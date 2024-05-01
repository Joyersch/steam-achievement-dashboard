<?php

namespace App\Console\Commands;

use App\Helpers\SteamApiHelper;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Console\Command;

class pull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pull {user=0} {appid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls data from the steam api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $forUser = $this->argument('user');
        $forApp = $this->argument('appid');

        $users = User::all();
        foreach ($users as $user) {
            if ($forUser && $user->steam_user_id != $forUser) {
                continue;
            }

            $steamGames = SteamApiHelper::GetUserGames($user);
            foreach ($steamGames as $steamGame) {
                if ($forApp && $forApp != $steamGame->appid) {
                    continue;
                }

                $game = Game::where('appid', $steamGame->appid)->first();
                $stats = SteamApiHelper::GetAchievements($user, $steamGame->appid);
                if ($stats) {
                    $total = $stats['total'];
                    $achieved = $stats['achieved'];
                    if (!$game) {
                        $game = Game::create([
                            'appid' => $steamGame->appid,
                            'name' => $stats['name']
                        ]);
                    } else {
                        $game->update(['name' => $stats['name']]);
                    }

                    $userGameStats = UserGameStat::latestEntry($user, $game);
                    if (!$userGameStats || $userGameStats->total != $total || $userGameStats->achieved != $achieved) {
                        UserGameStat::create([
                            'game_id' => $game->id,
                            'user_id' => $user->id,
                            'total' => $total,
                            'achieved' => $achieved,
                        ]);
                    } else {
                        // even though nothing has changed, this will update the timestamp
                        $userGameStats->touch();
                    }
                }
            }
        }
    }
}

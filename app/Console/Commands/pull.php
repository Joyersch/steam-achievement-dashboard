<?php

namespace App\Console\Commands;

use App\Enums\ActivityType;
use App\Helpers\SteamApiHelper;
use App\Models\AchievementStats;
use App\Models\Activity;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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

                    $dates = $stats['dates']->sortBy(fn($d) => $d)->values();

                    $pairs = $dates->map(function (Carbon|null $date, $index) use ($total) {
                        if (!$date) {
                            return null;
                        }

                        $percentage = ($index + 1) / $total * 100;
                        return [
                            'x' => $date->format('Y-m-d H:i:s'),
                            'y' => round($percentage, 6)
                        ];
                    })->filter(fn($p) => !is_null($p))->values();

                    $achievementStats = AchievementStats::firstOrCreate([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                    ]);

                    $achievementStats->update(['values' => json_decode($pairs)]);

                    $userGameStats = UserGameStat::latestEntry($user, $game);
                    if (!$userGameStats || $userGameStats->total != $total
                        || $userGameStats->achieved != $achieved) {
                        UserGameStat::create([
                            'game_id' => $game->id,
                            'user_id' => $user->id,
                            'total' => $total,
                            'achieved' => $achieved,
                        ]);

                        if ($userGameStats) {
                            $activityType = ActivityType::AchievementGained;

                            if ($userGameStats->total < $total) {
                                $activityType = ActivityType::GameAchievementAdded;
                            } else if ($userGameStats->achieved > $achieved) {
                                $activityType = ActivityType::AchievementLost;
                            }

                            if ($userGameStats->total > $total) {
                                $activityType = ActivityType::GameAchievementRemoved;
                            }

                            Activity::create([
                                'game_id' => $game->id,
                                'user_id' => $user->id,
                                'type' => $activityType,
                            ]);
                        }

                    } else {
                        // even though nothing has changed, this will update the timestamp
                        $userGameStats->touch();
                    }
                }
            }
        }
    }
}

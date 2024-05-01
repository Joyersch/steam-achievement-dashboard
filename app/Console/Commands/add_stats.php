<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Console\Command;

class add_stats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add_stats {username} {appid} {achieved} {total}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'At a stat to a game';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appid = $this->argument('appid');
        $achieved = $this->argument('achieved');
        $total = $this->argument('total');
        $name = $this->argument('username');

        $game = Game::where('appid', $appid)->first();
        $user = User::where('name', $name)->first();

        UserGameStat::create([
            'appid' => $appid,
            'achieved' => $achieved,
            'total' => $total,
            'user_id' => $user->id,
            'game_id' => $game->id,
        ]);
    }
}

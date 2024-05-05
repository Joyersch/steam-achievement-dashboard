<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\User;
use Illuminate\Console\Command;

class remove_stats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove_stats {user} {appid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::whereName($this->argument('user'));
        $game =Game::whereAppid( $this->argument('appid'));
        $stats = $user->stats($game);
        foreach ($stats as $stat) {
            $stat->delete();
        }
    }
}

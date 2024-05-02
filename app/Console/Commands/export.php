<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Game;
use App\Models\User;
use Illuminate\Console\Command;

class export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports data from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $games = Game::all();
        $users = User::with("gameStats")->get();
        $activities = Activity::all();
        $export = ['games' => $games, 'users' => $users, 'activity' => $activities];
        $path = storage_path() . "/export.json";
        if (file_put_contents($path, json_encode($export))) {
            $this->info('Create export at: ' . $path);
        } else {
            $this->error('Unable to export to: ' . $path);
        }
    }
}

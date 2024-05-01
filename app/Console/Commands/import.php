<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

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
        $file = storage_path('export.json');
        if (!$file || !file_exists($file)) {
            $this->error('No file found');
            return false;
        }
        $contents = json_decode(file_get_contents(storage_path('export.json')));

        foreach($contents->games as $game) {
            Game::firstOrCreate([
                'id' => $game->id,
                'appid' => $game->appid,
                'name'=> $game->name,
            ]);
        }

        foreach ($contents->users as $userData) {
            $user = User::firstOrCreate([
                'id' => $userData->id,
                'name' => $userData->name,
                'steam_user_id' => $userData->steam_user_id
            ]);

            foreach ($userData->game_stats as $gameStat) {
                UserGameStat::create([
                    'id' => $gameStat->id,
                    'created_at' => $gameStat->created_at,
                    'updated_at' => $gameStat->updated_at,
                    'game_id' => $gameStat->game_id,
                    'user_id' => $user->id,
                    'total' => $gameStat->total,
                    'achieved' => $gameStat->achieved,
                ]);
            }
        }
    }
}

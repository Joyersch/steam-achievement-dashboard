<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameStat;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
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
    protected $description = 'Old data will be deleted; Import data from file storage/export.json.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            UserGameStat::query()->truncate();
            Activity::query()->truncate();
            Game::query()->truncate();
            User::query()->truncate();
            $this->import();
            DB::commit();
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            DB::rollBack();
        }
    }

    private function import()
    {
        $file = storage_path('export.json');
        if (!$file || !file_exists($file)) {
            $this->error('No \'export.json\'file found in storage');
            return false;
        }
        $contents = json_decode(file_get_contents(storage_path('export.json')));

        foreach ($contents->games as $game) {
            Game::firstOrCreate([
                'id' => $game->id,
                'appid' => $game->appid,
                'name' => $game->name,
            ]);
        }

        foreach ($contents->users as $userData) {
            $user = User::firstOrCreate([
                'id' => $userData->id,
                'name' => $userData->name,
                'steam_user_id' => $userData->steam_user_id
            ]);

            $user->update([
                'color' => $userData->color
            ]);

            foreach ($userData->game_stats as $gameStat) {
                UserGameStat::create([
                    'id' => $gameStat->id,
                    'created_at' => $gameStat->created_at,
                    'updated_at' => $gameStat->updated_at,
                    'game_id' => $gameStat->game_id,
                    'user_id' => $gameStat->user_id,
                    'total' => $gameStat->total,
                    'achieved' => $gameStat->achieved,
                ]);
            }
        }

        foreach ($contents->activity as $activity) {
            Activity::create([
                'id' => $activity->id,
                'user_id' => $activity->user_id,
                'game_id' => $activity->game_id,
                'type' => $activity->type,
                'created_at' => $activity->created_at,
                'updated_at' => $activity->updated_at,
            ]);
        }
    }
}

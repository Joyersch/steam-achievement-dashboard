<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class add_game extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add_game {appid} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a game';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appid = $this->argument('appid');
        $name = $this->argument('name');
        Game::firstOrCreate([
            'appid' => $appid,
            'name' => $name
        ]);
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class game_count extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:game_count';

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
        $this->info(Game::all()->count());
    }
}

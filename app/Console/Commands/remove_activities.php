<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

class remove_activities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove_activities';

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
        Activity::query()->truncate();
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class remove_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove_user {user}';

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
        $user = User::where('name', $this->argument('user'))->first();

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        $user->delete();
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserGameStat;
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
    protected $description = 'Remove a user from the database';

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

        UserGameStat::where('user_id', $user->id)->delete();
        $user->delete();
    }
}

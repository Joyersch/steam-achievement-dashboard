<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

/**
 *
 */
class create_user extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_user {name} {steamUserId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new user to the database';

    /**
     * @param string $name
     * @param int $steamUserId
     * @return void
     */
    public function handle()
    {
        User::create([
            'name' => $this->argument('name'),
            'steam_user_id' => $this->argument('steamUserId')
        ]);
    }
}

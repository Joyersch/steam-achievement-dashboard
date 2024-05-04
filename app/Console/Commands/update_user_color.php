<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class update_user_color extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update_user_color {name} {color}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user color';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::whereName($this->argument('name'));

        $user->update([
            'color' => $this->argument('color'),
        ]);
    }
}

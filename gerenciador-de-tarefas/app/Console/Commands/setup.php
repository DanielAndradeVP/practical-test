<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class setup extends Command
{
    protected $signature = 'app:setup';

    protected $description = 'Command app setup';

    public function handle()
    {
        if (User::exists()) {
            $this->warn('User already exists');

            return;
        }
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'Dev123@',
        ]);

        $this->info('Setup user finished');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->line('Seeding user:');
        $this->command->newLine();

        if (User::where('email', config('user.email'))->first() !== null) {
            $this->command->warn('User with email "' . config('user.email') . '" already exists: skipping');
            $this->command->newLine();
            return;
        }

        $user = User::create([
            'name' => config('user.name'),
            'email' => config('user.email'),
            'password' => Hash::make(config('user.password')),
            'preferences' => [
                'locale' => 'es'
            ]
        ]);

        if (!isset($user)) {
            $this->command->error('Error creating user "' . config('user.name') . '" (' . config('user.email') . ')');
        } else {
            $this->command->info('User "' . config('user.name') . '" (' . config('user.email') . ') created');
        }
        $this->command->newLine();
    }
}

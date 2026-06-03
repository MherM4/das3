<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Moderator1',
                'email' => 'moderator@example.com',
                'password' => bcrypt('moderator@example.com'),
                'role' => 'moderator',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => bcrypt('user@example.com'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}

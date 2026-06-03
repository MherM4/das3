<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'adminvaspur@gmail.com',
                'password' => bcrypt('adminvaspur@gmail.com'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin@example.com'),
                'role' => 'admin',
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(['email' => $admin['email']], $admin);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'adminvaspur@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
        ]);
    }
}

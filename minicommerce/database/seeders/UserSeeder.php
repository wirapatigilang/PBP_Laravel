<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1, Jakarta',
        ]);

        // Regular user
        User::create([
            'name' => 'Gilang',
            'email' => 'wirapatigilang@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '08987654321',
            'address' => 'Jl. User No. 2, Bandung',
        ]);
    }
}

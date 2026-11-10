<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gametopup.test'],
            [
                'name' => 'Fawwaz Admin',
                'username' => 'admin',
                'phone' => '081234567890',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@gametopup.test'],
            [
                'name' => 'Budi Gamer',
                'username' => 'customer',
                'phone' => '089876543210',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@gametopup.test'],
            [
                'name' => 'Siti ProPlayer',
                'username' => 'siti',
                'phone' => '087711223344',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}

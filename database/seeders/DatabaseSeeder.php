<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin User (jika belum ada)
        User::firstOrCreate(
            ['email' => 'admin@sau.com'],
            [
                'name' => 'Admin SAU',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Buat Editor User (jika belum ada)
        User::firstOrCreate(
            ['email' => 'editor@sau.com'],
            [
                'name' => 'Editor SAU',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
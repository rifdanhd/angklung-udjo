<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShowSession; // Memanggil model yang baru

class ShowSessionSeeder extends Seeder
{
    public function run()
    {
        $sessions = [
            [
                'session_id' => 'pagi',
                'name' => 'Sesi Pagi',
                'time' => '10.00 - 11.30 WIB',
                'default_capacity' => 20,
                'available_days' => [0], // Minggu
                'is_active' => true,
            ],
            [
                'session_id' => 'siang',
                'name' => 'Sesi Siang',
                'time' => '13.00 - 14.30 WIB',
                'default_capacity' => 20,
                'available_days' => [6], // Sabtu
                'is_active' => true,
            ],
            [
                'session_id' => 'sore',
                'name' => 'Sesi Sore',
                'time' => '15.30 - 17.00 WIB',
                'default_capacity' => 20,
                'available_days' => [0, 6], // Minggu & Sabtu
                'is_active' => true,
            ],
            [
                'session_id' => 'reg',
                'name' => 'Regular Show',
                'time' => '15.30 - 17.00 WIB',
                'default_capacity' => 20,
                'available_days' => [1, 2, 3, 4, 5], // Senin-Jumat
                'is_active' => true,
            ],
        ];

        foreach ($sessions as $session) {
            ShowSession::updateOrCreate(
                ['session_id' => $session['session_id']], 
                $session
            );
        }

        $this->command->info('✅ Data Show Sessions berhasil dimasukkan ke tabel show_sessions!');
    }
}
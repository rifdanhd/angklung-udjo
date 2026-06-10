<?php
namespace Database\Seeders;

use App\Models\Show;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShowSeeder extends Seeder
{
    public function run()
    {
        $shows = [
            [
                'title' => 'Pertunjukan Angklung Sore',
                'description' => 'Pertunjukan angklung tradisional yang memukau dengan musik bambu khas Sunda. Nikmati harmoni alat musik bambu yang dimainkan oleh para seniman berbakat.',
                'date' => Carbon::today()->addDays(3),
                'time' => '15:30:00',
                'capacity' => 100,
                'available_seats' => 100,
                'price_domestic' => 50000,
                'price_foreign' => 100000,
                'is_active' => true,
            ],
            [
                'title' => 'Workshop Angklung Interaktif',
                'description' => 'Belajar bermain angklung langsung dari para ahli. Cocok untuk keluarga dan grup wisatawan yang ingin merasakan pengalaman bermain musik tradisional.',
                'date' => Carbon::today()->addDays(7),
                'time' => '14:00:00',
                'capacity' => 50,
                'available_seats' => 50,
                'price_domestic' => 75000,
                'price_foreign' => 150000,
                'is_active' => true,
            ],
            [
                'title' => 'Pertunjukan Wayang Golek & Angklung',
                'description' => 'Kolaborasi unik antara wayang golek tradisional dengan iringan musik angklung. Pengalaman budaya Sunda yang tak terlupakan!',
                'date' => Carbon::today()->addDays(10),
                'time' => '16:00:00',
                'capacity' => 80,
                'available_seats' => 80,
                'price_domestic' => 60000,
                'price_foreign' => 120000,
                'is_active' => true,
            ],
            [
                'title' => 'Pertunjukan Spesial Akhir Pekan',
                'description' => 'Pertunjukan istimewa dengan penampilan lengkap: angklung, tari tradisional Sunda, dan demo pembuatan angklung.',
                'date' => Carbon::today()->addDays(14),
                'time' => '15:00:00',
                'capacity' => 120,
                'available_seats' => 120,
                'price_domestic' => 70000,
                'price_foreign' => 140000,
                'is_active' => true,
            ],
        ];

        foreach ($shows as $show) {
            Show::create($show);
        }
    }
}

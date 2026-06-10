<?php
namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'country' => 'Australia',
                'message' => 'Amazing experience! The angklung performance was beautiful and the staff were so welcoming. A must-visit in Bandung!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'country' => 'Indonesia',
                'message' => 'Pengalaman yang luar biasa! Anak-anak saya sangat senang bisa belajar bermain angklung. Tempatnya nyaman dan edukatif.',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'country' => 'Spain',
                'message' => '¡Increíble! The bamboo music was so peaceful and harmonious. I bought several angklung as souvenirs.',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Kenji Tanaka',
                'country' => 'Japan',
                'message' => '素晴らしい体験でした！Traditional Sundanese culture is preserved so well here. Highly recommended!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'country' => 'Indonesia',
                'message' => 'Tempat yang sempurna untuk mengenalkan budaya Sunda kepada generasi muda. Pertunjukannya interaktif dan menghibur!',
                'rating' => 5,
                'is_approved' => true,
            ],
            [
                'name' => 'Emma Wilson',
                'country' => 'United Kingdom',
                'message' => 'Wonderful cultural experience! The interactive part where we played angklung together was the highlight of my Bandung trip.',
                'rating' => 5,
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
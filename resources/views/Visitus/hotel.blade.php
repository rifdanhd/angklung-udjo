{{-- resources/views/experience/hotels.blade.php --}}
@extends('layouts.app')

@section('title', 'Rekomendasi Hotel di Bandung - Saung Angklung Udjo')

@section('content')

    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
            }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            
            .reveal { opacity: 0; transform: translateY(40px); transition: all 1.2s cubic-bezier(0.22, 1, 0.36, 1); }
            .reveal.active { opacity: 1; transform: translateY(0); }

            /* Hotel Hero */
            .hotel-hero {
                width: 100%;
                height: 70vh;
                position: relative;
                overflow: hidden;
                background: var(--indigo-deep);
            }
            .hotel-hero img {
                width: 100%; height: 100%; object-fit: cover; opacity: 0.6;
            }

            /* Hotel Row Styling */
            .hotel-card {
                padding: 5rem 0;
                border-bottom: 1px solid rgba(26, 20, 69, 0.05);
            }
            .hotel-card:last-child { border-bottom: none; }

            .hotel-image-wrapper {
                width: 100%;
                aspect-ratio: 16/9;
                overflow: hidden;
                box-shadow: 0 30px 60px -12px rgba(0,0,0,0.2);
            }
            .hotel-image-wrapper img {
                width: 100%; height: 100%; object-fit: cover;
                transition: transform 2s ease;
            }
            .hotel-card:hover .hotel-image-wrapper img { transform: scale(1.05); }

            .amenity-tag {
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--gold-premium);
                border: 1px solid var(--gold-premium);
                padding: 4px 10px;
                margin-right: 8px;
                margin-bottom: 8px;
                display: inline-block;
            }
        </style>
    @endpush

    <!-- 1. HERO SECTION -->
    <section class="relative hotel-hero flex items-center justify-center">
        <img src="{{ asset('img/bandung-cityscape.jpg') }}" class="absolute inset-0" alt="Bandung City View">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#1a1445]"></div>
        <div class="relative z-10 text-center px-6">
            <p class="reveal text-xs font-bold tracking-[0.6em] text-gold-premium uppercase mb-4">Stay in Comfort</p>
            <h1 class="reveal font-editorial text-5xl md:text-8xl text-white italic">Hotels in Bandung</h1>
        </div>
    </section>

    <!-- 2. INTRO NARRATIVE -->
    <section class="bg-white py-24 text-center">
        <div class="max-w-3xl mx-auto px-8">
            <div class="reveal">
                <h2 class="font-editorial text-3xl md:text-4xl text-indigo-950 mb-8 italic">Istirahat Sejenak di <br><span class="text-gold-premium not-italic">Jantung Kota Kembang</span></h2>
                <p class="text-gray-500 font-light leading-loose text-lg">
                    Setelah menikmati simfoni bambu di Saung Angklung Udjo, lengkapi perjalanan Anda dengan menginap di akomodasi terbaik. Bandung menawarkan berbagai pilihan mulai dari hotel mewah di atas bukit hingga penginapan butik yang artistik. Berikut adalah kurasi hotel pilihan kami untuk Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- 3. HOTEL LISTING (SATU PER SATU) -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-8">
            
            @php
            $hotels = [
                [
                    'name' => 'The Gaia Hotel Bandung',
                    'type' => 'Luxury Lifestyle',
                    'dist' => '± 20 Menit dari Udjo',
                    'img' => 'hotel-gaia.jpg',
                    'desc' => 'Menghadirkan konsep "Active/Rest", The Gaia Hotel bukan sekadar tempat menginap, melainkan destinasi relaksasi dengan arsitektur yang megah. Terkenal dengan perpustakaan raksasanya yang ikonis dan kolam renang air hangat yang menghadap langsung ke lembah hijau Bandung.',
                    'tags' => ['Heated Pool', 'Gym', 'Restaurant', 'Art Gallery']
                ],
                [
                    'name' => 'InterContinental Bandung Dago Pakar',
                    'type' => '5-Star Excellence',
                    'dist' => '± 15 Menit dari Udjo',
                    'img' => 'hotel-intercon.jpg',
                    'desc' => 'Terletak di kawasan elit Dago Pakar, hotel ini menawarkan pemandangan spektakuler lapangan golf dan kerlap-kerlip lampu kota Bandung di malam hari. Pilihan tepat bagi pengunjung yang menginginkan kemewahan modern dengan suasana pegunungan yang tenang.',
                    'tags' => ['Golf View', 'Luxury Spa', 'Fine Dining', 'Family Friendly']
                ],
                [
                    'name' => 'Padma Hotel Bandung',
                    'type' => 'Nature & Wellness',
                    'dist' => '± 25 Menit dari Udjo',
                    'img' => 'hotel-padma.jpg',
                    'desc' => 'Tersembunyi di lereng bukit Ciumbuleuit, Padma Hotel menawarkan pengalaman menyatu dengan alam. Dengan desain interior yang hangat dan pelayanan yang personal, hotel ini sangat cocok bagi mereka yang mencari kedamaian dan udara segar khas Bandung.',
                    'tags' => ['Forest View', 'Jacuzzi', 'Kids Adventure', 'Afternoon Tea']
                ],
                [
                    'name' => 'The Trans Luxury Hotel',
                    'type' => 'Premium City Center',
                    'dist' => '± 20 Menit dari Udjo',
                    'img' => 'hotel-trans.jpg',
                    'desc' => 'Merupakan simbol kemewahan di pusat kota Bandung. Terintegrasi langsung dengan kawasan Trans Studio Mall, hotel ini memberikan akses mudah ke hiburan kelas dunia dan belanja, tanpa meninggalkan standar kenyamanan bintang lima yang luar biasa.',
                    'tags' => ['Theme Park Access', 'Beach Pool', 'Sky Dining', 'Strategic']
                ]
            ];
            @endphp

            @foreach($hotels as $index => $hotel)
            <div class="hotel-card reveal">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- Image Side (Bergantian Kiri-Kanan) -->
                    <div class="{{ $index % 2 == 0 ? 'lg:order-1' : 'lg:order-2' }}">
                        <div class="hotel-image-wrapper">
                            <img src="{{ asset('img/'.$hotel['img']) }}" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200'" alt="{{ $hotel['name'] }}">
                        </div>
                    </div>

                    <!-- Info Side -->
                    <div class="{{ $index % 2 == 0 ? 'lg:order-2' : 'lg:order-1' }}">
                        <p class="text-[10px] font-bold tracking-[0.4em] text-gold-premium uppercase mb-4">{{ $hotel['type'] }}</p>
                        <h3 class="font-editorial text-4xl text-indigo-950 mb-4">{{ $hotel['name'] }}</h3>
                        <p class="flex items-center text-xs text-gray-400 mb-8 tracking-widest uppercase">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $hotel['dist'] }}
                        </p>
                        
                        <p class="text-gray-500 font-light leading-relaxed text-lg mb-8">
                            {{ $hotel['desc'] }}
                        </p>

                        <div class="mb-10">
                            @foreach($hotel['tags'] as $tag)
                                <span class="amenity-tag">{{ $tag }}</span>
                            @endforeach
                        </div>

                        <a href="#" class="inline-block border-b-2 border-indigo-950 text-indigo-950 font-bold text-xs uppercase tracking-widest pb-2 hover:text-gold-premium hover:border-gold-premium transition-all">
                            Lihat Detail & Harga
                        </a>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </section>

    <!-- 4. PARTNER BADGES (Optional) -->
    <section class="py-20 bg-[#fafaf9] border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-8 text-center">
            <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 uppercase mb-12">Supported Travel Partners</p>
            <div class="flex flex-wrap justify-center gap-12 md:gap-24 opacity-30 grayscale">
                <img src="{{ asset('img/traveloka-logo.png') }}" class="h-8 md:h-10" alt="Traveloka">
                <img src="{{ asset('img/bookingcom-logo.png') }}" class="h-8 md:h-10" alt="Booking.com">
                <img src="{{ asset('img/tiketcom-logo.png') }}" class="h-8 md:h-10" alt="Tiket.com">
                <img src="{{ asset('img/agoda-logo.png') }}" class="h-8 md:h-10" alt="Agoda">
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
    @endpush

@endsection
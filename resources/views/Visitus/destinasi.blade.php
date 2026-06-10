@extends('layouts.app')

@section('title', 'Destinasi Sekitar - Jelajahi Harmoni Bandung Timur')

@section('content')

    {{-- STYLES - Konsisten dengan Home --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
                --qatar-maroon: #7d002a;
            }

            body { font-family: 'Inter', sans-serif; color: var(--indigo-deep); }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            .font-spirax { font-family: 'Spirax', cursive; }

            /* Reveal System */
            .reveal {
                opacity: 0;
                transform: translateY(40px);
                transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal.active {
                opacity: 1;
                transform: translateY(0);
            }

            /* Premium Card Style (Visit Qatar Inspired) */
            .desti-card {
                position: relative;
                aspect-ratio: 4/5;
                overflow: hidden;
                border-radius: 20px;
                background: var(--indigo-deep);
            }
            .desti-card img {
                width: 100%; height: 100%;
                object-fit: cover;
                transition: transform 2s ease, opacity 0.5s;
                opacity: 0.8;
            }
            .desti-card:hover img { transform: scale(1.1); opacity: 1; }
            
            .desti-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(26, 20, 69, 0.95) 0%, rgba(26, 20, 69, 0.2) 50%, transparent 100%);
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                color: white;
            }

            .text-spacing-sm { text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.65rem; font-weight: 700; }
            .badge-gold { color: var(--gold-premium); border-left: 2px solid var(--gold-premium); padding-left: 10px; }
        </style>
    @endpush

    <!-- 1. CINEMATIC HERO -->
    <section class="relative h-[85vh] flex items-center overflow-hidden bg-black">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1505245208761-baad7241277d?q=80&w=2000" class="w-full h-full object-cover opacity-60 scale-105">
            <div class="absolute inset-0 bg-gradient-to-r from-[#1a1445] to-transparent opacity-80"></div>
        </div>
        
        <div class="relative z-10 max-w-[1400px] mx-auto px-10 md:px-20 text-white">
            <p class="reveal text-spacing-sm text-gold-premium mb-6">Discovery & Travel Guide</p>
            <h1 class="reveal font-spirax text-5xl md:text-8xl leading-[1.1] mb-8">
                Lanjutkan <br>
                <span class="italic font-editorial font-light text-gold-premium">Perjalanan Anda</span>
            </h1>
            <p class="reveal max-w-xl text-white/70 font-light leading-relaxed text-lg">
                Dari gema bambu Padasuka menuju puncak-puncak perbukitan dan taman kota modern. Jelajahi sisi terbaik Bandung Timur.
            </p>
        </div>
    </section>

    <!-- 2. EDITORIAL INTRO -->
    <section class="py-32 bg-white">
        <div class="max-w-4xl mx-auto px-10 text-center">
            <div class="reveal mb-10 flex justify-center">
                <div class="w-16 h-px bg-gold-premium/40"></div>
            </div>
            <h2 class="reveal font-editorial text-3xl md:text-5xl text-indigo-950 leading-tight mb-10">
                "Budaya adalah awal, <span class="italic text-gold-premium">alam dan kreativitas</span> adalah pelengkapnya."
            </h2>
            <p class="reveal text-gray-400 font-light leading-loose text-lg italic">
                Saung Angklung Udjo terletak di gerbang emas wisata Bandung Timur. Hanya beberapa menit berkendara, Anda akan menemukan transisi dari kemeriahan tradisi ke ketenangan alam pegunungan.
            </p>
        </div>
    </section>

    <!-- 3. FEATURED DESTINATIONS (LATEST & TRENDING) -->
    <section class="py-24 bg-v-gray">
        <div class="max-w-[1400px] mx-auto px-10">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 reveal">
                <div>
                    <p class="text-spacing-sm text-gray-400 mb-4">Trending Now</p>
                    <h2 class="font-editorial text-4xl text-indigo-950 italic">Destinasi Terpilih</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                
                @php
                    $destinations = [
                        [
                            'cat' => 'Modern Landmark',
                            'title' => 'Kiara Artha Park',
                            'desc' => 'Taman kota modern terbaru dengan Dancing Fountain yang spektakuler dan area Kampung Korea.',
                            'dist' => '15 Menit • Jl. Banten',
                            'img' => 'https://images.unsplash.com/photo-1596422846543-75c6fc18a594?q=80&w=800'
                        ],
                        [
                            'cat' => 'High Art Space',
                            'title' => 'Selasar Sunaryo',
                            'desc' => 'Pusat seni kontemporer kelas dunia. Nikmati kopi di balkon sambil melihat instalasi seni yang ikonik.',
                            'dist' => '20 Menit • Ciburial (Via Cigadung)',
                            'img' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?q=80&w=800'
                        ],
                        [
                            'cat' => 'Nature & Sky',
                            'title' => 'Puncak Bintang Moko',
                            'desc' => 'Transformasi terbaru dari Bukit Moko. Berjalan di atas dek kayu di sela hutan pinus dan kabut.',
                            'dist' => '30 Menit • Puncak Padasuka',
                            'img' => 'https://images.unsplash.com/photo-1625904870006-ac3ad10be29a?q=80&w=800'
                        ],
                        [
                            'cat' => 'Heritage Dining',
                            'title' => 'Imah Djoglo',
                            'desc' => 'Restoran keluarga bernuansa kayu klasik dengan kebun binatang mini dan suasana pedesaan.',
                            'dist' => '10 Menit • Sumber Sari',
                            'img' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=800'
                        ],
                        [
                            'cat' => 'Creative Hub',
                            'title' => 'Kampung Cigadung',
                            'desc' => 'Kawasan pengrajin batik Hasan dan studio seni lokal yang kini jadi pusat wisata kreatif Bandung.',
                            'dist' => '12 Menit • Cigadung',
                            'img' => 'https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=800'
                        ],
                        [
                            'cat' => 'Sunset Point',
                            'title' => 'Caringin Tilu',
                            'desc' => 'Wajah baru kawasan kuliner bukit dengan pemandangan lampu kota Bandung yang tak tertandingi.',
                            'dist' => '18 Menit • Atas Padasuka',
                            'img' => 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?q=80&w=800'
                        ]
                    ];
                @endphp

                @foreach($destinations as $index => $d)
                <div class="reveal group" style="transition-delay: {{ $index * 100 }}ms;">
                    <div class="desti-card mb-8 shadow-2xl">
                        <img src="{{ $d['img'] }}" alt="{{ $d['title'] }}">
                        <div class="desti-overlay">
                            <span class="text-spacing-sm text-gold-premium mb-3 block">{{ $d['cat'] }}</span>
                            <h3 class="font-editorial text-3xl leading-tight mb-4">{{ $d['title'] }}</h3>
                            <div class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-white/50 border-t border-white/10 pt-4">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $d['dist'] }}
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-500 font-light leading-relaxed px-2">{{ $d['desc'] }}</p>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- 4. TRAVEL ESSENTIALS (Style Home) -->
    <section class="py-32 bg-white">
        <div class="max-w-[1200px] mx-auto px-10">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <div class="reveal">
                    <h2 class="font-editorial text-4xl text-indigo-950 mb-10 leading-tight">Panduan <br><span class="text-gold-premium italic">Transportasi & Akses</span></h2>
                    <div class="space-y-8">
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-full bg-v-gray flex items-center justify-center flex-shrink-0 text-indigo-950">
                                <span class="font-bold text-sm">01</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm tracking-widest uppercase mb-2">Transportasi Online</h4>
                                <p class="text-gray-500 text-sm font-light">Sangat mudah menjangkau Saung Udjo dan Kiara Artha Park menggunakan Grab/Gojek.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-full bg-v-gray flex items-center justify-center flex-shrink-0 text-indigo-950">
                                <span class="font-bold text-sm">02</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm tracking-widest uppercase mb-2">Kendaran Pribadi</h4>
                                <p class="text-gray-500 text-sm font-light">Pastikan kondisi rem prima jika ingin melanjutkan ke Bukit Moko karena tanjakan yang cukup curam.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reveal bg-indigo-950 p-12 rounded-[40px] text-white">
                    <h3 class="font-editorial text-2xl mb-6 italic text-gold-premium">Tips Lokal</h3>
                    <p class="font-light leading-relaxed opacity-80 mb-8">
                        "Waktu terbaik untuk berkunjung ke Saung Udjo adalah sesi sore (15:30), sehingga setelah selesai Anda bisa langsung menuju Caringin Tilu untuk makan malam dengan pemandangan lampu kota."
                    </p>
                    <div class="w-20 h-px bg-gold-premium"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FINAL CTA (Style Home) -->
    <section class="relative py-32 bg-indigo-950 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-10 text-center">
            <h2 class="reveal font-editorial text-4xl md:text-6xl text-white mb-12 leading-tight">
                Siap memulai <br>
                <span class="text-gold-premium italic">petualangan Anda?</span>
            </h2>
            <div class="reveal flex flex-col md:flex-row justify-center gap-6">
                <a href="{{ route('shows.index') }}" class="btn-premium-modern !bg-white !text-indigo-950">
                    Pesan Tiket Sekarang
                </a>
                <a href="https://maps.google.com" target="_blank" class="btn-premium-modern !bg-transparent !border-white !text-white">
                    Petunjuk Arah
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) entry.target.classList.add('active');
                    });
                }, { threshold: 0.1 });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });
        </script>
    @endpush

@endsection
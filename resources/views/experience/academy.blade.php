{{-- resources/views/experience/venue.blade.php --}}
@extends('layouts.app')

@section('title', 'Venue & Denah Lokasi - Saung Angklung Udjo')

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

            /* Venue Immersive Image */
            .venue-hero-wrapper {
                width: 100%;
                height: 80vh;
                position: relative;
                overflow: hidden;
            }
            .venue-hero-wrapper img {
                width: 100%; height: 100%; object-fit: cover;
            }

            /* Facility Card */
            .facility-card {
                background: white;
                border-bottom: 4px solid transparent;
                transition: all 0.5s ease;
            }
            .facility-card:hover {
                border-bottom: 4px solid var(--gold-premium);
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            }
            
            /* Map Section */
            .map-container {
                background: #f4f1ea;
                border: 1px solid #e5e1d8;
                position: relative;
                overflow: hidden;
            }
        </style>
    @endpush

    <!-- 1. HERO SECTION: BALE UDJO -->
    <section class="relative venue-hero-wrapper">
        <img src="{{ asset('img/venue-main.jpg') }}" class="w-full h-full object-cover" alt="Bale Udjo Amphitheater">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1a1445] via-transparent to-transparent"></div>
        <div class="absolute bottom-20 left-0 w-full text-center px-6">
            <p class="reveal text-xs font-bold tracking-[0.6em] text-gold-premium uppercase mb-4">Our Sacred Stage</p>
            <h1 class="reveal font-editorial text-5xl md:text-8xl text-white italic">Bale Udjo</h1>
        </div>
    </section>

    <!-- 2. PENJELASAN VENUE UTAMA -->
    <section class="bg-white py-24 md:py-32">
        <div class="max-w-5xl mx-auto px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <p class="text-indigo-900/40 text-[10px] font-bold tracking-[0.4em] uppercase mb-6">Arsitektur & Akustik</p>
                    <h2 class="font-editorial text-4xl text-indigo-950 mb-8 leading-tight">Amfiteater Bambu yang <span class="text-gold-premium italic">Bernapas</span></h2>
                    <div class="space-y-6 text-gray-500 font-light leading-relaxed text-lg">
                        <p>
                            <strong>Bale Udjo</strong> adalah mahakarya arsitektur bambu semi-terbuka yang dirancang khusus untuk menciptakan harmoni antara suara dan alam. Dengan kapasitas hingga 500 penonton, amfiteater ini menawarkan akustik alami yang memantulkan getaran angklung secara sempurna.
                        </p>
                        <p>
                            Atap tinggi yang terbuat dari rumbia dan struktur pilar bambu yang kokoh memastikan sirkulasi udara pegunungan Bandung tetap terjaga, memberikan kenyamanan maksimal bagi pengunjung sambil menikmati pertunjukan di bawah langit sore.
                        </p>
                    </div>
                </div>
                <div class="reveal">
                    <img src="{{ asset('img/venue-interior.jpg') }}" class="w-full shadow-2xl rounded-sm" alt="Interior Bale Udjo">
                </div>
            </div>
        </div>
    </section>

    <!-- 3. DENAH LOKASI (MAP) -->
    <section class="py-24 bg-[#fafaf9]">
        <div class="max-w-7xl mx-auto px-8">
            <div class="reveal text-center mb-16">
                <p class="text-indigo-900/40 text-[10px] font-bold tracking-[0.4em] uppercase mb-4">Panduan Area</p>
                <h2 class="font-editorial text-4xl text-indigo-950">Denah Lokasi</h2>
            </div>

            <!-- Placeholder Denah / Map -->
            <div class="reveal map-container rounded-sm p-4 md:p-12 shadow-inner">
                {{-- Gunakan Image Denah Asli Disini --}}
                <img src="{{ asset('img/map-udjo-placeholder.png') }}" class="w-full h-auto mx-auto shadow-2xl" alt="Site Map Saung Angklung Udjo">
                
                <!-- Keterangan Denah -->
                <div class="grid md:grid-cols-3 gap-8 mt-16 text-indigo-950">
                    <div class="flex gap-4">
                        <span class="font-editorial text-2xl text-gold-premium">A</span>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-widest mb-2">Pusat Informasi</h4>
                            <p class="text-xs text-gray-500 font-light">Lokasi tiket dan penyambutan utama tamu.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-editorial text-2xl text-gold-premium">B</span>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-widest mb-2">Bale Udjo</h4>
                            <p class="text-xs text-gray-500 font-light">Panggung utama pertunjukan seni angklung.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="font-editorial text-2xl text-gold-premium">C</span>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-widest mb-2">Buruan</h4>
                            <p class="text-xs text-gray-500 font-light">Area terbuka untuk workshop dan interaksi budaya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. FASILITAS PENDUKUNG -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-8">
            <div class="reveal mb-16">
                <h2 class="font-editorial text-4xl text-indigo-950 italic">Fasilitas <span class="text-gold-premium not-italic">& Kenyamanan</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Fasilitas 1 -->
                <div class="reveal facility-card p-8 border border-gray-100">
                    <div class="w-12 h-12 mb-6 text-gold-premium">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="font-editorial text-xl text-indigo-950 mb-4">Toko Souvenir</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">Pusat kerajinan tangan khas Sunda dan berbagai jenis instrumen angklung berkualitas tinggi.</p>
                </div>

                <!-- Fasilitas 2 -->
                <div class="reveal facility-card p-8 border border-gray-100" style="transition-delay: 100ms;">
                    <div class="w-12 h-12 mb-6 text-gold-premium">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-editorial text-xl text-indigo-950 mb-4">Perpustakaan</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">Ruang literasi yang menyimpan sejarah angklung dan dokumentasi Abah Udjo Ngalagena.</p>
                </div>

                <!-- Fasilitas 3 -->
                <div class="reveal facility-card p-8 border border-gray-100" style="transition-delay: 200ms;">
                    <div class="w-12 h-12 mb-6 text-gold-premium">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="font-editorial text-xl text-indigo-950 mb-4">Parkir Luas</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">Area parkir yang memadai untuk kendaraan pribadi maupun bus pariwisata besar.</p>
                </div>

                <!-- Fasilitas 4 -->
                <div class="reveal facility-card p-8 border border-gray-100" style="transition-delay: 300ms;">
                    <div class="w-12 h-12 mb-6 text-gold-premium">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="font-editorial text-xl text-indigo-950 mb-4">Mushola & Toilet</h3>
                    <p class="text-gray-500 text-sm font-light leading-relaxed">Fasilitas umum yang bersih dan nyaman demi kemudahan ibadah dan sanitasi pengunjung.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. GOOGLE MAPS INTEGRATION -->
    <section class="h-[500px] w-full bg-gray-200">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.985834479573!2d107.65215757573934!3d-6.892288367443585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e79606d0b647%3A0xc0021b777a4a984a!2sSaung%20Angklung%20Udjo!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
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
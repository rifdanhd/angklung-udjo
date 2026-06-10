{{-- resources/views/shows/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Jadwal & Tiket - Saung Angklung Udjo')

@section('content')

    {{-- 1. STYLES: EDITORIAL SHOWCASE STYLE --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
                --qatar-maroon: #7d002a;
            }

            body { font-family: 'Inter', sans-serif; color: var(--indigo-deep); background-color: #fff; }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            .font-spirax { font-family: 'Spirax', cursive; }
            
            .text-spacing-sm { text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.65rem; font-weight: 700; }
            .text-spacing-lg { text-transform: uppercase; letter-spacing: 0.5em; font-size: 0.75rem; font-weight: 800; }

            /* Hero Cinematic */
            .hero-shows { height: 60vh; position: relative; overflow: hidden; background: #000; display: flex; align-items: center; justify-content: center; }
            .hero-bg { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.5; }
            .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 20%, var(--indigo-deep) 100%); }

            /* Reveal System */
            .reveal { opacity: 0; transform: translateY(30px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); visibility: hidden; }
            .reveal.active { opacity: 1 !important; transform: translateY(0) !important; visibility: visible !important; }

            /* Card Doorway Style */
            .card-door {
                clip-path: url(#door-mask);
                -webkit-clip-path: url(#door-mask);
                aspect-ratio: 3/4;
                overflow: hidden;
            }

            /* Info Bar Item */
            .info-item { border-left: 1px solid rgba(26, 20, 69, 0.1); padding: 0 2rem; }

            section { margin: 0 !important; }
        </style>
    @endpush

    <!-- SVG MASK FOR DOORWAY SHAPE -->
    <svg width="0" height="0" class="absolute">
        <defs>
            <clipPath id="door-mask" clipPathUnits="objectBoundingBox">
                <path d="M0.848,0.138 L0.5,0 L0.152,0.138 C0.057,0.176,0,0.242,0,0.313 V1 H1 V0.313 C1,0.242,0.943,0.176,0.848,0.138 Z"></path>
            </clipPath>
        </defs>
    </svg>

    <!-- 1. HERO SECTION -->
    <section class="hero-shows">
        <img src="{{ asset('img/performance.jpg') }}" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="container mx-auto px-10 relative z-10 text-white text-center">
            <div class="max-w-4xl mx-auto">
                <p class="reveal text-spacing-lg text-gold-premium mb-6">Discovery & Harmony</p>
                <h1 class="reveal font-editorial text-5xl md:text-8xl leading-tight italic" style="transition-delay: 200ms;">
                    Jadwal Pertunjukan
                </h1>
            </div>
        </div>
    </section>

    <!-- 2. SHOW ESSENTIALS (Info Bar ala Qatar) -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                <div class="info-item reveal">
                    <span class="text-spacing-sm text-gray-400">Durasi</span>
                    <p class="font-editorial text-xl text-indigo-950 mt-2">60 - 90 Menit</p>
                </div>
                <div class="info-item reveal" style="transition-delay: 100ms;">
                    <span class="text-spacing-sm text-gray-400">Frekuensi</span>
                    <p class="font-editorial text-xl text-indigo-950 mt-2">Setiap Hari</p>
                </div>
                <div class="info-item reveal" style="transition-delay: 200ms;">
                    <span class="text-spacing-sm text-gray-400">Kapasitas</span>
                    <p class="font-editorial text-xl text-indigo-950 mt-2">500 Kursi</p>
                </div>
                <div class="info-item reveal" style="transition-delay: 300ms;">
                    <span class="text-spacing-sm text-gray-400">Bahasa</span>
                    <p class="font-editorial text-xl text-indigo-950 mt-2">ID / EN</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. MAIN SCHEDULE (EDITORIAL LAYOUT) -->
    <section class="py-32 bg-white">
        <div class="max-w-[1300px] mx-auto px-10 space-y-40">
            
            {{-- Weekdays --}}
            <div class="grid lg:grid-cols-12 gap-20 items-center">
                <div class="lg:col-span-5 reveal">
                    <div class="card-door group">
                        <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110">
                    </div>
                </div>
                <div class="lg:col-span-7 reveal" style="transition-delay: 300ms;">
                    <p class="text-spacing-lg text-gray-400 mb-6">Senin – Jumat</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-8">Pertunjukan <span class="text-gold-premium italic">Harian</span></h2>
                    <p class="text-gray-500 text-lg leading-loose font-light mb-10">
                        Rasakan gema harmoni bambu di sore hari. Pertunjukan rutin harian kami menyajikan inti dari budaya Sunda, mulai dari Tari Wayang hingga orkestra angklung interaktif.
                    </p>
                    <div class="p-8 bg-v-gray border-l-4 border-gold-premium">
                        <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Waktu Mulai</span>
                        <p class="font-editorial text-3xl text-indigo-950 mt-2">15:30 – 17:00 WIB</p>
                    </div>
                </div>
            </div>

            {{-- Weekends --}}
            <div class="grid lg:grid-cols-12 gap-20 items-center">
                <div class="lg:col-span-7 reveal order-2 lg:order-1">
                    <p class="text-spacing-lg text-gray-400 mb-6">Sabtu – Minggu</p>
                    <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight mb-8">Momen <span class="text-gold-premium italic">Akhir Pekan</span></h2>
                    <p class="text-gray-500 text-lg leading-loose font-light mb-10">
                        Sempurnakan akhir pekan keluarga Anda dengan dua pilihan sesi pertunjukan. Kami menghadirkan kemeriahan lebih melalui atraksi Helaran yang penuh warna.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-8 bg-v-gray border-l-4 border-indigo-900">
                            <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Sesi Pagi</span>
                            <p class="font-editorial text-2xl text-indigo-950 mt-2">10:00 WIB</p>
                            <p class="text-[9px] mt-1 italic text-gray-400">Khusus Hari Minggu</p>
                        </div>
                        <div class="p-8 bg-v-gray border-l-4 border-gold-premium">
                            <span class="text-[10px] font-bold tracking-widest text-gray-400 uppercase">Sesi Sore</span>
                            <p class="font-editorial text-2xl text-indigo-950 mt-2">15:30 WIB</p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-5 reveal order-1 lg:order-2" style="transition-delay: 300ms;">
                    <div class="card-door group">
                        <img src="{{ asset('img/orkes.jpg') }}" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. TICKETS & PRICING (CLEAN QATAR TABLE STYLE) -->
    <section class="py-32 bg-v-gray">
        <div class="max-w-[1100px] mx-auto px-10">
            <div class="text-center mb-20 reveal">
                <p class="text-spacing-lg text-gray-400 mb-6">Akses & Reservasi</p>
                <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-tight">Harga Tiket Masuk</h2>
                <div class="w-20 h-px bg-gold-premium mx-auto mt-10"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-10">
                <!-- Domestik -->
                <div class="reveal p-12 bg-white shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h4 class="text-spacing-sm text-amber-600 mb-10">Tiket Domestik</h4>
                        <div class="space-y-8">
                            <div class="flex justify-between items-end border-b border-gray-50 pb-4">
                                <span class="font-editorial text-2xl text-indigo-950">Dewasa</span>
                                <span class="font-editorial text-3xl text-indigo-950">Rp 85k</span>
                            </div>
                            <div class="flex justify-between items-end border-b border-gray-50 pb-4">
                                <div>
                                    <span class="font-editorial text-2xl text-indigo-950">Anak-anak</span>
                                    <p class="text-[10px] text-gray-400 italic">Usia 3 - 12 Tahun</p>
                                </div>
                                <span class="font-editorial text-3xl text-indigo-950">Rp 60k</span>
                            </div>
                        </div>
                    </div>
                    <a href="https://www.traveloka.com/..." target="_blank" class="mt-16 block w-full text-center py-5 bg-indigo-950 text-white text-[10px] font-bold uppercase tracking-widest hover:bg-gold-premium transition-all">Pesan via Traveloka</a>
                </div>

                <!-- Internasional -->
                <div class="reveal p-12 bg-white shadow-sm border border-gray-100 flex flex-col justify-between" style="transition-delay: 200ms;">
                    <div>
                        <h4 class="text-spacing-sm text-amber-600 mb-10">International Ticket</h4>
                        <div class="space-y-8">
                            <div class="flex justify-between items-end border-b border-gray-50 pb-4">
                                <span class="font-editorial text-2xl text-indigo-950">Adult</span>
                                <span class="font-editorial text-3xl text-indigo-950">IDR 120k</span>
                            </div>
                            <div class="flex justify-between items-end border-b border-gray-50 pb-4">
                                <div>
                                    <span class="font-editorial text-2xl text-indigo-950">Children</span>
                                    <p class="text-[10px] text-gray-400 italic">Age 3 - 12 Years</p>
                                </div>
                                <span class="font-editorial text-3xl text-indigo-950">IDR 85k</span>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:info@angklung-udjo.co.id" class="mt-16 block w-full text-center py-5 border border-indigo-950 text-indigo-950 text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-950 hover:text-white transition-all">Inquiry via Email</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. RESERVASI ROMBONGAN (NEW FEATURE) -->
    <section class="py-32 bg-white overflow-hidden">
        <div class="max-w-[1300px] mx-auto px-10 grid lg:grid-cols-2 gap-20 items-center">
            <div class="reveal">
                <p class="text-spacing-lg text-gray-400 mb-8 uppercase font-bold">Kunjungan Grup</p>
                <h2 class="font-editorial text-5xl md:text-7xl text-indigo-950 leading-tight mb-10 italic">Reservasi <br> Rombongan</h2>
                <p class="text-gray-500 text-lg leading-loose mb-12 font-light">
                    Kami melayani kunjungan grup skala besar untuk instansi, sekolah, dan agen perjalanan dengan jadwal yang fleksibel serta paket makan siang tradisional yang autentik.
                </p>
                <a href="https://wa.me/6282182821200" class="inline-flex items-center gap-6 group text-indigo-950 font-bold text-spacing-sm transition-all hover:text-gold-premium uppercase">
                    Hubungi Admin WhatsApp
                    <div class="w-12 h-px bg-indigo-950/20 group-hover:w-20 group-hover:bg-gold-premium transition-all duration-500"></div>
                </a>
            </div>
            <div class="reveal" style="transition-delay: 200ms;">
                <img src="{{ asset('img/helaran.jpg') }}" class="w-full shadow-2xl rounded-3xl">
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
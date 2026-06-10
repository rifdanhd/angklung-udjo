{{-- resources/views/souvenir.blade.php --}}
@extends('layouts.app')

@section('title', 'Koleksi Kerajinan & Cinderamata - Saung Angklung Udjo')

@section('content')
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
                --qatar-maroon: #7d002a;
            }

            .font-editorial { font-family: 'Libre Baskerville', serif; }
            .font-spirax    { font-family: 'Spirax', cursive; }

            .text-spacing-lg {
                text-transform: uppercase;
                letter-spacing: 0.5em;
                font-size: 0.75rem;
                font-weight: 800;
            }

            /* ── Reveal ── */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
                visibility: hidden;
            }
            .reveal.active {
                opacity: 1 !important;
                transform: translateY(0) !important;
                visibility: visible !important;
            }

            /* ── Snap Slider ── */
            .snap-slider {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                scroll-behavior: smooth;
                -webkit-overflow-scrolling: touch;
            }
            .snap-slider::-webkit-scrollbar { display: none; }
            .snap-item { scroll-snap-align: start; flex: 0 0 auto; }

            /* ── Qatar Card ── */
            .qatar-card {
                position: relative;
                aspect-ratio: 3/4.5;
                overflow: hidden;
                border-radius: 1rem;
                background: var(--indigo-deep);
            }
            .qatar-card img {
                width: 100%; height: 100%;
                object-fit: cover;
                transition: transform 1.5s ease;
                opacity: 0.85;
            }
            .qatar-card:hover img { transform: scale(1.1); }
            .qatar-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                color: white;
            }

            .full-bleed-right {
                padding-left: max(1.5rem, calc((100vw - 1440px) / 2 + 3rem));
            }

            /* ══════════════════════════════════════════
               HERO — Simple, sama seperti Visi & Misi
            ══════════════════════════════════════════ */
            .hero-souvenir {
                height: 60vh;
                position: relative;
                overflow: hidden;
                background: #1a1445;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .hero-bg {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.4;
            }

            .hero-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to bottom, transparent 0%, var(--indigo-deep) 100%);
            }

            @media (max-width: 768px) {
                .hero-souvenir { height: 55vh; }
            }
        </style>
    @endpush


    {{-- ══════════════════════════════════════════
         1. HERO
    ══════════════════════════════════════════ --}}
    <section class="hero-souvenir">
        <img src="{{ asset('img/soevenir.jpeg') }}" class="hero-bg" alt="Souvenir Shop">
        <div class="hero-overlay"></div>
        <div class="relative z-10 text-center text-white px-6">
            <div class="reveal">
                <h1 class="font-editorial text-5xl md:text-8xl leading-tight italic">
                    Souvenir <br>
                    <span class="text-white/90">Shop</span>
                </h1>
                <p class="mt-8 max-w-xl mx-auto text-white/60 font-light leading-loose tracking-wide text-sm md:text-base">
                    Setiap detil bambu yang diraut adalah simbol dedikasi kami dalam menjaga api budaya Sunda tetap menyala.
                </p>
            </div>
        </div>
    </section>




    {{-- ══════════════════════════════════════════
         2. THE STORY OF CRAFTSMANSHIP
    ══════════════════════════════════════════ --}}
    <section class="py-32 bg-white overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-10">
            <div class="flex flex-col lg:flex-row items-center gap-24 lg:gap-40">

                <div class="w-full lg:w-5/12 reveal">
                    <div class="relative group">
                        <div class="absolute -inset-8 border-[0.5px] border-gray-100 pointer-events-none"></div>
                        <div class="relative aspect-[3/4] overflow-hidden rounded-xl">
                            <img src="{{ asset('img/Souvenir3.jpeg') }}"
                                 class="w-full h-full object-cover transition-transform duration-[6s] group-hover:scale-105">
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-7/12 reveal" style="transition-delay: 300ms;">
                    <h2 class="font-editorial text-4xl md:text-5xl text-indigo-950 leading-tight mb-12">
                        Dibuat dengan <br>
                        <span class="text-gold-premium italic font-normal">Rasa dan Jiwa</span>
                    </h2>
                    <div class="space-y-8 text-gray-400 font-light leading-loose text-lg">
                        <p class="italic text-indigo-900/60 font-editorial text-xl">
                            "Souvenir kami bukanlah komoditas massal, melainkan narasi tradisi yang dapat Anda bawa pulang."
                        </p>
                        <p>
                            Di tangan para pengrajin lokal Padasuka, bambu pilihan bertransformasi menjadi nada, dan kayu albasia
                            berubah menjadi karakter yang hidup. Kami memastikan setiap karya memiliki standar kualitas tinggi
                            sebagai duta budaya bangsa.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ══════════════════════════════════════════
         3. FEATURED COLLECTIONS SLIDER
    ══════════════════════════════════════════ --}}
    <section class="py-32 overflow-hidden" style="background:var(--v-gray);">
        <div class="full-bleed-right">
            <div class="grid lg:grid-cols-12 gap-10 items-start">

                <div class="lg:col-span-3 pr-10 reveal">
                    <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 uppercase mb-6">Gallery</p>
                    <h2 class="font-editorial text-4xl text-indigo-950 leading-tight mb-8">
                        Koleksi <br>
                        <span class="text-gold-premium italic">Ikonik</span>
                    </h2>
                    <p class="text-gray-400 text-sm font-light leading-relaxed">
                        Jelajahi berbagai pilihan kerajinan tangan terbaik kami, tersedia eksklusif hanya di toko fisik Saung Udjo.
                    </p>
                </div>

                <div class="lg:col-span-9">
                    <div id="souvenirSlider" class="snap-slider gap-6">
                        @php
                            $items = [
                                ['img' => 'Souvenir4suling.jpeg'],
                                ['img' => 'sovenir1.jpeg'],
                                ['img' => 'Soevenir5.jpeg'],
                                ['img' => 'Soevenir6.jpeg'],
                                ['img' => 'Soevenir7.jpeg'],
                                ['img' => 'Soevenir8.jpeg'],
                                ['img' => 'Soeverni9.jpeg'],
                                ['img' => 'Sovenir2.jpeg'],
                                ['img' => 'Sovenir3.jpeg'],
                            ];
                        @endphp

                        @foreach ($items as $item)
                            <div class="snap-item w-[75%] md:w-[35%] group cursor-default">
                                <div class="qatar-card">
                                    <img src="{{ asset('img/' . $item['img']) }}" alt="Souvenir">
                                    <div class="qatar-overlay"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end gap-3 mt-12 pr-[10vw]">
                        <button onclick="scrollSlider('left')"
                                class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-indigo-950 hover:text-white transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button onclick="scrollSlider('right')"
                                class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-indigo-950 hover:text-white transition flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ══════════════════════════════════════════
         4. PANDUAN BERBELANJA
    ══════════════════════════════════════════ --}}
    <section class="py-32 border-t border-gray-100" style="background:#fdfdfb;">
        <div class="max-w-[1400px] mx-auto px-10">

            <div class="text-center mb-24 reveal">
                <p class="text-[9px] font-bold tracking-[0.5em] uppercase mb-5"
                   style="color:var(--gold-premium);">Panduan</p>
                <h2 class="font-editorial text-2xl md:text-4xl text-indigo-950 leading-tight">
                    Panduan Berbelanja <br>
                    <span class="text-gold-premium italic font-normal text-xl md:text-3xl">di toko galeri kami</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 md:gap-12 text-center">

                <div class="reveal group">
                    <div class="mb-10 transform group-hover:scale-110 transition-transform duration-500 flex justify-center text-indigo-950">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3 class="font-editorial text-2xl text-indigo-950 mb-4">Lokasi Galeri</h3>
                    <p class="text-gray-500 text-sm font-light px-4">Tersedia di dua titik strategis: Area Parkir Utama dan Area Teater Pertunjukan.</p>
                </div>

                <div class="reveal group" style="transition-delay: 150ms;">
                    <div class="mb-10 transform group-hover:scale-110 transition-transform duration-500 flex justify-center text-indigo-950">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3 class="font-editorial text-2xl text-indigo-950 mb-4">Waktu Buka</h3>
                    <p class="text-gray-500 text-sm font-light px-4">Kami melayani Anda setiap hari mulai pukul 08.00 hingga 18.00 WIB.</p>
                </div>

                <div class="reveal group" style="transition-delay: 300ms;">
                    <div class="mb-10 transform group-hover:scale-110 transition-transform duration-500 flex justify-center text-indigo-950">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                    </div>
                    <h3 class="font-editorial text-2xl text-indigo-950 mb-4">Transaksi</h3>
                    <p class="text-gray-500 text-sm font-light px-4">Menerima pembayaran tunai, Debit, Kartu Kredit, dan berbagai metode QRIS.</p>
                </div>

                <div class="reveal group" style="transition-delay: 450ms;">
                    <div class="mb-10 transform group-hover:scale-110 transition-transform duration-500 flex justify-center text-indigo-950">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                        </svg>
                    </div>
                    <h3 class="font-editorial text-2xl text-indigo-950 mb-4">Pengemasan</h3>
                    <p class="text-gray-500 text-sm font-light px-4">Layanan packing kayu khusus untuk angklung agar aman dibawa dalam perjalanan udara.</p>
                </div>

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
                }, { threshold: 0.15 });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            });

            function scrollSlider(dir) {
                const slider = document.getElementById('souvenirSlider');
                const amt = slider.clientWidth * 0.4;
                slider.scrollBy({ left: dir === 'left' ? -amt : amt, behavior: 'smooth' });
            }
        </script>
    @endpush

@endsection
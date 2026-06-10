{{-- resources/views/home.blade.php --}}
@extends('layouts.app', [
    'seoTitle'       => 'Saung Angklung Udjo — Wisata Budaya UNESCO Bandung',
    'seoDescription' => 'Saung Angklung Udjo, destinasi wisata budaya UNESCO di Bandung sejak 1966. Nikmati pertunjukan angklung, wayang golek, tari tradisional Sunda. Booking tiket online — buka setiap hari pukul 08:00–17:30 WIB.',
    'seoKeywords'    => 'saung angklung udjo, wisata bandung, angklung unesco, pertunjukan angklung, wayang golek, budaya sunda, tiket angklung bandung, padasuka 118, mang udjo, wisata budaya bandung',
    'seoImage'       => asset('images/UdjoFullColor.png'),
    'seoType'        => 'website',
])

@push('preload')
    @if(isset($slides) && $slides->first())
        <link
            rel="preload"
            as="image"
            href="{{ asset('storage/' . $slides->first()->image_path) }}"
            fetchpriority="high"
        >
    @endif
@endpush

@section('title', 'Saung Angklung Udjo — Wisata Budaya UNESCO Bandung')

@section('content')


{{-- STYLES --}}
@push('styles')
    <style>
        /* TOMBOL UNESCO PREMIUM */
        .btn-unesco-premium {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem 3rem;
            background: #1a1445;
            /* Indigo Base */
            color: white;
            text-decoration: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 30px rgba(26, 20, 69, 0.15);
        }

        .btn-content {
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 2;
            font-weight: 800;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.4em;
            /* Spasi lebar biar mewah */
            transition: transform 0.5s ease;
        }

        .btn-icon {
            width: 0;
            /* Awalnya sembunyi */
            height: 14px;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Garis Luar (Outer Border) */
        .btn-border-outer {
            position: absolute;
            inset: 4px;
            border: 1px solid rgba(196, 164, 124, 0.3);
            /* Gold Line Tipis */
            border-radius: 0.8rem;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        /* HOVER STATE */
        .btn-unesco-premium:hover {
            background: #c4a47c;
            /* Berubah jadi Gold */
            color: #1a1445;
            /* Teks jadi Indigo */
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(196, 164, 124, 0.25);
        }

        .btn-unesco-premium:hover .btn-icon {
            width: 20px;
            /* Icon muncul */
            opacity: 1;
            transform: translateX(5px);
        }

        .btn-unesco-premium:hover .btn-border-outer {
            inset: 0;
            /* Garis melebar ke ujung */
            border-color: rgba(26, 20, 69, 0.2);
        }

        .btn-unesco-premium:active {
            transform: scale(0.95);
        }

        .img-luber-serasi {
            /* Sudut kanan dibuat serasi dengan .qatar-card (1rem atau sesuai selera premium) */
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            /* Sisi kiri tetap 0 karena nempel ke ujung layar */
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            overflow: hidden;
            box-shadow: 15px 0 50px rgba(0, 0, 0, 0.05);
        }


        html {
            scroll-behavior: smooth;
        }

        .hero-nav-minimal {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            /* Membuat elemen tepat di tengah */
            display: flex;
            gap: 80px;
            /* Jarak lebar antar menu agar terlihat lega/minimalis */
            z-index: 100;
            width: auto;
        }

        .hero-nav-minimal .nav-item {
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.4s ease;
        }

        .hero-nav-minimal .nav-text {
            color: #ffffff;
            font-size: 13px;
            /* Ukuran lebih kecil agar minimalis */
            font-weight: 400;
            letter-spacing: 3px;
            /* Spasi antar huruf untuk kesan elegan */
            margin-bottom: 15px;
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .hero-nav-minimal .nav-line {
            width: 120px;
            /* Panjang garis tetap */
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
            position: relative;
        }

        /* State: Hover & Active */
        .nav-item:hover .nav-text,
        .nav-item.active .nav-text {
            opacity: 1;
        }

        .nav-item.active .nav-line::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 50%;
            /* Panjang indikator aktif */
            height: 2px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        /* Responsif untuk Mobile */
        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .cta-foto-wrap {
                position: relative;
                height: auto !important;
                max-height: none !important;
                min-height: 420px;
                align-self: stretch;
            }

            .cta-foto-wrap img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .hero-nav-minimal {
                gap: 20px;
                bottom: 20px;
                width: 95%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .hero-nav-minimal .nav-text {
                font-size: 8px;
                letter-spacing: 1px;
                margin-bottom: 8px;
            }

            .hero-nav-minimal .nav-line {
                width: 60px;
            }
        }


        :root {
            --indigo-deep: #1a1445;
            --gold-premium: #c4a47c;
            --v-gray: #f8f8f7;
            --qatar-maroon: #7d002a;
            --bg-premium: #F7F7F2;
            --bg-brand: #22185d;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--bg-brand);
            background-color: var(--bg-premium) !important;
        }

        .font-editorial {
            font-family: 'Libre Baskerville', serif;
        }

        .font-spirax {
            font-family: 'Spirax', cursive;
        }

        .text-spacing-sm {
            text-transform: uppercase;
            letter-spacing: 0.3em;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .text-spacing-lg {
            text-transform: uppercase;
            letter-spacing: 0.5em;
            font-size: 0.75rem;
            font-weight: 800;
        }

        /* Reveal System */
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

        /* Scrollbar Hide */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Slider Snap Logic */
        .snap-slider {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding-right: 10vw;
        }

        .snap-slider::-webkit-scrollbar {
            display: none;
        }

        .snap-item {
            scroll-snap-align: start;
            flex: 0 0 auto;
        }

        /* Qatar Card Style */
        .qatar-card {
            position: relative;
            aspect-ratio: 3/4.5;
            overflow: hidden;
            border-radius: 1rem;
            background: var(--indigo-deep);
            transition: transform 0.5s cubic-bezier(0.2, 1, 0.3, 1);
        }

        .qatar-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 1.5s ease;
            opacity: 0.9;
        }

        .qatar-card:hover img {
            transform: scale(1.1);
        }

        .qatar-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.2) 40%, transparent 100%);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
        }

        /* Event Card */
        .event-card {
            position: relative;
            aspect-ratio: 4/5;
            overflow: hidden;
            background: var(--indigo-deep);
        }

        .event-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 2s ease;
            opacity: 0.8;
        }

        .event-card:hover img {
            transform: scale(1.1);
            opacity: 1;
        }

        .event-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, transparent 60%);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
        }

        /* News Card */
        .news-card img {
            transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .news-card:hover img {
            transform: scale(1.05);
        }

        /* Journey Steps */
        .journey-step {
            border-left: 1px solid rgba(26, 20, 69, 0.1);
            padding: 0 0 40px 30px;
            position: relative;
        }

        .journey-step::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 0;
            width: 9px;
            height: 9px;
            background: var(--gold-premium);
            border-radius: 50%;
        }

        /* Logo Container */
        .logo-container {
            filter: grayscale(1);
            opacity: 0.3;
            transition: all 0.5s ease;
        }

        .logo-container:hover {
            filter: grayscale(0);
            opacity: 1;
            transform: translateY(-5px);
        }

        /* Button Styles */
        .btn-v {
            padding: 1.2rem 3.5rem;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            transition: all 0.4s;
            display: inline-block;
            border-radius: 0;
        }

        .btn-premium-modern {
            display: inline-block;
            padding: 1.2rem 3.5rem;
            background-color: #ffffff;
            color: #1a1445;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
            border-radius: 0;
        }

        .btn-premium-modern:hover {
            background-color: transparent;
            color: #ffffff;
            border-color: #ffffff;
            letter-spacing: 0.4em;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        /* Full Bleed Right */
        .full-bleed-right {
            padding-left: max(1.5rem, calc((100vw - 1440px) / 2 + 3rem));
        }

        @media (max-width: 1024px) {
            .full-bleed-right {
                padding-left: 2rem;
            }
        }

        section {
            margin: 0 !important;
        }
    </style>
@endpush


<!-- 1. CINEMATIC HERO SLIDER -->
<section class="relative h-screen bg-black overflow-hidden flex items-center">
    <!-- Background Slides -->
    <div id="hero-slider-container" class="absolute inset-0 z-0">
        {{-- Di hero slider --}}
      @foreach ($slides as $index => $slide)
    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
        <img
            src="{{ asset('storage/' . $slide->image_path) }}"
            class="w-full h-full object-cover"
            width="1920"
            height="1080"
            alt="{{ $slide->alt_text ?? 'Pertunjukan Saung Angklung Udjo' }}"
            {{-- ✅ Slide pertama: eager + priority --}}
            @if($index === 0)
                fetchpriority="high"
                loading="eager"
                decoding="sync"
            @else
                loading="lazy"
                decoding="async"
            @endif
        >
    </div>
@endforeach
    </div>




    </div>

    <!-- Overlay Gradien Premium -->
    <div class="absolute inset-0 bg-gradient-to-t from-[#1a1445] via-transparent to-transparent z-[1]"></div>
    <div class="absolute inset-0 bg-black/20 z-[1]"></div>

    <!-- MAIN HEADLINE (PERBAIKAN ALIGNMENT) -->
    <div class="absolute inset-0 z-10">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 lg:px-20 text-white h-full flex items-center">
            <div class="w-full max-w-4xl">
                <h1 class="reveal font-spirax text-[2rem] md:text-[3rem] lg:text-[4rem] leading-[1.1] tracking-tight">
                    Saung Angklung<br>
                    <span class="italic text-gold-premium">Udjo</span>
                </h1>
                <p class="reveal mt-6 text-[8px] md:text-[10px] tracking-[0.5em] font-bold uppercase text-white/80">
                    {{ __('home.hero.unesco_badge') }}
                </p>

            </div>
        </div>
    </div>


    <!-- Navigasi Slider (Visit Qatar Style) -->
    <div class="absolute bottom-10 right-10 md:right-20 z-20 flex items-center gap-4">
        <!-- Progress Indicators -->
        <div class="flex gap-2 mr-4">
            @for ($i = 0; $i < 3; $i++)
                <div class="hero-indicator {{ $i === 0 ? 'active' : '' }}"></div>
            @endfor
        </div>


        <!-- Tombol Panah -->
        <button onclick="prevSlide()" class="nav-btn-hero" aria-label="Slide sebelumnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <button onclick="nextSlide()" class="nav-btn-hero" aria-label="Slide berikutnya">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>



    <!-- Minimalist Centered Navigation -->
    <div class="hero-nav-minimal">
        <a href="#jadwal-pertunjukan" class="nav-item">
            <span class="nav-text">{{ __('home.hero.nav_schedule') }}</span>
            <div class="nav-line"></div>
        </a>
        <a href="#Rangkaian-Pertunjukan" class="nav-item">
            <span class="nav-text">{{ __('home.hero.nav_performances') }}</span>
            <div class="nav-line"></div>
        </a>
        <a href="{{ route('heritage.venue') }}#mapslokasi" class="nav-item">
            <span class="nav-text">{{ __('home.hero.nav_virtual_tour') }}</span>
            <div class="nav-line"></div>
        </a>

    </div>
</section>

<style>
    /* Transisi Slide */
    .hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1), transform 10s linear;
        z-index: 0;
    }

    .hero-slide.active {
        opacity: 0.6;
        /* Kecerahan gambar */
        z-index: 1;
        transform: scale(1.1);
        /* Efek zoom perlahan ala Visit Qatar */
    }

    /* Indikator Garis Bawah */
    .hero-indicator {
        width: 30px;
        height: 2px;
        background: rgba(255, 255, 255, 0.3);
        transition: all 0.5s ease;
    }

    .hero-indicator.active {
        background: var(--gold-premium);
        width: 50px;
    }

    /* Tombol Navigasi Bulat */
    .nav-btn-hero {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
    }

    .nav-btn-hero:hover {
        background: white;
        color: #1a1445;
        border-color: white;
    }

    /* Perbaikan Font Spirax agar tidak tumpang tindih */
    .font-spirax span {
        display: block;
    }
</style>

<script>
    // Variabel global
    let currentSlide = 0;
    let slides, indicators;
    let autoPlayInterval;

    document.addEventListener('DOMContentLoaded', () => {
    requestIdleCallback(() => {
        // Inisialisasi elemen
        slides = document.querySelectorAll('.hero-slide');
        indicators = document.querySelectorAll('.hero-indicator');
        // Tampilkan slide pertama
        if (slides.length > 0) {
            showSlide(0);
        }
        // Auto play - HANYA SATU kali
        autoPlayInterval = setInterval(nextSlide, 6000);
    });
});
        // Inisialisasi elemen
        slides = document.querySelectorAll('.hero-slide');
        indicators = document.querySelectorAll('.hero-indicator');

        // Tampilkan slide pertama
        if (slides.length > 0) {
            showSlide(0);
        }

        // Auto play - HANYA SATU kali
        autoPlayInterval = setInterval(nextSlide, 6000);
    });

    function showSlide(index) {
        if (!slides || slides.length === 0) return;

        // Hapus class active dari semua slide dan indikator
        slides.forEach(s => s.classList.remove('active'));
        indicators.forEach(i => i.classList.remove('active'));

        // Handle looping
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        // Aktifkan slide dan indikator yang sesuai
        slides[currentSlide].classList.add('active');

        // Update indikator (dengan modulo untuk 3 indikator)
        const indicatorIndex = currentSlide % indicators.length;
        if (indicators[indicatorIndex]) {
            indicators[indicatorIndex].classList.add('active');
        }
    }

    function nextSlide() {
        currentSlide++;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide--;
        showSlide(currentSlide);
    }

    // Pause auto-play saat hover (opsional)
    document.querySelector('#hero-slider-container')?.addEventListener('mouseenter', () => {
        clearInterval(autoPlayInterval);
    });

    document.querySelector('#hero-slider-container')?.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextSlide, 6000);
    });
</script>








<div style="height: 60px;"></div>


{{-- ================================================
SECTION: EVENTS — Dynamic from DB
================================================ --}}

<section id="events" class="py-20 overflow-hidden">

    {{-- 1. HEADER --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-12">
        <div class="reveal">
            <h2 class="font-editorial text-3xl md:text-5xl text-indigo-950 leading-tight mb-4">
                {{ __('home.events.title') }}
            </h2>
            <p class="max-w-md text-gray-400 text-sm font-light leading-relaxed">
                {{ __('home.events.desc') }}
            </p>
        </div>
    </div>

    {{-- 2. SLIDER --}}
    <div class="w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw]">
        <div id="evSlider" class="snap-slider gap-6 overflow-x-auto flex">

            {{-- spacer kiri --}}
            <div class="w-[30vw] flex-shrink-0"></div>

            @forelse($events as $event)
                <div class="snap-item w-[75%] md:w-[24%] group cursor-pointer flex-shrink-0">
                    <a href="{{ $event->url ?? '#' }}"
                       {{ $event->url ? 'target="_blank" rel="noopener noreferrer"' : '' }}
                       class="block no-underline">

                        <div class="ev-arch-card">
                            @if($event->image_path)
                                <img src="{{ Storage::url($event->image_path) }}"
                                     alt="{{ $event->title }}">
                            @else
                                {{-- Fallback placeholder --}}
                                <img src="https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=800"
                                     alt="{{ $event->title }}">
                            @endif

                            {{-- Overlay info (opsional — uncomment jika ingin tampilkan judul) --}}
                            {{--
                            <div class="ev-arch-overlay">
                                @if($event->category)
                                    <span class="text-[9px] font-bold text-white/60 uppercase tracking-[0.3em] mb-2 block">
                                        {{ $event->category }}
                                    </span>
                                @endif
                                <h3 class="font-editorial text-xl text-white leading-snug">{{ $event->title }}</h3>
                                @if($event->event_date)
                                    <p class="text-[10px] text-white/50 mt-1">{{ $event->event_date }}</p>
                                @endif
                            </div>
                            --}}
                        </div>

                    </a>
                </div>
            @empty
                <div class="w-full px-10 py-20 text-center text-gray-400 italic">
                    Belum ada event yang ditampilkan.
                </div>
            @endforelse

            {{-- spacer kanan --}}
            <div class="w-[30vw] flex-shrink-0"></div>
        </div>

        {{-- 3. CONTROLS --}}
        <div class="flex justify-end gap-3 mt-10 pr-[10vw]">
            <button onclick="scrollEv('left')" aria-label="Event sebelumnya"
                class="w-12 h-12 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center relative z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button onclick="scrollEv('right')" aria-label="Event berikutnya"
                class="w-12 h-12 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center relative z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</section>


<style>
    /* RASIO TETAP 2/3 - Ukuran fisik mengecil karena mengikuti lebar kolom md:w-[28%] */
    .ev-arch-card {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-start;
        aspect-ratio: 3 / 4.5;
        border-radius: 1rem;
    }

    .ev-arch-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .group:hover .ev-arch-card img {
        transform: scale(1.05);
    }

    .ev-arch-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem;
        height: 60%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.7) 40%, transparent 100%);
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    /* Slider Style agar tombol berfungsi */
    .snap-slider {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        scrollbar-width: none;
        scroll-padding-left: 15vw;
        /* ← TAMBAH INI */
    }

    .snap-slider::-webkit-scrollbar {
        display: none;
    }

    .snap-item {
        scroll-snap-align: start;
    }
</style>

<script>
    function scrollEv(dir) {
        const slider = document.getElementById('evSlider');
        if (!slider) return;

        // Gunakan clientWidth seperti fungsi lain, lebih aman
        const amount = slider.clientWidth * 0.85;
        slider.scrollBy({
            left: dir === 'right' ? amount : -amount,
            behavior: 'smooth'
        });
    }


    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('evSlider');
        const card = slider.querySelector('.snap-item');

        if (slider && card) {
            const gap = 24;
            const offset = card.offsetWidth + gap;

            // TANPA animasi (langsung posisi awal)
            slider.scrollLeft = 0;
        }
    });
</script>



<!-- THE MAESTRO LEGACY (Ultra Minimalist - Visit Qatar Style) -->
<section id="maestro" class="py-32 md:py-48 overflow-hidden">
    <div class="max-w-[1200px] mx-auto px-10">
        <div class="flex flex-col lg:flex-row items-center gap-24 lg:gap-40">

            <!-- SISI KIRI: Foto Portrait (Dibuat Lebih Kecil & Simpel) -->
            <div class="w-full lg:w-5/12 reveal">
                <div class="relative group">
                    <!-- Bingkai Luar Tipis Sekali -->
                    <div class="absolute -inset-8 border-[0.5px] border-gray-100 pointer-events-none"></div>

                    <!-- Frame Foto -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-50">
                        <img src="{{ asset('images/udjo-2.webp') }}" alt="Udjo Ngalagena"
                            class="w-full h-full object-cover grayscale brightness-110 contrast-110 transition-all duration-[4s] group-hover:scale-105">
                    </div>

                    <!-- Nama diletakkan sangat kecil di bawah -->
                    <div class="mt-8 text-center lg:text-left">
                        <span class="text-[9px] font-bold tracking-[0.6em] text-gold-premium uppercase">Udjo
                            Ngalagena (1929-2001)</span>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: Teks (Sangat Lega & Minimalis) -->
            <div class="w-full lg:w-7/12 reveal" style="transition-delay: 300ms;">
                <div class="max-w-lg">
                    <!-- Judul Utama (Rapi & Elegan) -->
                    <h2
                        class="font-editorial text-4xl md:text-5xl lg:text-6xl text-indigo-950 leading-[1.2] mb-12 tracking-tight">
                        {{ __('home.maestro.title_1') }} <br>
                        {{ __('home.maestro.title_2') }} <br>
                        <span class="text-gold-premium italic font-normal">{{ __('home.maestro.title_3') }}</span>
                    </h2>

                    <!-- Deskripsi (Font Tipis & Jarak Baris Luas) -->
                    <div class="space-y-8 text-gray-400 font-light leading-loose text-lg">
                        <p class="italic text-indigo-900/60 font-editorial text-xl">
                            {{ __('home.maestro.quote') }}
                        </p>
                        <p>
                            {{ __('home.maestro.desc') }}
                        </p>
                    </div>

                    <!-- Tombol Navigasi (Sangat Simpel) -->
                    <div class="mt-16">
                        <a href="{{ route('heritage.history') }}"
                            class="group inline-flex items-center gap-6 text-[10px] font-bold tracking-[0.4em] uppercase text-indigo-950 hover:text-gold-premium transition-all">
                            <span>{{ __('home.maestro.cta') }}</span>
                            <div
                                class="w-12 h-px bg-indigo-950/20 group-hover:w-20 group-hover:bg-gold-premium transition-all duration-500">
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- 3. QUICK INFO BAR -->
<section class="py-16 border-b border-gray-100 overflow-hidden">

    {{-- Grid: desktop 3-col, mobile swipe --}}
    <div id="qiSlider" class="qi-info-grid max-w-[1400px] mx-auto px-10">

        <div class="qi-info-item reveal flex flex-col items-center text-center">
            <svg class="w-10 h-10 text-indigo-900 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    stroke-width="1.2" />
            </svg>
            <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">
                {{ __('home.quick_info.founded_label') }}</h4>
            <p class="font-editorial text-xl">{{ __('home.quick_info.founded_value') }}</p>
        </div>

     <div class="qi-info-item reveal flex flex-col items-center text-center" style="transition-delay: 200ms;">
    <img src="{{ asset('images/LOGOUNESCO.png') }}"
         class="w-12 h-10 mb-6 object-contain"
         style="filter: brightness(0) saturate(100%) invert(19%) sepia(30%) saturate(1500%) hue-rotate(210deg) brightness(95%);"
         alt="UNESCO World Heritage">



    <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">
        {{ __('home.quick_info.status_label') }}
    </h4>
    <p class="font-editorial text-xl">{{ __('home.quick_info.status_value') }}</p>
</div>

        <div class="qi-info-item reveal flex flex-col items-center text-center" style="transition-delay: 400ms;">
            <img src="{{ asset('images/angklung.webp') }}" class="w-10 h-10 mb-6 object-contain"
                style="filter: brightness(0) saturate(100%) invert(19%) sepia(30%) saturate(1500%) hue-rotate(210deg) brightness(95%);"
                alt="Angklung">
            <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">
                {{ __('home.quick_info.culture_label') }}</h4>
            <p class="font-editorial text-xl">{{ __('home.quick_info.culture_value') }}</p>
        </div>

        {{-- Spacer kanan (mobile only) --}}
        <div class="qi-spacer" aria-hidden="true"></div>
    </div>

    {{-- Dots indicator (mobile only) --}}
    <div id="qiDots" class="qi-dots flex gap-1.5 px-6 mt-4">
        <div class="qi-dot active"></div>
        <div class="qi-dot"></div>
        <div class="qi-dot"></div>
    </div>
</section>

<style>
    /* Desktop: grid biasa (tidak ada perubahan dari sebelumnya) */
    .qi-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
    }

    .qi-spacer {
        display: none;
    }

    .qi-dots {
        display: none;
    }

    .qi-dot {
        height: 2px;
        border-radius: 2px;
        background: rgba(26, 20, 69, 0.15);
        transition: all 0.35s ease;
        width: 20px;
    }

    .qi-dot.active {
        background: #1a1445;
        width: 36px;
    }

    /* Mobile only: ubah grid jadi swipe slider */
    @media (max-width: 767px) {
        .qi-info-grid {
            display: flex !important;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding: 0 1.5rem !important;
            gap: 1rem;
            max-width: 100% !important;
        }

        .qi-info-grid::-webkit-scrollbar {
            display: none;
        }

        .qi-info-item {
            flex: 0 0 72vw;
            max-width: 240px;
            scroll-snap-align: start;
            background: #F7F7F2;

            /* tetap ada garis tipis biar kartu terbaca */
            border-radius: 16px;
            padding: 2rem 1.25rem !important;
        }

        .qi-spacer {
            display: block;
            flex: 0 0 0.5rem;
        }

        .qi-dots {
            display: flex;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('qiSlider');
        const dots = document.querySelectorAll('.qi-dot');

        slider.addEventListener('scroll', () => {
            if (window.innerWidth >= 768) return; // hanya aktif di mobile
            const cards = slider.querySelectorAll('.qi-info-item');
            const leftRef = slider.getBoundingClientRect().left;
            let activeIdx = 0,
                minDist = Infinity;
            cards.forEach((card, i) => {
                const dist = Math.abs(card.getBoundingClientRect().left - leftRef);
                if (dist < minDist) {
                    minDist = dist;
                    activeIdx = i;
                }
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === activeIdx));
        });
    });
</script>


<!-- SECTION: ANGKLUNG FOR THE WORLD (LUBER KIRI SERASI) -->
<section id="global-mission" class="py-32 overflow-hidden bg-[#F7F7F2]">
    <div class="full-bleed-left-container">
        <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">

            <!-- SISI KIRI: Foto Tunggal Luber Ke Kiri -->
            <div class="w-full lg:w-1/2 reveal">
                <div class="relative h-[450px] md:h-[600px] lg:h-[700px] w-full img-luber-serasi">
                    <img src="{{ asset('img/Pertunjukanluar.webp') }}"
                        class="w-full h-full object-cover transition-transform duration-[6s] hover:scale-110"
                        alt="Angklung for The World">

                    <!-- Overlay Gradien Halus -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent to-indigo-950/10"></div>
                </div>
            </div>

            <!-- SISI KANAN: Teks -->
            <div class="w-full lg:w-1/2 px-8 lg:px-0 reveal" style="transition-delay: 300ms;">
                <div class="max-w-xl">
                    <p class="text-[10px] font-bold tracking-[0.5em] text-gold-premium uppercase mb-6">
                        {{ __('home.global_mission.eyebrow') }}</p>

                    <h2 class="font-editorial text-4xl md:text-5xl lg:text-6xl text-indigo-950 leading-[1.15] mb-10">
                        Angklung for <br>
                        <span class="italic text-gold-premium font-normal">The World</span>
                    </h2>

                    <div class="space-y-8 text-indigo-950/70 font-light leading-relaxed text-lg">
                        <p>
                            {{ __('home.global_mission.desc_1') }}
                        </p>

                        <div class="flex items-center gap-4">
                            <div class="w-12 h-px bg-gold-premium"></div>
                            <div class="w-2 h-2 rounded-full bg-gold-premium/30"></div>
                        </div>


                    </div>


                </div>
            </div>

        </div>
    </div>
</section>

<!-- 5. RANGKAIAN PERTUNJUKAN (FULL BLEED SLIDER) -->
<section id="Rangkaian-Pertunjukan" class="py-32 overflow-hidden">
    <div class="full-bleed-right">
        <div class="grid lg:grid-cols-12 gap-10 items-start">

            <!-- SISI KIRI: Deskripsi -->
            <div class="lg:col-span-3 pr-10 reveal">
                <p class="text-[10px] font-bold tracking-[0.4em] text-gray-400 uppercase mb-6">Discovery</p>
                <h2 class="font-editorial text-4xl md:text-5xl text-indigo-950 leading-tight mb-8">
                    {{ __('home.performances.title') }} <br> <span
                        class="text-gold-premium italic">{{ __('home.performances.title_italic') }}</span>
                </h2>
                <p class="text-gray-400 text-base font-light leading-relaxed mb-10">
                    {{ __('home.performances.desc') }}
                </p>
                <a href="{{ route('experience.performances') }}"
                    class="inline-block border-b-2 border-indigo-950 pb-1 text-[10px] font-bold uppercase tracking-widest text-indigo-950 hover:text-gold-premium hover:border-gold-premium transition-all">
                    {{ __('home.performances.cta_all') }}</a>
            </div>

            <!-- SISI KANAN: Slider -->
            <div class="lg:col-span-9">


                <div id="perfSlider" class="snap-slider gap-6">

                    @php
                        $performanceKeys = [
                            ['img' => 'Wayanggolek.webp', 'key' => 'wayang_golek', 'anchor' => 'wayang-golek'],
                            ['img' => 'Helaran1.webp', 'key' => 'helaran', 'anchor' => 'helaran'],
                            ['img' => 'Taritopeng.webp', 'key' => 'tari_topeng', 'anchor' => 'tari-topeng'],
                            ['img' => 'Angklungmini.webp', 'key' => 'angklung_mini', 'anchor' => 'angklung-mini'],
                            ['img' => 'Arumbaa.webp', 'key' => 'arumba', 'anchor' => 'arumba'],
                            ['img' => 'Angklungmasal.webp', 'key' => 'angklung_masal', 'anchor' => 'angklung-masal'],
                            [
                                'img' => 'Interaktif_Angklung.webp',
                                'key' => 'angklung_interaktif',
                                'anchor' => 'angklung-interaktif',
                            ],
                            ['img' => 'Trioangklung.webp', 'key' => 'trio_angklung', 'anchor' => 'trio-angklung'],
                            ['img' => 'MenariBersama.webp', 'key' => 'menari_bersama', 'anchor' => 'menari-bersama'],
                        ];
                    @endphp

                    @foreach ($performanceKeys as $p)
                        @php
                            $perf = __('home.performances_list.' . $p['key']);
                        @endphp
                        <div class="snap-item w-[75%] md:w-[40%] group cursor-pointer">
                            <a href="{{ route('experience.performances') }}#{{ $p['anchor'] }}"
                                class="block no-underline">
                                <div class="qatar-card">
                                    <img src="{{ asset('img/' . $p['img']) }}"
                                        onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1000'">

                                    <div class="qatar-overlay">
                                        <p class="text-[9px] font-bold text-white/60 uppercase tracking-[0.3em] mb-3">
                                            {{ $perf['cat'] }}
                                        </p>
                                        <h3 class="font-editorial text-2xl md:text-3xl leading-tight mb-2">
                                            {{ $perf['title'] }}
                                        </h3>
                                        <p class="text-[10px] opacity-70 font-light mb-4">
                                            {{ $perf['desc'] }}
                                        </p>

                                        {{-- CTA muncul saat hover --}}
                                        <div
                                            class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-2 group-hover:translate-y-0">
                                            <div class="w-6 h-px bg-gold-premium"></div>
                                            <span
                                                class="text-[9px] font-bold uppercase tracking-[0.2em] text-gold-premium">
                                                {{ __('home.news.cta_read') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>

                <!-- Slider Controls -->
                <div class="flex justify-end gap-3 mt-12 pr-[10vw]">
                    <button onclick="scrollPerf('left')"
                        class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button onclick="scrollPerf('right')"
                        class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-gray-100 transition flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION: JADWAL PERTUNJUKAN (PREMIUM ENHANCED) -->
<section id="jadwal-pertunjukan">

    <div class="container">

        <!-- Header Section -->
        <div class="header-section reveal">
            <h2 class="main-title font-editorial">{{ __('home.schedule.title') }}</h2>
        </div>

        <!-- Schedule Cards Grid (2 Columns) -->
       <div id="scheduleSlider1" class="schedule-all-cards">
    <!-- Card 1: Pertunjukan Reguler -->
    <div class="info-card reveal">
        <div class="card-header">
            <h3 class="card-title">{{ __('home.schedule.regular_show') }}</h3>
            <div class="header-line"></div>
        </div>
        <div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.everyday') }}</span>
                <span class="schedule-time font-editorial">15.30 - 17.00<span class="timezone">WIB</span></span>
            </div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.saturday') }}</span>
                <span class="schedule-time font-editorial">13.00 & 15.30<span class="timezone">WIB</span></span>
            </div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.sunday') }}</span>
                <span class="schedule-time font-editorial">10.00 & 15.30<span class="timezone">WIB</span></span>
            </div>
        </div>
    </div>

    <!-- Card 2: Reservasi -->
    <div class="info-card reveal" style="transition-delay: 100ms;">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('home.schedule.reservation_show') }}
                <a href="https://wa.me/6282182821200" target="_blank">Admin</a>
            </h3>
            <div class="header-line"></div>
        </div>
        <div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.morning_session') }}</span>
                <span class="schedule-time font-editorial">10.00 - 11.30<span class="timezone">WIB</span></span>
            </div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.afternoon_session') }}</span>
                <span class="schedule-time font-editorial">13.00 - 14.30<span class="timezone">WIB</span></span>
            </div>
            <div class="schedule-row">
                <span class="schedule-label">{{ __('home.schedule.evening_session') }}</span>
                <span class="schedule-time font-editorial">15.30 - 17.00<span class="timezone">WIB</span></span>
            </div>
        </div>
    </div>

    <div class="schedule-spacer" aria-hidden="true"></div>
</div>
<div id="scheduleDots1" class="schedule-dots">
    <div class="sch-dot active"></div>
    <div class="sch-dot"></div>
</div>






<div id="scheduleSlider2" class="schedule-all-cards" style="margin-top: 1.5rem;">
    <!-- Domestik -->
    <div class="info-card reveal" style="transition-delay: 200ms;">
        <div class="card-header">
            <h3 class="card-title">{{ __('home.schedule.domestic_visitors') }}</h3>
            <div class="header-line"></div>
        </div>
        <div>
            <div class="price-row">
                <span class="price-category font-editorial">{{ __('home.schedule.adult') }}</span>
                <span class="price-amount">IDR 85K</span>
            </div>
            <div class="price-row">
                <span class="price-category font-editorial">{{ __('home.schedule.student') }}</span>
                <span class="price-amount">IDR 60K</span>
            </div>
        </div>
    </div>

    <!-- International -->
    <div class="info-card reveal" style="transition-delay: 300ms;">
        <div class="card-header">
            <h3 class="card-title">International Visitors</h3>
            <div class="header-line"></div>
        </div>
        <div>
            <div class="price-row">
                <span class="price-category font-editorial">Adult</span>
                <span class="price-amount">IDR 120K</span>
            </div>
            <div class="price-row">
                <span class="price-category font-editorial">Student</span>
                <span class="price-amount">IDR 85K</span>
            </div>
        </div>
    </div>

    <div class="schedule-spacer" aria-hidden="true"></div>
</div>
<div id="scheduleDots2" class="schedule-dots">
    <div class="sch-dot active"></div>
    <div class="sch-dot"></div>
</div>
        <!-- Bottom Info Section -->
        <div class="bottom-info reveal" style="transition-delay: 400ms;">

            <!-- Kapasitas & Minimal Reservasi -->
            <div class="stats-row">
                <div class="stat-item">
                    <p class="stat-label">{{ __('home.schedule.capacity_label') }}</p>
                    <p class="stat-value font-editorial">{{ __('home.schedule.capacity_value') }}</p>
                </div>

                <div class="stat-item">
                    <p class="stat-label">{{ __('home.schedule.minimum_reservation_label') }}</p>
                    <div class="minimal-group">
                        <div class="minimal-stat">
                            <p class="stat-value font-editorial">30</p>
                            <span class="sub-label">{{ __('home.schedule.minimum_adult') }}</span>
                        </div>
                        <div class="minimal-stat">
                            <p class="stat-value font-editorial">50</p>
                            <span class="sub-label">{{ __('home.schedule.minimum_student') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note Box -->
            <div class="note-box">
                <p>
                    {{ __('home.schedule.note') }}
                </p>
            </div>

        </div>
    </div>
</section>

<style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spirax&display=swap');
/* DESKTOP: tetap grid 2 kolom, tidak ada slider */
/* DESKTOP: tetap grid 2 kolom */
.schedule-all-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    max-width: 72rem;
    margin: 0 auto 2rem;
}

.schedule-spacer { display: none; }
.schedule-dots { display: none; }

.sch-dot {
    height: 2px;
    border-radius: 2px;
    background: rgba(26, 20, 69, 0.15);
    transition: all 0.35s ease;
    width: 20px;
}
.sch-dot.active {
    background: #1a1445;
    width: 36px;
}

/* MOBILE ONLY */
@media (max-width: 767px) {
    .schedule-all-cards {
        display: flex !important;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        scrollbar-width: none;
        padding: 0 1.5rem !important;
        gap: 1rem;
        max-width: 100% !important;
        margin-bottom: 0 !important;
    }
    .schedule-all-cards::-webkit-scrollbar { display: none; }
    .schedule-all-cards .info-card {
        flex: 0 0 80vw;
        max-width: 320px;
        scroll-snap-align: start;
    }
    .schedule-spacer {
        display: block;
        flex: 0 0 0.5rem;
    }
    .schedule-dots {
        display: flex;
        gap: 6px;
        justify-content: center;
        margin: 0.75rem 0 2rem;
    }
}
    #jadwal-pertunjukan {
        position: relative;
        padding: 8rem 2.5rem;
        overflow: hidden;
        background: #F7F7F2;
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .font-editorial {
        font-family: 'Libre Baskerville', serif;
    }

    #jadwal-pertunjukan .font-spirax {
        font-family: 'Spirax', cursive;
    }

    #jadwal-pertunjukan::before {
        content: '';
        position: absolute;
        top: 5rem;
        right: 2.5rem;
        width: 16rem;
        height: 16rem;
        background: radial-gradient(circle, rgba(196, 164, 124, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(60px);
        pointer-events: none;
        z-index: 0;
    }

    #jadwal-pertunjukan::after {
        content: '';
        position: absolute;
        bottom: 5rem;
        left: 2.5rem;
        width: 20rem;
        height: 20rem;
        background: radial-gradient(circle, rgba(26, 20, 69, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }

    #jadwal-pertunjukan .container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 10;
    }

    #jadwal-pertunjukan .header-section {
        text-align: center;
        margin-bottom: 5rem;
    }

    #jadwal-pertunjukan .main-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1.15;
        letter-spacing: -0.02em;
        color: #1a1445;
        font-family: 'Libre Baskerville', serif;
    }

    #jadwal-pertunjukan .schedule-cards-grid {
        max-width: 72rem;
        margin: 0 auto 5rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    #jadwal-pertunjukan .cards-grid {
        max-width: 56rem;
        margin: 0 auto 5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    #jadwal-pertunjukan .info-card {
        background: white;
        border: 1px solid rgba(26, 20, 69, 0.08);
        padding: 2.5rem 3rem;
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #jadwal-pertunjukan .info-card:hover {
        border-color: rgba(196, 164, 124, 0.3);
        box-shadow: 0 20px 60px rgba(26, 20, 69, 0.08);
        transform: translateY(-6px);
    }

    #jadwal-pertunjukan .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 2rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(26, 20, 69, 0.08);
    }

    #jadwal-pertunjukan .card-title {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        color: #1a1445;
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .card-title a {
        color: #c4a47c;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #jadwal-pertunjukan .card-title a:hover {
        opacity: 0.7;
    }

    #jadwal-pertunjukan .header-line {
        width: 32px;
        height: 1px;
        background: #c4a47c;
    }

    #jadwal-pertunjukan .schedule-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(26, 20, 69, 0.05);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #jadwal-pertunjukan .schedule-row:last-child {
        border-bottom: none;
    }

    #jadwal-pertunjukan .schedule-row:hover {
        background: rgba(196, 164, 124, 0.03);
        padding-left: 1rem;
        padding-right: 1rem;
        margin: 0 -1rem;
    }

    #jadwal-pertunjukan .schedule-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: rgba(26, 20, 69, 0.6);
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .schedule-time {
        font-size: clamp(1.5rem, 3vw, 1.875rem);
        font-weight: 600;
        color: #22185d;
        font-variant-numeric: tabular-nums;
        font-family: 'Libre Baskerville', serif;
        letter-spacing: 0.02em;
    }

    #jadwal-pertunjukan .schedule-time .timezone {
        font-size: 10px;
        font-weight: 600;
        color: rgba(26, 20, 69, 0.4);
        margin-left: 0.5rem;
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.05em;
    }

    #jadwal-pertunjukan .pricing-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 5rem;
        max-width: 72rem;
        margin-left: auto;
        margin-right: auto;
    }

    #jadwal-pertunjukan .price-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 1.5rem 0;
    }

    #jadwal-pertunjukan .price-row:not(:last-child) {
        border-bottom: 1px solid rgba(26, 20, 69, 0.05);
    }

    #jadwal-pertunjukan .price-category {
        font-size: clamp(1.5rem, 2.5vw, 2rem);
        font-weight: 600;
        color: #1a1445;
        font-family: 'Libre Baskerville', serif;
    }

    #jadwal-pertunjukan .price-amount {
        font-size: 1.125rem;
        font-weight: 900;
        letter-spacing: 0.05em;
        color: #c4a47c;
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .bottom-info {
        max-width: 56rem;
        margin: 0 auto;
        padding-top: 4rem;
        border-top: 2px solid rgba(26, 20, 69, 0.1);
    }

    #jadwal-pertunjukan .stats-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 4rem 8rem;
        margin-bottom: 4rem;
        text-align: center;
    }

    #jadwal-pertunjukan .stat-item {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    #jadwal-pertunjukan .stat-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.4em;
        text-transform: uppercase;
        color: rgba(26, 20, 69, 0.5);
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .stat-value {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 600;
        color: #1a1445;
        font-family: 'Libre Baskerville', serif;
    }

    #jadwal-pertunjukan .minimal-group {
        display: flex;
        gap: 4rem;
        justify-content: center;
    }

    #jadwal-pertunjukan .minimal-stat {
        text-align: center;
    }

    #jadwal-pertunjukan .minimal-stat .stat-value {
        margin-bottom: 0.5rem;
    }

    #jadwal-pertunjukan .minimal-stat .sub-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: rgba(26, 20, 69, 0.5);
        font-family: 'Inter', sans-serif;
    }

    #jadwal-pertunjukan .note-box {
        max-width: 42rem;
        margin: 0 auto;
        padding: 2rem 2.5rem;
        background: transparent;
        color: #1a1445;
        /* warna teks */
        border: 1px solid currentColor;
        /* border ikut warna teks */
        text-align: center;
    }


    #jadwal-pertunjukan .note-box p {
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.8;
        color: #1a1445;
        font-family: 'Inter', sans-serif;
    }

    @media (max-width: 768px) {
        #jadwal-pertunjukan {
            padding: 5rem 1.5rem;
        }

        #jadwal-pertunjukan .schedule-cards-grid {
            grid-template-columns: 1fr;
        }

        #jadwal-pertunjukan .pricing-grid {
            grid-template-columns: 1fr;
        }

        #jadwal-pertunjukan .info-card {
            padding: 2rem 1.5rem;
        }

        #jadwal-pertunjukan .schedule-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1.25rem 0;
        }

        #jadwal-pertunjukan .stats-row {
            gap: 3rem;
        }

        #jadwal-pertunjukan .minimal-group {
            gap: 2rem;
        }

        #jadwal-pertunjukan .note-box {
            padding: 1.5rem;
        }
    }
</style>

<div style="height: 60px;"></div>
<!-- FINAL CTA — VISIT QATAR SPLIT STYLE -->
<!-- FINAL CTA — QATAR FULL BLEED STYLE -->
<section
    style="position: relative; width: 100%; overflow: hidden; min-height: 420px; display: flex; align-items: center; justify-content: center;">
    {{-- Background Image --}}
    <img src="{{ asset('img/Angklungmasal.webp') }}"
        style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;"
        loading="lazy" decoding="async" width="1920" height="800" alt="Pertunjukan Angklung Masal">

    {{-- Overlay Gelap — pakai inline style biar pasti kena --}}
    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.65);"></div>

    {{-- Konten --}}
    <div
        style="position: relative; z-index: 10; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 60px 1.5rem;">

        <h2 class="font-editorial"
            style="font-size: clamp(2.5rem, 6vw, 5rem); color: white; line-height: 1.15; margin-bottom: 2.5rem; max-width: 800px; text-shadow: 0 2px 20px rgba(0,0,0,0.4);">
            Jadilah saksi <br>
            <em>harmoni berikutnya.</em>
        </h2>

        <a href="https://angklung-udjo.co.id/tickets/buy" target="_blank" rel="noopener noreferrer"
            style="display: inline-block; padding: 1rem 3rem; background: transparent; color: white;
                  border: 1px solid white; font-size: 11px; font-weight: 700;
                  text-transform: uppercase; letter-spacing: 0.3em; text-decoration: none;
                  transition: all 0.3s ease;"
            onmouseover="this.style.background='white'; this.style.color='#1a1445';"
            onmouseout="this.style.background='transparent'; this.style.color='white';">
            Booking Sekarang Juga
        </a>

    </div>
</section>
<div style="height: 60px;"></div>


{{-- ================================================ --}}
{{-- SECTION JOURNAL - PERFORMANCES LAYOUT STYLE      --}}
{{-- ================================================ --}}
<section id="journal" class="py-32 overflow-hidden bg-[#F7F7F2]">
    <div class="full-bleed-right">
        <div class="grid lg:grid-cols-12 gap-10 items-start">

            <!-- SISI KIRI: Deskripsi Editorial (Visit Qatar Style) -->
            <div class="lg:col-span-3 pr-10 lg:pr-20 reveal">



                <!-- Judul: Sangat Besar, Leading Rapat, Kontras Tinggi -->
                <h2
                    class="font-editorial text-5xl md:text-6xl lg:text-7xl text-indigo-950 leading-[1] mb-12 tracking-tighter">
                    {{ __('home.news.title_line1') }} <br>
                    <span class="text-gold-premium italic font-normal font-editorial">
                        {{ __('home.news.title_line2') }}
                    </span>
                </h2>


                <!-- Deskripsi: Font-light, abu-abu halus, lebar dibatasi (Max-width) agar elegan -->
                <p class="text-gray-500 text-lg font-light leading-relaxed mb-14 max-w-xs">
                    {{ __('home.news.description') }}
                </p>

                <!-- CTA: Visit Qatar Style (Text + Animating Arrow) -->
                <a href="{{ route('articles.index') }}"
                    class="group inline-flex items-center gap-5 text-[11px] font-bold uppercase tracking-[0.3em] text-indigo-950 transition-all">
                    <span class="relative">
                        {{ __('home.performances.cta_all') ?? 'Eksplorasi Semua' }}
                        <!-- Underline tipis yang muncul dari tengah -->
                        <span
                            class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-indigo-950 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                    </span>

                    <!-- Ikon Panah Minimalis (Ciri Khas Visit Qatar) -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 transform transition-transform duration-500 group-hover:translate-x-3"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <!-- SISI KANAN: Slider Meluber (Full Bleed) -->
            <div class="lg:col-span-9">
                <div id="journalSlider" class="snap-slider gap-8">
                    @forelse($latestArticles as $article)
                        <div class="snap-item w-[80%] md:w-[40%] group cursor-pointer">
                            @if ($article->isExternal())
                                {{-- Jika eksternal, langsung ke URL eksternal --}}
                                <a href="{{ $article->external_url }}" target="_blank" rel="noopener noreferrer"
                                    class="block">
                                @else
                                    {{-- Jika internal, ke halaman show --}}
                                    <a href="{{ route('articles.show', $article->slug) }}" class="block">
                            @endif
                            <div class="qatar-card">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->title }}">
                                @endif

                                <div class="qatar-overlay">
                                    <h3 class="font-editorial text-2xl md:text-3xl leading-tight mb-4">
                                        {{ $article->title }}
                                        @if ($article->isExternal())
                                            <svg class="inline-block w-4 h-4 ml-2 opacity-70" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        @endif
                                    </h3>
                                    <p class="text-[10px] opacity-70 font-light line-clamp-2 mb-6 italic">
                                        {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}
                                    </p>

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-px bg-white/30 group-hover:w-12 group-hover:bg-gold-premium transition-all">
                                        </div>
                                        <span class="text-[8px] font-bold uppercase tracking-widest">
                                            {{ $article->isExternal() ? 'Baca di Sumber' : __('home.news.cta_read') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    @empty
                        <div class="w-full py-20 text-center border border-dashed border-gray-200 rounded-xl">
                            <p class="font-editorial italic text-gray-400">Menyusun manuskrip terbaru...</p>
                        </div>
                    @endforelse
                </div>

                <!-- Slider Controls (Bottom Right) -->
                <div class="flex justify-end gap-3 mt-12 pr-[10vw]">
                    <button onclick="navJournal('left')"
                        class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-indigo-950 hover:text-white transition flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button onclick="navJournal('right')"
                        class="w-14 h-14 rounded-full border border-gray-200 text-indigo-950 hover:bg-indigo-950 hover:text-white transition flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Fungsi navigasi yang disesuaikan dengan ID journalSlider
    function navJournal(direction) {
        const slider = document.getElementById('journalSlider');
        if (!slider) return;

        // Geser berdasarkan lebar container slider (sama dengan logika rangkaian pertunjukan)
        const scrollAmount = slider.clientWidth * (window.innerWidth < 768 ? 0.8 : 0.45);
        slider.scrollBy({
            left: direction === 'left' ? -scrollAmount : scrollAmount,
            behavior: 'smooth'
        });
    }
</script>


{{-- ================================================ --}}
{{-- SECTION TESTIMONI - FULLY RESPONSIVE             --}}
{{-- ================================================ --}}
<section class="py-16 md:py-32 overflow-hidden bg-[#F7F7F2]">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12">

        {{-- HEADER: Mobile (Centered) & Desktop (Spread) --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 md:mb-16 gap-10">

            {{-- Judul --}}
            <div class="reveal text-center lg:text-left">
                <h2 class="font-editorial text-4xl md:text-6xl text-indigo-950 leading-[1.1]">
                    {{ __('home.testimonials.title_line_1') }} <br><span
                        class="italic text-gold-premium font-normal text-3xl md:text-5xl">
                        {{ __('home.testimonials.title_line_2') }}</span>
                </h2>
            </div>

            {{-- Info Rating & Tombol (Muncul di Mobile & Desktop) --}}
            <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8 reveal"
                style="transition-delay: 200ms;">

                {{-- Rating Stats --}}
                <div class="flex flex-col items-center lg:items-end md:border-r md:border-gray-200 md:pr-8">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-4xl font-bold text-indigo-950 tracking-tighter">4.7</span>
                        <div class="flex flex-col">
                            <div class="flex gap-0.5">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-3.5 h-3.5 text-[#FABB05] fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <p
                                class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-1 text-center lg:text-right">
                                16,933 Google Reviews</p>
                        </div>
                    </div>
                </div>

                {{-- CTA Button --}}
                <a href="https://search.google.com/local/writereview?placeid=ChIJBYSGT5DnaC4RnEy6JfAzvO8"
                    target="_blank" class="btn-unesco-premium w-full md:w-auto text-center"
                    style="padding: 1rem 2.5rem;">
                    <span class="btn-content">
                        <span class="btn-text" style="font-size: 10px; letter-spacing: 0.2em;">
                            {{ __('home.testimonials.write_review') }}</span>
                    </span>
                    <div class="btn-border-outer"></div>
                </a>
            </div>
        </div>

        {{-- SLIDER CONTAINER --}}
        <div class="relative group">
            <div id="testiSlider"
                class="flex gap-6 md:gap-8 overflow-x-auto pb-12 hide-scrollbar snap-x snap-mandatory scroll-smooth items-stretch px-2">

                @forelse($testimonials as $index => $testimonial)
                    <div
                        class="flex-none w-[88%] md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.35rem)] snap-center h-auto">
                        <div
                            class="bg-white p-7 md:p-10 rounded-3xl border border-gray-100 shadow-[0_15px_40px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_50px_rgba(184,146,64,0.1)] hover:border-gold-premium/20 transition-all duration-500 h-full flex flex-col justify-between">

                            <div>
                                {{-- CARD HEADER --}}
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="relative shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-indigo-50 overflow-hidden border border-indigo-100/30">
                                            @if ($testimonial->image)
                                                <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-indigo-950 text-white font-bold text-xs uppercase">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="min-w-0">
                                        <h4
                                            class="font-bold text-indigo-950 text-xs md:text-sm tracking-wide uppercase truncate mb-0.5">
                                            {{ $testimonial->name }}</h4>
                                        <span
                                            class="text-[9px] text-gold-premium font-bold uppercase tracking-widest">{{ $testimonial->country ?? 'Verified Visitor' }}</span>
                                    </div>
                                </div>

                                {{-- STAR RATING --}}
                                <div class="flex gap-0.5 mb-5">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-3 h-3 text-[#FABB05] fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>

                                {{-- MESSAGE --}}
                                <div class="relative">
                                    <p id="msg-{{ $index }}"
                                        class="testimonial-msg text-indigo-950/80 text-sm md:text-base leading-[1.7] italic font-light line-clamp-4">
                                        "{{ $testimonial->message }}"
                                    </p>

                                    @if (strlen($testimonial->message) > 100)
                                        <button onclick="toggleMsg({{ $index }})"
                                            id="tog-{{ $index }}"
                                            class="mt-4 text-[9px] font-black tracking-[0.2em] text-indigo-950 hover:text-gold-premium transition-colors flex items-center gap-2">
                                            <span> {{ __('home.testimonials.read_more') }}</span>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-[8px] font-bold text-gray-300 uppercase tracking-[0.3em]">Verified
                                    Review</span>
                                <div class="flex gap-1">
                                    <div class="w-1 h-1 rounded-full bg-gold-premium/40"></div>
                                    <div class="w-1 h-1 rounded-full bg-gold-premium"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-10 text-gray-400 italic">Belum ada ulasan.</div>
                @endforelse
            </div>

            {{-- DESKTOP NAVIGATION --}}
            <button onclick="navTesti('left')"
                class="absolute top-1/2 -left-6 -translate-y-1/2 w-12 h-12 bg-white shadow-xl rounded-full flex items-center justify-center text-indigo-950 hover:bg-indigo-950 hover:text-white transition-all duration-300 z-10 hidden lg:flex border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button onclick="navTesti('right')"
                class="absolute top-1/2 -right-6 -translate-y-1/2 w-12 h-12 bg-white shadow-xl rounded-full flex items-center justify-center text-indigo-950 hover:bg-indigo-950 hover:text-white transition-all duration-300 z-10 hidden lg:flex border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        {{-- INDICATOR DOTS --}}

        <div id="testiDots" class="flex justify-center gap-2 mt-6"></div>
    </div>
</section>

<style>
    .testimonial-msg {
        transition: all 0.4s ease;
    }

    .testimonial-msg.expanded {
        -webkit-line-clamp: unset !important;
        line-clamp: unset !important;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .btn-unesco-premium {
        position: relative;
        background: #1a1445;
        color: white;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: inline-block;
        z-index: 1;
    }

    .btn-unesco-premium:hover {
        background: #b89240;
        transform: translateY(-2px);
    }

    /* Dot Active State */
    .dot-active {
        width: 2rem !important;
        background-color: #1a1445 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('testiSlider');
        const dotsContainer = document.getElementById('testiDots');
        const items = slider.querySelectorAll('.flex-none');

        // Create Dots based on items
        items.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = 'w-2 h-1.5 bg-gray-300 rounded-full transition-all duration-300';
            if (i === 0) dot.classList.add('dot-active');
            dotsContainer.appendChild(dot);
        });

        // Update Dots on Scroll
        slider.addEventListener('scroll', () => {
            const scrollPos = slider.scrollLeft;
            const cardWidth = items[0].offsetWidth;
            const activeIndex = Math.round(scrollPos / cardWidth);

            const dots = dotsContainer.querySelectorAll('div');
            dots.forEach((dot, i) => {
                if (i === activeIndex) dot.classList.add('dot-active');
                else dot.classList.remove('dot-active');
            });
        });
    });

    function toggleMsg(idx) {
        const msg = document.getElementById('msg-' + idx);
        const btn = document.getElementById('tog-' + idx);
        if (msg.classList.contains('expanded')) {
            msg.classList.remove('expanded');
            btn.innerHTML = '<span>Baca Selengkapnya</span>';
        } else {
            msg.classList.add('expanded');
            btn.innerHTML = '<span>  {{ __('home.testimonials.hide') }}</span>';
        }
    }

    function navTesti(direction) {
        const slider = document.getElementById('testiSlider');
        const cardWidth = slider.querySelector('.flex-none').offsetWidth + 32;
        slider.scrollBy({
            left: direction === 'left' ? -cardWidth : cardWidth,
            behavior: 'smooth'
        });
    }
</script>

{{-- ================================================ --}}
{{-- SECTION: FAQ - Saung Angklung Udjo Style        --}}
{{-- Taruh setelah section Testimoni,                --}}
{{-- sebelum section Essentials                      --}}
{{-- ================================================ --}}

<section id="faq" class="py-32 bg-[#F7F7F2] border-t border-gray-100 overflow-hidden">
    <div class="max-w-[1200px] mx-auto px-6 md:px-12 lg:px-20">

        <div class="flex flex-col lg:flex-row gap-20 lg:gap-32 items-start">

            {{-- ── SISI KIRI: Header ── --}}
            <div class="w-full lg:w-5/12 lg:sticky lg:top-32 reveal">
                <p class="text-[10px] font-bold tracking-[0.5em] text-gold-premium uppercase mb-6">
                    {{ __('home.faq.eyebrow') }}
                </p>
                <h2 class="font-editorial text-5xl md:text-6xl text-indigo-950 leading-[1.1] mb-8">
                    {{ __('home.faq.title_1') }} <br>
                    <span class="italic text-gold-premium font-normal">{{ __('home.faq.title_2') }}</span>
                </h2>
                <p class="text-gray-400 text-base font-light leading-relaxed mb-12 max-w-sm">
                    {{ __('home.faq.desc') }}
                </p>

                {{-- CTA WhatsApp --}}
                <a href="https://wa.me/6282182821200" target="_blank"
                    class="group inline-flex items-center gap-5 text-[11px] font-bold uppercase tracking-[0.3em] text-indigo-950 transition-all">
                    <span class="relative">
                        {{ __('home.faq.cta') }}
                        <span
                            class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-indigo-950 transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 transform transition-transform duration-500 group-hover:translate-x-3"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            {{-- ── SISI KANAN: Accordion FAQ ── --}}
            <div class="w-full lg:w-7/12 reveal" style="transition-delay: 200ms;">

                @php
                    $faqs = __('home.faq.items');
                @endphp

                <div class="faq-list">
                    @foreach ($faqs as $i => $faq)
                        <div class="faq-item {{ $i === 0 ? 'active' : '' }}" onclick="toggleFaq(this)">
                            <div class="faq-question">
                                <span>{{ $faq['q'] }}</span>
                                <div class="faq-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            <div class="faq-answer">
                                <p>{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    /* ── FAQ List ── */
    .faq-list {
        display: flex;
        flex-direction: column;
        border-top: 1px solid rgba(26, 20, 69, 0.08);
    }

    .faq-item {
        border-bottom: 1px solid rgba(26, 20, 69, 0.08);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .faq-item:hover {
        background: rgba(196, 164, 124, 0.03);
    }

    /* ── Question Row ── */
    .faq-question {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 0;
        user-select: none;
    }

    .faq-question span {
        font-size: 15px;
        font-weight: 600;
        color: #1a1445;
        line-height: 1.5;
        font-family: 'Inter', sans-serif;
        transition: color 0.3s ease;
    }

    .faq-item:hover .faq-question span,
    .faq-item.active .faq-question span {
        color: #c4a47c;
    }

    /* ── Icon ── */
    .faq-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid rgba(26, 20, 69, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        color: #1a1445;
    }

    .faq-icon svg {
        width: 14px;
        height: 14px;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .faq-item.active .faq-icon {
        background: #c4a47c;
        border-color: #c4a47c;
        color: white;
    }

    /* Rotasi icon saat aktif */
    .faq-item.active .faq-icon svg {
        transform: rotate(90deg);
    }

    /* ── Answer ── */
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1), padding 0.4s ease;
    }

    .faq-item.active .faq-answer {
        max-height: 300px;
        padding-bottom: 24px;
    }

    .faq-answer p {
        font-size: 14px;
        color: rgba(26, 20, 69, 0.6);
        line-height: 1.8;
        font-weight: 400;
        font-family: 'Inter', sans-serif;
        padding-right: 56px;
    }

    /* ── Highlight line kiri saat active ── */
    .faq-item.active {
        padding-left: 16px;
        border-left: 2px solid #c4a47c;
        margin-left: -1px;
    }

    @media (max-width: 768px) {
        .faq-answer p {
            padding-right: 0;
        }

        .faq-item.active {
            padding-left: 12px;
        }

        .faq-question span {
            font-size: 14px;
        }
    }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    function initScheduleSlider(sliderId, dotsId) {
        const slider = document.getElementById(sliderId);
        const dots = document.querySelectorAll('#' + dotsId + ' .sch-dot');
        if (!slider) return;

        slider.addEventListener('scroll', () => {
            if (window.innerWidth >= 768) return;
            const cards = slider.querySelectorAll('.info-card');
            const leftRef = slider.getBoundingClientRect().left;
            let activeIdx = 0, minDist = Infinity;
            cards.forEach((card, i) => {
                const dist = Math.abs(card.getBoundingClientRect().left - leftRef);
                if (dist < minDist) { minDist = dist; activeIdx = i; }
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === activeIdx));
        });
    }

    function autoPlaySlider(sliderId) {
        if (window.innerWidth >= 768) return;

        const slider = document.getElementById(sliderId);
        if (!slider) return;

        const cards = slider.querySelectorAll('.info-card');
        if (cards.length === 0) return;

        let currentIndex = 0;
        let interval = null;
        let userInteracted = false; // ← flag swipe manual

        function goNext() {
            currentIndex++;
            if (currentIndex >= cards.length) currentIndex = 0;
            cards[currentIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
        }

        function startAuto() {
            if (interval || userInteracted) return; // ← tidak start kalau sudah diswipe
            interval = setInterval(goNext, 3000);
        }

        function stopAuto() {
            clearInterval(interval);
            interval = null;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startAuto();
                } else {
                    stopAuto();
                    // Reset flag & posisi saat keluar viewport
                    userInteracted = false;
                    currentIndex = 0;
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                }
            });
        }, { threshold: 0.4 });

        observer.observe(slider);

        // Swipe manual → stop & tidak resume
        slider.addEventListener('touchstart', () => {
            stopAuto();
            userInteracted = true;
        }, { passive: true });
    }

    initScheduleSlider('scheduleSlider1', 'scheduleDots1');
    initScheduleSlider('scheduleSlider2', 'scheduleDots2');

    autoPlaySlider('scheduleSlider1');
    autoPlaySlider('scheduleSlider2');
});
    function toggleFaq(item) {
        const isActive = item.classList.contains('active');

        // Tutup semua
        document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));

        // Buka yang diklik (kecuali kalau sudah aktif → toggle tutup)
        if (!isActive) {
            item.classList.add('active');
        }
    }
</script>


<!-- SECTION: ESSENTIALS -->
<section class="py-32 border-t border-gray-100 bg-[#F7F7F2]">
    <div class="max-w-[1400px] mx-auto">

        <div class="text-center mb-16 px-10 reveal">
            <h2 class="font-editorial text-2xl md:text-4xl text-indigo-950 leading-tight tracking-normal">
                {{ __('home.essentials.title') }}
            </h2>
        </div>

        {{-- Grid desktop / Slider mobile --}}
        <div id="essSlider"
            class="essentials-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 md:gap-12 px-10">

            <div class="essentials-item reveal flex flex-col items-center text-center group">
                <div class="mb-8 transform group-hover:scale-110 transition-transform duration-500">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1a1445"
                        stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <h3 class="font-editorial text-2xl text-indigo-950 mb-4">{{ __('home.essentials.access_title') }}
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed font-light mb-6 px-4">
                    {{ __('home.essentials.access_desc') }}</p>
                <a href="{{ route('heritage.venue') }}#mapslokasi"
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-950 border-b border-indigo-950/20 pb-1 hover:text-gold-premium hover:border-gold-premium transition-all">
                    {{ __('home.essentials.read_more') }}
                </a>
            </div>

            <div class="essentials-item reveal flex flex-col items-center text-center group"
                style="transition-delay:150ms">
                <div class="mb-8 transform group-hover:scale-110 transition-transform duration-500">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1a1445"
                        stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h3 class="font-editorial text-2xl text-indigo-950 mb-4">{{ __('home.essentials.time_title') }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed font-light mb-6 px-4">
                    {{ __('home.essentials.time_desc') }}</p>
                <a href="#"
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-950 border-b border-indigo-950/20 pb-1 hover:text-gold-premium hover:border-gold-premium transition-all">
                    {{ __('home.essentials.read_more') }}
                </a>
            </div>

            <div class="essentials-item reveal flex flex-col items-center text-center group"
                style="transition-delay:300ms">
                <div class="mb-8 transform group-hover:scale-110 transition-transform duration-500">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1a1445"
                        stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M12 3l1.545 4.635L18.18 9.18l-4.635 1.545L12 15.36l-1.545-4.635L5.82 9.18l4.635-1.545L12 3z">
                        </path>
                        <path d="M6 3l.75 2.25L9 6l-2.25.75L6 9l-.75-2.25L3 6l2.25-.75L6 3z"></path>
                        <path d="M18 15l.75 2.25L21 18l-2.25.75L18 21l-.75-2.25L15 18l2.25-.75L18 15z"></path>
                    </svg>
                </div>
                <h3 class="font-editorial text-2xl text-indigo-950 mb-4">{{ __('home.essentials.tips_title') }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed font-light mb-6 px-4">
                    {{ __('home.essentials.tips_desc') }}</p>
                <a href="#"
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-950 border-b border-indigo-950/20 pb-1 hover:text-gold-premium hover:border-gold-premium transition-all">
                    {{ __('home.essentials.read_more') }}
                </a>
            </div>

            <div class="essentials-item reveal flex flex-col items-center text-center group"
                style="transition-delay:450ms">
                <div class="mb-8 transform group-hover:scale-110 transition-transform duration-500">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#1a1445"
                        stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                    </svg>
                </div>
                <h3 class="font-editorial text-2xl text-indigo-950 mb-4">{{ __('home.essentials.explore_title') }}
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed font-light mb-6 px-4">
                    {{ __('home.essentials.explore_desc') }}</p>
                <a href="#"
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-950 border-b border-indigo-950/20 pb-1 hover:text-gold-premium hover:border-gold-premium transition-all">
                    {{ __('home.essentials.read_more') }}
                </a>
            </div>

            {{-- Spacer kanan (mobile only) --}}
            <div class="essentials-spacer hidden" aria-hidden="true"></div>
        </div>

        {{-- Dots (mobile only) --}}
        <div id="essDots" class="essentials-dots gap-1.5 px-6 mt-5">
            <div class="ess-dot active"></div>
            <div class="ess-dot"></div>
            <div class="ess-dot"></div>
            <div class="ess-dot"></div>
        </div>
    </div>
</section>

<style>
    .essentials-item {}

    .essentials-spacer {
        display: none;
    }

    .essentials-dots {
        display: none;
    }

    .ess-dot {
        height: 2px;
        border-radius: 2px;
        background: rgba(26, 20, 69, 0.15);
        transition: all 0.35s ease;
        width: 20px;
    }

    .ess-dot.active {
        background: #1a1445;
        width: 36px;
    }

    @media (max-width: 767px) {
        .essentials-grid {
            display: flex !important;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
            padding: 0 1.5rem !important;
            gap: 1rem;
        }

        .essentials-grid::-webkit-scrollbar {
            display: none;
        }

        .essentials-item {
            flex: 0 0 72vw;
            max-width: 240px;
            scroll-snap-align: start;
            background: #F7F7F2 !important;

            border-radius: 16px;
            padding: 2rem 1.25rem !important;
        }

        .essentials-spacer {
            display: block !important;
            flex: 0 0 0.5rem;
        }

        .essentials-dots {
            display: flex !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('essSlider');
        const dots = document.querySelectorAll('.ess-dot');
        if (!slider) return;
        slider.addEventListener('scroll', () => {
            if (window.innerWidth >= 768) return;
            const cards = slider.querySelectorAll('.essentials-item');
            const left = slider.getBoundingClientRect().left;
            let activeIdx = 0,
                minDist = Infinity;
            cards.forEach((c, i) => {
                const dist = Math.abs(c.getBoundingClientRect().left - left);
                if (dist < minDist) {
                    minDist = dist;
                    activeIdx = i;
                }
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === activeIdx));
        });
    });
</script>

@push('scripts')
    <script>
        // Function untuk scroll Performance/Rangkaian Pertunjukan
        function scrollPerf(direction) {
            const slider = document.getElementById('perfSlider');
            const scrollAmount = slider.clientWidth * (window.innerWidth < 768 ? 0.8 : 0.45);
            slider.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }

        function scrollTesti(dir) {
            const slider = document.getElementById('testiSlider');
            const amt = slider.clientWidth * (window.innerWidth < 768 ? 0.85 : 0.45);
            slider.scrollBy({
                left: dir === 'left' ? -amt : amt,
                behavior: 'smooth'
            });
        }

        // Reveal Animation Observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.15
            });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });

        // Slider Functions
        function scrollSlider(dir) {
            const slider = document.getElementById('eventSlider');
            const amt = slider.clientWidth * 0.9;
            slider.scrollBy({
                left: dir === 'left' ? -amt : amt,
                behavior: 'smooth'
            });
        }

        function scrollNews(direction) {
            const slider = document.getElementById('newsSlider');
            const scrollAmount = slider.clientWidth * (window.innerWidth < 768 ? 0.85 : 0.35);
            slider.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>
@endpush

{{-- SCRIPTS --}}

@push('scripts')
    <script>
        function scrollTesti(dir) {
            const slider = document.getElementById('testiSlider');
            const amt = slider.clientWidth * (window.innerWidth < 768 ? 0.85 : 0.45);
            slider.scrollBy({
                left: dir === 'left' ? -amt : amt,
                behavior: 'smooth'
            });
        }
        // Reveal Animation Observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.15
            });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });

        // Slider Functions
        function scrollSlider(dir) {
            const slider = document.getElementById('eventSlider');
            const amt = slider.clientWidth * 0.9;
            slider.scrollBy({
                left: dir === 'left' ? -amt : amt,
                behavior: 'smooth'
            });
        }


        function scrollNews(direction) {
            const slider = document.getElementById('newsSlider');
            const scrollAmount = slider.clientWidth * (window.innerWidth < 768 ? 0.85 : 0.35);
            slider.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection

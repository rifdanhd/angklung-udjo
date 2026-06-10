{{-- resources/views/heritage/sau-history.blade.php --}}
@extends('layouts.app')

@section('title', 'Sejarah Saung Angklung Udjo | Warisan Budaya Dunia')

@section('content')
@section('title', __('history.meta_title'))

    @push('styles')
        <link
            href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600;800&display=swap"
            rel="stylesheet">
            
        <style>
            :root {
                --q-maroon: #831633;
                --q-gold: #c4a47c;
                --q-cream: #FAF8F4;
                --q-navy: #1a1445;
                --q-text: #333333;
                 --bg-premium: #F7F7F2;
                 --bg-brand: #22185d;
                --indigo-deep: var(--q-navy);
                --gold-premium: var(--q-gold);
                --qatar-maroon: var(--q-maroon);
            }

            body {
                background-color: var(--bg-premium) !important;
                color: var(--q-text);
                font-family: 'Inter', sans-serif;
                -webkit-font-smoothing: antialiased;
                overflow-x: hidden;
            }

            .font-serif { font-family: 'Libre Baskerville', serif; }
            .font-editorial { font-family: 'Libre Baskerville', serif; }

            .v-container {
                max-width: 1140px;
                margin: 0 auto;
                padding: 0 24px;
                position: relative;
            }

            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal.active {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .q-frame {
                position: relative;
                background: #fff;
                padding: 0;
                overflow: hidden;
            }

            .q-frame img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 1.2s ease;
            }

            .q-frame:hover img { transform: scale(1.05); }

            .q-quote {
                font-family: 'Libre Baskerville', serif;
                font-size: 1.5rem;
                line-height: 1.6;
                color: var(--q-navy);
                margin-bottom: 2rem;
                font-weight: 400;
                opacity: 0.9;
            }

            .q-text {
                font-size: 1.1rem;
                line-height: 1.8;
                color: #666;
                font-weight: 300;
            }

            .hero-history {
                height: 85vh;
                background: #000;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
            }
            /* Tambahkan di dalam <style> */
.hero-slide {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    opacity: 0;
    transform: scale(1);
    transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1), transform 10s linear;
    z-index: 1;
}

.hero-slide.active {
    opacity: 0.5;
    transform: scale(1.1); /* ← zoom perlahan seperti home */
    z-index: 2;
}

.hero-history > img:not(.hero-slide) {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.5;
    object-position: top;
    z-index: 1;
}
           

            .hero-title {
                position: relative;
                z-index: 10;
                color: white;
                text-align: center;
            }

            .hero-title h1 {
                font-size: clamp(3.5rem, 9vw, 6.5rem);
                line-height: 1;
                margin-bottom: 20px;
                font-weight: 400;
            }

            .hero-subtitle {
                text-transform: uppercase;
                letter-spacing: 0.6em;
                font-size: 0.9rem;
                font-weight: 300;
                opacity: 0.8;
            }

            .section-label {
                text-transform: uppercase;
                letter-spacing: 0.4em;
                font-size: 0.7rem;
                font-weight: 800;
                color: var(--q-gold);
                margin-bottom: 30px;
                display: block;
            }

            .main-heading {
                font-size: clamp(2.2rem, 5vw, 3.5rem);
                line-height: 1.15;
                margin-bottom: 60px;
                color: var(--q-navy);
            }

            .main-heading span {
                color: var(--q-gold);
                font-style: italic;
            }

            .history-block {
                padding: 100px 0;
                position: relative;
                overflow: hidden;
            }

            .big-year {
                font-size: 13rem;
                font-weight: 900;
                color: rgba(26, 20, 69, 0.03);
                position: absolute;
                top: 20px;
                left: -30px;
                z-index: -1;
                line-height: 1;
            }

            .history-image-wrap {
                position: relative;
                border-radius: 4px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            }

            .history-image-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .slider-container {
                padding: 100px 0;
                overflow: hidden;
            }

            .v-slider {
                display: flex;
                gap: 24px;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 40px;
                scroll-padding-left: calc((100vw - 1140px) / 2);
            }

            .v-slider::-webkit-scrollbar { display: none; }

            .v-card {
                scroll-snap-align: start;
                flex: 0 0 380px;
                aspect-ratio: 3 / 5;
                height: auto;
                border-radius: 1rem;
                overflow: hidden;
                position: relative;
                background: var(--indigo-deep);
                cursor: pointer;
            }

            .v-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 1.6s ease, filter 1.2s ease, opacity 1.2s ease;
                opacity: 0.88;
                filter: grayscale(35%);
                will-change: transform, filter;
            }

            .v-card:hover img {
                transform: scale(1.08);
                filter: grayscale(0%);
                opacity: 1;
            }

            .v-card-content {
                position: absolute;
                inset: 0;
                padding: 2.2rem;
                background: linear-gradient(to top,
                        rgba(0, 0, 0, 0.82) 0%,
                        rgba(0, 0, 0, 0.25) 45%,
                        transparent 100%);
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                color: #fff;
            }

            .v-card-content p {
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.35em;
                font-weight: 800;
                color: var(--gold-premium);
                margin-bottom: 10px;
            }

            .v-card-content h4 {
                font-size: 1.9rem;
                line-height: 1.15;
                margin-bottom: 10px;
                font-family: 'Libre Baskerville', serif;
                font-weight: 400;
            }

            .v-card-content span {
                font-size: 12px;
                line-height: 1.7;
                opacity: 0.8;
                font-weight: 300;
            }

            .q-btn-circle {
                width: 56px;
                height: 56px;
                border-radius: 999px;
                border: 1px solid rgba(26, 20, 69, 0.18);
                display: flex;
                align-items: center;
                justify-content: center;
                transition: 0.35s;
                cursor: pointer;
                background: #fff;
                user-select: none;
            }

            .q-btn-circle:hover {
                background: var(--indigo-deep);
                color: #fff;
                border-color: var(--indigo-deep);
            }

            .unesco-block {
                background: var(--q-navy);
                color: white;
                padding: 50px 0;
            }

            .q-btn-primary {
                display: inline-block;
                padding: 20px 50px;
                background: var(--q-maroon);
                color: white;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                text-decoration: none;
                transition: 0.4s;
                font-size: 0.85rem;
            }

            @media (max-width: 992px) {
                .v-card { flex: 0 0 300px; }
                .main-heading { font-size: 2.2rem; }
            }
        </style>
    @endpush

    <!-- 1. HERO UTAMA -->
  <!-- 1. HERO UTAMA -->
@php
    $heroSlides = \App\Models\HistorySlide::where('is_active', true)
                    ->orderBy('order')
                    ->get();
    $hasSlides = $heroSlides->isNotEmpty();
@endphp

<section class="hero-history" id="hero-history">

    {{-- Jika ada slide dari database, tampilkan carousel --}}
    @if($hasSlides)
        @foreach($heroSlides as $i => $slide)
            <img src="{{ asset('storage/' . $slide->image_path) }}"
                 alt="{{ $slide->alt_text ?? 'Sejarah Saung Angklung Udjo' }}"
                 class="hero-slide">
                
        @endforeach

    {{-- Fallback ke gambar statis jika belum ada slide --}}
    @else
        <img src="{{ asset('images/BGUDJOBIO.jpeg') }}"
             alt="Biografi Udjo Ngalagena"
             style="z-index: 1;">
    @endif

    {{-- Dots indicator (hanya tampil jika lebih dari 1 slide) --}}
    @if($hasSlides && $heroSlides->count() > 1)
        <div style="position:absolute;bottom:32px;left:50%;transform:translateX(-50%);display:flex;gap:8px;z-index:20;">
            @foreach($heroSlides as $i => $slide)
                <div class="hero-dot" data-index="{{ $i }}"
                     style="width:{{ $i === 0 ? '24px' : '8px' }};height:8px;border-radius:999px;
                            background:{{ $i === 0 ? '#fff' : 'rgba(255,255,255,0.4)' }};
                            transition:all .4s ease;cursor:pointer;">
                </div>
            @endforeach
        </div>
    @endif

    <div class="hero-title" style="z-index:10;">
        <p class="hero-subtitle reveal">{{ __('history.hero.subtitle') }}</p>
        <h1 class="font-serif reveal">{{ __('history.hero.title') }}</h1>
    </div>
</section>

    <!-- BAB I: FONDASI (1966) -->
    <section class="history-block">
        <div class="v-container">
            <div class="grid md:grid-cols-12 gap-16 items-center">
                <div class="md:col-span-6 reveal">
                    <div class="udjo-figure">
                        <img src="{{ asset('images/abah-udjo-legend.webp') }}" alt="Udjo & Uum">
                    </div>
                </div>
                <div class="md:col-span-6 reveal">
                    <span class="section-label">{{ __('history.founding.eyebrow') }}</span>
                    <h3 class="font-editorial" style="font-size: 3rem; margin-bottom: 30px; color: var(--q-navy);">
                        {{ __('history.founding.title_1') }} <br>
                        <span style="color: var(--q-navy); font-style: italic;">{{ __('history.founding.title_2') }}</span>
                    </h3>
                    <p style="font-size: 1.15rem; line-height: 1.9; color: #666; margin-bottom: 24px;">
                        {!! __('history.founding.desc_1') !!}
                    </p>
                    <p style="font-size: 1.15rem; line-height: 1.9; color: #666;">
                        {{ __('history.founding.desc_2') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: THE FAMILY LEGACY -->
    <section class="history-block" style="padding: 120px 0;">
        <div class="v-container">
            <div class="grid md:grid-cols-12 gap-12 items-start">
                <div class="md:col-span-6 reveal">
                    <div class="q-frame" style="aspect-ratio: 4/3;">
                        <img src="{{ asset('images/3.the history.jpg') }}" alt="Keluarga Udjo Ngalagena">
                    </div>
                    <div class="q-frame" style="aspect-ratio: 4/3;">
                        <img src="{{ asset('images/kumpul6.jpg') }}" alt="Keluarga Udjo Ngalagena">
                    </div>
                    <p class="section-label" style="margin-top: 30px; font-size: 0.6rem; opacity: 0.5;">
                        {{ __('history.family_legacy.archive_label') }}
                    </p>
                </div>

                <div class="md:col-span-6 reveal" style="padding-top: 40px;">
                    <span class="big-year" style="font-size: 10rem; opacity: 0.03;">1960</span>
                    <span class="section-label">{{ __('history.family_legacy.eyebrow') }}</span>

                    <h2 class="font-editorial"
                        style="font-size: 3rem; margin-bottom: 40px; color: var(--q-navy); font-style: normal;">
                        {{ __('history.family_legacy.title_1') }} <br>
                        <span style="color: var(--q-navy); font-style: italic;">{{ __('history.family_legacy.title_2') }}</span>
                    </h2>

                    <div class="q-quote italic">
                        {{ __('history.family_legacy.quote') }}
                    </div>

                    <p class="q-text">
                        {{ __('history.family_legacy.desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: COMMUNITY FOUNDATION -->
    <section class="history-block" style="border-bottom: 1px solid #f0f0f0;">
        <div class="v-container text-center">
            <div class="reveal" style="max-width: 1000px; margin: 0 auto 80px;">
                <span class="section-label">{{ __('history.community.eyebrow') }}</span>
                <h3 class="font-editorial"
                    style="font-size: clamp(1.5rem, 4vw, 2.2rem); line-height: 1.6; color: var(--q-navy); font-weight: 400;">
                    {{ __('history.community.quote') }}
                </h3>
            </div>

            <div class="grid md:grid-cols-2 gap-8 reveal">
                <div class="history-image-wrap" style="aspect-ratio: 3/2; box-shadow: 0 15px 40px rgba(0,0,0,0.04);">
                    <img src="{{ asset('images/kumpul.webp') }}" alt="Awal Komunitas Padasuka"
                        onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1200'">
                </div>
                <div class="history-image-wrap" style="aspect-ratio: 3/2; box-shadow: 0 15px 40px rgba(0,0,0,0.04);">
                    <img src="{{ asset('images/kumpul2.webp') }}" alt="Pendidikan Angklung Dini"
                        onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1200'">
                </div>
            </div>

            <div class="reveal" style="max-width: 800px; margin: 60px auto 0; text-align: left;"></div>
        </div>
    </section>

    <!-- SECTION: KAULINAN URANG LEMBUR -->
    <section class="history-block" style="border-bottom: 1px solid #f0f0f0;">
        <div class="v-container">
            <div class="grid md:grid-cols-12 gap-16 items-center">
                <div class="md:col-span-5 reveal">
                    <span class="section-label">{{ __('history.kaulinan.eyebrow') }}</span>
                    <h2 class="font-editorial"
                        style="font-size: clamp(2.2rem, 4vw, 3rem); line-height: 1.1; color: var(--q-navy); margin-bottom: 35px;">
                        {{ __('history.kaulinan.title_1') }} <br>
                        <span style="color: var(--q-navy); font-style: italic;">{{ __('history.kaulinan.title_2') }}</span>
                    </h2>

                    <p class="content-text"
                        style="font-size: 1.2rem; line-height: 1.8; color: var(--q-navy); opacity: 0.85; margin-bottom: 30px; font-style: italic;">
                        {{ __('history.kaulinan.quote') }}
                    </p>

                    <p class="content-text" style="font-size: 1.1rem; color: #666;">
                        {{ __('history.kaulinan.desc') }}
                    </p>
                </div>

                <div class="md:col-span-7 reveal">
                    <div class="history-image-wrap" style="aspect-ratio: 16/8; box-shadow: 0 30px 60px rgba(0,0,0,0.05);">
                        <img src="{{ asset('images/tampil.webp') }}" alt="Konsep Kaulinan Urang Lembur"
                            onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1200'">
                    </div>
                    <p class="section-label" style="margin-top: 20px; font-size: 0.6rem; text-align: right; opacity: 0.5;">
                        {{ __('history.kaulinan.doc_label') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: NARASI PERJUANGAN ABAH UDJO -->
    <section class="py-24">
        <div class="max-w-[1200px] mx-auto px-10 grid md:grid-cols-2 gap-16 items-center">

            <div class="relative overflow-hidden rounded-2xl shadow-lg">
                <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                    <source src="{{ asset('Video/MOTION PAK UDJO NAIK SEPEDA.mp4') }}" type="video/mp4">
                    {{ __('history.journey.video_unsupported') }}
                </video>
            </div>

            <div>
                <span class="section-label">{{ __('history.journey.eyebrow') }}</span>
                <blockquote class="text-lg md:text-xl leading-relaxed text-gray-700">
                    {{ __('history.journey.quote') }}
                </blockquote>
            </div>

        </div>
    </section>

    <!-- SECTION: FOUNDING STATEMENT -->
    <section class="py-32">
        <div class="max-w-[900px] mx-auto px-10 text-center">

            <span class="section-label">{{ __('history.founder_statement.eyebrow') }}</span>

            <blockquote class="font-serif text-2xl md:text-3xl leading-relaxed text-[#22185d]">
                {{ __('history.founder_statement.quote') }}
            </blockquote>

            <p class="mt-10 text-sm uppercase tracking-[0.35em] text-gray-500">
                {{ __('history.founder_statement.author') }}
            </p>

        </div>
    </section>

    <!-- VIDEO SECTION -->
    <section style="padding: 120px 0;">
        <div class="v-container">
            <div class="reveal" style="max-width: 1200px; margin: 0 auto;">
                <div style="position: relative; width: 100%; padding-bottom: 56.25%; background: #000; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        src="https://www.youtube.com/embed/TMmAfWH3x_8" title="Saung Angklung Udjo" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>
                <p style="text-align: center; margin-top: 24px; font-size: 0.95rem; color: #888; font-style: italic;">
                    {{ __('history.video.caption') }}
                </p>
            </div>
        </div>
    </section>

    <!-- UNESCO -->
    <section class="unesco-block">
        <div class="v-container">
            <div class="grid md:grid-cols-12 gap-16 items-center">
                <div class="md:col-span-6 reveal">
                    <div style="border: 1px solid rgba(255,255,255,0.2); padding: 20px; text-align: center;">
                        <img src="{{ asset('images/PenghargaanUNESCO.jpg') }}" alt="UNESCO Recognition"
                            style="width: 100%; height: auto; display: block; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        <p class="section-label" style="color: var(--q-gold); margin-bottom: 0; letter-spacing: 3px;">
                            {{ __('history.unesco.inscribed') }}
                        </p>
                    </div>
                </div>

                <div class="md:col-span-6 reveal">
                    <span class="section-label" style="color: var(--q-gold);">{{ __('history.unesco.eyebrow') }}</span>
                    <h2 class="font-editorial"
                        style="font-size: clamp(2.5rem, 5vw, 3.5rem); line-height: 1.1; margin-bottom: 30px;">
                        {{ __('history.unesco.title_1') }} <br>
                        <span style="color: white; font-style: italic;">{{ __('history.unesco.title_2') }}</span>
                    </h2>
                    <p style="font-size: 1.25rem; line-height: 2; opacity: 0.8; font-weight: 300;">
                        {{ __('history.unesco.desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SLIDER: JEJAK PRESIDEN -->
    <section class="slider-container">
        <div class="v-container">
            <div class="reveal" style="margin-bottom: 60px;">
                <span class="section-label">{{ __('history.diplomacy.eyebrow') }}</span>
                <h2 class="font-editorial" style="font-size: 3.5rem; color: var(--indigo-deep);">
                    {{ __('history.diplomacy.title') }}
                </h2>
            </div>
        </div>

        <div id="presSlider" class="v-slider" style="padding-left: calc((100vw - 1140px) / 2);">
            @php
                $presidents = [
                    ['img' => 'soe.jpg',        'name' => __('history.diplomacy.presidents.0.name'), 'title' => __('history.diplomacy.presidents.0.title'), 'desc' => __('history.diplomacy.presidents.0.desc')],
                    ['img' => 'suharto.jpg',     'name' => __('history.diplomacy.presidents.1.name'), 'title' => __('history.diplomacy.presidents.1.title'), 'desc' => __('history.diplomacy.presidents.1.desc')],
                    ['img' => 'habibie.jpg',     'name' => __('history.diplomacy.presidents.2.name'), 'title' => __('history.diplomacy.presidents.2.title'), 'desc' => __('history.diplomacy.presidents.2.desc')],
                    ['img' => 'MEGAWATI.jpeg',   'name' => __('history.diplomacy.presidents.3.name'), 'title' => __('history.diplomacy.presidents.3.title'), 'desc' => __('history.diplomacy.presidents.3.desc')],
                    ['img' => 'sby.jpg',         'name' => __('history.diplomacy.presidents.4.name'), 'title' => __('history.diplomacy.presidents.4.title'), 'desc' => __('history.diplomacy.presidents.4.desc')],
                    ['img' => 'JOKOWI.JPG',      'name' => __('history.diplomacy.presidents.5.name'), 'title' => __('history.diplomacy.presidents.5.title'), 'desc' => __('history.diplomacy.presidents.5.desc')],
                    ['img' => 'wowo.jpg',        'name' => __('history.diplomacy.presidents.6.name'), 'title' => __('history.diplomacy.presidents.6.title'), 'desc' => __('history.diplomacy.presidents.6.desc')],
                ];
            @endphp

            @foreach ($presidents as $p)
                <div class="v-card reveal">
                    <img src="{{ asset('PRESIDENT/' . $p['img']) }}"
                        onerror="this.src='https://images.unsplash.com/photo-1531050171669-014464ce5001?q=80&w=1000'">
                    <div class="v-card-content">
                        <p>{{ $p['title'] }}</p>
                        <h4>{{ $p['name'] }}</h4>
                        <span>{{ $p['desc'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="v-container">
            <div class="flex gap-4 mt-8">
                <div onclick="scrollSlider('presSlider', 'left')" class="q-btn-circle">←</div>
                <div onclick="scrollSlider('presSlider', 'right')" class="q-btn-circle">→</div>
            </div>
        </div>
    </section>

    <!-- SECTION: MILESTONE -->
    <section class="section-padding" style="border-top: 1px solid #f2f2f2;">
        <div class="v-container">
            <div class="grid md:grid-cols-12 gap-8 mb-24">
                <div class="md:col-span-8 reveal"></div>
                <div class="md:col-span-4 reveal md:flex md:align-end"></div>
            </div>

            <div class="grid md:grid-cols-12 gap-20">
                <div class="md:col-span-8 reveal">
                    <div style="display: flex; flex-direction: column; gap: 80px;">

                        @php
                            $milestones = [
                                ['year' => __('history.milestone.items.0.year'), 'title' => __('history.milestone.items.0.title'), 'desc' => __('history.milestone.items.0.desc')],
                                ['year' => __('history.milestone.items.1.year'), 'title' => __('history.milestone.items.1.title'), 'desc' => __('history.milestone.items.1.desc')],
                                ['year' => __('history.milestone.items.2.year'), 'title' => __('history.milestone.items.2.title'), 'desc' => __('history.milestone.items.2.desc')],
                                ['year' => __('history.milestone.items.3.year'), 'title' => __('history.milestone.items.3.title'), 'desc' => __('history.milestone.items.3.desc')],
                            ];
                        @endphp

                        @foreach ($milestones as $m)
                            <div style="display: grid; grid-template-columns: 100px 1fr; gap: 40px;">
                                <div style="font-family: 'Libre Baskerville', serif; font-size: 1.2rem; color: var(--q-gold); font-weight: 700; padding-top: 5px;">
                                    {{ $m['year'] }}
                                </div>
                                <div>
                                    <h4 style="font-family: 'Libre Baskerville', serif; font-size: 1.8rem; margin-bottom: 15px; font-weight: 400;">
                                        {{ $m['title'] }}
                                    </h4>
                                    <p class="content-text" style="max-width: 600px;">
                                        {{ $m['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section style="padding: 120px 0; text-align: center; border-top: 1px solid #f0f0f0;"></section>

    @push('scripts')
        <script>
        
        // ── Loading overlay saat upload ──

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('active');
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            function scrollSlider(id, direction) {
                const slider = document.getElementById(id);
                const card = slider.querySelector('.v-card');
                const gap = 24;
                const cardWidth = card ? (card.offsetWidth + gap) : 420;
                slider.scrollBy({
                    left: direction === 'left' ? -cardWidth : cardWidth,
                    behavior: 'smooth'
                });
            }

            const sliders = document.querySelectorAll('.v-slider');
            sliders.forEach(slider => {
                let isDown = false;
                let startX;
                let scrollLeft;
                slider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    slider.style.scrollSnapType = 'none';
                    slider.style.scrollBehavior = 'auto';
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                });
                slider.addEventListener('mouseleave', () => {
                    isDown = false;
                    slider.style.scrollSnapType = '';
                    slider.style.scrollBehavior = '';
                });
                slider.addEventListener('mouseup', () => {
                    isDown = false;
                    slider.style.scrollSnapType = '';
                    slider.style.scrollBehavior = '';
                });
                slider.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });
            });
            
            // ── Hero History Carousel ──────────────────────────
(function () {
    const slides = document.querySelectorAll('#hero-history .hero-slide');
    const dots   = document.querySelectorAll('#hero-history .hero-dot');
    if (slides.length === 0) return;

    let current = 0;
    let timer   = null;

    // Set slide pertama aktif
    slides[0].classList.add('active');

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current] && (dots[current].style.width = '8px', dots[current].style.background = 'rgba(255,255,255,0.4)');

        current = index % slides.length;

        slides[current].classList.add('active');
        if (dots[current]) {
            dots[current].style.width = '24px';
            dots[current].style.background = '#fff';
        }
    }

    function next() { goTo((current + 1) % slides.length); }

    function startTimer() { clearInterval(timer); timer = setInterval(next, 6000); }

    dots.forEach((dot, i) => dot.addEventListener('click', () => { goTo(i); startTimer(); }));

    startTimer();
})();
        </script>
    @endpush

@endsection
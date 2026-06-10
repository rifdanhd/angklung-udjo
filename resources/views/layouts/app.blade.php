<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">

{{-- ============================================================
     HEAD uhuy
     ============================================================ --}}

<head>
    {{-- ═══════════════════ CHARSET & VIEWPORT (HARUS PALING ATAS) ═══════════════════ --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('preload')

    {{-- ═══════════════════ SEO META TAGS ═══════════════════ --}}
    @include('partials.seo', [
        'title'       => $seoTitle       ?? null,
        'description' => $seoDescription ?? null,
        'image'       => $seoImage       ?? null,
        'type'        => $seoType        ?? 'website',
        'keywords'    => $seoKeywords    ?? null,
    ])

    {{-- ═══════════════════ FAVICON ═══════════════════ --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}">

    {{-- ═══════════════════ SCHEMA.ORG STRUCTURED DATA ═══════════════════ --}}
    @include('partials.schema-organization')

    {{-- ═══════════════════ ASSETS ═══════════════════ --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    @include('partials.analytics')

{{-- ✅ GSAP dulu, ScrollTrigger sesudahnya (defer agar tidak blocking render) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>

{{-- Alpine tetap pakai defer karena memang didesain begitu --}}
<script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- ── Google Fonts ── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spirax&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* ── CSS Variables ──────────────────────────────────────── */
        :root {
            --v-indigo: #1a1445;
            --v-gold: #c4a47c;
            --v-maroon: #7d002a;
        }

        /* ── Reset ──────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            overflow-x: hidden;
            background-color: #fff;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--v-indigo);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Utility Typography ──────────────────────────────────── */
        .font-editorial {
            font-family: 'Libre Baskerville', serif;
        }

        .font-spirax {
            font-family: 'Spirax', cursive;
        }

        /* ── Scrollbar ───────────────────────────────────────────── */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--v-indigo);
        }

        /* ── Alpine cloak ────────────────────────────────────────── */
        [x-cloak] {
            display: none !important;
        }

        /* ─────────────────────────────────────────────────────────
           NAVBAR
        ───────────────────────────────────────────────────────── */
        #navbar {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
            z-index: 100;
        }

        .nav-transparent {
            background: transparent;
            padding: 30px 0;
        }

        .nav-solid {
            background: rgba(255, 255, 255, 0.98);
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        /* Nav link styles */
        .nav-link-main {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            padding: 10px 0;
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
        }

        .nav-link-main.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--v-gold);
        }

        .nav-link-sub {
            font-size: 13px;
            font-weight: 400;
            color: rgba(26, 20, 69, 0.6);
            display: block;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .nav-link-sub:hover {
            color: var(--v-gold);
            transform: translateX(5px);
        }

        .mega-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--v-gold);
            margin-bottom: 1.5rem;
            display: block;
        }

        /* ── Mega Menu ───────────────────────────────────────────── */
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100vw;
            background: white;
            color: var(--v-indigo);
            opacity: 0;
            visibility: hidden;
            transform: translateY(5px);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
            border-top: 1px solid #f1f1f1;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1);
            pointer-events: none;
        }

        .mega-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        /* Nav solid state: language button tint */
        .nav-solid .lang-dropdown-btn {
            background: rgba(26, 20, 69, 0.1);
            border-color: rgba(26, 20, 69, 0.2);
            color: #1a1445;
        }

        /* ─────────────────────────────────────────────────────────
           MOBILE NAV
        ───────────────────────────────────────────────────────── */
        #mobile-nav {
            display: none;
            transform: translateX(100%);
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ─────────────────────────────────────────────────────────
           WHATSAPP FLOAT / POPUP  — anti-FOUC
        ───────────────────────────────────────────────────────── */
        #wa-float,
        #wa-popup {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
#wa-float.wa-muncul {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    transform: translateY(0) !important;
}
  #wa-popup.wa-terbuka {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    transform: translateY(0) scale(1) !important;
}
        /* ── Social icons ────────────────────────────────────────── */
        .social-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
        }

        .social-icon:hover svg {
            filter: drop-shadow(0 4px 8px rgba(196, 164, 124, 0.4));
        }
    </style>

    @stack('styles')
</head>

{{-- ============================================================
     BODY
     ============================================================ --}}

<body class="antialiased">
    @php $currentLocale = app()->getLocale(); @endphp

    {{-- ══════════════════════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════════════════════ --}}
    <nav id="navbar" class="fixed top-0 w-full nav-transparent">
        <div
            class="max-w-[1500px] mx-auto px-8 md:px-12
                    flex lg:grid lg:grid-cols-3 justify-between items-center">

            {{-- ── Logo ── --}}
            <a href="{{ route('home', $currentLocale) }}" class="flex items-center gap-5 group shrink-0">
                <div class="w-12 h-12 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                    <img src="{{ asset('images/UdjoFullColor.png') }}" alt="Logo Saung Angklung Udjo"
                        class="w-full h-full object-contain drop-shadow-xl">
                </div>
                <div class="flex flex-col">
                    <span id="brand-name"
                        class="font-spirax font-bold text-xl text-white transition-colors duration-500">
                        Saung Angklung Udjo
                    </span>
                    <span id="brand-sub"
                        class="text-[9px] uppercase tracking-[0.4em] font-bold text-white transition-colors duration-500">
                        {{ t('tagline') }}
                    </span>
                </div>
            </a>

            {{-- ── Desktop Navigation ── --}}
            <div class="hidden lg:flex items-center gap-6 justify-center">

                {{-- Heritage --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l1">{{ t('heritage') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial text-amber-600">{{ t('the_legend') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('heritage.history') }}"
                                            class="nav-link-sub font-medium">{{ t('sejarah_profile') }}</a></li>
                                    <li><a href="{{ route('heritage.vision-mission') }}"
                                            class="nav-link-sub font-medium">{{ t('vision_mission') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial text-amber-600">{{ t('angklung') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('heritage.angklung') }}"
                                            class="nav-link-sub">{{ t('angklung_history') }}</a></li>
                                    <li><a href="{{ route('heritage.jenis-angklung') }}"
                                            class="nav-link-sub font-medium">{{ t('angklung_types') }}</a></li>
                                    <li><a href="{{ route('heritage.craftsmanship') }}"
                                            class="nav-link-sub">{{ t('how_to_make') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l2">{{ t('experience') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('attractions') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('experience.performances', $currentLocale) }}"
                                            class="nav-link-sub">{{ t('indoor_performance') }}</a></li>
                                    <li><a href="{{ route('experience.performancesoutdoor') }}"
                                            class="nav-link-sub">{{ t('outdoor_performance') }}</a></li>
                                    <li><a href="{{ route('heritage.achievements') }}"
                                            class="nav-link-sub">{{ t('achievements') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('craftsmanship') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('experience.souvenir') }}"
                                            class="nav-link-sub">{{ t('souvenir_shop') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Visit Us --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white whitespace-nowrap" id="l3">{{ t('visit_us') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('booking') }}</span>
                                <ul class="space-y-4 font-bold">
                                    <li><a href="{{ route('contact') }}"
                                            class="nav-link-sub">{{ t('reservation_info') }}</a></li>
                                    <li><a href="{{ route('heritage.venue') }}"
                                            class="nav-link-sub">{{ t('venue_site') }}</a></li>
                                    <li><a href="{{ route('experience.banguet') }}"
                                            class="nav-link-sub">{{ t('banquet') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('city_guide') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('Visitus.hotel') }}"
                                            class="nav-link-sub">{{ t('hotels') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stories --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l4">{{ t('stories') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('media_center') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('articles.index', $currentLocale) }}"
                                            class="nav-link-sub">{{ t('news_events') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('creative') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('gallery.index', $currentLocale) }}"
                                            class="nav-link-sub">Gallery</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('assets') }}</span>
                                <ul class="space-y-4 font-medium">
                                    <li><a href="https://drive.google.com/file/d/1A579hR3y0xP5yEW-r78hEDXFW26BQsG1/view?usp=sharing"
                                            target="_blank" rel="noopener"
                                            class="nav-link-sub">{{ t('ebrochure') }}</a></li>
                                    <li><a href="https://drive.google.com/file/d/1RGZKVynjb8PKu7kaQRYtFMnXImc0eOph/view?usp=sharing"
                                            target="_blank" rel="noopener"
                                            class="nav-link-sub">{{ t('downloads_hub') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

       {{-- Products --}}
<a href="{{ route('products.index') }}" class="nav-link-main text-white" id="l5">
    Products
</a>

{{-- Partnership --}}
<a href="{{ route('partnership.index') }}" class="nav-link-main text-white" id="l6">
    Partnership
</a>

            </div>

            {{-- ── Right: Language + CTA ── --}}
            <div class="hidden lg:flex items-center gap-4 justify-end">

                {{-- Language Switcher --}}
                <div class="relative inline-block" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="lang-dropdown-btn flex items-center gap-2 px-4 py-2 rounded-full
                                   bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20
                                   text-white transition-all"
                        aria-label="Switch language">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                        <span class="font-medium text-sm">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl overflow-hidden z-50">
                        <a href="{{ route('language.switch', 'id') }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50
                                  {{ app()->getLocale() === 'id' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}">
                            <span class="text-2xl">🇮🇩</span> Bahasa Indonesia
                        </a>
                        <a href="{{ route('language.switch', 'en') }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50
                                  {{ app()->getLocale() === 'en' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}">
                            <span class="text-2xl">🇬🇧</span> English
                        </a>
                    </div>
                </div>

                {{-- Book Now CTA --}}
                <a href="{{ route('tickets.buy') }}" id="nav-cta"
                    class="bg-white text-indigo-900 px-8 py-3 text-[10px] font-bold uppercase tracking-widest
                          hover:bg-[var(--v-gold)] hover:text-white transition-all shadow-xl shrink-0">
                    Book Now
                </a>
            </div>

            {{-- ── Mobile Hamburger ── --}}
            <button onclick="toggleMobileNav(true)" class="lg:hidden text-white justify-self-end" id="mobile-btn"
                aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 8h16M4 16h16" stroke-width="2" />
                </svg>
            </button>

        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════════════ --}}
<main class="w-full" id="main-content">
    @yield('content')
</main>

    {{-- ══════════════════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════════════════ --}}
    <footer class="bg-[#1a1445] text-white pt-32 pb-16 w-full">
        <div class="max-w-[1400px] mx-auto px-10">

            {{-- Footer grid --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-24">

                {{-- Brand --}}
                <div class="md:col-span-4 space-y-8">
                    <a href="{{ route('home', $currentLocale) }}" class="flex items-center gap-5 group shrink-0">
                        <div class="w-12 h-12 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('images/UdjoFullColor.png') }}" alt="Logo"
                                class="w-full h-full object-contain drop-shadow-xl">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-spirax font-bold text-xl text-white">Saung Angklung Udjo</span>
                            <span
                                class="text-[8px] text-white/60 uppercase tracking-[0.4em]">{{ t('tagline') }}</span>
                        </div>
                    </a>
                    <p class="text-sm text-white/40 leading-loose max-w-sm font-light">{{ t('description') }}</p>
                </div>

                {{-- Navigation links --}}
                <div class="md:col-span-2">
                   <p class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">WISATA BUDAYA</p>
                    <ul class="space-y-5 text-sm text-white/60">
                        <li><a href="#" class="hover:text-white transition">{{ t('heritage') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ t('experience') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ t('visit_us') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ t('stories') }}</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">
                        {{ t('connect') }}</h4>
                    <ul class="space-y-5 text-sm text-white/60 italic font-light">
                        <li>{{ t('address') }}</li>
                        <li>+62 821 8282 1200</li>
                        <li>info@angklung-udjo.co.id</li>
                    </ul>
                </div>

                {{-- Social Media --}}
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">
                        {{ t('follow') }}</h4>
                    <div class="flex gap-6">

                        <a href="https://www.instagram.com/angklungudjo/" target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full
                                  bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>

                        <a href="https://www.tiktok.com/@saungangklungudjo" target="_blank" rel="noopener noreferrer"
                            aria-label="TikTok"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full
                                  bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                        </a>

                        <a href="https://www.youtube.com/@saungangklungudjo" target="_blank"
                            rel="noopener noreferrer" aria-label="YouTube"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full
                                  bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>

                    </div>
                </div>

            </div>

            {{-- Footer bottom --}}
            <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-3">
                <p class="text-[9px] tracking-[0.4em] uppercase opacity-20">
                    &copy; {{ date('Y') }} {{ t('rights') }}
                </p>
                <p class="text-[9px] tracking-[0.3em] uppercase opacity-20">
                    Designed &amp; Developed by
                    <span class="cursor-default">Muhammad Rifdan Dermawan</span>
                </p>
            </div>

        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════
         MOBILE NAVIGATION DRAWER
    ══════════════════════════════════════════════════════════ --}}
    <div id="mobile-nav" class="fixed inset-0 bg-[#1a1445] z-[200] flex flex-col overflow-hidden"
        aria-label="Mobile navigation">

        {{-- Header --}}
        <div class="flex justify-between items-center p-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-4 text-[10px] font-bold tracking-[0.3em] text-white">
                <a href="{{ route('language.switch', 'id') }}"
                    class="transition-opacity {{ $currentLocale == 'id' ? 'text-amber-500' : 'opacity-40 hover:opacity-100' }}">ID</a>
                <span class="opacity-10 text-xs">|</span>
                <a href="{{ route('language.switch', 'en') }}"
                    class="transition-opacity {{ $currentLocale == 'en' ? 'text-amber-500' : 'opacity-40 hover:opacity-100' }}">EN</a>
            </div>
            <button onclick="toggleMobileNav(false)"
                class="text-white p-2 hover:rotate-90 transition-transform duration-500" aria-label="Close menu">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        {{-- Scrollable Links --}}
        <div class="flex-1 overflow-y-auto px-6 py-8">

            @php
                $mobileNavSections = [
                    'heritage' => [
                        t('heritage'),
                        [
                            ['route' => route('heritage.history'), 'label' => t('sejarah_profile')],
                            ['route' => route('heritage.vision-mission'), 'label' => t('vision_mission')],
                            ['route' => route('heritage.angklung'), 'label' => t('angklung_history')],
                            ['route' => route('heritage.jenis-angklung'), 'label' => t('angklung_types')],
                            ['route' => route('heritage.craftsmanship'), 'label' => t('how_to_make')],
                        ],
                    ],
                    'experience' => [
                        t('experience'),
                        [
                            [
                                'route' => route('experience.performances', $currentLocale),
                                'label' => t('indoor_performance'),
                            ],
                            ['route' => route('experience.performancesoutdoor'), 'label' => t('outdoor_performance')],
                            ['route' => route('heritage.achievements'), 'label' => t('achievements')],
                            ['route' => route('experience.souvenir'), 'label' => t('souvenir_shop')],
                        ],
                    ],
                    'visit' => [
                        t('visit_us'),
                        [
                            ['route' => route('contact'), 'label' => t('reservation_info')],
                            ['route' => route('heritage.venue'), 'label' => t('venue_site')],
                            ['route' => route('experience.banguet'), 'label' => t('banquet')],
                            ['route' => route('Visitus.hotel'), 'label' => t('hotels')],
                        ],
                    ],
                    'stories' => [
                        t('stories'),
                        [
                            ['route' => route('articles.index', $currentLocale), 'label' => t('news_events')],
                            ['route' => route('gallery.index', $currentLocale), 'label' => 'Gallery'],
                            [
                                'route' =>
                                    'https://drive.google.com/file/d/1A579hR3y0xP5yEW-r78hEDXFW26BQsG1/view?usp=sharing',
                                'label' => t('ebrochure'),
                                'external' => true,
                            ],
                            [
                                'route' =>
                                    'https://drive.google.com/file/d/1RGZKVynjb8PKu7kaQRYtFMnXImc0eOph/view?usp=sharing',
                                'label' => t('downloads_hub'),
                                'external' => true,
                            ],
                        ],
                    ],
                ];
            @endphp

            @foreach ($mobileNavSections as $key => [$title, $links])
                <div class="mb-8" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-left mb-4">
                        <span
                            class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">{{ $title }}</span>
                        <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="space-y-1 pl-4">
                        @foreach ($links as $link)
                            <a href="{{ $link['route'] }}"
                                class="block text-white/70 hover:text-white text-sm transition-colors py-2"
                                @if (!empty($link['external'])) target="_blank" rel="noopener" @endif>
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

    {{-- Products --}}
            <div class="mb-8">
                <a href="#" class="flex items-center justify-between w-full text-left">
                    <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">Products</span>
                </a>
            </div>
   {{-- Partnership --}}
        <div class="mb-8 pb-4">  {{-- tambah pb-4 biar tidak terpotong --}}
            <a href="{{ route('partnership.index') }}" class="flex items-center justify-between w-full text-left">
                <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">Partnership</span>
            </a>
        </div>

        </div>

        {{-- CTA --}}
        <div class="p-6 border-t border-white/10 bg-black/10 flex-shrink-0">
            <a href="{{ route('tickets.buy') }}"
                class="block w-full text-center py-4 bg-white text-indigo-950 font-bold
                      text-[11px] tracking-[0.3em] uppercase transition-transform active:scale-95 rounded-lg">
                Book Now
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         WHATSAPP — Popup
    ══════════════════════════════════════════════════════════ --}}
    <div id="wa-popup" class="fixed bottom-32 right-10 z-[99] transform translate-y-4 scale-95" role="dialog"
        aria-label="WhatsApp Contact">
        <div class="bg-white rounded-2xl shadow-2xl p-4 w-72">

            <div class="flex justify-between items-center mb-4 pb-3 border-b">
                <h3 class="font-bold text-gray-800 text-sm">{{ t('title') }}</h3>
                <button id="close-popup" class="text-gray-400 hover:text-gray-600 transition-colors"
                    aria-label="Close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @php
                $waContacts = [
                    ['number' => '6282182821200', 'name' => t('admin_1_name'), 'desc' => t('admin_1_desc')],
                    ['number' => '628112124050', 'name' => t('admin_2_name'), 'desc' => t('admin_2_desc')],
                    ['number' => '6289665285200', 'name' => t('souvenir_name'), 'desc' => t('souvenir_desc')],
                ];
            @endphp

            @foreach ($waContacts as $i => $wa)
                <a href="https://wa.me/{{ $wa['number'] }}" target="_blank" rel="noopener"
                    class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-all duration-200 group
                          {{ $i < count($waContacts) - 1 ? 'mb-2' : '' }}">
                    <div
                        class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center flex-shrink-0
                                group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm">{{ $wa['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $wa['desc'] }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#25D366] group-hover:translate-x-1 transition-all"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @endforeach

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         WHATSAPP — Float Button
    ══════════════════════════════════════════════════════════ --}}
    <button id="wa-float" class="fixed bottom-10 right-10 z-[100] group flex items-center gap-4 translate-y-6"
        aria-label="Open WhatsApp chat">
        <span
            class="bg-white text-indigo-950 px-6 py-3 text-[10px] font-bold tracking-widest uppercase
                     shadow-2xl hidden md:block">
            {{ t('admin_wa') }}
        </span>
        <div
            class="w-16 h-16 bg-[#25D366] text-white rounded-full flex items-center justify-center
                    shadow-[0_15px_30px_rgba(37,211,102,0.3)] transition-transform group-hover:scale-110 cursor-pointer">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
            </svg>
        </div>
    </button>

    {{-- ══════════════════════════════════════════════════════════
         SCRIPTS
    ══════════════════════════════════════════════════════════ --}}
    <script>
        (() => {
            /* ── Element references ─────────────────────────────── */
            const navbar = document.getElementById('navbar');
            const waFloat = document.getElementById('wa-float');
            const waPopup = document.getElementById('wa-popup');
            const brandEl = document.getElementById('brand-name');
            const subEl = document.getElementById('brand-sub');
            const ctaEl = document.getElementById('nav-cta');
            const mobBtn = document.getElementById('mobile-btn');
         const linkEls = ['l1', 'l2', 'l3', 'l4', 'l5', 'l6'].map(id => document.getElementById(id));
            const navGroups = document.querySelectorAll('.nav-group');

            let isScrolled = false;
            let activeMegaMenu = null;

            /* ── Navbar state ───────────────────────────────────── */
            function applyNavState() {
                const solid = isScrolled || activeMegaMenu !== null;

                navbar.classList.toggle('nav-solid', solid);
                navbar.classList.toggle('nav-transparent', !solid);

                const color = solid ? '#1a1445' : 'white';
                const subOpacity = solid ? 'rgba(26,20,69,0.4)' : 'rgba(255,255,255,0.6)';

                if (brandEl) brandEl.style.color = color;
                if (subEl) subEl.style.color = subOpacity;
                if (mobBtn) mobBtn.style.color = color;

                linkEls.forEach(l => {
                    if (l) l.style.color = color;
                });

                if (ctaEl) {
                    ctaEl.classList.toggle('bg-[#1a1445]', solid);
                    ctaEl.classList.toggle('text-white', solid);
                    ctaEl.classList.toggle('bg-white', !solid);
                    ctaEl.classList.toggle('text-indigo-900', !solid);
                }
            }

            /* ── Mega menu ──────────────────────────────────────── */
            function closeMegaMenu() {
                if (!activeMegaMenu) return;
                activeMegaMenu.querySelector('.mega-menu')?.classList.remove('active');
                activeMegaMenu.querySelector('.nav-link-main')?.classList.remove('active');
                activeMegaMenu = null;
                applyNavState();
            }

         navGroups.forEach(group => {
    const link = group.querySelector('.nav-link-main');
    const menu = group.querySelector('.mega-menu');

    // Kalau tidak ada mega menu (Products & Partnership), skip logic mega menu
    if (!menu) return;

    link.addEventListener('click', e => {
        e.stopPropagation();
        if (activeMegaMenu === group) {
            closeMegaMenu();
        } else {
            closeMegaMenu();
            menu.classList.add('active');
            link.classList.add('active');
            activeMegaMenu = group;
            applyNavState();
        }
    });

    menu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMegaMenu));
});

            document.addEventListener('click', e => {
                if (activeMegaMenu && !e.target.closest('.nav-group')) closeMegaMenu();
            });

            /* ── Scroll handler ─────────────────────────────────── */
            function onScroll() {
                isScrolled = window.scrollY > 80;
                applyNavState();

                if (waFloat) {
                    waFloat.classList.toggle('wa-muncul', isScrolled);
                    if (!isScrolled) waPopup?.classList.remove('wa-terbuka');
                }
            }

            window.addEventListener('scroll', onScroll, {
                passive: true
            });
            onScroll(); // run on load

            /* ── Mobile nav ─────────────────────────────────────── */
            window.toggleMobileNav = (open) => {
                const nav = document.getElementById('mobile-nav');
                if (!nav) return;
                if (open) {
                    nav.style.display = 'flex';
                    requestAnimationFrame(() => nav.style.transform = 'translateX(0)');
                } else {
                    nav.style.transform = 'translateX(100%)';
                    setTimeout(() => nav.style.display = 'none', 700);
                }
            };

            /* ── WhatsApp ───────────────────────────────────────── */
            waFloat?.addEventListener('click', e => {
                e.preventDefault();
                waPopup?.classList.toggle('wa-terbuka');
            });

            document.getElementById('close-popup')?.addEventListener('click', () => {
                waPopup?.classList.remove('wa-terbuka');
            });

            document.addEventListener('click', e => {
                if (waFloat && waPopup && !waFloat.contains(e.target) && !waPopup.contains(e.target)) {
                    waPopup.classList.remove('wa-terbuka');
                }
            });
        })();
    </script>

    @stack('scripts')
    @include('partials.cookie-consent')

</body>

</html>

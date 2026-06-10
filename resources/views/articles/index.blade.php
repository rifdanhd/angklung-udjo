<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Cerita — Saung Angklung Udjo</title>
    <meta name="description" content="Kumpulan berita, cerita, dan artikel terkini dari Saung Angklung Udjo — warisan budaya Sunda yang mendunia.">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spirax&family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── CSS Variables ── */
        :root {
            --navy: #1a1445;
            --gold: #c4a47c;
            --gold-dark: #b08d62;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html, body { overflow-x: hidden; }

        body {
            font-family: 'Inter', sans-serif;
            color: #1a1a1a;
            background: #f5f5f0;
        }
        .font-spirax { font-family: 'Spirax', cursive; }
        .font-serif  { font-family: 'Libre Baskerville', serif; }
        .font-lora   { font-family: 'Lora', serif; }

        /* ────────────────────────────────────────────────────────
           TOP BAR (Kompas-style)
        ──────────────────────────────────────────────────────── */
        .topbar {
            background: var(--navy);
            border-bottom: 2px solid var(--gold);
            padding: 0.5rem 0;
        }

        /* ────────────────────────────────────────────────────────
           HEADER / BRAND BAR
        ──────────────────────────────────────────────────────── */
        .brand-header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 0;
        }

        /* Search pill */
        .search-pill {
            display: flex; align-items: center; gap: 0.5rem;
            background: #f4f4f4; border: 1.5px solid #e0e0e0;
            border-radius: 50px; padding: 0.45rem 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-pill:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196,164,124,0.15);
        }
        .search-pill input {
            background: transparent; border: none; outline: none;
            font-size: 0.85rem; width: 100%;
        }

        /* BOOK NOW button */
        .btn-book {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--navy);
            color: #fff;
            padding: 0.6rem 1.4rem;
            font-size: 0.72rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.12em;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            white-space: nowrap;
        }
        .btn-book:hover { background: #110d30; transform: translateY(-1px); }

        /* ────────────────────────────────────────────────────────
           CATEGORY NAV BAR (Kompas-style sticky)
        ──────────────────────────────────────────────────────── */
        .cat-nav {
            background: #fff;
          position: sticky; top: 0; z-index: 50;
        }
        .cat-nav-inner {
            display: flex; align-items: stretch;
            max-width: 1280px; margin: 0 auto;
            overflow-x: auto; scrollbar-width: none;
        }
        .cat-nav-inner::-webkit-scrollbar { display: none; }
        .cat-link {
            display: inline-block;
            padding: 0.75rem 1.1rem;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: #444; white-space: nowrap;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }
        .cat-link:hover  { color: var(--red); }
        .cat-link.active { color: var(--navy); border-bottom-color: var(--gold); }

        /* ────────────────────────────────────────────────────────
           FILTER PILLS
        ──────────────────────────────────────────────────────── */
        .pill {
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            cursor: pointer; text-decoration: none;
            border: 1.5px solid #ddd;
            background: #fff; color: #555;
            transition: all 0.2s;
        }
        .pill:hover { border-color: var(--gold); color: var(--gold); }
        .pill.active {
            background: var(--navy); color: #fff;
            border-color: var(--navy);
        }

        /* ────────────────────────────────────────────────────────
           HERO SECTION
        ──────────────────────────────────────────────────────── */
        .articles-hero {
            background-image: linear-gradient(135deg, rgba(26,20,69,0.85) 0%, rgba(45,27,105,0.7) 60%, rgba(26,20,69,0.9) 100%), url('{{ asset("img/Angklungmasal.webp") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 5rem 0 4rem; /* sedikit diperbesar paddingnya agar hero lebih proporsional */
            position: relative; overflow: hidden;
        }
        .articles-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(196,164,124,0.1) 0%, transparent 60%);
        }
        .hero-search {
            width: 100%; padding: 0.9rem 1.5rem 0.9rem 3.2rem;
            border: 2px solid rgba(196,164,124,0.3); border-radius: 50px;
            background: rgba(255,255,255,0.08); color: white;
            font-size: 0.9rem; outline: none;
            transition: all 0.3s; backdrop-filter: blur(10px);
        }
        .hero-search::placeholder { color: rgba(255,255,255,0.4); }
        .hero-search:focus {
            border-color: var(--gold);
            background: rgba(255,255,255,0.13);
            box-shadow: 0 0 0 4px rgba(196,164,124,0.15);
        }

        /* ────────────────────────────────────────────────────────
           FEATURED CARD
        ──────────────────────────────────────────────────────── */
        .featured-card {
            position: relative; border-radius: 12px; overflow: hidden;
            height: 460px; display: block; text-decoration: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }
        .featured-card img { width:100%; height:100%; object-fit:cover; transition: transform 0.6s ease; }
        .featured-card:hover img { transform: scale(1.04); }
        .featured-card .overlay {
            position:absolute; inset:0;
            background: linear-gradient(180deg, transparent 20%, rgba(0,0,0,0.92) 100%);
        }
        .featured-card .fc-content { position:absolute; bottom:0; left:0; right:0; padding:2rem; }
        .featured-badge {
            display:inline-block; padding:0.25rem 0.75rem;
            background: var(--red); color:#fff;
            font-size:0.65rem; font-weight:800;
            text-transform:uppercase; letter-spacing:0.1em;
            border-radius:3px; margin-bottom:0.75rem;
        }
        .featured-title {
            font-family:'Libre Baskerville', serif;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight:700; color:#fff; line-height:1.25;
            margin-bottom:0.75rem;
            display:-webkit-box; -webkit-line-clamp:3;
            -webkit-box-orient:vertical; overflow:hidden;
        }

        /* ────────────────────────────────────────────────────────
           ARTICLE CARDS
        ──────────────────────────────────────────────────────── */
        .article-card {
            background:#fff; border-radius:10px; overflow:hidden;
            text-decoration:none; display:flex; flex-direction:column;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
        }
        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(26,20,69,0.12);
        }
        .card-thumb-wrap { overflow:hidden; }
        .card-thumb {
            width:100%; height:200px; object-fit:cover;
            transition: transform 0.5s ease;
        }
        .article-card:hover .card-thumb { transform: scale(1.05); }
        .card-thumb-placeholder {
            width:100%; height:200px;
            background: linear-gradient(135deg, #e8e6f0, #d5d0e8);
            display:flex; align-items:center; justify-content:center;
            font-size:2.5rem; opacity:0.35;
        }
        .card-body { padding:1.25rem; flex:1; display:flex; flex-direction:column; }
        .card-category {
            font-size:0.65rem; font-weight:800; color: var(--red);
            text-transform:uppercase; letter-spacing:0.1em;
            margin-bottom:0.5rem;
        }
        .card-title {
            font-family:'Libre Baskerville', serif;
            font-size:1rem; font-weight:700; color: var(--navy); line-height:1.4;
            margin-bottom:0.75rem; flex:1;
            display:-webkit-box; -webkit-line-clamp:3;
            -webkit-box-orient:vertical; overflow:hidden;
        }
        .article-card:hover .card-title { color: var(--red); }
        .card-footer-line {
            display:flex; justify-content:space-between; align-items:center;
            padding-top:0.75rem; border-top:1px solid #f0f0f0;
            font-size:0.72rem; color:#999;
        }
        .card-read-more {
            font-size:0.72rem; font-weight:700; color: var(--navy);
            display:flex; align-items:center; gap:0.25rem;
            transition: color 0.2s, gap 0.2s;
        }
        .article-card:hover .card-read-more { color: var(--red); gap:0.5rem; }

        /* Skeleton loading */
        @keyframes skeleton-pulse {
            0%,100% { opacity:0.5; }
            50% { opacity:1; }
        }
        .skeleton {
            background: linear-gradient(90deg, #e8e8e8 25%, #f5f5f5 50%, #e8e8e8 75%);
            background-size: 200% 100%;
            animation: skeleton-pulse 1.5s ease-in-out infinite;
        }

        /* ────────────────────────────────────────────────────────
           SIDEBAR TRENDING
        ──────────────────────────────────────────────────────── */
        .sidebar-section-title {
            font-size:0.7rem; font-weight:900;
            text-transform:uppercase; letter-spacing:0.15em;
            color: var(--navy);
            padding-bottom:0.6rem;
            border-bottom: 3px solid var(--gold);
            display:inline-block; margin-bottom:1.25rem;
        }
        .trending-item {
            display:flex; gap:0.75rem; align-items:flex-start;
            padding:0.85rem 0; border-bottom:1px solid #f0f0f0;
            text-decoration:none;
        }
        .trending-item:last-child { border-bottom:none; }
        .trending-num {
            font-size:2rem; font-weight:900; line-height:1;
            color:#e8e8e8; min-width:2rem; transition:color 0.2s;
        }
        .trending-item:hover .trending-num { color: var(--gold); }
        .trending-title {
            font-size:0.85rem; font-weight:700; color: var(--navy);
            line-height:1.35; transition:color 0.2s;
        }
        .trending-item:hover .trending-title { color: var(--gold); }
        .trending-cat {
            font-size:0.62rem; font-weight:700; color: var(--gold);
            text-transform:uppercase; letter-spacing:0.08em;
            margin-top:0.25rem; display:block;
        }

        /* ────────────────────────────────────────────────────────
           FOOTER — App Style (pure CSS, no JIT)
        ──────────────────────────────────────────────────────── */
        .app-footer {
            background: #1a1445;
            color: #fff;
            padding: 8rem 0 4rem;
            width: 100%;
        }
        .app-footer-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2.5rem;
        }
        .app-footer-grid {
            display: grid;
            grid-template-columns: 4fr 2fr 3fr 3fr;
            gap: 4rem;
            margin-bottom: 6rem;
        }
        .app-footer-logo-link {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            text-decoration: none;
            margin-bottom: 2rem;
        }
        .app-footer-logo-img {
            width: 3rem;
            height: 3rem;
            object-fit: contain;
            filter: drop-shadow(0 8px 24px rgba(0,0,0,0.4));
            transition: transform 0.5s ease;
        }
        .app-footer-logo-link:hover .app-footer-logo-img { transform: scale(1.05); }
        .app-footer-brand-name {
            font-family: 'Spirax', cursive;
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
            display: block;
        }
        .app-footer-tagline {
            font-size: 8px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.4em;
            display: block;
        }
        .app-footer-desc {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.4);
            line-height: 2;
            max-width: 24rem;
            font-weight: 300;
            margin: 0;
        }
        .app-footer-col-title {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: #f59e0b;
            margin-bottom: 2.5rem;
            display: block;
        }
        .app-footer-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .app-footer-nav-list li { margin-bottom: 1.25rem; }
        .app-footer-nav-list a {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: color 0.3s;
        }
        .app-footer-nav-list a:hover { color: #fff; }
        .app-footer-contact-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .app-footer-contact-list li {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.6);
            font-style: italic;
            font-weight: 300;
            margin-bottom: 1.25rem;
        }
        .app-footer-social-row { display: flex; gap: 1.5rem; }
        .app-footer-social-icon {
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            flex-shrink: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .app-footer-social-icon:hover {
            background: rgba(245,158,11,0.2);
            border-color: rgba(245,158,11,0.5);
            color: #f59e0b;
            transform: translateY(-3px) scale(1.1);
        }
        .app-footer-social-icon:hover svg {
            filter: drop-shadow(0 4px 8px rgba(196,164,124,0.4));
        }
        .app-footer-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.05);
            margin: 0 0 1.5rem;
        }
        .app-footer-bottom {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
        }
        .app-footer-copy {
            font-size: 9px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
            margin: 0;
        }
        @media (max-width: 767px) {
            .app-footer { padding: 4rem 0 2rem; }
            .app-footer-grid { grid-template-columns: 1fr; gap: 2rem; margin-bottom: 3rem; }
            .app-footer-inner { padding: 0 1rem; }
            .app-footer-bottom { flex-direction: column; text-align: center; }
        }

        /* ────────────────────────────────────────────────────────
           SOCIAL ICON (footer)
        ──────────────────────────────────────────────────────── */
        .social-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
        }
        .social-icon:hover svg {
            filter: drop-shadow(0 4px 8px rgba(196, 164, 124, 0.4));
        }

        /* ────────────────────────────────────────────────────────
           MISC
        ──────────────────────────────────────────────────────── */
        .section-label {
            font-size:0.65rem; font-weight:900;
            text-transform:uppercase; letter-spacing:0.25em;
            color: var(--navy); padding-bottom:0.5rem;
            border-bottom:3px solid var(--gold);
            display:inline-block;
        }

        .articles-grid {
            display:grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap:1.5rem;
        }

        /* ────────────────────────────────────────────────────────
           MOBILE RESPONSIVE
        ──────────────────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .articles-grid { grid-template-columns: repeat(2, 1fr); }
            .featured-card { height: 380px; }
        }

        @media (max-width: 768px) {
            /* Header */
            .brand-header { padding: 0.6rem 0; }
            .brand-header .font-spirax { font-size: 1rem !important; }
            .brand-header .text-\[8px\] { font-size: 6px !important; letter-spacing: 0.25em !important; }
            .btn-book { padding: 0.4rem 0.85rem; font-size: 0.6rem; }

            /* Category Nav */
            .cat-nav { border-bottom: 1px solid #eee; }
            .cat-link { padding: 0.55rem 0.65rem; font-size: 0.62rem; }

            /* Hero */
            .articles-hero { padding: 2.5rem 0 2rem; background-attachment: scroll; }
            .hero-search { padding: 0.7rem 1.2rem 0.7rem 2.8rem; font-size: 0.82rem; }

            /* Filter Pills */
            .pill { padding: 0.28rem 0.75rem; font-size: 0.65rem; }

            /* Featured Card */
            .featured-card { height: 280px; }
            .featured-title { font-size: 1.1rem !important; -webkit-line-clamp: 2; }
            .fc-content { padding: 1.25rem !important; }
            .featured-badge { font-size: 0.58rem; padding: 0.2rem 0.6rem; margin-bottom: 0.5rem; }
            .section-label { font-size: 0.6rem; }

            /* Article Grid */
            .articles-grid { grid-template-columns: 1fr; gap: 1rem; }

            /* Article Cards */
            .card-thumb { height: 180px; }
            .card-thumb-placeholder { height: 180px; }
            .card-body { padding: 1rem; }
            .card-title { font-size: 0.9rem; margin-bottom: 0.5rem; }
            .card-category { font-size: 0.6rem; margin-bottom: 0.35rem; }
            .card-footer-line { font-size: 0.65rem; padding-top: 0.6rem; }
            .card-read-more { font-size: 0.65rem; }

            /* Sidebar */
            .trending-num { font-size: 1.5rem; }
            .trending-title { font-size: 0.78rem; }
            .trending-item { padding: 0.65rem 0; }

            /* Pagination */
            .pagination { flex-wrap: wrap; justify-content: center; }

            /* Empty State */
            .text-7xl { font-size: 3.5rem !important; }

            /* Main content spacing */
            main.max-w-screen-xl { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        }

        @media (max-width: 480px) {
            .featured-card { height: 240px; }
            .featured-title { font-size: 0.95rem !important; }
            .card-thumb { height: 160px; }
            .card-thumb-placeholder { height: 160px; }
            .card-title { font-size: 0.85rem; }
            .brand-header .font-spirax { font-size: 0.9rem !important; }
            .hero-search { font-size: 0.78rem; }
            .articles-hero h1 { font-size: 1.5rem !important; }
        }

        /* ────────────────────────────────────────────────────────
           KOMPAS-STYLE PAGINATION
        ──────────────────────────────────────────────────────── */
        .pagination-wrapper {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #e8e8e8;
        }
        .pagination-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            flex-wrap: wrap;
        }
        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.6rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            background: #fff;
            color: #444;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .page-btn:hover {
            border-color: var(--navy);
            color: var(--navy);
            background: #f8f7ff;
        }
        .page-btn.active {
            background: var(--navy);
            border-color: var(--navy);
            color: #fff;
            box-shadow: 0 2px 8px rgba(26,20,69,0.25);
        }
        .page-btn.disabled {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }
        .page-btn.arrow {
            font-size: 0.75rem;
            gap: 0.3rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .page-dots {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2.5rem;
            color: #999;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.1em;
        }
        .pagination-info {
            text-align: center;
            margin-top: 0.75rem;
            font-size: 0.72rem;
            color: #999;
            font-weight: 500;
        }
        .pagination-info strong {
            color: var(--navy);
            font-weight: 800;
        }
        @media (max-width: 480px) {
            .page-btn { min-width: 2.2rem; height: 2.2rem; font-size: 0.72rem; }
            .page-btn.arrow span { display: none; }
        }
    </style>
</head>
<body>
{{-- ══════════════════════════
     BRAND HEADER
     ══════════════════════════ --}}
<header class="brand-header">
    <div class="max-w-screen-xl mx-auto px-4 flex flex-wrap justify-between items-center gap-4">

        {{-- Logo & Brand --}}
        <a href="/" class="flex items-center gap-4 group shrink-0">
            <div class="w-11 h-11 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                <img src="{{ asset('images/UdjoFullColor.png') }}" alt="Logo Saung Angklung Udjo" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="font-spirax font-bold text-xl text-[#1a1445]">Saung Angklung Udjo</span>
                <span class="text-[8px] uppercase tracking-[0.4em] font-bold text-[#1a1445]/50">Nature, Culture in Harmony</span>
            </div>
        </a>

        {{-- Search + Book Now --}}
        <div class="flex items-center gap-3">
            <form action="{{ route('articles.index') }}" method="GET" class="hidden md:block">
                <div class="search-pill w-56 focus-within:w-72 transition-all duration-300">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari artikel..."
                           value="{{ request('search') }}">
                </div>
            </form>

            {{-- BOOK NOW — menonjol dengan warna merah ala Kompas --}}
            <a href="{{ route('tickets.buy') }}" class="btn-book" id="btn-book-now-index">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Book Now
            </a>
        </div>
    </div>
</header>

{{-- ══════════════════════════
     CATEGORY / NAV BAR (sticky)
     ══════════════════════════ --}}
<nav class="cat-nav">
    <div class="cat-nav-inner px-4">
        <a href="{{ route('home') }}" class="cat-link">Beranda</a>
        <a href="{{ route('articles.index') }}" class="cat-link active">News</a>
        <a href="{{ route('heritage.angklung') }}" class="cat-link">Heritage</a>
        <a href="{{ route('experience.performances') }}" class="cat-link">Experience</a>
        <a href="{{ route('articles.index', ['category' => 'Stories']) }}" class="cat-link">Stories</a>
        <a href="{{ route('products.index') }}" class="cat-link">Products</a>
        <a href="{{ route('partnership.index') }}" class="cat-link">Partnership</a>
        <a href="{{ route('contact') }}" class="cat-link">Visit Us</a>
    </div>
</nav>

{{-- ══════════════════════════
     HERO BANNER
     ══════════════════════════ --}}
<section class="articles-hero">
    <div class="max-w-screen-xl mx-auto px-4 relative z-10">
        <h1 class="font-serif text-white mb-1" style="font-size:clamp(2rem,5vw,3rem); font-weight:800; letter-spacing:-0.02em;">
            Berita &amp; Cerita
        </h1>

        <form action="{{ route('articles.index') }}" method="GET">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="relative max-w-lg">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/40 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" class="hero-search"
                       placeholder="Cari artikel, cerita, berita..."
                       value="{{ request('search') }}">
            </div>
        </form>
    </div>
</section>

{{-- ══════════════════════════
     FILTER PILLS
     ══════════════════════════ --}}
<div class="bg-white border-b border-gray-100 py-3 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-4 flex flex-wrap gap-2 items-center">
        <a href="{{ route('articles.index', array_filter(['search' => request('search')])) }}"
           class="pill {{ !request('category') ? 'active' : '' }}">Semua</a>
        @foreach($categories as $cat)
        <a href="{{ route('articles.index', array_filter(['category' => $cat, 'search' => request('search')])) }}"
           class="pill {{ request('category') === $cat ? 'active' : '' }}">{{ $cat }}</a>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════
     MAIN CONTENT
     ══════════════════════════ --}}
<main class="max-w-screen-xl mx-auto px-4 py-10">

    @if($articles->isEmpty())
    {{-- Empty State --}}
    <div class="text-center py-24">
        <div class="text-7xl mb-6 opacity-20">📰</div>
        <h3 class="text-xl font-bold text-[#1a1445] mb-2">Artikel tidak ditemukan</h3>
        <p class="text-gray-400 mb-6">Coba kata kunci atau kategori lain</p>
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center gap-2 bg-[#1a1445] text-white px-6 py-3 rounded font-bold text-sm hover:bg-[#c4a47c] transition">
            Lihat Semua Artikel
        </a>
    </div>

    @else

    <div class="flex flex-col lg:flex-row gap-10">

        {{-- ── LEFT COLUMN (main content) ── --}}
        <div class="lg:w-2/3">

            {{-- FEATURED ARTICLE --}}
            @if(!request('search') && !request('category') && $articles->currentPage() === 1)
            @php $featured = $articles->first(); @endphp
            <div class="mb-8">
                <p class="section-label mb-4 block">★ Artikel Pilihan</p>
                <a href="{{ $featured->isExternal() ? $featured->external_url : route('articles.show', $featured->slug) }}"
                   class="featured-card"
                   @if($featured->isExternal()) target="_blank" rel="noopener noreferrer" @endif>
                    @if($featured->featured_image)
                        <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}" loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#1a1445] to-[#2d1b69] flex items-center justify-center">
                            <svg class="w-20 h-20 text-[#c4a47c]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    @endif
                    <div class="overlay"></div>
                    <div class="fc-content">
                        <span class="featured-badge">{{ $featured->category ?? 'Berita' }}</span>
                        <h2 class="featured-title">{{ $featured->title }}</h2>
                        <div class="flex items-center gap-3 text-white/60 text-xs">
                            <span>{{ $featured->user->name ?? 'Tim Saung Udjo' }}</span>
                            <span>•</span>
                            <span>{{ $featured->published_at?->translatedFormat('d MMMM Y') }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            {{-- ARTICLE GRID --}}
            @php
                $gridArticles = (!request('search') && !request('category') && $articles->currentPage() === 1)
                    ? $articles->skip(1) : $articles;
            @endphp

            @if($gridArticles->count())
            <div class="articles-grid"
                 x-data="{show:false}"
                 x-init="setTimeout(()=>show=true, 200)"
                 :class="{'opacity-0 translate-y-4':!show, 'opacity-100 translate-y-0 transition-all duration-700':show}">
                @foreach($gridArticles as $article)
                <a href="{{ $article->isExternal() ? $article->external_url : route('articles.show', $article->slug) }}"
                   class="article-card"
                   @if($article->isExternal()) target="_blank" rel="noopener noreferrer" @endif>
                    <div class="card-thumb-wrap">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 alt="{{ $article->title }}" class="card-thumb" loading="lazy">
                        @else
                            <div class="card-thumb-placeholder">📰</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="card-category">
                            {{ $article->category ?? 'Budaya' }}
                            @if($article->isExternal())
                                <span class="inline-flex items-center gap-0.5 ml-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-700 normal-case tracking-normal">↗ Eksternal</span>
                            @endif
                        </p>
                        <h3 class="card-title">{{ $article->title }}</h3>
                        <div class="card-footer-line">
                            <time class="text-gray-400">{{ $article->published_at?->translatedFormat('d M Y') }}</time>
                            <span class="card-read-more">
                                Baca
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            {{-- Kompas-Style Pagination --}}
            @if($articles->hasPages())
            <div class="pagination-wrapper">
                <nav class="pagination-nav" aria-label="Navigasi halaman">
                    {{-- Previous --}}
                    @if($articles->onFirstPage())
                        <span class="page-btn arrow disabled">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            <span>Prev</span>
                        </span>
                    @else
                        <a href="{{ $articles->appends(request()->query())->previousPageUrl() }}" class="page-btn arrow">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            <span>Prev</span>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $currentPage = $articles->currentPage();
                        $lastPage = $articles->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $articles->appends(request()->query())->url(1) }}" class="page-btn">1</a>
                        @if($start > 2)
                            <span class="page-dots">…</span>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $currentPage)
                            <span class="page-btn active">{{ $i }}</span>
                        @else
                            <a href="{{ $articles->appends(request()->query())->url($i) }}" class="page-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span class="page-dots">…</span>
                        @endif
                        <a href="{{ $articles->appends(request()->query())->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
                    @endif

                    {{-- Next --}}
                    @if($articles->hasMorePages())
                        <a href="{{ $articles->appends(request()->query())->nextPageUrl() }}" class="page-btn arrow">
                            <span>Next</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="page-btn arrow disabled">
                            <span>Next</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
                <p class="pagination-info">
                    Halaman <strong>{{ $articles->currentPage() }}</strong> dari <strong>{{ $articles->lastPage() }}</strong>
                    &middot; {{ $articles->total() }} artikel
                </p>
            </div>
            @endif
        </div>

        {{-- ── RIGHT COLUMN (sidebar) ── --}}
        <aside class="lg:w-1/3">
            <div class="sticky top-[53px]">

                {{-- Trending / Terpopuler --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mb-6">
                    <span class="sidebar-section-title">Terpopuler</span>
                    <div>
                        @foreach($articles->take(5) as $idx => $a)
                        <a href="{{ $a->isExternal() ? $a->external_url : route('articles.show', $a->slug) }}"
                           class="trending-item"
                           @if($a->isExternal()) target="_blank" rel="noopener noreferrer" @endif>
                            <span class="trending-num">{{ $idx + 1 }}</span>
                            <div>
                                <p class="trending-title">{{ $a->title }}</p>
                                <span class="trending-cat">{{ $a->category ?? 'Budaya' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>



            </div>
        </aside>

    </div>

    @endif
</main>

{{-- ══════════════════════════
     FOOTER
     ══════════════════════════ --}}
@php $currentLocale = app()->getLocale(); @endphp
<footer class="app-footer">
    <div class="app-footer-inner">

        {{-- Footer grid --}}
        <div class="app-footer-grid">

            {{-- Brand --}}
            <div>
                <a href="{{ route('home', $currentLocale) }}" class="app-footer-logo-link">
                    <img src="{{ asset('images/UdjoFullColor.png') }}" alt="Logo Saung Angklung Udjo"
                        class="app-footer-logo-img">
                    <div style="display: flex; flex-direction: column;">
                        <span class="app-footer-brand-name">Saung Angklung Udjo</span>
                        <span class="app-footer-tagline">{{ t('tagline') }}</span>
                    </div>
                </a>
                <p class="app-footer-desc">{{ t('description') }}</p>
            </div>

            {{-- Navigation links --}}
            <div>
                <span class="app-footer-col-title">WISATA BUDAYA</span>
                <ul class="app-footer-nav-list">
                    <li><a href="#">{{ t('heritage') }}</a></li>
                    <li><a href="#">{{ t('experience') }}</a></li>
                    <li><a href="#">{{ t('visit_us') }}</a></li>
                    <li><a href="{{ route('articles.index', $currentLocale) }}">{{ t('stories') }}</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <span class="app-footer-col-title">{{ t('connect') }}</span>
                <ul class="app-footer-contact-list">
                    <li>{{ t('address') }}</li>
                    <li>+62 821 8282 1200</li>
                    <li>info@angklung-udjo.co.id</li>
                </ul>
            </div>

            {{-- Social Media --}}
            <div>
                <span class="app-footer-col-title">{{ t('follow') }}</span>
                <div class="app-footer-social-row">

                    <a href="https://www.instagram.com/angklungudjo/" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram" class="app-footer-social-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>

                    <a href="https://www.tiktok.com/@saungangklungudjo" target="_blank" rel="noopener noreferrer"
                        aria-label="TikTok" class="app-footer-social-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                        </svg>
                    </a>

                    <a href="https://www.youtube.com/@saungangklungudjo" target="_blank"
                        rel="noopener noreferrer" aria-label="YouTube"
                        class="social-icon w-10 h-10 flex items-center justify-center rounded-full
                              bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50">
                        <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>

                </div>
            </div>

        </div>

        <hr class="app-footer-divider">

        {{-- Footer bottom --}}
        <div class="app-footer-bottom">
            <p class="app-footer-copy">
                &copy; {{ date('Y') }} {{ t('rights') }}
            </p>
            <p class="app-footer-copy">
                Designed &amp; Developed by <span style="cursor:default; color:rgba(255,255,255,0.4);">Muhammad Rifdan Dermawan</span>
            </p>
        </div>

    </div>
</footer>

<script>
    // Reading progress for articles page
    window.addEventListener('scroll', () => {
        const scrollTotal = document.documentElement.scrollHeight - window.innerHeight;
        // (no progress bar on index, just for safety)
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ═══════════════════ SEO META TAGS ═══════════════════ --}}
    @php
        $articleDesc = \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 180);
        $articleImg  = $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/UdjoFullColor.png');
    @endphp
    @include('partials.seo', [
        'title'         => $article->title . ' — Saung Angklung Udjo',
        'description'   => $articleDesc,
        'image'         => $articleImg,
        'type'          => 'article',
        'keywords'      => ($article->tags ?? '') . ', saung angklung udjo, artikel budaya, angklung',
        'publishedTime' => optional($article->published_at ?? $article->created_at)->toIso8601String(),
        'modifiedTime'  => optional($article->updated_at)->toIso8601String(),
        'author'        => $article->author ?? 'Saung Angklung Udjo',
        'section'       => $article->category ?? 'Budaya',
    ])

    {{-- Schema.org Article --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": @json($article->title),
        "description": @json($articleDesc),
        "image": @json($articleImg),
        "datePublished": @json(optional($article->published_at ?? $article->created_at)->toIso8601String()),
        "dateModified": @json(optional($article->updated_at)->toIso8601String()),
        "author": { "@type": "Organization", "name": @json($article->author ?? 'Saung Angklung Udjo'), "url": @json(url('/')) },
        "publisher": {
            "@type": "Organization", "name": "Saung Angklung Udjo",
            "logo": { "@type": "ImageObject", "url": @json(asset('images/UdjoFullColor.png')) }
        },
        "mainEntityOfPage": { "@type": "WebPage", "@id": @json(url()->current()) }
    }
    </script>

    @include('partials.schema-organization')

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
            --navy:     #1a1445;
            --gold:     #1a1445;
            --gold-dark:#b08d62;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html, body { overflow-x: hidden; }

        body {
            font-family: 'Inter', sans-serif;
            color: #1a1a1a;
            background: #fff;
        }
        .font-spirax { font-family: 'Spirax', cursive; }
        .font-serif  { font-family: 'Libre Baskerville', serif; }
        .font-lora   { font-family: 'Lora', serif; }

        /* ────────────────────────────────────────────────────────
           READING PROGRESS BAR
        ──────────────────────────────────────────────────────── */
        #reading-progress {
            position: fixed; top: 0; left: 0; height: 3px;
            width: 0%; background: var(--gold); z-index: 10000;
            transition: width 0.1s linear;
        }

        /* ────────────────────────────────────────────────────────
           TOP INFO BAR
        ──────────────────────────────────────────────────────── */
        .topbar {
            background: var(--navy);
            border-bottom: 2px solid var(--gold);
            padding: 0.45rem 0;
        }

        /* ────────────────────────────────────────────────────────
           BRAND HEADER
        ──────────────────────────────────────────────────────── */
        .brand-header {
            background: #fff;
            border-bottom: 1px solid #e5e5e5;
            padding: 0.9rem 0;
        }

        /* Search pill */
        .search-pill {
            display: flex; align-items: center; gap: 0.5rem;
            background: #f4f4f4; border: 1.5px solid #e0e0e0;
            border-radius: 50px; padding: 0.4rem 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-pill:focus-within {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196,164,124,0.15);
        }
        .search-pill input { background: transparent; border: none; outline: none; font-size: 0.82rem; width: 100%; }

        /* BOOK NOW button */
        .btn-book {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--gold); color: #fff;
            padding: 0.55rem 1.3rem;
            font-size: 0.7rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.12em;
            border-radius: 4px; text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            white-space: nowrap;
        }
        .btn-book:hover { background: var(--gold-dark); transform: translateY(-1px); }

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
            padding: 0.7rem 1rem;
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: #444; white-space: nowrap;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }
        .cat-link:hover  { color: var(--gold); }
        .cat-link.active { color: var(--navy); border-bottom-color: var(--gold); }

        /* ────────────────────────────────────────────────────────
           ARTICLE CONTENT AREA
        ──────────────────────────────────────────────────────── */

        /* Breadcrumb */
        .breadcrumb {
            font-size: 0.68rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.2em;
            color: var(--gold);
        }

        /* Category pill on article */
        .article-cat-badge {
            display: inline-block;
            padding: 0.25rem 0.85rem;
            background: var(--gold); color: #fff;
            font-size: 0.65rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.1em;
            border-radius: 3px; margin-bottom: 0.75rem;
        }

        /* Article title */
        .article-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 800; line-height: 1.15;
            color: var(--navy); letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        /* Author meta */
        .author-avatar {
            width: 2.5rem; height: 2.5rem; border-radius: 50%;
            background: linear-gradient(135deg, var(--navy), #2d1b69);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 1rem;
            flex-shrink: 0;
        }

        /* Share buttons */
        .share-btn {
            width: 2.25rem; height: 2.25rem; border-radius: 50%;
            border: 1.5px solid #e5e5e5;
            display: flex; align-items: center; justify-content: center;
            color: #999; text-decoration: none;
            transition: all 0.2s;
        }
        .share-btn:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .share-btn.wa:hover { background: #25D366; border-color: #25D366; }

        /* Article typography */
        .article-content {
            font-family: 'Lora', serif;
            font-size: 1.1rem; line-height: 2;
            color: #2a2a2a;
        }
        .article-content p { margin-bottom: 1.6rem; }
        .article-content h2 { font-family: 'Libre Baskerville', serif; font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 2rem 0 1rem; }
        .article-content h3 { font-family: 'Libre Baskerville', serif; font-size: 1.2rem; font-weight: 700; color: var(--navy); margin: 1.5rem 0 0.75rem; }
        .article-content blockquote {
            border-left: 4px solid var(--gold);
            padding: 0.5rem 1.5rem;
            margin: 2rem 0;
            background: #fafaf8;
            font-style: italic; color: #555;
            font-size: 1.15rem;
        }
        .article-content a { color: var(--gold); text-decoration: underline; }
        .article-content ul, .article-content ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
        .article-content li { margin-bottom: 0.5rem; }

        /* Image Slider */
        .slider-container {
            height: 480px;
            background: #f5f5f0;
            position: relative; overflow: hidden;
            border-radius: 8px;
        }
        .slider-img { width: 100%; height: 100%; object-fit: cover; }

        /* ────────────────────────────────────────────────────────
           MOBILE RESPONSIVE
        ──────────────────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .article-content { font-size: 1rem; line-height: 1.85; }
            .article-content h2 { font-size: 1.3rem; }
            .article-content h3 { font-size: 1.1rem; }
        }

        @media (max-width: 768px) {
            /* Header */
            .brand-header { padding: 0.6rem 0; }
            .brand-header .font-spirax { font-size: 1rem !important; }
            .brand-header .text-\[8px\] { font-size: 6px !important; letter-spacing: 0.25em !important; }
            .btn-book { padding: 0.45rem 0.9rem; font-size: 0.62rem; }
            .search-pill { display: none !important; }

            /* Category Nav */
            .cat-nav { border-bottom: 1px solid #eee; }
            .cat-link { padding: 0.6rem 0.7rem; font-size: 0.65rem; }

            /* Article */
            .article-title { font-size: 1.5rem; line-height: 1.25; margin-bottom: 0.75rem; }
            .article-cat-badge { font-size: 0.58rem; padding: 0.2rem 0.65rem; margin-bottom: 0.5rem; }
            .breadcrumb { font-size: 0.6rem; letter-spacing: 0.12em; margin-bottom: 0.5rem !important; }

            /* Author & Share */
            .author-avatar { width: 2rem; height: 2rem; font-size: 0.8rem; }

            /* Image Slider */
            .slider-container { height: 220px; border-radius: 6px; }
            .slider-container button { width: 2rem; height: 2rem; }
            .slider-container button svg { width: 1rem; height: 1rem; }

            /* Article Body */
            .article-content { font-size: 0.95rem; line-height: 1.8; }
            .article-content p { margin-bottom: 1.2rem; }
            .article-content blockquote { padding: 0.4rem 1rem; font-size: 1rem; margin: 1.5rem 0; }
            .article-content h2 { font-size: 1.2rem; margin: 1.5rem 0 0.75rem; }
            .article-content h3 { font-size: 1.05rem; margin: 1rem 0 0.5rem; }

            /* Tags */
            .article-tag { padding: 0.25rem 0.65rem; font-size: 0.62rem; }

            /* Sidebar */
            .trending-num { font-size: 1.5rem; }
            .trending-title { font-size: 0.78rem; }

            /* Other Articles */
            .other-articles-section { padding: 2.5rem 0; margin-top: 2rem; }
            .section-heading { font-size: 1.4rem; }
            .section-subheading { font-size: 0.8rem; margin-bottom: 1.5rem; }
            .other-card-img { height: 160px; }
            .other-card-body { padding: 1rem; }
            .other-card-title { font-size: 0.9rem; }

            /* Next Article */
            .next-article-card { padding: 1rem; }

            /* CTA Card */
            .cta-card-bg { padding: 1.25rem; }
        }

        @media (max-width: 480px) {
            .article-title { font-size: 1.3rem; }
            .slider-container { height: 180px; }
            .article-content { font-size: 0.9rem; line-height: 1.75; }
            .other-card-img { height: 140px; }
            .section-heading { font-size: 1.2rem; }
            .brand-header .font-spirax { font-size: 0.9rem !important; }
        }

        /* ────────────────────────────────────────────────────────
           NEXT ARTICLE CARD
        ──────────────────────────────────────────────────────── */
        .next-article-card {
            border: 1px solid #e8e8e8; border-radius: 12px;
            padding: 1.5rem; background: #fafaf8;
            display: flex; flex-wrap: wrap; gap: 1rem;
            align-items: center; justify-content: space-between;
            transition: box-shadow 0.2s;
        }
        .next-article-card:hover { box-shadow: 0 8px 32px rgba(26,20,69,0.1); }

        /* ────────────────────────────────────────────────────────
           SIDEBAR
        ──────────────────────────────────────────────────────── */
        .sidebar-section-title {
            font-size: 0.68rem; font-weight: 900;
            text-transform: uppercase; letter-spacing: 0.18em;
            color: var(--navy);
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--gold);
            display: inline-block; margin-bottom: 1.25rem;
        }
        .trending-item {
            display: flex; gap: 0.75rem; align-items: flex-start;
            padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0;
            text-decoration: none;
        }
        .trending-item:last-child { border-bottom: none; }
        .trending-num {
            font-size: 2rem; font-weight: 900; line-height: 1;
            color: #e8e8e8; min-width: 2rem; transition: color 0.2s;
        }
        .trending-item:hover .trending-num { color: var(--gold); }
        .trending-title {
            font-size: 0.82rem; font-weight: 700;
            color: var(--navy); line-height: 1.35; transition: color 0.2s;
        }
        .trending-item:hover .trending-title { color: var(--gold); }
        .trending-cat {
            font-size: 0.6rem; font-weight: 700; color: var(--gold);
            text-transform: uppercase; letter-spacing: 0.08em;
            margin-top: 0.2rem; display: block;
        }

        /* Tags */
        .article-tag {
            padding: 0.3rem 0.9rem;
            background: #f0f0f0; border-radius: 3px;
            font-size: 0.7rem; font-weight: 700; color: #555;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .article-tag:hover { background: var(--gold); color: #fff; }

        /* ────────────────────────────────────────────────────────
           BERITA LAINNYA SECTION
        ──────────────────────────────────────────────────────── */
        .other-articles-section {
            background: #fafaf8;
            padding: 3.5rem 0;
            margin-top: 3rem;
            border-top: 1px solid #e8e8e8;
        }
        .section-heading {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.8rem; font-weight: 800;
            color: var(--navy);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .section-subheading {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }
        .other-article-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            display: block;
            border: 1px solid #eee;
        }
        .other-article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(26,20,69,0.12);
        }
        .other-card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .other-article-card:hover .other-card-img {
            transform: scale(1.05);
        }
        .other-card-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #e8e6f0, #d5d0e8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            opacity: 0.35;
        }
        .other-card-body {
            padding: 1.25rem;
        }
        .other-card-category {
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }
        .other-card-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.4;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .other-article-card:hover .other-card-title {
            color: var(--gold);
        }
        .other-card-date {
            font-size: 0.72rem;
            color: #999;
        }

        /* ────────────────────────────────────────────────────────
           CTA CARD (SIDEBAR)
        ──────────────────────────────────────────────────────── */
        .cta-card-bg {
            background: linear-gradient(135deg, var(--navy) 0%, #2d1b69 100%);
            padding: 1.5rem;
            text-align: center;
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
    </style>
</head>
<body>

{{-- Reading Progress Bar --}}
<div id="reading-progress"></div>


{{-- ══════════════════════════
     BRAND HEADER
     ══════════════════════════ --}}
<header class="brand-header">
    <div class="max-w-screen-xl mx-auto px-4 flex flex-wrap justify-between items-center gap-4">

        {{-- Logo --}}
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
                <div class="search-pill w-52 focus-within:w-72 transition-all duration-300">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari artikel...">
                </div>
            </form>

            {{-- BOOK NOW --}}
            <a href="{{ route('tickets.buy') }}" class="btn-book" id="btn-book-now-show">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Book Now
            </a>
        </div>
    </div>
</header>

{{-- ══════════════════════════
     CATEGORY NAV BAR (sticky)
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
     MAIN ARTICLE CONTENT
     ══════════════════════════ --}}
<main class="max-w-screen-xl mx-auto px-4 py-10">
    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ── LEFT / MAIN COLUMN ── --}}
        <article class="lg:w-2/3">

            {{-- Breadcrumb --}}
            <nav class="breadcrumb mb-4">
                <a href="{{ route('articles.index') }}" class="hover:underline">Udjo News</a>
                <span class="mx-2 opacity-40">/</span>
                <span>{{ $article->category ?? 'Artikel' }}</span>
                <span class="mx-2 opacity-40">/</span>
                <span class="text-gray-400 font-normal normal-case tracking-normal" style="font-size:0.72rem;">Detail</span>
            </nav>

            {{-- Category Badge --}}
            <span class="article-cat-badge">{{ $article->category ?? 'Berita' }}</span>

            {{-- Title --}}
            <h1 class="article-title">{{ $article->title }}</h1>

            {{-- Author Meta & Share --}}
            <div class="flex flex-wrap items-center justify-between border-b border-gray-100 pb-5 mb-7 gap-4">
                <div class="flex items-center gap-3">
                    <div class="author-avatar">{{ substr($article->user->name ?? 'A', 0, 1) }}</div>
                    <div>
                        <p class="font-bold text-sm text-[#1a1445]">{{ $article->user->name ?? 'Admin Saung Udjo' }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">
                            {{ $article->published_at?->translatedFormat('d F Y, H:i') }} WIB
                            @if($article->published_at && $article->updated_at && $article->updated_at->gt($article->published_at->addHour()))
                                &bull; <span class="italic">Diperbarui {{ $article->updated_at->translatedFormat('d M Y') }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Share Buttons --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-1">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" class="share-btn" aria-label="Share to Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}"
                       target="_blank" class="share-btn" aria-label="Share to Twitter/X">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                       target="_blank" class="share-btn wa" aria-label="Share via WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                </div>
            </div>

            {{-- IMAGE / SLIDER --}}
            @if($article->featured_image || $article->images->isNotEmpty())
            <div class="mb-8 rounded-xl overflow-hidden shadow-xl"
                 x-data="{ active: 0, total: {{ $article->images->isNotEmpty() ? $article->images->count() : 1 }} }">
                <div class="slider-container">
                    @php
                        $images = $article->images->isNotEmpty()
                            ? $article->images
                            : collect([(object)['image_path' => $article->featured_image]]);
                    @endphp

                    @foreach($images as $idx => $img)
                        <div x-show="active === {{ $idx }}"
                             x-transition:enter="transition duration-500 ease-in-out"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition duration-500 ease-in-out"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 w-full h-full">
                            @if($img->image_path)
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="slider-img" alt="Gallery {{ $idx+1 }}">
                            @endif
                        </div>
                    @endforeach

                    {{-- Slider Controls (if multiple images) --}}
                    @if($images->count() > 1)
                    <div class="absolute inset-0 flex items-center justify-between px-4 pointer-events-none z-10">
                        <button @click="active = (active - 1 + total) % total"
                                class="pointer-events-auto w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg>
                        </button>
                        <button @click="active = (active + 1) % total"
                                class="pointer-events-auto w-10 h-10 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center shadow-lg hover:bg-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
                        </button>
                    </div>
                    {{-- Dots --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        @foreach($images as $idx => $img)
                        <button @click="active = {{ $idx }}"
                                :class="active === {{ $idx }} ? 'bg-white w-6' : 'bg-white/50 w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                    @endif
                </div>

                @if(isset($article->image_caption) && $article->image_caption)
                    <p class="text-xs text-gray-400 mt-3 italic text-center font-lora px-4">{{ $article->image_caption }}</p>
                @endif
            </div>
            @endif

            {{-- ARTICLE BODY --}}
            <div class="article-content mb-10" id="article-body">
                {!! nl2br(e($article->content)) !!}
            </div>

            {{-- TAGS --}}
            <div class="flex flex-wrap gap-2 items-center pt-6 border-t border-gray-100 mb-10">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-1">Tags:</span>
                <a href="{{ route('articles.index') }}" class="article-tag">#SaungUdjo</a>
                <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="article-tag">#{{ strtoupper($article->category ?? 'Budaya') }}</a>
                @if($article->tags)
                    @foreach(explode(',', $article->tags) as $tag)
                        <span class="article-tag">#{{ trim($tag) }}</span>
                    @endforeach
                @endif
            </div>


        </article>

        {{-- ── RIGHT / SIDEBAR ── --}}
        <aside class="lg:w-1/3">
            <div class="sticky top-[53px] space-y-6">

                {{-- Terpopuler --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <span class="sidebar-section-title">Terpopuler</span>
                    <div>
                        @if(isset($relatedArticles))
                            @foreach($relatedArticles->take(5) as $idx => $related)
                            <a href="{{ $related->isExternal() ? $related->external_url : route('articles.show', $related->slug) }}"
                               class="trending-item"
                               @if($related->isExternal()) target="_blank" rel="noopener noreferrer" @endif>
                                <span class="trending-num">{{ $idx + 1 }}</span>
                                <div>
                                    <p class="trending-title">{{ $related->title }}</p>
                                    <span class="trending-cat">{{ $related->category }}</span>
                                </div>
                            </a>
                            @endforeach
                        @endif
                    </div>
                </div>



                {{-- Ad Placeholder --}}
                <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 h-64 flex flex-col items-center justify-center p-6 text-center">
                    <span class="text-xs font-bold text-gray-300 uppercase tracking-widest">Space Iklan</span>
                </div>

            </div>
        </aside>

    </div>
</main>

{{-- ══════════════════════════
     BERITA LAINNYA SECTION
     ══════════════════════════ --}}
@if(isset($relatedArticles) && $relatedArticles->count() > 0)
<section class="other-articles-section">
    <div class="max-w-screen-xl mx-auto px-4">
        <h2 class="section-heading">Berita Lainnya</h2>
        <p class="section-subheading">Artikel terbaru dari Saung Angklung Udjo</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedArticles->take(3) as $other)
            <a href="{{ $other->isExternal() ? $other->external_url : route('articles.show', $other->slug) }}"
               class="other-article-card"
               @if($other->isExternal()) target="_blank" rel="noopener noreferrer" @endif>
                <div style="overflow: hidden;">
                    @if($other->featured_image)
                        <img src="{{ asset('storage/' . $other->featured_image) }}"
                             alt="{{ $other->title }}"
                             class="other-card-img">
                    @else
                        <div class="other-card-placeholder">📰</div>
                    @endif
                </div>
                <div class="other-card-body">
                    <p class="other-card-category">{{ $other->category ?? 'Berita' }}</p>
                    <h3 class="other-card-title">{{ $other->title }}</h3>
                    <p class="other-card-date">{{ $other->published_at?->translatedFormat('d F Y') ?? $other->created_at?->translatedFormat('d F Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

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
                        rel="noopener noreferrer" aria-label="YouTube" class="app-footer-social-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
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
    // Reading Progress Bar
    const progressBar = document.getElementById('reading-progress');
    const articleBody = document.getElementById('article-body');

    window.addEventListener('scroll', () => {
        if (!progressBar || !articleBody) return;
        const articleTop    = articleBody.offsetTop;
        const articleBottom = articleTop + articleBody.offsetHeight;
        const scrolled      = window.scrollY + window.innerHeight;
        const progress      = Math.min(100, Math.max(0,
            ((window.scrollY - articleTop) / (articleBottom - articleTop)) * 100
        ));
        progressBar.style.width = progress + '%';
    });

    // Touch Swipe Support for Image Slider
    document.querySelectorAll('.slider-container').forEach(slider => {
        let startX = 0;
        let endX = 0;
        slider.addEventListener('touchstart', e => { startX = e.changedTouches[0].screenX; }, { passive: true });
        slider.addEventListener('touchend', e => {
            endX = e.changedTouches[0].screenX;
            const diff = startX - endX;
            if (Math.abs(diff) > 50) {
                const alpineData = Alpine.$data(slider.closest('[x-data]'));
                if (alpineData) {
                    if (diff > 0) {
                        alpineData.active = (alpineData.active + 1) % alpineData.total;
                    } else {
                        alpineData.active = (alpineData.active - 1 + alpineData.total) % alpineData.total;
                    }
                }
            }
        }, { passive: true });
    });
</script>

</body>
</html>

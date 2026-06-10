{{--
  ┌──────────────────────────────────────────────────────────────────┐
  │  SEO Partial — Saung Angklung Udjo                                │
  │  Pemakaian:                                                       │
  │  @include('partials.seo', [                                       │
  │      'title'       => 'Pesan Tiket',                              │
  │      'description' => 'Booking tiket pertunjukan angklung...',    │
  │      'image'       => asset('images/share.jpg'), // optional      │
  │      'type'        => 'website', // website | article | product   │
  │      'keywords'    => 'tiket, angklung, bandung', // optional     │
  │  ])                                                               │
  └──────────────────────────────────────────────────────────────────┘
--}}

@php
    // ── Default values ─────────────────────────────────────────────
    $siteName     = 'Saung Angklung Udjo';
    $defaultTitle = 'Saung Angklung Udjo — Wisata Budaya UNESCO Bandung';
    $defaultDesc  = 'Saung Angklung Udjo, destinasi wisata budaya UNESCO di Bandung sejak 1966. Nikmati pertunjukan angklung, wayang golek, dan tari tradisional Sunda. Booking tiket online sekarang.';
    $defaultImg   = asset('images/UdjoFullColor.png');

    // ── Resolve values ─────────────────────────────────────────────
    $seoTitle    = $title ?? $defaultTitle;
    $seoFullTitle = str_contains($seoTitle, $siteName) ? $seoTitle : $seoTitle . ' — ' . $siteName;
    $seoDesc     = $description ?? $defaultDesc;
    $seoImage    = $image ?? $defaultImg;
    $seoType     = $type ?? 'website';
    $seoKeywords = $keywords ?? 'saung angklung udjo, wisata bandung, angklung, unesco, pertunjukan tradisional, wayang golek, budaya sunda, tiket bandung';
    $seoUrl      = url()->current();
    $seoLocale   = app()->getLocale() === 'en' ? 'en_US' : 'id_ID';

    // Truncate description (160 chars optimal for Google, 200 max)
    $seoDesc = mb_strlen($seoDesc) > 200 ? mb_substr($seoDesc, 0, 197) . '...' : $seoDesc;
@endphp

{{-- ═══════════════════ PRIMARY META ═══════════════════ --}}
<title>{{ $seoFullTitle }}</title>
<meta name="description" content="{{ $seoDesc }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="author" content="{{ $siteName }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $seoUrl }}">

{{-- Hreflang (Bahasa) --}}
<link rel="alternate" hreflang="id" href="{{ url()->current() }}">
<link rel="alternate" hreflang="en" href="{{ url()->current() }}">
<link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

{{-- Theme Color (untuk mobile browser) --}}
<meta name="theme-color" content="#1a1445">
<meta name="msapplication-TileColor" content="#1a1445">

{{-- ═══════════════════ OPEN GRAPH (Facebook, WhatsApp, LinkedIn, etc) ═══════════════════ --}}
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoFullTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:secure_url" content="{{ $seoImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $seoTitle }}">
<meta property="og:locale" content="{{ $seoLocale }}">
<meta property="og:locale:alternate" content="{{ $seoLocale === 'id_ID' ? 'en_US' : 'id_ID' }}">

{{-- Article-specific OG (kalau type=article) --}}
@if($seoType === 'article')
    @isset($publishedTime)
        <meta property="article:published_time" content="{{ $publishedTime }}">
    @endisset
    @isset($modifiedTime)
        <meta property="article:modified_time" content="{{ $modifiedTime }}">
    @endisset
    @isset($author)
        <meta property="article:author" content="{{ $author }}">
    @endisset
    @isset($section)
        <meta property="article:section" content="{{ $section }}">
    @endisset
@endif

{{-- ═══════════════════ TWITTER CARD ═══════════════════ --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@saungangklungudjo">
<meta name="twitter:creator" content="@saungangklungudjo">
<meta name="twitter:title" content="{{ $seoFullTitle }}">
<meta name="twitter:description" content="{{ $seoDesc }}">
<meta name="twitter:image" content="{{ $seoImage }}">
<meta name="twitter:image:alt" content="{{ $seoTitle }}">

{{-- ═══════════════════ DUBLIN CORE (untuk academic/cultural sites) ═══════════════════ --}}
<meta name="DC.title" content="{{ $seoFullTitle }}">
<meta name="DC.creator" content="{{ $siteName }}">
<meta name="DC.subject" content="Cultural Heritage, Indonesian Music, UNESCO">
<meta name="DC.description" content="{{ $seoDesc }}">
<meta name="DC.publisher" content="{{ $siteName }}">
<meta name="DC.language" content="{{ app()->getLocale() }}">

{{-- ═══════════════════ GEO TAGS (lokasi fisik) ═══════════════════ --}}
<meta name="geo.region" content="ID-JB">
<meta name="geo.placename" content="Bandung, Jawa Barat, Indonesia">
<meta name="geo.position" content="-6.9027;107.6532">
<meta name="ICBM" content="-6.9027, 107.6532">

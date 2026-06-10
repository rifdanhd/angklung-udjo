@extends('layouts.app', [
    'seoTitle'       => $product->name . ' — Angklung Tradisional',
    'seoDescription' => \Illuminate\Support\Str::limit(strip_tags($product->description ?? 'Produk angklung tradisional berkualitas dari Saung Angklung Udjo, Bandung.'), 180),
    'seoKeywords'    => 'beli ' . strtolower($product->name) . ', angklung tradisional, ' . ($product->category ?? 'angklung') . ', produk angklung udjo',
    'seoImage'       => $product->image ? asset('storage/' . $product->image) : asset('images/UdjoFullColor.png'),
    'seoType'        => 'product',
])

@section('title', $product->name . ' — Angklung Tradisional')

{{-- ═══════════════════ SCHEMA.ORG PRODUCT ═══════════════════ --}}
@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": @json($product->name),
    "description": @json(strip_tags($product->description ?? '')),
    "image": @json($product->image ? asset('storage/' . $product->image) : asset('images/UdjoFullColor.png')),
    "url": @json(url()->current()),
    "brand": {
        "@type": "Brand",
        "name": "Saung Angklung Udjo"
    },
    "manufacturer": {
        "@type": "Organization",
        "name": "Saung Angklung Udjo",
        "url": @json(url('/'))
    },
    @if(isset($product->price) && $product->price > 0)
    "offers": {
        "@type": "Offer",
        "url": @json(url()->current()),
        "priceCurrency": "IDR",
        "price": @json((string) (int) $product->price),
        "availability": @json(($product->stock ?? 1) > 0 ? "https://schema.org/InStock" : "https://schema.org/OutOfStock"),
        "seller": {
            "@type": "Organization",
            "name": "Saung Angklung Udjo"
        }
    },
    @endif
    "category": @json($product->category ?? "Musical Instrument")
}
</script>
@endpush

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>

        /* ── LIGHTBOX ── */
.lightbox-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.92);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 16px;
}

.lightbox-overlay.active {
    display: flex;
}

.lightbox-img-wrap {
    position: relative;
    max-width: 90vw;
    max-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-img-wrap img {
    max-width: 90vw;
    max-height: 78vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    transition: opacity 0.2s;
}

.lightbox-close {
    position: fixed;
    top: 20px;
    right: 24px;
    background: none;
    border: none;
    color: #fff;
    font-size: 36px;
    cursor: pointer;
    line-height: 1;
    opacity: 0.7;
    transition: 0.2s;
}

.lightbox-close:hover { opacity: 1; }

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(6px);
    color: #fff;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 20px;
    transition: 0.2s;
    user-select: none;
}

.lightbox-nav:hover { background: rgba(196,164,124,0.4); }
.lightbox-nav.prev { left: -56px; }
.lightbox-nav.next { right: -56px; }
.lightbox-nav.hidden { display: none; }

.lightbox-thumbs {
    display: flex;
    gap: 8px;
    max-width: 90vw;
    overflow-x: auto;
    padding: 4px 0;
}

.lightbox-thumb {
    width: 52px;
    height: 52px;
    border-radius: 6px;
    border: 2px solid transparent;
    overflow: hidden;
    cursor: pointer;
    flex-shrink: 0;
    opacity: 0.55;
    transition: 0.2s;
}

.lightbox-thumb.active {
    border-color: var(--gold);
    opacity: 1;
}

.lightbox-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lightbox-counter {
    color: rgba(255,255,255,0.45);
    font-size: 12px;
    letter-spacing: .1em;
}

.main-img-box {
    cursor: zoom-in; /* tambahkan ini */
}
        :root {
            --gold: #c4a47c;
            --navy: #1a1445;
            --white: #ffffff;
            --bg: #ffffff;
            --gray-border: #e5e7eb;
            --gray-text: #6d7588;
        }

        body {
            background: var(--bg);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* ── HERO ── */
        .show-hero {
            position: relative;
            height: 40vh;
            min-height: 300px;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            padding: 0 clamp(1.5rem, 5vw, 4rem) 3rem;
            padding-top: 100px;
        }

        .show-hero-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(13, 11, 46, 0.85) 0%, rgba(26, 20, 69, 0.75) 50%, rgba(34, 24, 93, 0.85) 100%),
                url('{{ asset('img/Angklungmasal.webp') }}') center/cover no-repeat;
            z-index: 1;
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(135deg, transparent 0, transparent 40px, rgba(196, 164, 124, .025) 40px, rgba(196, 164, 124, .025) 41px);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 5;
            width: 100%;
        }

        .bc-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 1rem;
        }

        .bc-inner a {
            color: inherit;
            text-decoration: none;
            transition: 0.2s;
        }

        .bc-inner a:hover {
            color: var(--gold);
        }

        .bc-inner .cur {
            color: #fff;
        }

        .bc-inner .sep-line {
            opacity: 0.2;
            margin: 0 8px;
            color: #fff;
        }

        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            color: #fff;
            line-height: 1.2;
            font-weight: 400;
        }

        /* ── LAYOUT 3 KOLOM ── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .product-layout {
            display: grid;
            grid-template-columns: 348px 1fr 268px;
            gap: 32px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            align-items: start;
        }

        /* KOLOM 1: GALLERY */
        .gallery-sticky {
            position: sticky;
            top: 100px;
        }

        .main-img-box {
            width: 348px;
            height: 348px;
            border-radius: 12px;
            border: 1px solid var(--gray-border);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .main-img-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .main-img-box .no-img {
            font-size: 64px;
            color: #ddd;
        }

        .thumb-list {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .thumb-item {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            border: 1px solid var(--gray-border);
            cursor: pointer;
            overflow: hidden;
            background: white;
            flex-shrink: 0;
        }

        .thumb-item.active {
            border-color: var(--gold);
            border-width: 2px;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* KOLOM 2: INFO */
        .product-info-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--gray-border);
        }

        .product-info-card h1 {
            font-size: 20px;
            font-weight: 700;
            color: #31353b;
            margin: 0 0 10px;
        }

        .price-display {
            font-size: 30px;
            font-weight: 700;
            color: #31353b;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .description-text {
            font-size: 14px;
            line-height: 1.6;
            color: #6d7588;
            margin-top: 20px;
            white-space: pre-line;
        }

        /* Stock badge */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stock-ok {
            background: #dcfce7;
            color: #15803d;
        }

        .stock-low {
            background: #fef9c3;
            color: #854d0e;
        }

        .stock-empty {
            background: #fee2e2;
            color: #dc2626;
        }

        /* KOLOM 3: STICKY CARD */
        .sticky-card {
            border: 1px solid var(--gray-border);
            border-radius: 12px;
            padding: 16px;
            position: sticky;
            top: 100px;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .qty-input {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: fit-content;
            padding: 2px;
        }

        .qty-btn {
            width: 30px;
            border: none;
            background: none;
            color: var(--gold);
            font-weight: bold;
            cursor: pointer;
            font-size: 18px;
        }

        .qty-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .qty-val {
            width: 40px;
            text-align: center;
            border: none;
            font-weight: 700;
            outline: none;
        }

        .btn-buy {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-weight: 800;
            border: none;
            background: var(--gold);
            color: #1a1445;
            cursor: pointer;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
        }

        .btn-buy:hover {
            background: #b89240;
            transform: translateY(-2px);
        }

        .btn-buy:disabled {
            background: #e2e0f0;
            color: #aaa;
            cursor: not-allowed;
            transform: none;
        }

        /* ── RELATED ── */
        .related-section {
            margin-top: 60px;
            border-top: 8px solid #f0f3f7;
            padding: 40px 0 80px;
        }

        .recommend-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
        }

        .mini-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            text-decoration: none;
            transition: 0.2s;
            background: white;
        }

        .mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .mini-img {
            width: 100%;
            aspect-ratio: 1/1;
            background: #f8f8f8;
            overflow: hidden;
        }

        .mini-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mini-img .mini-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #ddd;
        }

        .mini-info {
            padding: 10px;
        }

        .mini-name {
            font-size: 12px;
            color: #31353b;
            height: 34px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .mini-price {
            font-size: 14px;
            font-weight: 700;
            color: #31353b;
            margin-top: 5px;
        }

        /* ── MOBILE ── */
        .mobile-cta {
            display: none;
        }

        @media (max-width: 768px) {
            .product-layout {
                grid-template-columns: 1fr;
                gap: 0;
                padding-top: 0;
                margin-top: 0;
            }

            .gallery-sticky {
                position: static;
            }

            .main-img-box {
                width: 100vw;
                height: 100vw;
                border-radius: 0;
                border: none;
                margin-left: -20px;
                margin-right: -20px;
            }

            .product-info-card {
                border-radius: 0;
                border-left: none;
                border-right: none;
            }

            .sticky-card {
                position: static;
                border: none;
                box-shadow: none;
                border-radius: 0;
                border-top: 8px solid #f0f3f7;
                border-bottom: 8px solid #f0f3f7;
                width: 100vw;
                margin-left: -20px;
                padding: 15px 20px;
            }

            .sticky-card .btn-buy {
                display: none;
            }

            .recommend-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .related-section {
                margin-bottom: 80px;
            }

            .mobile-cta {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #fff;
                padding: 10px 15px;
                box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
                z-index: 1000;
                gap: 10px;
                border-top: 1px solid #f0f0f0;
            }

            .btn-chat-mob {
                width: 45px;
                height: 45px;
                border: 1px solid #ddd;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                flex-shrink: 0;
            }

            .btn-buy-mob {
                flex: 1;
                background: var(--gold);
                color: #1a1445;
                border: none;
                padding: 12px;
                border-radius: 8px;
                font-weight: 800;
                font-size: 14px;
                text-align: center;
                text-decoration: none;
                cursor: pointer;
                font-family: 'Inter', sans-serif;
            }

            .btn-buy-mob.disabled {
                background: #e2e0f0;
                color: #aaa;
                cursor: not-allowed;
            }
        }
    </style>
@endpush

@section('content')

    @php
        /* ── Satu tempat definisi, dipakai ulang di seluruh view ── */
      $WA_NUMBER = '628112124050';
        $images = $product->images ?? [];
        $hasImg = count($images) > 0;
        $available = $product->is_available && $product->stock > 0;
        $stockLabel = $product->stock > 10 ? 'Tersedia' : ($product->stock > 0 ? "Sisa {$product->stock}" : 'Habis');
        $stockClass = $product->stock > 10 ? 'stock-ok' : ($product->stock > 0 ? 'stock-low' : 'stock-empty');
        $waText =
            "Halo Admin Saung Angklung Udjo! 👋\n\nSaya ingin memesan produk:\n\n" .
            "🛍️ *{$product->name}*\n" .
            '💰 Harga: Rp ' .
            number_format($product->price, 0, ',', '.') .
            "\n\n" .
            'Mohon info ketersediaan dan cara pemesanannya 🙏';
    @endphp

    {{-- HERO --}}
    <div class="show-hero">
        <div class="show-hero-bg"></div>
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="bc-inner">
                <a href="/">BERANDA</a>
                <span>›</span>
                <a href="{{ route('products.index') }}">PESAN ANGKLUNG</a>
                <span class="sep-line">|</span>
                <span class="cur">{{ Str::limit($product->name, 40) }}</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-layout">

            {{-- KOLOM 1: GALLERY --}}
            <div class="gallery-sticky">
            <div class="main-img-box" onclick="openLightbox(currentLightboxIndex)">
    @if ($hasImg)
        <img id="mainImage" src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}">
    @else
        <div class="no-img">🎵</div>
    @endif
</div>

                @if ($hasImg && count($images) > 1)
                    <div class="thumb-list">
                        @foreach ($images as $index => $image)
                            <div class="thumb-item {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeImage('{{ asset('storage/' . $image) }}', this)">
                                <img src="{{ asset('storage/' . $image) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- KOLOM 2: INFO --}}
            <div class="product-info-column">
                <div class="product-info-card">
                    <h1>{{ $product->name }}</h1>
                    <div style="font-size:14px;color:#6d7588">
                        Terjual <span style="color:#31353b;font-weight:600">10 rb+</span>
                    </div>

                    <div class="price-display">Rp{{ number_format($product->price, 0, ',', '.') }}</div>

                    <div style="margin-top:12px">
                        <span class="stock-badge {{ $stockClass }}">{{ $stockLabel }}</span>
                    </div>

                    <div
                        style="margin-top:20px;font-weight:700;color:var(--gold);border-bottom:2px solid var(--gold);width:fit-content;padding-bottom:5px;text-transform:uppercase;font-size:12px;letter-spacing:1px">
                        Detail Produk
                    </div>
                    <div class="description-text">{{ $product->description }}</div>
                </div>
            </div>

            {{-- KOLOM 3: STICKY CARD --}}
            <div class="sticky-card">
                <div style="font-size:14px;font-weight:700;margin-bottom:15px">Atur jumlah dan catatan</div>

                @if ($available)
                    <div class="qty-input">
                        <button class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="qty-val" readonly>
                        <button class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                    <div style="margin:20px 0;display:flex;justify-content:space-between;align-items:center">
                        <span style="color:#6d7588;font-size:14px">Subtotal</span>
                        <span id="subtotalDisplay" style="font-weight:700;font-size:18px;color:#31353b">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                    <button class="btn-buy" onclick="buyNow()">Beli Langsung</button>
                @else
                    <div style="text-align:center;padding:20px 0;color:#dc2626;font-weight:700">Stok Habis</div>
                    <button class="btn-buy" disabled>Stok Habis</button>
                @endif
            </div>

        </div>

        {{-- RELATED --}}
        @if ($relatedProducts->count() > 0)
            <div class="related-section">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px">
                    <h2 style="font-size:18px;margin:0;font-weight:700">Lainnya di toko ini</h2>
                    <a href="{{ route('products.index') }}"
                        style="color:var(--gold);font-weight:700;text-decoration:none;font-size:14px">Lihat Semua</a>
                </div>
                <div class="recommend-grid">
                    @foreach ($relatedProducts as $related)
                        @php $relImages = $related->images ?? []; @endphp
                        <a href="{{ route('products.show', $related) }}" class="mini-card">
                            <div class="mini-img">
                                @if (count($relImages) > 0)
                                    <img src="{{ asset('storage/' . $relImages[0]) }}" alt="{{ $related->name }}">
                                @else
                                    <div class="mini-placeholder">🎵</div>
                                @endif
                            </div>
                            <div class="mini-info">
                                <div class="mini-name">{{ $related->name }}</div>
                                <div class="mini-price">Rp{{ number_format($related->price, 0, ',', '.') }}</div>
                                <div style="font-size:10px;color:#999;margin-top:8px">⭐ 5.0 | Terjual 100+</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- MOBILE CTA --}}
    <div class="mobile-cta">
  {{-- BARU --}}
<a href="https://wa.me/628112124050" class="btn-chat-mob" title="Chat Admin">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="#1a1445">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
            </svg>
        </a>
        @if ($available)
            <a href="javascript:void(0)" onclick="buyNow()" class="btn-buy-mob">Beli Sekarang</a>
        @else
            <span class="btn-buy-mob disabled">Stok Habis</span>
        @endif
    </div>


    {{-- LIGHTBOX --}}
@if ($hasImg)
<div class="lightbox-overlay" id="lightboxOverlay" onclick="closeLightboxOnBg(event)">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <div class="lightbox-img-wrap">
        <button class="lightbox-nav prev" id="lbPrev" onclick="lbNav(-1)">‹</button>
        <img id="lightboxImg" src="" alt="">
        <button class="lightbox-nav next" id="lbNext" onclick="lbNav(1)">›</button>
    </div>
    <div class="lightbox-counter" id="lbCounter"></div>
    @if (count($images) > 1)
    <div class="lightbox-thumbs" id="lbThumbs">
        @foreach ($images as $i => $image)
        <div class="lightbox-thumb {{ $i === 0 ? 'active' : '' }}" onclick="goToLightbox({{ $i }})">
            <img src="{{ asset('storage/' . $image) }}" alt="">
        </div>
        @endforeach
    </div>
    @endif
</div>
@endif

@endsection

@push('scripts')
    <script>

        // ── LIGHTBOX ──
var lbImages = @json(array_map(fn($img) => asset('storage/' . $img), $images));
var currentLightboxIndex = 0;

function openLightbox(index) {
    if (!lbImages.length) return;
    currentLightboxIndex = index;
    updateLightbox();
    document.getElementById('lightboxOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightboxOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

function closeLightboxOnBg(e) {
    if (e.target === document.getElementById('lightboxOverlay')) closeLightbox();
}

function lbNav(dir) {
    currentLightboxIndex = (currentLightboxIndex + dir + lbImages.length) % lbImages.length;
    updateLightbox();
}

function goToLightbox(index) {
    currentLightboxIndex = index;
    updateLightbox();
}

function updateLightbox() {
    var img = document.getElementById('lightboxImg');
    img.style.opacity = 0;
    setTimeout(function () {
        img.src = lbImages[currentLightboxIndex];
        img.style.opacity = 1;
    }, 150);

    document.getElementById('lbCounter').innerText =
        (currentLightboxIndex + 1) + ' / ' + lbImages.length;

    // prev/next visibility
    var prev = document.getElementById('lbPrev');
    var next = document.getElementById('lbNext');
    if (prev) prev.classList.toggle('hidden', lbImages.length <= 1);
    if (next) next.classList.toggle('hidden', lbImages.length <= 1);

    // sync thumbnails
    document.querySelectorAll('.lightbox-thumb').forEach(function (el, i) {
        el.classList.toggle('active', i === currentLightboxIndex);
    });

    // sync main image & thumb di halaman
    var mainImg = document.getElementById('mainImage');
    if (mainImg) mainImg.src = lbImages[currentLightboxIndex];
    document.querySelectorAll('.thumb-item').forEach(function (el, i) {
        el.classList.toggle('active', i === currentLightboxIndex);
    });
}

// Keyboard navigation
document.addEventListener('keydown', function (e) {
    if (!document.getElementById('lightboxOverlay').classList.contains('active')) return;
    if (e.key === 'ArrowRight') lbNav(1);
    if (e.key === 'ArrowLeft')  lbNav(-1);
    if (e.key === 'Escape')     closeLightbox();
});
        var price = {{ $product->price }};
        var stock = {{ $product->stock }};
        var waNumber = '{{ $WA_NUMBER }}';
        var prodName = '{{ addslashes($product->name) }}';

        function changeImage(src, el) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumb-item').forEach(function(item) {
                item.classList.remove('active');
            });
            el.classList.add('active');
        }

        function increaseQty() {
            var q = document.getElementById('quantity');
            if (parseInt(q.value) < stock) {
                q.value = parseInt(q.value) + 1;
                updateSub();
            }
        }

        function decreaseQty() {
            var q = document.getElementById('quantity');
            if (parseInt(q.value) > 1) {
                q.value = parseInt(q.value) - 1;
                updateSub();
            }
        }

        function updateSub() {
            var qty = parseInt(document.getElementById('quantity').value);
            document.getElementById('subtotalDisplay').innerText =
                'Rp' + (qty * price).toLocaleString('id-ID');
        }

        function buyNow() {
            var qty = document.getElementById('quantity') ? document.getElementById('quantity').value : 1;
            var text = 'Halo Admin Saung Angklung Udjo! 👋\n\nSaya ingin memesan:\n\n' +
                '🛍️ *' + prodName + '*\n' +
                '📦 Jumlah: ' + qty + ' pcs\n' +
                '💰 Total: Rp' + (qty * price).toLocaleString('id-ID') + '\n\n' +
                'Mohon info cara pembayaran dan pengirimannya 🙏';
            window.open('https://wa.me/' + waNumber + '?text=' + encodeURIComponent(text), '_blank');
        }
    </script>
@endpush

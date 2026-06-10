@extends('layouts.app')

@section('title', 'Katalog Angklung | Saung Angklung Udjo')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── RESET & GLOBAL ── */
        :root {
            --gold: #c4a47c;
            --navy: #1a1445;
            --bg-gray: #f0f3f7;
            --white: #ffffff;
            --gray-text: #6d7588;
            --gray-border: #e5e7eb;
            --tokopedia-green: #03ac0e;
        }

        /* Paksa background body menjadi abu-abu khas Tokopedia */
        body {
            background-color: var(--bg-gray) !important;
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif !important;
        }

        /* ── HERO (Tetap Megah) ── */
        .tkt-hero {
            position: relative;
            height: 40vh;
            min-height: 300px;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            padding: 0 clamp(1.5rem, 5vw, 4rem) 3.5rem;
        }
        .tkt-hero-bg {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(13,11,46,0.8) 0%, rgba(26,20,69,0.7) 50%, rgba(34,24,93,0.8) 100%),
                        url('{{ asset('img/Angklungmasal.webp') }}') center/cover no-repeat;
            z-index: 1;
        }
        .hero-title {
            position: relative; z-index: 5;
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            color: #fff; margin: 0;
        }

        /* ── BREADCRUMB (Sesuai Gambar 12) ── */
        .breadcrumb-container {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            padding: 12px clamp(1.5rem, 5vw, 4rem);
        }
        .bc-inner {
            display: flex; align-items: center; gap: 8px;
            font-size: 11px; font-weight: 800; letter-spacing: .1em;
            text-transform: uppercase;
        }
        .bc-inner a { color: #999; text-decoration: none; }
        .bc-inner .sep { color: #ccc; }
        .bc-inner .line-sep { color: #eee; margin: 0 10px; }
        .bc-inner .cur { color: var(--gold); }


    /* ── FILTER TABS (CENTER) ── */
    .filter-section {
        padding: 10px 20px;
        background: #f0f3f7;
        display: flex;
        justify-content: center; /* Ke Tengah */
        gap: 30px;

    }
    .filter-btn {
        background: none; border: none; padding: 12px 0;
        font-size: 14px; font-weight: 600; color: var(--gray-text);
        cursor: pointer; position: relative;
    }
    .filter-btn.active { color: var(--gold); }
    .filter-btn.active::after {
        content: ''; position: absolute; bottom: -1px; left: 0; right: 0;
        height: 3px; background: var(--gold); border-radius: 10px;
    }

    /* ── GRID PRODUK (CENTER) ── */
    .main-content {
        padding: 40px 20px 100px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .prod-grid {
        display: grid;
        /* auto-fit dan justify-content center membuat kartu selalu di tengah */
        grid-template-columns: repeat(auto-fit, 200px);
        justify-content: center;
        gap: 15px;
    }

        /* ── TOKOPEDIA CARD ── */
        .product-card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid var(--gray-border);
            text-decoration: none;
            display: flex; flex-direction: column;
            overflow: hidden;
            transition: transform 0.2s ease;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

     /* KOTAK GAMBAR (Wadah) */
.img-box {
    width: 100%;
    aspect-ratio: 1 / 1; /* MEMAKSA KOTAK JADI PERSEGI SEMPURNA */
    position: relative;
    background-color: #fff; /* Background putih jika gambar tidak penuh */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid var(--gray-border);
}

/* GAMBARNYA */
.img-box img {
    width: 100%;
    height: 100%;
    /* RAHASIA UTAMA: contain agar gambar utuh terlihat
       tanpa merubah ukuran kotak, cover jika ingin zoom memenuhi kotak */
    object-fit: contain;
    padding: 10px; /* Beri sedikit ruang agar gambar tidak nempel ke pinggir kotak */
    transition: transform 0.3s ease;
}

        .badge-official {
            position: absolute; top: 0; left: 0;
            background: #d6001c; color: #fff;
            font-size: 9px; font-weight: 800; padding: 3px 6px;
            border-bottom-right-radius: 8px;
        }

        .info-box { padding: 8px; flex: 1; display: flex; flex-direction: column; }

        .prod-title {
            font-size: 13px; color: #31353b; line-height: 1.4;
            height: 36px; overflow: hidden;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            margin-bottom: 4px;
        }

        .prod-price {
            font-size: 15px; font-weight: 800; color: #31353b; margin-bottom: 8px;
        }

        .prod-loc {
            font-size: 11px; color: var(--gray-text);
            display: flex; align-items: center; gap: 4px; margin-bottom: 4px;
        }

        .prod-stats {
            margin-top: auto;
            font-size: 11px; color: var(--gray-text);
            display: flex; align-items: center; gap: 3px;
        }
        .prod-stats span.star { color: #ffc400; font-size: 14px; }

/* MOBILE TOUCH PERFECT */
@media(max-width:768px) {
    .prod-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
        padding: 0 8px !important;
    }

    .product-card:active {
        transform: scale(0.98) !important;
    }

    .filter-section {
        gap: 20px !important;
        padding: 12px 16px !important;
        overflow-x: auto !important;
        scrollbar-width: none;
    }

    /* Search bar mobile */
    #searchInput {
        font-size: 16px !important; /* No zoom */
    }
}

/* iPhone SE / XS Small */
@media(max-width:375px) {
    .prod-grid { grid-template-columns: 1fr !important; }
}

        /* ── MOBILE ── */
        @media (max-width: 1100px) { .prod-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width: 768px) {
            .prod-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .main-content { padding: 15px 10px; }
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <div class="tkt-hero">
        <div class="tkt-hero-bg"></div>
        <h1 class="hero-title">Produk Angklung</h1>
    </div>

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-container">
        <div class="bc-inner">
            <a href="/">BERANDA</a>
            <span class="sep">›</span>
            <a href="{{ route('tickets.buy') }}">PESAN TIKET</a>
            <span class="line-sep">|</span>
            <span class="cur">PESAN ANGKLUNG</span>
        </div>
    </div>

{{-- SEARCH BAR --}}
<div style="background: #f0f3f7; padding: 20px 20px; border-bottom: 1px solid #e5e7eb;">
    <div style="max-width: 600px; margin: 0 auto; display:flex; align-items:center; border: 1.5px solid var(--gold); border-radius: 10px; padding: 10px 16px; gap: 10px; background:#fff;">
        <svg width="16" height="16" fill="none" stroke="#c4a47c" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input
            type="text"
            id="searchInput"
            placeholder="Kamu mau cari produk apa?"
            oninput="filterSearch(this.value)"
            style="border:none; outline:none; font-size:14px; width:100%; font-family:'Inter',sans-serif; color:#31353b;">
    </div>
</div>

    {{-- FILTER --}}
    <div class="filter-section">
        <button class="filter-btn active" onclick="filterCat('all', this)">Semua</button>
        <button class="filter-btn" onclick="filterCat('angklung', this)">Angklung</button>
        <button class="filter-btn" onclick="filterCat('souvenir', this)">Souvenir</button>
    </div>

    {{-- GRID --}}
    <div class="main-content">
        <div class="prod-grid">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product) }}" class="product-card" data-cat="{{ $product->category }}">
                <div class="img-box">

                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}">
                    @else
                        <div style="height:100%; display:flex; align-items:center; justify-content:center;">🎵</div>
                    @endif
                </div>
                <div class="info-box">
                    <div class="prod-title">{{ $product->name }}</div>
                    <div class="prod-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="prod-loc">Kota Bandung</div>
                    <div class="prod-stats">
                        <span class="star">★</span> 5.0 | Terjual 100+
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function filterSearch(val) {
    const q = val.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
        const name = card.querySelector('.prod-title').innerText.toLowerCase();
        card.style.display = name.includes(q) ? 'flex' : 'none';
    });
}

    function filterCat(cat, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.product-card').forEach(card => {
            if (cat === 'all' || card.dataset.cat === cat) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush

@extends('layouts.app', [
    'seoTitle'       => 'Book Now — Walk-in atau Bayar Online | Saung Angklung Udjo',
    'seoDescription' => 'Pilih cara pesan tiket Saung Angklung Udjo: walk-in dengan konfirmasi WhatsApp atau bayar online via QRIS & transfer bank.',
    'seoKeywords'    => 'book now angklung, walk-in tiket angklung, bayar online qris, saung angklung udjo, ticket booking',
    'seoType'        => 'website',
])

@section('title', 'Pilih Opsi Book Now')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
    --cream:   #F7F7F2;
    --ink:     #1a1445;
    --gold:    #c4a47c;
    --gold-lt: #e8d5b0;
    --muted:   #6b7280;
    --border:  #e5e7eb;
    --white:   #FFFFFF;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

/* ─────────────────────────────────────────
   PAGE
───────────────────────────────────────── */
.bn-page {
    background: var(--cream);
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    padding: 0 0 6rem;
}

/* ─────────────────────────────────────────
   HERO  (matches home cinematic dark hero)
───────────────────────────────────────── */
.bn-hero {
    position: relative;
    background: var(--ink);
    overflow: hidden;
    padding: clamp(4rem, 10vw, 7rem) clamp(1.5rem, 6vw, 5rem) clamp(3rem, 7vw, 5rem);
}

/* subtle noise texture — same as home overlay */
.bn-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    opacity: 0.4;
    pointer-events: none;
}

/* gold radial deco — mirrors home hero glow */
.bn-hero::after {
    content: '';
    position: absolute;
    top: -120px;
    right: -80px;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(196,151,58,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.bn-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 3rem;
    align-items: end;
}

/* eyebrow — same pattern as home "Discovery" / "Pesan Tiket" labels */
.bn-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1.5rem;
}
.bn-eyebrow::before {
    content: '';
    display: block;
    width: 32px;
    height: 1px;
    background: var(--gold);
}

/* title — Cormorant Garamond, same size scale as home hero */
.bn-hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 400;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 1.25rem;
}
.bn-hero-title em {
    font-style: italic;
    color: var(--gold-lt);
}

.bn-hero-sub {
    font-size: 15px;
    color: rgba(255,255,255,0.5);
    line-height: 1.7;
    max-width: 480px;
}

/* badge — same frosted pill as home hero */
.bn-hero-badge {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    text-align: center;
    flex-shrink: 0;
    backdrop-filter: blur(8px);
}
.bn-hero-badge-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    font-weight: 600;
    color: var(--gold-lt);
    line-height: 1;
}
.bn-hero-badge-label {
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin-top: 6px;
}

/* ─────────────────────────────────────────
   MAIN CONTENT
───────────────────────────────────────── */
.bn-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem clamp(1.5rem, 6vw, 5rem) 0;
}

/* section label — matches home "Discovery" / "Pilih opsi" style */
.bn-section-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 12px;
}
.bn-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* ─────────────────────────────────────────
   CARDS  (matches home .qatar-card feel)
───────────────────────────────────────── */
.bn-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.bn-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.bn-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 60px rgba(28,25,23,0.1);
}

.bn-card-top {
    padding: 2.5rem 2.5rem 2rem;
    flex: 1;
}

/* tag pills */
.bn-card-tag {
    display: inline-flex;
    padding: 5px 14px;
    border-radius: 99px;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    margin-bottom: 1.75rem;
}
.bn-card-tag.walkin {
    background: #F0FDF4;
    color: #166534;
    border: 1px solid #BBF7D0;
}
.bn-card-tag.online {
    background: #FFF7ED;
    color: #9A3412;
    border: 1px solid #FED7AA;
}

/* icon box */
.bn-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}
.bn-card-icon.walkin { background: #F0FDF4; }
.bn-card-icon.online { background: #FFF7ED; }
.bn-card-icon svg { width: 26px; height: 26px; }

.bn-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.9rem;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 0.75rem;
}

.bn-card-desc {
    font-size: 14px;
    line-height: 1.75;
    color: var(--muted);
    margin-bottom: 2rem;
}

.bn-card-features {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.bn-card-feature {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--ink);
}
.bn-card-feature-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.walkin .bn-card-feature-dot { background: #22C55E; }
.online .bn-card-feature-dot { background: #F97316; }

/* card footer */
.bn-card-bottom {
    padding: 1.75rem 2.5rem;
    border-top: 1px solid var(--border);
    background: var(--cream);
}

/* QRIS note under online button */
.bn-qris-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 0.75rem;
    font-size: 11px;
    color: var(--muted);
}
.bn-qris-note svg {
    width: 13px;
    height: 13px;
    color: #22C55E;
    flex-shrink: 0;
}
.bn-qris-badge {
    background: #FFF7ED;
    color: #9A3412;
    border: 1px solid #FED7AA;
    border-radius: 6px;
    padding: 2px 8px;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
}

/* ─────────────────────────────────────────
   BUTTONS  (matches home btn-premium style)
───────────────────────────────────────── */
.bn-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 24px;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-decoration: none;
    transition: all 0.25s ease;
    cursor: pointer;
    border: none;
}
.bn-btn.walkin {
    background: var(--ink);
    color: #fff;
}
.bn-btn.walkin:hover {
    background: #2D2926;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(28,25,23,0.2);
}
.bn-btn.online {
    background: var(--gold);
    color: #fff;
}
.bn-btn.online:hover {
    background: #B8872E;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(196,151,58,0.35);
}
.bn-btn svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    transition: transform 0.2s;
}
.bn-btn:hover svg { transform: translateX(3px); }

/* ─────────────────────────────────────────
   INFO STRIP  (matches home quick-info bar)
───────────────────────────────────────── */
.bn-info {
    margin-top: 3rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--border);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
}
.bn-info-item {
    background: var(--white);
    padding: 1.75rem 2rem;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.bn-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.bn-info-icon svg { width: 18px; height: 18px; color: var(--gold); }
.bn-info-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 4px;
}
.bn-info-text {
    font-size: 12px;
    color: var(--muted);
    line-height: 1.6;
}

/* ─────────────────────────────────────────
   ANIMATIONS  (same fadeUp as home reveal)
───────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.bn-hero-inner { animation: fadeUp 0.7s ease both; }
.bn-cards      { animation: fadeUp 0.7s 0.15s ease both; }
.bn-info       { animation: fadeUp 0.7s 0.25s ease both; }

/* ─────────────────────────────────────────
   MOBILE
───────────────────────────────────────── */
@media (max-width: 768px) {
    .bn-hero-inner          { grid-template-columns: 1fr; }
    .bn-hero-badge          { display: none; }
    .bn-cards               { grid-template-columns: 1fr 1fr; gap: 1rem; }
    .bn-info                { grid-template-columns: 1fr; }
    .bn-card-top            { padding: 1.5rem 1.25rem 1rem; }
    .bn-card-bottom         { padding: 1rem 1.25rem; }
    .bn-card-title          { font-size: 1.4rem; }
    .bn-card-icon           { width: 44px; height: 44px; }
    .bn-card-features       { gap: 6px; }
    .bn-card-feature        { font-size: 12px; }
    .bn-card-desc           { font-size: 13px; margin-bottom: 1rem; }
}
</style>
@endpush

@section('content')
<div class="bn-page">

    {{-- ── HERO ── --}}
    <div class="bn-hero">
        <div class="bn-hero-inner">
            <div>
                <div class="bn-eyebrow">Pesan Tiket</div>
                <h1 class="bn-hero-title">
                    Pilih cara pesan tiket<br>
                    <em>yang cocok untukmu</em>
                </h1>

            </div>

        </div>
    </div>

    {{-- ── CARDS ── --}}
    <div class="bn-wrap">
        <div class="bn-section-label">Pilih opsi</div>

        <div class="bn-cards">

            {{-- WALK-IN --}}
            <div class="bn-card walkin">
                <div class="bn-card-top">

                    <div class="bn-card-icon walkin">
                        <svg fill="none" stroke="#166534" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863
                                   9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3
                                   12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>

                    <h2 class="bn-card-title">Pembayaran Di tempat</h2>


                    <div class="bn-card-features">
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            Bayar di lokasi saat kedatangan
                        </div>
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            Konfirmasi cepat via WhatsApp
                        </div>
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            Tanpa akun atau registrasi
                        </div>
                    </div>
                </div>
                <div class="bn-card-bottom">
                    <a href="{{ url('/tickets/buy') }}" class="bn-btn walkin">
                        Pesan Walk-in
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- BAYAR ONLINE --}}
            <div class="bn-card online">
                <div class="bn-card-top">


                    <div class="bn-card-icon online">
                        <svg fill="none" stroke="#9A3412" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0
                                   00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>

                    <h2 class="bn-card-title">Pembayaran Online</h2>


                    <div class="bn-card-features">
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            QRIS — semua e-wallet & m-banking
                        </div>
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            Transfer bank instan (virtual account)
                        </div>
                        <div class="bn-card-feature">
                            <div class="bn-card-feature-dot"></div>
                            Tiket langsung terkonfirmasi otomatis
                        </div>
                    </div>
                </div>
                <div class="bn-card-bottom">
                    <a href="#"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bn-btn online">
                        Bayar Online
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>

                </div>
            </div>

        </div>{{-- /.bn-cards --}}

        {{-- ── INFO STRIP ── --}}
        <div class="bn-info">
            <div class="bn-info-item">
                <div class="bn-info-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2
                               0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="bn-info-title">Tersedia Setiap Hari</div>
                    <div class="bn-info-text">Pertunjukan digelar setiap hari dengan beberapa sesi pilihan.</div>
                </div>
            </div>
            <div class="bn-info-item">
                <div class="bn-info-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="bn-info-title">Durasi 90 Menit</div>
                    <div class="bn-info-text">Hadir 30 menit sebelum pertunjukan dimulai.</div>
                </div>
            </div>
            <div class="bn-info-item">
                <div class="bn-info-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955
                               11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29
                               9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <div class="bn-info-title">Termasuk Souvenir</div>
                    <div class="bn-info-text">Setiap tiket sudah termasuk welcome drink dan souvenir.</div>
                </div>
            </div>
        </div>{{-- /.bn-info --}}

    </div>{{-- /.bn-wrap --}}
</div>{{-- /.bn-page --}}
@endsection

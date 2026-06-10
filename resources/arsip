@extends('layouts.app')
@section('title', 'Promo Spesial Ramadhan 2026 | Saung Angklung Udjo')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;700&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --green-deep:  #0a2e1f;
        --green-mid:   #124a30;
        --green-light: #1a6b43;
        --gold:        #d4a843;
        --gold-light:  #f0c96a;
        --gold-pale:   #fdf3dc;
        --cream:       #faf7f0;
        --text-dark:   #1a1a1a;
        --text-mid:    #4a4a4a;
        --intl:        #1a3a5c;
        --intl-light:  #2a5a8c;
        --intl-pale:   #eef4fb;
    }
    body { background: var(--cream); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); min-height: 100vh; overflow-x: hidden; }

    /* ── HERO ── */
    .hero {
        position: relative;
        padding: 70px 20px 110px;
        text-align: center;
        overflow: hidden;
        isolation: isolate;
        background: var(--green-deep);
    }
    .hero-bg-img {
        position: absolute; inset: 0; z-index: 0;
        width: 100%; height: 100%;
        object-fit: cover; object-position: center;
        animation: heroZoom 18s ease-in-out infinite alternate;
    }
    @keyframes heroZoom {
        0%   { transform: scale(1); }
        100% { transform: scale(1.06); }
    }
    .hero::before {
        content: '';
        position: absolute; inset: 0; z-index: 1;
        background: linear-gradient(180deg,
            rgba(6,20,10,.75)  0%,
            rgba(10,46,31,.65) 45%,
            rgba(6,20,10,.82)  100%);
    }
    .hero-aurora {
        position: absolute; inset: 0; z-index: 2; pointer-events: none;
        background:
            radial-gradient(ellipse 80% 50% at 50% 30%, rgba(212,168,67,.12) 0%, transparent 65%),
            radial-gradient(ellipse 60% 40% at 80% 70%, rgba(26,107,67,.15)  0%, transparent 60%);
        animation: auroraPulse 8s ease-in-out infinite alternate;
    }
    @keyframes auroraPulse {
        0%   { opacity: .5; }
        50%  { opacity: 1;  }
        100% { opacity: .6; }
    }
    .moon-wrap {
        position: relative; z-index: 10;
        display: flex; justify-content: center;
        margin-bottom: 10px;
        animation: floatMoon 5s ease-in-out infinite;
    }
    @keyframes floatMoon {
        0%, 100% { transform: translateY(0) rotate(-2deg); }
        50%       { transform: translateY(-10px) rotate(2deg); }
    }
    .moon-svg {
        width: 90px; height: 90px;
        filter: drop-shadow(0 0 24px rgba(212,168,67,.8))
                drop-shadow(0 0 48px rgba(212,168,67,.35));
    }
    .hero-promo-label {
        position: relative; z-index: 10;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px; font-weight: 600;
        letter-spacing: 3px; text-transform: uppercase;
        color: var(--gold-light);
        margin-bottom: 6px;
    }
    .hero h1 {
        position: relative; z-index: 10;
        font-family: 'Amiri', serif;
        font-size: clamp(24px, 5.5vw, 42px);
        font-weight: 700; color: #fff; line-height: 1.25;
        text-shadow: 0 2px 20px rgba(0,0,0,.6);
    }
    .arabic-ramadhan {
        position: relative; z-index: 10;
        display: block;
        font-family: 'Noto Naskh Arabic', 'Amiri', serif;
        font-size: clamp(38px, 9vw, 72px);
        font-weight: 700;
        color: var(--gold-light);
        line-height: 1.1;
        margin: 4px 0 2px;
        text-shadow:
            0 0 30px rgba(212,168,67,.7),
            0 0 60px rgba(212,168,67,.3),
            0 3px 12px rgba(0,0,0,.5);
        letter-spacing: 2px;
        direction: rtl;
    }
    .hero-year {
        position: relative; z-index: 10;
        font-family: 'Amiri', serif;
        font-size: clamp(18px, 4vw, 28px);
        color: rgba(255,255,255,.9);
        font-weight: 400;
        margin-top: 2px;
    }
    .hero-sub {
        margin-top: 10px; font-size: 13px;
        color: rgba(255,255,255,.65);
        letter-spacing: .5px;
        position: relative; z-index: 10;
    }
    .divider {
        display: flex; align-items: center; gap: 10px;
        margin: 12px auto; max-width: 240px;
        position: relative; z-index: 10;
    }
    .divider::before, .divider::after {
        content: ''; flex: 1; height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }
    .divider-diamond { width: 7px; height: 7px; background: var(--gold); transform: rotate(45deg); flex-shrink: 0; }

    /* ── COUNTDOWN ── */
    .countdown-wrap {
        position: relative; z-index: 10;
        margin-top: 18px;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
    }
    .cd-label {
        font-size: 11px; font-weight: 600; letter-spacing: 2px;
        text-transform: uppercase; color: rgba(255,255,255,.5);
    }
    .countdown-boxes {
        display: flex; align-items: center; gap: 6px;
    }
    .cd-box {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(212,168,67,.3);
        border-radius: 12px;
        padding: 10px 14px;
        min-width: 58px;
        text-align: center;
        backdrop-filter: blur(6px);
        display: flex; flex-direction: column; align-items: center;
    }
    .cd-num {
        font-family: 'Amiri', serif;
        font-size: 28px; font-weight: 700;
        color: var(--gold-light);
        line-height: 1;
        display: block;
        text-shadow: 0 0 16px rgba(212,168,67,.5);
        transition: transform .15s ease;
    }
    .cd-num.tick {
        transform: scale(1.18);
    }
    .cd-unit {
        font-size: 9px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: rgba(255,255,255,.4);
        margin-top: 3px;
    }
    .cd-sep {
        font-size: 22px; font-weight: 700;
        color: var(--gold);
        margin-bottom: 14px;
        opacity: .7;
    }
    .cd-expired {
        font-family: 'Amiri', serif;
        font-size: 18px; color: var(--gold-light);
        letter-spacing: 1px; opacity: .8;
    }
    @media (max-width: 420px) {
        .cd-box { min-width: 46px; padding: 8px 10px; }
        .cd-num { font-size: 22px; }
    }

    /* ── CARD ── */
    .container-promo { max-width: 720px; margin: -55px auto 60px; padding: 0 16px; position: relative; z-index: 10; }
    .card-promo { background: #fff; border-radius: 28px; padding: 32px 28px; box-shadow: 0 20px 60px rgba(10,46,31,.15), 0 4px 12px rgba(10,46,31,.08); border: 1px solid rgba(212,168,67,.15); }

    .banner-area { position: relative; border-radius: 18px; overflow: hidden; margin-bottom: 28px; background: linear-gradient(135deg, var(--green-deep), var(--green-mid)); min-height: 200px; display: flex; align-items: center; justify-content: center; }
    .banner-area img.voucher-img { width: 100%; display: block; border-radius: 18px; }
    .banner-fallback { padding: 36px 24px; text-align: center; width: 100%; }
    .banner-fallback .bf-label { font-family: 'Amiri', serif; color: var(--gold-light); font-size: 13px; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 8px; }
    .banner-fallback .bf-title { font-family: 'Amiri', serif; font-size: clamp(22px, 5vw, 34px); color: #fff; font-weight: 700; line-height: 1.3; }
    .banner-fallback .bf-title span { color: var(--gold); }
    .banner-fallback .bf-sub { color: rgba(255,255,255,.7); font-size: 13px; margin-top: 8px; }

    .price-section { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 28px; }
    .price-card { border-radius: 16px; padding: 18px 16px; text-align: center; border: 1.5px solid rgba(212,168,67,.25); background: var(--gold-pale); position: relative; overflow: hidden; }
    .price-card.featured { border-color: var(--gold); background: linear-gradient(145deg, #fff9ec, #fff3d0); }
    .price-card .pc-label { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--green-mid); margin-bottom: 8px; }
    .price-card .pc-old { font-size: 13px; text-decoration: line-through; color: #999; margin-bottom: 2px; }
    .price-card .pc-new { font-family: 'Amiri', serif; font-size: 24px; font-weight: 700; color: var(--green-deep); }
    .price-card .pc-new span { font-size: 13px; font-weight: 400; color: var(--text-mid); }
    .price-card .promo-badge { position: absolute; top: 10px; right: -18px; background: var(--green-light); color: #fff; font-size: 10px; font-weight: 700; padding: 3px 24px 3px 10px; border-radius: 4px; letter-spacing: .5px; }

    .info-strip { display: flex; gap: 12px; margin-bottom: 28px; flex-wrap: wrap; }
    .info-pill { display: flex; align-items: center; gap: 6px; background: var(--green-deep); color: #fff; border-radius: 50px; padding: 8px 16px; font-size: 12px; font-weight: 600; }
    .info-pill svg { width: 15px; height: 15px; flex-shrink: 0; }

    .form-section-title { font-family: 'Amiri', serif; font-size: 20px; font-weight: 700; color: var(--green-deep); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .form-section-title svg { width: 22px; height: 22px; }
    .field-group { margin-bottom: 16px; }
    .field-group label { display: block; font-size: 12px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--green-mid); margin-bottom: 6px; }
    .field-group input, .field-group select { width: 100%; padding: 14px 16px; border-radius: 14px; border: 1.5px solid #e0ddd5; font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); background: #fafaf8; transition: border-color .2s, box-shadow .2s; outline: none; appearance: none; }
    .field-group input:focus, .field-group select:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(212,168,67,.15); background: #fff; }
    .field-group input.input-error, .field-group select.input-error { border-color: #e53e3e; }
    .field-error-msg { color: #e53e3e; font-size: 12px; margin-top: 5px; display: none; }
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    /* ── TICKET SECTIONS ── */
    .ticket-section { border-radius: 18px; padding: 20px; margin-bottom: 16px; border: 1.5px solid; }
    .ticket-section.domestik { background: linear-gradient(135deg, #f0fff6, #e8faf0); border-color: rgba(26,107,67,.25); }
    .ticket-section.mancanegara { background: linear-gradient(135deg, #f0f6ff, #e8f0fa); border-color: rgba(26,67,107,.25); }
    .ticket-section-header { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
    .ticket-section-icon { font-size: 28px; line-height: 1; margin-top: 2px; }
    .ticket-section-title { font-size: 15px; font-weight: 700; color: var(--green-deep); margin-bottom: 2px; }
    .ticket-section.mancanegara .ticket-section-title { color: var(--intl); }
    .ticket-section-sub { font-size: 12px; color: #888; }
    .ticket-price-info { margin-left: auto; text-align: right; display: flex; flex-direction: column; gap: 2px; }
    .tpi-item { font-size: 12px; color: var(--text-mid); white-space: nowrap; }
    .tpi-item strong { color: var(--green-deep); }
    .ticket-section.mancanegara .tpi-item strong { color: var(--intl); }
    .ticket-section.mancanegara .field-group input:focus { border-color: #5a9fd4; box-shadow: 0 0 0 3px rgba(90,159,212,.15); }
    .ticket-section.mancanegara .field-group label { color: var(--intl); }

    /* ── TOTAL SUMMARY ── */
    .total-summary { background: linear-gradient(135deg, var(--green-deep), var(--green-mid)); border-radius: 18px; padding: 20px 22px; margin: 20px 0 24px; color: #fff; }
    .ts-title { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--gold-light); margin-bottom: 14px; }
    .ts-rows { display: flex; flex-direction: column; gap: 8px; }
    .ts-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: rgba(255,255,255,.75); }
    .ts-row .ts-row-label { display: flex; align-items: center; gap: 6px; }
    .ts-row .ts-flag { font-size: 15px; }
    .ts-row-amount { color: #fff; font-weight: 600; }
    .ts-divider { height: 1px; background: rgba(255,255,255,.15); margin: 12px 0; }
    .ts-total-row { display: flex; justify-content: space-between; align-items: center; font-size: 15px; font-weight: 700; color: #fff; }
    .ts-grand { font-family: 'Amiri', serif; font-size: 22px; color: var(--gold-light); }
    .ts-pax { margin-top: 6px; font-size: 11px; color: rgba(255,255,255,.4); text-align: right; letter-spacing: .5px; text-transform: uppercase; }
    .ts-empty { font-size: 13px; color: rgba(255,255,255,.35); text-align: center; padding: 8px 0; font-style: italic; }

    .btn-klaim { width: 100%; background: linear-gradient(135deg, var(--green-deep), var(--green-light)); color: #fff; border: none; padding: 17px 20px; border-radius: 50px; font-weight: 700; font-size: 15px; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 8px; transition: transform .2s, box-shadow .2s; box-shadow: 0 6px 20px rgba(10,46,31,.25); position: relative; overflow: hidden; }
    .btn-klaim::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,.08)); }
    .btn-klaim:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(10,46,31,.3); }
    .btn-klaim svg { width: 20px; height: 20px; flex-shrink: 0; }

    .note-box { margin-top: 24px; background: linear-gradient(135deg, #f0f7f3, #e8f4ed); border: 1px solid rgba(26,107,67,.2); border-radius: 16px; padding: 18px 20px; }
    .note-title { font-weight: 700; font-size: 13px; color: var(--green-mid); letter-spacing: .5px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
    .note-title svg { width: 15px; height: 15px; }
    .note-list { list-style: none; }
    .note-list li { font-size: 13px; color: var(--text-mid); padding: 4px 0 4px 20px; position: relative; line-height: 1.5; }
    .note-list li::before { content: '◆'; position: absolute; left: 0; color: var(--gold); font-size: 8px; top: 7px; }

    .alert-error { background: #fff0f0; border: 1px solid #fcc; border-radius: 12px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px; color: #c00; display: flex; align-items: flex-start; gap: 8px; }
    .alert-error svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }

    .select-wrapper { position: relative; }
    .select-wrapper::after { content: '▾'; position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-mid); pointer-events: none; font-size: 14px; }

    .badge-no-promo { display: inline-block; background: rgba(26,58,92,.12); color: var(--intl); border: 1px solid rgba(26,58,92,.2); border-radius: 20px; font-size: 10px; font-weight: 700; letter-spacing: .5px; padding: 3px 10px; text-transform: uppercase; margin-left: 6px; vertical-align: middle; }

    /* ── POPUP NOTIFIKASI ── */
    .notif-popup {
        position: fixed;
        bottom: 24px; left: 20px;
        z-index: 9999;
        background: #fff;
        border-radius: 14px;
        padding: 12px 32px 12px 16px;
        box-shadow: 0 8px 32px rgba(10,46,31,.18), 0 2px 8px rgba(0,0,0,.08);
        max-width: 260px; min-width: 190px;
        border-left: 4px solid var(--green-light);
        transform: translateX(-320px);
        opacity: 0;
        transition: transform .45s cubic-bezier(.34,1.56,.64,1), opacity .35s ease;
        pointer-events: none;
    }
    .notif-popup.show {
        transform: translateX(0);
        opacity: 1;
        pointer-events: auto;
    }
    .notif-name { font-size: 12px; font-weight: 700; color: var(--text-dark); line-height: 1.3; margin-bottom: 3px; }
    .notif-desc { font-size: 11px; color: #888; line-height: 1.4; }
    .notif-desc strong { color: var(--green-light); }
    .notif-time { font-size: 10px; color: #bbb; margin-top: 3px; display: block; }
    .notif-close {
        position: absolute; top: 8px; right: 10px;
        font-size: 13px; color: #ccc; cursor: pointer;
        background: none; border: none; padding: 0;
        line-height: 1; transition: color .2s;
    }
    .notif-close:hover { color: #999; }

    @media (max-width: 520px) {
        .card-promo { padding: 20px 16px; }
        .price-section { grid-template-columns: 1fr; }
        .field-row { grid-template-columns: 1fr; }
        .info-strip { gap: 8px; }
        .arabic-ramadhan { font-size: clamp(34px, 12vw, 60px); }
        .ticket-price-info { margin-left: 0; width: 100%; flex-direction: row; gap: 8px; }
        .ticket-section-header { flex-wrap: wrap; }
        .notif-popup { max-width: calc(100vw - 40px); }
    }
</style>

<!-- HERO -->
<section class="hero">
    <img src="{{ asset('img/performance.jpg') }}" class="hero-bg-img" alt="" aria-hidden="true">
    <div class="hero-aurora"></div>
    <div class="moon-wrap">
        <svg class="moon-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <radialGradient id="moonGrad" cx="38%" cy="38%">
                    <stop offset="0%"   stop-color="#fce680"/>
                    <stop offset="60%"  stop-color="#f0c96a"/>
                    <stop offset="100%" stop-color="#c8860a"/>
                </radialGradient>
                <filter id="moonGlow">
                    <feGaussianBlur stdDeviation="3" result="blur"/>
                    <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>
            </defs>
            <circle cx="50" cy="50" r="46" fill="rgba(212,168,67,.08)"/>
            <path d="M50,10 A40,40 0 1,1 50,90 A28,28 0 1,0 50,10 Z" fill="url(#moonGrad)" filter="url(#moonGlow)"/>
        </svg>
    </div>
    <p class="hero-promo-label">Promo Spesial</p>
    <h1>
        <span class="arabic-ramadhan">رَمَضَان</span>
    </h1>
    <p class="hero-year">2026 / 1447 H</p>
    <div class="divider"><div class="divider-diamond"></div></div>
    <p class="hero-sub">Saung Angklung Udjo &middot; Bandung</p>

    {{-- ── COUNTDOWN TIMER ── --}}
    <div class="countdown-wrap">
        <div class="cd-label">⏳ Promo berakhir dalam</div>
        <div class="countdown-boxes" id="countdownBoxes">
            <div class="cd-box">
                <span class="cd-num" id="cd-days">00</span>
                <span class="cd-unit">Hari</span>
            </div>
            <div class="cd-sep">:</div>
            <div class="cd-box">
                <span class="cd-num" id="cd-hours">00</span>
                <span class="cd-unit">Jam</span>
            </div>
            <div class="cd-sep">:</div>
            <div class="cd-box">
                <span class="cd-num" id="cd-mins">00</span>
                <span class="cd-unit">Menit</span>
            </div>
            <div class="cd-sep">:</div>
            <div class="cd-box">
                <span class="cd-num" id="cd-secs">00</span>
                <span class="cd-unit">Detik</span>
            </div>
        </div>
    </div>
    {{-- ── /COUNTDOWN ── --}}
</section>

<!-- CARD -->
<div class="container-promo">
    <div class="card-promo">

        <!-- BANNER -->
        <div class="banner-area">
            <img src="{{ asset('img/FEEDS.webp') }}"
                 class="voucher-img"
                 onerror="this.parentElement.innerHTML = fallbackBanner()"
                 alt="Promo Ramadhan Udjo">
        </div>

        <!-- INFO PILLS -->
        <div class="info-strip">
            <div class="info-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
                Pertunjukan Reguler Sore 15.30–17.00 WIB
            </div>
            <div class="info-pill">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                23 Feb – 15 Mar 2026
            </div>
        </div>

        <!-- FORM TITLE -->
        <p class="form-section-title">
            <svg viewBox="0 0 24 24" fill="var(--gold)" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            Form Klaim Promo
        </p>

        @if($errors->any())
        <div class="alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('promo.submit') }}" method="POST" id="formKlaim" novalidate>
            @csrf

            <!-- Nama -->
            <div class="field-group">
                <label>Nama</label>
                <input type="text" name="nama" id="nama"
                       placeholder="Masukkan nama lengkap atau nama grup"
                       value="{{ old('nama') }}" required>
            </div>

            <!-- Kota asal -->
            <div class="field-group">
                <label>Kota Asal (Pemesan)</label>
                <div class="select-wrapper">
                    <select name="kota" id="kota" required>
                        <option value="" disabled {{ old('kota') ? '' : 'selected' }}>Pilih kota asal...</option>
                        @php
                            $kotaIndonesia = [
                                'Jakarta Pusat','Jakarta Selatan','Jakarta Timur','Jakarta Barat','Jakarta Utara',
                                'Bandung','Surabaya','Medan','Semarang','Makassar','Palembang',
                                'Tangerang','Tangerang Selatan','Depok','Bekasi','Bogor',
                                'Yogyakarta','Malang','Solo','Cimahi','Tasikmalaya','Cirebon',
                                'Sukabumi','Garut','Purwakarta','Subang','Karawang','Cianjur',
                                'Banjarmasin','Balikpapan','Samarinda','Pontianak','Pekanbaru',
                                'Padang','Batam','Lampung','Manado','Denpasar','Mataram',
                                'Kupung','Ambon','Jayapura','Lainnya (Indonesia)'
                            ];
                        @endphp
                        @foreach($kotaIndonesia as $kota)
                            <option value="{{ $kota }}" {{ old('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- ══ TIKET DOMESTIK ══ -->
            <div class="ticket-section domestik">
                <div class="ticket-section-header">
                    <span class="ticket-section-icon">🇮🇩</span>
                    <div style="flex:1">
                        <div class="ticket-section-title">Tiket Domestik
                            <span style="background:var(--green-light);color:#fff;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;letter-spacing:.5px;margin-left:6px;vertical-align:middle;">PROMO</span>
                        </div>
                        <div class="ticket-section-sub">Harga promo Ramadhan · WNI / KTP Indonesia</div>
                    </div>
                    <div class="ticket-price-info" style="margin-bottom:14px;">
                        <span class="tpi-item"><s style="color:#bbb">Rp 85.000</s> → <strong>Rp 68.000</strong> / Dewasa
                        <span class="tpi-item"><strong>Rp 60.000</strong> / Anak (3–11th)</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-group" style="margin-bottom:0">
                        <label>Dewasa</label>
                        <input type="number" name="jumlah_tiket_dewasa" id="jml_dom_dewasa"
                               placeholder="0" min="0" max="100"
                               value="{{ old('jumlah_tiket_dewasa', 0) }}"
                               oninput="hitungTotal()">
                    </div>
                    <div class="field-group" style="margin-bottom:0">
                        <label>Anak (3–11th)</label>
                        <input type="number" name="jumlah_tiket_anak" id="jml_dom_anak"
                               placeholder="0" min="0" max="100"
                               value="{{ old('jumlah_tiket_anak', 0) }}"
                               oninput="hitungTotal()">
                    </div>
                </div>
            </div>

            <!-- ══ TIKET MANCANEGARA ══ -->
            <div class="ticket-section mancanegara">
                <div class="ticket-section-header">
                    <span class="ticket-section-icon">🌏</span>
                    <div style="flex:1">
                        <div class="ticket-section-title" style="color:var(--intl)">Tiket Mancanegara
                            <span class="badge-no-promo">Harga Normal</span>
                        </div>
                        <div class="ticket-section-sub">Wisatawan asing / WNA · Tidak termasuk promo</div>
                    </div>
                    <div class="ticket-price-info">
                        <span class="tpi-item"><strong style="color:var(--intl)">Rp 120.000</strong> / Dewasa</span>
                        <span class="tpi-item"><strong style="color:var(--intl)">Rp 85.000</strong> / Anak (3–11th)</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-group" style="margin-bottom:0">
                        <label style="color:var(--intl)">Dewasa</label>
                        <input type="number" name="jumlah_tiket_manca_dewasa" id="jml_manca_dewasa"
                               placeholder="0" min="0" max="100"
                               value="{{ old('jumlah_tiket_manca_dewasa', 0) }}"
                               oninput="hitungTotal()">
                    </div>
                    <div class="field-group" style="margin-bottom:0">
                        <label style="color:var(--intl)">Anak (3–11th)</label>
                        <input type="number" name="jumlah_tiket_manca_anak" id="jml_manca_anak"
                               placeholder="0" min="0" max="100"
                               value="{{ old('jumlah_tiket_manca_anak', 0) }}"
                               oninput="hitungTotal()">
                    </div>
                </div>
            </div>

            <!-- ══ TOTAL SUMMARY ══ -->
            <div class="total-summary" id="totalSummary">
                <div class="ts-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 7H6a2 2 0 00-2 2v9a2 2 0 002 2h9a2 2 0 002-2v-3"/>
                        <path d="M9 15h6m-6-4h3m-3-4h3"/>
                        <path d="M15 2l3 3-7 7H8v-3l7-7z"/>
                    </svg>
                    Ringkasan Pemesanan
                </div>
                <div id="ts-rows"><div class="ts-empty">Masukkan jumlah tiket untuk melihat ringkasan</div></div>
                <div class="ts-divider"></div>
                <div class="ts-total-row">
                    <span>Total Pembayaran</span>
                    <span id="ts-grand-total" class="ts-grand">Rp 0</span>
                </div>
                <div class="ts-pax" id="ts-pax">0 orang total</div>
            </div>

            <!-- Tanggal -->
            <div class="field-group">
                <label>Tanggal Kunjungan</label>
                <div class="select-wrapper">
                    <select name="tanggal_kunjungan" id="tanggal_kunjungan" required>
                        <option value="" disabled {{ old('tanggal_kunjungan') ? '' : 'selected' }}>
                            Pilih tanggal kunjungan...
                        </option>
                        @php
                            $start     = \Carbon\Carbon::parse('2026-02-23');
                            $end       = \Carbon\Carbon::parse('2026-03-15');
                            $namaHari  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                            $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni',
                                          'Juli','Agustus','September','Oktober','November','Desember'];
                            $cur = $start->copy();
                        @endphp
                        @while ($cur->lte($end))
                            @php
                                $val   = $cur->format('Y-m-d');
                                $label = $namaHari[$cur->dayOfWeek] . ', '
                                       . $cur->day . ' '
                                       . $namaBulan[(int)$cur->month] . ' '
                                       . $cur->year;
                            @endphp
                            <option value="{{ $val }}" {{ old('tanggal_kunjungan') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @php $cur->addDay() @endphp
                        @endwhile
                    </select>
                </div>
            </div>

            <!-- No HP -->
            <div class="field-group">
                <label>No HP / WhatsApp <small style="font-weight:400;text-transform:none;color:#888">(Indonesia)</small></label>
                <input type="tel" name="no_hp" id="no_hp"
                       placeholder="Contoh: 08123456789 atau +6281234567"
                       value="{{ old('no_hp') }}" required>
                <div class="field-error-msg" id="no_hp_error">
                    ⚠️ Nomor HP harus nomor Indonesia yang valid (diawali 08 atau +62).
                </div>
            </div>

            <button type="submit" class="btn-klaim">
                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Klaim Sekarang via WhatsApp
            </button>
        </form>

        <div class="note-box">
            <div class="note-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                </svg>
                Catatan Penting
            </div>
            <ul class="note-list">
                <li>Periode Promo berlaku mulai <strong>23 Februari s/d 15 Maret 2026</strong>.</li>
                <li>Promo ini <strong>khusus untuk pengunjung domestik (WNI)</strong>. Tamu mancanegara dikenakan harga normal.</li>
                <li>Campuran rombongan domestik & mancanegara <strong>dapat dilakukan dalam satu pemesanan</strong>.</li>
                <li>Jika ingin berbuka puasa di SAU, silakan hubungi Admin untuk informasi lebih lanjut.</li>
                <li>Dilarang membawa makanan dari luar.</li>
                <li>Dilarang membuang sampah rombongan/individu di area SAU.</li>
            </ul>
        </div>

    </div>
</div>

{{-- ── POPUP NOTIFIKASI PEMBELIAN ── --}}
<div class="notif-popup" id="notifPopup">
    <button class="notif-close" onclick="tutupNotif()" aria-label="Tutup">✕</button>
    <div class="notif-name" id="notifNama">—</div>
    <div class="notif-desc" id="notifDesc">baru saja membeli tiket</div>
    <span class="notif-time" id="notifTime">beberapa saat lalu</span>
</div>

<script>
    function fallbackBanner() {
        return '<div class="banner-fallback"><div class="bf-label">Special Offer &middot; Ramadhan 2026</div><div class="bf-title">Promo <span>Spesial</span><br>Ramadhan 2026</div><div class="bf-sub">Saung Angklung Udjo &middot; Bandung</div></div>';
    }

    /* ── Harga ── */
    const HARGA = {
        dom_dewasa:   68000,
        dom_anak:     60000,
        manca_dewasa: 120000,
        manca_anak:   85000
    };

    function fmt(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function hitungTotal() {
        const domDewasa   = Math.max(0, parseInt(document.getElementById('jml_dom_dewasa').value)   || 0);
        const domAnak     = Math.max(0, parseInt(document.getElementById('jml_dom_anak').value)     || 0);
        const mancaDewasa = Math.max(0, parseInt(document.getElementById('jml_manca_dewasa').value) || 0);
        const mancaAnak   = Math.max(0, parseInt(document.getElementById('jml_manca_anak').value)   || 0);

        const subDomDewasa   = domDewasa   * HARGA.dom_dewasa;
        const subDomAnak     = domAnak     * HARGA.dom_anak;
        const subMancaDewasa = mancaDewasa * HARGA.manca_dewasa;
        const subMancaAnak   = mancaAnak   * HARGA.manca_anak;
        const grand = subDomDewasa + subDomAnak + subMancaDewasa + subMancaAnak;
        const totalPax = domDewasa + domAnak + mancaDewasa + mancaAnak;

        const rowsEl = document.getElementById('ts-rows');
        const rows = [];

        if (domDewasa > 0)
            rows.push(`<div class="ts-row"><span class="ts-row-label"><span class="ts-flag">🇮🇩</span> Dewasa Domestik × ${domDewasa}</span><span class="ts-row-amount">${fmt(subDomDewasa)}</span></div>`);
        if (domAnak > 0)
            rows.push(`<div class="ts-row"><span class="ts-row-label"><span class="ts-flag">🇮🇩</span> Anak Domestik × ${domAnak}</span><span class="ts-row-amount">${fmt(subDomAnak)}</span></div>`);
        if (mancaDewasa > 0)
            rows.push(`<div class="ts-row"><span class="ts-row-label"><span class="ts-flag">🌏</span> Dewasa Mancanegara × ${mancaDewasa}</span><span class="ts-row-amount">${fmt(subMancaDewasa)}</span></div>`);
        if (mancaAnak > 0)
            rows.push(`<div class="ts-row"><span class="ts-row-label"><span class="ts-flag">🌏</span> Anak Mancanegara × ${mancaAnak}</span><span class="ts-row-amount">${fmt(subMancaAnak)}</span></div>`);

        rowsEl.innerHTML = rows.length
            ? rows.join('')
            : '<div class="ts-empty">Masukkan jumlah tiket untuk melihat ringkasan</div>';

        document.getElementById('ts-grand-total').textContent = fmt(grand);
        document.getElementById('ts-pax').textContent = totalPax + ' orang total';
    }

    /* ── Validasi HP ── */
    const noHpInput   = document.getElementById('no_hp');
    const noHpError   = document.getElementById('no_hp_error');
    const formKlaim   = document.getElementById('formKlaim');
    const indonesiaHP = /^(\+62|62|0)8[0-9]{8,11}$/;

    function validateHP() {
        const val = noHpInput.value.trim().replace(/[\s\-]/g, '');
        if (val && !indonesiaHP.test(val)) {
            noHpInput.classList.add('input-error');
            noHpError.style.display = 'block';
            return false;
        }
        noHpInput.classList.remove('input-error');
        noHpError.style.display = 'none';
        return true;
    }

    noHpInput.addEventListener('blur', validateHP);
    noHpInput.addEventListener('input', function() {
        if (noHpError.style.display === 'block') validateHP();
    });

    formKlaim.addEventListener('submit', function(e) {
        const domDewasa   = parseInt(document.getElementById('jml_dom_dewasa').value)   || 0;
        const domAnak     = parseInt(document.getElementById('jml_dom_anak').value)     || 0;
        const mancaDewasa = parseInt(document.getElementById('jml_manca_dewasa').value) || 0;
        const mancaAnak   = parseInt(document.getElementById('jml_manca_anak').value)   || 0;
        let valid = true;
        if (!validateHP()) valid = false;
        if (domDewasa + domAnak + mancaDewasa + mancaAnak < 1) {
            alert('Harap masukkan minimal 1 tiket (domestik atau mancanegara).');
            valid = false;
        }
        if (!valid) e.preventDefault();
    });

    hitungTotal();

    /* ════════════════════════════════
       COUNTDOWN TIMER
       Target: 15 Maret 2026 23:59:59 WIB
    ════════════════════════════════ */
    (function() {
        const TARGET = new Date('2026-03-15T23:59:59+07:00').getTime();

        function pad(n) { return String(n).padStart(2, '0'); }

        function tick(id, val) {
            const el = document.getElementById(id);
            if (!el) return;
            const prev = el.textContent;
            el.textContent = pad(val);
            if (prev !== pad(val)) {
                el.classList.remove('tick');
                void el.offsetWidth;
                el.classList.add('tick');
                setTimeout(() => el.classList.remove('tick'), 200);
            }
        }

        function updateCountdown() {
            const diff = TARGET - Date.now();
            if (diff <= 0) {
                const boxes = document.getElementById('countdownBoxes');
                if (boxes) boxes.innerHTML = '<span class="cd-expired">Promo telah berakhir 🌙</span>';
                return;
            }
            tick('cd-days',  Math.floor(diff / 86400000));
            tick('cd-hours', Math.floor((diff % 86400000) / 3600000));
            tick('cd-mins',  Math.floor((diff % 3600000)  / 60000));
            tick('cd-secs',  Math.floor((diff % 60000)    / 1000));
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();

    /* ════════════════════════════════
       POPUP NOTIFIKASI PEMBELIAN
       Edit array `pembeli` untuk ubah nama/data
    ════════════════════════════════ */
    (function() {
        const pembeli = [
            { nama: 'Ramadhan E.P.',    kota: 'Bekasi',          tiket: '4 Dewasa',           emoji: '🎶' },
            { nama: 'Winda A.N.',       kota: 'Lainnya (ID)',     tiket: '2 Dewasa',           emoji: '🎵' },
            { nama: 'Rika Hapsari',     kota: 'Jakarta Timur',   tiket: '3 Dewasa + 2 Anak',  emoji: '🎼' },
            { nama: 'Farhan A.F.',      kota: 'Bekasi',          tiket: '2 Dewasa',           emoji: '🌙' },
            { nama: 'Victory Outreach', kota: 'Bandung',         tiket: '13 tiket',           emoji: '🎺' },
            { nama: 'Siti Nasriah',     kota: 'Bandung',         tiket: '2 tiket campuran',   emoji: '🎻' },
            { nama: 'Arini K.',         kota: 'Bekasi',          tiket: '4 tiket campuran',   emoji: '🥁' },
            { nama: 'Dewi S.W.',        kota: 'Bandung',         tiket: '6 tiket campuran',   emoji: '🎵' },
            { nama: 'Mochammad Iman',   kota: 'Jakarta Timur',   tiket: '2 Dewasa',           emoji: '🌙' },
        ];

        const waktuLalu = [
            'baru saja', '1 menit lalu', '2 menit lalu', '3 menit lalu',
            '5 menit lalu', '7 menit lalu', '10 menit lalu', '12 menit lalu', '15 menit lalu'
        ];

        const popup    = document.getElementById('notifPopup');
        const elNama   = document.getElementById('notifNama');
        const elDesc   = document.getElementById('notifDesc');
        const elTime   = document.getElementById('notifTime');

        let idx = 0;
        let hideTimer, showTimer;
        let userTyping = false;
        let resumeTimer;

        // Deteksi user sedang fokus di form
        const formInputs = document.querySelectorAll('#formKlaim input, #formKlaim select, #formKlaim textarea');
        formInputs.forEach(function(el) {
            el.addEventListener('focus', function() {
                userTyping = true;
                clearTimeout(resumeTimer);
                // Sembunyikan popup kalau lagi tampil
                popup.classList.remove('show');
                clearTimeout(hideTimer);
                clearTimeout(showTimer);
            });
            el.addEventListener('blur', function() {
                // Tunggu 3 detik setelah user berhenti ketik baru muncul lagi
                clearTimeout(resumeTimer);
                resumeTimer = setTimeout(function() {
                    userTyping = false;
                    showTimer = setTimeout(tampilkan, 1500);
                }, 3000);
            });
        });

        function tampilkan() {
            if (userTyping) return;
            const p = pembeli[idx % pembeli.length];
            elNama.textContent   = p.nama + ' · ' + p.kota;
            elDesc.innerHTML     = 'baru saja membeli <strong>' + p.tiket + '</strong>';
            elTime.textContent   = waktuLalu[idx % waktuLalu.length];
            popup.classList.add('show');
            idx++;
            clearTimeout(hideTimer);
            hideTimer = setTimeout(sembunyikan, 4000);
        }

        function sembunyikan() {
            popup.classList.remove('show');
            clearTimeout(showTimer);
            if (!userTyping) {
                showTimer = setTimeout(tampilkan, 2000 + Math.random() * 1000);
            }
        }

        function tutupNotif() { sembunyikan(); }
        window.tutupNotif = tutupNotif;

        // Mulai setelah 3 detik
        setTimeout(tampilkan, 3000);
    })();
</script>

@endsection
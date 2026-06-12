@extends('layouts.app')

@section('title', 'Book Now | Saung Angklung Udjo')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        :root {
            --gold: #c4a47c;
            --gold-lt: rgba(196, 164, 124, .12);
            --bg: #F7F7F2;
            --white: #ffffff;
            --gray-soft: rgba(26, 20, 69, .06);
            --gray-mid: rgba(26, 20, 69, .12);
            --gray-text: rgba(26, 20, 69, .5);
            --success: #2d9f6a;
            --danger: #e05252;
            --radius-sm: 6px;
            --radius-md: 14px;
            --radius-lg: 24px;
            --shadow-card: 0 12px 48px rgba(26, 20, 69, .07);
            --shadow-hover: 0 24px 60px rgba(26, 20, 69, .12)
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            /* #F7F7F2 */
        }




        /* HERO */
        .tkt-hero {
            position: relative;
            height: 46vh;
            min-height: 320px;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            padding: 0 clamp(1.5rem, 5vw, 4rem) 3rem;
        }

        .tkt-hero-bg {
            position: absolute;
            inset: 0;
            /* Perubahan di sini: Menggunakan gambar dan gradien transparan */
            background: linear-gradient(160deg, rgba(13, 11, 46, 0.8) 0%, rgba(26, 20, 69, 0.7) 50%, rgba(34, 24, 93, 0.8) 100%),
                url('{{ asset('img/Angklungmasal.webp') }}') center/cover no-repeat;
            /* Pastikan jalur gambar benar. Asset('images/...') diasumsikan jalur publik Laravel Anda. */
            height: 65vh;
            /* dari 46vh */
            min-height: 420px;
            /* dari 320px */
        }

        .tkt-hero-bg::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            border: 1px solid rgba(196, 164, 124, .07)
        }

        .tkt-hero-bg::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 20%;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(196, 164, 124, .05)
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(135deg, transparent 0, transparent 40px, rgba(196, 164, 124, .025) 40px, rgba(196, 164, 124, .025) 41px)
        }

        .hero-deco {
            position: absolute;
            right: clamp(2rem, 8vw, 7rem);
            top: 50%;
            transform: translateY(-50%);
            opacity: .055;
            pointer-events: none;
            width: clamp(80px, 12vw, 150px)
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 750px
        }

        .hero-eyebrow {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .55em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .hero-eyebrow::before {
            content: '';
            display: inline-block;
            width: 28px;
            height: 1px;
            background: var(--gold)
        }

        .hero-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(1.7rem, 4vw, 3rem);
            color: #fff;
            line-height: 1.15;
            font-weight: 400;
            margin-bottom: 16px
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold)
        }

        .hero-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap
        }

        .hero-badge {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45)
        }

        .hero-sep {
            width: 1px;
            height: 12px;
            background: rgba(255, 255, 255, .15)
        }

        /* BREADCRUMB */
        .breadcrumb {
            padding: 13px clamp(1.5rem, 5vw, 4rem);
            border-bottom: 1px solid var(--gray-mid);
            background: var(--white)
        }

        .bc-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: var(--gray-text)
        }

        .bc-inner a {
            color: var(--gray-text);
            text-decoration: none;
            transition: color .2s
        }

        .bc-inner a:hover {
            color: var(--gold)
        }

        .bc-inner .sep {
            font-size: 8px;
            opacity: .35
        }

        .bc-inner .cur {
            color: #1a1445
        }

        /* MAIN LAYOUT */
        .tkt-wrap {
            max-width: 1360px;
            margin: 0 auto;
            padding: 2.5rem clamp(1.5rem, 5vw, 4rem) 6rem;
            display: grid;
            grid-template-columns: 1fr 390px;
            gap: 2.5rem;
            align-items: start;
            background: var(--bg)
        }

        /* STEPS */
        .steps {
            grid-column: 1/-1;
            display: flex;
            align-items: center;
            margin-bottom: .5rem
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1
        }

        .sn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--gray-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            color: var(--gray-text);
            transition: all .4s;
            flex-shrink: 0
        }

        .sl {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: var(--gray-text);
            transition: color .4s
        }

        .step.active .sn {
            background: #1a1445;
            border-color: #1a1445;
            color: #fff
        }

        .step.active .sl {
            color: #1a1445
        }

        .step.done .sn {
            background: var(--gold);
            border-color: var(--gold);
            color: #1a1445
        }

        .step.done .sl {
            color: var(--gold)
        }

        .sline {
            flex: 1;
            height: 1px;
            background: var(--gray-mid);
            margin: 0 10px;
            transition: background .4s
        }

        .sline.done {
            background: var(--gold)
        }

        /* CARD */
        .card {
            background: var(--white);
            border: 1px solid var(--gray-soft);
            border-radius: var(--radius-lg);
            padding: 2rem 2.2rem;
            margin-bottom: 1.4rem;
            box-shadow: var(--shadow-card);
            transition: box-shadow .4s
        }

        .card:hover {
            box-shadow: var(--shadow-hover)
        }

        .sh {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 1.75rem
        }

        .sh-bar {
            width: 3px;
            height: 24px;
            background: linear-gradient(to bottom, var(--gold), rgba(196, 164, 124, .25));
            border-radius: 2px;
            flex-shrink: 0
        }

        .sh h3 {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: #1a1445
        }

        .sh p {
            font-size: 9px;
            color: var(--gray-text);
            letter-spacing: .2em;
            text-transform: uppercase;
            font-weight: 700;
            margin-top: 2px
        }

        /* CALENDAR */
        .cal-hdr {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.4rem
        }

        .cal-month {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            font-weight: 400;
            color: #1a1445
        }

        .cal-navs {
            display: flex;
            gap: 8px
        }

        .cal-btn {
            width: 33px;
            height: 33px;
            border-radius: 50%;
            border: 1px solid var(--gray-mid);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1445;
            transition: all .22s
        }

        .cal-btn:hover {
            background: #1a1445;
            color: #fff;
            border-color: #1a1445
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 3px
        }

        .cdn {
            text-align: center;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--gray-text);
            padding: 7px 0 10px
        }

        .cd {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #1a1445;
            cursor: pointer;
            transition: all .18s;
            position: relative;
            border: 1px solid transparent
        }

        .cd:hover:not(.empty):not(.past) {
            background: var(--gold-lt);
            border-color: rgba(196, 164, 124, .3)
        }

        .cd.past {
            color: rgba(26, 20, 69, .2);
            cursor: not-allowed
        }

        .cd.empty {
            cursor: default
        }

        .cd.today:not(.sel) {
            font-weight: 800;
            color: var(--gold)
        }

        .cd.today:not(.sel)::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--gold)
        }

        .cd.sel {
            background: #1a1445;
            color: #fff;
            font-weight: 700;
            border-color: #1a1445
        }

        .cd.has:not(.past):not(.sel):not(.today)::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(196, 164, 124, .45)
        }

        /* SESSIONS */
        .sess-grid {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .sess-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all .22s;
            position: relative
        }

        .sess-item:hover {
            border-color: var(--gold);
            background: var(--gold-lt)
        }

        .sess-item.sel {
            border-color: #1a1445;
            background: rgba(26, 20, 69, .03)
        }



        .sess-time {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.05rem;
            color: #1a1445
        }

        .sess-meta {
            margin-left: auto;
            text-align: right
        }

        .sess-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gray-text);
            margin-bottom: 3px
        }

        .sess-seats {
            font-size: 11px;
            font-weight: 700;
            color: var(--success)
        }

        .sess-seats.low {
            color: #e08a2d
        }

        .sess-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #1a1445;
            display: none;
            align-items: center;
            justify-content: center;
            margin-left: 14px;
            flex-shrink: 0
        }

        .sess-check svg {
            width: 10px;
            height: 10px;
            stroke: #fff
        }

        .sess-item.sel .sess-check {
            display: flex
        }

        /* TICKETS */
        .tkt-list {
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .tkt-row {
            display: flex;
            align-items: center;
            padding: 1.1rem 1.25rem;
            border: 1px solid var(--gray-mid);
            border-radius: var(--radius-md);
            transition: border-color .22s
        }

        .tkt-row:hover {
            border-color: rgba(196, 164, 124, .35)
        }

        .tkt-row.has {
            border-color: rgba(26, 20, 69, .2)
        }

        .tkt-info {
            flex: 1
        }

        .tkt-name {
            font-size: 13px;
            font-weight: 700;
            color: #1a1445;
            margin-bottom: 3px
        }

        .tkt-desc {
            font-size: 10px;
            color: var(--gray-text)
        }

        .tkt-price {
            font-family: 'Libre Baskerville', serif;
            font-size: .98rem;
            color: #1a1445;
            margin: 0 1.1rem;
            min-width: 88px;
            text-align: right
        }

        .tkt-price small {
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .12em;
            color: var(--gray-text);
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            margin-bottom: 2px
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            gap: 9px
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1.5px solid var(--gray-mid);
            background: transparent;
            cursor: pointer;
            font-size: 15px;
            color: #1a1445;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .18s;
            line-height: 1;
            user-select: none
        }

        .qty-btn:hover:not(:disabled) {
            background: #1a1445;
            color: #fff;
            border-color: #1a1445
        }

        .qty-btn:disabled {
            border-color: var(--gray-soft);
            color: rgba(26, 20, 69, .2);
            cursor: not-allowed
        }

        .qty-num {
            font-size: 14px;
            font-weight: 700;
            min-width: 22px;
            text-align: center
        }

        /* FORM */
        .fg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px
        }

        .fg.full {
            grid-template-columns: 1fr
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        .field label {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .35em;
            text-transform: uppercase;
            color: var(--gray-text)
        }

        .field input,
        .field select {
            width: 100%;
            min-width: 0;
            padding: 11px 14px;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-sm);
            background: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1a1445;
            outline: none;
            transition: border-color .22s;
            appearance: none;
            -webkit-appearance: none
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(196, 164, 124, .1)
        }

        .field input::placeholder {
            color: rgba(26, 20, 69, .22)
        }

        .field-err {
            font-size: 10px;
            color: var(--danger);
            margin-top: 2px;
            display: none
        }

        .field.has-err .field-err {
            display: block
        }

        .field.has-err input,
        .field.has-err select {
            border-color: var(--danger)
        }

        .form-gap {
            display: flex;
            flex-direction: column;
            gap: 14px
        }

        /* EMPTY STATE */
        .es {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2.5rem 1rem;
            gap: 10px;
            text-align: center
        }

        .es svg {
            opacity: .16
        }

        .es p {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--gray-text)
        }

        /* RIGHT PANEL */
        .order-panel {
            position: sticky;
            top: 86px;
            display: flex;
            flex-direction: column;
            gap: 1rem
        }

        .sum-card {
            background: var(--white);
            border: 1px solid var(--gray-soft);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card)
        }

        .sum-hdr {
            background: #1a1445;
            padding: 1.4rem 1.6rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sum-chevron { display: none; width: 18px; height: 18px; stroke: #fff; transition: transform 0.3s; }
        .sum-action { padding: 0 1.6rem 1.4rem; background: var(--white); }
        .sum-body-wrapper { display: block; }

        .sum-hdr p {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .38em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .38);
            margin-bottom: 6px
        }

        .sum-price {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.75rem;
            color: #fff;
            font-weight: 400
        }

        .sum-price small {
            font-size: 11px;
            color: rgba(255, 255, 255, .38);
            font-family: 'Inter', sans-serif;
            margin-left: 4px
        }

        .sum-body {
            padding: 1.4rem 1.6rem
        }

        .sum-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 1.1rem
        }

        .sum-row-info {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px
        }

        .sum-row-info svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 1px;
            opacity: .38
        }

        .sum-row-info .lbl {
            color: var(--gray-text)
        }

        .sum-row-info strong {
            color: #1a1445;
            display: block
        }

        .sum-divider {
            height: 1px;
            background: var(--gray-soft);
            margin: 1.1rem 0
        }

        .sum-rows {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 1.1rem
        }

        .sum-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--gray-text)
        }

        .sum-row .val {
            font-weight: 600;
            color: #1a1445
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding-top: 10px;
            border-top: 1.5px dashed var(--gray-mid);
            margin-bottom: 1.4rem
        }

        .sum-total .tl {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .22em;
            text-transform: uppercase
        }

        .sum-total .tv {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.35rem;
            color: #1a1445
        }

        .btn-pay {
            width: 100%;
            padding: 15px;
            background: var(--gold);
            color: #1a1445;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .28em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .35s cubic-bezier(.16, 1, .3, 1);
            box-shadow: 0 8px 28px rgba(196, 164, 124, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px
        }

        .btn-pay:hover:not(:disabled) {
            background: #b89240;
            transform: translateY(-2px);
            box-shadow: 0 14px 38px rgba(196, 164, 124, .4)
        }

        .phone-wrap {
            display: flex;
            gap: 8px;
        }

        .phone-code {
            width: 110px;
            flex-shrink: 0;
            padding: 11px 10px;
            border: 1.5px solid var(--gray-mid);
            border-radius: var(--radius-sm);
            background: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1a1445;
            outline: none;
            transition: border-color .22s;
            appearance: none;
            -webkit-appearance: none;
        }

        @media(max-width:600px) {
            .phone-code {
                width: 85px;
                font-size: 11px;
            }
        }

        .btn-pay:disabled {
            background: var(--gray-mid);
            color: var(--gray-text);
            box-shadow: none;
            cursor: not-allowed;
            transform: none
        }

        .btn-pay .btn-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(26, 20, 69, .2);
            border-top-color: #1a1445;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none
        }

        .btn-pay.loading .btn-spinner {
            display: block
        }

        .btn-pay.loading .btn-label {
            display: none
        }

        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--gray-text);
            margin-top: 10px
        }

        .secure-note svg {
            width: 11px;
            height: 11px
        }

        .pm-row {
            margin-top: 13px;
            padding-top: 13px;
            border-top: 1px solid var(--gray-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap
        }

        .pm {
            padding: 4px 9px;
            border: 1px solid var(--gray-mid);
            border-radius: 4px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .08em;
            color: var(--gray-text)
        }

        .policy ul,
        .policy li {
            color: rgba(255, 255, 255, .42);
            font-size: 10px;
            line-height: 1.75;
        }

        .policy {
            background: #1a1445;
            border-radius: var(--radius-md);
            padding: 1rem 1.25rem
        }

        .policy p {
            font-size: 10px;
            color: rgba(255, 255, 255, .42);
            line-height: 1.75
        }

        .policy strong {
            color: var(--gold)
        }

        /* TOAST */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #1a1445;
            padding: 12px 22px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            color: #fff;
            z-index: 9999;
            transition: transform .35s cubic-bezier(.16, 1, .3, 1);
            border: 1px solid rgba(196, 164, 124, .2);
            box-shadow: 0 16px 40px rgba(26, 20, 69, .3);
            white-space: nowrap;
            pointer-events: none
        }

        .toast.show {
            transform: translateX(-50%) translateY(0)
        }

        .toast.err {
            border-color: rgba(224, 82, 82, .4)
        }

        .toast.ok {
            border-color: rgba(45, 159, 106, .4)
        }

        /* REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: all .8s cubic-bezier(.16, 1, .3, 1)
        }

        .reveal.active {
            opacity: 1;
            transform: none
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        /* ── HIDE GLOBAL WA FLOAT ── */
        /* Sembunyikan pop up WA dari app.blade.php khusus untuk halaman ini */
        #wa-float, #wa-popup {
            display: none !important;
        }

        /* ── MOBILE FIXES ── */
@media(max-width:768px) {

    /* --- Hero --- */
    .tkt-hero {
        height: 32vh !important;
        min-height: 200px !important;
        padding: 0 1rem 1.8rem !important;
    }
    .tkt-hero-bg {
        height: 42vh !important;
        min-height: 240px !important;
    }
    .hero-title {
        font-size: 1.5rem !important;
        line-height: 1.2 !important;
    }
    .hero-eyebrow { font-size: 8px !important; }

    /* --- Layout --- */
    .tkt-wrap {
        padding: 1.2rem 0.9rem 2rem !important;
        gap: 1.2rem !important;
        grid-template-columns: 1fr !important;
    }
    .steps { display: none !important; }

    /* --- Cards --- */
    .card {
        padding: 1.3rem 1rem !important;
        margin-bottom: 1rem !important;
        border-radius: 16px !important;
    }
    .sh { margin-bottom: 1.2rem !important; }
    .sh h3 { font-size: .95rem !important; }
    .sh p  { font-size: 8px !important; }

    /* --- Calendar: beri padding kanan agar tidak ketutup tombol WA --- */
    .cal-hdr { margin-bottom: .9rem !important; }
    .cal-btn { width: 30px !important; height: 30px !important; }
    .cal-month { font-size: .95rem !important; }

    /* Grid kalender: beri ruang kanan ekstra */
    .cal-grid {
        padding-right: 4px !important;
        gap: 2px !important;
    }
    .cdn {
        font-size: 8px !important;
        letter-spacing: .1em !important;
        padding: 5px 0 8px !important;
    }
    .cd {
        font-size: 11px !important;
        border-radius: 6px !important;
    }

    /* --- Sessions --- */
    .sess-item { padding: .8rem .9rem !important; }
    .sess-time { font-size: .95rem !important; }
    .sess-label { font-size: 8px !important; }

    /* --- Tickets --- */
    .tkt-row { padding: .85rem .9rem !important; flex-wrap: wrap; gap: 8px; }
    .tkt-price {
        margin: 0 !important;
        min-width: unset !important;
        font-size: .88rem !important;
        text-align: left !important;
    }
    .tkt-price small { display: inline !important; margin-right: 4px; }
    .tkt-name { font-size: 12px !important; }
    .tkt-desc { font-size: 9px !important; }
    .qty-btn { width: 28px !important; height: 28px !important; }

    /* --- Form --- */
    .fg { grid-template-columns: 1fr !important; gap: 10px !important; }
    .field label { font-size: 8px !important; letter-spacing: .25em !important; }
    .field input,
    .field select {
        padding: 12px 12px !important;
        font-size: 16px !important; /* Cegah zoom iOS */
        border-radius: 6px !important;
    }

    /* Country code & negara dropdown */
    #cc-btn { height: 44px !important; min-width: 80px !important; font-size: 12px !important; }
    #f-phone { height: 44px !important; font-size: 16px !important; }
    #cc-dropdown {
        width: 270px !important;
        left: 0 !important;
        transform: none !important;
        z-index: 10000 !important;
    }
    #nc-dropdown {
        width: 100% !important;
        z-index: 10000 !important;
    }

    /* --- Right panel --- */
    .order-panel {
        position: static !important;
        top: auto !important;
        order: 2;
    }
    .sum-card {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 1000 !important;
        box-shadow: 0 -10px 40px rgba(26,20,69,0.12) !important;
        border-radius: 24px 24px 0 0 !important;
        margin: 0 !important;
        border: none !important;
        max-height: 85vh;

        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        background: #fff;
    }

    .sum-hdr {
        order: 2;
        width: 50%;
        padding: 1rem 0 1rem 1.2rem !important;
        border-radius: 0 !important;
        background: transparent !important;
        cursor: pointer;
    }
    .sum-hdr p { color: var(--gray-text) !important; margin-bottom: 2px !important; }
    .sum-price { color: #1a1445 !important; font-size: 1.35rem !important; }
    .sum-price small { color: var(--gray-text) !important; display: none !important; }
    .sum-chevron { display: block !important; stroke: #1a1445; margin-left: auto; margin-right: 10px; }

    .sum-action {
        order: 3;
        width: 50%;
        padding: 1rem 1.2rem 1rem 0.5rem !important;
        background: transparent !important;
    }

    .sum-body-wrapper {
        order: 1;
        width: 100%;
        display: none !important;
        max-height: 55vh;
        overflow-y: auto;
        border-bottom: 1px solid var(--gray-soft);
    }
    .sum-body-wrapper.show {
        display: block !important;
    }

    .sum-body { padding: 1.2rem 1.3rem !important; }

    /* --- Pay button --- */
    .btn-pay {
        padding: 15px !important;
        font-size: 12px !important;
        letter-spacing: .15em !important;
    }

    /* --- Policy box --- */
    .policy { border-radius: 12px !important; margin-bottom: 140px !important; }

    /* --- Breadcrumb --- */
    .breadcrumb { padding: 10px .9rem !important; }
    .bc-inner { font-size: 8px !important; gap: 4px !important; }

    /* --- Toast --- */
    .toast { bottom: 1.2rem !important; max-width: 88vw !important; font-size: 10px !important; }

}

/* --- Extra small (< 400px) --- */
@media(max-width:400px) {
    .tkt-hero { height: 28vh !important; min-height: 180px !important; }
    .hero-title { font-size: 1.35rem !important; }
    .tkt-wrap { padding: 1rem .7rem 2rem !important; }
    .card { padding: 1.1rem .9rem !important; }
    .cdn { font-size: 7px !important; }
    .cd  { font-size: 10px !important; }
}

/* ── PRODUCT MODAL ── */
@keyframes fadeIn {
    from { opacity:0 } to { opacity:1 }
}
@keyframes slideIn {
    from { transform:translateX(100%) } to { transform:translateX(0) }
}
@keyframes slideOut {
    from { transform:translateX(0) } to { transform:translateX(100%) }
}
@keyframes slideUp {
    from { opacity:0; transform:translateY(32px) scale(0.97) }
    to   { opacity:1; transform:translateY(0) scale(1) }
}


.prod-filter {
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid rgba(196,164,124,.3);
    background: transparent;
    color: rgba(255,255,255,.5);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all .2s;
    font-family: 'Inter', sans-serif;
}
.prod-filter:hover {
    border-color: var(--gold);
    color: var(--gold);
}
.prod-filter.active {
    background: var(--gold);
    border-color: var(--gold);
    color: #1a1445;
}


@media(max-width:600px) {
    #product-modal-panel {
        width: 100vw !important;
    }
}

/* Segmented Control Tabs Layout */
.pay-tabs-container {
    background: rgba(26, 20, 69, 0.05);
    padding: 4px;
    border-radius: 12px;
    display: flex;
    gap: 4px;
    width: 100%;
}

.pay-tab {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: transparent;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-align: center;
    position: relative;
    user-select: none;
}

.pay-tab span {
    font-size: 11px;
    font-weight: 800;
    color: rgba(26, 20, 69, 0.5);
    transition: color 0.25s ease;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.pay-tab i {
    font-size: 16px;
    color: rgba(26, 20, 69, 0.45);
    transition: color 0.25s ease;
}

.pay-tab:hover span {
    color: #1a1445;
}

.pay-tab.selected {
    background: #fff;
    box-shadow: 0 4px 12px rgba(26, 20, 69, 0.08);
}

.pay-tab.selected span {
    color: #1a1445;
}

.pay-tab.selected i {
    color: #1a1445;
}

/* Specific active colors for brand icons */
.pay-tab#opt-walkin.selected i {
    color: #25D366;
}
.pay-tab#opt-online.selected i {
    color: #3C3489;
}

.pay-tab-badge {
    font-size: 9px;
    font-weight: 800;
    background: #EEEDFE;
    color: #3C3489;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 4px;
    transition: all 0.25s ease;
}

.pay-tab.selected .pay-tab-badge {
    background: #1a1445;
    color: #fff;
}

.pay-tab-badge:empty {
    display: none;
}

.pay-tab.disabled-sess {
    opacity: 0.45;
    cursor: not-allowed;
    pointer-events: none;
}



    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <div class="tkt-hero">
        <div class="tkt-hero-bg"></div>
        <div class="hero-pattern"></div>
        <svg class="hero-deco" viewBox="0 0 80 180" fill="white" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="0" width="5" height="180" rx="2" />
            <rect x="75" y="0" width="5" height="180" rx="2" />
            <rect x="0" y="0" width="80" height="6" rx="2" />
            <rect x="0" y="58" width="80" height="4" rx="1" />
            <rect x="9" y="7" width="10" height="118" rx="2" />
            <rect x="24" y="13" width="10" height="113" rx="2" />
            <rect x="40" y="7" width="10" height="118" rx="2" />
            <rect x="56" y="11" width="10" height="116" rx="2" />
        </svg>
        <div class="hero-content">
            <div class="hero-eyebrow">Pesan Tiket</div>
            <h1 class="hero-title">Pertunjukan Angklung<br><em>&amp; Budaya Sunda</em></h1>

        </div>
    </div>

 <div class="breadcrumb">
    <div class="bc-inner">
        <a href="{{ route('home') }}">Beranda</a>
        <span class="sep">›</span>
        <span class="cur">Pesan Tiket</span>
        <span class="sep" style="opacity:.2;margin:0 4px">|</span>
  <a href="/produk"
   style="color:#1a1445;text-decoration:none;transition:color .2s"
   onmouseover="this.style.color='var(--gold)'"
   onmouseout="this.style.color='#1a1445'">
    Pesan Angklung
</a>
    </div>
</div>

    {{-- MAIN --}}
    <div class="tkt-wrap">

        {{-- STEPS --}}
        <div class="steps">
            <div class="step active" id="stp1">
                <div class="sn">1</div>
                <div class="sl">Data Pengunjung</div>
            </div>
            <div class="sline" id="l12"></div>
            <div class="step" id="stp2">
                <div class="sn">2</div>
                <div class="sl">Pilih Jadwal</div>
            </div>
            <div class="sline" id="l23"></div>
            <div class="step" id="stp3">
                <div class="sn">3</div>
                <div class="sl">Pilih Tiket</div>
            </div>
            <div class="sline" id="l34"></div>
            <div class="step" id="stp4">
                <div class="sn">4</div>
                <div class="sl">Metode Pembayaran</div>
            </div>
        </div>

        {{-- LEFT --}}
        <div>

            {{-- 1. DATA PENGUNJUNG --}}
            <div class="card reveal">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Data Pengunjung</h3>
                        <p>Untuk konfirmasi tiket</p>
                    </div>
                </div>
                <div class="form-gap">
                    <div class="fg">
                        <div class="field" id="field-name">
                            <label>Nama Lengkap</label>
                            <input type="text" id="f-name" placeholder="Masukkan nama lengkap" autocomplete="name">
                            <span class="field-err">Nama wajib diisi</span>
                        </div>
                        {{-- Nomor HP / WA --}}
<div class="field" id="field-phone">
    <label>Nomor HP / WA</label>
    <div style="display:flex;gap:8px;width:100%">

        {{-- Custom Country Code Dropdown --}}
        <div style="position:relative;flex-shrink:0" id="cc-trigger">
            <button type="button" id="cc-btn"
                style="display:flex;align-items:center;gap:6px;padding:0 10px;height:44px;min-width:90px;border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);background:#fff;cursor:pointer;font-size:13px;color:#1a1445;white-space:nowrap;">
                <span id="cc-flag" style="font-size:18px;line-height:1">🇮🇩</span>
                <span id="cc-code" style="font-weight:600">+62</span>
                <svg id="cc-arrow" style="margin-left:auto;width:12px;height:12px;opacity:.4;transition:transform .2s;flex-shrink:0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div id="cc-dropdown"
                style="display:none;position:absolute;top:calc(100% + 4px);left:0;z-index:999;width:270px;background:#fff;border:1.5px solid var(--gray-mid);border-radius:var(--radius-md);box-shadow:0 8px 24px rgba(0,0,0,.10);flex-direction:column;overflow:hidden">
                <div style="padding:8px;border-bottom:1px solid var(--gray-soft);position:relative">
                    <svg style="position:absolute;left:18px;top:50%;transform:translateY(-50%);width:13px;height:13px;opacity:.35;pointer-events:none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                    </svg>
                    <input id="cc-search" type="text" placeholder="Cari negara..."
                        style="width:100%;height:34px;padding:0 10px 0 30px;border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);font-size:12px;background:var(--bg);color:#1a1445;outline:none;font-family:'Inter',sans-serif"
                        autocomplete="off" spellcheck="false">
                </div>
                <div id="cc-list" style="overflow-y:auto;max-height:220px"></div>
            </div>
        </div>

        <input type="hidden" id="f-phone-code" value="+62">
        <input type="tel" id="f-phone" placeholder="8xxxxxxxxxx" autocomplete="tel"
            style="flex:1;min-width:0;height:44px;padding:0 14px;border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);background:#fff;font-size:13px;color:#1a1445;outline:none;font-family:'Inter',sans-serif">
    </div>
    <span class="field-err">Nomor HP wajib diisi</span>
</div>
                    </div>
                    <div class="fg full">
                        <div class="field" id="field-email">
                            <label>Email</label>
                            <input type="email" id="f-email" placeholder="email@contoh.com" autocomplete="email">
                            <span class="field-err">Format email tidak valid</span>

                            {{-- Honeypot field to prevent spam bots --}}
                            <div style="display:none !important;" aria-hidden="true">
                                <input type="text" id="f-honeypot" name="company_name_verification" tabindex="-1" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="fg">
                        {{-- Kota & Negara Asal --}}
                        {{-- BARU --}}
                        <div class="field">
                            <label>Kota Asal</label>
                            <input type="text" id="f-city" placeholder="e.g. Bandung"
                                autocomplete="address-level2">
                        </div>

<div class="field">
    <label>Negara Asal</label>

    {{-- Hidden input untuk value aktual --}}
    <input type="hidden" id="f-country" name="negara_asal">

    {{-- Trigger button --}}
    <div style="position:relative" id="nc-trigger">
        <button type="button" id="nc-btn"
            style="display:flex;align-items:center;gap:8px;width:100%;padding:0 14px;height:44px;
                   border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);
                   background:#fff;cursor:pointer;font-size:13px;color:#1a1445;text-align:left;
                   font-family:'Inter',sans-serif;transition:border-color .22s">
            <span id="nc-flag" style="font-size:18px;line-height:1;flex-shrink:0"></span>
            <span id="nc-label" style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
                                       color:rgba(26,20,69,.22)">Pilih negara...</span>
            <svg id="nc-arrow" style="width:12px;height:12px;opacity:.4;transition:transform .2s;flex-shrink:0"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        {{-- Dropdown --}}
        <div id="nc-dropdown"
            style="display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:998;
                   background:#fff;border:1.5px solid var(--gray-mid);border-radius:var(--radius-md);
                   box-shadow:0 8px 24px rgba(0,0,0,.10);flex-direction:column;overflow:hidden">

            {{-- Search box --}}
            <div style="padding:8px;border-bottom:1px solid var(--gray-soft);position:relative">
                <svg style="position:absolute;left:18px;top:50%;transform:translateY(-50%);
                            width:13px;height:13px;opacity:.35;pointer-events:none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                </svg>
                <input id="nc-search" type="text" placeholder="Cari negara..."
                    style="width:100%;height:34px;padding:0 10px 0 30px;
                           border:1.5px solid var(--gray-mid);border-radius:var(--radius-sm);
                           font-size:12px;background:var(--bg);color:#1a1445;outline:none;
                           font-family:'Inter',sans-serif"
                    autocomplete="off" spellcheck="false">
            </div>

            {{-- List --}}
            <div id="nc-list" style="overflow-y:auto;max-height:220px"></div>
        </div>
    </div>
</div>

                    </div>
                </div>

            </div>







            {{-- 2. PILIH TANGGAL --}}
            <div class="card reveal" style="transition-delay:.1s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Pilih Tanggal</h3>
                        <p>Tersedia setiap hari</p>
                    </div>
                </div>
                <div class="cal-hdr">
                    <div class="cal-month" id="cal-title"></div>
                    <div class="cal-navs">
                        <button class="cal-btn" onclick="chMonth(-1)" aria-label="Bulan sebelumnya">
                            <svg width="13" height="13" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="cal-btn" onclick="chMonth(1)" aria-label="Bulan berikutnya">
                            <svg width="13" height="13" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="cal-grid" id="cal-grid"></div>
            </div>

            {{-- 3. PILIH SESI --}}
            <div class="card reveal" style="transition-delay:.2s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Pilih Sesi</h3>
                        <p>Durasi 90 menit tiap sesi</p>
                    </div>
                </div>
                <div id="sess-box">
                    <div class="es">
                        <svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Pilih tanggal terlebih dahulu</p>
                    </div>
                </div>
            </div>

            {{-- 4. JENIS TIKET --}}
            <div class="card reveal" style="transition-delay:.3s">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div>
                        <h3>Jenis Tiket</h3>
                        <p>Termasuk welcome drink &amp; souvenir</p>
                    </div>
                </div>
                <div id="tkt-box">
                    <div class="es">
                        <svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <p>Pilih sesi terlebih dahulu</p>
                    </div>
                </div>
            </div>

        </div>{{-- end left --}}

        {{-- RIGHT PANEL --}}
        <div class="order-panel">

            <div class="sum-card reveal" id="sum-card-mobile">
                <div class="sum-hdr" onclick="toggleSumMobile()">
                    <div class="sum-hdr-text">
                        <p>Total Pembayaran</p>
                        <div class="sum-price" id="sum-price">Rp 0 <small>/ kunjungan</small></div>
                    </div>
                    <svg class="sum-chevron" id="sum-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 15l-6-6-6 6"/></svg>
                </div>
                <div class="sum-body-wrapper" id="sum-body-wrapper">
                    <div class="sum-body">
                    <div class="sum-info">
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div><span class="lbl">Tanggal</span><strong id="sum-date">—</strong></div>
                        </div>
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div><span class="lbl">Sesi</span><strong id="sum-sess">—</strong></div>
                        </div>
                        <div class="sum-row-info">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                            <div><span class="lbl">Tiket</span><strong id="sum-qty">0 tiket</strong></div>
                        </div>
                    </div>

                    <div class="sum-divider"></div>

                    {{-- PROMO CODE --}}
                    <div class="sum-promo-wrap" style="padding: 10px 0;">
                        <div style="display:flex;gap:8px">
                            <input type="text" id="promo-code" placeholder="Punya kode promo?"
                                style="flex:1;padding:9px 12px;border:1.5px solid var(--gray-mid);border-radius:8px;font-size:12px;outline:none;font-family:'Inter',sans-serif;text-transform:uppercase;"
                                autocomplete="off" spellcheck="false">
                            <button onclick="applyPromo()"
                                style="padding:9px 14px;background:#1a1445;color:#fff;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;">
                                Apply
                            </button>
                        </div>
                        <div id="promo-msg" style="font-size:10.5px;margin-top:6px;font-weight:500;"></div>

                        @if(isset($promos) && $promos->count() > 0)
                            <div style="margin-top: 12px;">
                                <div style="font-size: 10px; color: var(--gray-text); font-weight: 600; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.05em;">Promo Tersedia:</div>
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    @foreach($promos as $p)
                                        <div class="voucher-item" data-code="{{ strtoupper($p->code) }}" onclick="selectPromoCode('{{ $p->code }}')"
                                            style="display: flex; align-items: center; justify-content: space-between; padding: 8px 10px; background: rgba(196,164,124,0.06); border: 1px dashed rgba(196,164,124,0.4); border-radius: 6px; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='rgba(196,164,124,0.12)'; this.style.borderColor='var(--gold)';"
                                            onmouseout="this.style.background='rgba(196,164,124,0.06)'; this.style.borderColor='rgba(196,164,124,0.4)';">
                                            <div style="display: flex; align-items: center; gap: 8px; text-align: left;">
                                                @if($p->banner_image)
                                                    <img src="{{ asset('storage/' . $p->banner_image) }}" alt="Promo" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; flex-shrink: 0;">
                                                @else
                                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--gold); flex-shrink: 0;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                    </svg>
                                                @endif
                                                <div>
                                                    <div style="font-size: 11px; font-weight: 700; color: #1a1445; line-height: 1.2; text-transform: uppercase;">{{ $p->name }}</div>
                                                    <div style="font-size: 9px; color: var(--gray-text); line-height: 1.2; margin-top: 2px;">{{ $p->description ?: 'Diskon menarik untuk Anda' }}</div>
                                                </div>
                                            </div>
                                            <div class="claim-badge" style="font-size: 9.5px; font-weight: 700; color: var(--gold); background: #fff; padding: 2px 6px; border-radius: 4px; border: 1px solid rgba(196,164,124,0.25); flex-shrink: 0; margin-left: 8px; transition: all 0.2s;">
                                                Klaim
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>{{-- end sum-promo-wrap --}}

                      <!-- HOMPIMPLAY VOUCHER PROMO BANNER-->

<div style="margin-top: 16px; padding: 14px; background: linear-gradient(135deg, rgba(45, 159, 106, 0.08) 0%, rgba(31, 120, 78, 0.05) 100%); border: 1.5px solid rgba(45, 159, 106, 0.3); border-radius: 12px; position: relative; overflow: hidden;">
    <!-- Decorative corner -->
    <div style="position: absolute; top: -20px; right: -20px; width: 60px; height: 60px; background: radial-gradient(circle, rgba(45, 159, 106, 0.15), transparent); border-radius: 50%;"></div>

    <div style="display: flex; gap: 14px; align-items: flex-start;">
        <!-- Icon Box -->
        <div style="width: 56px; height: 56px; border-radius: 12px; background: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 6px 16px rgba(45,159,106,0.25); padding: 8px; box-sizing: border-box;">
            <img src="https://www.hompimplay.id/assets/home/logo-color.png" alt="Hompimplay" style="width: 100%; height: 100%; object-fit: contain;">
        </div>

        <!-- Content -->
        <div style="flex: 1; min-width: 0;">
           {{-- Label --}}
<span style="font-size: 10px; color: var(--success); font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;">Voucher Kolaborasi</span>

{{-- Judul --}}
<div style="font-size: 13px; font-weight: 800; color: #1a1445; line-height: 1.4; margin-bottom: 4px;">
    Voucher Rp 50.000 di HompimPlay
</div>

{{-- ↓ PERIODE DI SINI ↓ --}}
<div style="display: inline-flex; align-items: center; gap: 5px; background: rgba(45,159,106,0.1); border: 1px solid rgba(45,159,106,0.25); border-radius: 50px; padding: 3px 10px; margin-bottom: 8px;">
    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#1f784e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
    <span style="font-size: 10px; font-weight: 700; color: #1f784e; letter-spacing: 0.04em;">Berlaku 2 juni – 30 Juni 2026</span>
</div>

{{-- Deskripsi --}}
<div style="font-size: 10px; color: rgba(26,20,69,.6); line-height: 1.6; margin-bottom: 10px;">
   Liburan Budaya & Fun Play Experience dalam 1 Destinasi.
</div>

            <!-- OTOMATIS DIDAPATKAN -->
            <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; background: rgba(45, 159, 106, 0.1); border: 1px solid rgba(45, 159, 106, 0.3); border-radius: 50px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2d9f6a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                <span style="font-size: 11px; font-weight: 700; color: #2d9f6a; letter-spacing: 0.03em;">
                    Otomatis Didapatkan
                </span>
            </div>
        </div>
    </div>
</div>


                    <div class="sum-divider"></div>
                    <div class="sum-rows" id="sum-rows"></div>
                    <div class="sum-total" id="sum-total" style="display:none">
                        <span class="tl">Total</span>
                        <span class="tv" id="sum-tv">Rp 0</span>
                    </div>
                    <div id="payment-method-selector" style="display:none; margin-top: 16px; border-top: 1.5px solid var(--gray-soft); padding-top: 16px;">
                        <div style="font-size: 10px; color: var(--gray-text); font-weight: 800; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.05em; text-align: left;">Metode Pembayaran</div>
                        <div class="pay-tabs-container">
                            <div id="opt-walkin" class="pay-tab" onclick="selectPayMethod('walkin')">
                                <i class="ti ti-brand-whatsapp"></i>
                                <span>Walk-in (WA)</span>
                            </div>
                            <div id="opt-online" class="pay-tab" onclick="selectPayMethod('online')">
                                <i class="ti ti-credit-card"></i>
                                <span>Online (UdjoShop)</span>
                                <span id="online-slot-badge" class="pay-tab-badge"></span>
                            </div>
                        </div>
                        <div id="online-disabled-reason" style="display:none; font-size: 10.5px; color: var(--danger); margin-top: 8px; text-align: left; line-height: 1.4;"></div>
                        <div id="online-payment-channels" style="display:none; font-size: 11px; color: var(--gray-text); margin-top: 10px; background: rgba(196,164,124,0.08); padding: 10px 12px; border-radius: 8px; border: 1px solid rgba(196,164,124,0.15); text-align: left;">
                            <div style="font-weight: 700; color: #1a1445; margin-bottom: 4px;">💳 Pilihan Metode Pembayaran Online:</div>
                            <ul style="margin: 0; padding-left: 16px; line-height: 1.5; color: rgba(26, 20, 69, 0.85);">
                                <li><strong>QRIS</strong> &amp; <strong>OVO</strong></li>
                                <li><strong>Virtual Account</strong>: Bank BRI, Bank Mandiri, Bank BNI, Bank Permata, Bank Sahabat Sampoerna (BSS)</li>
                            </ul>
                        </div>
                    </div>
                </div>{{-- end sum-body --}}
            </div>{{-- end sum-body-wrapper --}}

            <div class="sum-action">

<button class="btn-pay" id="btn-pay" disabled onclick="handlePay()">
    <div class="btn-spinner"></div>
    <span class="btn-label">Pilih Metode Pembayaran</span>
</button>
            </div>
      </div>{{-- end sum-card --}}

        <div style="background:rgba(26,20,69,0.06);border:1px solid rgba(26,20,69,0.1);border-radius:16px;padding:20px 22px;">
            <p style="font-size:11px;font-weight:800;color:#1a1445;margin:0 0 12px;letter-spacing:0.04em;text-transform:uppercase;">📋 Keterangan</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <span style="color:#c9a84c;font-size:14px;line-height:1;flex-shrink:0;margin-top:2px;">•</span>
                    <span style="font-size:11px;color:rgba(26,20,69,0.7);line-height:1.65;">Data yang sudah diisi lengkap akan kami reservasikan. Formulir tidak lengkap belum dapat direservasikan.</span>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <span style="color:#c9a84c;font-size:14px;line-height:1;flex-shrink:0;margin-top:2px;">•</span>
                    <span style="font-size:11px;color:rgba(26,20,69,0.7);line-height:1.65;">Dilarang membawa makan/minum dari luar.</span>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <span style="color:#c9a84c;font-size:14px;line-height:1;flex-shrink:0;margin-top:2px;">•</span>
                    <span style="font-size:11px;color:rgba(26,20,69,0.7);line-height:1.65;">Dilarang membuang sampah rombongan di seluruh area Saung Angklung Udjo.</span>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <span style="color:#c9a84c;font-size:14px;line-height:1;flex-shrink:0;margin-top:2px;">•</span>
                    <span style="font-size:11px;color:rgba(26,20,69,0.7);line-height:1.65;">Mohon hadir 30 menit sebelum pertunjukan dimulai.</span>
                </div>
                <div style="display:flex;gap:8px;align-items:flex-start;">
                    <span style="color:#c9a84c;font-size:14px;line-height:1;flex-shrink:0;margin-top:2px;">•</span>
                    <span style="font-size:11px;color:rgba(26,20,69,0.7);line-height:1.65;">Tidak ada nomor kursi — tempat duduk sistem <em>First Come First Serve</em>.</span>
                </div>
            </div>
        </div>

    </div>{{-- end order-panel --}}

    </div>{{-- end wrap --}}
    <div class="toast" id="toast" role="alert" aria-live="polite"><span id="toast-msg">—</span></div>


@endsection

@push('scripts')
    @push('scripts')
        <script>
function toggleSumMobile() {
    if(window.innerWidth > 768) return;
    const bodyWrap = document.getElementById('sum-body-wrapper');
    const chevron = document.getElementById('sum-chevron');
    if(bodyWrap.classList.contains('show')) {
        bodyWrap.classList.remove('show');
        chevron.style.transform = 'rotate(0deg)';
    } else {
        bodyWrap.classList.add('show');
        chevron.style.transform = 'rotate(180deg)';
    }
}

// ── NEGARA ASAL SEARCHABLE DROPDOWN ──
const NC_COUNTRIES = [
    { flag:'🇮🇩', name:'Indonesia'                              },
    { flag:'🇺🇸', name:'Amerika Serikat'                        },
    { flag:'🇬🇧', name:'Inggris'                                },
    { flag:'🇦🇺', name:'Australia'                              },
    { flag:'🇸🇬', name:'Singapura'                              },
    { flag:'🇲🇾', name:'Malaysia'                               },
    { flag:'🇯🇵', name:'Jepang'                                 },
    { flag:'🇰🇷', name:'Korea Selatan'                          },
    { flag:'🇨🇳', name:'Tiongkok'                               },
    { flag:'🇮🇳', name:'India'                                  },
    { flag:'🇹🇭', name:'Thailand'                               },
    { flag:'🇳🇱', name:'Belanda'                                },
    { flag:'🇩🇪', name:'Jerman'                                 },
    { flag:'🇫🇷', name:'Prancis'                                },
    { flag:'🇦🇫', name:'Afganistan'                             },
    { flag:'🇦🇱', name:'Albania'                                },
    { flag:'🇩🇿', name:'Aljazair'                               },
    { flag:'🇦🇸', name:'Samoa Amerika'                          },
    { flag:'🇦🇩', name:'Andorra'                                },
    { flag:'🇦🇴', name:'Angola'                                 },
    { flag:'🇦🇮', name:'Anguilla'                               },
    { flag:'🇦🇬', name:'Antigua dan Barbuda'                    },
    { flag:'🇦🇷', name:'Argentina'                              },
    { flag:'🇦🇲', name:'Armenia'                                },
    { flag:'🇦🇼', name:'Aruba'                                  },
    { flag:'🇦🇹', name:'Austria'                                },
    { flag:'🇦🇿', name:'Azerbaijan'                             },
    { flag:'🇧🇸', name:'Bahama'                                 },
    { flag:'🇧🇭', name:'Bahrain'                                },
    { flag:'🇧🇩', name:'Bangladesh'                             },
    { flag:'🇧🇧', name:'Barbados'                               },
    { flag:'🇧🇾', name:'Belarus'                                },
    { flag:'🇧🇪', name:'Belgia'                                 },
    { flag:'🇧🇿', name:'Belize'                                 },
    { flag:'🇧🇯', name:'Benin'                                  },
    { flag:'🇧🇲', name:'Bermuda'                                },
    { flag:'🇧🇹', name:'Bhutan'                                 },
    { flag:'🇧🇴', name:'Bolivia'                                },
    { flag:'🇧🇦', name:'Bosnia dan Herzegovina'                 },
    { flag:'🇧🇼', name:'Botswana'                               },
    { flag:'🇧🇷', name:'Brasil'                                 },
    { flag:'🇻🇬', name:'Kepulauan Virgin Britania'              },
    { flag:'🇧🇳', name:'Brunei'                                 },
    { flag:'🇧🇬', name:'Bulgaria'                               },
    { flag:'🇧🇫', name:'Burkina Faso'                           },
    { flag:'🇧🇮', name:'Burundi'                                },
    { flag:'🇰🇭', name:'Kamboja'                                },
    { flag:'🇨🇲', name:'Kamerun'                                },
    { flag:'🇨🇦', name:'Kanada'                                 },
    { flag:'🇨🇻', name:'Tanjung Verde'                          },
    { flag:'🇰🇾', name:'Kepulauan Cayman'                       },
    { flag:'🇨🇫', name:'Republik Afrika Tengah'                 },
    { flag:'🇹🇩', name:'Chad'                                   },
    { flag:'🇨🇱', name:'Chili'                                  },
    { flag:'🇨🇴', name:'Kolombia'                               },
    { flag:'🇰🇲', name:'Komoro'                                 },
    { flag:'🇨🇬', name:'Kongo'                                  },
    { flag:'🇨🇩', name:'Kongo (RDK)'                            },
    { flag:'🇨🇰', name:'Kepulauan Cook'                         },
    { flag:'🇨🇷', name:'Kosta Rika'                             },
    { flag:'🇭🇷', name:'Kroasia'                                },
    { flag:'🇨🇺', name:'Kuba'                                   },
    { flag:'🇨🇼', name:'Curaçao'                                },
    { flag:'🇨🇾', name:'Siprus'                                 },
    { flag:'🇨🇿', name:'Ceko'                                   },
    { flag:'🇩🇰', name:'Denmark'                                },
    { flag:'🇩🇯', name:'Djibouti'                               },
    { flag:'🇩🇲', name:'Dominika'                               },
    { flag:'🇩🇴', name:'Republik Dominika'                      },
    { flag:'🇪🇨', name:'Ekuador'                                },
    { flag:'🇪🇬', name:'Mesir'                                  },
    { flag:'🇸🇻', name:'El Salvador'                            },
    { flag:'🇬🇶', name:'Guinea Khatulistiwa'                    },
    { flag:'🇪🇷', name:'Eritrea'                                },
    { flag:'🇪🇪', name:'Estonia'                                },
    { flag:'🇸🇿', name:'Eswatini'                               },
    { flag:'🇪🇹', name:'Etiopia'                                },
    { flag:'🇫🇰', name:'Kepulauan Falkland'                     },
    { flag:'🇫🇴', name:'Kepulauan Faroe'                        },
    { flag:'🇫🇯', name:'Fiji'                                   },
    { flag:'🇫🇮', name:'Finlandia'                              },
    { flag:'🇬🇫', name:'Guyana Prancis'                         },
    { flag:'🇵🇫', name:'Polinesia Prancis'                      },
    { flag:'🇬🇦', name:'Gabon'                                  },
    { flag:'🇬🇲', name:'Gambia'                                 },
    { flag:'🇬🇪', name:'Georgia'                                },
    { flag:'🇬🇭', name:'Ghana'                                  },
    { flag:'🇬🇮', name:'Gibraltar'                              },
    { flag:'🇬🇷', name:'Yunani'                                 },
    { flag:'🇬🇱', name:'Greenland'                              },
    { flag:'🇬🇩', name:'Grenada'                                },
    { flag:'🇬🇵', name:'Guadeloupe'                             },
    { flag:'🇬🇺', name:'Guam'                                   },
    { flag:'🇬🇹', name:'Guatemala'                              },
    { flag:'🇬🇳', name:'Guinea'                                 },
    { flag:'🇬🇼', name:'Guinea-Bissau'                          },
    { flag:'🇬🇾', name:'Guyana'                                 },
    { flag:'🇭🇹', name:'Haiti'                                  },
    { flag:'🇭🇳', name:'Honduras'                               },
    { flag:'🇭🇰', name:'Hong Kong'                              },
    { flag:'🇭🇺', name:'Hongaria'                               },
    { flag:'🇮🇸', name:'Islandia'                               },
    { flag:'🇮🇷', name:'Iran'                                   },
    { flag:'🇮🇶', name:'Irak'                                   },
    { flag:'🇮🇪', name:'Irlandia'                               },
    { flag:'🇮🇱', name:'Israel'                                 },
    { flag:'🇮🇹', name:'Italia'                                 },
    { flag:'🇨🇮', name:'Pantai Gading'                          },
    { flag:'🇯🇲', name:'Jamaika'                                },
    { flag:'🇯🇴', name:'Yordania'                               },
    { flag:'🇰🇿', name:'Kazakhstan'                             },
    { flag:'🇰🇪', name:'Kenya'                                  },
    { flag:'🇰🇮', name:'Kiribati'                               },
    { flag:'🇽🇰', name:'Kosovo'                                 },
    { flag:'🇰🇼', name:'Kuwait'                                 },
    { flag:'🇰🇬', name:'Kirgistan'                              },
    { flag:'🇱🇦', name:'Laos'                                   },
    { flag:'🇱🇻', name:'Latvia'                                 },
    { flag:'🇱🇧', name:'Lebanon'                                },
    { flag:'🇱🇸', name:'Lesotho'                                },
    { flag:'🇱🇷', name:'Liberia'                                },
    { flag:'🇱🇾', name:'Libya'                                  },
    { flag:'🇱🇮', name:'Liechtenstein'                          },
    { flag:'🇱🇹', name:'Lituania'                               },
    { flag:'🇱🇺', name:'Luksemburg'                             },
    { flag:'🇲🇴', name:'Makau'                                  },
    { flag:'🇲🇬', name:'Madagaskar'                             },
    { flag:'🇲🇼', name:'Malawi'                                 },
    { flag:'🇲🇻', name:'Maladewa'                               },
    { flag:'🇲🇱', name:'Mali'                                   },
    { flag:'🇲🇹', name:'Malta'                                  },
    { flag:'🇲🇭', name:'Kepulauan Marshall'                     },
    { flag:'🇲🇶', name:'Martinik'                               },
    { flag:'🇲🇷', name:'Mauritania'                             },
    { flag:'🇲🇺', name:'Mauritius'                              },
    { flag:'🇲🇽', name:'Meksiko'                                },
    { flag:'🇫🇲', name:'Mikronesia'                             },
    { flag:'🇲🇩', name:'Moldova'                                },
    { flag:'🇲🇨', name:'Monako'                                 },
    { flag:'🇲🇳', name:'Mongolia'                               },
    { flag:'🇲🇪', name:'Montenegro'                             },
    { flag:'🇲🇸', name:'Montserrat'                             },
    { flag:'🇲🇦', name:'Maroko'                                 },
    { flag:'🇲🇿', name:'Mozambik'                               },
    { flag:'🇲🇲', name:'Myanmar'                                },
    { flag:'🇳🇦', name:'Namibia'                                },
    { flag:'🇳🇷', name:'Nauru'                                  },
    { flag:'🇳🇵', name:'Nepal'                                  },
    { flag:'🇳🇨', name:'Kaledonia Baru'                         },
    { flag:'🇳🇿', name:'Selandia Baru'                          },
    { flag:'🇳🇮', name:'Nikaragua'                              },
    { flag:'🇳🇪', name:'Niger'                                  },
    { flag:'🇳🇬', name:'Nigeria'                                },
    { flag:'🇳🇺', name:'Niue'                                   },
    { flag:'🇰🇵', name:'Korea Utara'                            },
    { flag:'🇲🇰', name:'Makedonia Utara'                        },
    { flag:'🇳🇴', name:'Norwegia'                               },
    { flag:'🇴🇲', name:'Oman'                                   },
    { flag:'🇵🇰', name:'Pakistan'                               },
    { flag:'🇵🇼', name:'Palau'                                  },
    { flag:'🇵🇸', name:'Palestina'                              },
    { flag:'🇵🇦', name:'Panama'                                 },
    { flag:'🇵🇬', name:'Papua Nugini'                           },
    { flag:'🇵🇾', name:'Paraguay'                               },
    { flag:'🇵🇪', name:'Peru'                                   },
    { flag:'🇵🇭', name:'Filipina'                               },
    { flag:'🇵🇱', name:'Polandia'                               },
    { flag:'🇵🇹', name:'Portugal'                               },
    { flag:'🇵🇷', name:'Puerto Riko'                            },
    { flag:'🇶🇦', name:'Qatar'                                  },
    { flag:'🇷🇴', name:'Rumania'                                },
    { flag:'🇷🇺', name:'Rusia'                                  },
    { flag:'🇷🇼', name:'Rwanda'                                 },
    { flag:'🇰🇳', name:'Saint Kitts dan Nevis'                  },
    { flag:'🇱🇨', name:'Saint Lucia'                            },
    { flag:'🇻🇨', name:'Saint Vincent dan Grenadines'           },
    { flag:'🇼🇸', name:'Samoa'                                  },
    { flag:'🇸🇲', name:'San Marino'                             },
    { flag:'🇸🇹', name:'São Tomé dan Príncipe'                  },
    { flag:'🇸🇦', name:'Arab Saudi'                             },
    { flag:'🇸🇳', name:'Senegal'                                },
    { flag:'🇷🇸', name:'Serbia'                                 },
    { flag:'🇸🇨', name:'Seychelles'                             },
    { flag:'🇸🇱', name:'Sierra Leone'                           },
    { flag:'🇸🇰', name:'Slovakia'                               },
    { flag:'🇸🇮', name:'Slovenia'                               },
    { flag:'🇸🇧', name:'Kepulauan Solomon'                      },
    { flag:'🇸🇴', name:'Somalia'                                },
    { flag:'🇿🇦', name:'Afrika Selatan'                         },
    { flag:'🇸🇸', name:'Sudan Selatan'                          },
    { flag:'🇪🇸', name:'Spanyol'                                },
    { flag:'🇱🇰', name:'Sri Lanka'                              },
    { flag:'🇸🇩', name:'Sudan'                                  },
    { flag:'🇸🇷', name:'Suriname'                               },
    { flag:'🇸🇪', name:'Swedia'                                 },
    { flag:'🇨🇭', name:'Swiss'                                  },
    { flag:'🇸🇾', name:'Suriah'                                 },
    { flag:'🇹🇼', name:'Taiwan'                                 },
    { flag:'🇹🇯', name:'Tajikistan'                             },
    { flag:'🇹🇿', name:'Tanzania'                               },
    { flag:'🇹🇱', name:'Timor-Leste'                            },
    { flag:'🇹🇬', name:'Togo'                                   },
    { flag:'🇹🇴', name:'Tonga'                                  },
    { flag:'🇹🇹', name:'Trinidad dan Tobago'                    },
    { flag:'🇹🇳', name:'Tunisia'                                },
    { flag:'🇹🇷', name:'Turki'                                  },
    { flag:'🇹🇲', name:'Turkmenistan'                           },
    { flag:'🇹🇻', name:'Tuvalu'                                 },
    { flag:'🇺🇬', name:'Uganda'                                 },
    { flag:'🇺🇦', name:'Ukraina'                                },
    { flag:'🇦🇪', name:'Uni Emirat Arab'                        },
    { flag:'🇺🇾', name:'Uruguay'                                },
    { flag:'🇺🇿', name:'Uzbekistan'                             },
    { flag:'🇻🇺', name:'Vanuatu'                                },
    { flag:'🇻🇦', name:'Vatikan'                                },
    { flag:'🇻🇪', name:'Venezuela'                              },
    { flag:'🇻🇳', name:'Vietnam'                                },
    { flag:'🇾🇪', name:'Yaman'                                  },
    { flag:'🇿🇲', name:'Zambia'                                 },
    { flag:'🇿🇼', name:'Zimbabwe'                               },
];
let ncSelected = null;
let ncQuery    = '';

function ncRenderList() {
    const q        = ncQuery.toLowerCase().trim();
    const filtered = q
        ? NC_COUNTRIES.filter(c => c.name.toLowerCase().includes(q))
        : NC_COUNTRIES;

    const list = document.getElementById('nc-list');
    if (!filtered.length) {
        list.innerHTML = '<div style="padding:16px;font-size:12px;color:var(--gray-text);text-align:center">Negara tidak ditemukan</div>';
        return;
    }

    list.innerHTML = filtered.map(c => {
        const isActive = ncSelected && ncSelected.name === c.name;
        return `
        <div data-name="${c.name}"
            style="display:flex;align-items:center;gap:10px;padding:9px 14px;cursor:pointer;font-size:13px;
                   background:${isActive ? 'rgba(196,164,124,.12)' : 'transparent'};transition:background .12s">
            <span style="font-size:18px;line-height:1;flex-shrink:0">${c.flag}</span>
            <span style="flex:1;color:#1a1445;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${c.name}</span>
            ${isActive ? '<svg style="width:12px;height:12px;flex-shrink:0" fill="none" stroke="#c4a47c" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>' : ''}
        </div>`;
    }).join('');

    list.querySelectorAll('[data-name]').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.background = 'var(--gray-soft)');
        el.addEventListener('mouseleave', () => {
            el.style.background = (ncSelected && el.dataset.name === ncSelected.name)
                ? 'rgba(196,164,124,.12)' : 'transparent';
        });
        el.addEventListener('click', () => {
            const country = NC_COUNTRIES.find(c => c.name === el.dataset.name);
            if (country) ncPick(country);
        });
    });
}

function ncPick(country) {
    ncSelected = country;
    document.getElementById('nc-flag').textContent  = country.flag;
    document.getElementById('nc-label').textContent = country.name;
    document.getElementById('nc-label').style.color = '#1a1445';
    document.getElementById('f-country').value      = country.name;
    ncClose();
    ncRenderList();
}

function ncOpen() {
    const dd = document.getElementById('nc-dropdown');
    dd.style.display = 'flex';
    document.getElementById('nc-btn').style.borderColor = 'var(--gold)';
    document.getElementById('nc-arrow').style.transform = 'rotate(180deg)';
    document.getElementById('nc-search').value = '';
    ncQuery = '';
    ncRenderList();
    // scroll ke item aktif
    setTimeout(() => {
        document.getElementById('nc-search').focus();
        const active = document.querySelector('#nc-list [data-name]');
        if (ncSelected && active) {
            const sel = document.querySelector(`#nc-list [data-name="${ncSelected.name}"]`);
            if (sel) sel.scrollIntoView({ block:'nearest' });
        }
    }, 50);
}

function ncClose() {
    document.getElementById('nc-dropdown').style.display = 'none';
    document.getElementById('nc-btn').style.borderColor = 'var(--gray-mid)';
    document.getElementById('nc-arrow').style.transform = '';
}

document.getElementById('nc-btn').addEventListener('click', e => {
    e.stopPropagation();
    document.getElementById('nc-dropdown').style.display === 'flex' ? ncClose() : ncOpen();
});

document.getElementById('nc-search').addEventListener('input', function () {
    ncQuery = this.value;
    ncRenderList();
});

document.getElementById('nc-search').addEventListener('keydown', e => {
    if (e.key === 'Escape') ncClose();
});

document.addEventListener('click', e => {
    if (!document.getElementById('nc-trigger').contains(e.target)) ncClose();
});


   // ── COUNTRY CODE DROPDOWN ──
const CC_COUNTRIES = [
    { flag:'🇮🇩', name:'Indonesia',                            code:'+62'   },
    { flag:'🇺🇸', name:'United States',                        code:'+1'    },
    { flag:'🇬🇧', name:'United Kingdom',                       code:'+44'   },
    { flag:'🇦🇺', name:'Australia',                            code:'+61'   },
    { flag:'🇸🇬', name:'Singapore',                            code:'+65'   },
    { flag:'🇲🇾', name:'Malaysia',                             code:'+60'   },
    { flag:'🇯🇵', name:'Japan',                                code:'+81'   },
    { flag:'🇰🇷', name:'South Korea',                          code:'+82'   },
    { flag:'🇨🇳', name:'China',                                code:'+86'   },
    { flag:'🇮🇳', name:'India',                                code:'+91'   },
    { flag:'🇹🇭', name:'Thailand',                             code:'+66'   },
    { flag:'🇳🇱', name:'Netherlands',                          code:'+31'   },
    { flag:'🇩🇪', name:'Germany',                              code:'+49'   },
    { flag:'🇫🇷', name:'France',                               code:'+33'   },
    { flag:'🇦🇫', name:'Afghanistan',                          code:'+93'   },
    { flag:'🇦🇱', name:'Albania',                              code:'+355'  },
    { flag:'🇩🇿', name:'Algeria',                              code:'+213'  },
    { flag:'🇦🇸', name:'American Samoa',                       code:'+1-684'},
    { flag:'🇦🇩', name:'Andorra',                              code:'+376'  },
    { flag:'🇦🇴', name:'Angola',                               code:'+244'  },
    { flag:'🇦🇮', name:'Anguilla',                             code:'+1-264'},
    { flag:'🇦🇬', name:'Antigua and Barbuda',                  code:'+1-268'},
    { flag:'🇦🇷', name:'Argentina',                            code:'+54'   },
    { flag:'🇦🇲', name:'Armenia',                              code:'+374'  },
    { flag:'🇦🇼', name:'Aruba',                                code:'+297'  },
    { flag:'🇦🇹', name:'Austria',                              code:'+43'   },
    { flag:'🇦🇿', name:'Azerbaijan',                           code:'+994'  },
    { flag:'🇧🇸', name:'Bahamas',                              code:'+1-242'},
    { flag:'🇧🇭', name:'Bahrain',                              code:'+973'  },
    { flag:'🇧🇩', name:'Bangladesh',                           code:'+880'  },
    { flag:'🇧🇧', name:'Barbados',                             code:'+1-246'},
    { flag:'🇧🇾', name:'Belarus',                              code:'+375'  },
    { flag:'🇧🇪', name:'Belgium',                              code:'+32'   },
    { flag:'🇧🇿', name:'Belize',                               code:'+501'  },
    { flag:'🇧🇯', name:'Benin',                                code:'+229'  },
    { flag:'🇧🇲', name:'Bermuda',                              code:'+1-441'},
    { flag:'🇧🇹', name:'Bhutan',                               code:'+975'  },
    { flag:'🇧🇴', name:'Bolivia',                              code:'+591'  },
    { flag:'🇧🇦', name:'Bosnia and Herzegovina',               code:'+387'  },
    { flag:'🇧🇼', name:'Botswana',                             code:'+267'  },
    { flag:'🇧🇷', name:'Brazil',                               code:'+55'   },
    { flag:'🇮🇴', name:'British Indian Ocean Territory',        code:'+246'  },
    { flag:'🇻🇬', name:'British Virgin Islands',               code:'+1-284'},
    { flag:'🇧🇳', name:'Brunei',                               code:'+673'  },
    { flag:'🇧🇬', name:'Bulgaria',                             code:'+359'  },
    { flag:'🇧🇫', name:'Burkina Faso',                         code:'+226'  },
    { flag:'🇧🇮', name:'Burundi',                              code:'+257'  },
    { flag:'🇰🇭', name:'Cambodia',                             code:'+855'  },
    { flag:'🇨🇲', name:'Cameroon',                             code:'+237'  },
    { flag:'🇨🇦', name:'Canada',                               code:'+1'    },
    { flag:'🇨🇻', name:'Cape Verde',                           code:'+238'  },
    { flag:'🇰🇾', name:'Cayman Islands',                       code:'+1-345'},
    { flag:'🇨🇫', name:'Central African Republic',             code:'+236'  },
    { flag:'🇹🇩', name:'Chad',                                 code:'+235'  },
    { flag:'🇨🇱', name:'Chile',                                code:'+56'   },
    { flag:'🇨🇽', name:'Christmas Island',                     code:'+61'   },
    { flag:'🇨🇨', name:'Cocos Islands',                        code:'+61'   },
    { flag:'🇨🇴', name:'Colombia',                             code:'+57'   },
    { flag:'🇰🇲', name:'Comoros',                              code:'+269'  },
    { flag:'🇨🇬', name:'Congo',                                code:'+242'  },
    { flag:'🇨🇩', name:'Congo (DRC)',                          code:'+243'  },
    { flag:'🇨🇰', name:'Cook Islands',                         code:'+682'  },
    { flag:'🇨🇷', name:'Costa Rica',                           code:'+506'  },
    { flag:'🇭🇷', name:'Croatia',                              code:'+385'  },
    { flag:'🇨🇺', name:'Cuba',                                 code:'+53'   },
    { flag:'🇨🇼', name:'Curaçao',                              code:'+599'  },
    { flag:'🇨🇾', name:'Cyprus',                               code:'+357'  },
    { flag:'🇨🇿', name:'Czech Republic',                       code:'+420'  },
    { flag:'🇩🇰', name:'Denmark',                              code:'+45'   },
    { flag:'🇩🇯', name:'Djibouti',                             code:'+253'  },
    { flag:'🇩🇲', name:'Dominica',                             code:'+1-767'},
    { flag:'🇩🇴', name:'Dominican Republic',                   code:'+1-809'},
    { flag:'🇪🇨', name:'Ecuador',                              code:'+593'  },
    { flag:'🇪🇬', name:'Egypt',                                code:'+20'   },
    { flag:'🇸🇻', name:'El Salvador',                          code:'+503'  },
    { flag:'🇬🇶', name:'Equatorial Guinea',                    code:'+240'  },
    { flag:'🇪🇷', name:'Eritrea',                              code:'+291'  },
    { flag:'🇪🇪', name:'Estonia',                              code:'+372'  },
    { flag:'🇸🇿', name:'Eswatini',                             code:'+268'  },
    { flag:'🇪🇹', name:'Ethiopia',                             code:'+251'  },
    { flag:'🇫🇰', name:'Falkland Islands',                     code:'+500'  },
    { flag:'🇫🇴', name:'Faroe Islands',                        code:'+298'  },
    { flag:'🇫🇯', name:'Fiji',                                 code:'+679'  },
    { flag:'🇫🇮', name:'Finland',                              code:'+358'  },
    { flag:'🇬🇫', name:'French Guiana',                        code:'+594'  },
    { flag:'🇵🇫', name:'French Polynesia',                     code:'+689'  },
    { flag:'🇬🇦', name:'Gabon',                                code:'+241'  },
    { flag:'🇬🇲', name:'Gambia',                               code:'+220'  },
    { flag:'🇬🇪', name:'Georgia',                              code:'+995'  },
    { flag:'🇬🇭', name:'Ghana',                                code:'+233'  },
    { flag:'🇬🇮', name:'Gibraltar',                            code:'+350'  },
    { flag:'🇬🇷', name:'Greece',                               code:'+30'   },
    { flag:'🇬🇱', name:'Greenland',                            code:'+299'  },
    { flag:'🇬🇩', name:'Grenada',                              code:'+1-473'},
    { flag:'🇬🇵', name:'Guadeloupe',                           code:'+590'  },
    { flag:'🇬🇺', name:'Guam',                                 code:'+1-671'},
    { flag:'🇬🇹', name:'Guatemala',                            code:'+502'  },
    { flag:'🇬🇬', name:'Guernsey',                             code:'+44'   },
    { flag:'🇬🇳', name:'Guinea',                               code:'+224'  },
    { flag:'🇬🇼', name:'Guinea-Bissau',                        code:'+245'  },
    { flag:'🇬🇾', name:'Guyana',                               code:'+592'  },
    { flag:'🇭🇹', name:'Haiti',                                code:'+509'  },
    { flag:'🇭🇳', name:'Honduras',                             code:'+504'  },
    { flag:'🇭🇰', name:'Hong Kong',                            code:'+852'  },
    { flag:'🇭🇺', name:'Hungary',                              code:'+36'   },
    { flag:'🇮🇸', name:'Iceland',                              code:'+354'  },
    { flag:'🇮🇷', name:'Iran',                                 code:'+98'   },
    { flag:'🇮🇶', name:'Iraq',                                 code:'+964'  },
    { flag:'🇮🇪', name:'Ireland',                              code:'+353'  },
    { flag:'🇮🇲', name:'Isle of Man',                          code:'+44'   },
    { flag:'🇮🇱', name:'Israel',                               code:'+972'  },
    { flag:'🇮🇹', name:'Italy',                                code:'+39'   },
    { flag:'🇨🇮', name:"Ivory Coast",                          code:'+225'  },
    { flag:'🇯🇲', name:'Jamaica',                              code:'+1-876'},
    { flag:'🇯🇴', name:'Jordan',                               code:'+962'  },
    { flag:'🇰🇿', name:'Kazakhstan',                           code:'+7'    },
    { flag:'🇰🇪', name:'Kenya',                                code:'+254'  },
    { flag:'🇰🇮', name:'Kiribati',                             code:'+686'  },
    { flag:'🇽🇰', name:'Kosovo',                               code:'+383'  },
    { flag:'🇰🇼', name:'Kuwait',                               code:'+965'  },
    { flag:'🇰🇬', name:'Kyrgyzstan',                           code:'+996'  },
    { flag:'🇱🇦', name:'Laos',                                 code:'+856'  },
    { flag:'🇱🇻', name:'Latvia',                               code:'+371'  },
    { flag:'🇱🇧', name:'Lebanon',                              code:'+961'  },
    { flag:'🇱🇸', name:'Lesotho',                              code:'+266'  },
    { flag:'🇱🇷', name:'Liberia',                              code:'+231'  },
    { flag:'🇱🇾', name:'Libya',                                code:'+218'  },
    { flag:'🇱🇮', name:'Liechtenstein',                        code:'+423'  },
    { flag:'🇱🇹', name:'Lithuania',                            code:'+370'  },
    { flag:'🇱🇺', name:'Luxembourg',                           code:'+352'  },
    { flag:'🇲🇴', name:'Macau',                                code:'+853'  },
    { flag:'🇲🇬', name:'Madagascar',                           code:'+261'  },
    { flag:'🇲🇼', name:'Malawi',                               code:'+265'  },
    { flag:'🇲🇻', name:'Maldives',                             code:'+960'  },
    { flag:'🇲🇱', name:'Mali',                                 code:'+223'  },
    { flag:'🇲🇹', name:'Malta',                                code:'+356'  },
    { flag:'🇲🇭', name:'Marshall Islands',                     code:'+692'  },
    { flag:'🇲🇶', name:'Martinique',                           code:'+596'  },
    { flag:'🇲🇷', name:'Mauritania',                           code:'+222'  },
    { flag:'🇲🇺', name:'Mauritius',                            code:'+230'  },
    { flag:'🇾🇹', name:'Mayotte',                              code:'+262'  },
    { flag:'🇲🇽', name:'Mexico',                               code:'+52'   },
    { flag:'🇫🇲', name:'Micronesia',                           code:'+691'  },
    { flag:'🇲🇩', name:'Moldova',                              code:'+373'  },
    { flag:'🇲🇨', name:'Monaco',                               code:'+377'  },
    { flag:'🇲🇳', name:'Mongolia',                             code:'+976'  },
    { flag:'🇲🇪', name:'Montenegro',                           code:'+382'  },
    { flag:'🇲🇸', name:'Montserrat',                           code:'+1-664'},
    { flag:'🇲🇦', name:'Morocco',                              code:'+212'  },
    { flag:'🇲🇿', name:'Mozambique',                           code:'+258'  },
    { flag:'🇲🇲', name:'Myanmar (Burma)',                       code:'+95'   },
    { flag:'🇳🇦', name:'Namibia',                              code:'+264'  },
    { flag:'🇳🇷', name:'Nauru',                                code:'+674'  },
    { flag:'🇳🇵', name:'Nepal',                                code:'+977'  },
    { flag:'🇳🇨', name:'New Caledonia',                        code:'+687'  },
    { flag:'🇳🇿', name:'New Zealand',                          code:'+64'   },
    { flag:'🇳🇮', name:'Nicaragua',                            code:'+505'  },
    { flag:'🇳🇪', name:'Niger',                                code:'+227'  },
    { flag:'🇳🇬', name:'Nigeria',                              code:'+234'  },
    { flag:'🇳🇺', name:'Niue',                                 code:'+683'  },
    { flag:'🇳🇫', name:'Norfolk Island',                       code:'+672'  },
    { flag:'🇰🇵', name:'North Korea',                          code:'+850'  },
    { flag:'🇲🇰', name:'North Macedonia',                      code:'+389'  },
    { flag:'🇲🇵', name:'Northern Mariana Islands',             code:'+1-670'},
    { flag:'🇳🇴', name:'Norway',                               code:'+47'   },
    { flag:'🇴🇲', name:'Oman',                                 code:'+968'  },
    { flag:'🇵🇰', name:'Pakistan',                             code:'+92'   },
    { flag:'🇵🇼', name:'Palau',                                code:'+680'  },
    { flag:'🇵🇸', name:'Palestine',                            code:'+970'  },
    { flag:'🇵🇦', name:'Panama',                               code:'+507'  },
    { flag:'🇵🇬', name:'Papua New Guinea',                     code:'+675'  },
    { flag:'🇵🇾', name:'Paraguay',                             code:'+595'  },
    { flag:'🇵🇪', name:'Peru',                                 code:'+51'   },
    { flag:'🇵🇭', name:'Philippines',                          code:'+63'   },
    { flag:'🇵🇳', name:'Pitcairn Islands',                     code:'+870'  },
    { flag:'🇵🇱', name:'Poland',                               code:'+48'   },
    { flag:'🇵🇹', name:'Portugal',                             code:'+351'  },
    { flag:'🇵🇷', name:'Puerto Rico',                          code:'+1-787'},
    { flag:'🇶🇦', name:'Qatar',                                code:'+974'  },
    { flag:'🇷🇪', name:'Réunion',                              code:'+262'  },
    { flag:'🇷🇴', name:'Romania',                              code:'+40'   },
    { flag:'🇷🇺', name:'Russia',                               code:'+7'    },
    { flag:'🇷🇼', name:'Rwanda',                               code:'+250'  },
    { flag:'🇧🇱', name:'Saint Barthélemy',                     code:'+590'  },
    { flag:'🇸🇭', name:'Saint Helena',                         code:'+290'  },
    { flag:'🇰🇳', name:'Saint Kitts and Nevis',                code:'+1-869'},
    { flag:'🇱🇨', name:'Saint Lucia',                          code:'+1-758'},
    { flag:'🇲🇫', name:'Saint Martin',                         code:'+590'  },
    { flag:'🇵🇲', name:'Saint Pierre and Miquelon',            code:'+508'  },
    { flag:'🇻🇨', name:'Saint Vincent and the Grenadines',     code:'+1-784'},
    { flag:'🇼🇸', name:'Samoa',                                code:'+685'  },
    { flag:'🇸🇲', name:'San Marino',                           code:'+378'  },
    { flag:'🇸🇹', name:'São Tomé and Príncipe',                code:'+239'  },
    { flag:'🇸🇦', name:'Saudi Arabia',                         code:'+966'  },
    { flag:'🇸🇳', name:'Senegal',                              code:'+221'  },
    { flag:'🇷🇸', name:'Serbia',                               code:'+381'  },
    { flag:'🇸🇨', name:'Seychelles',                           code:'+248'  },
    { flag:'🇸🇱', name:'Sierra Leone',                         code:'+232'  },
    { flag:'🇸🇽', name:'Sint Maarten',                         code:'+1-721'},
    { flag:'🇸🇰', name:'Slovakia',                             code:'+421'  },
    { flag:'🇸🇮', name:'Slovenia',                             code:'+386'  },
    { flag:'🇸🇧', name:'Solomon Islands',                      code:'+677'  },
    { flag:'🇸🇴', name:'Somalia',                              code:'+252'  },
    { flag:'🇿🇦', name:'South Africa',                         code:'+27'   },
    { flag:'🇬🇸', name:'South Georgia',                        code:'+500'  },
    { flag:'🇸🇸', name:'South Sudan',                          code:'+211'  },
    { flag:'🇪🇸', name:'Spain',                                code:'+34'   },
    { flag:'🇱🇰', name:'Sri Lanka',                            code:'+94'   },
    { flag:'🇸🇩', name:'Sudan',                                code:'+249'  },
    { flag:'🇸🇷', name:'Suriname',                             code:'+597'  },
    { flag:'🇸🇯', name:'Svalbard and Jan Mayen',               code:'+47'   },
    { flag:'🇸🇪', name:'Sweden',                               code:'+46'   },
    { flag:'🇨🇭', name:'Switzerland',                          code:'+41'   },
    { flag:'🇸🇾', name:'Syria',                                code:'+963'  },
    { flag:'🇹🇼', name:'Taiwan',                               code:'+886'  },
    { flag:'🇹🇯', name:'Tajikistan',                           code:'+992'  },
    { flag:'🇹🇿', name:'Tanzania',                             code:'+255'  },
    { flag:'🇹🇱', name:'Timor-Leste',                          code:'+670'  },
    { flag:'🇹🇬', name:'Togo',                                 code:'+228'  },
    { flag:'🇹🇰', name:'Tokelau',                              code:'+690'  },
    { flag:'🇹🇴', name:'Tonga',                                code:'+676'  },
    { flag:'🇹🇹', name:'Trinidad and Tobago',                  code:'+1-868'},
    { flag:'🇹🇳', name:'Tunisia',                              code:'+216'  },
    { flag:'🇹🇷', name:'Turkey',                               code:'+90'   },
    { flag:'🇹🇲', name:'Turkmenistan',                         code:'+993'  },
    { flag:'🇹🇨', name:'Turks and Caicos Islands',             code:'+1-649'},
    { flag:'🇹🇻', name:'Tuvalu',                               code:'+688'  },
    { flag:'🇺🇬', name:'Uganda',                               code:'+256'  },
    { flag:'🇺🇦', name:'Ukraine',                              code:'+380'  },
    { flag:'🇦🇪', name:'United Arab Emirates',                 code:'+971'  },
    { flag:'🇺🇾', name:'Uruguay',                              code:'+598'  },
    { flag:'🇻🇮', name:'US Virgin Islands',                    code:'+1-340'},
    { flag:'🇺🇿', name:'Uzbekistan',                           code:'+998'  },
    { flag:'🇻🇺', name:'Vanuatu',                              code:'+678'  },
    { flag:'🇻🇦', name:'Vatican City',                         code:'+379'  },
    { flag:'🇻🇪', name:'Venezuela',                            code:'+58'   },
    { flag:'🇻🇳', name:'Vietnam',                              code:'+84'   },
    { flag:'🇼🇫', name:'Wallis and Futuna',                    code:'+681'  },
    { flag:'🇪🇭', name:'Western Sahara',                       code:'+212'  },
    { flag:'🇾🇪', name:'Yemen',                                code:'+967'  },
    { flag:'🇿🇲', name:'Zambia',                               code:'+260'  },
    { flag:'🇿🇼', name:'Zimbabwe',                             code:'+263'  },
];

let ccSelected = CC_COUNTRIES[0];
let ccQuery = '';
function ccRenderList() {
    const q = ccQuery.toLowerCase().trim();
    const filtered = q
        ? CC_COUNTRIES.filter(c =>
            c.name.toLowerCase().includes(q) ||
            c.code.includes(q) ||
            c.code.replace('+','').includes(q)
          )
        : CC_COUNTRIES;

    const list = document.getElementById('cc-list');
    if (!filtered.length) {
        list.innerHTML = '<div style="padding:16px;font-size:12px;color:var(--gray-text);text-align:center">Negara tidak ditemukan</div>';
        return;
    }

    list.innerHTML = filtered.map(c => {
        const isActive = c.code === ccSelected.code && c.name === ccSelected.name;
        return `
        <div data-code="${c.code}" data-name="${c.name}"
            style="display:flex;align-items:center;gap:10px;padding:9px 14px;cursor:pointer;font-size:13px;
                   background:${isActive ? 'rgba(196,164,124,.12)' : 'transparent'};
                   transition:background .12s">
            <span style="font-size:18px;line-height:1;flex-shrink:0">${c.flag}</span>
            <span style="flex:1;color:#1a1445;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${c.name}</span>
            <span style="font-size:11px;color:var(--gray-text);font-weight:600;flex-shrink:0">${c.code}</span>
            ${isActive ? '<svg style="width:12px;height:12px;flex-shrink:0" fill="none" stroke="#c4a47c" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>' : ''}
        </div>`;
    }).join('');

    list.querySelectorAll('[data-code]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.background = 'var(--gray-soft)';
        });
        el.addEventListener('mouseleave', () => {
            const isActive = el.dataset.code === ccSelected.code && el.dataset.name === ccSelected.name;
            el.style.background = isActive ? 'rgba(196,164,124,.12)' : 'transparent';
        });
        el.addEventListener('click', () => {
            const country = CC_COUNTRIES.find(c => c.code === el.dataset.code && c.name === el.dataset.name);
            if (country) ccPick(country);
        });
    });
}
function ccPick(country) {
    ccSelected = country;
    document.getElementById('cc-flag').textContent = country.flag;
    document.getElementById('cc-code').textContent = country.code;
    document.getElementById('f-phone-code').value = country.code;
    ccClose();
    ccRenderList();
}
function ccOpen() {
    const dd = document.getElementById('cc-dropdown');
    dd.style.display = 'flex';
    document.getElementById('cc-btn').style.borderColor = 'var(--gold)';
    document.getElementById('cc-arrow').style.transform = 'rotate(180deg)';
    document.getElementById('cc-search').value = '';
    ccQuery = '';
    ccRenderList();
    setTimeout(() => document.getElementById('cc-search').focus(), 50);
}

function ccClose() {
    document.getElementById('cc-dropdown').style.display = 'none';
    document.getElementById('cc-btn').style.borderColor = 'var(--gray-mid)';
    document.getElementById('cc-arrow').style.transform = '';
}

document.getElementById('cc-btn').addEventListener('click', e => {
    e.stopPropagation();
    document.getElementById('cc-dropdown').style.display === 'flex' ? ccClose() : ccOpen();
});

document.getElementById('cc-search').addEventListener('input', function() {
    ccQuery = this.value;
    ccRenderList();
});

document.getElementById('cc-search').addEventListener('keydown', e => {
    if (e.key === 'Escape') ccClose();
});

document.addEventListener('click', e => {
    if (!document.getElementById('cc-trigger').contains(e.target)) ccClose();
});

// Sinkronisasi dengan auto-fill dari pilihan negara
const countryPhoneMap = { /* ... map yang sudah ada ... */ };
document.getElementById('f-country')?.addEventListener('change', function () {
    if (!userChangedPhoneCode) {
        const code = countryPhoneMap[this.value];
        if (code) {
            const country = CC_COUNTRIES.find(c => c.code === code);
            if (country) ccPick(country);
        }
    }
});


            const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember'
            ];
            const DAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            const NOW = new Date();
            const TODAY_Y = NOW.getFullYear(),
                TODAY_M = NOW.getMonth(),
                TODAY_D = NOW.getDate();

          const TICKETS = [{
        id: 'dom-dew',
        name: 'Domestik — Dewasa',
        desc: 'WNI, 18 tahun ke atas',
        price: 85000
    },
    {
        id: 'dom-pel',
        name: 'Domestik — Anak',
        desc: 'WNI di bawah 12 tahun',
        price: 60000
    },
    {
        id: 'kitas-dew',
        name: 'KITAS — Dewasa',
        desc: 'Pemegang KITAS, 18 tahun ke atas',
        price: 85000
    },
    {
        id: 'int-dew',
        name: 'Mancanegara — Dewasa',
        desc: 'WNA, 18 tahun ke atas',
        price: 120000
    },
    {
        id: 'int-pel',
        name: 'Mancanegara — Anak',
        desc: 'WNA di bawah 12 tahun',
        price: 85000
    },
];

            /* ── PROMO ── */
            let activePromo = null;
            let klaimHompimplay = true;

            async function applyPromo() {
                const code = document.getElementById('promo-code').value.trim().toUpperCase();
                const msg = document.getElementById('promo-msg');

                if (!code) {
                    activePromo = null;
                    msg.style.color = 'var(--gray-text)';
                    msg.textContent = '';
                    updateSum();
                    return;
                }

                if (!selDate) {
                    activePromo = null;
                    msg.style.color = '#e05252';
                    msg.textContent = '❌ Silakan pilih tanggal kunjungan terlebih dahulu';
                    updateSum();
                    return;
                }

                const sessEl = document.getElementById('sum-sess');
                const sessWaktu = (sessEl && sessEl.textContent !== '—') ? sessEl.textContent.trim() : null;

                try {
                    const res = await fetch('/booking/validate-promo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ code, booking_date: selDate, session_time: sessWaktu })
                    });

                    const data = await res.json();

                    if (!res.ok || !data.valid) {
                        activePromo = null;
                        msg.style.color = '#e05252';
                        msg.textContent = '❌ ' + (data.message || 'Kode promo tidak valid');
                        updateSum();
                        return;
                    }

                    // Promo valid
                    const promo = data.promo;
                    activePromo = {
                        code: promo.code,
                        name: promo.name,
                        type: promo.type,
                        description: promo.description,
                        discount_type: promo.discount_type,
                        discount_value: promo.discount_value,
                        discount_percent: promo.discount_percent,
                        discount_flat: promo.discount_flat,
                        min_purchase: promo.min_purchase,
                        max_discount: promo.max_discount,
                        emoji: '🎉',
                        label: promo.name
                    };

                    msg.style.color = '#2d9f6a';
                    const discText = promo.discount_type === 'percent'
                        ? `${promo.discount_value}% off`
                        : `Rp ${n(promo.discount_value)}`;
                    msg.textContent = `✅ Kode berhasil — ${promo.name} (${discText})`;

                    updateSum();
                } catch (err) {
                    console.error('Promo validation error:', err);
                    activePromo = null;
                    msg.style.color = '#e05252';
                    msg.textContent = '❌ Terjadi kesalahan';
                    updateSum();
                }
            }

            function selectPromoCode(code) {
                const input = document.getElementById('promo-code');
                if (input) {
                    input.value = code;
                    applyPromo();
                }
            }

            let calM = TODAY_M,
                calY = TODAY_Y;
            let selDate = null,
                selSess = null;
            let currentSessions = [];
            let selPayMethod = null;

async function checkOnlineStatus() {
    try {
        const res = await fetch(`/booking/online-status?tanggal=${selDate}`);
        const data = await res.json();
        const badge = document.getElementById('online-slot-badge');
        const optOnline = document.getElementById('opt-online');
        const reasonEl = document.getElementById('online-disabled-reason');

        if (data.available) {
            if (optOnline) {
                optOnline.classList.remove('disabled-sess');
            }
            if (badge) {
                badge.textContent = 'Sisa ' + data.sisa;
                badge.style.display = 'inline-block';
            }
            if (reasonEl) {
                reasonEl.style.display = 'none';
                reasonEl.textContent = '';
            }
            if (!selPayMethod) {
                selectPayMethod('walkin');
            }
        } else {
            if (optOnline) {
                optOnline.classList.add('disabled-sess');
            }
            if (badge) {
                badge.style.display = 'none';
            }
            if (reasonEl && data.reason) {
                reasonEl.textContent = '⚠ ' + data.reason;
                reasonEl.style.display = 'block';
            }
            selectPayMethod('walkin');
        }
    } catch(e) { console.log('Online status check failed', e); }
}

function selectPayMethod(method) {
    if (method === 'online') {
        const optOnline = document.getElementById('opt-online');
        if (optOnline && optOnline.classList.contains('disabled-sess')) {
            return;
        }
    }
    selPayMethod = method;
    highlightPayMethod(method);
    const btnPay = document.getElementById('btn-pay');
    if (btnPay) {
        btnPay.disabled = false;
        btnPay.querySelector('.btn-label').textContent = method === 'online'
            ? 'Lanjut ke UdjoShop →'
            : 'Pesan Via WhatsApp';
    }

    // Tampilkan/sembunyikan list channel pembayaran online
    const channelsEl = document.getElementById('online-payment-channels');
    if (channelsEl) {
        channelsEl.style.display = method === 'online' ? 'block' : 'none';
    }

    updateSum();
}

function highlightPayMethod(method) {
    const walkin = document.getElementById('opt-walkin');
    const online = document.getElementById('opt-online');
    if (walkin) {
        if (method === 'walkin') {
            walkin.classList.add('selected');
        } else {
            walkin.classList.remove('selected');
        }
    }
    if (online) {
        if (method === 'online') {
            online.classList.add('selected');
        } else {
            online.classList.remove('selected');
        }
    }
}
            const qty = {};
            TICKETS.forEach(t => qty[t.id] = 0);

            /* ── CALENDAR ── */
            function renderCal() {
                document.getElementById('cal-title').textContent = `${MONTHS[calM]} ${calY}`;
                const g = document.getElementById('cal-grid');
                g.innerHTML = '';
                DAYS.forEach(d => {
                    const e = document.createElement('div');
                    e.className = 'cdn';
                    e.textContent = d;
                    g.appendChild(e);
                });
                const firstDay = new Date(calY, calM, 1).getDay();
                const totalDays = new Date(calY, calM + 1, 0).getDate();
                for (let i = 0; i < firstDay; i++) {
                    const e = document.createElement('div');
                    e.className = 'cd empty';
                    g.appendChild(e);
                }
                for (let d = 1; d <= totalDays; d++) {
                    const isPast = (calY < TODAY_Y) || (calY === TODAY_Y && calM < TODAY_M) || (calY === TODAY_Y && calM ===
                        TODAY_M && d < TODAY_D);
                    const isToday = calY === TODAY_Y && calM === TODAY_M && d === TODAY_D;
                    const ds = fmt(calY, calM, d);
                    const cls = 'cd' + (isPast ? ' past' : ' has') + (isToday ? ' today' : '') + (ds === selDate ? ' sel' : '');
                    const e = document.createElement('div');
                    e.className = cls;
                    e.textContent = d;
                    e.setAttribute('role', 'button');
                    if (!isPast) e.onclick = () => pickDate(ds, d);
                    g.appendChild(e);
                }
            }

            function fmt(y, m, d) {
                return `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            }

            function chMonth(dir) {
                let nextM = calM + dir;
                let nextY = calY;

                if (nextM < 0) {
                    nextM = 11;
                    nextY--;
                }
                if (nextM > 11) {
                    nextM = 0;
                    nextY++;
                }

                // Cegah ke bulan sebelumnya (sudah terlewat)
                if (nextY < TODAY_Y || (nextY === TODAY_Y && nextM < TODAY_M)) {
                    return;
                }

                // Cegah ke bulan berikutnya sesuai request manager (hanya bisa bulan ini)
                if (nextY > TODAY_Y || (nextY === TODAY_Y && nextM > TODAY_M)) {
                    showToast('⚠ Booking hanya untuk bulan ini', 'err');
                    return;
                }

                calM = nextM;
                calY = nextY;
                renderCal();
            }

            /* ── SESSIONS ── */


           // 1. Update fungsi pickDate agar mengambil data SESI LENGKAP dari server
/* ── SESSIONS (DINAMIS) ── */
async function pickDate(ds, dayNum) {
    selDate = ds;
    selSess = null;
    currentSessions = [];
    TICKETS.forEach(t => qty[t.id] = 0);
    renderCal();
    renderTkts();
    updateSum();

    document.getElementById('sum-date').textContent = `${dayNum} ${MONTHS[calM]} ${calY}`;
    document.getElementById('sum-sess').textContent = '—';
    document.getElementById('sess-box').innerHTML = `<div class="es"><p>Memuat jadwal...</p></div>`;

    if (document.getElementById('promo-code').value.trim()) {
        applyPromo();
    }

    try {
        // ✅ PERBAIKAN: Fetch SEMUA sesi sekaligus untuk tanggal ini
        const res = await fetch(`/booking/seats?tanggal=${ds}`);
        if (!res.ok) throw new Error("Server Error");
        currentSessions = await res.json();
        renderSess();
    } catch (e) {
        showToast('❌ Kesalahan jaringan, coba lagi', 'err');
        document.getElementById('sess-box').innerHTML = '<div class="es"><p>Gagal memuat jadwal.</p></div>';
    }
}

// 2. Update fungsi renderSess agar membaca kunci 'remaining' dan 'capacity'
function renderSess() {
    const b = document.getElementById('sess-box');
    if (!selDate || !currentSessions || currentSessions.length === 0) {
        b.innerHTML = `<div class="es"><p>Pilih tanggal terlebih dahulu</p></div>`;
        return;
    }

    const totalSelected = TICKETS.reduce((sum, t) => sum + qty[t.id], 0);

    b.innerHTML = '<div class="sess-grid">' + currentSessions.map(s => {
        // Gunakan s.remaining dan s.capacity dari Controller
        const liveRemaining = s.id === selSess ? Math.max(0, s.remaining - totalSelected) : s.remaining;
        const isFull = liveRemaining <= 0;
        const isSelected = selSess === s.id;

        // Progress bar berdasarkan kapasitas dinamis (bukan statis 20 lagi)
        const pct = (liveRemaining / s.capacity) * 100;
        const isLow = liveRemaining <= 5 && liveRemaining > 0;
        const textColor = isFull ? '#e05252' : isLow ? '#e08a2d' : 'var(--success)';
        const seatLabel = isFull ? 'Penuh' : `${liveRemaining} kursi tersisa`;

        return `
            <div class="sess-item${isSelected ? ' sel' : ''}${isFull ? ' disabled-sess' : ''}"
                 onclick="${isFull ? '' : `pickSess('${s.id}', '${s.time}')`}"
                 style="${isFull ? 'opacity:.45;cursor:not-allowed;pointer-events:none;' : 'cursor:pointer;'}">
              <div style="flex:1">
                <div class="sess-time">${s.time}</div>
                <div class="sess-label" style="margin-top:4px">${s.label}</div>
                <div style="margin-top:10px;height:5px;background:var(--gray-mid);border-radius:99px;overflow:hidden;max-width:280px">
                  <div style="height:100%;width:${pct}%;background:#1a1445;border-radius:99px;transition:width .5s ease"></div>
                </div>
                <div style="margin-top:5px;font-size:10px;font-weight:700;color:${textColor};letter-spacing:.12em">${seatLabel}</div>
              </div>
              <div class="sess-check" style="display:${isSelected ? 'flex' : 'none'}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                  <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>`;
    }).join('') + '</div>';
}

// 3. Update fungsi pickSess agar parameternya sesuai
function pickSess(id, timeText) {
    selSess = id;
    // Reset qty tiket saat pindah sesi agar sisa kursi akurat
    TICKETS.forEach(tk => qty[tk.id] = 0);
    renderSess();
    renderTkts();
    document.getElementById('sum-sess').textContent = timeText;
    updateSum();

    if (document.getElementById('promo-code').value.trim()) {
        applyPromo();
    }
}

            /* ── TICKETS ── */
            function renderTkts() {
                const b = document.getElementById('tkt-box');
                if (!selSess) {
                    b.innerHTML =
                        `<div class="es"><svg width="38" height="38" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg><p>Pilih sesi terlebih dahulu</p></div>`;
                    return;
                }

                const sessionObj = currentSessions.find(s => s.id === selSess);
                const currentRemaining = sessionObj ? sessionObj.remaining : 0;
                const totalSelected = TICKETS.reduce((sum, t) => sum + qty[t.id], 0);
                const isMaxReached = totalSelected >= currentRemaining;

                b.innerHTML = '<div class="tkt-list">' + TICKETS.map(t => `
        <div class="tkt-row${qty[t.id] > 0 ? ' has' : ''}">
          <div class="tkt-info">
            <div class="tkt-name">${t.name}</div>
         <div class="tkt-desc">${t.desc}</div>
          </div>
          <div class="tkt-price"><small>per orang</small>Rp ${n(t.price)}</div>
          <div class="qty-ctrl">
            <button class="qty-btn" onclick="chQty('${t.id}',-1)"${qty[t.id] === 0 ? ' disabled' : ''}>−</button>
            <span class="qty-num">${qty[t.id]}</span>
            <button class="qty-btn" onclick="chQty('${t.id}',1)"${isMaxReached ? ' disabled' : ''}>+</button>
          </div>
        </div>`).join('') + '</div>';
            }

            function chQty(id, d) {
                const sessionObj = currentSessions.find(s => s.id === selSess);
                const currentRemaining = sessionObj ? sessionObj.remaining : 0;
                const totalSelected = TICKETS.reduce((sum, t) => sum + qty[t.id], 0);

                if (d > 0 && totalSelected >= currentRemaining) {
                    return; // Prevent incrementing if max capacity reached
                }

                qty[id] = Math.max(0, qty[id] + d);
                renderTkts();
                updateSum();
            }

            /* ── SUMMARY ── */
            function updateSum() {
                renderSess();
                let sub = 0,
                    totalQ = 0,
                    rows = '';
                TICKETS.forEach(t => {
                    if (qty[t.id] > 0) {
                        const s = qty[t.id] * t.price;
                        sub += s;
                        totalQ += qty[t.id];
                        rows +=
                            `<div class="sum-row"><span>${t.name} ×${qty[t.id]}</span><span class="val">Rp ${n(s)}</span></div>`;
                    }
                });
                let disc = 0;
              if (activePromo && sub > 0) {
    const domesticSub = (qty['dom-dew'] * 85000) + (qty['dom-pel'] * 60000);
    const domesticQ   = qty['dom-dew'] + qty['dom-pel'];

    if (domesticSub > 0) {
        if (activePromo.discount_type === 'percent') {
            disc = Math.round(domesticSub * activePromo.discount_value / 100);
        } else if (activePromo.discount_type === 'fixed') {
            disc = Math.round(activePromo.discount_value * domesticQ);
        }
        if (activePromo.max_discount > 0) disc = Math.min(disc, activePromo.max_discount);
        if (activePromo.min_purchase > 0 && sub < activePromo.min_purchase) {
            disc = 0;
            rows += `<div class="sum-row" style="color:#e08a2d;font-size:10px"><span>⚠ Min pembelian Rp ${n(activePromo.min_purchase)}</span></div>`;
        } else if (disc > 0) {
            rows += `<div class="sum-row" style="color:var(--success)"><span>${activePromo.name} <span style="font-size:9px;opacity:.6">(tiket domestik)</span></span><span class="val" style="color:var(--success)">− Rp ${n(disc)}</span></div>`;
        }
    } else {
        rows += `<div class="sum-row" style="color:#e08a2d;font-size:10px"><span>⚠ Promo hanya berlaku untuk tiket domestik</span></div>`;
    }
}
                const grandTotal = sub - disc;
                document.getElementById('sum-rows').innerHTML = rows;
                document.getElementById('sum-qty').textContent = totalQ > 0 ? `${totalQ} tiket` : '0 tiket';
                document.getElementById('sum-price').innerHTML = (totalQ > 0 ? `Rp ${n(grandTotal)}` : 'Rp 0') +
                    ' <small>/ kunjungan</small>';
                const tot = document.getElementById('sum-total');
                if (totalQ > 0) {
                    tot.style.display = 'flex';
                    document.getElementById('sum-tv').textContent = `Rp ${n(grandTotal)}`;
                } else {
                    tot.style.display = 'none';
                }
                updSteps(totalQ);
            const btnPay = document.getElementById('btn-pay');
            const selector = document.getElementById('payment-method-selector');
            if (selDate && selSess && totalQ > 0) {
                if (selector) selector.style.display = 'block';
                checkOnlineStatus();
            } else {
                if (selector) selector.style.display = 'none';
            }
            if (btnPay) btnPay.disabled = !(selDate && selSess && totalQ > 0 && selPayMethod);
                updateVoucherBadges();
            }

            function updateVoucherBadges() {
                const currentCode = activePromo ? activePromo.code.toUpperCase() : '';
                document.querySelectorAll('.voucher-item').forEach(item => {
                    const itemCode = item.getAttribute('data-code');
                    const badge = item.querySelector('.claim-badge');
                    if (badge) {
                        if (currentCode && itemCode === currentCode) {
                            badge.textContent = 'Terpasang';
                            badge.style.color = '#fff';
                            badge.style.background = '#2d9f6a';
                            badge.style.borderColor = '#2d9f6a';
                            item.style.background = 'rgba(45, 159, 106, 0.05)';
                            item.style.borderColor = '#2d9f6a';
                        } else {
                            badge.textContent = 'Klaim';
                            badge.style.color = 'var(--gold)';
                            badge.style.background = '#fff';
                            badge.style.borderColor = 'rgba(196,164,124,0.25)';
                            item.style.background = 'rgba(196,164,124,0.06)';
                            item.style.borderColor = 'rgba(196,164,124,0.4)';
                        }
                    }
                });
            }

            /* ── STEPS ── */
            function updSteps(q) {
                const s1 = document.getElementById('stp1'),
                    s2 = document.getElementById('stp2'),
                    s3 = document.getElementById('stp3'),
                    s4 = document.getElementById('stp4'),
                    l12 = document.getElementById('l12'),
                    l23 = document.getElementById('l23'),
                    l34 = document.getElementById('l34');
                s1.className = 'step active';
                s2.className = selDate ? 'step done' : 'step';
                l12.className = selDate ? 'sline done' : 'sline';
                if (q > 0) {
                    s3.className = 'step done';
                    l23.className = 'sline done';
                    s4.className = selPayMethod ? 'step done' : 'step active';
                    l34.className = selPayMethod ? 'sline done' : 'sline';
                } else {
                    s3.className = selSess ? 'step active' : 'step';
                    l23.className = 'sline';
                    s4.className = 'step';
                    l34.className = 'sline';
                }
            }

            /* ── VALIDATION ── */
            function validateForm() {
                const name = document.getElementById('f-name').value.trim();
                const phone = document.getElementById('f-phone').value.trim();
                const email = document.getElementById('f-email').value.trim();
                const setErr = (id, err) => document.getElementById(id).classList.toggle('has-err', err);
                setErr('field-name', !name);
                setErr('field-phone', !phone);
                setErr('field-email', !email || !email.includes('@') || !email.includes('.'));
                if (!name || !phone || !email || !email.includes('@') || !email.includes('.')) {
                    const f = document.querySelector('.field.has-err input');
                    if (f) {
                        f.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        f.focus();
                    }
                    return false;
                }
                return true;
            }

            /* ── HELPER: WA Deep Link per platform ── */
function buildWaDeepLink(waUrl) {
    const ua      = navigator.userAgent.toLowerCase();
    const isMobile = /android|iphone|ipad|ipod/.test(ua);

    const match = waUrl.match(/wa\.me\/(\d+)\?text=(.+)/);
    if (!match) return waUrl;

    const phone = match[1];
    const text  = match[2];

    if (isMobile) {
        // Scheme universal — Android & iOS
        // Kalau user punya 2 WA, Android akan tampilkan pilihan
        return `whatsapp://send?phone=${phone}&text=${text}`;
    }

    return waUrl; // Desktop: wa.me biasa
}


          async function handlePay() {
    if (!validateForm()) {
        showToast('⚠ Lengkapi data pengunjung terlebih dahulu', 'err');
        return;
    }



    const btn = document.getElementById('btn-pay');
    btn.disabled = true;
    btn.classList.add('loading');

    const name  = document.getElementById('f-name').value.trim();
    const code  = document.getElementById('f-phone-code').value;
    const phone = document.getElementById('f-phone').value.trim();
    const email = document.getElementById('f-email').value.trim();

    const SESS_START = { pagi:'10.00 WIB', siang:'13.00 WIB', sore:'15.30 WIB', reg:'15.30 WIB' };
    const sessWaktu  = SESS_START[selSess] || selSess;
    const sub  = TICKETS.reduce((s, t) => s + qty[t.id] * t.price, 0);
    let disc = 0;

    // Hitung discount dari promo yang aktif
    if (activePromo && sub > 0) {
    const domesticSub = (qty['dom-dew'] * 85000) + (qty['dom-pel'] * 60000);
    const domesticQ   = qty['dom-dew'] + qty['dom-pel'];

    if (domesticSub > 0) {
        if (activePromo.discount_type === 'percent') {
            disc = Math.round(domesticSub * activePromo.discount_value / 100);
        } else if (activePromo.discount_type === 'fixed') {
            disc = Math.round(activePromo.discount_value * domesticQ);
        }
        if (activePromo.max_discount > 0) disc = Math.min(disc, activePromo.max_discount);
        if (activePromo.min_purchase > 0 && sub < activePromo.min_purchase) disc = 0;
    }
}
    const payload = {
        nama: name, no_hp: code + phone, email,
        kota: document.getElementById('f-city').value.trim() || '',
        negara_asal: document.getElementById('f-country').value || '',
        tanggal_kunjungan: selDate, session_id: selSess, session_time: sessWaktu,
        jumlah_tiket_dewasa: qty['dom-dew'], jumlah_tiket_anak: qty['dom-pel'],
        jumlah_tiket_kitas_dewasa: qty['kitas-dew'], 
        jumlah_tiket_manca_dewasa: qty['int-dew'], jumlah_tiket_manca_anak: qty['int-pel'],
        
        promo_code: activePromo?.code ?? null,
        discount_amount: disc, subtotal: sub, total_harga: sub - disc,
        promo_info: activePromo ?? null,
        klaim_hompimplay: klaimHompimplay,
       'payment_method': selPayMethod || 'walkin',
        company_name_verification: document.getElementById('f-honeypot').value || ''
    };

    try {
        const res  = await fetch('{{ route('booking.ticket.submit') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();

        // ── Tangani 422 Validation Error dari submit() ──
        if (res.status === 422) {
            if (data.errors) {
                const messages = Object.values(data.errors).flat();
                const firstMsg = messages[0] || 'Data tidak valid.';
                showToast('⚠ ' + firstMsg, 'err');
                // Tampilkan semua error ke console untuk debugging
                console.error('[submit 422] Validation errors:', data.errors);
            } else if (data.message) {
                showToast('⚠ ' + data.message, 'err');
            } else {
                showToast('⚠ Terjadi kesalahan validasi, coba lagi.', 'err');
            }
            return;
        }

        if (!data.success) {
            showToast('❌ ' + (data.message || 'Gagal menyimpan booking.'), 'err');
            return;
        }

       if (data.success && selPayMethod === 'online') {
    try {
        // Redirect ke Majoo
        const majooRes = await fetch('/booking/redirect-majoo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ booking_code: data.booking_code })
        });
        const majooData = await majooRes.json();
        if (majooRes.ok && majooData.available) {
            showBookingSuccess(majooData.majoo_url, true, data.booking_code);
        } else {
            showToast('❌ ' + (majooData.reason || 'Kuota habis atau pemesanan online tidak tersedia.'), 'err');
        }
    } catch (err) {
        showToast('❌ Gagal terhubung ke server pembayaran, silakan hubungi admin.', 'err');
    }
    return;
}
        // Booking berhasil — tampilkan pop-up dulu, WA dibuka dari dalam popup
        document.getElementById('stp4').className = 'step active';
        document.getElementById('l34').className  = 'sline done';

        const deepLink = buildWaDeepLink(data.wa_url);
        showBookingSuccess(deepLink);

        // Ganti tombol jadi link WA (backup kalau modal ditutup)
        document.getElementById('btn-pay').outerHTML = `
            <a id="btn-wa" href="${deepLink}" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:10px;
                      width:100%;padding:15px;background:#25D366;color:#fff;
                      border-radius:10px;text-decoration:none;
                      font-family:'Inter',sans-serif;font-size:11px;font-weight:900;
                      letter-spacing:.22em;text-transform:uppercase;
                      box-shadow:0 8px 28px rgba(37,211,102,.3);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 1.99.579 3.842 1.573 5.398L2 22l4.734-1.546A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.946 7.946 0 01-4.35-1.297l-.31-.186-3.23 1.055 1.05-3.142-.202-.323A7.948 7.948 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/>
                </svg>
                Buka WhatsApp
            </a>`;

        const seatsRes = await fetch(`/booking/seats?tanggal=${selDate}`);
        currentSessions = await seatsRes.json();
        renderSess();

    } catch (e) {
        showToast('❌ Terjadi kesalahan jaringan, coba lagi', 'err');
    } finally {
        // Kalau btn-pay masih ada (error path), kembalikan state-nya
        const btnEl = document.getElementById('btn-pay');
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.classList.remove('loading');
        }
    }
}        /* ── HELPERS ── */
            function n(v) {
                return v.toLocaleString('id-ID');
            }
            let toastTimer;

          function copyBookingCode(code) {
              navigator.clipboard.writeText(code).then(() => {
                  showToast('📋 Kode Booking berhasil disalin!', 'success');
                  
                  // Update Modal Steps if they exist
                  const step1El = document.getElementById('step-1-el');
                  const step1Badge = document.getElementById('step-1-badge');
                  const step2El = document.getElementById('step-2-el');
                  const step2Badge = document.getElementById('step-2-badge');
                  const step3El = document.getElementById('step-3-el');
                  const btnRedirect = document.getElementById('btn-redirect-udjoshop');
                  const copyWarning = document.getElementById('copy-warning-text');
                  const btnCopyText = document.getElementById('copy-btn-text');
                  const btnCopy = document.getElementById('btn-copy-code');
                  
                  if (step1El && step1Badge) {
                      step1El.style.background = 'rgba(45,159,106,.05)';
                      step1El.style.borderColor = 'rgba(45,159,106,.2)';
                      step1Badge.style.background = '#2d9f6a';
                      step1Badge.innerHTML = '✓';
                  }
                  
                  if (step2El && step2Badge) {
                      step2El.style.opacity = '1';
                      step2El.style.background = 'rgba(196,164,124,.1)';
                      step2El.style.border = '1px solid rgba(196,164,124,.2)';
                      step2Badge.style.background = '#1a1445';
                  }

                  if (step3El) {
                      step3El.style.opacity = '1';
                  }
                  
                  if (btnCopy) {
                      btnCopy.style.background = '#2d9f6a';
                      if (btnCopyText) btnCopyText.textContent = 'Tersalin';
                  }
                  
                  if (btnRedirect) {
                      btnRedirect.disabled = false;
                      btnRedirect.style.background = '#1a1445';
                      btnRedirect.style.color = '#fff';
                      btnRedirect.style.cursor = 'pointer';
                      btnRedirect.style.boxShadow = '0 8px 24px rgba(26,20,69,.2)';
                  }
                  
                  if (copyWarning) {
                      copyWarning.style.display = 'none';
                  }
              }).catch(err => {
                  showToast('❌ Gagal menyalin, silakan salin manual', 'err');
              });
          }

          function handleOnlinePaymentRedirect(url, code) {
              navigator.clipboard.writeText(code).then(() => {
                  showToast('📋 Kode Booking disalin!', 'success');
                  setTimeout(() => {
                      window.open(url, '_blank');
                      document.getElementById('notif-sukses')?.remove();
                  }, 400);
              }).catch(() => {
                  window.open(url, '_blank');
                  document.getElementById('notif-sukses')?.remove();
              });
          }

          function showBookingSuccess(waUrl, isOnline = false, bookingCode = '') {
    const existing = document.getElementById('notif-sukses');
    if (existing) existing.remove();

    const notif = document.createElement('div');
    notif.id = 'notif-sukses';
    notif.style.cssText = `
        position:fixed;top:0;left:0;right:0;bottom:0;
        background:rgba(26,20,69,.55);backdrop-filter:blur(4px);
        display:flex;align-items:center;justify-content:center;
        z-index:99999;animation:fadeIn .25s ease;padding:1rem;
    `;

    const actionBtn = isOnline
        ? `<div style="font-size:13.5px;color:rgba(26,20,69,.7);line-height:1.6;margin-bottom:1.5rem;text-align:left;">
               <p style="margin-bottom:12px;text-align:center;font-size:12px;color:rgba(26,20,69,.6);">Ikuti 3 langkah berikut untuk menyelesaikan pembayaran:</p>
               
               <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:16px;">
                   <!-- Step 1 -->
                   <div id="step-1-el" style="display:flex;align-items:flex-start;gap:10px;padding:10px;border-radius:8px;background:rgba(196,164,124,.1);border:1px solid rgba(196,164,124,.2);transition:all 0.3s ease;">
                       <div id="step-1-badge" style="width:20px;height:20px;border-radius:50%;background:#1a1445;color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:bold;flex-shrink:0;">1</div>
                       <div>
                           <strong style="color:#1a1445;display:block;font-size:12px;line-height:1.2;margin-bottom:2px;">Salin Kode Booking</strong>
                           <span style="font-size:11px;color:rgba(26,20,69,.75);display:block;line-height:1.3;">Salin kode booking unik Anda di bawah.</span>
                       </div>
                   </div>
                   
                   <!-- Step 2 -->
                   <div id="step-2-el" style="display:flex;align-items:flex-start;gap:10px;padding:10px;border-radius:8px;background:rgba(26,20,69,.02);opacity:0.5;transition:all 0.3s ease;">
                       <div id="step-2-badge" style="width:20px;height:20px;border-radius:50%;background:#ccc;color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:bold;flex-shrink:0;">2</div>
                       <div>
                           <strong style="color:#1a1445;display:block;font-size:12px;line-height:1.2;margin-bottom:2px;">Lanjut ke UdjoShop</strong>
                           <span style="font-size:11px;color:rgba(26,20,69,.75);display:block;line-height:1.3;">Tombol lanjut akan aktif setelah Anda menyalin kode.</span>
                       </div>
                   </div>

                   <!-- Step 3 -->
                   <div id="step-3-el" style="display:flex;align-items:flex-start;gap:10px;padding:10px;border-radius:8px;background:rgba(26,20,69,.02);opacity:0.5;transition:all 0.3s ease;">
                       <div id="step-3-badge" style="width:20px;height:20px;border-radius:50%;background:#ccc;color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:bold;flex-shrink:0;">3</div>
                       <div>
                           <strong style="color:#1a1445;display:block;font-size:12px;line-height:1.2;margin-bottom:2px;">Paste Kode saat Checkout</strong>
                           <span style="font-size:11px;color:rgba(26,20,69,.75);display:block;line-height:1.3;">Tempel (*paste*) kode di kolom <strong>Catatan / Keterangan Pembelian</strong>.</span>
                       </div>
                   </div>
               </div>

               <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:rgba(26,20,69,.04);border:1.5px dashed rgba(26,20,69,.15);border-radius:10px;margin-bottom:16px;">
                   <span id="booking-code-val" style="font-family:'Courier New',Courier,monospace;font-size:16px;font-weight:800;color:#1a1445;">${bookingCode}</span>
                   <button id="btn-copy-code" onclick="copyBookingCode('${bookingCode}')" style="background:#c4a47c;border:none;border-radius:6px;cursor:pointer;color:#fff;display:flex;align-items:center;gap:6px;font-weight:700;font-size:12px;padding:6px 12px;outline:none;transition:all 0.2s;">
                       <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                           <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                       </svg>
                       <span id="copy-btn-text">Salin</span>
                   </button>
               </div>
           </div>
           <button id="btn-redirect-udjoshop" onclick="handleOnlinePaymentRedirect('${waUrl}', '${bookingCode}')" disabled
               style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px;background:#e5e7eb;color:#9ca3af;
                      border:none;border-radius:12px;font-size:12px;font-weight:800;
                      letter-spacing:.12em;text-transform:uppercase;cursor:not-allowed;
                      font-family:'Inter',sans-serif;box-shadow:none;transition:all 0.3s ease;">
               Lanjut ke UdjoShop
           </button>
           <p id="copy-warning-text" style="font-size:11px;color:#e05252;margin-top:10px;text-align:center;font-weight:600;margin-bottom:0;">
               ⚠ Harap salin kode booking terlebih dahulu sebelum lanjut
           </p>`
        : `<div style="font-size:13px;color:rgba(26,20,69,.55);line-height:1.6;margin-bottom:1.5rem">
               Data kamu sudah kami catat.<br>Tap tombol di bawah untuk konfirmasi via WhatsApp.
           </div>
           <a href="${waUrl}" target="_blank"
              onclick="document.getElementById('notif-sukses').remove()"
              style="display:flex;align-items:center;justify-content:center;gap:10px;
                     width:100%;padding:14px;background:#25D366;color:#fff;
                     border-radius:12px;text-decoration:none;margin-bottom:10px;
                     font-size:12px;font-weight:800;letter-spacing:.15em;
                     text-transform:uppercase;box-shadow:0 8px 24px rgba(37,211,102,.3);
                     font-family:'Inter',sans-serif;box-sizing:border-box">
               <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                   <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                   <path d="M12 2C6.477 2 2 6.477 2 12c0 1.99.579 3.842 1.573 5.398L2 22l4.734-1.546A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18a7.946 7.946 0 01-4.35-1.297l-.31-.186-3.23 1.055 1.05-3.142-.202-.323A7.948 7.948 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8z"/>
               </svg>
               Konfirmasi via WhatsApp
           </a>
           <button onclick="document.getElementById('notif-sukses').remove()"
               style="width:100%;padding:11px;background:transparent;color:#9ca3af;
                      border:1.5px solid #e5e7eb;border-radius:12px;
                      font-size:11px;font-weight:700;letter-spacing:.08em;
                      text-transform:uppercase;cursor:pointer;font-family:'Inter',sans-serif">
               Nanti Saja
           </button>`;

    notif.innerHTML = `
        <div style="background:#fff;border-radius:20px;padding:2rem 2.2rem;
                    max-width:390px;width:100%;text-align:center;
                    box-shadow:0 24px 60px rgba(26,20,69,.2);
                    animation:slideUp .3s cubic-bezier(.16,1,.3,1)">
            <div style="width:64px;height:64px;background:${isOnline ? 'rgba(26,20,69,.08)' : 'rgba(45,159,106,.1)'};
                        border-radius:50%;display:flex;align-items:center;
                        justify-content:center;margin:0 auto 1rem">
                <svg width="32" height="32" fill="none" stroke="${isOnline ? '#1a1445' : '#2d9f6a'}" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div style="font-size:18px;font-weight:800;color:#1a1445;margin-bottom:8px">
                Booking Tersimpan!
            </div>
            ${actionBtn}
        </div>`;

    document.body.appendChild(notif);
    notif.addEventListener('click', e => { if (e.target === notif) notif.remove(); });
}
          function showToast(msg, type = '') {

    // Toast biasa untuk error / warning
    const t = document.getElementById('toast');
    document.getElementById('toast-msg').textContent = msg;
    t.className = `toast ${type} show`;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 3800);
}
            ['f-name', 'f-phone', 'f-email'].forEach(id => {
                document.getElementById(id)?.addEventListener('input', () => {
                    const m = {
                        'f-name': 'field-name',
                        'f-phone': 'field-phone',
                        'f-email': 'field-email'
                    };
                    document.getElementById(m[id])?.classList.remove('has-err');
                });
            });

            /* ── INIT ── */
            document.addEventListener('DOMContentLoaded', () => {
                renderCal();
                updateSum();
                const obs = new IntersectionObserver(entries => {
                    entries.forEach(e => {
                        if (e.isIntersecting) e.target.classList.add('active');
                    });
                }, {
                    threshold: .1
                });
                document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
            });
        </script>
    @endpush
@endpush

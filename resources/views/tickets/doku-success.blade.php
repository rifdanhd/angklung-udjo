@extends('layouts.app')

@section('title', 'Pembayaran Berhasil | Saung Angklung Udjo')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<style>
    :root {
        --gold: #c4a47c;
        --gold-lt: rgba(196, 164, 124, .14);
        --navy: #1a1445;
        --bg: #F7F7F2;
        --success: #16a34a;
        --success-lt: rgba(22, 163, 74, .1);
        --pending: #d97706;
        --pending-lt: rgba(217, 119, 6, .1);
        --radius-md: 16px;
        --radius-lg: 24px;
    }

    body { background: var(--bg); font-family: 'Inter', sans-serif; }

    .doku-page {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
    }

    .doku-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 60px rgba(26,20,69,.1);
        max-width: 560px;
        width: 100%;
        overflow: hidden;
    }

    .doku-card-header {
        background: linear-gradient(135deg, var(--navy) 0%, #2a1c7a 100%);
        padding: 2.5rem 2rem 2rem;
        text-align: center;
        position: relative;
    }

    .doku-card-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0; right: 0;
        height: 40px;
        background: #fff;
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    .status-icon {
        width: 72px; height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
    }

    .status-icon.success { background: var(--success-lt); }
    .status-icon.pending { background: var(--pending-lt); }

    .doku-card-header h1 {
        font-family: 'Libre Baskerville', serif;
        color: #fff;
        font-size: 1.5rem;
        margin-bottom: .5rem;
    }

    .doku-card-header p {
        color: rgba(255,255,255,.7);
        font-size: .9rem;
    }

    .doku-card-body {
        padding: 2.5rem 2rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: .75rem 0;
        border-bottom: 1px solid rgba(26,20,69,.07);
        gap: 1rem;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: .82rem;
        color: rgba(26,20,69,.5);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .04em;
        flex-shrink: 0;
    }

    .info-value {
        font-size: .95rem;
        color: var(--navy);
        font-weight: 600;
        text-align: right;
    }

    .booking-code-badge {
        display: inline-block;
        background: var(--gold-lt);
        color: var(--gold);
        border: 1px solid rgba(196,164,124,.3);
        border-radius: 8px;
        padding: .25rem .75rem;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .06em;
        font-family: 'Courier New', monospace;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .3rem .75rem;
        border-radius: 20px;
        font-size: .82rem;
        font-weight: 600;
    }

    .status-badge.completed { background: var(--success-lt); color: var(--success); }
    .status-badge.pending   { background: var(--pending-lt); color: var(--pending); }
    .status-badge.cancelled { background: rgba(220,38,38,.1); color: #dc2626; }

    .total-highlight {
        background: linear-gradient(135deg, rgba(196,164,124,.1) 0%, rgba(196,164,124,.05) 100%);
        border: 1px solid rgba(196,164,124,.3);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin: 1.25rem 0;
        text-align: center;
    }

    .total-highlight .label { font-size: .82rem; color: rgba(26,20,69,.5); font-weight: 500; }
    .total-highlight .amount {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--navy);
        margin-top: .25rem;
    }

    .pending-notice {
        background: rgba(217,119,6,.08);
        border: 1px solid rgba(217,119,6,.2);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin: 1.25rem 0;
        display: flex;
        gap: .75rem;
        align-items: flex-start;
    }

    .pending-notice .icon { font-size: 1.2rem; flex-shrink: 0; margin-top: .1rem; }
    .pending-notice p { font-size: .85rem; color: #92400e; margin: 0; line-height: 1.5; }

    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: 100%;
        padding: .9rem 1.5rem;
        background: linear-gradient(135deg, var(--navy) 0%, #2a1c7a 100%);
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        font-size: .95rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform .15s, box-shadow .15s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,20,69,.25);
        color: #fff;
    }

    .btn-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        width: 100%;
        padding: .85rem 1.5rem;
        background: transparent;
        color: var(--navy);
        border: 2px solid rgba(26,20,69,.15);
        border-radius: 10px;
        font-weight: 600;
        font-size: .9rem;
        text-decoration: none;
        margin-top: .75rem;
        transition: border-color .15s, background .15s;
    }

    .btn-secondary:hover {
        border-color: var(--gold);
        background: var(--gold-lt);
        color: var(--navy);
    }

    /* Countdown timer */
    #polling-status {
        font-size: .82rem;
        color: rgba(26,20,69,.5);
        text-align: center;
        margin-top: .5rem;
    }
</style>
@endpush

@section('content')
<div class="doku-page">
    <div class="doku-card">

        {{-- ── HEADER ── --}}
        <div class="doku-card-header">
            @if($booking->status === 'completed')
                <div class="status-icon success">✅</div>
                <h1>Pembayaran Berhasil!</h1>
                <p>Tiket Anda telah dikonfirmasi. Selamat menikmati pertunjukan.</p>
            @elseif($booking->status === 'cancelled')
                <div class="status-icon pending" style="background:rgba(220,38,38,.15)">❌</div>
                <h1>Pembayaran Dibatalkan</h1>
                <p>Transaksi ini telah dibatalkan atau kadaluarsa.</p>
            @else
                <div class="status-icon pending">⏳</div>
                <h1>Menunggu Pembayaran</h1>
                <p>Selesaikan pembayaran Anda sebelum batas waktu habis.</p>
            @endif
        </div>

        {{-- ── BODY ── --}}
        <div class="doku-card-body">

            {{-- Kode Booking --}}
            <div class="info-row">
                <span class="info-label">Kode Booking</span>
                <span class="booking-code-badge">{{ $booking->booking_code }}</span>
            </div>

            {{-- Nama --}}
            <div class="info-row">
                <span class="info-label">Atas Nama</span>
                <span class="info-value">{{ $booking->nama }}</span>
            </div>

            {{-- Tanggal Kunjungan --}}
            <div class="info-row">
                <span class="info-label">Tanggal Kunjungan</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('d F Y') }}
                </span>
            </div>

            {{-- Sesi --}}
            <div class="info-row">
                <span class="info-label">Sesi</span>
                <span class="info-value">{{ $booking->session_time }}</span>
            </div>

            {{-- Jumlah Tiket --}}
            <div class="info-row">
                <span class="info-label">Tiket</span>
                <span class="info-value">
                    @php
                        $parts = [];
                        if ($booking->jumlah_tiket_dewasa > 0)       $parts[] = $booking->jumlah_tiket_dewasa . ' Dewasa';
                        if ($booking->jumlah_tiket_anak > 0)         $parts[] = $booking->jumlah_tiket_anak . ' Anak';
                        if ($booking->jumlah_tiket_kitas_dewasa > 0) $parts[] = $booking->jumlah_tiket_kitas_dewasa . ' KITAS';
                        if ($booking->jumlah_tiket_manca_dewasa > 0) $parts[] = $booking->jumlah_tiket_manca_dewasa . ' Manca Dewasa';
                        if ($booking->jumlah_tiket_manca_anak > 0)   $parts[] = $booking->jumlah_tiket_manca_anak . ' Manca Anak';
                    @endphp
                    {{ implode(', ', $parts) }}
                </span>
            </div>

            {{-- Status --}}
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="status-badge {{ $booking->status }}" id="status-badge">
                    @if($booking->status === 'completed') ✅ Lunas
                    @elseif($booking->status === 'cancelled') ❌ Dibatalkan
                    @else ⏳ Menunggu Pembayaran
                    @endif
                </span>
            </div>

            {{-- Total --}}
            <div class="total-highlight">
                <div class="label">Total Pembayaran</div>
                <div class="amount">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
            </div>

            {{-- Pending Notice --}}
            @if($booking->status === 'pending')
            <div class="pending-notice">
                <div class="icon">💡</div>
                <p>Halaman ini akan otomatis memperbarui status setelah pembayaran Doku Anda dikonfirmasi. Simpan kode booking Anda: <strong>{{ $booking->booking_code }}</strong>.</p>
            </div>
            @endif

            {{-- CTA Buttons --}}
            @if($booking->status === 'completed')
                <a href="{{ route('home') }}" class="btn-primary">
                    🏠 Kembali ke Beranda
                </a>
            @elseif($booking->status === 'cancelled')
                <a href="{{ route('tickets.buy') }}" class="btn-primary">
                    🔄 Buat Booking Baru
                </a>
            @else
                <button class="btn-primary" id="btn-check-status" onclick="checkStatus()">
                    🔄 Cek Status Pembayaran
                </button>
                <p id="polling-status">Status akan diperbarui otomatis…</p>
                <a href="{{ route('tickets.buy') }}" class="btn-secondary">
                    ← Kembali ke Halaman Tiket
                </a>
            @endif

        </div>{{-- /.doku-card-body --}}
    </div>
</div>
@endsection

@if($booking->status === 'pending')
@push('scripts')
<script>
    const BOOKING_CODE = '{{ $booking->booking_code }}';
    const STATUS_URL   = '/booking/doku/status/' + BOOKING_CODE;
    let pollInterval;

    function checkStatus() {
        fetch(STATUS_URL)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'completed') {
                    clearInterval(pollInterval);
                    // Reload agar tampilan berubah ke "Berhasil"
                    window.location.reload();
                } else if (data.status === 'cancelled') {
                    clearInterval(pollInterval);
                    window.location.reload();
                }
            })
            .catch(() => {});
    }

    // Poll setiap 8 detik otomatis
    pollInterval = setInterval(checkStatus, 8000);

    // Update teks countdown
    let countdown = 8;
    setInterval(() => {
        countdown--;
        if (countdown <= 0) countdown = 8;
        const el = document.getElementById('polling-status');
        if (el) el.textContent = 'Mengecek status otomatis dalam ' + countdown + ' detik…';
    }, 1000);
</script>
@endpush
@endif

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil – Saung Angklung Udjo</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --coklat: #4A2C0A; --emas: #C9922A; --emas-muda: #F0C060;
            --hijau: #2D5016; --krem: #F5EDD8; --krem-tua: #E8D8B8;
            --putih: #FDFAF4;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--putih);
            font-family: 'DM Sans', sans-serif;
            color: var(--coklat);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .card {
            background: #fff;
            border: 1px solid var(--krem-tua);
            border-radius: 16px;
            max-width: 480px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(74,44,10,.10);
            animation: slideUp .4s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-top {
            background: var(--hijau);
            padding: 40px 32px;
            text-align: center;
        }
        .check-circle {
            width: 72px; height: 72px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 18px;
        }
        .card-top h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 26px;
        }
        .card-top p { color: rgba(255,255,255,.8); font-size: 14px; margin-top: 8px; }

        .card-body { padding: 28px 32px; }

        .order-code {
            background: var(--krem);
            border: 1px dashed var(--emas);
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            letter-spacing: 2px;
            color: var(--coklat);
            margin-bottom: 24px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px dashed var(--krem-tua);
            font-size: 13px;
        }
        .detail-row:last-child { border: none; }
        .detail-row .label { color: #8A6830; }
        .detail-row .val { font-weight: 600; }

        .ticket-highlight {
            background: linear-gradient(135deg, var(--emas) 0%, #B87820 100%);
            border-radius: 10px;
            padding: 18px 22px;
            text-align: center;
            margin: 20px 0;
            color: var(--putih);
        }
        .ticket-highlight .num {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            line-height: 1;
        }
        .ticket-highlight p { font-size: 13px; opacity: .9; margin-top: 4px; }

        .notice {
            background: var(--krem);
            border-left: 4px solid var(--emas);
            padding: 14px 16px;
            border-radius: 0 8px 8px 0;
            font-size: 13px;
            color: #6B4C20;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-home {
            display: block;
            text-align: center;
            text-decoration: none;
            background: var(--coklat);
            color: var(--krem);
            padding: 13px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: opacity .2s;
        }
        .btn-home:hover { opacity: .85; }

        .footer { margin-top: 24px; font-size: 12px; color: #9A7A50; text-align: center; }
    </style>
</head>
<body>

<div class="card">
    <div class="card-top">
        <div class="check-circle">✓</div>
        <h1>Pembayaran Diterima!</h1>
        <p>Bukti bayar kamu sudah kami terima & sedang diverifikasi</p>
    </div>
    <div class="card-body">

        <div class="order-code">{{ $order->order_code }}</div>

        <div class="ticket-highlight">
            <div class="num">{{ $order->total_tiket }}</div>
            <p>Total Tiket Masuk yang Kamu Dapat</p>
        </div>

        <div class="detail-row">
            <span class="label">Nama</span>
            <span class="val">{{ $order->nama_pemesan }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Tanggal Kunjungan</span>
            <span class="val">{{ $order->tanggal_kunjungan->translatedFormat('d F Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Tiket Dibeli</span>
            <span class="val">{{ $order->jumlah_tiket }} tiket</span>
        </div>
        <div class="detail-row">
            <span class="label">Tiket Gratis (B1G1)</span>
            <span class="val">{{ $order->jumlah_tiket_gratis }} tiket</span>
        </div>
        <div class="detail-row">
            <span class="label">Total Dibayar</span>
            <span class="val">{{ $order->total_format }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Waktu Pembayaran</span>
            <span class="val">{{ $order->paid_at->format('d/m/Y H:i') }} WIB</span>
        </div>

        <br>
        <div class="notice">
            📧 Konfirmasi tiket akan dikirimkan ke <b>{{ $order->email }}</b> setelah verifikasi selesai (maks. 1×24 jam). Tunjukkan kode order ini saat tiba di lokasi.
        </div>

        <a href="{{ route('ticket.buy') }}" class="btn-home">← Pesan Tiket Lagi</a>
    </div>
</div>

<div class="footer">© {{ date('Y') }} Saung Angklung Udjo — Jl. Padasuka No.118, Bandung</div>

</body>
</html>
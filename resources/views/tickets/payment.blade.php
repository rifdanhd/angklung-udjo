<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS – Saung Angklung Udjo</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --coklat:    #4A2C0A;
            --emas:      #C9922A;
            --emas-muda: #F0C060;
            --hijau:     #2D5016;
            --krem:      #F5EDD8;
            --krem-tua:  #E8D8B8;
            --putih:     #FDFAF4;
            --merah:     #C0392B;
            --biru:      #1565C0;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--putih);
            font-family: 'DM Sans', sans-serif;
            color: var(--coklat);
            min-height: 100vh;
        }

        .header {
            background: var(--coklat);
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--krem);
            font-size: 22px;
        }
        .header p { color: var(--krem-tua); font-size: 13px; margin-top: 4px; }

        .steps {
            display: flex;
            justify-content: center;
            gap: 0;
            background: var(--krem-tua);
            overflow: hidden;
        }
        .step {
            flex: 1;
            max-width: 200px;
            text-align: center;
            padding: 12px 8px;
            font-size: 12px;
            font-weight: 500;
            color: #9A7A50;
            position: relative;
        }
        .step.active { background: var(--emas); color: var(--coklat); font-weight: 700; }
        .step-num {
            display: block;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: start;
        }
        @media (max-width: 640px) {
            .container { grid-template-columns: 1fr; padding: 24px 16px; }
        }

        .card {
            background: #fff;
            border: 1px solid var(--krem-tua);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(74,44,10,.07);
        }
        .card-header {
            background: var(--krem);
            border-bottom: 1px solid var(--krem-tua);
            padding: 16px 22px;
        }
        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }
        .card-body { padding: 22px; }

        /* ORDER SUMMARY */
        .order-code {
            background: var(--coklat);
            color: var(--emas-muda);
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }
        .order-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px dashed var(--krem-tua);
            font-size: 13px;
        }
        .order-row:last-child { border: none; }
        .order-row .label { color: #7A5C30; }
        .order-row .val { font-weight: 600; }
        .free-badge {
            background: var(--hijau);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .total-row {
            background: var(--krem);
            border-radius: 8px;
            padding: 14px 0 0;
            margin-top: 8px;
        }
        .total-row .order-row {
            padding: 10px 14px;
            border-bottom: none;
        }
        .total-row .order-row .val { font-size: 18px; color: var(--emas); }

        /* QRIS */
        .qris-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #7A5C30;
            margin-bottom: 16px;
        }
        .qris-label::before, .qris-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--krem-tua);
        }
        .qris-wrap {
            text-align: center;
            margin-bottom: 20px;
        }
        .qris-img {
            width: 220px;
            height: 220px;
            border: 3px solid var(--emas);
            border-radius: 12px;
            object-fit: contain;
            background: #fff;
            padding: 8px;
        }
        .qris-note {
            font-size: 12px;
            color: #8A6830;
            margin-top: 8px;
            line-height: 1.5;
        }
        .qris-amount {
            display: inline-block;
            background: var(--krem);
            border: 1.5px solid var(--emas);
            border-radius: 8px;
            padding: 10px 24px;
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            color: var(--coklat);
            margin: 12px 0;
        }

        /* UPLOAD */
        .upload-area {
            border: 2px dashed var(--krem-tua);
            border-radius: 10px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
            margin-bottom: 16px;
        }
        .upload-area:hover, .upload-area.drag { border-color: var(--emas); background: var(--krem); }
        .upload-area .icon { font-size: 36px; margin-bottom: 8px; }
        .upload-area p { font-size: 13px; color: #8A6830; }
        .upload-area strong { color: var(--coklat); }
        #uploadInput { display: none; }
        #previewWrap { display: none; text-align: center; margin-bottom: 16px; }
        #previewImg { max-width: 100%; max-height: 200px; border-radius: 8px; border: 2px solid var(--krem-tua); }

        .btn-bayar {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--emas) 0%, #B87820 100%);
            color: var(--putih);
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s;
        }
        .btn-bayar:hover { opacity: .9; }
        .btn-bayar:disabled { opacity: .5; cursor: default; }

        .alert-error {
            background: #FEF0EE;
            border: 1px solid #F5C6C0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 13px;
            color: var(--merah);
        }

        .timer-box {
            background: var(--krem);
            border: 1px solid var(--krem-tua);
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            margin-bottom: 16px;
            font-size: 13px;
            color: #7A5C30;
        }
        .timer-box strong { font-size: 20px; color: var(--merah); }

        .footer { text-align: center; padding: 24px; background: var(--coklat); color: var(--krem-tua); font-size: 12px; }
    </style>
</head>
<body>

<header class="header">
    <h1>Saung Angklung Udjo</h1>
    <p>Selesaikan pembayaran untuk mengonfirmasi tiket kamu</p>
</header>

<div class="steps">
    <div class="step"><span class="step-num">✓</span>Pesan</div>
    <div class="step active"><span class="step-num">2</span>Bayar</div>
    <div class="step"><span class="step-num">3</span>Selesai</div>
</div>

<main>
    <div class="container">

        {{-- KIRI: Ringkasan Order --}}
        <div>
            <div class="card">
                <div class="card-header"><h2>Ringkasan Pesanan</h2></div>
                <div class="card-body">
                    <div class="order-code">{{ $order->order_code }}</div>

                    <div class="order-row">
                        <span class="label">Nama Pemesan</span>
                        <span class="val">{{ $order->nama_pemesan }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Tanggal Kunjungan</span>
                        <span class="val">{{ $order->tanggal_kunjungan->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Tiket Dibeli</span>
                        <span class="val">{{ $order->jumlah_tiket }} tiket</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Tiket Gratis (B1G1) <span class="free-badge">FREE</span></span>
                        <span class="val">{{ $order->jumlah_tiket_gratis }} tiket</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Total Tiket Masuk</span>
                        <span class="val">{{ $order->total_tiket }} tiket</span>
                    </div>

                    <div class="total-row">
                        <div class="order-row">
                            <span class="label">Total yang Harus Dibayar</span>
                            <span class="val">{{ $order->total_format }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: QRIS + Upload --}}
        <div>
            <div class="card">
                <div class="card-header"><h2>Pembayaran QRIS</h2></div>
                <div class="card-body">

                    <div class="timer-box">
                        Selesaikan pembayaran dalam <strong id="countdown">15:00</strong>
                    </div>

                    <div class="qris-label">Scan QR Code di bawah</div>

                    <div class="qris-wrap">
                        <img src="{{ $qrisImage }}" alt="QRIS Saung Udjo" class="qris-img"
                             onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=SaungUdjo-QRIS'">
                        <br>
                        <span class="qris-amount">{{ $order->total_format }}</span>
                        <p class="qris-note">
                            Bayar dengan GoPay, OVO, Dana, ShopeePay,<br>
                            m-Banking, atau dompet digital lainnya
                        </p>
                    </div>

                    <div class="qris-label">Upload Bukti Pembayaran</div>

                    @if ($errors->any())
                        <div class="alert-error">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('ticket.confirm', $order->order_code) }}"
                          method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="upload-area" id="uploadArea" onclick="document.getElementById('uploadInput').click()">
                            <div class="icon">📸</div>
                            <p><strong>Klik atau seret foto bukti pembayaran</strong><br>JPG / PNG — maks. 2 MB</p>
                        </div>

                        <div id="previewWrap">
                            <img id="previewImg" src="" alt="Preview">
                            <p style="font-size:12px;color:#8A6830;margin-top:8px">
                                <a href="#" onclick="resetUpload(); return false;">Ganti foto</a>
                            </p>
                        </div>

                        <input type="file" name="bukti_bayar" id="uploadInput" accept="image/*">

                        <button type="submit" class="btn-bayar" id="btnKonfirmasi" disabled>
                            Konfirmasi Pembayaran
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>
</main>

<footer class="footer">© {{ date('Y') }} Saung Angklung Udjo — Jl. Padasuka No.118, Bandung</footer>

<script>
    // Countdown timer 15 menit
    let seconds = 15 * 60;
    const el = document.getElementById('countdown');
    const interval = setInterval(() => {
        seconds--;
        if (seconds <= 0) { clearInterval(interval); el.textContent = '00:00'; return; }
        const m = String(Math.floor(seconds / 60)).padStart(2, '0');
        const s = String(seconds % 60).padStart(2, '0');
        el.textContent = m + ':' + s;
        if (seconds < 60) el.style.color = '#C0392B';
    }, 1000);

    // File upload preview
    const input   = document.getElementById('uploadInput');
    const area    = document.getElementById('uploadArea');
    const preview = document.getElementById('previewWrap');
    const img     = document.getElementById('previewImg');
    const btn     = document.getElementById('btnKonfirmasi');

    input.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                area.style.display = 'none';
                preview.style.display = 'block';
                btn.disabled = false;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function resetUpload() {
        input.value = '';
        img.src = '';
        area.style.display = 'block';
        preview.style.display = 'none';
        btn.disabled = true;
    }

    // Drag & drop
    area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('drag'); });
    area.addEventListener('dragleave', () => area.classList.remove('drag'));
    area.addEventListener('drop', e => {
        e.preventDefault();
        area.classList.remove('drag');
        if (e.dataTransfer.files[0]) {
            input.files = e.dataTransfer.files;
            input.dispatchEvent(new Event('change'));
        }
    });
</script>
</body>
</html>
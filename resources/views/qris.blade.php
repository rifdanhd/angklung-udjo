<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QRIS — Saung Angklung Udjo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f5f5f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.75rem;
        }

        .header-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #1D9E75;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .header-icon svg { width: 24px; height: 24px; fill: none; stroke: #fff; stroke-width: 1.75; }

        .header h1 { font-size: 16px; font-weight: 600; color: #111; }
        .header p  { font-size: 13px; color: #888; margin-top: 1px; }

        label.field-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .amount-wrap {
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            transition: border-color .2s;
        }

        .amount-wrap:focus-within { border-color: #1D9E75; }

        .currency { font-size: 18px; font-weight: 500; color: #aaa; }

        #amount-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 24px;
            font-weight: 600;
            color: #111;
            width: 100%;
            background: transparent;
        }

        .quick-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 1.25rem;
        }

        .quick-btn {
            padding: 5px 14px;
            border: 1.5px solid #e5e5e5;
            border-radius: 20px;
            background: transparent;
            font-size: 12px;
            color: #555;
            cursor: pointer;
            transition: all .15s;
        }

        .quick-btn:hover { border-color: #1D9E75; color: #1D9E75; background: #f0faf6; }
        .quick-btn.active { border-color: #1D9E75; color: #1D9E75; background: #e1f5ee; }

        #gen-btn {
            width: 100%;
            padding: 14px;
            background: #1D9E75;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }

        #gen-btn:hover { background: #0F6E56; }
        #gen-btn:active { transform: scale(.98); }
        #gen-btn:disabled { background: #a0d4be; cursor: not-allowed; }

        .qr-section {
            display: none;
            margin-top: 1.5rem;
            text-align: center;
        }

        .qr-section.show { display: block; }

        .divider {
            border: none;
            border-top: 1.5px dashed #e5e5e5;
            margin-bottom: 1.5rem;
        }

        .qr-label { font-size: 12px; color: #999; margin-bottom: 4px; }
        .qr-amount { font-size: 22px; font-weight: 700; color: #111; margin-bottom: 1.25rem; }

        .qr-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        #qr-canvas-wrap {
            border: 8px solid #fff;
            border-radius: 16px;
            box-shadow: 0 0 0 1.5px #e5e5e5;
            overflow: hidden;
            display: inline-block;
            line-height: 0; /* hapus gap bawah canvas/img */
        }

        /* Paksa tampil 256px di layar, tapi internal 512px untuk unduhan tajam */
        #qr-canvas-wrap canvas,
        #qr-canvas-wrap img {
            width: 256px !important;
            height: 256px !important;
            display: block;
        }

        .crc-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e1f5ee;
            color: #0F6E56;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 1rem;
        }

        .crc-badge.invalid { background: #fcebeb; color: #a32d2d; }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            flex: 1;
            padding: 10px;
            border: 1.5px solid #e5e5e5;
            border-radius: 10px;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            cursor: pointer;
            transition: all .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .action-btn:hover { border-color: #1D9E75; color: #1D9E75; background: #f0faf6; }

        .error-box {
            display: none;
            background: #fcebeb;
            color: #a32d2d;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-top: 1rem;
        }

        .error-box.show { display: block; }

        @media (prefers-color-scheme: dark) {
            body { background: #1a1a1a; }
            .card { background: #242424; box-shadow: 0 4px 24px rgba(0,0,0,.3); }
            .header h1 { color: #f0f0f0; }
            .amount-wrap { border-color: #333; background: #2a2a2a; }
            #amount-input { color: #f0f0f0; }
            .quick-btn { border-color: #333; color: #aaa; }
            .action-btn { border-color: #333; color: #aaa; }
            .divider { border-color: #333; }
            .qr-amount { color: #f0f0f0; }
            #qr-canvas-wrap { box-shadow: 0 0 0 1.5px #333; }
        }
    </style>
</head>
<body>
<div class="card">
    <div class="header">
        <div class="header-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="3" height="3"/><rect x="18" y="14" width="3" height="3"/><rect x="14" y="18" width="3" height="3"/><rect x="18" y="18" width="3" height="3"/></svg>
        </div>
        <div>
            <h1>QRIS Generator</h1>
            <p>Saung Angklung Udjo &middot; Bandung</p>
        </div>
    </div>

    <label class="field-label">Nominal Pembayaran</label>
    <div class="amount-wrap">
        <span class="currency">Rp</span>
        <input id="amount-input" type="number" value="230000" min="1" step="1000" placeholder="0" />
    </div>

    <div class="quick-btns">
        <button class="quick-btn" data-val="10000">10rb</button>
        <button class="quick-btn" data-val="25000">25rb</button>
        <button class="quick-btn" data-val="50000">50rb</button>
        <button class="quick-btn" data-val="100000">100rb</button>
        <button class="quick-btn" data-val="200000">200rb</button>
        <button class="quick-btn" data-val="500000">500rb</button>
    </div>

    <button id="gen-btn">Generate QR</button>

    <div class="error-box" id="error-box"></div>

    <div class="qr-section" id="qr-section">
        <hr class="divider">
        <p class="qr-label">Scan untuk membayar</p>
        <p class="qr-amount" id="qr-amount"></p>
        <div class="qr-wrap">
            <div id="qr-canvas-wrap"></div>
        </div>
        <div class="crc-badge" id="crc-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
            <span id="crc-text">CRC valid</span>
        </div>
        <div class="action-btns">
            <button class="action-btn" id="copy-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                Salin String
            </button>
            <button class="action-btn" id="dl-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Unduh PNG
            </button>
        </div>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let currentStr = '';

function formatRp(val) {
    return 'Rp ' + parseInt(val).toLocaleString('id-ID');
}

function showError(msg) {
    const box = document.getElementById('error-box');
    box.textContent = msg;
    box.classList.add('show');
}

function hideError() {
    document.getElementById('error-box').classList.remove('show');
}

document.querySelectorAll('.quick-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('amount-input').value = btn.dataset.val;
    });
});

document.getElementById('gen-btn').addEventListener('click', async () => {
    const amount = parseInt(document.getElementById('amount-input').value) || 0;
    if (amount < 1) { showError('Masukkan nominal yang valid.'); return; }

    hideError();
    const btn = document.getElementById('gen-btn');
    btn.disabled = true;
    btn.textContent = 'Generating...';

    try {
        const res = await fetch('/qris/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ amount }),
        });

        const data = await res.json();

        if (!data.success) {
            showError(data.message || 'Gagal generate QRIS.');
            return;
        }

        currentStr = data.dynamic;

        document.getElementById('qr-amount').textContent = formatRp(data.amount);

        const badge   = document.getElementById('crc-badge');
        const crcText = document.getElementById('crc-text');
        if (data.valid) {
            badge.classList.remove('invalid');
            crcText.textContent = 'CRC valid';
        } else {
            badge.classList.add('invalid');
            crcText.textContent = 'CRC tidak valid!';
        }

        // Generate QR di resolusi 512px (tajam untuk unduh),
        // ditampilkan 256px via CSS
        const wrap = document.getElementById('qr-canvas-wrap');
        wrap.innerHTML = '';
        new QRCode(wrap, {
            text: currentStr,
            width: 512,
            height: 512,
            correctLevel: QRCode.CorrectLevel.L,
        });

        document.getElementById('qr-section').classList.add('show');

    } catch (e) {
        showError('Terjadi kesalahan. Coba lagi.');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Generate QR';
    }
});

document.getElementById('copy-btn').addEventListener('click', () => {
    if (!currentStr) return;
    navigator.clipboard.writeText(currentStr).then(() => {
        const btn = document.getElementById('copy-btn');
        const orig = btn.innerHTML;
        btn.textContent = 'Tersalin!';
        setTimeout(() => { btn.innerHTML = orig; }, 2000);
    });
});

document.getElementById('dl-btn').addEventListener('click', () => {
    // qrcodejs bisa render canvas atau img tergantung browser
    // coba canvas dulu, fallback ke img
    const canvas = document.querySelector('#qr-canvas-wrap canvas');
    const img    = document.querySelector('#qr-canvas-wrap img');

    let url = '';
    if (canvas) {
        url = canvas.toDataURL('image/png');
    } else if (img) {
        url = img.src;
    } else {
        alert('Generate QR dulu.');
        return;
    }

    const a = document.createElement('a');
    a.href     = url;
    a.download = 'qris-' + document.getElementById('amount-input').value + '.png';
    a.click();
});
</script>
</body>
</html>

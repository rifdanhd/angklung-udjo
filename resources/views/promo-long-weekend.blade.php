@extends('layouts.app')
@section('title', 'Promo Long Weekend Mei 2026 | Saung Angklung Udjo')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root { 
        --green-deep: #0a2e1f; 
        --green-light: #1a6b43; 
        --gold: #d4a843; 
        --gold-pale: #fdf3dc; 
        --bg-soft: #faf7f0;
    }
    body { background: var(--bg-soft); font-family: 'Plus Jakarta Sans', sans-serif; color: #1a1a1a; }
    
    .hero { 
        padding: 160px 20px 120px; 
        text-align: center; 
        background: linear-gradient(180deg, #061d14 0%, #0a2e1f 100%); 
        color: #fff;
        position: relative;
    }

    .hero::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0; height: 120px;
        background: linear-gradient(to top, var(--bg-soft), transparent);
    }

    .promo-label { text-transform: uppercase; letter-spacing: 5px; font-size: 12px; font-weight: 700; color: var(--gold); margin-bottom: 15px; display: block; }
    .hero h1 { font-size: clamp(32px, 6vw, 56px); font-weight: 800; letter-spacing: -1px; line-height: 1.1; margin-bottom: 15px; position: relative; z-index: 1; }
    .hero h1 span { color: var(--gold); font-style: italic; }

    .container-promo { max-width: 650px; margin: -80px auto 60px; padding: 0 15px; position: relative; z-index: 10; }
    .card-promo { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }

    .promo-banner { width: 100%; height: auto; background: #eee; display: block; }
    .promo-banner img { width: 100%; height: auto; display: block; }

    .card-content { padding: 35px 30px; }

    .terms-box { background: #f8fafc; border-left: 4px solid var(--gold); padding: 20px; border-radius: 12px; margin-bottom: 30px; }
    .terms-box h4 { margin-top: 0; font-size: 14px; color: var(--green-deep); text-transform: uppercase; margin-bottom: 12px; font-weight: 800; }
    .terms-list { margin: 0; padding-left: 18px; font-size: 13.5px; color: #475569; line-height: 1.6; }

    .field-group { margin-bottom: 20px; }
    .field-group label { display: block; font-size: 11px; font-weight: 700; margin-bottom: 8px; color: var(--green-deep); text-transform: uppercase; }
    .field-group input, .field-group select { width: 100%; padding: 14px 16px; border-radius: 12px; border: 1.5px solid #e2e8f0; outline: none; transition: 0.3s; font-size: 15px; }
    .field-group input:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(212, 168, 67, 0.1); }

    .ticket-card { padding: 20px; border-radius: 16px; border: 1.5px solid; margin-bottom: 20px; }
    .ticket-card.domestik { background: #f0fff4; border-color: #bbf7d0; }
    .ticket-card.mancanegara { background: #eff6ff; border-color: #bfdbfe; }

    /* ── RINCIAN BOX ── */
    .total-box { background: var(--green-deep); color: #fff; padding: 25px; border-radius: 16px; margin: 30px 0; }
    .breakdown-title { font-size: 12px; font-weight: 700; color: var(--gold); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; display: block; }
    .breakdown-item { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: rgba(255,255,255,0.8); }
    .grand-total-row { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 2px dashed rgba(255,255,255,0.2); }
    
    .btn-klaim { width: 100%; background: linear-gradient(135deg, var(--green-deep), var(--green-light)); color: #fff; border: none; padding: 20px; border-radius: 50px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(10, 46, 31, 0.2); text-transform: uppercase; letter-spacing: 1px; }
    .btn-klaim:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(10, 46, 31, 0.3); }

    .badge-diskon { background: var(--gold); color: #fff; padding: 1px 6px; border-radius: 20px; font-size: 9px; font-weight: 800; }
    .harga-coret { text-decoration: line-through; opacity: 0.5; }
</style>

<section class="hero">
    <span class="promo-label">Special Holiday Offer</span>
    <h1>Long Weekend <span>Mei 2026</span></h1>
    <p style="opacity: 0.8; letter-spacing: 2px;">Saung Angklung Udjo • Bandung</p>
</section>

<div class="container-promo">
    <div class="card-promo">
        <div class="promo-banner">
            <img src="{{ asset('images/Promo_Weekend.jpeg') }}" alt="Banner">
        </div>

        <div class="card-content">
            <div class="terms-box">
                <h4>Syarat & Ketentuan:</h4>
                <ol class="terms-list">
                    <li>Program berlaku untuk <b>perorangan/family/rombongan</b>.</li>
                    <li>Wajib isi form dan konfirmasi Admin via WhatsApp.</li>
                    <li><b>Diskon 10%</b> berlaku untuk kategori <b>Dewasa (Domestik & Mancanegara)</b>.</li>
                </ol>
            </div>

            <form action="{{ route('promo.submit') }}" method="POST">
                @csrf

                {{-- Honeypot field to prevent spam bots --}}
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="company_name_verification" tabindex="-1" autocomplete="off">
                </div>
                <div class="field-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" placeholder="Contoh: Budi Santoso" required>
                </div>

                <div class="ticket-card domestik">
                    <label style="color:#166534; font-size:11px; font-weight:800;">🇮🇩 TIKET DOMESTIK (WNI)</label>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-top:10px;">
                        <div class="field-group" style="margin-bottom:0;">
                            <label style="font-size:10px;">
                                Dewasa
                                <span class="badge-diskon">DISKON 10%</span><br>
                                <span class="harga-coret">85.000</span> → 76.500
                            </label>
                            <input type="number" name="jumlah_tiket_dewasa" id="d1" value="0" min="0" oninput="hitung()">
                        </div>
                        <div class="field-group" style="margin-bottom:0;">
                            <label style="font-size:10px;">Anak (60.000)</label>
                            <input type="number" name="jumlah_tiket_anak" id="a1" value="0" min="0" oninput="hitung()">
                        </div>
                    </div>
                </div>

                <div class="ticket-card mancanegara">
                    <label style="color:#1e40af; font-size:11px; font-weight:800;">🌏 TIKET MANCANEGARA (WNA)</label>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-top:10px;">
                        <div class="field-group" style="margin-bottom:0;">
                            <label style="font-size:10px;">
                                Adult
                                <span class="badge-diskon">DISKON 10%</span><br>
                                <span class="harga-coret">120.000</span> → 108.000
                            </label>
                            <input type="number" name="jumlah_tiket_manca_dewasa" id="d2" value="0" min="0" oninput="hitung()">
                        </div>
                        <div class="field-group" style="margin-bottom:0;">
                            <label style="font-size:10px;">Child (85.000)</label>
                            <input type="number" name="jumlah_tiket_manca_anak" id="a2" value="0" min="0" oninput="hitung()">
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <label>Pilih Jadwal</label>
                    <select name="tanggal_kunjungan" id="tgl" required onchange="hitung()">
                        <option value="2026-05-16" selected>Sabtu, 16 Mei - 13:00 WIB</option>
                    </select>
                </div>

                <div class="field-group">
                    <label>Nomor WhatsApp</label>
                    <input type="tel" name="no_hp" placeholder="08123456789" required>
                </div>

                <!-- ── BAGIAN RINCIAN OTOMATIS ── -->
                <div class="total-box">
                    <span class="breakdown-title">Ringkasan Pemesanan</span>
                    <div id="rincian-list">
                        <div style="font-style:italic; font-size:12px; color:rgba(255,255,255,0.5)">Silakan masukkan jumlah tiket...</div>
                    </div>
                    <div class="grand-total-row">
                        <span style="font-weight:700; font-size:14px;">TOTAL ESTIMASI</span>
                        <span id="grand-total" style="font-size:24px; font-weight:800; color: var(--gold);">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="btn-klaim">Klaim Promo via WhatsApp</button>
            </form>
        </div>
    </div>
</div>

<script>
    function formatIDR(val) {
        return 'Rp ' + val.toLocaleString('id-ID');
    }

    function hitung() {
        const d1 = parseInt(document.getElementById('d1').value) || 0;
        const a1 = parseInt(document.getElementById('a1').value) || 0;
        const d2 = parseInt(document.getElementById('d2').value) || 0;
        const a2 = parseInt(document.getElementById('a2').value) || 0;

        let rincianHtml = "";
        let total = 0;

        // Domestik Dewasa — diskon 10% dari 85.000
        if (d1 > 0) {
            const hargaNormal = d1 * 85000;
            const diskon = Math.round(hargaNormal * 0.10);
            const sub = hargaNormal - diskon;
            total += sub;
            rincianHtml += `
                <div class="breakdown-item">
                    <span>Domestik Dewasa (${d1} org)</span>
                    <span>
                        <span style="text-decoration:line-through; opacity:0.5; font-size:11px; margin-right:6px;">${formatIDR(hargaNormal)}</span>
                        ${formatIDR(sub)}
                    </span>
                </div>
                <div class="breakdown-item" style="color: var(--gold); font-size:11px; margin-top:-4px; margin-bottom:8px;">
                    <span>✦ Diskon 10% Dewasa</span>
                    <span>- ${formatIDR(diskon)}</span>
                </div>`;
        }

        // Domestik Anak — tanpa diskon
        if (a1 > 0) {
            const sub = a1 * 60000;
            total += sub;
            rincianHtml += `<div class="breakdown-item"><span>Domestik Anak (${a1} org)</span><span>${formatIDR(sub)}</span></div>`;
        }

        // Mancanegara Adult — diskon 10% dari 120.000
        if (d2 > 0) {
            const hargaNormal = d2 * 120000;
            const diskon = Math.round(hargaNormal * 0.10);
            const sub = hargaNormal - diskon;
            total += sub;
            rincianHtml += `
                <div class="breakdown-item">
                    <span>Mancanegara Adult (${d2} org)</span>
                    <span>
                        <span style="text-decoration:line-through; opacity:0.5; font-size:11px; margin-right:6px;">${formatIDR(hargaNormal)}</span>
                        ${formatIDR(sub)}
                    </span>
                </div>
                <div class="breakdown-item" style="color: var(--gold); font-size:11px; margin-top:-4px; margin-bottom:8px;">
                    <span>✦ Diskon 10% Adult</span>
                    <span>- ${formatIDR(diskon)}</span>
                </div>`;
        }

        // Mancanegara Child — tanpa diskon
        if (a2 > 0) {
            const sub = a2 * 85000;
            total += sub;
            rincianHtml += `<div class="breakdown-item"><span>Mancanegara Child (${a2} org)</span><span>${formatIDR(sub)}</span></div>`;
        }

        if (total === 0) {
            rincianHtml = `<div style="font-style:italic; font-size:12px; color:rgba(255,255,255,0.5)">Silakan masukkan jumlah tiket...</div>`;
        }

        document.getElementById('rincian-list').innerHTML = rincianHtml;
        document.getElementById('grand-total').innerText = formatIDR(total);
    }
</script>
@endsection
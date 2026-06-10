@extends('layouts.app')
@section('title', 'Promo Long Weekend Mei 2026 | Saung Angklung Udjo')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root { --green-deep: #0a2e1f; --green-light: #1a6b43; --gold: #d4a843; --gold-pale: #fdf3dc; }
    body { background: #faf7f0; font-family: 'Plus Jakarta Sans', sans-serif; }
    .hero { padding: 60px 20px; text-align: center; background: var(--green-deep); color: #fff; }
    .container-promo { max-width: 600px; margin: -40px auto 60px; padding: 0 15px; }
    .card-promo { background: #fff; border-radius: 20px; padding: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #ddd; }
    .field-group { margin-bottom: 15px; }
    .field-group label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px; color: var(--green-deep); }
    .field-group input, .field-group select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ccc; outline: none; }
    .btn-klaim { width: 100%; background: var(--green-deep); color: #fff; border: none; padding: 15px; border-radius: 50px; font-weight: 700; cursor: pointer; margin-top: 10px; }
    .alert-danger { background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; }
    .total-box { background: var(--green-deep); color: #fff; padding: 15px; border-radius: 10px; text-align: center; margin-top: 15px; }
</style>

<section class="hero">
    <h1>Long Weekend <span>Udjo</span></h1>
    <p>Diskon 10% Khusus Dewasa</p>
</section>

<div class="container-promo">
    <div class="card-promo">

        <!-- INI PENTING: Untuk munculin kalau ada error -->
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('promo.submit') }}" method="POST">
            @csrf <!-- JANGAN SAMPAI HILANG -->
            
            <div class="field-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required>
            </div>

            <div style="background:#f0fff6; padding:15px; border-radius:10px; border:1px solid #bbf7d0; margin-bottom:15px;">
                <label style="font-weight:700; font-size:12px; display:block; margin-bottom:10px;">TIKET DOMESTIK (WNI)</label>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="field-group">
                        <label>Dewasa (Promo)</label>
                        <input type="number" name="jumlah_tiket_dewasa" id="d1" value="{{ old('jumlah_tiket_dewasa', 0) }}" min="0" oninput="hitung()">
                    </div>
                    <div class="field-group">
                        <label>Anak (Normal)</label>
                        <input type="number" name="jumlah_tiket_anak" id="a1" value="{{ old('jumlah_tiket_anak', 0) }}" min="0" oninput="hitung()">
                    </div>
                </div>
            </div>

            <div style="background:#f0f6ff; padding:15px; border-radius:10px; border:1px solid #bfdbfe; margin-bottom:15px;">
                <label style="font-weight:700; font-size:12px; display:block; margin-bottom:10px;">TIKET MANCANEGARA (WNA)</label>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div class="field-group">
                        <label>Adult (Promo)</label>
                        <input type="number" name="jumlah_tiket_manca_dewasa" id="d2" value="{{ old('jumlah_tiket_manca_dewasa', 0) }}" min="0" oninput="hitung()">
                    </div>
                    <div class="field-group">
                        <label>Child (Normal)</label>
                        <input type="number" name="jumlah_tiket_manca_anak" id="a2" value="{{ old('jumlah_tiket_manca_anak', 0) }}" min="0" oninput="hitung()">
                    </div>
                </div>
            </div>

            <div class="field-group">
                <label>Pilih Tanggal & Jam</label>
                <select name="tanggal_kunjungan" required>
                    <option value="" disabled selected>-- Pilih Jadwal --</option>
                    <option value="2026-05-14" {{ old('tanggal_kunjungan') == '2026-05-14' ? 'selected' : '' }}>Kamis, 14 Mei - 10:00 WIB</option>
                    <option value="2026-05-15" {{ old('tanggal_kunjungan') == '2026-05-15' ? 'selected' : '' }}>Jumat, 15 Mei - 15:30 WIB</option>
                    <option value="2026-05-16" {{ old('tanggal_kunjungan') == '2026-05-16' ? 'selected' : '' }}>Sabtu, 16 Mei - 13:00 WIB</option>
                </select>
            </div>

            <div class="field-group">
                <label>Nomor WhatsApp (Aktif)</label>
                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="0812345xxx" required>
            </div>

            <div class="total-box">
                <div style="font-size:11px; opacity:0.8;">ESTIMASI TOTAL:</div>
                <div id="grand-total" style="font-size:24px; font-weight:700;">Rp 0</div>
            </div>

            <button type="submit" class="btn-klaim">Klaim Promo via WhatsApp</button>
        </form>
    </div>
</div>

<script>
    function hitung() {
        const d1 = parseInt(document.getElementById('d1').value) || 0;
        const a1 = parseInt(document.getElementById('a1').value) || 0;
        const d2 = parseInt(document.getElementById('d2').value) || 0;
        const a2 = parseInt(document.getElementById('a2').value) || 0;
        
        // Perhitungan: Dewasa diskon 10%, Anak Normal
        const total = (d1 * 76500) + (a1 * 60000) + (d2 * 108000) + (a2 * 85000);
        document.getElementById('grand-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    hitung(); // Jalankan sekali pas load
</script>
@endsection
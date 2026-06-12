<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket - {{ $booking->booking_code }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1a1445;
            margin: 0px;
            padding: 0px;
            background-color: #ffffff;
            font-size: 14px;
        }
        .header-bar {
            background-color: #1a1445;
            color: #ffffff;
            padding: 30px;
            text-align: center;
            border-bottom: 5px solid #c4a47c;
        }
        .header-bar h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .header-bar p {
            margin: 5px 0 0 0;
            color: #c4a47c;
            font-size: 14px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px;
        }
        .ticket-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .ticket-info-table td {
            padding: 10px 0;
            border-bottom: 1px solid #eeeeee;
            vertical-align: top;
        }
        .ticket-info-table td.label {
            font-weight: bold;
            color: #777777;
            width: 30%;
        }
        .ticket-info-table td.value {
            color: #1a1445;
            font-weight: 500;
        }
        .code-badge {
            background-color: rgba(196, 164, 124, 0.15);
            color: #c4a47c;
            padding: 5px 12px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            border: 1px solid rgba(196, 164, 124, 0.3);
        }
        .qr-section {
            text-align: center;
            margin: 40px 0;
            padding: 20px;
            background-color: #F7F7F2;
            border-radius: 8px;
            border: 1px dashed #c4a47c;
        }
        .qr-section img {
            width: 150px;
            height: 150px;
        }
        .instructions {
            background-color: rgba(26, 20, 69, 0.03);
            border-left: 4px solid #1a1445;
            padding: 15px 20px;
            border-radius: 0 8px 8px 0;
            margin-top: 30px;
        }
        .instructions h3 {
            margin-top: 0;
            color: #1a1445;
            font-size: 15px;
        }
        .instructions ul {
            margin: 0;
            padding-left: 20px;
            font-size: 13px;
            color: #555555;
        }
        .instructions li {
            margin-bottom: 6px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 25px;
            background-color: #F7F7F2;
            text-align: center;
            font-size: 11px;
            color: #777777;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <h1>SAUNG ANGKLUNG UDJO</h1>
        <p>Official Entry E-Ticket</p>
    </div>

    <div class="content">
        <table class="ticket-info-table">
            <tr>
                <td class="label">Kode Booking</td>
                <td class="value"><span class="code-badge">{{ $booking->booking_code }}</span></td>
            </tr>
            <tr>
                <td class="label">Nama Pemesan</td>
                <td class="value">{{ $booking->nama }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $booking->email }}</td>
            </tr>
            <tr>
                <td class="label">No. Telepon</td>
                <td class="value">{{ $booking->no_hp }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Kunjungan</td>
                <td class="value"><strong>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</strong></td>
            </tr>
            <tr>
                <td class="label">Sesi Pertunjukan</td>
                <td class="value"><strong>{{ $booking->session_time }}</strong></td>
            </tr>
            <tr>
                <td class="label">Rincian Tiket</td>
                <td class="value">
                    @php
                        $parts = [];
                        if ($booking->jumlah_tiket_dewasa > 0) $parts[] = $booking->jumlah_tiket_dewasa . ' Dewasa';
                        if ($booking->jumlah_tiket_anak > 0) $parts[] = $booking->jumlah_tiket_anak . ' Anak';
                        if ($booking->jumlah_tiket_kitas_dewasa > 0) $parts[] = $booking->jumlah_tiket_kitas_dewasa . ' KITAS';
                        if ($booking->jumlah_tiket_manca_dewasa > 0) $parts[] = $booking->jumlah_tiket_manca_dewasa . ' Manca Dewasa';
                        if ($booking->jumlah_tiket_manca_anak > 0) $parts[] = $booking->jumlah_tiket_manca_anak . ' Manca Anak';
                    @endphp
                    {{ implode(', ', $parts) }}
                </td>
            </tr>
            <tr>
                <td class="label">Total Pembayaran</td>
                <td class="value"><strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong> (LUNAS)</td>
            </tr>
        </table>

        <div class="qr-section">
            <p style="margin: 0 0 15px 0; font-weight: bold; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #1a1445;">Tunjukkan QR Code ini untuk scan masuk check-in</p>
            {{-- Menggunakan Google Chart API untuk QR code gratis & andal di server --}}
            <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={{ $booking->booking_code }}&choe=UTF-8" alt="QR Code Booking">
            <p style="margin: 10px 0 0 0; font-family: monospace; font-size: 15px; font-weight: bold; color: #777777;">{{ $booking->booking_code }}</p>
        </div>

        <div class="instructions">
            <h3>📌 Panduan & Ketentuan Kunjungan:</h3>
            <ul>
                <li>Harap hadir 30 menit sebelum pertunjukan dimulai untuk proses check-in.</li>
                <li>Tunjukkan e-ticket ini baik dalam bentuk digital (ponsel) maupun cetak di gerbang masuk/loket penukaran tiket.</li>
                <li>Tidak ada alokasi nomor kursi tetap. Sistem tempat duduk adalah First Come First Serve (siapa cepat dia dapat).</li>
                <li>E-ticket ini hanya berlaku untuk tanggal dan sesi pertunjukan yang tertera di atas.</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>Saung Angklung Udjo</strong><br>Jl. Padasuka 118, Bandung 40192, Jawa Barat, Indonesia<br>Telepon: +62 22 7271714 | Email: info@angklung-udjo.co.id</p>
    </div>
</body>
</html>

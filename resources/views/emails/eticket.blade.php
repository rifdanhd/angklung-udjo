<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket Saung Angklung Udjo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #1a1445;
            background-color: #F7F7F2;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(26,20,69,0.05);
            border: 1px solid rgba(196,164,124,0.2);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #c4a47c;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #1a1445;
        }
        .booking-details {
            background-color: rgba(196, 164, 124, 0.08);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .booking-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .booking-details td {
            padding: 6px 0;
        }
        .booking-details td.label {
            font-weight: bold;
            color: rgba(26,20,69,0.6);
            width: 40%;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: rgba(26,20,69,0.5);
            border-top: 1px solid rgba(26,20,69,0.1);
            padding-top: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #1a1445;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Saung Angklung Udjo</h2>
            <p style="margin: 5px 0 0; color: #c4a47c;">Konfirmasi Pembayaran & E-Ticket</p>
        </div>

        <p>Halo, <strong>{{ $booking->nama }}</strong></p>
        <p>Terima kasih atas pemesanan tiket Anda di Saung Angklung Udjo. Pembayaran Anda telah terverifikasi dan pemesanan Anda kini berstatus <strong>Lunas (Confirmed/Completed)</strong>.</p>

        <div class="booking-details">
            <table>
                <tr>
                    <td class="label">Kode Booking</td>
                    <td><strong>{{ $booking->booking_code }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Kunjungan</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Sesi / Jam</td>
                    <td>{{ $booking->session_time }}</td>
                </tr>
                <tr>
                    <td class="label">Jumlah Tiket</td>
                    <td>
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
                    <td class="label">Total Harga</td>
                    <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <p>Kami telah melampirkan e-ticket PDF pada email ini. Silakan unduh dan tunjukkan e-ticket tersebut (atau tunjukkan QR Code-nya) kepada petugas kami saat kedatangan di loket check-in.</p>

        <p>Sampai jumpa di Saung Angklung Udjo!</p>

        <div class="footer">
            <p><strong>Saung Angklung Udjo</strong><br>Jl. Padasuka 118, Bandung 40192, Jawa Barat, Indonesia<br>Website: www.angklung-udjo.co.id</p>
        </div>
    </div>
</body>
</html>

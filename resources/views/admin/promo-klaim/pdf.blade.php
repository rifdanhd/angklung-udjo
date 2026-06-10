<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        /* Pengaturan Margin Standar Dokumen (Word-Style) */
        @page { 
            margin: 25mm 20mm; /* Atas-Bawah 2.5cm, Kiri-Kanan 2cm */
            size: A4 portrait; 
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt; /* Ukuran standar dokumen */
            color: #222;
            background: #fff;
            line-height: 1.5;
        }

        /* ── HEADER ── */
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .report-title {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
            margin-bottom: 5px;
        }
        .report-info {
            width: 100%;
            font-size: 8pt;
            color: #555;
        }

        /* ── SUMMARY SECTION ── */
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
            margin-top: 25px;
            color: #000;
        }

        .summary-box-wrapper {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px 0;
            margin: 0 -15px; /* Offset spacing */
        }
        .summary-box {
            display: table-cell;
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            background: #fcfcfc;
        }
        .summary-label {
            font-size: 7.5pt;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 8px;
            display: block;
            letter-spacing: 0.5px;
        }
        .summary-value {
            font-size: 14pt;
            font-weight: bold;
            color: #000;
        }

        /* ── TABLES ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        /* Header Tabel */
        thead { display: table-header-group; }
        
        th {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            padding: 8px 5px;
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: bold;
            text-align: left;
        }

        td {
            border: 1px solid #eee;
            padding: 8px 5px;
            font-size: 8.5pt;
            vertical-align: middle;
        }

        /* Zebra Row */
        tbody tr:nth-child(even) { background-color: #fafafa; }

        /* Utility */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .price { font-family: 'Courier New', Courier, monospace; font-weight: bold; }

        /* Status Badge */
        .status-pill {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7pt;
            border: 1px solid #999;
            border-radius: 3px;
            text-transform: uppercase;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>
<body>

@php
    $fmtRupiah = fn($n) => number_format($n, 0, ',', '.');
    
    // Mapping Jam Otomatis
    $jamMapping = [
        '2026-05-14' => '10.00 WIB',
        '2026-05-15' => '15.30 WIB',
        '2026-05-16' => '13.00 WIB',
    ];

    $targetDates = ['2026-05-14', '2026-05-15', '2026-05-16'];
    
    $summaryDates = [];
    foreach($targetDates as $date) {
        $filtered = $data->filter(fn($i) => \Carbon\Carbon::parse($i->tanggal_kunjungan)->format('Y-m-d') == $date);
        $summaryDates[$date] = [
            'pax' => $filtered->sum('jumlah_tiket_dewasa') + $filtered->sum('jumlah_tiket_anak') + 
                     $filtered->sum('jumlah_tiket_manca_dewasa') + $filtered->sum('jumlah_tiket_manca_anak'),
            'klaim' => $filtered->count(),
            'revenue' => $filtered->whereNotIn('status', ['cancelled'])->sum('total_harga')
        ];
    }
@endphp

<!-- HEADER -->
<div class="header">
    <table class="report-info" border="0">
        <tr>
            <td style="border:none; padding:0;">
                <div class="report-title">{{ $judul }}</div>
                <div>Saung Angklung Udjo &bull; Bandung, Indonesia</div>
            </td>
            <td style="border:none; padding:0; text-align:right;">
                <strong>Dibuat:</strong> {{ date('d M Y, H:i') }} WIB<br>
                <strong>Status:</strong> CONFIRMED DATA
            </td>
        </tr>
    </table>
</div>

<!-- SECTION 1: EXECUTIVE SUMMARY -->
<div class="section-title">I. Ringkasan Eksekutif</div>
<div class="summary-box-wrapper">
    <div class="summary-box">
        <span class="summary-label">Total Reservasi</span>
        <div class="summary-value">{{ $summary['total_klaim'] }}</div>
    </div>
    <div class="summary-box">
        <span class="summary-label">Total Keseluruhan Pax</span>
        <div class="summary-value">{{ $summary['total_pax'] }}</div>
    </div>
    <div class="summary-box">
        <span class="summary-label">Total Estimasi Pendapatan</span>
        <div class="summary-value">Rp {{ $fmtRupiah($summary['total_pendapatan']) }}</div>
    </div>
</div>

<!-- SECTION 2: DAILY BREAKDOWN -->
<div class="section-title">II. Rincian Per Hari (High Season)</div>
<table class="daily-table">
    <thead>
        <tr>
            <th width="35%">Hari & Tanggal</th>
            <th width="20%" class="text-center">Sesi</th>
            <th width="15%" class="text-center">Reservasi</th>
            <th width="15%" class="text-center">Total Pax</th>
            <th width="15%" class="text-right">Subtotal (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($summaryDates as $date => $stats)
        <tr>
            <td class="bold">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
            <td class="text-center">{{ $jamMapping[$date] ?? '-' }}</td>
            <td class="text-center">{{ $stats['klaim'] }}</td>
            <td class="text-center">{{ $stats['pax'] }}</td>
            <td class="text-right bold">{{ $fmtRupiah($stats['revenue']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- SECTION 3: MANIFEST -->
<div class="section-title">III. Daftar Manifest Penumpang</div>
<table class="manifest-table">
    <thead>
        <tr>
            <th width="3%" class="text-center">No</th>
            <th width="10%">Tanggal</th>
            <th width="10%" class="text-center">Sesi</th>
            <th width="20%">Nama Tamu</th>
            <th width="10%">WhatsApp</th>
            <th width="5%" class="text-center">DOM</th>
            <th width="5%" class="text-center">MAN</th>
            <th width="5%" class="text-center">PAX</th>
            <th width="15%" class="text-right">Harga (Rp)</th>
            <th width="12%" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $item)
        @php
            $tglKey = \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('Y-m-d');
            $paxRow = $item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak + $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak;
        @endphp
        <tr>
            <td class="text-center" style="color: #666;">{{ $key + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/y') }}</td>
            <td class="text-center">{{ $jamMapping[$tglKey] ?? '-' }}</td>
            <td class="bold">{{ strtoupper($item->nama) }}</td>
            <td>{{ $item->no_hp }}</td>
            <td class="text-center">{{ $item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak }}</td>
            <td class="text-center">{{ $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak }}</td>
            <td class="text-center bold">{{ $paxRow }}</td>
            <td class="text-right price">{{ $fmtRupiah($item->total_harga) }}</td>
            <td class="text-center"><span class="status-pill">{{ $item->status }}</span></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background: #eee; font-weight: bold;">
            <td colspan="7" class="text-right" style="padding: 10px;">GRAND TOTAL</td>
            <td class="text-center" style="font-size: 10pt;">{{ $summary['total_pax'] }}</td>
            <td class="text-right" style="font-size: 10pt;">{{ $fmtRupiah($summary['total_pendapatan']) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<!-- FOOTER -->
<div class="footer">
    <table width="100%" border="0">
        <tr>
            <td style="border:none;">&copy; {{ date('Y') }} Saung Angklung Udjo Digital Reporting System</td>
            <td style="border:none; text-align:right;">Halaman 1 dari 1</td>
        </tr>
    </table>
</div>

</body>
</html>
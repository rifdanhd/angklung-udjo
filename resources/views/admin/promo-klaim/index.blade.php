@extends('admin.layouts.app')
@section('title', 'Kelola Promo Klaim')
@section('content')

<style>
    .tabs { display:flex; gap:4px; background:var(--surface2); padding:4px; border-radius:10px; margin-bottom:20px; width:fit-content; border:1px solid var(--border); }
    .tab { padding:7px 16px; border-radius:7px; font-size:13px; font-weight:600; text-decoration:none; color:var(--text-muted); transition:all var(--transition); white-space:nowrap; display:flex; align-items:center; gap:6px; }
    .tab.active { background:var(--surface); color:var(--text); box-shadow:var(--shadow-sm); }
    .tab:hover:not(.active) { color:var(--text); }
    .tab-badge { background:var(--danger); color:#fff; border-radius:20px; padding:1px 6px; font-size:10px; font-weight:700; }

    .filter-bar { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; align-items:center; }
    .filter-input {
        padding:8px 13px; border-radius:var(--radius-sm); border:1.5px solid var(--border);
        font-size:13px; color:var(--text); background:var(--surface); outline:none;
        transition:border-color var(--transition); font-family:var(--font);
    }
    .filter-input:focus { border-color:var(--border-focus); box-shadow:0 0 0 3px rgba(124,111,255,.12); }

    .status-select {
        padding:6px 10px; border-radius:7px; border:1.5px solid var(--border);
        font-size:12px; font-weight:600; cursor:pointer; outline:none;
        background:var(--surface); min-width:128px; font-family:var(--font);
        transition:border-color var(--transition);
    }
    .status-select.s-pending   { color:#9a6c00; border-color:#f0d990; background:var(--gold-soft); }
    .status-select.s-confirmed { color:#1a7a4a; border-color:#9ddfc0; background:var(--success-soft); }
    .status-select.s-cancelled { color:#b81c21; border-color:#f5b8b0; background:var(--danger-soft); }

    .btn-del {
        width:30px; height:30px; display:flex; align-items:center; justify-content:center;
        border-radius:7px; border:1.5px solid var(--border); background:var(--surface);
        color:var(--danger); cursor:pointer; transition:all var(--transition); flex-shrink:0;
    }
    .btn-del:hover { background:var(--danger-soft); border-color:#f5b8b0; }

    .wa-link { color:#22c55e; font-weight:600; text-decoration:none; font-size:12.5px; }
    .wa-link:hover { text-decoration:underline; }

    .empty-state { text-align:center; padding:60px 20px; color:var(--text-muted); }

    .modal-overlay {
        display:none; position:fixed; inset:0; background:rgba(10,8,30,.45);
        z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(3px);
    }
    .modal-box {
        background:var(--surface); border-radius:16px; padding:32px 28px;
        max-width:380px; width:90%; box-shadow:0 24px 64px rgba(34,24,93,.2);
        text-align:center; animation:modalIn .2s ease;
    }
    @keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
    .modal-box h3 { font-size:16px; font-weight:700; margin:12px 0 8px; color:var(--text); }
    .modal-box p  { font-size:13px; color:var(--text-muted); margin-bottom:22px; line-height:1.5; }
    .modal-actions { display:flex; gap:10px; justify-content:center; }

    .tiket-wrap { display:flex; flex-direction:column; gap:3px; }

    .stat-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:24px; }
    @media(max-width:1200px) { .stat-grid { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:700px)  { .stat-grid { grid-template-columns:repeat(2,1fr); } }

    /* ── Chart Section ── */
    .chart-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:24px; }
    @media(max-width:1100px) { .chart-grid { grid-template-columns:1fr 1fr; } }
    @media(max-width:700px)  { .chart-grid { grid-template-columns:1fr; } }

    .chart-card {
        background:var(--surface); border:1px solid var(--border); border-radius:14px;
        padding:20px; position:relative;
    }
    .chart-card.wide { grid-column: span 2; }
    @media(max-width:1100px) { .chart-card.wide { grid-column: span 1; } }

    .chart-title {
        font-size:12px; font-weight:700; text-transform:uppercase;
        letter-spacing:.05em; color:var(--text-muted); margin-bottom:16px;
        display:flex; align-items:center; gap:6px;
    }
    .chart-title span { font-size:15px; }
    .chart-wrap { position:relative; height:200px; }
    .chart-wrap.sm { height:160px; }

    .event-pill {
        display:inline-flex; align-items:center; gap:5px;
        padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;
    }
    .event-pill.ramadan     { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
    .event-pill.long_weekend{ background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
    .event-pill.all         { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
</style>

@php
    // Semua data untuk grafik (tidak tergantung filter halaman)
    $allData = \App\Models\PromoKlaim::all();
    $lwDates = ['2026-05-14', '2026-05-15', '2026-05-16'];

    // Per event
    $countRamadan     = $allData->whereNotIn('tanggal_kunjungan', $lwDates)->count();
    $countLongWeekend = $allData->whereIn('tanggal_kunjungan', $lwDates)->count();

    // Per status
    $countPending   = $allData->where('status', 'pending')->count();
    $countConfirmed = $allData->where('status', 'confirmed')->count();
    $countCancelled = $allData->where('status', 'cancelled')->count();

    // Pax per event
    $paxRamadan = $allData->whereNotIn('tanggal_kunjungan', $lwDates)
        ->sum(fn($i) => $i->jumlah_tiket_dewasa + $i->jumlah_tiket_anak + $i->jumlah_tiket_manca_dewasa + $i->jumlah_tiket_manca_anak);
    $paxLW = $allData->whereIn('tanggal_kunjungan', $lwDates)
        ->sum(fn($i) => $i->jumlah_tiket_dewasa + $i->jumlah_tiket_anak + $i->jumlah_tiket_manca_dewasa + $i->jumlah_tiket_manca_anak);

    // Pendapatan per event
    $revenueRamadan = $allData->whereNotIn('tanggal_kunjungan', $lwDates)->where('status', 'confirmed')->sum('total_harga');
    $revenueLW      = $allData->whereIn('tanggal_kunjungan', $lwDates)->where('status', 'confirmed')->sum('total_harga');

    // Per tanggal kunjungan (top 10)
    $perTanggal = $allData->groupBy(fn($i) => \Carbon\Carbon::parse($i->tanggal_kunjungan)->format('d/m'))
        ->map(fn($g) => $g->count())
        ->sortKeys()
        ->take(15);

    // Pax breakdown total
    $totalDomDewasa  = $allData->sum('jumlah_tiket_dewasa');
    $totalDomAnak    = $allData->sum('jumlah_tiket_anak');
    $totalMancaDewasa= $allData->sum('jumlah_tiket_manca_dewasa');
    $totalMancaAnak  = $allData->sum('jumlah_tiket_manca_anak');

    // Klaim per hari (created_at)
    $perHari = $allData->groupBy(fn($i) => \Carbon\Carbon::parse($i->created_at)->format('d/m'))
        ->map(fn($g) => $g->count())
        ->sortKeys()
        ->take(14);
@endphp

{{-- ── HEADER ── --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Promo Klaim 2026</h1>
        <div class="page-breadcrumb" style="display:flex;align-items:center;gap:8px;">
            Manajemen Klaim &nbsp;
            @if($event === 'ramadan')
                <span class="event-pill ramadan">🌙 Ramadan 2026</span>
            @elseif($event === 'long_weekend')
                <span class="event-pill long_weekend">🏖️ Long Weekend Mei 2026</span>
            @else
                <span class="event-pill all">📋 Semua Event</span>
            @endif
        </div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <a href="{{ url('/promo-long-weekend') }}" target="_blank" class="btn btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Halaman Promo
        </a>
        <a href="{{ route('admin.promo.exportPdf') }}?event=ramadan" target="_blank" class="btn btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            PDF Ramadan
        </a>
        <a href="{{ route('admin.promo.exportPdf') }}?event=long_weekend" target="_blank" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            PDF Long Weekend
        </a>
        <a href="{{ route('admin.promo.exportExcel') }}?event={{ $event }}" class="btn btn-outline">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="8" y1="13" x2="16" y2="13"></line>
        <line x1="8" y1="17" x2="16" y2="17"></line>
        <polyline points="10 9 9 9 8 9"></polyline>
    </svg>
    Export Excel
</a>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stat-grid">
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;"><svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--text-muted);margin-bottom:3px;">Total Klaim</div><div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalKlaim }}</div></div>
    </div>
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#ede9ff;display:flex;align-items:center;justify-content:center;"><svg width="18" height="18" fill="none" stroke="#7c6fff" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
        <div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--text-muted);margin-bottom:3px;">Total Pax</div><div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalPax }}</div></div>
    </div>
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;"><span style="font-size:20px;">🎟️</span></div>
        <div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--text-muted);margin-bottom:3px;">Total Dewasa</div><div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalDewasa + $totalMancaDewasa }}</div></div>
    </div>
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--success-soft);display:flex;align-items:center;justify-content:center;"><span style="font-size:20px;">👦</span></div>
        <div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--text-muted);margin-bottom:3px;">Total Anak</div><div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalAnak + $totalMancaAnak }}</div></div>
    </div>
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;">
        <div style="width:42px;height:42px;border-radius:10px;background:#e8f0fa;display:flex;align-items:center;justify-content:center;"><span style="font-size:20px;">💰</span></div>
        <div><div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--text-muted);margin-bottom:3px;">Pendapatan</div><div style="font-size:18px;font-weight:800;color:var(--text);line-height:1;">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</div></div>
    </div>
</div>

{{-- ── GRAFIK ── --}}
<div class="chart-grid">

    {{-- Klaim per Event --}}
    <div class="chart-card">
        <div class="chart-title"><span>📊</span> Klaim per Event</div>
        <div class="chart-wrap sm">
            <canvas id="chartEvent"></canvas>
        </div>
    </div>

    {{-- Status Klaim --}}
    <div class="chart-card">
        <div class="chart-title"><span>🔄</span> Status Klaim</div>
        <div class="chart-wrap sm">
            <canvas id="chartStatus"></canvas>
        </div>
    </div>

    {{-- Pax Breakdown --}}
    <div class="chart-card">
        <div class="chart-title"><span>👥</span> Komposisi Pax</div>
        <div class="chart-wrap sm">
            <canvas id="chartPax"></canvas>
        </div>
    </div>

    {{-- Klaim per Tanggal Kunjungan --}}
    <div class="chart-card wide">
        <div class="chart-title"><span>📅</span> Klaim per Tanggal Kunjungan</div>
        <div class="chart-wrap">
            <canvas id="chartTanggal"></canvas>
        </div>
    </div>

    {{-- Pendapatan per Event --}}
    <div class="chart-card">
        <div class="chart-title"><span>💰</span> Pendapatan per Event</div>
        <div class="chart-wrap sm">
            <canvas id="chartRevenue"></canvas>
        </div>
    </div>

    {{-- Tren Klaim Masuk Harian --}}
    <div class="chart-card wide">
        <div class="chart-title"><span>📈</span> Tren Klaim Masuk per Hari</div>
        <div class="chart-wrap">
            <canvas id="chartTren"></canvas>
        </div>
    </div>

</div>

{{-- ── TABS ── --}}
<div class="tabs">
    <a href="{{ route('admin.promo.index') }}?event={{ $event }}" class="tab {{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.promo.index') }}?event={{ $event }}&status=pending" class="tab {{ request('status')=='pending' ? 'active' : '' }}">
        Pending @if(isset($totalPending) && $totalPending > 0)<span class="tab-badge">{{ $totalPending }}</span>@endif
    </a>
    <a href="{{ route('admin.promo.index') }}?event={{ $event }}&status=confirmed" class="tab {{ request('status')=='confirmed' ? 'active' : '' }}">Confirmed</a>
</div>

{{-- ── FILTER ── --}}
<form method="GET" action="{{ route('admin.promo.index') }}" class="filter-bar">
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif

    <select name="event" class="filter-input" onchange="this.form.submit()">
        <option value="all"          {{ $event === 'all'          ? 'selected' : '' }}>📋 Semua Event</option>
        <option value="ramadan"      {{ $event === 'ramadan'      ? 'selected' : '' }}>🌙 Ramadan 2026</option>
        <option value="long_weekend" {{ $event === 'long_weekend' ? 'selected' : '' }}>🏖️ Long Weekend Mei 2026</option>
    </select>

    <input type="text" name="search" placeholder="Cari nama, no HP..." value="{{ request('search') }}" class="filter-input" style="min-width:210px;">
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="filter-input">
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    @if(request('search') || request('tanggal') || (request('event') && request('event') !== 'all'))
        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

{{-- ── TABLE ── --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:36px;">#</th>
                    <th>Nama</th>
                    <th>WhatsApp</th>
                    <th style="text-align:center;">🇮🇩 Domestik</th>
                    <th style="text-align:center;">🌏 Mancanegara</th>
                    <th style="text-align:center;">Total Pax</th>
                    <th>Tgl Kunjungan</th>
                    <th>Jam</th>
                    <th>Event</th>
                    <th>Total Harga</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klaims as $i => $item)
                @php
                    $totalPaxRow = $item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak + $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak;
                    $tgl = \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('Y-m-d');
                    $isLW = in_array($tgl, ['2026-05-14', '2026-05-15', '2026-05-16']);
                    $jamMapping = [
                        '2026-05-14' => '10.00 WIB',
                        '2026-05-15' => '15.30 WIB',
                        '2026-05-16' => '13.00 WIB',
                    ];
                    $jamKunjungan = $jamMapping[$tgl] ?? '-';
                @endphp
                <tr>
                    <td>{{ $klaims->firstItem() + $i }}</td>
                    <td style="font-weight:600;">{{ $item->nama }}</td>
                    <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="wa-link">{{ $item->no_hp }}</a></td>
                    <td style="text-align:center;">
                        <div class="tiket-wrap">
                            @if($item->jumlah_tiket_dewasa > 0) <span class="badge badge-brand">{{ $item->jumlah_tiket_dewasa }} Dewasa</span> @endif
                            @if($item->jumlah_tiket_anak > 0) <span class="badge badge-success">{{ $item->jumlah_tiket_anak }} Anak</span> @endif
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <div class="tiket-wrap">
                            @if($item->jumlah_tiket_manca_dewasa > 0) <span class="badge" style="background:#dbeafe;color:#1e40af;">{{ $item->jumlah_tiket_manca_dewasa }} Adult</span> @endif
                            @if($item->jumlah_tiket_manca_anak > 0) <span class="badge" style="background:#ede9ff;color:#5b21b6;">{{ $item->jumlah_tiket_manca_anak }} Child</span> @endif
                        </div>
                    </td>
                    <td style="text-align:center; font-weight:700;">{{ $totalPaxRow }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }}</td>
                    <td><span class="badge badge-muted" style="background:#f1f1f1;color:#555;">{{ $jamKunjungan }}</span></td>
                    <td>
                        @if($isLW)
                            <span class="event-pill long_weekend">🏖️ Long Weekend</span>
                        @else
                            <span class="event-pill ramadan">🌙 Ramadan</span>
                        @endif
                    </td>
                    <td style="font-weight:700;color:var(--brand);">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td style="text-align:center;" id="status-badge-{{ $item->id }}">
                        <span class="badge badge-{{ $item->status == 'confirmed' ? 'success' : ($item->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:center;">
                            <select class="status-select s-{{ $item->status }}" data-id="{{ $item->id }}" data-url="{{ route('admin.promo.updateStatus', $item->id) }}">
                                <option value="pending"   @selected($item->status==='pending')>Pending</option>
                                <option value="confirmed" @selected($item->status==='confirmed')>Confirmed</option>
                                <option value="cancelled" @selected($item->status==='cancelled')>Cancelled</option>
                            </select>
                            <button class="btn-del" onclick="showModal({{ $item->id }}, '{{ addslashes($item->nama) }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="14"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="12" class="empty-state">Belum ada data klaim promo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:14px 20px;">{{ $klaims->links() }}</div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" class="modal-overlay">
    <div class="modal-box">
        <h3>Hapus Data Klaim?</h3>
        <p>Data <strong id="namaHapus"></strong> akan dihapus permanen.</p>
        <div class="modal-actions">
            <button onclick="hideModal()" class="btn btn-outline">Batal</button>
            <form id="formHapus" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    /* ── Modal ── */
    function showModal(id, nama) {
        document.getElementById('namaHapus').textContent = nama;
        document.getElementById('formHapus').action = '/admin/promo-klaim/' + id;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function hideModal() { document.getElementById('modalHapus').style.display = 'none'; }

    /* ── Status select ── */
    document.querySelectorAll('.status-select').forEach(sel => {
        sel.addEventListener('change', function() {
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('status', this.value);
            fetch(this.dataset.url, { method: 'POST', body: fd }).then(() => location.reload());
        });
    });

    /* ── Chart defaults ── */
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.size   = 11;
    Chart.defaults.color       = '#6b7280';

    /* ── 1. Klaim per Event (Donut) ── */
    new Chart(document.getElementById('chartEvent'), {
        type: 'doughnut',
        data: {
            labels: ['🌙 Ramadan', '🏖️ Long Weekend'],
            datasets: [{
                data: [{{ $countRamadan }}, {{ $countLongWeekend }}],
                backgroundColor: ['#fb923c', '#60a5fa'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw} klaim` } }
            }
        }
    });

    /* ── 2. Status Klaim (Donut) ── */
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Confirmed', 'Pending', 'Cancelled'],
            datasets: [{
                data: [{{ $countConfirmed }}, {{ $countPending }}, {{ $countCancelled }}],
                backgroundColor: ['#34d399', '#fbbf24', '#f87171'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw}` } }
            }
        }
    });

    /* ── 3. Komposisi Pax (Bar horizontal) ── */
    new Chart(document.getElementById('chartPax'), {
        type: 'bar',
        data: {
            labels: ['Dom. Dewasa', 'Dom. Anak', 'Manca. Dewasa', 'Manca. Anak'],
            datasets: [{
                data: [{{ $totalDomDewasa }}, {{ $totalDomAnak }}, {{ $totalMancaDewasa }}, {{ $totalMancaAnak }}],
                backgroundColor: ['#818cf8', '#a5b4fc', '#34d399', '#6ee7b7'],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } },
                y: { grid: { display: false } }
            }
        }
    });

    /* ── 4. Klaim per Tanggal Kunjungan (Bar) ── */
    new Chart(document.getElementById('chartTanggal'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($perTanggal->keys()) !!},
            datasets: [{
                label: 'Jumlah Klaim',
                data: {!! json_encode($perTanggal->values()) !!},
                backgroundColor: ctx => {
                    // Warna beda untuk Long Weekend (14,15,16 Mei)
                    const lwLabels = ['14/05', '15/05', '16/05'];
                    return lwLabels.includes(ctx.chart.data.labels[ctx.dataIndex]) ? '#60a5fa' : '#fb923c';
                },
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} klaim` } }
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } }
            }
        }
    });

    /* ── 5. Pendapatan per Event (Bar) ── */
    new Chart(document.getElementById('chartRevenue'), {
        type: 'bar',
        data: {
            labels: ['🌙 Ramadan', '🏖️ Long Weekend'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: [{{ $revenueRamadan }}, {{ $revenueLW }}],
                backgroundColor: ['#fb923c', '#60a5fa'],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    grid: { color: '#f3f4f6' },
                    ticks: { callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'jt' }
                }
            }
        }
    });

    /* ── 6. Tren Klaim Masuk per Hari (Line) ── */
    new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: {!! json_encode($perHari->keys()) !!},
            datasets: [{
                label: 'Klaim Masuk',
                data: {!! json_encode($perHari->values()) !!},
                borderColor: '#818cf8',
                backgroundColor: 'rgba(129,140,248,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#818cf8',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} klaim masuk` } }
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } }
            }
        }
    });
</script>

@endsection
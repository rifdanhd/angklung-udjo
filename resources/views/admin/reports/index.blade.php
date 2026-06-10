{{-- resources/views/admin/reports/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan & Tiket')

@push('styles')
<style>
/* Page header */
.page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
}
.page-title { font-size: 22px; font-weight: 700; color: var(--text); letter-spacing: -.5px; }
.page-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 12.5px; color: var(--text-muted); margin-top: 4px;
}
.page-breadcrumb a { color: var(--text-muted); text-decoration: none; }
.page-breadcrumb a:hover { color: var(--text); }
.page-breadcrumb svg { width: 12px; height: 12px; }

/* Filter Card */
.filter-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    margin-bottom: 24px;
}
.filter-form {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: flex-end;
}
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
}
.filter-group input {
    padding: 8px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13.5px;
    background: var(--surface);
    outline: none;
    min-height: 38px;
    transition: all var(--transition);
}
.filter-group input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
}

/* KPI Grid */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.kpi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px;
    transition: all var(--transition);
}
.kpi-card:hover {
    border-color: var(--border-strong);
    box-shadow: var(--shadow-sm);
}
.kpi-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .05em;
    margin-bottom: 8px;
}
.kpi-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.1;
    letter-spacing: -.5px;
}
.kpi-subtext {
    font-size: 11.5px;
    color: var(--text-muted);
    margin-top: 8px;
}

/* Report Layout */
.report-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 1024px) {
    .report-grid {
        grid-template-columns: 1fr;
    }
}

/* Progress List */
.progress-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.progress-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.progress-label-wrap {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 600;
}
.progress-bar-bg {
    height: 8px;
    background: var(--surface2);
    border-radius: 4px;
    overflow: hidden;
}
.progress-bar-fill {
    height: 100%;
    background: var(--accent);
    border-radius: 4px;
    transition: width .5s ease-out;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Keuangan &amp; Penjualan Tiket</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;margin:0 4px;"><path d="M9 5l7 7-7 7"/></svg>
            Laporan Keuangan
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="filter-card">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-form">
        <div class="filter-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="from" value="{{ $from->toDateString() }}">
        </div>
        <div class="filter-group">
            <label>Tanggal Selesai</label>
            <input type="date" name="to" value="{{ $to->toDateString() }}">
        </div>
        <div>
            @if(request('from') || request('to'))
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline" style="min-height:38px; margin-right:4px;">Reset</a>
            @endif
            <button type="submit" class="btn btn-primary" style="min-height:38px;">
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px;margin-right:6px;"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Terapkan Periode
            </button>
        </div>
    </form>
</div>

{{-- KPI Summary --}}
<div class="kpi-grid">
    {{-- Pendapatan --}}
    <div class="kpi-card" style="border-left: 4px solid var(--success);">
        <div class="kpi-label" style="color:var(--success-text);">Simulasi Pendapatan</div>
        <div class="kpi-value">Rp {{ number_format($kpi['total_revenue'], 0, ',', '.') }}</div>
        <div class="kpi-subtext">Potensi dari akumulasi pesanan masuk</div>
    </div>
    
    {{-- Total Reservasi --}}
    <div class="kpi-card" style="border-left: 4px solid var(--accent);">
        <div class="kpi-label" style="color:var(--accent);">Total Pemesanan</div>
        <div class="kpi-value">{{ $kpi['total_reservations'] }}</div>
        <div class="kpi-subtext">Pemesanan tiket terdaftar</div>
    </div>

    {{-- Total Tiket --}}
    <div class="kpi-card" style="border-left: 4px solid var(--info);">
        <div class="kpi-label" style="color:var(--info-text);">Tiket Terjual</div>
        <div class="kpi-value">{{ $kpi['total_tickets'] }}</div>
        <div class="kpi-subtext">Akumulasi seluruh jenis tiket</div>
    </div>

    {{-- Customer Baru --}}
    <div class="kpi-card" style="border-left: 4px solid var(--warning);">
        <div class="kpi-label" style="color:var(--warning-text);">Customer Baru</div>
        <div class="kpi-value">{{ $kpi['new_customers'] }}</div>
        <div class="kpi-subtext">Terdaftar pada periode ini</div>
    </div>
</div>

<div class="report-grid">
    {{-- Kiri: Pendapatan Harian --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Rincian Simulasi Pendapatan per Hari</div>
                <div class="card-sub">Menampilkan potensi pemasukan harian dan jumlah transaksi</div>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Transaksi</th>
                        <th style="text-align:right;">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($revenuePerDay as $day)
                    <tr>
                        <td style="font-weight:600;">{{ \Carbon\Carbon::parse($day->date)->translatedFormat('d M Y') }}</td>
                        <td>{{ $day->count }} Transaksi</td>
                        <td style="font-weight:700; text-align:right; color:var(--success-text);">
                            Rp {{ number_format($day->total, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center; padding:48px; color:var(--text-muted);">
                            Tidak ada transaksi finansial pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kanan: Tiket Terpopuler & Promo --}}
    <div style="display:flex; flex-direction:column; gap:20px;">
        {{-- Tiket Terlaris --}}
        <div class="card" style="padding:20px;">
            <div class="card-title" style="margin-bottom:6px;">Tiket Terlaris</div>
            <div class="card-sub" style="margin-bottom:18px;">Jenis tiket yang paling banyak dibeli</div>
            
            <div class="progress-list">
                @php
                    $maxQty = $topTickets->max('qty') ?: 1;
                @endphp
                @forelse($topTickets as $ticket)
                @php
                    $percentage = ($ticket->qty / $maxQty) * 100;
                @endphp
                <div class="progress-item">
                    <div class="progress-label-wrap">
                        <span>{{ $ticket->name }}</span>
                        <span style="color:var(--text-muted);">{{ $ticket->qty }} tiket</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                    </div>
                    <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                        Revenue: Rp {{ number_format($ticket->revenue, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:13px;">
                    Belum ada data penjualan tiket.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Penggunaan Promo --}}
        <div class="card" style="padding:20px;">
            <div class="card-title" style="margin-bottom:6px;">Penggunaan Kode Promo</div>
            <div class="card-sub" style="margin-bottom:18px;">Statistik kupon promo yang digunakan</div>

            <div class="progress-list">
                @php
                    $maxPromo = $promoUsage->max('usage') ?: 1;
                @endphp
                @forelse($promoUsage as $promo)
                @php
                    $percentage = ($promo->usage / $maxPromo) * 100;
                @endphp
                <div class="progress-item">
                    <div class="progress-label-wrap">
                        <span style="font-family:var(--font-mono); font-weight:700; color:var(--accent);">{{ $promo->promo_code_used }}</span>
                        <span style="color:var(--text-muted);">{{ $promo->usage }}x pakai</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $percentage }}%; background:var(--success);"></div>
                    </div>
                    <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">
                        Total Diskon: Rp {{ number_format($promo->total_disc, 0, ',', '.') }}
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:13px;">
                    Tidak ada kode promo yang digunakan periode ini.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

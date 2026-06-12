
@extends('admin.layouts.app')
@section('title', 'Booking Tiket')
@push('styles')
<style>
/* ═══ STAT CARDS ═══ */
.stats-grid {
    display: grid;
    gap: 14px;
    margin-bottom: 16px;
}
.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all var(--transition);
}
.stat-card:hover { border-color: var(--border-strong); box-shadow: var(--shadow-xs); }
.stat-icon {
    width: 38px; height: 38px;
    border-radius: 9px;
    background: var(--surface2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--text-muted);
}
.stat-icon svg { width: 18px; height: 18px; flex-shrink: 0; display: block; }
.stat-content { flex: 1; min-width: 0; }
.stat-val { font-size: 20px; font-weight: 700; color: var(--text); line-height: 1.1; letter-spacing: -.4px; }
.stat-lbl { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; font-weight: 500; }
.stat-trend {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600; margin-top: 6px;
}
.stat-trend svg { width: 12px; height: 12px; }
.stat-trend.up   { color: var(--success-text); }
.stat-trend.down { color: var(--danger-text); }
/* Revenue card dark */
.revenue-card {
    background: linear-gradient(135deg, #1f1d2b 0%, #2d2a3d 100%);
    background: var(--indigo-deep, #1a1445);
    border-color: transparent;
}
.revenue-card .stat-val  { color: #fff; font-size: 22px; }
.revenue-card .stat-lbl  { color: rgba(255,255,255,.7); }
.revenue-card .stat-icon { background: rgba(255,255,255,.12); color: #fff; }
@keyframes pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .5; transform: scale(1.15); }
}
@media (max-width: 640px) {
    .stat-card { padding: 12px 14px; }
    .stat-val  { font-size: 17px; }
}
/* ═══ FILTER SECTION ═══ */
.filter-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 14px 16px;
    margin-bottom: 16px;
}
.filter-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap; margin-bottom: 12px;
}
.filter-title { font-size: 13.5px; font-weight: 600; color: var(--text); }
.filter-presets { display: flex; gap: 6px; flex-wrap: wrap; }
.preset-btn {
    padding: 6px 12px;
    border: 1px solid var(--border);
    border-radius: 18px;
    background: var(--surface);
    color: var(--text-2);
    font-size: 12px; font-weight: 500;
    cursor: pointer;
    transition: all var(--transition);
    font-family: var(--font);
}
.preset-btn:hover  { background: var(--surface2); }
.preset-btn.active { background: var(--brand); color: #fff; border-color: var(--brand); }
.filter-bar { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.filter-bar input,
.filter-bar select {
    padding: 8px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font); font-size: 13px;
    background: var(--surface); outline: none;
    min-height: 38px; transition: all var(--transition);
    color: var(--text);
}
.filter-bar input:focus,
.filter-bar select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.date-range { display: flex; gap: 6px; align-items: center; }
.date-range input { width: 140px; }
@media (max-width: 768px) {
    .filter-bar { flex-direction: column; align-items: stretch; }
    .filter-bar > * { width: 100%; }
    .date-range { display: grid; grid-template-columns: 1fr auto 1fr; }
    .date-range input { width: 100%; }
    .filter-presets { overflow-x: auto; flex-wrap: nowrap; padding-bottom: 4px; scrollbar-width: none; }
    .filter-presets::-webkit-scrollbar { display: none; }
}
/* ═══ TABLE CONTROLS ═══ */
.table-controls {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
    background: var(--surface2);
}
.table-options { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.bulk-actions {
    display: none; align-items: center; gap: 8px;
    padding: 4px 12px;
    background: var(--accent-soft); border-radius: 8px; border: 1px solid #c7d2fe;
}
.bulk-actions.active { display: flex; }
.selected-count { font-size: 12px; font-weight: 600; color: var(--accent-hover); }
.export-group { display: flex; gap: 6px; }
.btn-export {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 11px;
    border: 1px solid var(--border-strong); border-radius: 6px;
    background: var(--surface); color: var(--text-2);
    font-size: 12px; font-weight: 500; cursor: pointer;
    transition: all var(--transition); text-decoration: none;
    font-family: var(--font);
}
.btn-export:hover { background: var(--surface2); color: var(--text); }
.btn-export svg  { width: 13px; height: 13px; flex-shrink: 0; }
.per-page { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); }
.per-page select {
    padding: 5px 8px; border: 1px solid var(--border-strong);
    border-radius: 6px; font-size: 12px; background: var(--surface);
}
@media (max-width: 768px) {
    .table-controls { padding: 10px 12px; }
    .export-group   { width: 100%; justify-content: space-between; }
    .btn-export     { flex: 1; justify-content: center; }
    .per-page       { display: none; }
}
/* ═══ CHECKBOX & SORTABLE ═══ */
.checkbox { width: 16px; height: 16px; accent-color: var(--accent); cursor: pointer; }
.sortable { cursor: pointer; user-select: none; position: relative; padding-right: 22px !important; }
.sortable::after {
    content: "\21C5"; position: absolute; right: 8px; top: 50%;
    transform: translateY(-50%); opacity: .35; font-size: 10px;
}
.sortable.asc::after  { content: "\2191"; opacity: 1; color: var(--accent); }
.sortable.desc::after { content: "\2193"; opacity: 1; color: var(--accent); }
/* ═══ STATUS SELECT ═══ */
.status-select {
    padding: 4px 8px; border: 1px solid var(--border-strong);
    border-radius: 6px; font-size: 11.5px; font-weight: 600;
    cursor: pointer; background: var(--surface); outline: none;
    font-family: var(--font);
}
.status-select.status-pending,
.status-select.status-confirmed { background: var(--warning-soft); color: var(--warning-text); border-color: #fde68a; }
.status-select.status-completed { background: var(--success-soft); color: var(--success-text); border-color: #a7f3d0; }
.status-select.status-cancelled { background: var(--danger-soft);  color: var(--danger-text);  border-color: #fecaca; }
/* ═══ TICKET ITEMS ═══ */
.tkt-items { font-size: 11.5px; line-height: 1.5; }
.tkt-item-line { color: var(--text-2); }
.tkt-item-line strong { color: var(--text); margin-right: 3px; }
/* ═══ LOADING OVERLAY ═══ */
.loading-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(255,255,255,.7); backdrop-filter: blur(2px);
    z-index: 9999; align-items: center; justify-content: center;
}
.loading-overlay.active { display: flex; }
.loading-spinner {
    width: 40px; height: 40px;
    border: 3px solid var(--surface3); border-top-color: var(--accent);
    border-radius: 50%; animation: spin .8s linear infinite;
}
/* ═══ MODAL ═══ */
.modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(15,15,21,.55); backdrop-filter: blur(4px);
    z-index: 100; align-items: center; justify-content: center; padding: 20px;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: var(--surface); border-radius: var(--radius-lg);
    width: 100%; max-width: 520px; max-height: 90vh;
    overflow-y: auto; box-shadow: var(--shadow-lg);
    padding: 22px 24px; position: relative;
    animation: slideUp .25s cubic-bezier(.4,0,.2,1);
}
.modal-box.large { max-width: 720px; }
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px) scale(.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-close {
    position: absolute; top: 12px; right: 14px;
    background: var(--surface2); border: none;
    width: 30px; height: 30px; border-radius: 8px;
    cursor: pointer; color: var(--text-muted); font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    transition: all var(--transition);
}
.modal-close:hover { background: var(--surface3); color: var(--text); }
.modal-title {
    font-size: 16px; font-weight: 600; color: var(--text);
    margin-bottom: 16px; padding-right: 40px;
}
/* Modal detail rows */
.modal-row {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 8px 0; border-bottom: 1px solid var(--border);
    font-size: 13px;
}
.modal-row:last-child { border-bottom: none; }
.modal-row .lbl {
    min-width: 140px; font-weight: 500; color: var(--text-muted); flex-shrink: 0;
}
.modal-row .val { color: var(--text); flex: 1; }
@media (max-width: 640px) {
    .modal-backdrop { padding: 0; align-items: flex-end; }
    .modal-box {
        max-width: 100%; max-height: 92vh;
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        padding: 20px 18px 24px;
    }
    .modal-row { flex-direction: column; gap: 2px; }
    .modal-row .lbl { min-width: 0; font-size: 11px; text-transform: uppercase; letter-spacing: .3px; }
}
/* ═══ FORM ═══ */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
.form-grid.single { grid-template-columns: 1fr; }
.form-group { display: flex; flex-direction: column; }
.form-input, .form-select, .form-textarea {
    width: 100%; padding: 9px 12px;
    border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
    font-family: var(--font); font-size: 13.5px;
    background: var(--surface); outline: none; transition: all var(--transition);
    color: var(--text);
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.form-textarea { resize: vertical; min-height: 80px; }
.form-label { display: block; font-size: 12.5px; font-weight: 500; color: var(--text); margin-bottom: 5px; }
.form-label.required::after { content: " *"; color: var(--danger); }
.modal-footer {
    display: flex; gap: 8px; justify-content: flex-end;
    padding-top: 14px; border-top: 1px solid var(--border); margin-top: 16px;
}
@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
    .form-input, .form-select, .form-textarea { font-size: 14px; min-height: 42px; padding: 11px 14px; }
    .modal-footer .btn { flex: 1; justify-content: center; }
}
/* ═══ MOBILE CARDS ═══ */
.bk-mobile-list { display: none; padding: 8px; }
@media (max-width: 768px) {
    .bk-table-desktop { display: none; }
    .bk-mobile-list   { display: block; }
}
.bk-mobile-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 14px; margin-bottom: 8px;
    transition: all var(--transition);
}
.bk-mobile-card:active { background: var(--surface2); }
.bk-mc-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 10px; margin-bottom: 10px;
}
.bk-mc-name { font-weight: 600; font-size: 14px; color: var(--text); }
.bk-mc-code { font-family: var(--font-mono); font-size: 11px; color: var(--accent); font-weight: 700; margin-top: 2px; }
.bk-mc-meta {
    display: grid; grid-template-columns: auto 1fr;
    gap: 4px 10px; font-size: 12.5px; margin-bottom: 10px;
}
.bk-mc-meta dt { color: var(--text-muted); font-weight: 500; }
.bk-mc-meta dd { color: var(--text); font-weight: 500; text-align: right; word-break: break-word; }
.bk-mc-actions {
    display: flex; gap: 6px;
    margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border);
}
.bk-mc-actions .btn { flex: 1; min-height: 38px; justify-content: center; }
/* ═══ NOTIF TOAST (pending booking) ═══ */
.notif-toast {
    position: fixed; bottom: 24px; right: 24px; z-index: 9998;
    display: flex; align-items: flex-start; gap: 12px;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); box-shadow: var(--shadow-lg);
    padding: 14px 16px; max-width: 340px; cursor: pointer;
    animation: slideUp .3s cubic-bezier(.4,0,.2,1);
    transition: opacity .25s, transform .25s;
}
.notif-toast:hover { box-shadow: var(--shadow-lg); }
.notif-toast-icon { flex-shrink: 0; margin-top: 2px; }
.notif-toast-body { flex: 1; min-width: 0; }
.notif-toast-title { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 3px; }
.notif-toast-msg   { font-size: 12px; color: var(--text-muted); }
.notif-toast-close {
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 18px; line-height: 1;
    padding: 0 2px; flex-shrink: 0; transition: color var(--transition);
}
.notif-toast-close:hover { color: var(--text); }
@media (max-width: 640px) {
    .notif-toast { bottom: 16px; left: 16px; right: 16px; max-width: none; }
}
/* ═══ PAGE HEADER ═══ */
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
@media (max-width: 640px) {
    .page-title { font-size: 18px; }
    .page-header > div:last-child { width: 100%; }
    .page-header .btn { width: 100%; justify-content: center; }
}
</style>
@endpush
@section('content')
{{-- Loading Overlay --}}
<div class="loading-overlay" id="loading">
    <div class="loading-spinner"></div>
</div>
{{-- Page header --}}
<div class="page-header">
    <div>
        <div class="page-title">Booking Tiket</div>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            Booking Tiket
        </div>
    </div>
    <div>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Booking
        </button>
    </div>
</div>
@if(session('error'))
<div class="alert alert-error">
    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('error') }}
</div>
@endif
{{-- Baris 1: Revenue + Total Booking + Total Tiket + Pengunjung Hari Ini --}}
<div class="stats-grid" style="grid-template-columns:repeat(4, 1fr);margin-bottom:16px">
    <div class="stat-card revenue-card" style="grid-column:span 1 !important">
        <div class="stat-icon">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['revenue'] ?? 'Rp 0' }}</div>
            <div class="stat-lbl">Perkiraan Pendapatan</div>

        </div>
    </div>
    <div class="stat-card" style="--stat-color:#7c6fff">
        <div class="stat-icon" style="background:#f0efff">
            <svg fill="none" stroke="#7c6fff" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['total'] }}</div>
            <div class="stat-lbl">Total Booking</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#0ea5e9">
        <div class="stat-icon" style="background:#e0f2fe">
            <svg fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ number_format($stats['total_tickets'] ?? 0) }}</div>
            <div class="stat-lbl">Total Tiket Terjual</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#10b981">
        <div class="stat-icon" style="background:#d1fae5">
            <svg fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ number_format($stats['visitors_today'] ?? 0) }}</div>
            <div class="stat-lbl">Total Pengunjung</div>
        </div>
    </div>
</div>
{{-- Baris 2: Pending | Reservasi | Lunas | Dibatalkan --}}
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:24px">
    <div class="stat-card" style="--stat-color:var(--warning-text, #b45309)">
        <div class="stat-icon" style="background:var(--warning-soft, #fef3c7)">
            <svg fill="none" stroke="var(--warning-text, #b45309)" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['pending'] }}</div>
            <div class="stat-lbl">Pending</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:var(--brand)">
        <div class="stat-icon" style="background:var(--accent-soft)">
            <svg fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['confirmed'] }}</div>
            <div class="stat-lbl">Reservasi</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:var(--success)">
        <div class="stat-icon" style="background:var(--success-soft)">
            <svg fill="none" stroke="var(--success)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['completed'] }}</div>
            <div class="stat-lbl">Lunas</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:var(--danger)">
        <div class="stat-icon" style="background:var(--danger-soft)">
            <svg fill="none" stroke="var(--danger)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $stats['cancelled'] ?? 0 }}</div>
            <div class="stat-lbl">Dibatalkan</div>
        </div>
    </div>
</div>
{{-- Enhanced Filter Section --}}
<div class="filter-section">
    <div class="filter-header">
        <div class="filter-title">🔍 Filter & Pencarian</div>
        <div class="filter-presets">
            <button class="preset-btn {{ !request()->hasAny(['date_from','date_to','preset']) ? 'active' : '' }}" onclick="applyPreset('all')">
                Semua
            </button>
            <button class="preset-btn {{ request('preset')=='today' ? 'active' : '' }}" onclick="applyPreset('today')">
                Hari Ini
            </button>
            <button class="preset-btn {{ request('preset')=='week' ? 'active' : '' }}" onclick="applyPreset('week')">
                Minggu Ini
            </button>
            <button class="preset-btn {{ request('preset')=='month' ? 'active' : '' }}" onclick="applyPreset('month')">
                Bulan Ini
            </button>
            <button class="preset-btn {{ request('preset')=='last_month' ? 'active' : '' }}" onclick="applyPreset('last_month')">
                Bulan Lalu
            </button>
        </div>
    </div>
    <form method="GET" action="{{ route('admin.booking.ticket.index') }}" id="filterForm">
        <div class="filter-bar">
            <input type="text"
                   name="search"
                   placeholder="🔍  Cari nama, email, kode, nomor HP..."
                   value="{{ request('search') }}"
                   style="min-width:280px">
            <div class="date-range">
                <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="Dari">
                <span style="color:var(--text-muted)">—</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="Sampai">
            </div>
            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" @selected(request('status')=='pending')>⏳ Pending</option>
                <option value="confirmed" @selected(request('status')=='confirmed' || request('status')=='reservasi')>⏳ Reservasi</option>
                <option value="completed" @selected(request('status')=='completed')>🎉 Lunas</option>
                <option value="cancelled" @selected(request('status')=='cancelled')>❌ Dibatalkan</option>
            </select>
            {{-- ↓ UPDATED: default sort = Kunjungan Terdekat --}}
            <select name="sort_by">
                <option value="visit_date_asc"  @selected(request('sort_by', 'visit_date_asc')=='visit_date_asc')>Kunjungan: Terdekat</option>
                <option value="visit_date_desc" @selected(request('sort_by')=='visit_date_desc')>Kunjungan: Terjauh</option>
                <option value="created_desc"    @selected(request('sort_by')=='created_desc')>Dipesan: Terbaru</option>
                <option value="created_asc"     @selected(request('sort_by')=='created_asc')>Dipesan: Terlama</option>
                <option value="total_desc"      @selected(request('sort_by')=='total_desc')>Total: Tertinggi</option>
                <option value="total_asc"       @selected(request('sort_by')=='total_asc')>Total: Terendah</option>
            </select>
            <input type="hidden" name="preset" id="presetInput" value="{{ request('preset') }}">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if(request()->hasAny(['search','date_from','date_to','status','sort_by','preset']))
                <a href="{{ route('admin.booking.ticket.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </div>
    </form>
</div>
{{-- Table --}}
<div class="card">
    {{-- Table Controls --}}
    <div class="table-controls">
        <div class="table-options" style="flex:1">
            <div class="bulk-actions" id="bulkActions">
                <span class="selected-count" id="selectedCount">0 dipilih</span>
                <button class="btn btn-sm btn-outline" onclick="bulkUpdateStatus()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Update Status
                </button>
                <button class="btn btn-sm btn-danger" onclick="bulkDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
        <div style="display:flex;gap:10px;align-items:center">
            <div class="export-group">
                <button class="btn-export" onclick="exportData('excel')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </button>
                <button class="btn-export" onclick="exportData('pdf')">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    PDF
                </button>
                <a href="https://docs.google.com/spreadsheets/d/14bNfETmR4BXxf-yhXiK4_y1Yms3x-Aa5b3fAYd8n2Hc/edit?gid=0#gid=0"
                   target="_blank"
                   class="btn-export"
                   style="color:#1a7340;border-color:#c3e6cb;text-decoration:none">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/>
                    </svg>
                    Spreadsheet
                </a>
            </div>
            <div class="per-page">
                <span>Tampilkan</span>
                <select onchange="changePerPage(this.value)">
                    <option value="10" @selected(request('per_page')==10)>10</option>
                    <option value="25" @selected(request('per_page')==25)>25</option>
                    <option value="50" @selected(request('per_page')==50)>50</option>
                    <option value="100" @selected(request('per_page')==100)>100</option>
                    <option value="1000" @selected(request('per_page')==1000)>1000
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-wrap bk-table-desktop">
        <table>
            <thead>
                <tr>
                    <th style="width:40px">
                        <input type="checkbox" class="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                    </th>
                    <th class="sortable" onclick="sortTable('booking_code')">Kode</th>
                    <th class="sortable" onclick="sortTable('name')">Pengunjung</th>
                    {{-- ↓ Kolom ini sekarang aktif asc by default --}}
                    <th class="sortable {{ in_array(request('sort_by', 'visit_date_asc'), ['visit_date_asc']) ? 'asc' : (request('sort_by')=='visit_date_desc' ? 'desc' : '') }}"
                        onclick="sortTable('visit_date')">Tanggal Kunjungan</th>
                    <th>Sesi</th>
                    <th>Tiket</th>
                    <th>Metode</th>
                    <th class="sortable" onclick="sortTable('total')">Total</th>
                    <th>Status</th>
                    <th class="sortable" onclick="sortTable('created_at')">Dipesan</th>
                    <th style="text-align:center;width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td onclick="event.stopPropagation()">
                        <input type="checkbox" class="checkbox row-checkbox" value="{{ $b->id }}" onchange="updateBulkActions()">
                    </td>
                    <td style="cursor:pointer" onclick="openDetailModal({{ $b->id }})">
                        <span style="font-family:monospace;font-size:12px;font-weight:700;color:var(--brand)">{{ $b->booking_code }}</span>
                        @if($b->promo_code)
                            <br><span style="font-size:10px;color:var(--success)">🏷 {{ $b->promo_code }}</span>
                        @endif
                    </td>
                    <td style="cursor:pointer" onclick="openDetailModal({{ $b->id }})">
                        <div style="font-weight:600">{{ $b->name }}</div>
                        <div style="font-size:11.5px;color:var(--text-muted)">{{ $b->email }}</div>
                        <div style="font-size:11.5px;color:var(--text-muted)">{{ $b->phone }}</div>
                    </td>
                    <td style="cursor:pointer" onclick="openDetailModal({{ $b->id }})">
                        <div style="font-weight:600">{{ $b->visit_date->translatedFormat('d M Y') }}</div>
                        <div style="font-size:11.5px;color:var(--text-muted)">{{ $b->city ?: '—' }}</div>
                    </td>
                    <td style="font-size:12.5px;cursor:pointer" onclick="openDetailModal({{ $b->id }})">{{ $b->session_time }}</td>
                    <td style="cursor:pointer" onclick="openDetailModal({{ $b->id }})">
                        <div class="tkt-items">
                            @foreach($b->ticket_items as $item)
                            <div class="tkt-item-line">
                                <strong>{{ $item['qty'] }}×</strong> {{ $item['name'] }}
                            </div>
                            @endforeach
                        </div>
                    </td>
                    <td onclick="event.stopPropagation()">
                        @if($b->payment_method === 'online')
                            <span style="font-size:10.5px;background:#ff4d4f;color:#fff;padding:3px 8px;border-radius:4px;font-weight:600;white-space:nowrap;display:inline-block;">Online (Majoo)</span>
                        @elseif($b->payment_method === 'doku')
                            <span style="font-size:10.5px;background:#00539c;color:#fff;padding:3px 8px;border-radius:4px;font-weight:600;white-space:nowrap;display:inline-block;">Doku Instan</span>
                        @else
                            <span style="font-size:10.5px;background:#6b7280;color:#fff;padding:3px 8px;border-radius:4px;font-weight:600;white-space:nowrap;display:inline-block;">Walk-in (WA)</span>
                        @endif
                    </td>
                    <td style="cursor:pointer" onclick="openDetailModal({{ $b->id }})">
                        <div style="font-weight:700;color:var(--text)">{{ $b->formattedTotal() }}</div>
                        @if($b->discount_amount > 0)
                            <div style="font-size:11px;color:var(--success)">
                                − Rp {{ number_format($b->discount_amount,0,',','.') }}
                            </div>
                        @endif
                    </td>
                    <td onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.booking.ticket.updateStatus', $b) }}" class="status-form">
                            @csrf
                            <select name="status" onchange="this.form.submit()"
                                class="status-select status-{{ $b->status }}">
                                <option value="pending" @selected($b->status=='pending')>⏳ Pending</option>
                                <option value="confirmed" @selected($b->status=='confirmed')>⏳ Reservasi</option>
                                <option value="completed" @selected($b->status=='completed')>🎉 Lunas</option>
                                <option value="cancelled" @selected($b->status=='cancelled')>❌ Dibatalkan</option>
                            </select>
                        </form>
                    </td>
                    <td style="cursor:pointer;white-space:nowrap" onclick="openDetailModal({{ $b->id }})">
                        <div style="font-size:12px;font-weight:600">
                            {{ $b->created_at->format('d M Y') }}
                        </div>
                        <div style="font-size:11px;color:var(--text-muted)">
                            {{ $b->created_at->format('H:i') }} WIB
                        </div>
                        <div style="font-size:10.5px;color:var(--text-muted)">
                            {{ $b->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td onclick="event.stopPropagation()" style="text-align:center;white-space:nowrap">
                        {{-- Edit --}}
                        <button class="btn btn-sm btn-outline btn-icon-sm"
                                onclick="openEditModal({{ $b->id }})"
                                title="Edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$b->phone) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline btn-icon-sm"
                           title="Chat WhatsApp"
                           style="color:#25d366;border-color:#c8f0d8">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        {{-- Print Ticket --}}
                        <button class="btn btn-sm btn-outline btn-icon-sm"
                                onclick="printTicket({{ $b->id }})"
                                title="Print Tiket">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                        </button>
                        {{-- Hapus --}}
                        <form method="POST" action="{{ route('admin.booking.ticket.destroy', $b) }}"
                              style="display:inline"
                              onsubmit="return confirm('Hapus booking {{ $b->booking_code }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-icon-sm" title="Hapus">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                {{-- Hidden data untuk modal --}}
                <tr id="modal-data-{{ $b->id }}" style="display:none"
                    data-name="{{ $b->name }}"
                    data-code="{{ $b->booking_code }}"
                    data-email="{{ $b->email }}"
                    data-phone="{{ $b->phone }}"
                    data-city="{{ $b->city ?: '—' }}"
                    data-date="{{ $b->visit_date->translatedFormat('d F Y') }}"
                    data-sess="{{ $b->session_time }}"
                    data-total="{{ $b->formattedTotal() }}"
                    data-sub="Rp {{ number_format($b->subtotal,0,',','.') }}"
                    data-disc="{{ $b->discount_amount > 0 ? '− Rp '.number_format($b->discount_amount,0,',','.') : '—' }}"
                    data-promo="{{ $b->promo_code ?: '—' }}"
                    data-status="{{ $b->statusLabel() }}"
                    data-method="{{ $b->payment_method === 'online' ? 'Online (Majoo)' : ($b->payment_method === 'doku' ? 'Doku Instan' : 'Walk-in (WA)') }}"
                    data-created="{{ $b->created_at->format('d M Y H:i') }}"
                    data-items='@json($b->ticket_items)'
                ></tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" style="display:block;margin:0 auto 12px;opacity:.3">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Belum ada data booking
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- ═══════════ MOBILE CARDS (tampil di HP, table di-hide otomatis via CSS) ═══════════ --}}
    <div class="bk-mobile-list">
        @forelse($bookings as $b)
            <div class="bk-mobile-card">
                <div class="bk-mc-head">
                    <div style="flex:1;min-width:0;cursor:pointer;" onclick="openDetailModal({{ $b->id }})">
                        <div class="bk-mc-name">{{ $b->name }}</div>
                        <div class="bk-mc-code">
                            {{ $b->booking_code }}
                            @if($b->payment_method === 'online')
                                <span style="font-size:9px;background:#ff4d4f;color:#fff;padding:1px 4px;border-radius:3px;font-weight:600;margin-left:4px;">Online (Majoo)</span>
                            @elseif($b->payment_method === 'doku')
                                <span style="font-size:9px;background:#00539c;color:#fff;padding:1px 4px;border-radius:3px;font-weight:600;margin-left:4px;">Doku Instan</span>
                            @else
                                <span style="font-size:9px;background:#6b7280;color:#fff;padding:1px 4px;border-radius:3px;font-weight:600;margin-left:4px;">Walk-in (WA)</span>
                            @endif
                        </div>
                    </div>
                    @php
                        $statusMap = [
                            'pending'   => ['cls' => 'badge-warning', 'lbl' => 'Pending'],
                            'confirmed' => ['cls' => 'badge-warning', 'lbl' => 'Reservasi'],
                            'completed' => ['cls' => 'badge-success', 'lbl' => 'Lunas'],
                            'cancelled' => ['cls' => 'badge-danger',  'lbl' => 'Dibatalkan'],
                        ];
                        $st = $statusMap[$b->status] ?? ['cls' => 'badge-muted', 'lbl' => $b->status];
                    @endphp
                    <span class="badge {{ $st['cls'] }}">{{ $st['lbl'] }}</span>
                </div>
                <dl class="bk-mc-meta">
                    <dt>Tanggal</dt>
                    <dd>{{ $b->visit_date->translatedFormat('d M Y') }}</dd>
                    <dt>Sesi</dt>
                    <dd>{{ $b->session_time }}</dd>
                    <dt>HP</dt>
                    <dd style="font-family:var(--font-mono);">{{ $b->phone }}</dd>
                    <dt>Total</dt>
                    <dd style="font-weight:700;">{{ $b->formattedTotal() }}</dd>
                    @if($b->promo_code)
                    <dt>Promo</dt>
                    <dd style="color:var(--success-text);">{{ $b->promo_code }}</dd>
                    @endif
                </dl>
                <div class="bk-mc-actions">
                    <button class="btn btn-outline btn-sm" onclick="openDetailModal({{ $b->id }})">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Detail
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $b->phone) }}"
                       target="_blank"
                       class="btn btn-outline btn-sm"
                       style="color:#25d366;border-color:#c8f0d8;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WA
                    </a>
                    <button class="btn btn-outline btn-sm" onclick="openEditModal({{ $b->id }})">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="empty-state-title">Belum ada booking</div>
                <div class="empty-state-text">Booking baru akan muncul di sini setelah pengunjung mengisi form.</div>
            </div>
        @endforelse
    </div>
    @if($bookings->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border)">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
    @endif
</div>
{{-- Detail Modal --}}
<div class="modal-backdrop" id="detailModal" onclick="closeModal('detailModal', event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeModal('detailModal')">&times;</button>
        <div class="modal-title" id="m-title">Detail Booking</div>
        <div id="m-body"></div>
    </div>
</div>
{{-- Create/Edit Booking Modal --}}
<div class="modal-backdrop" id="createModal" onclick="closeModal('createModal', event)">
    <div class="modal-box large" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeModal('createModal')">&times;</button>
        <div class="modal-title" id="form-title">Tambah Booking Baru</div>
        <form method="POST" action="{{ route('admin.booking.ticket.store') }}" id="bookingForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="bookingId">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">No HP / WhatsApp</label>
                    <input type="text" name="phone" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kota Asal</label>
                    <input type="text" name="city" class="form-input">
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">Tanggal Kunjungan</label>
                    <input type="date" name="visit_date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label required">Sesi</label>
                    <select name="session_time" class="form-select" required>
                        <option value="">Pilih Sesi</option>
                        <option value="09:00 - 11:00">09:00 - 11:00</option>
                        <option value="11:00 - 13:00">11:00 - 13:00</option>
                        <option value="13:00 - 15:00">13:00 - 15:00</option>
                        <option value="15:00 - 17:00">15:00 - 17:00</option>
                    </select>
                </div>
            </div>
            <div class="form-grid single">
                <div class="form-group">
                    <label class="form-label required">Tiket</label>
                    <div id="ticketItems" style="display:flex;flex-direction:column;gap:8px">
                        <div style="display:flex;gap:8px;align-items:center">
                            <select class="form-select" style="flex:1" name="tickets[0][id]" required>
    <option value="">Pilih Tiket</option>
    <option value="dewasa">Domestik — Dewasa</option>
    <option value="anak">Domestik — Anak</option>
    <option value="kitas_dewasa">KITAS — Dewasa</option>
    <option value="manca_dewasa">Mancanegara — Dewasa</option>
    <option value="manca_anak">Mancanegara — Anak</option>
</select>
                            <input type="number" class="form-input" style="width:80px" name="tickets[0][qty]" placeholder="Qty" min="1" value="1">
                            <button type="button" class="btn btn-sm btn-outline" onclick="addTicketRow()">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Kode Promo</label>
                    <input type="text" name="promo_code" class="form-input" placeholder="Optional">
                </div>
                <div class="form-group">
                    <label class="form-label required">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="pending">⏳ Pending</option>
                        <option value="confirmed" selected>⏳ Reservasi</option>
                        <option value="completed">🎉 Lunas</option>
                        <option value="cancelled">❌ Dibatalkan</option>
                    </select>
                </div>
            </div>
            <div class="form-grid single">
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-textarea" placeholder="Catatan tambahan (optional)"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('createModal')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
// ── Detail Modal ──
function openDetailModal(id) {
    const r = document.getElementById('modal-data-' + id);
    if (!r) return;
    const d = r.dataset;
    const items = JSON.parse(d.items || '[]');
    const itemHtml = items.map(i =>
        `<div style="display:flex;justify-content:space-between;font-size:12.5px;padding:4px 0">
            <span>${i.name} × ${i.qty}</span>
            <span style="font-weight:600">Rp ${Number(i.subtotal).toLocaleString('id-ID')}</span>
         </div>`
    ).join('');
    document.getElementById('m-title').textContent = 'Detail Booking — ' + d.code;
    document.getElementById('m-body').innerHTML = `
        <div class="modal-row"><span class="lbl">Kode Booking</span><span class="val" style="font-family:monospace;color:var(--brand);font-weight:700">${d.code}</span></div>
        <div class="modal-row"><span class="lbl">Nama</span><span class="val">${d.name}</span></div>
        <div class="modal-row"><span class="lbl">Email</span><span class="val">${d.email}</span></div>
        <div class="modal-row"><span class="lbl">No HP / WA</span><span class="val">${d.phone}</span></div>
        <div class="modal-row"><span class="lbl">Kota Asal</span><span class="val">${d.city}</span></div>
        <div class="modal-row"><span class="lbl">Tanggal Kunjungan</span><span class="val">${d.date}</span></div>
        <div class="modal-row"><span class="lbl">Sesi</span><span class="val">${d.sess}</span></div>
        <div class="modal-row"><span class="lbl">Tiket</span><span class="val" style="flex:1">${itemHtml}</span></div>
        <div class="modal-row"><span class="lbl">Sub Total</span><span class="val">${d.sub}</span></div>
        <div class="modal-row"><span class="lbl">Diskon (${d.promo})</span><span class="val" style="color:var(--success)">${d.disc}</span></div>
        <div class="modal-row"><span class="lbl">Total</span><span class="val" style="font-weight:800;font-size:15px">${d.total}</span></div>
        <div class="modal-row"><span class="lbl">Metode Pembayaran</span><span class="val">${d.method}</span></div>
        <div class="modal-row"><span class="lbl">Status</span><span class="val">${d.status}</span></div>
        <div class="modal-row"><span class="lbl">Dipesan</span><span class="val">${d.created}</span></div>
    `;
    document.getElementById('detailModal').classList.add('open');
}
// ── Sort Table (klik header) ──
function sortTable(col) {
    const params = new URLSearchParams(window.location.search);
    const current = params.get('sort_by') || 'visit_date_asc';
    const map = {
        'visit_date': { asc: 'visit_date_asc', desc: 'visit_date_desc', default: 'visit_date_asc' },
        'created_at': { asc: 'created_asc',    desc: 'created_desc',    default: 'created_desc'   },
        'total':      { asc: 'total_asc',       desc: 'total_desc',      default: 'total_desc'     },
    };
    if (!map[col]) return;
    const next = current === map[col].asc ? map[col].desc : map[col].asc;
    params.set('sort_by', next);
    window.location.href = '{{ route("admin.booking.ticket.index") }}?' + params.toString();
}
// ── Create/Edit Modal ──
function openCreateModal() {
    document.getElementById('form-title').textContent = 'Tambah Booking Baru';
    document.getElementById('bookingForm').reset();
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('bookingId').value = '';
    document.getElementById('bookingForm').action = '{{ route("admin.booking.ticket.store") }}';
    document.getElementById('createModal').classList.add('open');
}
function openEditModal(id) {
    document.getElementById('form-title').textContent = 'Edit Booking';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('bookingId').value = id;
    document.getElementById('createModal').classList.add('open');
}
function addTicketRow() {
    const container = document.getElementById('ticketItems');
    const index = container.children.length;
    const row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:8px;align-items:center';
    row.innerHTML = `
       <select class="form-select" style="flex:1" name="tickets[${index}][id]" required>
    <option value="">Pilih Tiket</option>
    <option value="dewasa">Domestik — Dewasa</option>
    <option value="anak">Domestik — Anak</option>
    <option value="kitas_dewasa">KITAS — Dewasa</option>
    <option value="manca_dewasa">Mancanegara — Dewasa</option>
    <option value="manca_anak">Mancanegara — Anak</option>
</select>
        <input type="number" class="form-input" style="width:80px" name="tickets[${index}][qty]" placeholder="Qty" min="1" value="1">
        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    container.appendChild(row);
}
function closeModal(modalId, e) {
    if (!e || e.target === document.getElementById(modalId))
        document.getElementById(modalId).classList.remove('open');
}
// ── Bulk Actions ──
function toggleSelectAll(checkbox) {
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.checked = checkbox.checked;
        cb.closest('tr').classList.toggle('selected', checkbox.checked);
    });
    updateBulkActions();
}
function updateBulkActions() {
    const count = document.querySelectorAll('.row-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count + ' dipilih';
    document.getElementById('bulkActions').style.display = count > 0 ? 'flex' : 'none';
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.closest('tr').classList.toggle('selected', cb.checked);
    });
}
function bulkUpdateStatus() {
    const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    if (!selected.length) return;
    const status = prompt('Update status ke:\nreservasi / lunas / dibatalkan');
    const mapped = {
        'reservasi': 'confirmed',
        'lunas': 'completed',
        'dibatalkan': 'cancelled'
    };
    if (!status || !mapped[status.toLowerCase()]) {
        alert('Status tidak valid!'); return;
    }
    const value = mapped[status.toLowerCase()];
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.booking.ticket.bulkUpdateStatus") }}';
    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="status" value="${value}">`;
    selected.forEach(id => form.innerHTML += `<input type="hidden" name="ids[]" value="${id}">`);
    document.body.appendChild(form);
    form.submit();
}
function bulkDelete() {
    const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    if (!selected.length || !confirm(`Hapus ${selected.length} booking yang dipilih?`)) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.booking.ticket.bulkDestroy") }}';
    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="DELETE">`;
    selected.forEach(id => form.innerHTML += `<input type="hidden" name="ids[]" value="${id}">`);
    document.body.appendChild(form);
    form.submit();
}
// ── Export ──
function exportData(format) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', format);
    window.location.href = '{{ route("admin.booking.ticket.index") }}?' + params.toString();
}
// ── Per Page ──
function changePerPage(value) {
    const params = new URLSearchParams(window.location.search);
    params.set('per_page', value);
    window.location.href = '{{ route("admin.booking.ticket.index") }}?' + params.toString();
}
// ── Date Presets ──
function applyPreset(preset) {
    const form = document.getElementById('filterForm');
    form.querySelector('[name="date_from"]').value = '';
    form.querySelector('[name="date_to"]').value = '';
    document.getElementById('presetInput').value = preset === 'all' ? '' : preset;
    form.submit();
}
// ── Print Ticket ──
function printTicket(id) {
    window.open('{{ route("admin.booking.ticket.index") }}/' + id + '/print', '_blank');
}
// ── Keyboard Shortcuts ──
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal('detailModal'); closeModal('createModal'); }
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); document.querySelector('[name="search"]').focus(); }
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') { e.preventDefault(); openCreateModal(); }
});
// ── Hide loading ──
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('loading').style.display = 'none';
});
// ── Notifikasi Pending ──
(function () {
    const pendingCount = {{ $stats['pending'] }};
    if (pendingCount === 0) return;
    const dismissKey = 'pending_notif_dismissed_' + new Date().toDateString();
    if (sessionStorage.getItem(dismissKey)) return;
    const toast = document.createElement('div');
    toast.className = 'notif-toast';
    toast.innerHTML = `
        <div class="notif-toast-icon">
            <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="notif-toast-body">
            <div class="notif-toast-title">⏳ ${pendingCount} Booking Pending</div>
            <div class="notif-toast-msg">Segera tinjau dan konfirmasi booking yang masuk.</div>
        </div>
        <button class="notif-toast-close" id="dismissToast">&times;</button>
    `;
    toast.addEventListener('click', (e) => {
        if (e.target.id === 'dismissToast') return;
        window.location.href = '{{ route("admin.booking.ticket.index") }}?status=pending';
    });
    toast.querySelector('#dismissToast').addEventListener('click', () => {
        toast.style.cssText += 'opacity:0;transform:translateX(60px);transition:all .25s';
        sessionStorage.setItem(dismissKey, '1');
        setTimeout(() => toast.remove(), 260);
    });
    document.body.appendChild(toast);
    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.style.cssText += 'opacity:0;transform:translateX(60px);transition:all .4s';
            setTimeout(() => toast.remove(), 400);
        }
    }, 8000);
})();
</script>
@endpush

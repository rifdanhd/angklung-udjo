{{-- resources/views/admin/schedules/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Atur Jadwal & Stok')

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

/* Grid Layout */
.schedule-grid {
    display: grid;
    grid-template-columns: minmax(320px, 400px) 1fr;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1024px) {
    .schedule-grid { grid-template-columns: 1fr; }
}

/* Right-side table filters */
.table-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    background: var(--surface2);
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 12px;
}
.filter-tabs {
    display: flex;
    background: var(--surface3);
    padding: 4px;
    border-radius: 8px;
    gap: 4px;
}
.filter-tab-btn {
    padding: 6px 12px;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text-muted);
    border: none;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    transition: all var(--transition);
}
.filter-tab-btn.active {
    background: var(--surface);
    color: var(--text);
    box-shadow: var(--shadow-sm);
}

/* Predefined list card */
.default-rules-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 20px;
    margin-top: 16px;
}
.default-rule-item {
    display: flex;
    justify-content: space-between;
    font-size: 12.5px;
    border-bottom: 1px dashed var(--border);
    padding: 8px 0;
}
.default-rule-item:last-child {
    border-bottom: none;
}

/* Modal styling */
.modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,15,21,.55);
    backdrop-filter: blur(4px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: var(--surface);
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 440px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    padding: 24px;
    position: relative;
    animation: slideUp .2s cubic-bezier(.4,0,.2,1);
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px) scale(.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-close {
    position: absolute;
    top: 16px; right: 16px;
    background: var(--surface2);
    border: none;
    width: 32px; height: 32px;
    border-radius: 8px;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    transition: all var(--transition);
}
.modal-close:hover { background: var(--surface3); color: var(--text); }
.modal-header {
    margin-bottom: 20px;
}
.modal-title {
    font-size: 18px; font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
}
.form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13.5px;
    background: var(--surface);
    outline: none;
    transition: all var(--transition);
}
.form-control:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Atur Jadwal &amp; Stok Kursi</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;margin:0 4px;"><path d="M9 5l7 7-7 7"/></svg>
            Jadwal &amp; Stok
        </div>
    </div>
</div>

<div class="schedule-grid">
    
    {{-- KIRI: FORM & PANDUAN --}}
    <div>
        {{-- Card Form --}}
        <div class="card" style="padding: 20px 22px 22px;">
            <div class="card-title" style="font-size:15px; font-weight:600;">Buat Jadwal / Override</div>
            <div class="card-sub" style="font-size:12.5px; color:var(--text-muted); margin:4px 0 16px;">
                Tentukan jadwal khusus atau bulk update kapasitas kursi.
            </div>

            <form action="{{ route('admin.schedules.store') }}" method="POST" id="main-schedule-form">
                @csrf
                <input type="hidden" name="session_time" id="hidden_session_time">

                {{-- Tanggal Mulai & Selesai --}}
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" required min="{{ now()->toDateString() }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Selesai (Opsional)</label>
                    <input type="date" name="end_date" class="form-control" placeholder="Isi untuk rentang tanggal">
                    <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">
                        Kosongkan jika hanya ingin mengatur untuk 1 hari saja.
                    </div>
                </div>

                {{-- Tipe Sesi --}}
                <div class="form-group">
                    <label>Sesi Pertunjukan</label>
                    <select name="session_id" id="session_id_select" class="form-control" required onchange="handleSessionChange(this)">
                        <option value="" disabled selected>Pilih Sesi...</option>
                        <option value="pagi" data-time="10.00 - 11.30 WIB">Sesi Pagi (10.00 – 11.30 WIB)</option>
                        <option value="siang" data-time="13.00 - 14.30 WIB">Sesi Siang (13.00 – 14.30 WIB)</option>
                        <option value="sore" data-time="15.30 - 17.00 WIB">Sesi Sore (15.30 – 17.00 WIB)</option>
                        <option value="reg" data-time="15.30 - 17.00 WIB">Regular Show (15.30 – 17.00 WIB)</option>
                        <option value="custom">Kustom (Tentukan Sendiri)</option>
                    </select>
                </div>

                {{-- Custom Session Fields --}}
                <div id="custom-session-wrapper" style="display:none; padding:12px; background:var(--surface2); border:1px solid var(--border); border-radius:var(--radius-sm); margin-bottom:16px;">
                    <div class="form-group">
                        <label>ID Sesi Kustom</label>
                        <input type="text" id="custom_session_id" class="form-control" placeholder="e.g. malam, spesial_konser">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Waktu Sesi Kustom</label>
                        <input type="text" id="custom_session_time" class="form-control" placeholder="e.g. 19.00 - 20.30 WIB">
                    </div>
                </div>

                {{-- Kapasitas Kursi --}}
                <div class="form-group">
                    <label>Kapasitas Kursi</label>
                    <input type="number" name="capacity" value="20" min="1" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; margin-top:20px;">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px;margin-right:6px;"><path d="M12 4v16m8-8H4"/></svg>
                    Simpan Konfigurasi
                </button>
            </form>
        </div>

        {{-- Card Panduan Default --}}
        <div class="default-rules-card">
            <div style="font-weight:600; font-size:13.5px; color:var(--text); margin-bottom:10px; display:inline-flex; align-items:center; gap:6px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Jadwal Default Saung Angklung Udjo
            </div>
            <div style="font-size:12px; color:var(--text-muted); margin-bottom:12px;">
                Hari-hari berikut berjalan otomatis menggunakan jadwal bawaan jika tidak di-override di sini:
            </div>
            
            <div class="default-rule-item">
                <span style="font-weight:600;">Senin – Jumat</span>
                <span>Regular Show (15.30 - 17.00)</span>
            </div>
            <div class="default-rule-item">
                <span style="font-weight:600;">Sabtu</span>
                <span>Siang (13.00) &amp; Sore (15.30)</span>
            </div>
            <div class="default-rule-item">
                <span style="font-weight:600;">Minggu</span>
                <span>Pagi (10.00) &amp; Sore (15.30)</span>
            </div>
            <div class="default-rule-item" style="color:var(--text-muted);">
                <span>Kapasitas Bawaan:</span>
                <span style="font-weight:600;">{{ $defaultCapacity }} Kursi / Sesi</span>
            </div>
        </div>

        {{-- Card Kapasitas Default --}}
        <div class="card" style="padding: 16px 20px; margin-top: 16px;">
            <div style="font-weight:600; font-size:13.5px; color:var(--text); margin-bottom:8px; display:inline-flex; align-items:center; gap:6px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                Atur Kapasitas Default Sistem
            </div>
            <div style="font-size:12px; color:var(--text-muted); margin-bottom:12px;">
                Ubah kapasitas bawaan global untuk seluruh hari yang tidak di-override.
            </div>
            <form action="{{ route('admin.schedules.update-default-capacity') }}" method="POST" style="margin:0;">
                @csrf
                <div style="display:flex; gap:8px; align-items:center;">
                    <div style="flex:1;">
                        <input type="number" name="default_capacity" value="{{ $defaultCapacity }}" min="1" class="form-control" required style="padding: 7px 10px; font-size:13px;">
                    </div>
                    <button type="submit" class="btn btn-outline" style="padding: 7px 12px; font-size:12.5px; height:auto;">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- KANAN: TABLE TERDAFTAR --}}
    <div class="card">
        <div class="table-filter-bar">
            <div>
                <div class="card-title" style="font-size:15px; font-weight:600;">Jadwal Khusus Terdaftar</div>
                <div class="card-sub" style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                    Kapasitas overrides yang aktif pada tanggal tertentu
                </div>
            </div>

            <div class="filter-tabs">
                <a href="{{ route('admin.schedules.index') }}?filter=upcoming" class="filter-tab-btn {{ request('filter') !== 'past' ? 'active' : '' }}">
                    Jadwal Mendatang
                </a>
                <a href="{{ route('admin.schedules.index') }}?filter=past" class="filter-tab-btn {{ request('filter') === 'past' ? 'active' : '' }}">
                    Riwayat Lampau
                </a>
            </div>
        </div>

        @if(request('filter') === 'past' && $schedules->total() > 0)
        <div style="padding:12px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:flex-end;">
            <form action="{{ route('admin.schedules.clear-past') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh jadwal lampau?')">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:13px;height:13px;margin-right:6px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Bersihkan Semua Jadwal Lampau
                </button>
            </form>
        </div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Sesi</th>
                        <th>Waktu Pertunjukan</th>
                        <th>Kapasitas Kursi</th>
                        <th style="width:120px; text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $s)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ \Carbon\Carbon::parse($s->date)->translatedFormat('d M Y') }}</div>
                            <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                                {{ \Carbon\Carbon::parse($s->date)->translatedFormat('l') }}
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($s->session_id) {
                                    'pagi'  => 'badge-info',
                                    'siang' => 'badge-warning',
                                    'sore'  => 'badge-brand',
                                    'reg'   => 'badge-success',
                                    default => 'badge-muted',
                                };
                                $label = match($s->session_id) {
                                    'pagi'  => 'Pagi',
                                    'siang' => 'Siang',
                                    'sore'  => 'Sore',
                                    'reg'   => 'Regular',
                                    default => strtoupper($s->session_id),
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                        </td>
                        <td style="font-family:var(--font-mono); font-size:12.5px; font-weight:600;">
                            {{ $s->session_time }}
                        </td>
                        <td>
                            <span class="badge badge-outline" style="font-weight:700;">
                                {{ $s->capacity }} Kursi
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:flex-end;">
                                <button onclick="openEditModal({{ $s->toJson() }})" class="btn btn-outline btn-sm btn-icon-sm" title="Edit Jadwal">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.schedules.destroy', $s) }}" method="POST" onsubmit="return confirm('Kembalikan ke jadwal default untuk sesi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-sm" title="Hapus Override">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:48px; color:var(--text-muted);">
                            Tidak ada jadwal khusus terdaftar. Seluruh tanggal berjalan otomatis mengikuti jadwal default.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            {{ $schedules->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>

{{-- MODAL QUICK EDIT --}}
<div class="modal-backdrop" id="edit-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="closeEditModal()">×</button>
        <div class="modal-header">
            <h2 class="modal-title">Edit Jadwal Khusus</h2>
            <div style="font-size:12.5px;color:var(--text-muted);" id="edit-subtitle"></div>
        </div>

        <form id="edit-form" method="POST">
            @csrf @method('PUT')

            <div class="form-group">
                <label>Waktu Sesi</label>
                <input type="text" name="session_time" id="edit-session-time" class="form-control" required placeholder="e.g. 15.30 - 17.00 WIB">
            </div>

            <div class="form-group">
                <label>Kapasitas Kursi</label>
                <input type="number" name="capacity" id="edit-capacity" class="form-control" required min="1">
            </div>

            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:24px;border-top:1px solid var(--border);padding-top:16px;">
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Main Form Handle custom session select toggle
const hiddenTime = document.getElementById('hidden_session_time');
const sessionSelect = document.getElementById('session_id_select');
const customWrapper = document.getElementById('custom-session-wrapper');
const customIdField = document.getElementById('custom_session_id');
const customTimeField = document.getElementById('custom_session_time');
const mainForm = document.getElementById('main-schedule-form');

function handleSessionChange(select) {
    const selectedOpt = select.options[select.selectedIndex];
    
    if (select.value === 'custom') {
        customWrapper.style.display = 'block';
        customIdField.required = true;
        customTimeField.required = true;
    } else {
        customWrapper.style.display = 'none';
        customIdField.required = false;
        customTimeField.required = false;
        
        // Auto-assign predefined times
        hiddenTime.value = selectedOpt.dataset.time || '';
    }
}

// On submit main form
mainForm.addEventListener('submit', function (e) {
    if (sessionSelect.value === 'custom') {
        // Override the select's name with the custom id & time
        // We modify the value of select to custom session ID
        sessionSelect.value = customIdField.value.trim().toLowerCase().replace(/\s+/g, '_');
        hiddenTime.value = customTimeField.value.trim();
    }
});

// Modal Actions
const backdrop = document.getElementById('edit-backdrop');
const editForm = document.getElementById('edit-form');

function openEditModal(schedule) {
    document.getElementById('edit-subtitle').textContent = `Jadwal Tanggal ${formatDate(schedule.date)} - Sesi ${schedule.session_id.toUpperCase()}`;
    
    editForm.action = `/admin/schedules/${schedule.id}`;
    document.getElementById('edit-session-time').value = schedule.session_time || '';
    document.getElementById('edit-capacity').value = schedule.capacity || 20;

    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target === backdrop) closeEditModal();
}

function formatDate(dateStr) {
    const d = new Date(dateStr);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
}

// Keyboard ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEditModal(); });
</script>
@endpush

@extends('admin.layouts.app')
@section('title', 'Kuota Booking Online')
@push('styles')
<style>
/* ═══ STAT CARDS ═══ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
.filter-bar { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.filter-bar input {
    padding: 8px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font); font-size: 13px;
    background: var(--surface); outline: none;
    min-height: 38px; transition: all var(--transition);
    color: var(--text);
}
.filter-bar input:focus {
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
}

/* ═══ TABLE CONTROLS ═══ */
.table-controls {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; gap: 12px; align-items: center; justify-content: space-between;
    background: var(--surface2);
    flex-wrap: wrap;
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
    width: 100%; max-width: 450px; max-height: 90vh;
    overflow-y: auto; box-shadow: var(--shadow-lg);
    padding: 22px 24px; position: relative;
    animation: slideUp .25s cubic-bezier(.4,0,.2,1);
}
.modal-close {
    position: absolute; right: 18px; top: 18px;
    width: 28px; height: 28px; border-radius: 50%;
    border: none; background: transparent;
    font-size: 20px; color: var(--text-muted);
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all var(--transition);
}
.modal-close:hover { background: var(--surface3); color: var(--text); }
.modal-title {
    font-size: 15px; font-weight: 700; color: var(--text);
    margin-bottom: 20px; padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
}

/* ═══ FORM ═══ */
.form-grid { display: grid; grid-template-columns: 1fr; gap: 12px; margin-bottom: 12px; }
.form-group { display: flex; flex-direction: column; }
.form-input, .form-select {
    width: 100%; padding: 9px 12px;
    border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
    font-family: var(--font); font-size: 13.5px;
    background: var(--surface); outline: none; transition: all var(--transition);
    color: var(--text);
}
.form-input:focus, .form-select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.form-label { display: block; font-size: 12.5px; font-weight: 500; color: var(--text); margin-bottom: 5px; }
.form-label.required::after { content: " *"; color: var(--danger); }
.modal-footer {
    display: flex; gap: 8px; justify-content: flex-end;
    padding-top: 14px; border-top: 1px solid var(--border); margin-top: 16px;
}

@media (max-width: 640px) {
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
.bk-mc-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 10px; margin-bottom: 10px;
}
.bk-mc-name { font-weight: 600; font-size: 14px; color: var(--text); }
.bk-mc-meta {
    display: grid; grid-template-columns: auto 1fr;
    gap: 4px 10px; font-size: 12.5px; margin-bottom: 10px;
}
.bk-mc-meta dt { color: var(--text-muted); font-weight: 500; }
.bk-mc-meta dd { color: var(--text); font-weight: 500; text-align: right; }
.bk-mc-actions {
    display: flex; gap: 6px;
    margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border);
}
.bk-mc-actions .btn { flex: 1; min-height: 38px; justify-content: center; }
.bk-mc-actions form { flex: 1; display: flex; }
.bk-mc-actions form button { width: 100%; }
</style>
@endpush

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;gap:12px;flex-wrap:wrap;">
    <div>
        <h1 style="font-size:18px;font-weight:700;color:var(--text);letter-spacing: -.3px;">Kuota Booking Online</h1>
        <p style="font-size:12px;color:var(--text-muted);margin-top:2px;">Atur kapasitas maksimal harian dan status buka/tutup booking online</p>
    </div>
    <div>
        <button class="btn btn-primary" onclick="openCreateModal()" style="display:inline-flex;align-items:center;gap:6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kuota Khusus
        </button>
    </div>
</div>

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="color:var(--brand);background:var(--brand-soft)">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm14-5h-8m8 4h-8m8 4h-8"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $todayCapacity }}</div>
            <div class="stat-lbl">Kuota Hari Ini</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="color:var(--info);background:var(--info-soft)">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239a9 9 0 0112.573 12.574m-2.122-2.122a6 6 0 00-8.302-8.303"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val">{{ $todayUsed }}</div>
            <div class="stat-lbl">Total Klik Terpakai</div>
        </div>
    </div>

    <div class="stat-card">
        @php
            $todayRemaining = $todayCapacity - $todayUsed;
            $remainingColor = $todayRemaining <= 0 ? 'var(--danger)' : ($todayRemaining <= 5 ? 'var(--warning)' : 'var(--success)');
            $remainingBg = $todayRemaining <= 0 ? 'var(--danger-soft)' : ($todayRemaining <= 5 ? 'var(--warning-soft)' : 'var(--success-soft)');
        @@endphp
        <div class="stat-icon" style="color:{{ $remainingColor }};background:{{ $remainingBg }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val" style="color:{{ $remainingColor }}">{{ max(0, $todayRemaining) }}</div>
            <div class="stat-lbl">Sisa Slot Hari Ini</div>
        </div>
    </div>

    <div class="stat-card">
        @php
            $statusColor = $todayStatus === 'Buka' ? 'var(--success)' : 'var(--danger)';
            $statusBg = $todayStatus === 'Buka' ? 'var(--success-soft)' : 'var(--danger-soft)';
        @@endphp
        <div class="stat-icon" style="color:{{ $statusColor }};background:{{ $statusBg }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.071m7.071 0a5 5 0 010 7.07m-4.243-1.414a1 1 0 110-2 1 1 0 010 2z"/>
            </svg>
        </div>
        <div class="stat-content">
            <div class="stat-val" style="color:{{ $statusColor }}">{{ $todayStatus }}</div>
            <div class="stat-lbl">Status Booking Hari Ini</div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<form method="GET" action="{{ route('admin.booking.online') }}" class="filter-section">
    <div class="filter-header">
        <span class="filter-title">Filter Rentang Tanggal</span>
    </div>
    <div class="filter-bar">
        <div class="date-range">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input" placeholder="Dari Tanggal">
            <span style="color:var(--text-muted);font-size:12px;">s/d</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input" placeholder="Sampai Tanggal">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request()->anyFilled(['date_from', 'date_to']))
            <a href="{{ route('admin.booking.online') }}" class="btn btn-outline">Reset</a>
        @endif
    </div>
</form>

<!-- DATA CONTAINER -->
<div class="card" style="margin-bottom: 24px;">
    <div class="bk-table-desktop">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th style="text-align: center;">Kapasitas</th>
                        <th style="text-align: center;">Klik Terpakai</th>
                        <th style="text-align: center;">Sisa Slot</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($counters as $counter)
                        @php
                            $dateVal = $counter->tanggal instanceof \Carbon\Carbon ? $counter->tanggal : \Carbon\Carbon::parse($counter->tanggal);
                            $isToday = $dateVal->isToday();
                            $remaining = $counter->kapasitas - $counter->total_klik;
                        @@endphp
                        <tr style="{{ $isToday ? 'background: rgba(26,20,69,.03); font-weight: 600;' : '' }}">
                            <td>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <span>{{ $dateVal->translatedFormat('d F Y') }}</span>
                                    @if($isToday)
                                        <span class="badge badge-brand" style="font-size:9px;padding:1px 5px;">HARI INI</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center; font-family:var(--font-mono)">{{ $counter->kapasitas }}</td>
                            <td style="text-align: center; font-family:var(--font-mono)">{{ $counter->total_klik }}</td>
                            <td style="text-align: center; font-family:var(--font-mono)">
                                <span style="color: {{ $remaining <= 0 ? 'var(--danger-text)' : ($remaining <= 5 ? 'var(--warning-text)' : 'var(--text)') }}">
                                    {{ max(0, $remaining) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @if($counter->is_closed)
                                    <span class="badge badge-danger">Tutup</span>
                                @else
                                    <span class="badge badge-success">Buka</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display:inline-flex;gap:6px;align-items:center;">
                                    <form method="POST" action="{{ route('admin.booking.online.toggle', $counter->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $counter->is_closed ? 'btn-outline' : 'btn-danger' }}" style="padding: 4px 8px; font-size:11px;">
                                            {{ $counter->is_closed ? 'Buka Kuota' : 'Tutup Kuota' }}
                                        </button>
                                    </form>
                                    <button class="btn btn-outline btn-sm" style="padding: 4px 8px; font-size:11px;"
                                        onclick="openEditModal({{ $counter->id }}, '{{ $counter->tanggal->toDateString() }}', {{ $counter->kapasitas }}, {{ $counter->is_closed ? 1 : 0 }})">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px 16px; color: var(--text-muted);">
                                Tidak ada data kuota online. Kuota otomatis menggunakan setelan default (20 slot/hari).
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARD LIST -->
    <div class="bk-mobile-list">
        @forelse($counters as $counter)
            @php
                $dateVal = $counter->tanggal instanceof \Carbon\Carbon ? $counter->tanggal : \Carbon\Carbon::parse($counter->tanggal);
                $isToday = $dateVal->isToday();
                $remaining = $counter->kapasitas - $counter->total_klik;
            @@endphp
            <div class="bk-mobile-card" style="{{ $isToday ? 'border-color: var(--accent); background: rgba(26,20,69,.01);' : '' }}">
                <div class="bk-mc-head">
                    <span class="bk-mc-name" style="font-size:13.5px; display:inline-flex; align-items:center; gap:6px;">
                        {{ $dateVal->translatedFormat('d M Y') }}
                        @if($isToday)
                            <span class="badge badge-brand" style="font-size:9px;padding:1px 5px;">HARI INI</span>
                        @endif
                    </span>
                    @if($counter->is_closed)
                        <span class="badge badge-danger">Tutup</span>
                    @else
                        <span class="badge badge-success">Buka</span>
                    @endif
                </div>
                <dl class="bk-mc-meta">
                    <dt>Kapasitas</dt>
                    <dd>{{ $counter->kapasitas }}</dd>
                    
                    <dt>Klik Terpakai</dt>
                    <dd>{{ $counter->total_klik }}</dd>
                    
                    <dt>Sisa Slot</dt>
                    <dd style="color: {{ $remaining <= 0 ? 'var(--danger-text)' : ($remaining <= 5 ? 'var(--warning-text)' : 'var(--text)') }}">
                        {{ max(0, $remaining) }}
                    </dd>
                </dl>
                <div class="bk-mc-actions">
                    <form method="POST" action="{{ route('admin.booking.online.toggle', $counter->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $counter->is_closed ? 'btn-outline' : 'btn-danger' }}">
                            {{ $counter->is_closed ? 'Buka' : 'Tutup' }}
                        </button>
                    </form>
                    <button class="btn btn-outline btn-sm"
                        onclick="openEditModal({{ $counter->id }}, '{{ $counter->tanggal->toDateString() }}', {{ $counter->kapasitas }}, {{ $counter->is_closed ? 1 : 0 }})">
                        Edit
                    </button>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 24px 16px; color: var(--text-muted); font-size:13px; background:var(--surface); border-radius:8px; border:1px solid var(--border);">
                Tidak ada data kuota online.
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($counters->hasPages())
        <div class="table-controls" style="border-top: 1px solid var(--border); border-bottom: none; background: transparent;">
            <div></div>
            <div>
                {{ $counters->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>

<!-- CREATE MODAL -->
<div class="modal-backdrop" id="createModal" onclick="closeModal('createModal', event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeModal('createModal')">&times;</button>
        <div class="modal-title">Tambah Kuota Khusus</div>
        
        <form method="POST" action="{{ route('admin.booking.online.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" required value="{{ today()->addDay()->toDateString() }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-input" required min="0" value="20">
                </div>

                <div class="form-group">
                    <label class="form-label required">Status</label>
                    <select name="is_closed" class="form-select" required>
                        <option value="0">Buka (Terima Booking)</option>
                        <option value="1">Tutup (Online Disabled)</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('createModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-backdrop" id="editModal" onclick="closeModal('editModal', event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="closeModal('editModal')">&times;</button>
        <div class="modal-title">Edit Kuota Online</div>
        
        <form method="POST" id="editForm" action="">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="text" id="editTanggalText" class="form-input" disabled style="background:var(--surface2)">
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Kapasitas</label>
                    <input type="number" name="kapasitas" id="editKapasitas" class="form-input" required min="0">
                </div>

                <div class="form-group">
                    <label class="form-label required">Status</label>
                    <select name="is_closed" id="editIsClosed" class="form-select" required>
                        <option value="0">Buka (Terima Booking)</option>
                        <option value="1">Tutup (Online Disabled)</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('createModal').classList.add('open');
}

function openEditModal(id, tanggal, kapasitas, isClosed) {
    const form = document.getElementById('editForm');
    form.action = `{{ url('admin/booking-tickets/online') }}/${id}`;
    
    document.getElementById('editTanggalText').value = formatDateIndo(tanggal);
    document.getElementById('editKapasitas').value = kapasitas;
    document.getElementById('editIsClosed').value = isClosed;
    
    document.getElementById('editModal').classList.add('open');
}

function closeModal(modalId, e) {
    if (!e || e.target === document.getElementById(modalId)) {
        document.getElementById(modalId).classList.remove('open');
    }
}

function formatDateIndo(dateStr) {
    const d = new Date(dateStr);
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
}
</script>
@endsection

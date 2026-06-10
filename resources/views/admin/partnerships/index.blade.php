{{-- resources/views/admin/partnerships/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Manajemen Kemitraan')

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

/* Filter section */
.filter-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 14px 16px;
    margin-bottom: 16px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}
.filter-section input,
.filter-section select {
    padding: 8px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13px;
    background: var(--surface);
    outline: none;
    min-height: 38px;
    transition: all var(--transition);
}
.filter-section input:focus,
.filter-section select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.filter-section input[type="search"] { flex: 1; min-width: 180px; }

/* Modal styles */
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
    max-width: 560px;
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
.detail-grid {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 12px;
}
.detail-item {
    border-bottom: 1.5px solid var(--border);
    padding-bottom: 12px;
}
.detail-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.detail-label {
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-muted);
    font-weight: 600;
    margin-bottom: 4px;
}
.detail-val {
    font-size: 13.5px;
    color: var(--text);
    font-weight: 500;
    line-height: 1.5;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Kemitraan (Partnership)</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;margin:0 4px;"><path d="M9 5l7 7-7 7"/></svg>
            Kemitraan
        </div>
    </div>
</div>

{{-- Filter Section --}}
<form action="{{ route('admin.partnerships.index') }}" method="GET" class="filter-section">
    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama travel, PIC, nomor WhatsApp, alamat...">
    
    <select name="status_kunjungan" onchange="this.form.submit()">
        <option value="">Semua Status Kunjungan</option>
        <option value="pernah" {{ request('status_kunjungan') == 'pernah' ? 'selected' : '' }}>Pernah Kunjung</option>
        <option value="belum" {{ request('status_kunjungan') == 'belum' ? 'selected' : '' }}>Belum Pernah</option>
    </select>

    @if(request('search') || request('status_kunjungan'))
        <a href="{{ route('admin.partnerships.index') }}" class="btn btn-outline" style="min-height:38px;">Reset</a>
    @endif
    <button type="submit" class="btn btn-primary" style="min-height:38px;">Filter</button>
</form>

{{-- Table Card --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Pengajuan Kemitraan</div>
            <div class="card-sub">Menampilkan instansi dan travel agent yang mengajukan kemitraan</div>
        </div>
        <span class="badge badge-brand">{{ $partnerships->total() }} Pengajuan</span>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Travel / Instansi</th>
                    <th>Nama PIC</th>
                    <th>No. WhatsApp</th>
                    <th>Kunjungan</th>
                    <th>Rencana Tanggal</th>
                    <th>Tanggal Masuk</th>
                    <th style="width:120px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partnerships as $partner)
                <tr>
                    <td>
                        <div style="font-weight:600;">{{ $partner->nama_travel }}</div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:2px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $partner->alamat }}
                        </div>
                    </td>
                    <td style="font-weight:500;">{{ $partner->nama_pic }}</td>
                    <td>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $partner->no_wa) }}" target="_blank" style="color:var(--accent);text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.5-5.739-1.453L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.965C16.428 2.016 13.99 1.01 11.993 1.01c-5.452 0-9.88 4.419-9.885 9.851-.001 1.748.467 3.456 1.353 5.004l-.995 3.633 3.73-.973zm13.109-7.37c-.3-.15-1.771-.875-2.028-.969-.258-.094-.446-.14-.633.14-.187.28-.726.912-.89 1.092-.163.18-.326.2-.626.05-1.366-.68-2.39-1.2-3.23-2.645-.224-.388.224-.36.642-1.196.07-.14.03-.263-.02-.363-.05-.1-.446-1.073-.61-1.472-.16-.388-.324-.336-.446-.342-.115-.006-.247-.007-.38-.007-.132 0-.348.05-.53.25-.182.2-.695.68-.695 1.66 0 .98.71 1.926.81 2.059.1.133 1.4 2.137 3.39 2.992.473.203.84.324 1.127.417.475.152.907.13 1.248.078.38-.058 1.77-.723 2.02-.142.25-.58.25-1.077.17-1.173-.07-.095-.25-.15-.55-.3z"/></svg>
                            {{ $partner->no_wa }}
                        </a>
                    </td>
                    <td>
                        <span class="badge {{ $partner->status_kunjungan == 'pernah' ? 'badge-success' : 'badge-info' }}">
                            {{ $partner->status_kunjungan == 'pernah' ? 'Pernah' : 'Belum Pernah' }}
                        </span>
                    </td>
                    <td style="font-weight:600;">
                        {{ $partner->rencana_kunjungan ? \Carbon\Carbon::parse($partner->rencana_kunjungan)->format('d M Y') : '—' }}
                    </td>
                    <td style="color:var(--text-muted);">
                        {{ $partner->created_at->format('d M Y H:i') }}
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <button onclick="openDetailModal({{ $partner->toJson() }}, '{{ $partner->created_at->format('d M Y H:i') }}')" class="btn btn-outline btn-sm btn-icon-sm" title="Lihat Detail">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <form action="{{ route('admin.partnerships.destroy', $partner) }}" method="POST" onsubmit="return confirm('Hapus data kemitraan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-sm" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:56px;color:var(--text-muted);">
                        Belum ada pengajuan kemitraan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($partnerships->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--border);">
        {{ $partnerships->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- DETAIL MODAL --}}
<div class="modal-backdrop" id="detail-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="closeDetailModal()">×</button>
        <div class="modal-header">
            <h2 class="modal-title">Detail Pengajuan Kemitraan</h2>
            <div style="font-size:12.5px;color:var(--text-muted);" id="detail-created-at"></div>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Nama Travel / Instansi</div>
                <div class="detail-val" id="detail-nama-travel"></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Nama PIC</div>
                <div class="detail-val" id="detail-nama-pic"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Alamat</div>
                <div class="detail-val" id="detail-alamat"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">WhatsApp</div>
                <div class="detail-val">
                    <a id="detail-wa-link" href="" target="_blank" style="color:var(--accent);text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                        <span id="detail-wa-val"></span>
                    </a>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Status Kunjungan</div>
                <div class="detail-val" id="detail-status-kunjungan"></div>
            </div>

            <div class="detail-item" id="detail-kapan-pernah-wrapper">
                <div class="detail-label">Terakhir Kunjung</div>
                <div class="detail-val" id="detail-kapan-pernah"></div>
            </div>

            <div class="detail-item" id="detail-rencana-wrapper">
                <div class="detail-label">Rencana Kunjungan</div>
                <div class="detail-val" id="detail-rencana"></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Sumber Informasi</div>
                <div class="detail-val" id="detail-sumber-info"></div>
            </div>

            <div class="detail-item" id="detail-sumber-lainnya-wrapper">
                <div class="detail-label">Sumber Info Lainnya</div>
                <div class="detail-val" id="detail-sumber-lainnya"></div>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;margin-top:24px;">
            <button class="btn btn-outline" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const backdrop = document.getElementById('detail-backdrop');

function openDetailModal(partner, formattedDate) {
    document.getElementById('detail-created-at').textContent = 'Dikirim pada: ' + formattedDate;
    document.getElementById('detail-nama-travel').textContent = partner.nama_travel || '—';
    document.getElementById('detail-nama-pic').textContent = partner.nama_pic || '—';
    document.getElementById('detail-alamat').textContent = partner.alamat || '—';
    
    // WhatsApp
    const waClean = (partner.no_wa || '').replace(/[^0-9]/g, '');
    document.getElementById('detail-wa-link').href = 'https://wa.me/' + waClean;
    document.getElementById('detail-wa-val').textContent = partner.no_wa || '—';

    // Status Kunjungan
    if (partner.status_kunjungan === 'pernah') {
        document.getElementById('detail-status-kunjungan').innerHTML = '<span class="badge badge-success">Pernah Berkunjung</span>';
        document.getElementById('detail-kapan-pernah-wrapper').style.display = 'block';
        document.getElementById('detail-kapan-pernah').textContent = partner.kapan_pernah || '—';
        document.getElementById('detail-rencana-wrapper').style.display = 'none';
    } else {
        document.getElementById('detail-status-kunjungan').innerHTML = '<span class="badge badge-info">Belum Pernah Berkunjung</span>';
        document.getElementById('detail-kapan-pernah-wrapper').style.display = 'none';
        document.getElementById('detail-rencana-wrapper').style.display = 'block';
        document.getElementById('detail-rencana').textContent = partner.rencana_kunjungan ? formatDate(partner.rencana_kunjungan) : '—';
    }

    // Sumber info
    document.getElementById('detail-sumber-info').textContent = partner.sumber_info || '—';
    if (partner.sumber_info_lainnya) {
        document.getElementById('detail-sumber-lainnya-wrapper').style.display = 'block';
        document.getElementById('detail-sumber-lainnya').textContent = partner.sumber_info_lainnya;
    } else {
        document.getElementById('detail-sumber-lainnya-wrapper').style.display = 'none';
    }

    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target === backdrop) closeDetailModal();
}

function formatDate(dateStr) {
    const d = new Date(dateStr);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
}

// Keyboard ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetailModal(); });
</script>
@endpush

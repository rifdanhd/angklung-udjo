{{-- resources/views/admin/events/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Manajemen Events')

@push('styles')
<style>
    .ev-img-thumb {
        width: 54px; height: 72px;
        object-fit: cover;
        border-radius: 8px;
        background: var(--surface2);
        flex-shrink: 0;
    }
    .drag-handle {
        cursor: grab;
        color: var(--text-muted);
        padding: 4px 6px;
        border-radius: 6px;
        transition: background var(--transition);
    }
    .drag-handle:active { cursor: grabbing; }
    .drag-handle:hover  { background: var(--surface2); }
    .sortable-ghost { opacity: .4; background: var(--accent-soft) !important; }

    /* ── MODAL ── */
    .modal-backdrop {
        position: fixed; inset: 0;
        background: rgba(10,8,30,.55);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    .modal-backdrop.open { display: flex; }

    .modal-box {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: 0 24px 80px rgba(34,24,93,.22);
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        overflow-y: auto;
        animation: modalIn .25s cubic-bezier(.16,1,.3,1);
    }
    @keyframes modalIn {
        from { opacity:0; transform: scale(.95) translateY(12px); }
        to   { opacity:1; transform: scale(1) translateY(0); }
    }

    .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; background: var(--surface); z-index: 1;
    }
    .modal-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; }
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        display: flex; justify-content: flex-end; gap: 10px;
        position: sticky; bottom: 0; background: var(--surface);
    }

    .close-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: none; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); transition: all var(--transition);
    }
    .close-btn:hover { background: var(--surface2); color: var(--text); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:580px){ .form-grid { grid-template-columns: 1fr; } }

    /* Image Preview */
    .img-preview-wrap {
        width: 110px; height: 148px;
        border-radius: var(--radius-sm);
        border: 2px dashed var(--border);
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface2);
        cursor: pointer;
        transition: border-color var(--transition);
        flex-shrink: 0;
    }
    .img-preview-wrap:hover { border-color: var(--accent); }
    .img-preview-wrap img { width:100%; height:100%; object-fit:cover; }
    .img-placeholder {
        display: flex; flex-direction: column; align-items: center;
        gap: 6px; color: var(--text-muted); font-size: 11px; text-align: center; padding: 10px;
    }

    /* Toggle */
    .toggle-switch { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; }
    .toggle-switch input { display: none; }
    .toggle-track {
        width: 40px; height: 22px; background: var(--border);
        border-radius: 11px; position: relative; transition: background var(--transition);
    }
    .toggle-track::after {
        content:''; position: absolute; top: 3px; left: 3px;
        width: 16px; height: 16px; border-radius: 50%; background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
        transition: transform var(--transition);
    }
    input:checked + .toggle-track { background: var(--success); }
    input:checked + .toggle-track::after { transform: translateX(18px); }

    .status-badge-active   { background: var(--success-soft); color: #1a7a4a; }
    .status-badge-inactive { background: #eeeef5; color: var(--text-muted); }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Events</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            Events
        </div>
    </div>
    <button onclick="openModal()" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Tambah Event
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Events</div>
            <div class="card-sub">Drag baris untuk mengubah urutan tampilan di website</div>
        </div>
        <span class="badge badge-brand">{{ $events->count() }} Event</span>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:36px;"></th>
                    <th style="width:64px;">Foto</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="sortable-events">
                @forelse($events as $event)
                <tr data-id="{{ $event->id }}">
                    <td>
                        <span class="drag-handle" title="Drag untuk reorder">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="9"  cy="5"  r="1.2"/><circle cx="15" cy="5"  r="1.2"/>
                                <circle cx="9"  cy="12" r="1.2"/><circle cx="15" cy="12" r="1.2"/>
                                <circle cx="9"  cy="19" r="1.2"/><circle cx="15" cy="19" r="1.2"/>
                            </svg>
                        </span>
                    </td>
                    <td>
                        @if($event->image_path)
                            <img src="{{ Storage::url($event->image_path) }}" class="ev-img-thumb" alt="">
                        @else
                            <div class="ev-img-thumb" style="display:flex;align-items:center;justify-content:center;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="color:var(--text-muted)">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 16l5-5 4 4 3-3 5 5"/>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $event->title }}</div>
                        @if($event->description)
                        <div style="font-size:12px;color:var(--text-muted);margin-top:2px;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ $event->description }}
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($event->category)
                            <span class="badge badge-brand">{{ $event->category }}</span>
                        @else
                            <span style="color:var(--text-muted);">—</span>
                        @endif
                    </td>
                    <td style="font-weight:600;white-space:nowrap;">{{ $event->event_date ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $event->is_active ? 'badge-success' : 'badge-muted' }}">
                            {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            {{-- Edit: populate modal --}}
                            <button onclick="openModal({{ $event->toJson() }})"
                                class="btn btn-outline btn-sm btn-icon-sm" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            {{-- Delete --}}
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus event ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-sm" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:56px;color:var(--text-muted);">
                        Belum ada event.
                        <button onclick="openModal()" style="color:var(--accent);background:none;border:none;cursor:pointer;font-weight:600;">
                            Tambah sekarang
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL CREATE / EDIT
══════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modal-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-box" id="modal-box">

        {{-- Header --}}
        <div class="modal-header">
            <div>
                <div class="card-title" id="modal-title">Tambah Event</div>
                <div class="card-sub" id="modal-sub">Isi detail event baru</div>
            </div>
            <button class="close-btn" onclick="closeModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="event-form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="sort_order" id="field-sort_order" value="0">

            <div class="modal-body">

                {{-- Baris: Preview + Fields --}}
                <div style="display:flex;gap:18px;align-items:flex-start;">

                    {{-- Image Preview --}}
                    <label for="image-input" style="display:block;flex-shrink:0;">
                        <div class="img-preview-wrap" id="img-preview-wrap" title="Klik untuk ganti foto">
                            <img id="img-preview" src="" alt="" style="display:none;">
                            <div class="img-placeholder" id="img-placeholder">
                                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <path d="M3 16l5-5 4 4 3-3 5 5"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                </svg>
                                <span>Klik upload<br><small style="opacity:.6;">Rasio 3:4.5</small></span>
                            </div>
                        </div>
                        <div style="font-size:10px;color:var(--text-muted);text-align:center;margin-top:6px;">Maks 4MB</div>
                    </label>
                    <input type="file" id="image-input" name="image" accept="image/*" style="display:none;">

                    {{-- Judul + Kategori + Tanggal --}}
                    <div style="flex:1;display:flex;flex-direction:column;gap:14px;">
                        <div>
                            <label class="form-label">Judul <span style="color:var(--danger)">*</span></label>
                            <input type="text" name="title" id="field-title" class="form-control"
                                   placeholder="e.g. D'Masiv × Saung Angklung Udjo" required>
                        </div>
                        <div class="form-grid">
                            <div>
                                <label class="form-label">Kategori</label>
                                <input type="text" name="category" id="field-category" class="form-control"
                                       placeholder="e.g. Konser, Reguler">
                            </div>
                            <div>
                                <label class="form-label">Tanggal Tampil</label>
                                <input type="text" name="event_date" id="field-event_date" class="form-control"
                                       placeholder="e.g. 25 Apr">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" id="field-description" class="form-control"
                              rows="2" placeholder="Deskripsi singkat event..."></textarea>
                </div>

                {{-- URL --}}
                <div>
                    <label class="form-label">URL Tiket / Info</label>
                    <input type="url" name="url" id="field-url" class="form-control"
                           placeholder="https://...">
                </div>

                {{-- Status --}}
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--surface2);border-radius:var(--radius-sm);">
                    <div>
                        <div style="font-size:13px;font-weight:600;">Tampilkan di Website</div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Nonaktif = tersembunyi dari halaman utama</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="field-is_active" name="is_active" value="1" checked>
                        <div class="toggle-track"></div>
                    </label>
                </div>

            </div>{{-- /modal-body --}}

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary" id="modal-submit-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// ── SortableJS Drag Reorder ──────────────────────────────────────
const tbody = document.getElementById('sortable-events');
if (tbody) {
    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd() {
            const order = [...tbody.querySelectorAll('tr[data-id]')]
                            .map(r => parseInt(r.dataset.id));
            fetch('{{ route('admin.events.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ order }),
            });
        },
    });
}

// ── Modal Logic ──────────────────────────────────────────────────
const backdrop   = document.getElementById('modal-backdrop');
const form       = document.getElementById('event-form');
const imgPreview = document.getElementById('img-preview');
const imgPlaceholder = document.getElementById('img-placeholder');
const imageInput = document.getElementById('image-input');

function openModal(event = null) {
    // Reset form
    form.reset();
    imgPreview.src = '';
    imgPreview.style.display = 'none';
    imgPlaceholder.style.display = 'flex';

    if (event) {
        // ── Edit mode ──
        document.getElementById('modal-title').textContent = 'Edit Event';
        document.getElementById('modal-sub').textContent   = 'Perbarui detail event';
        document.getElementById('modal-submit-btn').textContent = 'Simpan Perubahan';

        form.action = `/admin/events/${event.id}`;
        document.getElementById('form-method').value = 'PUT';

        document.getElementById('field-title').value       = event.title       ?? '';
        document.getElementById('field-category').value    = event.category    ?? '';
        document.getElementById('field-event_date').value  = event.event_date  ?? '';
        document.getElementById('field-description').value = event.description ?? '';
        document.getElementById('field-url').value         = event.url         ?? '';
        document.getElementById('field-sort_order').value  = event.sort_order  ?? 0;
        document.getElementById('field-is_active').checked = !!event.is_active;

        if (event.image_path) {
            imgPreview.src = '/storage/' + event.image_path;
            imgPreview.style.display = 'block';
            imgPlaceholder.style.display = 'none';
        }
    } else {
        // ── Create mode ──
        document.getElementById('modal-title').textContent = 'Tambah Event';
        document.getElementById('modal-sub').textContent   = 'Isi detail event baru';
        document.getElementById('modal-submit-btn').textContent = 'Simpan';

        form.action = '{{ route('admin.events.store') }}';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('field-is_active').checked = true;
    }

    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target === backdrop) closeModal();
}

// Keyboard ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Image preview on file select
imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        imgPreview.src = e.target.result;
        imgPreview.style.display = 'block';
        imgPlaceholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
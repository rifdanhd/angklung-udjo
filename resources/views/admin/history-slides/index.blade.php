{{-- resources/views/admin/history-slides/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Kelola Hero Carousel — History')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Hero Carousel — History</h1>
        <div class="page-breadcrumb">Heritage › History › Kelola Slide Hero</div>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ url('/heritage/history') }}" target="_blank" class="btn btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
            </svg>
            Preview
        </a>
        <button onclick="document.getElementById('modal-upload').style.display='flex'" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="14" height="14">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Upload Foto
        </button>
    </div>
</div>

{{-- Flash message --}}
@if(session('success'))
<div style="background:rgba(22,163,74,.1);border:1.5px solid rgba(22,163,74,.25);border-radius:var(--radius);padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
    <svg width="16" height="16" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
    <span style="font-size:13px;color:#16a34a;font-weight:600;">{{ session('success') }}</span>
</div>
@endif

{{-- Info tips --}}
<div style="background:var(--accent-soft);border:1.5px solid rgba(124,111,255,.2);border-radius:var(--radius);padding:14px 18px;margin-bottom:22px;display:flex;align-items:center;gap:12px;">
    <svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    <div style="font-size:13px;color:var(--brand);">
        <strong>Tips:</strong> Drag &amp; drop kartu untuk mengatur urutan tampil. Klik toggle untuk aktif/nonaktifkan slide. Ukuran foto ideal <strong>1920×1080px</strong>, format JPG/WEBP.
    </div>
</div>

{{-- Slide grid --}}
<div id="slide-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    @forelse($slides as $slide)
    <div class="slide-card card" data-id="{{ $slide->id }}"
         style="overflow:hidden;transition:box-shadow .2s,transform .2s;{{ !$slide->is_active ? 'opacity:.55;' : '' }}cursor:grab;">

        {{-- Thumbnail --}}
        <div style="position:relative;height:180px;overflow:hidden;background:var(--surface2);">
            <img src="{{ asset('storage/' . $slide->image_path) }}"
                 alt="{{ $slide->alt_text ?? 'History slide' }}"
                 style="width:100%;height:100%;object-fit:cover;">

            {{-- Order badge --}}
            <div style="position:absolute;top:10px;left:10px;width:28px;height:28px;border-radius:50%;background:rgba(10,8,30,.65);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;">
                {{ $slide->order }}
            </div>

            {{-- Status badge --}}
            <div style="position:absolute;top:10px;right:10px;">
                @if($slide->is_active)
                    <span class="badge badge-success" style="font-size:10.5px;backdrop-filter:blur(4px);">Aktif</span>
                @else
                    <span class="badge badge-muted" style="font-size:10.5px;backdrop-filter:blur(4px);">Nonaktif</span>
                @endif
            </div>

            {{-- Drag handle --}}
            <div style="position:absolute;bottom:10px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.7);">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5a1 1 0 100 2 1 1 0 000-2zM15 5a1 1 0 100 2 1 1 0 000-2zM9 11a1 1 0 100 2 1 1 0 000-2zM15 11a1 1 0 100 2 1 1 0 000-2zM9 17a1 1 0 100 2 1 1 0 000-2zM15 17a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
            </div>
        </div>

        {{-- Info & Actions --}}
        <div style="padding:12px 16px;">
            <div style="font-size:12.5px;color:var(--text-muted);margin-bottom:12px;min-height:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $slide->alt_text ?: '—' }}
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">

                {{-- Toggle --}}
                <form action="{{ route('admin.history-slides.toggle', $slide) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $slide->is_active ? 'btn-outline' : 'btn-primary' }}"
                            style="{{ $slide->is_active ? '' : 'background:var(--success);' }}">
                        @if($slide->is_active)
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 12H6"/></svg>
                            Nonaktifkan
                        @else
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            Aktifkan
                        @endif
                    </button>
                </form>

                {{-- Hapus --}}
                <form action="{{ route('admin.history-slides.destroy', $slide) }}" method="POST"
                      onsubmit="return confirm('Hapus slide ini?')" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm"
                            style="background:var(--danger-soft);color:var(--danger);border:1.5px solid #f5b8b0;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @empty
    <div style="grid-column:span 3;text-align:center;padding:64px 20px;background:var(--surface);border-radius:var(--radius);border:1px solid var(--border);">
        <svg width="48" height="48" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 14px;display:block;opacity:.35;">
            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <div style="font-size:15px;font-weight:600;color:var(--text-muted);">Belum ada slide</div>
        <div style="font-size:13px;color:var(--text-muted);margin-top:6px;">Upload foto pertama untuk hero history</div>
    </div>
    @endforelse
</div>

{{-- Modal Upload --}}
<div id="modal-upload"
     style="display:none;position:fixed;inset:0;background:rgba(10,8,30,.45);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(3px);">
    <div style="background:var(--surface);border-radius:16px;padding:28px;width:90%;max-width:460px;box-shadow:0 24px 64px rgba(34,24,93,.2);animation:modalIn .2s ease;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <div style="font-size:16px;font-weight:700;color:var(--text);">Upload Foto Hero History</div>
            <button onclick="document.getElementById('modal-upload').style.display='none'"
                    style="background:none;border:none;cursor:pointer;color:var(--text-muted);padding:4px;border-radius:6px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

       <form action="{{ route('admin.history-slides.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
            @csrf

            <div id="drop-zone"
                 style="border:2px dashed var(--border);border-radius:var(--radius);padding:32px 20px;text-align:center;cursor:pointer;transition:all .15s;margin-bottom:16px;"
                 onclick="document.getElementById('file-input').click()"
                 ondragover="event.preventDefault();this.style.borderColor='var(--accent)';this.style.background='var(--accent-soft)'"
                 ondragleave="this.style.borderColor='var(--border)';this.style.background='transparent'"
                 ondrop="handleDrop(event)">
                <svg width="32" height="32" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block;">
                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <div style="font-size:13.5px;font-weight:600;color:var(--text);">Klik atau drag foto ke sini</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">JPG, PNG, WEBP · Maks 4MB · Ideal 1920×1080px</div>
                <div id="file-name" style="font-size:12px;color:var(--accent);margin-top:8px;font-weight:600;"></div>
            </div>
            <input type="file" id="file-input" name="image" accept="image/*" style="display:none;" onchange="showFileName(this)">

            <div class="form-group">
                <label class="form-label">Alt Text <span style="color:var(--text-muted);font-weight:400;">(opsional, untuk SEO)</span></label>
                <input type="text" name="alt_text" class="form-control" placeholder="Contoh: Sejarah Saung Angklung Udjo 1966">
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                <button type="button" onclick="document.getElementById('modal-upload').style.display='none'" class="btn btn-outline">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Upload Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Loading Overlay --}}
<div id="loading-overlay"
     style="display:none;position:fixed;inset:0;background:rgba(10,8,30,.6);z-index:99999;
            align-items:center;justify-content:center;backdrop-filter:blur(4px);">
    <div style="background:#fff;border-radius:16px;padding:36px 48px;text-align:center;
                box-shadow:0 24px 64px rgba(34,24,93,.25);">
        <div style="width:48px;height:48px;border:4px solid #ede9ff;border-top-color:#7c6fff;
                    border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 16px;">
        </div>
        <div style="font-size:15px;font-weight:700;color:#1a1535;">Mengupload foto...</div>
        <div id="overlay-filename" style="font-size:12px;color:#8b8aaa;margin-top:6px;">Mohon tunggu sebentar</div>
    </div>
</div>

<style>

    @keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
 @keyframes spin { to { transform: rotate(360deg); } }
    .slide-card:active { cursor: grabbing; }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>

// ── Loading overlay saat upload ──
const uploadForm = document.getElementById('upload-form');
if (uploadForm) {
    uploadForm.addEventListener('submit', function (e) {
        const fileInput = document.getElementById('file-input');
        if (!fileInput || !fileInput.files.length) {
            e.preventDefault();
            alert('Pilih foto terlebih dahulu!');
            return;
        }
        const overlay  = document.getElementById('loading-overlay');
        const desc     = document.getElementById('overlay-filename');
        if (desc) desc.textContent = fileInput.files[0].name;
        overlay.style.display = 'flex';
    });
}
    function showFileName(input) {
        if (input.files[0]) {
            document.getElementById('file-name').textContent = '✓ ' + input.files[0].name;
        }
    }

    function handleDrop(e) {
        e.preventDefault();
        document.getElementById('drop-zone').style.borderColor = 'var(--border)';
        document.getElementById('drop-zone').style.background   = 'transparent';
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('file-input').files = dt.files;
            document.getElementById('file-name').textContent = '✓ ' + file.name;
        }
    }

    const grid = document.getElementById('slide-grid');
    if (grid) {
        Sortable.create(grid, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function () {
                const ids = [...grid.querySelectorAll('.slide-card')].map(el => el.dataset.id);
                fetch('{{ route('admin.history-slides.order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids })
                });
            }
        });
    }
    
</script>

@endsection
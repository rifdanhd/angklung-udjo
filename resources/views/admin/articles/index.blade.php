{{-- resources/views/admin/articles/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Manajemen Artikel')

@push('styles')
<style>
    .art-img-thumb {
        width: 72px; height: 46px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--surface2);
        flex-shrink: 0;
    }

    /* ── MODAL ── */
    .modal-backdrop {
        position: fixed; inset: 0;
        background: rgba(10,8,30,.55);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: none;
        align-items: flex-start;
        justify-content: center;
        padding: 32px 20px;
        overflow-y: auto;
    }
    .modal-backdrop.open { display: flex; }

    .modal-box {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: 0 24px 80px rgba(34,24,93,.22);
        width: 100%;
        max-width: 740px;
        animation: modalIn .25s cubic-bezier(.16,1,.3,1);
        margin: auto;
    }
    @keyframes modalIn {
        from { opacity:0; transform: scale(.96) translateY(14px); }
        to   { opacity:1; transform: scale(1) translateY(0); }
    }

    .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        position: sticky; top: 0; background: var(--surface); z-index: 1;
        border-radius: var(--radius) var(--radius) 0 0;
    }
    .modal-body  { padding: 24px; display: flex; flex-direction: column; gap: 18px; }
    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        display: flex; justify-content: flex-end; gap: 10px;
        background: var(--surface);
        border-radius: 0 0 var(--radius) var(--radius);
    }

    .close-btn {
        width: 32px; height: 32px; border-radius: 8px;
        background: none; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted); transition: all var(--transition);
    }
    .close-btn:hover { background: var(--surface2); color: var(--text); }

    /* Image Preview */
    .img-preview-wrap {
        width: 100%; height: 160px;
        border-radius: var(--radius-sm);
        border: 2px dashed var(--border);
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface2);
        cursor: pointer;
        transition: border-color var(--transition);
    }
    .img-preview-wrap:hover { border-color: var(--accent); }
    .img-preview-wrap img { width:100%; height:100%; object-fit:cover; }
    .img-placeholder {
        display: flex; flex-direction: column; align-items: center;
        gap: 8px; color: var(--text-muted); font-size: 12px; text-align: center; padding: 16px;
    }

    /* Toggle */
    .toggle-switch { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; }
    .toggle-switch input[type=checkbox] { display: none; }
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
    input[type=checkbox]:checked + .toggle-track { background: var(--success); }
    input[type=checkbox]:checked + .toggle-track::after { transform: translateX(18px); }

    /* Radio type pills */
    .type-pills { display: flex; gap: 8px; }
    .type-pill {
        flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 10px 14px; border-radius: 10px;
        border: 2px solid var(--border); cursor: pointer;
        font-size: 13px; font-weight: 600; color: var(--text-muted);
        transition: all var(--transition); background: var(--surface2);
        user-select: none;
    }
    .type-pill input { display: none; }
    .type-pill.selected {
        border-color: var(--accent);
        background: var(--accent-soft);
        color: var(--accent);
    }

    /* Carousel thumbs */
    .carousel-strip { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .carousel-thumb {
        position: relative;
        width: 80px; height: 80px;
        border-radius: 8px; overflow: hidden;
        border: 1px solid var(--border);
    }
    .carousel-thumb img { width:100%; height:100%; object-fit:cover; }
    .carousel-thumb .del-thumb {
        position: absolute; top: 3px; right: 3px;
        width: 20px; height: 20px;
        background: rgba(220,38,38,.85); color: #fff;
        border-radius: 50%; border: none; cursor: pointer;
        font-size: 14px; line-height: 20px; text-align: center;
        display: none;
    }
    .carousel-thumb:hover .del-thumb { display: block; }

    .section-label {
        font-size: 12px; font-weight: 700; letter-spacing: .04em;
        text-transform: uppercase; color: var(--text-muted);
        padding-bottom: 8px; border-bottom: 1px solid var(--border);
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Artikel</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            Artikel
        </div>
    </div>
    <button onclick="openModal()" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Tambah Artikel
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Artikel</div>
        </div>
        <span class="badge badge-brand">{{ $articles->total() }} Artikel</span>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:84px;">Foto</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td style="color:var(--text-muted);font-size:12.5px;">
                        {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                    </td>
                    <td>
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 class="art-img-thumb" alt="{{ $article->title }}">
                        @else
                            <div class="art-img-thumb" style="display:flex;align-items:center;justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:13.5px;color:var(--text);max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $article->title }}
                        </div>
                        @if($article->external_url)
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">🔗 Eksternal</div>
                        @endif
                    </td>
                    <td><span class="badge badge-brand">{{ $article->category }}</span></td>
                    <td style="color:var(--text-muted);font-size:13px;">{{ $article->user->name ?? '—' }}</td>
                    <td style="color:var(--text-muted);font-size:13px;white-space:nowrap;">{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        @if($article->is_published)
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-muted">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <button onclick='openModal(@json($article->load("images")))'
                                    class="btn btn-outline btn-sm btn-icon-sm" title="Edit">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel ini?')">
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
                    <td colspan="8" style="text-align:center;padding:56px 20px;color:var(--text-muted);">
                        Belum ada artikel.
                        <button onclick="openModal()" style="color:var(--accent);background:none;border:none;cursor:pointer;font-weight:600;">
                            Tambah sekarang
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">
        {{ $articles->links() }}
    </div>
    @endif
</div>


{{-- ══════════════════════════════════════════════
     MODAL CREATE / EDIT
══════════════════════════════════════════════ --}}
<div class="modal-backdrop" id="modal-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-box">

        <div class="modal-header">
            <div>
                <div class="card-title" id="modal-title">Tambah Artikel</div>
                <div class="card-sub"   id="modal-sub">Isi detail artikel baru</div>
            </div>
            <button class="close-btn" onclick="closeModal()" type="button">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="article-form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="modal-body">

                {{-- Judul --}}
                <div>
                    <label class="form-label">Judul <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" id="field-title" class="form-control"
                           placeholder="Judul artikel..." required>
                </div>

                {{-- Excerpt --}}
                <div>
                    <label class="form-label">Excerpt <span style="color:var(--danger)">*</span></label>
                    <textarea name="excerpt" id="field-excerpt" class="form-control"
                              rows="2" placeholder="Ringkasan singkat artikel..." required></textarea>
                </div>

                {{-- Tipe Artikel --}}
                <div>
                    <label class="form-label">Tipe Artikel</label>
                    <div class="type-pills">
                        <label class="type-pill selected" id="pill-internal">
                            <input type="radio" name="article_type" value="internal"
                                   onchange="setType('internal')" checked>
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                            Artikel Internal
                        </label>
                        <label class="type-pill" id="pill-external">
                            <input type="radio" name="article_type" value="external"
                                   onchange="setType('external')">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Link Eksternal
                        </label>
                    </div>
                </div>

                {{-- External URL --}}
                <div id="field-external-wrap" style="display:none;">
                    <label class="form-label">URL Artikel Eksternal</label>
                    <input type="url" name="external_url" id="field-external_url" class="form-control"
                           placeholder="https://www.kompas.com/...">
                    <p style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan URL lengkap dari sumber eksternal</p>
                </div>

                {{-- Konten --}}
                <div id="field-content-wrap">
                    <label class="form-label">Konten <span style="color:var(--danger)">*</span></label>
                    <textarea name="content" id="field-content" class="form-control"
                              rows="6" placeholder="Isi konten artikel..."></textarea>
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="form-label">Kategori <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="category" id="field-category" class="form-control"
                           placeholder="e.g. Budaya, Wisata, Kuliner" required>
                </div>

                {{-- Featured Image --}}
                <div>
                    <div class="section-label">Gambar Utama</div>
                    <label for="featured-image-input" style="display:block;margin-top:10px;">
                        <div class="img-preview-wrap">
                            <img id="feat-preview" src="" alt="" style="display:none;width:100%;height:100%;object-fit:cover;">
                            <div class="img-placeholder" id="feat-placeholder">
                                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <path d="M3 16l5-5 4 4 3-3 5 5"/>
                                </svg>
                                <span>Klik untuk upload foto<br><small style="opacity:.6">Opsional · Maks 2MB</small></span>
                            </div>
                        </div>
                    </label>
                    <input type="file" id="featured-image-input" name="featured_image"
                           accept="image/*" style="display:none;">
                </div>

                {{-- Carousel Images --}}
                <div>
                    <div class="section-label">📸 Foto Carousel</div>
                    <p style="font-size:11px;color:var(--text-muted);margin:6px 0 10px;">
                        Bisa pilih lebih dari 1 foto. Tampil sebagai carousel di halaman artikel.
                    </p>
                    {{-- Foto tersimpan (edit mode) --}}
                    <div id="saved-carousel-strip" class="carousel-strip"></div>
                    <div id="deleted-images-inputs"></div>
                    {{-- Upload baru --}}
                    <input type="file" id="carousel-input" name="carousel_images[]"
                           multiple accept="image/*" class="form-control" style="margin-top:8px;">
                    <div id="new-carousel-strip" class="carousel-strip"></div>
                </div>

                {{-- Publish Toggle --}}
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--surface2);border-radius:var(--radius-sm);">
                    <div>
                        <div style="font-size:13px;font-weight:600;">Publish Artikel</div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Draft = tidak tampil di website</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" id="field-is_published" name="is_published" value="1" checked>
                        <div class="toggle-track"></div>
                    </label>
                </div>

            </div>{{-- /modal-body --}}

            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-outline">Batal</button>
                <button type="submit" id="modal-submit-btn" class="btn btn-primary">
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
<script>
// ── Refs ──────────────────────────────────────────────────────────
const backdrop        = document.getElementById('modal-backdrop');
const form            = document.getElementById('article-form');
const featPreview     = document.getElementById('feat-preview');
const featPlaceholder = document.getElementById('feat-placeholder');
const featInput       = document.getElementById('featured-image-input');
const carouselInput   = document.getElementById('carousel-input');
const savedStrip      = document.getElementById('saved-carousel-strip');
const newStrip        = document.getElementById('new-carousel-strip');
const deletedInputs   = document.getElementById('deleted-images-inputs');

// ── Open Modal ────────────────────────────────────────────────────
function openModal(article = null) {
    // Reset
    form.reset();
    featPreview.src = '';
    featPreview.style.display   = 'none';
    featPlaceholder.style.display = 'flex';
    savedStrip.innerHTML      = '';
    newStrip.innerHTML        = '';
    deletedInputs.innerHTML   = '';
    setType('internal');
    document.querySelector('input[name=article_type][value=internal]').checked = true;

    if (article) {
        // Edit mode
        document.getElementById('modal-title').textContent = 'Edit Artikel';
        document.getElementById('modal-sub').textContent   = 'Perbarui detail artikel';
        document.getElementById('modal-submit-btn').textContent = 'Simpan Perubahan';

        form.action = `/admin/articles/${article.id}`;
        document.getElementById('form-method').value = 'PUT';

        document.getElementById('field-title').value        = article.title        ?? '';
        document.getElementById('field-excerpt').value      = article.excerpt      ?? '';
        document.getElementById('field-content').value      = article.content      ?? '';
        document.getElementById('field-category').value     = article.category     ?? '';
        document.getElementById('field-external_url').value = article.external_url ?? '';
        document.getElementById('field-is_published').checked = !!article.is_published;

        const type = article.external_url ? 'external' : 'internal';
        document.querySelector(`input[name=article_type][value=${type}]`).checked = true;
        setType(type);

        if (article.featured_image) {
            featPreview.src = '/storage/' + article.featured_image;
            featPreview.style.display   = 'block';
            featPlaceholder.style.display = 'none';
        }

        if (article.images && article.images.length) {
            article.images.forEach(img => {
                const div = document.createElement('div');
                div.className = 'carousel-thumb';
                div.id = `saved-thumb-${img.id}`;
                div.innerHTML = `
                    <img src="/storage/${img.image_path}" alt="">
                    <button type="button" class="del-thumb"
                            onclick="deleteSavedImage(${img.id})">×</button>`;
                savedStrip.appendChild(div);
            });
        }

    } else {
        // Create mode
        document.getElementById('modal-title').textContent = 'Tambah Artikel';
        document.getElementById('modal-sub').textContent   = 'Isi detail artikel baru';
        document.getElementById('modal-submit-btn').textContent = 'Simpan';

        form.action = '{{ route('admin.articles.store') }}';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('field-is_published').checked = true;
    }

    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

// ── Close Modal ───────────────────────────────────────────────────
function closeModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
}
function handleBackdropClick(e) {
    if (e.target === backdrop) closeModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// ── Tipe Toggle ───────────────────────────────────────────────────
function setType(type) {
    const isExt = type === 'external';
    document.getElementById('field-external-wrap').style.display = isExt ? 'block' : 'none';
    document.getElementById('field-content-wrap').style.display  = isExt ? 'none'  : 'block';
    document.getElementById('field-content').required             = !isExt;
    document.getElementById('field-external_url').required        = isExt;
    document.getElementById('pill-internal').classList.toggle('selected', !isExt);
    document.getElementById('pill-external').classList.toggle('selected',  isExt);
}

// ── Featured Image Preview ────────────────────────────────────────
featInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        featPreview.src = e.target.result;
        featPreview.style.display   = 'block';
        featPlaceholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});

// ── Carousel Preview ──────────────────────────────────────────────
carouselInput.addEventListener('change', function () {
    newStrip.innerHTML = '';
    Array.from(this.files).forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'carousel-thumb';
            div.innerHTML = `
                <img src="${e.target.result}" alt="">
                <span style="position:absolute;bottom:3px;left:4px;background:rgba(0,0,0,.5);
                             color:#fff;font-size:10px;padding:1px 5px;border-radius:4px;">${i+1}</span>`;
            newStrip.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// ── Hapus Carousel Tersimpan ──────────────────────────────────────
function deleteSavedImage(imageId) {
    if (!confirm('Hapus foto ini?')) return;
    const el = document.getElementById(`saved-thumb-${imageId}`);
    if (el) el.style.display = 'none';
    const inp = document.createElement('input');
    inp.type  = 'hidden';
    inp.name  = 'delete_images[]';
    inp.value = imageId;
    deletedInputs.appendChild(inp);
}
</script>
@endpush
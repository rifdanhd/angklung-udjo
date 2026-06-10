@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@push('styles')
<style>
/* ── Stats Grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media(max-width:1100px){ .stats-grid{ grid-template-columns: repeat(3,1fr); } }
@media(max-width:600px) { .stats-grid{ grid-template-columns: repeat(2,1fr); } }

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--stat-color, var(--brand)), transparent);
    opacity: 0.7;
}
.stat-icon {
    width: 38px; height: 38px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon svg { width: 18px; height: 18px; }
.stat-val { font-size: 20px; font-weight: 800; color: var(--text); line-height: 1; }
.stat-lbl { font-size: 11px; color: var(--text-muted); margin-top: 3px; font-weight: 500; }

/* ── Filter ── */
.filter-section {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px 20px;
    margin-bottom: 18px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}
.filter-section input,
.filter-section select {
    padding: 8px 13px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13px;
    color: var(--text);
    background: var(--surface);
    outline: none;
    transition: border-color .18s;
}
.filter-section input:focus,
.filter-section select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(124,111,255,.1);
}
.filter-section input[type="text"] { flex: 1; min-width: 200px; }

/* ── Products Grid ── */
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
@media(max-width:1100px){ .products-grid{ grid-template-columns: repeat(3,1fr); } }
@media(max-width:768px) { .products-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px) { .products-grid{ grid-template-columns: 1fr; } }

/* ── Product Card ── */
.product-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: box-shadow .2s, transform .2s;
}
.product-card:hover {
    box-shadow: 0 8px 30px rgba(10,8,30,.12);
    transform: translateY(-2px);
}
.product-img {
    position: relative;
    height: 180px;
    background: var(--surface-alt);
    overflow: hidden;
}
.product-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .3s;
}
.product-card:hover .product-img img { transform: scale(1.06); }
.product-img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted);
}
.product-img-placeholder svg { width: 48px; height: 48px; opacity: .3; }

.product-badge {
    position: absolute;
    top: 10px; left: 10px;
    display: flex; flex-direction: column; gap: 5px;
}
.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .3px;
}
.badge-angklung  { background: #e8f0fe; color: #1a56db; }
.badge-arumba    { background: var(--success-soft); color: #1a7a4a; }
.badge-calung    { background: #f3e8ff; color: #7c3aed; }
.badge-souvenir  { background: var(--warning-soft); color: #9a6c00; }
.badge-featured  { background: #fef9c3; color: #854d0e; }

.product-sold-out {
    position: absolute;
    inset: 0;
    background: rgba(10,8,30,.5);
    display: flex; align-items: center; justify-content: center;
}
.sold-out-label {
    background: var(--danger);
    color: white;
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.product-body { padding: 14px 16px; }
.product-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-desc {
    font-size: 11.5px;
    color: var(--text-muted);
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}
.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 12px;
}
.product-price {
    font-size: 15px;
    font-weight: 800;
    color: var(--brand);
}
.product-stock { font-size: 11px; text-align: right; }
.product-stock .lbl { color: var(--text-muted); }
.product-stock .val { font-weight: 700; font-size: 13px; }
.stock-ok  { color: var(--success); }
.stock-low { color: var(--danger); }

.product-actions {
    display: flex;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
}
.product-actions .btn { flex: 1; justify-content: center; }

/* ── Modal ── */
.modal-backdrop {
    display: none;
    position: fixed; inset: 0;
    background: rgba(10,8,30,.55);
    z-index: 50;
    backdrop-filter: blur(3px);
    align-items: center; justify-content: center;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 28px 30px;
    max-width: 640px; width: 95%;
    box-shadow: 0 20px 60px rgba(10,8,30,.25);
    animation: modalIn .22s cubic-bezier(.16,1,.3,1);
    max-height: 90vh;
    overflow-y: auto;
}
@keyframes modalIn {
    from { opacity:0; transform:translateY(16px) scale(.97); }
    to   { opacity:1; transform:none; }
}
.modal-close {
    float: right;
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 20px; line-height: 1;
    transition: color .15s;
}
.modal-close:hover { color: var(--text); }
.modal-title { font-size: 16px; font-weight: 800; color: var(--text); margin-bottom: 20px; }
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
    margin-bottom: 14px;
}
.form-grid.single { grid-template-columns: 1fr; }
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-label { font-size: 12px; font-weight: 600; color: var(--text); }
.form-label.required::after { content: '*'; color: var(--danger); margin-left: 3px; }
.form-input, .form-select, .form-textarea {
    padding: 9px 13px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13px;
    color: var(--text);
    background: var(--surface);
    outline: none;
    transition: border-color .18s;
    width: 100%;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(124,111,255,.1);
}
.form-textarea { resize: vertical; min-height: 90px; }
.form-check {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--text); cursor: pointer;
}
.form-check input { accent-color: var(--brand); width: 15px; height: 15px; cursor: pointer; }
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid var(--border);
}

/* ── Alert ── */
.alert {
    padding: 12px 16px;
    border-radius: var(--radius-sm);
    margin-bottom: 16px;
    font-size: 13px;
    display: flex; align-items: center; gap: 10px;
}
.alert-success { background: var(--success-soft); color: var(--success); border: 1px solid var(--success); }
.alert-error   { background: var(--danger-soft);  color: var(--danger);  border: 1px solid var(--danger); }

/* ── Empty State ── */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
    color: var(--text-muted);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
}
.empty-state svg { opacity: .25; margin: 0 auto 16px; display: block; }

/* ══════════════════════════════════════════
   SHOPEE-STYLE IMAGE UPLOADER
══════════════════════════════════════════ */
.img-upload-section { margin-bottom: 16px; }

.img-upload-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.img-upload-label span {
    font-size: 11px;
    font-weight: 400;
    color: var(--text-muted);
}

/* Grid 3 slot */
.img-slots {
    display: grid;

    gap: 10px;

    grid-template-columns: repeat(5, 1fr);

}

.img-slot {
    position: relative;
    aspect-ratio: 1 / 1;
    border-radius: 10px;
    border: 2px dashed var(--border);
    background: var(--surface-alt, #f8f8fc);
    overflow: hidden;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    user-select: none;
}
.img-slot:hover { border-color: var(--brand); background: rgba(124,111,255,.05); }
.img-slot.filled { border-style: solid; border-color: var(--border); }

.img-slot-empty {
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    pointer-events: none;
}
.img-slot-empty svg { width: 26px; height: 26px; color: var(--text-muted); opacity: .45; }
.slot-label {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
    text-align: center;
    line-height: 1.3;
}
.slot-label.utama { color: var(--brand); font-weight: 700; opacity: 1; }

.img-slot-preview {
    width: 100%; height: 100%;
    object-fit: cover;
    display: none;
    pointer-events: none;
}

.img-slot-badge {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: rgba(124,111,255,.85);
    color: white;
    font-size: 10px;
    font-weight: 700;
    text-align: center;
    padding: 3px 0;
    letter-spacing: .4px;
    display: none;
    pointer-events: none;
}

.img-slot-remove {
    position: absolute;
    top: 5px; right: 5px;
    width: 22px; height: 22px;
    border-radius: 50%;
    background: rgba(10,8,30,.65);
    color: white;
    border: none;
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    line-height: 1;
    transition: background .15s;
    z-index: 3;
    padding: 0;
}
.img-slot-remove:hover { background: var(--danger); }

.img-upload-hint {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 7px;
    line-height: 1.6;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <div class="page-title">Kelola Produk</div>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
            Produk
        </div>
    </div>
    <div>
        <button type="button" class="btn btn-primary" onclick="openCreateModal()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
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

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card" style="--stat-color:var(--brand)">
        <div class="stat-icon" style="background:var(--accent-soft)">
            <svg fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $products->total() }}</div>
            <div class="stat-lbl">Total Produk</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#1a56db">
        <div class="stat-icon" style="background:#e8f0fe">
            <svg fill="none" stroke="#1a56db" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $products->getCollection()->where('category','angklung')->count() }}</div>
            <div class="stat-lbl">Angklung</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:var(--success)">
        <div class="stat-icon" style="background:var(--success-soft)">
            <svg fill="none" stroke="var(--success)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $products->getCollection()->where('category','arumba')->count() }}</div>
            <div class="stat-lbl">Arumba</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#7c3aed">
        <div class="stat-icon" style="background:#f3e8ff">
            <svg fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $products->getCollection()->where('category','calung')->count() }}</div>
            <div class="stat-lbl">Calung</div>
        </div>
    </div>
    <div class="stat-card" style="--stat-color:#9a6c00">
        <div class="stat-icon" style="background:var(--warning-soft)">
            <svg fill="none" stroke="#9a6c00" stroke-width="2" viewBox="0 0 24 24">
                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $products->getCollection()->where('category','souvenir')->count() }}</div>
            <div class="stat-lbl">Souvenir</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.products.index') }}">
    <div class="filter-section">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍  Cari nama produk...">
        <select name="category">
            <option value="">Semua Kategori</option>
            <option value="angklung"  @selected(request('category')=='angklung')>Angklung</option>
            <option value="arumba"    @selected(request('category')=='arumba')>Arumba</option>
            <option value="calung"    @selected(request('category')=='calung')>Calung</option>
            <option value="souvenir"  @selected(request('category')=='souvenir')>Souvenir</option>
        </select>
        <select name="availability">
            <option value="">Semua Status</option>
            <option value="available"    @selected(request('availability')=='available')>Tersedia</option>
            <option value="out_of_stock" @selected(request('availability')=='out_of_stock')>Habis</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','category','availability']))
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
    </div>
</form>

{{-- Products Grid --}}
<div class="products-grid">
    @forelse($products as $product)
    <div class="product-card">
        <div class="product-img">
            @if($product->images && count($product->images) > 0)
                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}">
            @else
                <div class="product-img-placeholder">
                    <svg fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif
            <div class="product-badge">
                <span class="badge badge-{{ $product->category }}">{{ ucfirst($product->category) }}</span>
                @if($product->is_featured)
                    <span class="badge badge-featured">⭐ Featured</span>
                @endif
            </div>
            @if(!$product->is_available || $product->stock <= 0)
                <div class="product-sold-out">
                    <span class="sold-out-label">Stok Habis</span>
                </div>
            @endif
        </div>

        <div class="product-body">
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-desc">{{ $product->description }}</div>
            <div class="product-meta">
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="product-stock">
                    <div class="lbl">Stok</div>
                    <div class="val {{ $product->stock > 10 ? 'stock-ok' : 'stock-low' }}">{{ $product->stock }}</div>
                </div>
            </div>
            <div class="product-actions">
                {{-- type="button" wajib agar tidak trigger form delete --}}
                <button type="button"
                        class="btn btn-sm btn-outline"
                        onclick="openEditModal({{ $product->id }})"
                        title="Edit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </button>
                <form method="POST"
                      action="{{ route('admin.products.destroy', $product) }}"
                      style="flex:1"
                      onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Hidden data untuk edit modal --}}
    <div id="product-data-{{ $product->id }}"
         style="display:none"
         data-id="{{ $product->id }}"
         data-name="{{ $product->name }}"
         data-description="{{ $product->description }}"
         data-price="{{ $product->price }}"
         data-stock="{{ $product->stock }}"
         data-category="{{ $product->category }}"
         data-is-featured="{{ $product->is_featured ? '1' : '0' }}"
         data-is-available="{{ $product->is_available ? '1' : '0' }}"
        data-images='@json($product->images ?? [])'
    ></div>

    @empty
    <div class="empty-state">
        <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <div style="font-size:15px;font-weight:600;margin-bottom:4px">Belum ada produk</div>
        <div style="font-size:12.5px">Klik tombol "Tambah Produk" untuk mulai</div>
    </div>
    @endforelse
</div>

@if($products->hasPages())
<div style="margin-top:24px">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif


{{-- ══════════════════════════════════════════════════
     MODAL TAMBAH / EDIT PRODUK
══════════════════════════════════════════════════ --}}
<div class="modal-backdrop" id="productModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <button type="button" class="modal-close"
                onclick="document.getElementById('productModal').classList.remove('open')">&times;</button>
        <div class="modal-title" id="modal-title">Tambah Produk</div>

        <form method="POST" id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            {{-- Nama & Kategori --}}
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">Nama Produk</label>
                    <input type="text" name="name" id="f-name" class="form-input" required
                           placeholder="Angklung Mini 8 Nada">
                </div>
                <div class="form-group">
                    <label class="form-label required">Kategori</label>
                    <select name="category" id="f-category" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        <option value="angklung">Angklung</option>
                        <option value="arumba">Arumba</option>
                        <option value="calung">Calung</option>
                        <option value="souvenir">Souvenir</option>
                    </select>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="form-grid single">
                <div class="form-group">
                    <label class="form-label required">Deskripsi</label>
                    <textarea name="description" id="f-description" class="form-textarea" required
                              placeholder="Deskripsi lengkap produk..."></textarea>
                </div>
            </div>

            {{-- Harga & Stok --}}
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">Harga (Rp)</label>
                    <input type="number" name="price" id="f-price" class="form-input"
                           required min="0" placeholder="75000">
                </div>
                <div class="form-group">
                    <label class="form-label required">Stok</label>
                    <input type="number" name="stock" id="f-stock" class="form-input"
                           required min="0" placeholder="10">
                </div>
            </div>

            {{-- ══ SHOPEE-STYLE IMAGE UPLOADER ══ --}}
            <div class="img-upload-section">
                <div class="img-upload-label">
                    Foto Produk
                    <span>— klik slot untuk upload · foto pertama = foto utama</span>
                </div>

                <div class="img-slots">
                    @for($s = 0; $s < 5; $s++)
                    <div class="img-slot" id="slot-{{ $s }}" onclick="triggerSlot({{ $s }})">
                        {{-- Placeholder kosong --}}
                        <div class="img-slot-empty" id="slot-empty-{{ $s }}">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                            </svg>
                            <div class="slot-label {{ $s === 0 ? 'utama' : '' }}">
                                {{ $s === 0 ? 'Foto Utama' : 'Foto ' . ($s + 1) }}
                            </div>
                        </div>

                        {{-- Preview gambar --}}
                        <img class="img-slot-preview" id="slot-preview-{{ $s }}" src="" alt="">

                        {{-- Badge UTAMA hanya slot 0 --}}
                        @if($s === 0)
                        <div class="img-slot-badge" id="slot-badge-0">UTAMA</div>
                        @endif

                        {{-- Tombol hapus --}}
                        <button type="button" class="img-slot-remove" id="slot-remove-{{ $s }}"
                                onclick="removeSlot(event, {{ $s }})">×</button>

                        {{-- Input file tersembunyi --}}
                        <input type="file" id="slot-input-{{ $s }}"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="handleSlotChange(event, {{ $s }})"
                               style="display:none">
                    </div>
                    @endfor
                </div>

                <div class="img-upload-hint">
                    Format JPG / PNG / WEBP &nbsp;·&nbsp; Maks. 2 MB per foto &nbsp;·&nbsp; Klik ✕ untuk hapus foto
                </div>
            </div>
            {{-- ══ END UPLOADER ══ --}}

            {{-- Checkbox --}}
            <div style="display:flex;gap:24px;margin-bottom:4px">
                <label class="form-check">
                    <input type="checkbox" name="is_featured" id="f-featured" value="1">
                    ⭐ Produk Featured
                </label>
                <label class="form-check">
                    <input type="checkbox" name="is_available" id="f-available" value="1" checked>
                    ✅ Tersedia
                </label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline"
                        onclick="document.getElementById('productModal').classList.remove('open')">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const ROUTE_STORE  = '{{ route("admin.products.store") }}';
const ROUTE_UPDATE = (id) => '{{ url("admin/products") }}/' + id;

// ════════════════════════════════════════
// STATE UPLOADER
// slotFiles[i]    = File object baru yang dipilih user (null = belum ada)
// slotExisting[i] = path lama dari server, misal "products/abc.jpg" (null = tidak ada)
// ════════════════════════════════════════
var slotFiles    = [null, null, null, null, null];
var slotExisting = [null, null, null, null, null];
// Klik slot → buka file picker (hanya jika slot kosong)
function triggerSlot(i) {
    if (slotFiles[i] || slotExisting[i]) return; // sudah ada gambar, jangan re-trigger
    document.getElementById('slot-input-' + i).click();
}

// File dipilih
function handleSlotChange(e, i) {
    var file = e.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2 MB.');
        e.target.value = '';
        return;
    }

    slotFiles[i]    = file;
    slotExisting[i] = null;

    var reader = new FileReader();
    reader.onload = function(ev) { renderSlot(i, ev.target.result); };
    reader.readAsDataURL(file);
}

// Render preview di slot
function renderSlot(i, src) {
    var slot    = document.getElementById('slot-' + i);
    var empty   = document.getElementById('slot-empty-' + i);
    var preview = document.getElementById('slot-preview-' + i);
    var remove  = document.getElementById('slot-remove-' + i);

    empty.style.display   = 'none';
    preview.src           = src;
    preview.style.display = 'block';
    remove.style.display  = 'flex';
    slot.classList.add('filled');

    if (i === 0) {
        document.getElementById('slot-badge-0').style.display = 'block';
    }
}

// Hapus slot
function removeSlot(e, i) {
    e.stopPropagation();

    slotFiles[i]    = null;
    slotExisting[i] = null;

    var slot    = document.getElementById('slot-' + i);
    var empty   = document.getElementById('slot-empty-' + i);
    var preview = document.getElementById('slot-preview-' + i);
    var remove  = document.getElementById('slot-remove-' + i);
    var input   = document.getElementById('slot-input-' + i);

    input.value           = '';
    preview.src           = '';
    preview.style.display = 'none';
    empty.style.display   = 'flex';
    remove.style.display  = 'none';
    slot.classList.remove('filled');

    if (i === 0) {
        document.getElementById('slot-badge-0').style.display = 'none';
    }
}

// Reset semua slot
function resetSlots() {
    for (var i = 0; i < 5; i++) { removeSlot({ stopPropagation: function(){} }, i); }
}
var BASE_STORAGE = '{{ asset("storage") }}/';
// Isi slot dengan gambar existing (mode edit)
function loadExistingImages(images) {
    console.log('[Product] Loading existing images:', images); // debug
    for (var i = 0; i < Math.min(images.length, 5); i++) {
        slotExisting[i] = images[i];
        renderSlot(i, BASE_STORAGE + images[i]);
    }
}

// ── Intercept submit → kirim via fetch + FormData ──
document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var form = this;
    var fd   = new FormData(form);

    // Hapus images[] yang mungkin ada dari input file lama
    fd.delete('images[]');
    fd.delete('existing_images[]');
    // ✅ TAMBAH INI — sinyal ke server bahwa client sudah proses gambar
    fd.append('_images_processed', '1');
    // Inject file baru & path lama
    for (var i = 0; i < 5; i++) {
        if (slotFiles[i]) {
            fd.append('images[]', slotFiles[i]);
        } else if (slotExisting[i]) {
            fd.append('existing_images[]', slotExisting[i]);
        }
    }

    var btn = document.getElementById('submitBtn');
    btn.disabled    = true;
    btn.textContent = 'Menyimpan...';

    fetch(form.action, {
        method : 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
        body   : fd
    })
    .then(function(res) {
        if (res.redirected) { window.location.href = res.url; return; }
        if (res.ok)         { window.location.reload(); return; }
        return res.text().then(function(t) {
            console.error(t);
            alert('Terjadi kesalahan. Cek kembali isian form.');
            btn.disabled    = false;
            btn.textContent = 'Simpan';
        });
    })
    .catch(function(err) {
        console.error(err);
        alert('Gagal mengirim. Periksa koneksi internet.');
        btn.disabled    = false;
        btn.textContent = 'Simpan';
    });
});

// ── Buka modal tambah ──
function openCreateModal() {
    var form = document.getElementById('productForm');
    form.reset();
    document.getElementById('formMethod').value        = 'POST';
    form.action                                        = ROUTE_STORE;
    document.getElementById('modal-title').textContent = 'Tambah Produk Baru';
    document.getElementById('submitBtn').innerHTML     =
        '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Simpan Produk';
    document.getElementById('submitBtn').disabled      = false;
    document.getElementById('f-available').checked    = true;
    document.getElementById('f-featured').checked     = false;
    resetSlots();
    document.getElementById('productModal').classList.add('open');
}

// ── Buka modal edit ──
function openEditModal(id) {
    var el = document.getElementById('product-data-' + id);
    if (!el) { console.error('product-data-' + id + ' tidak ditemukan'); return; }
    var d = el.dataset;

    var form = document.getElementById('productForm');
    form.reset();
    document.getElementById('formMethod').value        = 'PUT';
    form.action                                        = ROUTE_UPDATE(id);
    document.getElementById('modal-title').textContent = 'Edit Produk';
    document.getElementById('submitBtn').innerHTML     =
        '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg> Update Produk';
    document.getElementById('submitBtn').disabled      = false;

    document.getElementById('f-name').value        = d.name        || '';
    document.getElementById('f-description').value = d.description || '';
    document.getElementById('f-price').value        = d.price       || '';
    document.getElementById('f-stock').value        = d.stock       || '';
    document.getElementById('f-category').value     = d.category    || '';
    document.getElementById('f-featured').checked   = d.isFeatured  === '1';
    document.getElementById('f-available').checked  = d.isAvailable === '1';

    resetSlots();
  var images = [];
try { 
    images = JSON.parse(d.images || '[]');
    console.log('[Product] Parsed images:', images); // debug
} catch(err) { 
    console.error('[Product] JSON.parse gagal:', err, '| Raw:', d.images);
    images = []; 
}

    if (images.length) loadExistingImages(images);

    document.getElementById('productModal').classList.add('open');
}

// ── Tutup backdrop ──
function closeModal(e) {
    if (e.target === document.getElementById('productModal')) {
        document.getElementById('productModal').classList.remove('open');
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.getElementById('productModal').classList.remove('open');
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') { e.preventDefault(); openCreateModal(); }
});
</script>
@endpush
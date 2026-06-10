{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Kelola Gallery')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Gallery</h1>
        <div class="page-breadcrumb">Upload foto dan video pertunjukan</div>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Upload Media
    </a>
</div>

{{-- ── FILTER TABS ── --}}
<div style="display:flex;gap:4px;background:var(--surface2);padding:4px;border-radius:10px;margin-bottom:22px;width:fit-content;border:1px solid var(--border);">
    @php
        $tabs = [
            ['label' => 'Semua ('.$galleries->total().')', 'type' => null],
            ['label' => 'Foto', 'type' => 'photo'],
            ['label' => 'Video', 'type' => 'video'],
        ];
    @endphp
    @foreach($tabs as $tab)
    <a href="{{ route('admin.gallery.index', $tab['type'] ? ['type'=>$tab['type']] : []) }}"
       style="padding:7px 18px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ (!request('type') && !$tab['type']) || request('type') === $tab['type']
                 ? 'background:var(--surface);color:var(--text);box-shadow:var(--shadow-sm);'
                 : 'color:var(--text-muted);' }}">
        {{ $tab['label'] }}
    </a>
    @endforeach
</div>

{{-- ── GALLERY GRID ── --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    @forelse($galleries as $item)
    <div class="card" style="overflow:hidden;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='var(--shadow)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='var(--shadow-sm)';this.style.transform='translateY(0)'">

        {{-- Thumbnail --}}
        <div style="position:relative;height:160px;background:var(--surface2);overflow:hidden;">
            @if($item->type === 'photo')
                <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .3s;"
                     onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
            @else
                @if($item->thumbnail)
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;background:#1a1535;display:flex;align-items:center;justify-content:center;">
                        <svg width="40" height="40" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                @endif
                {{-- Play overlay --}}
                <div style="position:absolute;inset:0;background:rgba(10,8,30,.5);display:flex;align-items:center;justify-content:center;">
                    <div style="width:48px;height:48px;background:rgba(255,255,255,.18);backdrop-filter:blur(4px);border-radius:50%;display:flex;align-items:center;justify-content:center;border:1.5px solid rgba(255,255,255,.3);">
                        <svg width="18" height="18" fill="#fff" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                    </div>
                </div>
            @endif

            {{-- Badges --}}
            <div style="position:absolute;top:10px;left:10px;display:flex;flex-direction:column;gap:5px;">
                <span class="badge {{ $item->type === 'photo' ? 'badge-brand' : 'badge-danger' }}"
                      style="font-size:10.5px;backdrop-filter:blur(4px);background:rgba(255,255,255,.9);color:{{ $item->type === 'photo' ? 'var(--brand)' : 'var(--danger)' }};">
                    {{ $item->type === 'photo' ? 'Foto' : 'Video' }}
                </span>
                @if($item->is_featured)
                <span class="badge badge-warning" style="font-size:10.5px;backdrop-filter:blur(4px);background:rgba(255,255,255,.9);">
                    ★ Featured
                </span>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div style="padding:14px 16px;">
            <div style="font-weight:700;font-size:13.5px;color:var(--text);margin-bottom:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4;">
                {{ $item->title }}
            </div>
            @if($item->description)
            <div style="font-size:12px;color:var(--text-muted);margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                {{ $item->description }}
            </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:10px;border-top:1px solid var(--border);">
                <span style="font-size:11px;color:var(--text-muted);">Order: {{ $item->order }}</span>
                <div style="display:flex;gap:5px;">
                    <a href="{{ route('admin.gallery.edit', $item) }}" title="Edit"
                       style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);color:var(--text-muted);text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)';this.style.background='var(--accent-soft)'"
                       onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)';this.style.background='transparent'">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus media ini?')" style="margin:0;">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus"
                                style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:none;color:var(--danger);cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.borderColor='#f5b8b0';this.style.background='var(--danger-soft)'"
                                onmouseout="this.style.borderColor='var(--border)';this.style.background='none'">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:span 4;text-align:center;padding:64px 20px;background:var(--surface);border-radius:var(--radius);border:1px solid var(--border);">
        <svg width="48" height="48" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 14px;display:block;opacity:.35;"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <div style="font-size:15px;font-weight:600;color:var(--text-muted);">Belum ada media</div>
        <div style="font-size:13px;color:var(--text-muted);margin-top:6px;">Upload foto atau video pertama kamu</div>
    </div>
    @endforelse
</div>

@if($galleries->hasPages())
<div style="margin-top:22px;">{{ $galleries->links() }}</div>
@endif

@endsection
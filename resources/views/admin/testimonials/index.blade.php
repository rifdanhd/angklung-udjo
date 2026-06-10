{{-- resources/views/admin/testimonials/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Kelola Testimoni')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Testimoni</h1>
        <div class="page-breadcrumb">Feedback dari pengunjung Saung Angklung Udjo</div>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Tambah Testimoni
    </a>
</div>

{{-- ── STAT CARDS ── --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px;">
    <div class="card" style="padding:20px 22px;display:flex;align-items:center;gap:14px;border-left:3px solid var(--accent);">
        <div style="width:44px;height:44px;border-radius:11px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="19" height="19" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);">Total Testimoni</div>
            <div style="font-size:26px;font-weight:800;color:var(--text);letter-spacing:-1px;line-height:1;margin-top:4px;">{{ $testimonials->total() }}</div>
        </div>
    </div>

    <div class="card" style="padding:20px 22px;display:flex;align-items:center;gap:14px;border-left:3px solid var(--gold);">
        <div style="width:44px;height:44px;border-radius:11px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="19" height="19" fill="#e8b84b" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);">Rata-rata Rating</div>
            <div style="font-size:26px;font-weight:800;color:var(--text);letter-spacing:-1px;line-height:1;margin-top:4px;">{{ number_format($testimonials->avg('rating') ?? 0, 1) }} ★</div>
        </div>
    </div>

    <div class="card" style="padding:20px 22px;display:flex;align-items:center;gap:14px;border-left:3px solid var(--success);">
        <div style="width:44px;height:44px;border-radius:11px;background:var(--success-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="19" height="19" fill="none" stroke="var(--success)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
        </div>
        <div>
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);">Rating 5 Bintang</div>
            <div style="font-size:26px;font-weight:800;color:var(--text);letter-spacing:-1px;line-height:1;margin-top:4px;">{{ $testimonials->where('rating', 5)->count() }}</div>
        </div>
    </div>
</div>

{{-- ── TABLE ── --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Pengunjung</th>
                    <th>Rating</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:40px;height:40px;border-radius:50%;overflow:hidden;flex-shrink:0;border:2px solid var(--border);">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--brand),var(--accent));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:15px;color:#fff;">
                                        {{ substr($testimonial->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:13.5px;color:var(--text);">{{ $testimonial->name }}</div>
                                <div style="font-size:12px;color:var(--text-muted);">{{ $testimonial->country ?? 'No Location' }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div style="display:flex;gap:2px;">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="14" height="14" viewBox="0 0 20 20" style="fill:{{ $i <= $testimonial->rating ? '#e8b84b' : '#e8e8f0' }}">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </td>

                    <td>
                        <p style="font-size:13px;color:var(--text-muted);font-style:italic;max-width:280px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            "{{ $testimonial->message }}"
                        </p>
                    </td>

                    <td>
                        @if($testimonial->is_approved)
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>

                    <td>
                        <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                            @if(!$testimonial->is_approved)
                            <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" title="Setujui"
                                        style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid #9ddfc0;background:var(--success-soft);color:var(--success);cursor:pointer;transition:all .15s;"
                                        onmouseover="this.style.background='var(--success)';this.style.color='#fff'" onmouseout="this.style.background='var(--success-soft)';this.style.color='var(--success)'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" title="Edit"
                               style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:var(--surface);color:var(--text-muted);transition:all .15s;text-decoration:none;"
                               onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)';this.style.background='var(--accent-soft)'"
                               onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)';this.style.background='var(--surface)'">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                                  onsubmit="return confirm('Hapus testimoni dari {{ $testimonial->name }}?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                        style="width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:var(--surface);color:var(--danger);cursor:pointer;transition:all .15s;"
                                        onmouseover="this.style.borderColor='#f5b8b0';this.style.background='var(--danger-soft)'"
                                        onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface)'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:56px 20px;">
                        <svg width="40" height="40" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:.4;"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <div style="font-size:14px;color:var(--text-muted);">Belum ada testimoni</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($testimonials->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">
        {{ $testimonials->links() }}
    </div>
    @endif
</div>

@endsection
@extends('admin.layouts.app')


@section('title', 'Manajemen Promo')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Menggunakan JSDelivr untuk Alpine JS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@push('styles')
<style>
.stat-card { background: white; border-radius: 12px; padding: 20px 24px; border: 1px solid #f0f0f0; }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.badge-aktif      { background: #dcfce7; color: #15803d; }
.badge-nonaktif   { background: #f1f5f9; color: #64748b; }
.badge-kadaluarsa { background: #fee2e2; color: #dc2626; }
.badge-habis      { background: #fef9c3; color: #854d0e; }
.badge-belum_mulai{ background: #e0f2fe; color: #0369a1; }
.type-chip { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; background: #f1f5f9; color: #475569; }
</style>
@endpush

@section('content')
<div class="p-6 lg:p-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Promo</h1>
            <p class="text-sm text-gray-500 mt-1">Dashboard › Promo</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.promos.all-claims') }}"
               class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Semua Klaim
            </a>
            <a href="{{ route('admin.promos.create') }}"
               class="flex items-center gap-2 px-5 py-2 bg-[#1a1445] text-white rounded-lg text-sm font-semibold hover:bg-[#2a2460] transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Promo
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm font-medium flex items-center gap-2">
        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Total Promo</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Aktif</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Kadaluarsa</p>
            <p class="text-3xl font-bold text-red-500 mt-2">{{ $stats['expired'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Total Klaim</p>
            <p class="text-3xl font-bold text-[#c4a47c] mt-2">{{ $stats['claims'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama promo atau kode..."
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div>
                <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <option value="all">Semua Tipe</option>
                    <option value="voucher" @selected(request('type')=='voucher')>Voucher Diskon</option>
                    <option value="b1g1" @selected(request('type')=='b1g1')>Buy 1 Get 1</option>
                    <option value="early_bird" @selected(request('type')=='early_bird')>Early Bird</option>
                    <option value="bundling" @selected(request('type')=='bundling')>Paket Bundling</option>
                    <option value="other" @selected(request('type')=='other')>Lainnya</option>
                </select>
            </div>
            <div>
                <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <option value="">Semua Status</option>
                    <option value="active" @selected(request('status')=='active')>Aktif</option>
                    <option value="inactive" @selected(request('status')=='inactive')>Nonaktif</option>
                    <option value="expired" @selected(request('status')=='expired')>Kadaluarsa</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-[#1a1445] text-white rounded-lg text-sm font-semibold hover:bg-[#2a2460] transition">
                Filter
            </button>
            @if(request()->hasAny(['search','type','status']))
            <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50 transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Promo</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Tipe</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Diskon</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Periode</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Kuota</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-center px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($promos as $promo)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-gray-800">{{ $promo->name }}</p>
                        @if($promo->code)
                        <p class="text-xs text-gray-400 font-mono mt-0.5 bg-gray-100 inline-block px-2 py-0.5 rounded">{{ $promo->code }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="type-chip">{{ $promo->typeLabel() }}</span>
                    </td>
                    <td class="px-5 py-4 font-bold text-[#c4a47c]">
                        {{ $promo->discountLabel() }}
                    </td>
                    <td class="px-5 py-4 text-xs text-gray-500">
                        <div>{{ $promo->start_date->format('d M Y') }}</div>
                        <div class="text-gray-400">s/d {{ $promo->end_date->format('d M Y') }}</div>
                    </td>
                    <td class="px-5 py-4">
                        @if($promo->quota)
                        <div class="text-sm font-semibold text-gray-700">{{ $promo->used_count }} / {{ $promo->quota }}</div>
                        <div class="w-24 h-1.5 bg-gray-100 rounded-full mt-1">
                            <div class="h-1.5 rounded-full {{ $promo->isQuotaFull() ? 'bg-red-400' : 'bg-green-400' }}"
                                 style="width: {{ min(100, ($promo->used_count / $promo->quota) * 100) }}%"></div>
                        </div>
                        @else
                        <span class="text-xs text-gray-400">Unlimited</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @php $badge = $promo->statusBadge(); @endphp
                        <span class="badge badge-{{ $badge }}">
                            {{ ucfirst(str_replace('_', ' ', $badge)) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Klaim --}}
                            <a href="{{ route('admin.promos.claims', $promo) }}"
                               title="Lihat Klaim"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                            </a>
                            {{-- Toggle active --}}
                            <form method="POST" action="{{ route('admin.promos.toggle', $promo) }}">
                                @csrf @method('PATCH')
                                <button type="submit" title="{{ $promo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg transition
                                    {{ $promo->is_active ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9"/></svg>
                                </button>
                            </form>
                            {{-- Edit --}}
                            <a href="{{ route('admin.promos.edit', $promo) }}"
                               title="Edit"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}"
                                  onsubmit="return confirm('Hapus promo {{ $promo->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <p class="font-medium">Belum ada promo</p>
                        <p class="text-sm mt-1">Klik "+ Tambah Promo" untuk membuat promo pertama</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $promos->links() }}
        </div>
    </div>

</div>
@endsection

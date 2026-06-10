@extends('admin.layouts.app')

@section('title', 'Semua Klaim Promo')

@push('styles')
<style>
.stat-card { background: white; border-radius: 12px; padding: 20px 24px; border: 1px solid #f0f0f0; }
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
.badge-yellow { background: #fef9c3; color: #854d0e; }
.badge-blue   { background: #dbeafe; color: #1d4ed8; }
.badge-green  { background: #dcfce7; color: #15803d; }
.badge-red    { background: #fee2e2; color: #dc2626; }
.badge-gray   { background: #f1f5f9; color: #64748b; }
</style>
@endpush

@section('content')
<div class="p-6 lg:p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.promos.index') }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Semua Klaim Promo</h1>
                <p class="text-sm text-gray-500 mt-1">Dashboard › Promo › Klaim</p>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm font-medium">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Total Klaim</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Menunggu</p>
            <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $stats['pending'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Disetujui</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['approved'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Digunakan</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['used'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, email, kode klaim..."
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div>
                <select name="promo_id" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
                    <option value="">Semua Promo</option>
                    @foreach($promos as $p)
                    <option value="{{ $p->id }}" @selected(request('promo_id') == $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status')=='pending')>Menunggu</option>
                    <option value="approved" @selected(request('status')=='approved')>Disetujui</option>
                    <option value="used" @selected(request('status')=='used')>Digunakan</option>
                    <option value="rejected" @selected(request('status')=='rejected')>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-[#1a1445] text-white rounded-lg text-sm font-semibold hover:bg-[#2a2460] transition">Filter</button>
            @if(request()->hasAny(['search','status','promo_id']))
            <a href="{{ route('admin.promos.all-claims') }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50 transition">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Kode Klaim</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Promo</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Diskon</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Kunjungan</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($claims as $claim)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <p class="font-mono text-xs font-bold text-indigo-700 bg-indigo-50 inline-block px-2 py-1 rounded">{{ $claim->claim_code }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $claim->created_at->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-semibold text-gray-800">{{ $claim->name }}</p>
                        <p class="text-xs text-gray-400">{{ $claim->email }}</p>
                        <p class="text-xs text-gray-400">{{ $claim->phone }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-medium text-gray-700">{{ $claim->promo->name ?? '-' }}</p>
                        @if($claim->promo?->code)
                        <p class="text-xs font-mono text-gray-400">{{ $claim->promo->code }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-xs text-gray-400 line-through">Rp{{ number_format($claim->original_amount, 0, ',', '.') }}</p>
                        <p class="text-sm font-bold text-green-600">-Rp{{ number_format($claim->discount_amount, 0, ',', '.') }}</p>
                        <p class="text-sm font-bold text-gray-800">Rp{{ number_format($claim->final_amount, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ $claim->visit_date ? $claim->visit_date->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="badge badge-{{ $claim->statusColor() }}">{{ $claim->statusLabel() }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.promos.claim.status', $claim) }}" class="flex gap-1">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="border border-gray-200 rounded-lg px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-300">
                                <option value="pending"  @selected($claim->status == 'pending')>Menunggu</option>
                                <option value="approved" @selected($claim->status == 'approved')>Setujui</option>
                                <option value="used"     @selected($claim->status == 'used')>Tandai Dipakai</option>
                                <option value="rejected" @selected($claim->status == 'rejected')>Tolak</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <p class="font-medium">Belum ada klaim</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-50">
            {{ $claims->links() }}
        </div>
    </div>

</div>
@endsection

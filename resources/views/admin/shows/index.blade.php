{{-- resources/views/admin/shows/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Kelola Pertunjukan')

@section('content')
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Pertunjukan</h1>
                <p class="text-gray-600 mt-1">Manage jadwal pertunjukan Saung Angklung Udjo</p>
            </div>
            <a href="{{ route('admin.shows.create') }}"
                class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pertunjukan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Total Pertunjukan</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $shows->total() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Aktif</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $shows->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Tidak Aktif</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $shows->where('is_active', false)->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Mendatang</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $shows->where('date', '>=', now())->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Pertunjukan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal
                            & Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Kapasitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($shows as $show)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-16 h-12 flex-shrink-0">
                                        @if ($show->image)
                                            <img src="{{ asset('storage/' . $show->image) }}" alt="{{ $show->title }}"
                                                class="w-full h-full rounded-lg object-cover shadow-sm border border-gray-200">
                                        @else
                                            <div
                                                class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-[10px] font-bold">
                                                NO IMG
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 leading-tight">{{ $show->title }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($show->description, 40) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    {{ $show->time }}
                                    <p class="text-gray-500">{{ $show->time }} WIB</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-800">{{ $show->capacity }} kapasitas</p>
                                    <p class="text-xs text-gray-400">Total kursi</p>
                                </div>
                            </td>

                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="font-medium text-gray-800">Rp
                                        {{ number_format($show->price_domestic, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Asing: Rp
                                        {{ number_format($show->price_foreign, 0, ',', '.') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($show->is_active)
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.shows.edit', $show) }}"
                                        class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.shows.destroy', $show) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <p class="text-lg font-medium">Belum ada pertunjukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($shows->hasPages())
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $shows->links() }}
            </div>
        @endif
    </div>
@endsection

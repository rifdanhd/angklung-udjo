{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Kelola Booking')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Booking</h1>
        <p class="text-gray-600 mt-1">Manage semua booking pertunjukan</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Total Booking</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $bookings->total() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Pending</p>
            <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $bookings->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Confirmed</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $bookings->where('status', 'confirmed')->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-500 text-sm">Cancelled</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $bookings->where('status', 'cancelled')->count() }}</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, email, kode booking..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg transition">
                Filter
            </button>
            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.bookings.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode Booking</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pemesan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Pertunjukan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tiket</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-amber-600">{{ $booking->booking_code }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $booking->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->email }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->phone }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->nationality }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $booking->show->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->show->date->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->show->time->format('H:i') }} WIB</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $booking->num_tickets }} tiket</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-amber-600">Rp
                                    {{ number_format($booking->total_price ?? $booking->total_harga, 0, ',', '.') }}</span>
                                @if($booking->klaim_hompimplay)
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        🎁 Hompimplay
                                    </span>
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($booking->status === 'pending')
                                        <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-800 p-2 hover:bg-green-50 rounded transition"
                                                title="Konfirmasi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition"
                                                onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                                                title="Batalkan">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <button onclick="viewDetails({{ $booking->id }})"
                                        class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition"
                                        title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium">Belum ada booking</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bookings->hasPages())
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

@endsection

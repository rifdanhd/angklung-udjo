{{-- resources/views/shows/booking-form.blade.php --}}
<div class="bg-white rounded-2xl shadow-2xl p-8 border border-amber-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Pesan Tiket Sekarang</h2>
    
    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="show_id" value="{{ $show->id }}">

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Tiket</label>
            <input type="number" name="quantity" min="1" max="{{ $show->available_seats }}" 
                   class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-amber-500 focus:ring-amber-500 transition"
                   placeholder="Contoh: 2">
        </div>

        <div class="p-4 bg-amber-50 rounded-xl">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Harga per Tiket</span>
                <span>Rp {{ number_format($show->price_domestic, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg text-amber-900 border-t pt-2 mt-2">
                <span>Estimasi Total</span>
                <span id="total-price">Rp 0</span>
            </div>
        </div>

        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:scale-[1.02]">
            Lanjutkan ke Pembayaran
        </button>
    </form>
</div>
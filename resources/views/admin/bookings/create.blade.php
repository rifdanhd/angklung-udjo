{{-- resources/views/bookings/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking Pertunjukan - ' . $show->title)

@section('content')

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shows.index') }}" class="hover:text-amber-600">Pertunjukan</a>
            <span class="mx-2">/</span>
            <span class="text-amber-600">Booking</span>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Booking Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">Form Booking</h1>

                    @if($show->isFull())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                            <p class="font-semibold">Maaf, pertunjukan ini sudah penuh!</p>
                        </div>
                    @else
                        <form action="{{ route('bookings.store', $show) }}" method="POST" id="booking-form">
                            @csrf

                            <div class="space-y-6">
                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                           placeholder="contoh@email.com"
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        No. Telepon/WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                           placeholder="08123456789"
                                           required>
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nationality -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kewarganegaraan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="nationality" 
                                            id="nationality"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('nationality') border-red-500 @enderror"
                                            required>
                                        <option value="Indonesia" {{ old('nationality') === 'Indonesia' ? 'selected' : '' }}>Indonesia (WNI)</option>
                                        <option value="Asing" {{ old('nationality') === 'Asing' ? 'selected' : '' }}>Asing (WNA)</option>
                                    </select>
                                    @error('nationality')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jumlah Tiket -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jumlah Tiket <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="num_tickets" 
                                           id="num_tickets"
                                           value="{{ old('num_tickets', 1) }}"
                                           min="1"
                                           max="{{ min($show->available_seats, 10) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('num_tickets') border-red-500 @enderror"
                                           required>
                                    <p class="text-gray-500 text-sm mt-1">Maksimal 10 tiket per booking. Tersisa: {{ $show->available_seats }} kursi</p>
                                    @error('num_tickets')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Catatan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                              placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                                </div>

                                <!-- Terms -->
                                <div>
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               name="agree_terms" 
                                               required
                                               class="w-5 h-5 mt-1 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                                        <span class="text-sm text-gray-700">
                                            Saya setuju dengan <a href="#" class="text-amber-600 hover:text-amber-700 font-semibold">syarat dan ketentuan</a> yang berlaku
                                        </span>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" 
                                        class="w-full bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition transform hover:scale-105 flex items-center justify-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Konfirmasi Booking
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Booking</h3>

                    <!-- Show Info -->
                    <div class="mb-6 pb-6 border-b">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ $show->title }}</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $show->date->format('d F Y') }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $show->time->format('H:i') }} WIB
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $show->available_seats }} / {{ $show->capacity }} kursi tersisa
                            </div>
                        </div>
                    </div>

                    <!-- Price Calculation -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga per tiket:</span>
                            <span class="font-semibold" id="price-per-ticket">
                                Rp {{ number_format($show->price_domestic, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Jumlah tiket:</span>
                            <span class="font-semibold" id="ticket-count">1</span>
                        </div>
                        <div class="pt-3 border-t flex justify-between">
                            <span class="font-bold text-gray-800">Total:</span>
                            <span class="font-bold text-2xl text-amber-600" id="total-price">
                                Rp {{ number_format($show->price_domestic, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-amber-800">
                                <p class="font-semibold mb-1">Informasi Penting</p>
                                <ul class="space-y-1 text-xs">
                                    <li>• Kode booking akan dikirim via email</li>
                                    <li>• Harap datang 15 menit sebelum pertunjukan</li>
                                    <li>• Pembayaran di tempat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const priceDomestic = {{ $show->price_domestic }};
    const priceForeign = {{ $show->price_foreign }};
    
    const nationalitySelect = document.getElementById('nationality');
    const numTicketsInput = document.getElementById('num_tickets');
    const pricePerTicketEl = document.getElementById('price-per-ticket');
    const ticketCountEl = document.getElementById('ticket-count');
    const totalPriceEl = document.getElementById('total-price');

    function calculateTotal() {
        const nationality = nationalitySelect.value;
        const numTickets = parseInt(numTicketsInput.value) || 1;
        const pricePerTicket = nationality === 'Indonesia' ? priceDomestic : priceForeign;
        const total = pricePerTicket * numTickets;

        pricePerTicketEl.textContent = 'Rp ' + pricePerTicket.toLocaleString('id-ID');
        ticketCountEl.textContent = numTickets;
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    nationalitySelect.addEventListener('change', calculateTotal);
    numTicketsInput.addEventListener('input', calculateTotal);
</script>
@endpush
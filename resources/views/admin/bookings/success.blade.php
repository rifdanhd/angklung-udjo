{{-- resources/views/bookings/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Booking Berhasil')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        
        <div class="max-w-3xl mx-auto">
            
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Booking Berhasil!</h1>
                <p class="text-lg text-gray-600">Terima kasih telah melakukan booking di Saung Angklung Udjo</p>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-600 to-amber-700 p-6 text-white">
                    <div class="text-center">
                        <p class="text-sm mb-2 opacity-90">Kode Booking</p>
                        <h2 class="text-3xl font-bold mb-4">{{ $booking->booking_code }}</h2>
                        <div class="inline-block bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full">
                            <span class="text-sm font-semibold">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="p-6 space-y-6">
                    
                    <!-- Show Info -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Detail Pertunjukan
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Pertunjukan</p>
                                <p class="font-semibold text-gray-800">{{ $booking->show->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-800">
                                    {{ $booking->show->date->format('d F Y') }}, {{ $booking->show->time->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Data Pemesan
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $booking->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-semibold text-gray-800">{{ $booking->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">No. Telepon</p>
                                <p class="font-semibold text-gray-800">{{ $booking->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kewarganegaraan</p>
                                <p class="font-semibold text-gray-800">{{ $booking->nationality }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Rincian Pembayaran
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Tiket</span>
                                <span class="font-semibold">{{ $booking->num_tickets }} tiket</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t">
                                <span class="font-bold text-gray-800">Total Pembayaran</span>
                                <span class="font-bold text-2xl text-amber-600">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Important Info -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-3">Informasi Penting</h4>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Kode booking telah dikirim ke email <strong>{{ $booking->email }}</strong></span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Tunjukkan kode booking ini saat datang ke Saung Angklung Udjo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Harap datang <strong>15 menit sebelum</strong> pertunjukan dimulai</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Pembayaran dilakukan di tempat (cash/transfer)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button onclick="window.print()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Booking
                </button>
                <a href="https://wa.me/6222727171?text=Halo, saya sudah booking dengan kode {{ $booking->booking_code }}" 
                   target="_blank"
                   class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
                <a href="{{ route('home') }}" 
                   class="flex-1 bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Home
                </a>
            </div>

        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
    }
</style>
@endpush
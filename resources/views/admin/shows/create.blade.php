{{-- resources/views/admin/shows/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Pertunjukan')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.shows.index') }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Pertunjukan</h1>
            <p class="text-gray-600 mt-1">Buat jadwal pertunjukan baru</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg p-6">
    <form action="{{ route('admin.shows.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Judul Pertunjukan <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Contoh: Pertunjukan Angklung Sore"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('description') border-red-500 @enderror"
                          placeholder="Deskripsikan pertunjukan..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="date" 
                       value="{{ old('date') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('date') border-red-500 @enderror"
                       required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Time -->
            <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Waktu Pertunjukan <span class="text-red-500">*</span>
    </label>

   {{-- Ganti bagian select waktu dengan ini --}}
<select name="time"
    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500"
    required>
    <option value="">-- Pilih Waktu --</option>
    <option value="10:00">10.00 – 11.30</option>
    <option value="15:30">15.30 – 17.00</option>
    {{-- Tambahkan opsi di bawah ini --}}
    <option value="13:00 & 15:30">Sabtu: 13.00 & 15.30</option>
</select>

    @error('time')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


            <!-- Capacity -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kapasitas <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="capacity" 
                       value="{{ old('capacity') }}"
                       min="1"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('capacity') border-red-500 @enderror"
                       placeholder="Contoh: 100"
                       required>
                @error('capacity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Domestic -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Domestik (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="price_domestic" 
                       value="{{ old('price_domestic') }}"
                       min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('price_domestic') border-red-500 @enderror"
                       placeholder="50000"
                       required>
                @error('price_domestic')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price Foreign -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga Asing (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="price_foreign" 
                       value="{{ old('price_foreign') }}"
                       min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('price_foreign') border-red-500 @enderror"
                       placeholder="100000"
                       required>
                @error('price_foreign')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Pertunjukan
                </label>
                <input type="file" 
                       name="image" 
                       accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('image') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="md:col-span-2">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                    <span class="text-sm font-medium text-gray-700">Aktifkan pertunjukan ini</span>
                </label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center gap-4 mt-8 pt-6 border-t">
            <button type="submit" 
                    class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pertunjukan
            </button>
            <a href="{{ route('admin.shows.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

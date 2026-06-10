{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Produk</h1>
            <p class="text-gray-600 mt-1">Buat produk baru untuk dijual</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Basic Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Produk</h2>
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Angklung Dasar 8 Nada"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsikan produk secara detail..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price & Stock -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('price') border-red-500 @enderror"
                                   placeholder="50000"
                                   required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="stock" 
                                   value="{{ old('stock') }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                                   placeholder="10"
                                   required>
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Gambar Produk</h2>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Gambar (Max 5 gambar)
                    </label>
                    <input type="file" 
                           name="images[]" 
                           multiple
                           accept="image/*"
                           id="product-images"
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('images') border-red-500 @enderror">
                    <p class="text-gray-500 text-sm mt-2">
                        Format: JPG, PNG. Maksimal 2MB per gambar. Gambar pertama akan jadi thumbnail utama.
                    </p>
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div id="image-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Category & Status -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Kategori & Status</h2>
                
                <div class="space-y-4">
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('category') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="angklung" {{ old('category') === 'angklung' ? 'selected' : '' }}>Angklung</option>
                            <option value="arumba" {{ old('category') === 'arumba' ? 'selected' : '' }}>Arumba</option>
                            <option value="calung" {{ old('category') === 'calung' ? 'selected' : '' }}>Calung</option>
                            <option value="souvenir" {{ old('category') === 'souvenir' ? 'selected' : '' }}>Souvenir</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Featured -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Produk Featured</span>
                                <p class="text-xs text-gray-500">Tampilkan di homepage</p>
                            </div>
                        </label>
                    </div>

                    <!-- Is Available -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_available" 
                                   value="1"
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Tersedia</span>
                                <p class="text-xs text-gray-500">Produk bisa dibeli</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-amber-800">
                        <h4 class="font-semibold mb-2">Tips Produk Berkualitas</h4>
                        <ul class="space-y-1 text-xs">
                            <li>• Gunakan foto produk yang jelas dan berkualitas tinggi</li>
                            <li>• Tulis deskripsi lengkap dan detail</li>
                            <li>• Sebutkan material dan ukuran produk</li>
                            <li>• Upload minimal 3-4 foto dari berbagai angle</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex items-center gap-4 mt-6 bg-white rounded-xl shadow-lg p-6">
        <button type="submit" 
                class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Produk
        </button>
        <a href="{{ route('admin.products.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold transition">
            Batal
        </a>
    </div>

</form>

@endsection

@push('scripts')
<script>
    // Image Preview
    const imageInput = document.getElementById('product-images');
    const previewContainer = document.getElementById('image-preview');

    imageInput.addEventListener('change', function(e) {
        previewContainer.innerHTML = '';
        const files = Array.from(e.target.files);

        if (files.length > 5) {
            alert('Maksimal 5 gambar!');
            e.target.value = '';
            return;
        }

        files.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" 
                         class="w-full h-32 object-cover rounded-lg shadow">
                    ${index === 0 ? '<span class="absolute top-2 left-2 bg-amber-500 text-white text-xs px-2 py-1 rounded">Utama</span>' : ''}
                `;
                previewContainer.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        });
    });

    // Price formatting
    const priceInput = document.querySelector('input[name="price"]');
    priceInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');
    });
</script>
@endpush
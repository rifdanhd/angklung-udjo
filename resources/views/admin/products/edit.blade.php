{{-- resources/views/admin/products/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
            <p class="text-gray-600 mt-1">Update informasi produk</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                               value="{{ old('name', $product->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-500 @enderror"
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
                                  required>{{ old('description', $product->description) }}</textarea>
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
                                   value="{{ old('price', $product->price) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('price') border-red-500 @enderror"
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
                                   value="{{ old('stock', $product->stock) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                                   required>
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Images -->
            @if($product->images && count($product->images) > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Gambar Saat Ini</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->images as $index => $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image) }}" 
                             alt="Product Image {{ $index + 1 }}" 
                             class="w-full h-32 object-cover rounded-lg shadow">
                        @if($index === 0)
                        <span class="absolute top-2 left-2 bg-amber-500 text-white text-xs px-2 py-1 rounded">
                            Utama
                        </span>
                        @endif
                        <button type="button" 
                                onclick="deleteImage({{ $product->id }}, '{{ $image }}', this)"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Upload New Images -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Upload Gambar Baru</h2>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tambah Gambar (Max 5 gambar total)
                    </label>
                    <input type="file" 
                           name="images[]" 
                           multiple
                           accept="image/*"
                           id="product-images"
                           class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <p class="text-gray-500 text-sm mt-2">
                        Format: JPG, PNG. Maksimal 2MB per gambar. 
                        @if($product->images)
                            Saat ini: {{ count($product->images) }} gambar. 
                        @endif
                    </p>
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                required>
                            <option value="">Pilih Kategori</option>
                            <option value="angklung" {{ old('category', $product->category) === 'angklung' ? 'selected' : '' }}>Angklung</option>
                            <option value="arumba" {{ old('category', $product->category) === 'arumba' ? 'selected' : '' }}>Arumba</option>
                            <option value="calung" {{ old('category', $product->category) === 'calung' ? 'selected' : '' }}>Calung</option>
                            <option value="souvenir" {{ old('category', $product->category) === 'souvenir' ? 'selected' : '' }}>Souvenir</option>
                        </select>
                    </div>

                    <!-- Is Featured -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
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
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                                   class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Tersedia</span>
                                <p class="text-xs text-gray-500">Produk bisa dibeli</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <div class="text-sm text-blue-800">
                    <h4 class="font-semibold mb-2">Info Produk</h4>
                    <ul class="space-y-1 text-xs">
                        <li>• Dibuat: {{ $product->created_at->format('d M Y H:i') }}</li>
                        <li>• Terakhir update: {{ $product->updated_at->format('d M Y H:i') }}</li>
                        <li>• Slug: <code class="bg-blue-100 px-1 rounded">{{ $product->slug }}</code></li>
                    </ul>
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
            Update Produk
        </button>
        <a href="{{ route('admin.products.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold transition">
            Batal
        </a>
        <form action="{{ route('admin.products.destroy', $product) }}" 
              method="POST" 
              onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
              class="ml-auto">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-100 hover:bg-red-200 text-red-600 px-8 py-3 rounded-lg font-semibold transition">
                Hapus Produk
            </button>
        </form>
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

        const currentImages = {{ count($product->images ?? []) }};
        const maxImages = 5 - currentImages;

        if (files.length > maxImages) {
            alert(`Maksimal ${maxImages} gambar lagi! (Total max 5 gambar)`);
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
                `;
                previewContainer.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        });
    });

    // Delete Image Function
    function deleteImage(productId, imagePath, button) {
        if (!confirm('Yakin ingin menghapus gambar ini?')) {
            return;
        }

        fetch(`/admin/products/${productId}/delete-image`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image: imagePath })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                button.closest('.group').remove();
                alert('Gambar berhasil dihapus!');
            } else {
                alert('Gagal menghapus gambar!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan!');
        });
    }
</script>
@endpush
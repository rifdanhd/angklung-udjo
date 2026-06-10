{{-- Partial form untuk create & edit produk --}}
<div class="grid grid-cols-1 gap-6">

    {{-- Nama Produk --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nama Produk <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="name" 
               value="{{ old('name', $product->name ?? '') }}"
               placeholder="Misal: Angklung Mini"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
               required>
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Deskripsi <span class="text-red-500">*</span>
        </label>
        <textarea name="description" 
                  rows="4"
                  placeholder="Deskripsi produk..."
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                  required>{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Harga & Stok --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Harga <span class="text-red-500">*</span>
            </label>
            <input type="number" 
                   name="price" 
                   value="{{ old('price', $product->price ?? '') }}"
                   min="0"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror"
                   required>
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Stok <span class="text-red-500">*</span>
            </label>
            <input type="number" 
                   name="stock" 
                   value="{{ old('stock', $product->stock ?? '') }}"
                   min="0"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                   required>
            @error('stock')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Kategori <span class="text-red-500">*</span>
        </label>
        <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category') border-red-500 @enderror" required>
            <option value="">Pilih kategori…</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ old('category', $product->category ?? '') == $category ? 'selected' : '' }}>
                    {{ ucfirst($category) }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gambar --}}
    @if(!empty($product?->images))
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Saat Ini</label>
            <div class="flex gap-2 flex-wrap mb-2">
                @foreach ($product->images as $img)
                    <img src="{{ asset('storage/' . $img) }}" class="w-32 h-24 object-cover rounded border">
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Gambar Baru (Opsional)
        </label>
        <input type="file" 
               name="images[]" 
               accept="image/*" multiple
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images') border-red-500 @enderror">
        <p class="text-gray-500 text-sm mt-1">Bisa pilih satu atau lebih gambar (max 2MB/file)</p>
        @error('images')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Featured & Available --}}
    <div class="flex gap-6">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-2 focus:ring-yellow-500">
            <span class="text-sm font-medium text-gray-700">Produk Unggulan</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_available" value="1"
                   {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 text-green-500 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
            <span class="text-sm font-medium text-gray-700">Tersedia</span>
        </label>
    </div>

</div>

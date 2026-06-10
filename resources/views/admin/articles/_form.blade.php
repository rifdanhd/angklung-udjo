{{-- Partial form untuk create & edit artikel --}}
<div class="grid grid-cols-1 gap-6">
    {{-- Title --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Judul <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="title" 
               value="{{ old('title', $article->title ?? '') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('title') border-red-500 @enderror"
               required>
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Excerpt --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Excerpt <span class="text-red-500">*</span>
        </label>
        <textarea name="excerpt" 
                  rows="3"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                  required>{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
        @error('excerpt')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tipe Artikel --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Artikel</label>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" 
                       name="article_type" 
                       value="internal" 
                       {{ old('article_type', empty($article->external_url ?? '') ? 'internal' : 'external') == 'internal' ? 'checked' : '' }}
                       onchange="toggleArticleType()" 
                       class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-2 focus:ring-amber-500">
                <span class="text-sm font-medium text-gray-700">Artikel Internal (Halaman Sendiri)</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" 
                       name="article_type" 
                       value="external" 
                       {{ old('article_type', !empty($article->external_url ?? '') ? 'external' : 'internal') == 'external' ? 'checked' : '' }}
                       onchange="toggleArticleType()" 
                       class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-2 focus:ring-amber-500">
                <span class="text-sm font-medium text-gray-700">Link Eksternal (Kompas, dll)</span>
            </label>
        </div>
    </div>

    {{-- External URL --}}
    <div id="external_url_field" style="display: none;">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            URL Artikel Eksternal
        </label>
        <input type="url" 
               name="external_url" 
               id="external_url"
               value="{{ old('external_url', $article->external_url ?? '') }}"
               placeholder="https://www.kompas.com/artikel-contoh"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('external_url') border-red-500 @enderror">
        <p class="text-xs text-gray-500 mt-1">Masukkan URL lengkap artikel dari sumber eksternal</p>
        @error('external_url')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Content --}}
    <div id="content_field">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Konten <span class="text-red-500" id="content_required">*</span>
        </label>
        <textarea name="content" 
                  id="content"
                  rows="8"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content', $article->content ?? '') }}</textarea>
        @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Kategori <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="category" 
               value="{{ old('category', $article->category ?? '') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('category') border-red-500 @enderror"
               required>
        @error('category')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Featured Image --}}
    @if(!empty($article?->featured_image))
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Saat Ini</label>
            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                 alt="{{ $article->title }}" 
                 class="w-48 h-32 object-cover rounded-lg mb-2">
        </div>
    @endif
    
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Gambar Utama / Featured Image (Opsional)
        </label>
        <input type="file" 
               name="featured_image" 
               accept="image/*"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('featured_image') border-red-500 @enderror">
        @error('featured_image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- ========== CAROUSEL IMAGES (BARU) ========== --}}
    <div class="border border-dashed border-amber-400 rounded-lg p-5 bg-amber-50">
        <label class="block text-sm font-semibold text-gray-700 mb-1">
            📸 Foto Carousel (Opsional)
        </label>
        <p class="text-xs text-gray-500 mb-3">Bisa pilih lebih dari 1 foto. Akan ditampilkan sebagai carousel di halaman artikel.</p>

        <input type="file" 
               name="carousel_images[]" 
               id="carousel_images"
               multiple 
               accept="image/*"
               onchange="previewCarousel(event)"
               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('carousel_images.*') border-red-500 @enderror">
        @error('carousel_images.*')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Preview foto baru yang dipilih --}}
        <div id="carousel_preview" class="flex gap-3 flex-wrap mt-4"></div>

        {{-- Foto carousel yang sudah tersimpan (mode edit) --}}
        @if(isset($article) && $article->images->count())
        <div class="mt-4">
            <p class="text-xs font-semibold text-gray-600 mb-2">Foto carousel tersimpan:</p>
            <div class="flex gap-3 flex-wrap" id="saved_images">
                @foreach($article->images as $img)
                <div class="relative group" id="img-wrapper-{{ $img->id }}">
                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                         class="w-24 h-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                    <button type="button" 
                            onclick="deleteCarouselImage({{ $img->id }}, this)"
                            class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 text-sm font-bold shadow transition opacity-0 group-hover:opacity-100">
                        ×
                    </button>
                </div>
                @endforeach
            </div>
            {{-- Hidden input untuk tracking foto yang dihapus --}}
            <div id="deleted_images_inputs"></div>
        </div>
        @endif
    </div>
    {{-- ========== END CAROUSEL IMAGES ========== --}}

    {{-- Publish --}}
    <div>
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" 
                   name="is_published" 
                   value="1"
                   {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }}
                   class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
            <span class="text-sm font-medium text-gray-700">Publish artikel ini</span>
        </label>
    </div>
</div>

<script>
// ===== Toggle Internal / External =====
function toggleArticleType() {
    const type = document.querySelector('input[name="article_type"]:checked').value;
    const externalField = document.getElementById('external_url_field');
    const contentField = document.getElementById('content_field');
    const contentTextarea = document.getElementById('content');
    const externalInput = document.getElementById('external_url');
    const contentRequired = document.getElementById('content_required');
    
    if (type === 'external') {
        externalField.style.display = 'block';
        contentField.style.display = 'none';
        contentTextarea.removeAttribute('required');
        contentRequired.style.display = 'none';
        externalInput.setAttribute('required', 'required');
    } else {
        externalField.style.display = 'none';
        contentField.style.display = 'block';
        externalInput.removeAttribute('required');
        contentRequired.style.display = 'inline';
        contentTextarea.setAttribute('required', 'required');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleArticleType();
});

// ===== Preview Carousel Images =====
function previewCarousel(event) {
    const preview = document.getElementById('carousel_preview');
    preview.innerHTML = '';

    const files = event.target.files;
    if (!files.length) return;

    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-24 h-24 object-cover rounded-lg border border-amber-300 shadow-sm';

            const label = document.createElement('span');
            label.className = 'absolute bottom-1 left-1 bg-black/50 text-white text-xs px-1 rounded';
            label.textContent = index + 1;

            wrapper.appendChild(img);
            wrapper.appendChild(label);
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

// ===== Hapus foto carousel tersimpan =====
function deleteCarouselImage(imageId, btn) {
    if (!confirm('Hapus foto ini?')) return;

    // Sembunyikan wrapper foto
    const wrapper = document.getElementById('img-wrapper-' + imageId);
    wrapper.style.display = 'none';

    // Tambah hidden input supaya controller tau foto mana yang dihapus
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    input.value = imageId;
    document.getElementById('deleted_images_inputs').appendChild(input);
}
</script>
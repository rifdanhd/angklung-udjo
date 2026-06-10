@extends('admin.layouts.app')

@section('title', 'Tambah Gallery')

@section('content')
<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-amber-900 tracking-tight">Tambah Galeri Baru</h1>
            <p class="text-gray-500">Tambahkan koleksi foto atau video kegiatan ke portofolio galeri.</p>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm">
            <div class="flex items-center mb-2">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span class="font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-sm ml-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H9z" />
                                <path d="M4 6a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H4V8h3a1 1 0 000-2H4z" />
                            </svg>
                        </span>
                        Informasi Konten
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Koleksi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition border" value="{{ old('title') }}" required placeholder="Contoh: Pentas Seni Angklung 2024">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea name="description" id="description" rows="4" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition border" placeholder="Ceritakan sedikit tentang foto/video ini...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Media File
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Media</label>
                            <select name="type" id="type" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 border" onchange="toggleMediaFields(this.value)" required>
                                <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>📸 Foto</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>🎥 Video (YouTube Link)</option>
                            </select>
                        </div>
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">Urutan Tampil</label>
                            <input type="number" name="order" id="order" class="w-full border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-amber-500 border" value="{{ old('order', 0) }}">
                        </div>
                    </div>

                    <div id="photoField" class="space-y-4 {{ old('type') == 'video' ? 'hidden' : '' }}">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Gambar</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div id="preview-placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-400">PNG, JPG atau JPEG (Maks. 5MB)</p>
                                </div>
                                <img id="image-preview" class="hidden h-full w-full object-cover rounded-2xl p-2" />
                                <input type="file" name="file" id="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                            </label>
                        </div>
                    </div>

                    <div id="videoField" class="space-y-4 {{ old('type') == 'video' ? '' : 'hidden' }}">
                        <label for="video_url" class="block text-sm font-semibold text-gray-700 mb-1">Link URL Video YouTube</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                            </span>
                            <input type="url" name="video_url" id="video_url" class="w-full border-gray-200 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-amber-500 border" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=xxxxxx">
                        </div>
                        <p class="text-xs text-gray-500 italic">Pastikan link video bersifat publik.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-6">Pengaturan Tambahan</h2>
                    
                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 mb-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }} class="focus:ring-amber-500 h-5 w-5 text-amber-600 border-gray-300 rounded-lg cursor-pointer transition">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_featured" class="font-bold text-amber-900 cursor-pointer">Jadikan Unggulan</label>
                                <p class="text-amber-700 text-xs">Akan ditampilkan secara khusus di bagian awal galeri atau beranda.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-amber-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Konten
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-4 italic">Periksa kembali data sebelum menyimpan.</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Fungsi untuk ganti tampilan input Photo vs Video
function toggleMediaFields(type) {
    const photoField = document.getElementById('photoField');
    const videoField = document.getElementById('videoField');
    
    if (type === 'photo') {
        photoField.classList.remove('hidden');
        videoField.classList.add('hidden');
    } else {
        photoField.classList.add('hidden');
        videoField.classList.remove('hidden');
    }
}

// Fungsi untuk Preview Image yang akan diupload
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('preview-placeholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Jalankan pengecekan tipe saat pertama kali halaman dibuka (untuk old value)
document.addEventListener('DOMContentLoaded', function() {
    toggleMediaFields(document.getElementById('type').value);
});
</script>

<style>
/* Utility class jika Tailwind belum meload 'hidden' dengan baik */
.hidden { display: none !important; }
</style>
@endsection
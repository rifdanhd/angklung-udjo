@extends('admin.layouts.app')

@section('title', 'Tambah Testimoni')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Testimoni Baru</h1>

    {{-- 1. ERROR DISPLAY: Biar ketahuan kalau ada yang salah isi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Waduh!</strong> Ada masalah sama inputan kamu:<br>
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 2. FORM: Tambahkan enctype="multipart/form-data" (WAJIB!) --}}
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Input Foto --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Foto Profil (Avatar Google)</label>
            <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-amber-500">
            <p class="text-xs text-gray-400 mt-1">*Upload foto profil asli dari Google Maps agar lebih otentik.</p>
        </div>
    
        {{-- Nama Pengunjung --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-1">Nama Pengunjung</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-amber-500" 
                   required>
        </div>

        {{-- Negara --}}
        <div class="mb-4">
            <label for="country" class="block text-gray-700 font-medium mb-1">Negara</label>
            <input type="text" id="country" name="country" value="{{ old('country') }}"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        {{-- Rating --}}
        <div class="mb-4">
            <label for="rating" class="block text-gray-700 font-medium mb-1">Rating</label>
            <select id="rating" name="rating" 
                    class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-amber-500" 
                    required>
                <option value="">Pilih rating</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                @endfor
            </select>
        </div>

        {{-- Pesan --}}
        <div class="mb-4">
            <label for="message" class="block text-gray-700 font-medium mb-1">Pesan</label>
            <textarea id="message" name="message" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
                      required>{{ old('message') }}</textarea>
        </div>

        {{-- Checkbox Approve --}}
        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" id="is_approved" name="is_approved" value="1" {{ old('is_approved') ? 'checked' : '' }}>
            <label for="is_approved" class="text-gray-700 font-medium">Setujui Testimoni Sekarang</label>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.testimonials.index') }}" 
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</a>
            <button type="submit" 
                    class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
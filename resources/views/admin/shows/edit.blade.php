@extends('admin.layouts.app')

@section('title', 'Edit Pertunjukan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Pertunjukan</h1>
            <p class="text-gray-600 mt-1">Perbarui data pertunjukan</p>
        </div>

        <form action="{{ route('admin.shows.update', $show) }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div>
                <label class="block font-semibold mb-2">Judul Pertunjukan</label>
                <input type="text" name="title" value="{{ old('title', $show->title) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-amber-200">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-amber-200">{{ old('description', $show->description) }}</textarea>
            </div>

            <!-- Tanggal & Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', $show->date) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Waktu</label>
                    <input type="time" name="time" value="{{ old('time', $show->time) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <!-- Kapasitas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-2">Kapasitas</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $show->capacity) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Kapasitas tersedia</label>
                    <input type="number" name="available_seats"
                        value="{{ old('available_seats', $show->available_seats) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <!-- Harga -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-2">Harga Domestik</label>
                    <input type="number" name="price_domestic" value="{{ old('price_domestic', $show->price_domestic) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Harga Asing</label>
                    <input type="number" name="price_foreign" value="{{ old('price_foreign', $show->price_foreign) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block font-semibold mb-2">Status</label>
                <select name="is_active" class="w-full border rounded-lg px-4 py-2">
                    <option value="1" {{ $show->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$show->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block font-semibold mb-2">Gambar</label>
                @if ($show->image)
                    <img src="{{ asset('storage/' . $show->image) }}" class="w-48 h-32 object-cover rounded-lg mb-3">
                @endif
                <input type="file" name="image" class="w-full border rounded-lg px-4 py-2">
            </div>

            <!-- Action -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.shows.index') }}"
                    class="px-6 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700 font-semibold">
                    Update Pertunjukan
                </button>
            </div>
        </form>
    </div>
@endsection

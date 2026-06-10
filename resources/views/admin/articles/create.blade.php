@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Tambah Artikel</h1>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.articles._form')

        <div class="mt-6">
            <button type="submit" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-semibold">Simpan Artikel</button>
            <a href="{{ route('admin.articles.index') }}"
                class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold">Batal</a>
        </div>
    </form>
@endsection

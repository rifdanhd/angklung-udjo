@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<h1 class="text-3xl font-bold mb-6">Edit Artikel</h1>

<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('admin.articles._form', ['article' => $article])

    <div class="mt-6">
        <button type="submit">Update Artikel</button>
        <a href="{{ route('admin.articles.index') }}">Batal</a>
    </div>
</form>

@endsection

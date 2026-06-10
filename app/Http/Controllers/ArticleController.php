<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published();

        if ($request->has('category') && $request->category != 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->latest('published_at')->paginate(9);
        $categories = Article::distinct()->pluck('category');

        return view('articles.index', compact('articles', 'categories'));
    }

public function show($slug)
{
    // 1. Ambil artikel yang sedang dibuka
    $article = Article::where('slug', $slug)->firstOrFail();

    // Redirect jika artikel merupakan link eksternal
    if ($article->isExternal()) {
        return redirect()->away($article->external_url);
    }

    // 2. Ambil artikel TERKAIT (berdasarkan kategori yang sama, kecuali artikel ini)
    $relatedArticles = Article::where('category', $article->category)
                          ->where('id', '!=', $article->id)
                          ->where('published_at', '<=', now())
                          ->latest()
                          ->take(5) // Ambil 5 untuk sidebar ala Kompas
                          ->get();

    // 3. Ambil artikel selanjutnya (fitur navigasi Anda sebelumnya)
    $nextArticle = Article::where('id', '>', $article->id)
                          ->where('published_at', '<=', now())
                          ->orderBy('id', 'asc')
                          ->first();

    // 4. Kirim SEMUA variabel ke view
    return view('articles.show', compact('article', 'nextArticle', 'relatedArticles'));
}
}

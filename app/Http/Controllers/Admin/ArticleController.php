<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(15);

        return view('admin.articles.index', [
            'mode'     => 'index',
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        return view('admin.articles.index', [
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'             => 'required|string|max:255',
            'excerpt'           => 'required|string|max:500',
            'category'          => 'required|string',
            'featured_image'    => 'nullable|image|max:2048',
            'external_url'      => 'nullable|url',
            'is_published'      => 'boolean',
            'article_type'      => 'required|in:internal,external',
            'carousel_images'   => 'nullable|array',
            'carousel_images.*' => 'image|max:2048',
        ];

        if ($request->article_type === 'internal') {
            $rules['content'] = 'required|string';
        }
        if ($request->article_type === 'external') {
            $rules['external_url'] = 'required|url';
        }

        $validated = $request->validate($rules);
        $validated['user_id'] = Auth::id();

        if ($request->article_type === 'external') {
            $validated['content'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        if ($request->is_published) {
            $validated['published_at'] = now();
        }

        unset($validated['carousel_images'], $validated['article_type']);

        $article = Article::create($validated);

        if ($request->hasFile('carousel_images')) {
            foreach ($request->file('carousel_images') as $index => $image) {
                $path = $image->store('articles/carousel', 'public');
                $article->images()->create([
                    'image_path' => $path,
                    'order'      => $index,
                ]);
            }
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        $article->load('images');

        return view('admin.articles.index', [
            'mode'    => 'edit',
            'article' => $article,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $rules = [
            'title'             => 'required|string|max:255',
            'excerpt'           => 'required|string|max:500',
            'category'          => 'required|string',
            'featured_image'    => 'nullable|image|max:2048',
            'external_url'      => 'nullable|url',
            'is_published'      => 'boolean',
            'article_type'      => 'required|in:internal,external',
            'carousel_images'   => 'nullable|array',
            'carousel_images.*' => 'image|max:2048',
            'delete_images'     => 'nullable|array',
            'delete_images.*'   => 'integer',
        ];

        if ($request->article_type === 'internal') {
            $rules['content'] = 'required|string';
        }
        if ($request->article_type === 'external') {
            $rules['external_url'] = 'required|url';
        }

        $validated = $request->validate($rules);

        if ($request->article_type === 'external') {
            $validated['content'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        if ($request->is_published && ! $article->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $img = ArticleImage::find($imageId);
                if ($img && $img->article_id === $article->id) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('carousel_images')) {
            $lastOrder = $article->images()->max('order') ?? -1;
            foreach ($request->file('carousel_images') as $index => $image) {
                $path = $image->store('articles/carousel', 'public');
                $article->images()->create([
                    'image_path' => $path,
                    'order'      => $lastOrder + $index + 1,
                ]);
            }
        }

        unset($validated['carousel_images'], $validated['delete_images'], $validated['article_type']);

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(Article $article)
    {
        foreach ($article->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::available();

        if ($request->has('category') && $request->category != 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = ['angklung', 'arumba', 'calung', 'souvenir'];

        return view('products.index', compact('products', 'categories'));
    }

   public function show(Product $product)
{
    $relatedProducts = Product::available()
        ->where('category', $product->category)
        ->where('id','!=',$product->id)
        ->inRandomOrder()
        ->take(8)
        ->get();

    // kalau produk satu kategori kurang dari 8, tambahin dari kategori lain
    if($relatedProducts->count() < 8){
        $extra = Product::available()
            ->whereNotIn('id',
                $relatedProducts->pluck('id')->push($product->id)
            )
            ->inRandomOrder()
            ->take(8 - $relatedProducts->count())
            ->get();

        $relatedProducts = $relatedProducts->merge($extra);
    }

    return view('products.show', compact('product','relatedProducts'));
}
}

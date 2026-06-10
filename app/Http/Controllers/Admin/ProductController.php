<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('availability')) {
            if ($request->availability === 'available') {
                $query->where('is_available', true)->where('stock', '>', 0);
            } elseif ($request->availability === 'out_of_stock') {
                $query->where(fn($q) => $q->where('is_available', false)->orWhere('stock', '<=', 0));
            }
        }

        $products = $query->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
    'name'        => 'required|string|max:255',
    'description' => 'required|string',
    'price'       => 'required|numeric|min:0',
    'stock'       => 'required|integer|min:0',
    'category'    => 'required|in:angklung,arumba,calung,souvenir',
    'images'      => 'nullable|array|max:5',   // ← tambah ini
    'images.*'    => 'nullable|image|max:2048',
]);

        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['is_available'] = $request->boolean('is_available');

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('products', 'public');
            }
        }
        $validated['images'] = $images;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

 public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name'              => 'required|string|max:255',
        'description'       => 'required|string',
        'price'             => 'required|numeric|min:0',
        'stock'             => 'required|integer|min:0',
        'category'          => 'required|in:angklung,arumba,calung,souvenir',
        'images'            => 'nullable|array|max:5',
        'images.*'          => 'nullable|image|max:2048',
        'existing_images'   => 'nullable|array',
        'existing_images.*' => 'nullable|string',
    ]);

    $validated['is_featured']  = $request->boolean('is_featured');
    $validated['is_available'] = $request->boolean('is_available');

    // ✅ SAFETY NET: Jika client tidak mengirim signal _images_processed,
    // berarti ada bug di JS — jangan hapus foto lama
    if (!$request->has('_images_processed')) {
        unset($validated['existing_images']);
        $product->update($validated);

        return $request->expectsJson()
            ? response()->json(['success' => true])
            : redirect()->route('admin.products.index')
                ->with('success', "Produk \"{$product->name}\" berhasil diperbarui.");
    }

    // Normal flow
    $existingKept = $request->input('existing_images', []);

    if ($product->images) {
        foreach ($product->images as $old) {
            if (!in_array($old, $existingKept)) {
                Storage::disk('public')->delete($old);
            }
        }
    }

    $newImages = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $newImages[] = $image->store('products', 'public');
        }
    }

    $validated['images'] = array_values(array_merge($existingKept, $newImages));
    unset($validated['existing_images']);

    $product->update($validated);

    return $request->expectsJson()
        ? response()->json(['success' => true])
        : redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil diperbarui.");
}
    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus.");
    }

    public function deleteImage(Request $request, Product $product)
    {
        $request->validate(['image' => 'required|string']);

        $images = $product->images ?? [];

        if (!in_array($request->image, $images)) {
            return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan.'], 404);
        }

        Storage::disk('public')->delete($request->image);

        $product->update([
            'images' => array_values(array_diff($images, [$request->image]))
        ]);

        return response()->json(['success' => true]);
    }
}
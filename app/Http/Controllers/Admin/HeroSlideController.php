<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('order')->get();
        return view('admin.hero.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('hero', 'public');

        $maxOrder = HeroSlide::max('order') ?? 0;

        HeroSlide::create([
            'image_path' => $path,
            'alt_text'   => $request->alt_text,
            'order'      => $maxOrder + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Slide berhasil ditambahkan!');
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => !$heroSlide->is_active]);
        return back()->with('success', 'Status slide diperbarui!');
    }

    public function updateOrder(Request $request)
    {
        // Terima array of ids sesuai urutan baru
        foreach ($request->ids as $index => $id) {
            HeroSlide::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function destroy(HeroSlide $heroSlide)
    {
        Storage::disk('public')->delete($heroSlide->image_path);
        $heroSlide->delete();
        return back()->with('success', 'Slide berhasil dihapus!');
    }
}
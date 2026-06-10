<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistorySlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistorySlideController extends Controller
{
    public function index()
    {
        $slides = HistorySlide::orderBy('order')->get();
        return view('admin.history-slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $path     = $request->file('image')->store('history-slides', 'public');
        $maxOrder = HistorySlide::max('order') ?? 0;

        HistorySlide::create([
            'image_path' => $path,
            'alt_text'   => $request->alt_text,
            'order'      => $maxOrder + 1,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Slide berhasil ditambahkan!');
    }

    public function toggleActive(HistorySlide $historySlide)
    {
        $historySlide->update(['is_active' => !$historySlide->is_active]);
        return back()->with('success', 'Status slide diperbarui!');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->ids as $index => $id) {
            HistorySlide::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function destroy(HistorySlide $historySlide)
    {
        Storage::disk('public')->delete($historySlide->image_path);
        $historySlide->delete();
        return back()->with('success', 'Slide berhasil dihapus!');
    }
}
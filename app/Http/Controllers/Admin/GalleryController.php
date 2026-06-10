<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        $query = Gallery::ordered();

        if ($type === 'photo') {
            $query->where('type', 'photo');
        } elseif ($type === 'video') {
            $query->where('type', 'video');
        }

        $galleries = $query->paginate(20);
        return view('admin.gallery.index', compact('galleries', 'type'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            // Gunakan nullable agar format URL tidak dicek saat kolom kosong (tipe photo)
            'file' => 'required_if:type,photo|nullable|image|max:5120',
            'video_url' => 'required_if:type,video|nullable|url',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable', // Checkbox mengirim null jika tidak dicentang
        ]);

        // Atur is_featured secara manual
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->type === 'photo' && $request->hasFile('file')) {
            $path = $request->file('file')->store('gallery', 'public');
            $validated['file_path'] = $path;
            $validated['thumbnail'] = $path;
            $validated['video_url'] = null; // Pastikan video_url bersih
        } elseif ($request->type === 'video') {
            $validated['file_path'] = null;
            $validated['thumbnail'] = null;
        }

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil ditambahkan!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'file' => 'nullable|image|max:5120',
            'video_url' => 'required_if:type,video|nullable|url',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable',
        ]);

        $validated['is_featured'] = $request->has('is_featured');

        if ($request->type === 'photo') {
            if ($request->hasFile('file')) {
                if ($gallery->file_path) {
                    Storage::disk('public')->delete($gallery->file_path);
                }
                $path = $request->file('file')->store('gallery', 'public');
                $validated['file_path'] = $path;
                $validated['thumbnail'] = $path;
            }
            $validated['video_url'] = null;
        } elseif ($request->type === 'video') {
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $validated['file_path'] = null;
            $validated['thumbnail'] = null;
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil diupdate!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery berhasil dihapus!');
    }
}
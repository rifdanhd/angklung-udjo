<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
{
    // 1. Validasi (Ubah 'required' pada country jadi 'nullable' agar tidak galak)
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'country' => 'nullable|string|max:255', // Ganti jadi nullable
        'message' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Tambahkan ini
    ]);

    // 2. Logika Upload Foto
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('testimonials', 'public');
        $validated['image'] = $path;
    }

    // 3. Status Approved (otomatis aktif kalau dari admin)
    $validated['is_approved'] = $request->has('is_approved');

    // 4. Simpan ke Database
    Testimonial::create($validated);

    return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambah!');
}
}

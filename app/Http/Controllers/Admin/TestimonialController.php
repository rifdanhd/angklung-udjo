<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::latest();

        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $testimonials = $query->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }
    public function create()
    {
        // Menampilkan form tambah testimoni
        return view('admin.testimonials.create');
    }

  public function store(Request $request) {
    // 1. Validasi semua field yang ada di form kamu
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'country' => 'nullable|string|max:255', // Diset nullable agar tidak error jika kosong
        'message' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Logika Upload Foto
    if ($request->hasFile('image')) {
        // Simpan foto di folder storage/public/testimonials
        $data['image'] = $request->file('image')->store('testimonials', 'public');
    }

    // 3. Ambil nilai checkbox is_approved
    $data['is_approved'] = $request->has('is_approved') ? 1 : 0;

    // 4. Simpan ke Database
    Testimonial::create($data);

    // 5. Redirect ke INDEX agar kamu bisa lihat hasilnya di tabel, bukan back()
    return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambah!');
}

// Tambahkan ini agar halaman edit bisa terbuka
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

public function update(Request $request, Testimonial $testimonial)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'country' => 'nullable|string|max:255',
        'message' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Hapus foto lama jika ada
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }
        // Simpan foto baru
        $data['image'] = $request->file('image')->store('testimonials', 'public');
    }

    $data['is_approved'] = $request->has('is_approved');

    $testimonial->update($data);

    return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui!');
}
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);

        return back()->with('success', 'Testimoni berhasil disetujui!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus!');
    }
}

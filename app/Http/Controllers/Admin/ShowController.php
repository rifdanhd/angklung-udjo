<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function index()
    {
        $shows = Show::latest()->paginate(15);
        return view('admin.shows.index', compact('shows'));
    }

    public function create()
    {
        return view('admin.shows.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('shows', 'public');
        }

        // Set default values
        $validated['available_seats'] = $request->capacity;
        $validated['is_active'] = $request->has('is_active');

        Show::create($validated);

        return redirect()->route('admin.shows.index')->with('success', 'Pertunjukan berhasil dibuat!');
    }

    public function edit(Show $show)
    {
        return view('admin.shows.edit', compact('show'));
    }

    public function update(Request $request, Show $show)
    {
        $validated = $this->validateRequest($request, $show->id);

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($show->image) Storage::disk('public')->delete($show->image);
            $validated['image'] = $request->file('image')->store('shows', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        // Gunakan Transaction agar update available_seats aman
        DB::transaction(function () use ($show, $validated) {
            $show->update($validated);
            $show->updateAvailableSeats();
        });

        return redirect()->route('admin.shows.index')->with('success', 'Pertunjukan berhasil diperbarui!');
    }

    public function destroy(Show $show)
    {
        if ($show->image) {
            Storage::disk('public')->delete($show->image);
        }

        $show->delete();

        return redirect()->route('admin.shows.index')->with('success', 'Pertunjukan berhasil dihapus!');
    }

    /**
     * Helper Validasi agar kodingan tidak duplikat di store & update
     */
    protected function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'date'           => 'required|date',
            'time'           => 'required',
            'capacity'       => 'required|integer|min:1',
            'price_domestic' => 'required|numeric|min:0',
            'price_foreign'  => 'required|numeric|min:0',
            'image'          => $id ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);
    }
}

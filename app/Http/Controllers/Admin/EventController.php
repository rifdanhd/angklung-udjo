<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'event_date'  => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'url'         => 'nullable|url|max:500',
            'sort_order'  => 'integer|min:0',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        Event::create($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'event_date'  => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'url'         => 'nullable|url|max:500',
            'sort_order'  => 'integer|min:0',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        $event->update($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }
        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil dihapus.');
    }

    /** Update urutan via drag-and-drop (AJAX) */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $sortOrder => $id) {
            Event::where('id', $id)->update(['sort_order' => $sortOrder]);
        }

        return response()->json(['success' => true]);
    }
}
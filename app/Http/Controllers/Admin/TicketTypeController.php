<?php
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/TicketTypeController.php
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\TicketType;
use Illuminate\Http\Request;
 
class TicketTypeController extends Controller
{
    public function index()
    {
        $tickets = TicketType::orderBy('sort_order')->get();
        return view('admin.tickets.index', compact('tickets'));
    }
 
    public function create()
    {
        return view('admin.tickets.form', ['ticket' => null]);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'slug'        => 'required|string|unique:ticket_types,slug',
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:domestic,international',
            'type'        => 'required|in:adult,child',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        TicketType::create($data);
        return redirect()->route('admin.tickets.index')->with('success', 'Jenis tiket berhasil ditambah.');
    }
 
    public function edit(TicketType $ticket)
    {
        return view('admin.tickets.form', compact('ticket'));
    }
 
    public function update(Request $request, TicketType $ticket)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:domestic,international',
            'type'        => 'required|in:adult,child',
            'description' => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $ticket->update($data);
        return redirect()->route('admin.tickets.index')->with('success', 'Harga tiket berhasil diperbarui.');
    }
 
    public function destroy(TicketType $ticket)
    {
        $ticket->update(['is_active' => false]); // Soft-disable, jangan hapus karena ada FK
        return back()->with('success', 'Tiket dinonaktifkan.');
    }
}
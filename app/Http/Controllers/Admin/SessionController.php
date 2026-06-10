<?php
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/SessionController.php
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\ShowSession;
use Illuminate\Http\Request;
 
class SessionController extends Controller
{
    public function index()
    {
        $sessions = ShowSession::orderBy('day_type')->orderBy('sort_order')->get()
            ->groupBy('day_type');
        return view('admin.sessions.index', compact('sessions'));
    }
 
    public function create()
    {
        return view('admin.sessions.form', ['session' => null]);
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'session_key' => 'required|string|max:50',
            'name'        => 'required|string|max:255',
            'day_type'    => 'required|in:weekday,saturday,sunday',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'capacity'    => 'required|integer|min:1',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        ShowSession::create($data);
        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil ditambah.');
    }
 
    public function edit(ShowSession $session)
    {
        return view('admin.sessions.form', compact('session'));
    }
 
    public function update(Request $request, ShowSession $session)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'day_type'   => 'required|in:weekday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'capacity'   => 'required|integer|min:1',
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $session->update($data);
        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil diperbarui.');
    }
 
    public function destroy(ShowSession $session)
    {
        $session->delete();
        return back()->with('success', 'Sesi dihapus.');
    }
}
 
 
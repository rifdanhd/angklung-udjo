<?php
// ═══════════════════════════════════════════════════════════════
//  ADMIN CONTROLLERS — app/Http/Controllers/Admin/
// ═══════════════════════════════════════════════════════════════
 
 
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/ReservationController.php
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
 
class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['customer', 'showSession', 'items.ticketType', 'promoCode'])
            ->latest();
 
        // Filter status
        if ($s = $request->status) {
            $query->where('status', $s);
        }
 
        // Filter tanggal kunjungan
        if ($d = $request->date) {
            $query->whereDate('visit_date', $d);
        }
 
        // Cari nama / kode / email
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('reservation_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
 
        $reservations = $query->paginate(20)->withQueryString();
 
        // Stats untuk header
        $stats = [
            'total'     => Reservation::count(),
            'pending'   => Reservation::pending()->count(),
            'confirmed' => Reservation::confirmed()->count(),
            'today'     => Reservation::whereDate('visit_date', today())->count(),
            'revenue'   => Reservation::confirmed()->sum('grand_total'),
        ];
 
        return view('admin.reservations.index', compact('reservations', 'stats'));
    }
 
    public function show(Reservation $reservation)
    {
        $reservation->load(['customer', 'showSession', 'items.ticketType', 'promoCode']);
        return view('admin.reservations.show', compact('reservation'));
    }
 
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled,completed']);
        $reservation->update(['status' => $request->status]);
        return back()->with('success', "Status berhasil diubah ke {$request->status}.");
    }
 
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi dihapus.');
    }
}
 
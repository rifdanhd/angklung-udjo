<?php
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/ReportController.php
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\BookingTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from) : now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)   : now()->endOfMonth();
 
        // ── KPI ───────────────────────────────────────────
        $bookings = BookingTicket::whereBetween('tanggal_kunjungan', [$from->toDateString(), $to->toDateString()]);
 
        $kpi = [
            'total_reservations' => (clone $bookings)->count(),
            'total_revenue'      => (clone $bookings)->whereNotIn('status', ['cancelled', 'rejected'])->sum('total_harga'),
            'total_tickets'      => (clone $bookings)->sum(DB::raw('jumlah_tiket_dewasa + jumlah_tiket_anak + jumlah_tiket_manca_dewasa + jumlah_tiket_manca_anak')),
            'total_customers'    => BookingTicket::distinct('email')->count('email'),
            'new_customers'      => BookingTicket::whereBetween('created_at', [$from, $to])->distinct('email')->count('email'),
        ];
 
        // ── Revenue per hari ──────────────────────────────
        $revenuePerDay = BookingTicket::whereNotIn('status', ['cancelled', 'rejected'])
            ->whereBetween('tanggal_kunjungan', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('DATE(tanggal_kunjungan) as date, SUM(total_harga) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
 
        // ── Tiket terlaris (kalkulasi manual dari BookingTicket) ──
        $dewasaSum = (clone $bookings)->sum('jumlah_tiket_dewasa');
        $anakSum = (clone $bookings)->sum('jumlah_tiket_anak');
        $mancaDewasaSum = (clone $bookings)->sum('jumlah_tiket_manca_dewasa');
        $mancaAnakSum = (clone $bookings)->sum('jumlah_tiket_manca_anak');

        $topTickets = collect([
            (object)[
                'name'    => 'Domestik — Dewasa',
                'qty'     => $dewasaSum,
                'revenue' => $dewasaSum * 85000
            ],
            (object)[
                'name'    => 'Domestik — Anak',
                'qty'     => $anakSum,
                'revenue' => $anakSum * 60000
            ],
            (object)[
                'name'    => 'Mancanegara — Dewasa',
                'qty'     => $mancaDewasaSum,
                'revenue' => $mancaDewasaSum * 120000
            ],
            (object)[
                'name'    => 'Mancanegara — Anak',
                'qty'     => $mancaAnakSum,
                'revenue' => $mancaAnakSum * 85000
            ]
        ])->sortByDesc('qty')->values();
 
        // ── Reservasi per status ──────────────────────────
        $statusBreakdown = BookingTicket::whereBetween('tanggal_kunjungan', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
 
        // ── Promo usage ───────────────────────────────────
        $promoUsage = BookingTicket::whereNotNull('promo_code')
            ->whereRaw("promo_code != ''")
            ->whereBetween('tanggal_kunjungan', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('promo_code as promo_code_used, COUNT(*) as promo_count, SUM(discount_amount) as total_disc')
            ->groupBy('promo_code')
            ->orderByDesc('promo_count')
            ->get()
            ->map(function ($item) {
                $item->usage = $item->promo_count;
                return $item;
            });
 
        return view('admin.reports.index', compact(
            'from', 'to', 'kpi', 'revenuePerDay', 'topTickets', 'statusBreakdown', 'promoUsage'
        ));
    }
}
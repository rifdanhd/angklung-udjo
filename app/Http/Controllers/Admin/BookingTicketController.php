<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingTicket;
use App\Models\OnlineBookingCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\EticketService;

class BookingTicketController extends Controller
{
    // ── Definisi tiket (mapping select form → kolom DB) ──────────────────
    const TICKET_TYPES = [
        'dewasa'       => ['col' => 'jumlah_tiket_dewasa',       'label' => 'Domestik — Dewasa'],
        'anak'         => ['col' => 'jumlah_tiket_anak',         'label' => 'Domestik — Anak'],
        'kitas_dewasa' => ['col' => 'jumlah_tiket_kitas_dewasa', 'label' => 'KITAS — Dewasa'],
        'manca_dewasa' => ['col' => 'jumlah_tiket_manca_dewasa', 'label' => 'Mancanegara — Dewasa'],
        'manca_anak'   => ['col' => 'jumlah_tiket_manca_anak',   'label' => 'Mancanegara — Anak'],
    ];

    // ── Index ─────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = BookingTicket::query();

        // Search
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama',          'like', "%{$q}%")
                    ->orWhere('email',        'like', "%{$q}%")
                    ->orWhere('booking_code', 'like', "%{$q}%")
                    ->orWhere('no_hp',        'like', "%{$q}%");
            });
        }

        // Status
        if ($request->filled('status')) {
            if ($request->status === 'reservasi') {
                $query->where('status', 'confirmed');
            } else {
                $query->where('status', $request->status);
            }
        }

        // Payment Method filter (from sidebar menu)
        if ($request->get('payment_method') === 'online') {
            $query->whereIn('payment_method', ['online', 'doku']);
        } elseif ($request->get('payment_method') === 'walkin') {
            $query->where('payment_method', 'walkin');
        }

        // Hide pending rows that already have a confirmed duplicate for the same phone/date/session
        $query->where(function ($sub) {
            $sub->where('status', '!=', 'pending')
                ->orWhereNotExists(function ($exists) {
                    $exists->select(DB::raw(1))
                        ->from('booking_tickets as confirmed')
                        ->whereColumn('confirmed.no_hp', 'booking_tickets.no_hp')
                        ->whereColumn('confirmed.tanggal_kunjungan', 'booking_tickets.tanggal_kunjungan')
                        ->whereColumn('confirmed.session_id', 'booking_tickets.session_id')
                        ->whereColumn('confirmed.session_time', 'booking_tickets.session_time')
                        ->where('confirmed.status', 'confirmed');
                });
        });

        // Date preset
        if ($request->filled('preset')) {
            [$from, $to] = match ($request->preset) {
                'today'      => [today(), today()],
                'week'       => [now()->startOfWeek(), now()->endOfWeek()],
                'month'      => [now()->startOfMonth(), now()->endOfMonth()],
                'last_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
                default      => [null, null],
            };
            if ($from) $query->whereBetween('tanggal_kunjungan', [$from, $to]);

        } else {
            if ($request->filled('date_from')) {
                $query->whereDate('tanggal_kunjungan', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('tanggal_kunjungan', '<=', $request->date_to);
            }
        }

        // Base query for dynamic stats (before sort & paginate)
        $baseQuery = clone $query;

        // Sort — default: visit_date_asc (tanggal kunjungan terdekat dulu)
        match ($request->get('sort_by', 'visit_date_asc')) {
            'created_desc'    => $query->latest(),
            'created_asc'     => $query->oldest(),
            'visit_date_desc' => $query->orderByDesc('tanggal_kunjungan'),
            'total_desc'      => $query->orderByDesc('total_harga'),
            'total_asc'       => $query->orderBy('total_harga'),
            default           => $query->orderBy('tanggal_kunjungan'), // visit_date_asc
        };

        // Per page
        $perPage = in_array((int) $request->per_page, [10, 25, 50, 100, 1000])
                   ? (int) $request->per_page : 20;

        $bookings = $query->paginate($perPage)->withQueryString();

        // Global Revenue Trend
        $revenueBuilanIni = BookingTicket::whereIn('status', ['confirmed', 'completed'])
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('total_harga');

        $revenueBulanLalu = BookingTicket::whereIn('status', ['confirmed', 'completed'])
                                ->whereMonth('created_at', now()->subMonth()->month)
                                ->whereYear('created_at', now()->subMonth()->year)
                                ->sum('total_harga');

        $revenueTrend = $revenueBulanLalu > 0
            ? round((($revenueBuilanIni - $revenueBulanLalu) / $revenueBulanLalu) * 100)
            : null;

        $sumExpr = 'SUM(jumlah_tiket_dewasa + jumlah_tiket_anak + jumlah_tiket_kitas_dewasa + jumlah_tiket_manca_dewasa + jumlah_tiket_manca_anak) as total';

        $revenueQuery = (clone $baseQuery)->whereNotIn('status', ['cancelled']);
        if ($request->get('payment_method') === 'online') {
            $revenueQuery->where('status', 'completed');
        }

        // Dynamic Stats based on current filter
        $stats = [
            'revenue' => 'Rp ' . number_format($revenueQuery->sum('total_harga'), 0, ',', '.'),
            'revenue_trend'  => $revenueTrend,
            'total'          => (clone $baseQuery)->count(),
            'pending'        => (clone $baseQuery)->where('status', 'pending')->count(),
            'confirmed'      => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'completed'      => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled'      => (clone $baseQuery)->where('status', 'cancelled')->count(),
            'total_tickets'  => (clone $baseQuery)
                                    ->selectRaw($sumExpr)
                                    ->value('total') ?? 0,
            'visitors_today' => (clone $baseQuery)
                                    ->whereNotIn('status', ['cancelled'])
                                    ->selectRaw($sumExpr)
                                    ->value('total') ?? 0,
        ];

        return view('admin.booking-tickets.index', compact('bookings', 'stats'));
    }

    // ── Store ─────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|max:120',
            'phone'         => 'required|string|max:30',
            'city'          => 'nullable|string|max:100',
            'visit_date'    => 'required|date',
            'session_time'  => 'required|string|max:60',
            'tickets'       => 'required|array|min:1',
            'tickets.*.id'  => 'required|string|in:dewasa,anak,kitas_dewasa,manca_dewasa,manca_anak',
            'tickets.*.qty' => 'required|integer|min:1',
            'promo_code'    => 'nullable|string|max:30',
            'status'        => 'required|in:pending,confirmed,completed,cancelled',
            'payment_method'=> 'nullable|in:online,walkin,doku',
            'notes'         => 'nullable|string',
        ]);

        // Hitung qty per jenis tiket
        $qtys = [
            'jumlah_tiket_dewasa'       => 0,
            'jumlah_tiket_anak'         => 0,
            'jumlah_tiket_kitas_dewasa' => 0,
            'jumlah_tiket_manca_dewasa' => 0,
            'jumlah_tiket_manca_anak'   => 0,
        ];

        foreach ($data['tickets'] as $ticket) {
            $col = self::TICKET_TYPES[$ticket['id']]['col'];
            $qtys[$col] += (int) $ticket['qty'];
        }

        // Hitung total harga
        $subtotal = ($qtys['jumlah_tiket_dewasa']       * BookingTicket::PRICES['dewasa'])
                  + ($qtys['jumlah_tiket_anak']         * BookingTicket::PRICES['anak'])
                  + ($qtys['jumlah_tiket_kitas_dewasa'] * BookingTicket::PRICES['kitas_dewasa'])
                  + ($qtys['jumlah_tiket_manca_dewasa'] * BookingTicket::PRICES['manca_dewasa'])
                  + ($qtys['jumlah_tiket_manca_anak']   * BookingTicket::PRICES['manca_anak']);

        if ($data['status'] === 'pending') {
            $exists = BookingTicket::where('no_hp', $data['phone'])
                ->where('tanggal_kunjungan', $data['visit_date'])
                ->where('session_id', 'reg')
                ->where('session_time', $data['session_time'])
                ->where('status', 'confirmed')
                ->exists();

            if ($exists) {
                return back()->with('error', 'Sudah ada reservasi terkonfirmasi untuk nomor HP dan jadwal yang sama. Pending tidak boleh dibuat.');
            }
        }

        if ($data['status'] === 'confirmed') {
            BookingTicket::where('no_hp', $data['phone'])
                ->where('tanggal_kunjungan', $data['visit_date'])
                ->where('session_id', 'reg')
                ->where('session_time', $data['session_time'])
                ->where('status', 'pending')
                ->delete();
        }

        BookingTicket::create(array_merge($qtys, [
            'booking_code'      => BookingTicket::generateCode(),
            'nama'              => $data['name'],
            'email'             => $data['email'],
            'no_hp'             => $data['phone'],
            'kota'              => $data['city'],
            'tanggal_kunjungan' => $data['visit_date'],
            'session_id'        => 'reg',
            'session_time'      => $data['session_time'],
            'promo_code'        => $data['promo_code'],
            'discount_amount'   => 0,
            'subtotal'          => $subtotal,
            'total_harga'       => $subtotal,
            'status'            => $data['status'],
            'payment_method'    => $request->input('payment_method', 'walkin'),
        ]));

        return back()->with('success', 'Booking baru berhasil ditambahkan.');
    }

    // ── Update Status (dropdown di tabel) ─────────────────────────────────

    public function updateStatus(Request $request, BookingTicket $bookingTicket)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        if ($request->status === 'confirmed') {
            BookingTicket::where('no_hp', $bookingTicket->no_hp)
                ->where('tanggal_kunjungan', $bookingTicket->tanggal_kunjungan)
                ->where('session_id', $bookingTicket->session_id)
                ->where('session_time', $bookingTicket->session_time)
                ->where('status', 'pending')
                ->where('id', '<>', $bookingTicket->id)
                ->delete();
        }

        $bookingTicket->update(['status' => $request->status]);

        // Kirim E-Ticket jika diubah ke 'confirmed' (atau 'completed')
        if (in_array($request->status, ['confirmed', 'completed'])) {
            try {
                $eticketService = new EticketService();
                $eticketService->process($bookingTicket);
            } catch (\Exception $e) {
                \Log::error('Gagal memproses e-ticket untuk ' . $bookingTicket->booking_code . ': ' . $e->getMessage());
            }
        }

        return back()->with('success',
            "Status booking #{$bookingTicket->booking_code} diperbarui ke «{$bookingTicket->statusLabel()}»."
        );
    }

    // ── Bulk Update Status ────────────────────────────────────────────────

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'ids.*'  => 'integer|exists:booking_tickets,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $bookings = BookingTicket::whereIn('id', $request->ids)->get();

        if ($request->status === 'confirmed') {
            foreach ($bookings as $booking) {
                BookingTicket::where('no_hp', $booking->no_hp)
                    ->where('tanggal_kunjungan', $booking->tanggal_kunjungan)
                    ->where('session_id', $booking->session_id)
                    ->where('session_time', $booking->session_time)
                    ->where('status', 'pending')
                    ->where('id', '<>', $booking->id)
                    ->delete();
            }
        }

        $count = BookingTicket::whereIn('id', $request->ids)
                              ->update(['status' => $request->status]);

        // Kirim E-Ticket jika diubah ke 'confirmed' (atau 'completed') via Bulk Action
        if (in_array($request->status, ['confirmed', 'completed'])) {
            $eticketService = new EticketService();
            foreach ($bookings as $booking) {
                try {
                    // Refresh model agar status terupdate
                    $booking->refresh();
                    $eticketService->process($booking);
                } catch (\Exception $e) {
                    \Log::error('Gagal memproses e-ticket bulk untuk ' . $booking->booking_code . ': ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', "{$count} booking berhasil diperbarui statusnya.");
    }

    // ── Destroy ───────────────────────────────────────────────────────────

    public function destroy(BookingTicket $bookingTicket)
    {
        $code = $bookingTicket->booking_code;
        $bookingTicket->delete();

        return back()->with('success', "Booking #{$code} berhasil dihapus.");
    }

    // ── Bulk Destroy ──────────────────────────────────────────────────────

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:booking_tickets,id',
        ]);

        $count = BookingTicket::whereIn('id', $request->ids)->delete();

        return back()->with('success', "{$count} booking berhasil dihapus.");
    }

    // ── Export PDF ────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        return back()->with('error', 'Fitur export PDF belum tersedia.');
    }

    // ── Online Booking Quota Management ───────────────────────────────────

    public function onlineBooking(Request $request)
    {
        $todayDate = today()->toDateString();
        $todayCounter = OnlineBookingCounter::where('tanggal', $todayDate)->first();
        
        $todayCapacity = $todayCounter ? $todayCounter->kapasitas : 20;
        $todayUsed = $todayCounter ? $todayCounter->total_klik : 0;
        $todayStatus = ($todayCounter && $todayCounter->is_closed) ? 'Tutup' : 'Buka';

        $query = OnlineBookingCounter::query();

        if ($request->filled('date_from')) {
            $query->where('tanggal', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('tanggal', '<=', $request->date_to);
        }

        $counters = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();

        return view('admin.booking-tickets.online-booking', compact(
            'counters',
            'todayCapacity',
            'todayUsed',
            'todayStatus'
        ));
    }

    public function createOnlineCounter(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date|unique:online_booking_counters,tanggal',
            'kapasitas' => 'required|integer|min:0',
            'is_closed' => 'required|boolean',
        ]);

        OnlineBookingCounter::create([
            'tanggal'   => $request->tanggal,
            'kapasitas' => $request->kapasitas,
            'is_closed' => $request->is_closed,
            'total_klik' => 0,
        ]);

        return back()->with('success', 'Kuota tanggal baru berhasil ditambahkan.');
    }

    public function updateOnlineCapacity(Request $request, $id)
    {
        $request->validate([
            'kapasitas' => 'required|integer|min:0',
            'is_closed' => 'required|boolean',
        ]);

        $counter = OnlineBookingCounter::findOrFail($id);
        $counter->update([
            'kapasitas' => $request->kapasitas,
            'is_closed' => $request->is_closed,
        ]);

        return back()->with('success', 'Kapasitas booking online berhasil diperbarui.');
    }

    public function toggleOnlineClosed($id)
    {
        $counter = OnlineBookingCounter::findOrFail($id);
        $counter->update([
            'is_closed' => !$counter->is_closed,
        ]);

        $status = $counter->is_closed ? 'ditutup' : 'dibuka';
        $tanggalFormatted = $counter->tanggal instanceof Carbon ? $counter->tanggal->format('d M Y') : Carbon::parse($counter->tanggal)->format('d M Y');
        return back()->with('success', "Kuota online untuk tanggal {$tanggalFormatted} berhasil {$status}.");
    }

    // ── SCAN QR & CHECK-IN ───────────────────────────────────────────────

    public function scanQr()
    {
        return view('admin.booking-tickets.scan-qr');
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
        ]);

        $booking = BookingTicket::where('booking_code', $request->booking_code)->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'E-Ticket / Booking Code "' . $request->booking_code . '" tidak ditemukan.',
            ], 404);
        }

        // Pastikan tiket lunas/terkonfirmasi sebelum bisa masuk
        if (!in_array($booking->status, ['confirmed', 'completed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket "' . $booking->booking_code . '" belum Lunas/Dikonfirmasi (Status: ' . strtoupper($booking->status) . ').',
            ], 422);
        }

        // Cek jika sudah pernah melakukan check-in (scan)
        if ($booking->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket "' . $booking->booking_code . '" sudah pernah digunakan pada: ' . $booking->checked_in_at->translatedFormat('d M Y, H:i') . ' WIB.',
            ], 422);
        }

        // Lakukan check-in
        $booking->update([
            'checked_in_at' => now(),
        ]);

        // Rincian tiket untuk respon
        $parts = [];
        if ($booking->jumlah_tiket_dewasa > 0) $parts[] = $booking->jumlah_tiket_dewasa . ' Dewasa';
        if ($booking->jumlah_tiket_anak > 0) $parts[] = $booking->jumlah_tiket_anak . ' Anak';
        if ($booking->jumlah_tiket_kitas_dewasa > 0) $parts[] = $booking->jumlah_tiket_kitas_dewasa . ' KITAS';
        if ($booking->jumlah_tiket_manca_dewasa > 0) $parts[] = $booking->jumlah_tiket_manca_dewasa . ' Manca Dewasa';
        if ($booking->jumlah_tiket_manca_anak > 0) $parts[] = $booking->jumlah_tiket_manca_anak . ' Manca Anak';
        $ticketDetail = implode(', ', $parts);

        return response()->json([
            'success' => true,
            'message' => 'Check-in BERHASIL! Selamat Datang di Saung Angklung Udjo.',
            'data' => [
                'booking_code' => $booking->booking_code,
                'nama' => $booking->nama,
                'tanggal_kunjungan' => $booking->tanggal_kunjungan->translatedFormat('d M Y'),
                'session_time' => $booking->session_time,
                'ticket_detail' => $ticketDetail,
                'checked_in_at' => $booking->checked_in_at->translatedFormat('d M Y, H:i') . ' WIB',
            ]
        ]);
    }
}
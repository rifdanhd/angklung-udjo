<?php

namespace App\Http\Controllers;
use App\Models\OnlineBookingCounter;
use Illuminate\Http\Request;
use App\Models\BookingTicket;
use App\Services\GoogleSheetService;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Schedule; // Model baru untuk atur jadwal
use App\Models\Promo;    // Model Promo

class BookingTicketController extends Controller
{
    public function index()
    {
        return view('book-now');
    }

    public function submit(Request $request)
    {
        /* ── Validasi ── */
        $request->validate([
            'nama'                      => 'required|string|max:100',
            'no_hp'                     => 'required|string|max:30',
            'email'                     => 'required|email|max:120',
            'kota'                      => 'nullable|string|max:100',
            'negara_asal'               => 'nullable|string|max:100',
            'tanggal_kunjungan'         => 'required|date|after_or_equal:today',
            'session_id'                => 'required|string', // Dibuat string agar fleksibel untuk custom session
            'session_time'              => 'required|string|max:60',
            'jumlah_tiket_dewasa'       => 'required|integer|min:0',
            'jumlah_tiket_anak'         => 'required|integer|min:0',
            'jumlah_tiket_kitas_dewasa' => 'required|integer|min:0',
            'jumlah_tiket_manca_dewasa' => 'required|integer|min:0',
            'jumlah_tiket_manca_anak'   => 'required|integer|min:0',
            'promo_code'                => 'nullable|string|max:30',
            'discount_amount'           => 'required|integer|min:0',
            'subtotal'                  => 'required|integer|min:0',
            'total_harga'               => 'required|integer|min:1',
            'payment_method'            => 'required|in:online,walkin',
        ]);

        $dewasa      = (int) $request->jumlah_tiket_dewasa;
        $anak        = (int) $request->jumlah_tiket_anak;
        $kitasDewasa = (int) $request->jumlah_tiket_kitas_dewasa;
        $mancaDewasa = (int) $request->jumlah_tiket_manca_dewasa;
        $mancaAnak   = (int) $request->jumlah_tiket_manca_anak;

       if ($dewasa + $anak + $kitasDewasa + $mancaDewasa + $mancaAnak < 1) {
            return response()->json([
                'errors' => ['jumlah_tiket' => ['Pilih minimal 1 tiket.']]
            ], 422);
        }

        /* ── Validasi Promo di Backend (Keamanan & Ketepatan Tanggal) ── */
        if ($request->promo_code) {
            $promo = Promo::where('code', strtoupper($request->promo_code))
                ->where('is_active', true)
                ->first();

            if (!$promo) {
                return response()->json([
                    'errors' => ['promo_code' => ['Kode promo tidak valid atau kadaluarsa.']]
                ], 422);
            }

            // Cek apakah tanggal kunjungan berada di dalam periode promo
            $visitDate = Carbon::parse($request->tanggal_kunjungan);
            $startDate = Carbon::parse($promo->start_date)->startOfDay();
            $endDate   = Carbon::parse($promo->end_date)->endOfDay();

            if ($visitDate->lt($startDate) || $visitDate->gt($endDate)) {
                return response()->json([
                    'errors' => ['promo_code' => ['Promo ini tidak berlaku untuk tanggal kunjungan yang dipilih.']]
                ], 422);
            }

            if ($promo->isQuotaFull()) {
                return response()->json([
                    'errors' => ['promo_code' => ['Kuota promo sudah habis.']]
                ], 422);
            }

            // Cek apakah promo hanya berlaku untuk TANGGAL TERTENTU (Fitur Request Manager)
            if ($promo->specific_dates && is_array($promo->specific_dates) && count($promo->specific_dates) > 0) {
                if (!in_array($request->tanggal_kunjungan, $promo->specific_dates)) {
                    return response()->json([
                        'errors' => ['promo_code' => ['Promo ini hanya berlaku untuk tanggal kunjungan tertentu.']]
                    ], 422);
                }
            }

            // Cek Hari (Senin-Minggu)
            if (!$promo->isAllowedOnDate($visitDate)) {
                return response()->json([
                    'errors' => ['promo_code' => ['Promo tidak berlaku pada hari: ' . $visitDate->translatedFormat('l')]]
                ], 422);
            }

            // Cek Jam/Sesi Pertunjukan (Allowed Time)
            $timeToCheck = $this->parseSessionTimeToHi($request->session_time);
            if (!$promo->isAllowedAtTime($timeToCheck)) {
                return response()->json([
                    'errors' => ['promo_code' => ['Promo hanya berlaku pada jam/sesi pertunjukan ' . $promo->allowedTimeLabel()]]
                ], 422);
            }

            // Hitung ekspektasi diskon untuk mencegah manipulasi harga dari client
            $domesticSub = ($dewasa * 85000) + ($anak * 60000);
            $domesticQ = $dewasa + $anak;
            $expectedDisc = 0;

            if ($domesticSub > 0) {
                if ($promo->discount_type === 'percent') {
                    $expectedDisc = (int) round($domesticSub * $promo->discount_value / 100);
                } elseif ($promo->discount_type === 'fixed') {
                    $expectedDisc = (int) ($promo->discount_value * $domesticQ);
                }
                if ($promo->max_discount > 0) {
                    $expectedDisc = min($expectedDisc, $promo->max_discount);
                }
            }

            // Validasi toleransi selisih pembulatan diskon
            if (abs($expectedDisc - (int) $request->discount_amount) > 10) {
                return response()->json([
                    'errors' => ['discount_amount' => ['Terjadi kesalahan kalkulasi promo.']]
                ], 422);
            }
        }

        /* ── Deteksi tamu mancanegara ── */
        $isForeign = ($mancaDewasa + $mancaAnak > 0)
                     || (!empty($request->negara_asal)
                         && strtolower($request->negara_asal) !== 'indonesia');

        /* ── Cek apakah sudah ada confirmed booking untuk jadwal yang sama ── */
        $hasConfirmedDuplicate = BookingTicket::where('no_hp', $request->no_hp)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->where('session_id', $request->session_id)
            ->where('session_time', $request->session_time)
            ->where('status', 'confirmed')
            ->exists();

        if ($hasConfirmedDuplicate) {
            return response()->json([
                'errors' => ['no_hp' => ['Reservasi terkonfirmasi sudah ada untuk nomor ini pada jadwal yang sama.']]
            ], 422);
        }

        /* ── Simpan ke DB ── */
        $booking = BookingTicket::create([
            'booking_code'              => BookingTicket::generateCode(),
            'nama'                      => $request->nama,
            'no_hp'                     => $request->no_hp,
            'email'                     => $request->email,
            'kota'                      => $request->kota,
            'negara_asal'               => $request->negara_asal,
            'tanggal_kunjungan'         => $request->tanggal_kunjungan,
            'session_id'                => $request->session_id,
            'session_time'              => $request->session_time,
            'jumlah_tiket_dewasa'       => $dewasa,
            'jumlah_tiket_anak'         => $anak,
            'jumlah_tiket_kitas_dewasa' => $kitasDewasa,
            'jumlah_tiket_manca_dewasa' => $mancaDewasa,
            'jumlah_tiket_manca_anak'   => $mancaAnak,
            'promo_code'                => $request->promo_code,
            'discount_amount'           => $request->discount_amount,
            'subtotal'                  => $request->subtotal,
            'total_harga'               => $request->total_harga,
            'status'                    => $request->payment_method === 'online' ? 'pending' : 'confirmed',
            'payment_method'            => $request->payment_method,
        ]);

        /* ── Kirim ke Google Sheets ── */
        try {
            $sheetId = config('services.google.spreadsheet_id') ?? env('GOOGLE_SHEET_ID');
            if ($sheetId) {
                $sheet = new GoogleSheetService();
                $sheet->setSpreadsheetId($sheetId)
                    ->appendData('DATA TIKET!A:T', $sheet->formatBookingData($booking));
            }
        } catch (\Exception $e) {
            \Log::error('❌ Google Sheets error: ' . $e->getMessage());
        }

        $promoInfo = null;
        if ($request->has('promo_info') && $request->promo_info) {
            $promoInfo = $request->promo_info;
        }

        $klaimHompimplay  = $request->boolean('klaim_hompimplay', false);
        $paymentMethod    = $request->input('payment_method', 'walkin'); // walkin | transfer | qris
        $buktiTransferUrl = $request->input('bukti_transfer_url');       // URL file yang sudah diupload

        $waUrl = $this->buildWaUrl($booking, $promoInfo, $isForeign, $klaimHompimplay, $paymentMethod, $buktiTransferUrl);

        return response()->json([
            'success'      => true,
            'booking_code' => $booking->booking_code,
            'wa_url'       => $waUrl,
        ]);
    }

    /* ── Upload Bukti Transfer ── */
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|max:5120', // maks 5MB
        ]);

        $path = $request->file('bukti')->store('bukti-transfer', 'public');
        $url  = asset('storage/' . $path);

        return response()->json(['url' => $url]);
    }

    private function getDefaultCapacity()
    {
        return (int) \App\Support\SiteSettings::get('default_capacity', 20);
    }

    /* ── LOGIKA JADWAL: Override Database vs Default ── */
    private function getSchedulesForDate($date)
    {
        // 1. Dapatkan Jadwal Default berdasarkan hari
        $day = Carbon::parse($date)->dayOfWeek;
        $cap = $this->getDefaultCapacity();

        if ($day === 0) { // Minggu (Pagi & Sore)
            $sessions = [
                'pagi' => ['id' => 'pagi', 't' => '10.00 - 11.30 WIB', 'l' => 'Sesi Pagi', 's' => $cap],
                'sore' => ['id' => 'sore', 't' => '15.30 - 17.00 WIB', 'l' => 'Sesi Sore', 's' => $cap],
            ];
        } elseif ($day === 6) { // Sabtu (Siang & Sore)
            $sessions = [
                'siang' => ['id' => 'siang', 't' => '13.00 - 14.30 WIB', 'l' => 'Sesi Siang', 's' => $cap],
                'sore'  => ['id' => 'sore',  't' => '15.30 - 17.00 WIB', 'l' => 'Sesi Sore',  's' => $cap],
            ];
        } else { // Senin - Jumat (Default Sore)
            $sessions = [
                'reg' => ['id' => 'reg', 't' => '15.30 - 17.00 WIB', 'l' => 'Regular Show', 's' => $cap]
            ];
        }

        // 2. Load Overrides dari Database dan gabungkan
        $overrides = Schedule::where('date', $date)->get();

        foreach ($overrides as $s) {
            $sessions[$s->session_id] = [
                'id' => $s->session_id,
                't'  => $s->session_time,
                'l'  => $this->formatSessionLabel($s->session_id),
                's'  => $s->capacity
            ];
        }

        return array_values($sessions);
    }

    private function formatSessionLabel($id) {
        $labels = [
            'pagi' => 'Sesi Pagi',
            'siang' => 'Sesi Siang',
            'sore' => 'Sesi Sore',
            'reg' => 'Regular Show'
        ];
        return $labels[$id] ?? strtoupper($id);
    }

    /* ── API GET SEATS (Dibuat Dinamis) ── */
    public function getSeats(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $sessions = $this->getSchedulesForDate($tanggal);

        $results = collect($sessions)->map(function ($sess) use ($tanggal) {
            $terpakai = BookingTicket::where('tanggal_kunjungan', $tanggal)
                ->where('session_id', $sess['id'])
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->get()
                ->sum(function ($b) {
                return $b->jumlah_tiket_dewasa + $b->jumlah_tiket_anak +
       $b->jumlah_tiket_kitas_dewasa +
       $b->jumlah_tiket_manca_dewasa + $b->jumlah_tiket_manca_anak;
                });

            return [
                'id'        => $sess['id'],
                'time'      => $sess['time'] ?? $sess['t'], // Handle mapping
                'label'     => $sess['label'] ?? $sess['l'],
                'capacity'  => $sess['s'],
                'remaining' => max(0, $sess['s'] - (int) $terpakai),
            ];
        });

        return response()->json($results);
    }

    public function buy()
    {
        $products = Product::where('stock', '>', 0)->latest()->get();
        return view('buy', compact('products'));
    }

    /* ── VALIDASI PROMO: Tambahan fitur Tanggal Spesifik ── */
    public function validatePromo(Request $request)
    {
        $code = strtoupper($request->input('code', ''));
        $bookingDate = $request->input('booking_date'); // Diambil dari frontend

        if (!$code) {
            return response()->json(['valid' => false, 'message' => 'Masukkan kode promo'], 400);
        }

        $promo = Promo::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$promo) {
            return response()->json(['valid' => false, 'message' => 'Kode promo tidak valid atau kadaluarsa'], 404);
        }

        $visitDate = Carbon::parse($bookingDate);

        // Cek apakah tanggal kunjungan berada di dalam periode promo
        $startDate = Carbon::parse($promo->start_date)->startOfDay();
        $endDate   = Carbon::parse($promo->end_date)->endOfDay();

        if ($visitDate->lt($startDate) || $visitDate->gt($endDate)) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo ini hanya berlaku untuk kunjungan tanggal: ' .
                             $startDate->translatedFormat('d M Y') . ' s/d ' .
                             $endDate->translatedFormat('d M Y') . '.'
            ], 400);
        }

        if ($promo->isQuotaFull()) {
            return response()->json(['valid' => false, 'message' => 'Kuota promo sudah habis'], 400);
        }

        // Cek apakah promo hanya berlaku untuk TANGGAL TERTENTU (Fitur Request Manager)
        if ($promo->specific_dates && is_array($promo->specific_dates) && count($promo->specific_dates) > 0) {
            if (!in_array($bookingDate, $promo->specific_dates)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Promo ini hanya berlaku untuk tanggal kunjungan tertentu.',
                ], 400);
            }
        }

        // Cek Hari (Senin-Minggu)
        if (!$promo->isAllowedOnDate(Carbon::parse($bookingDate))) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo tidak berlaku pada hari: ' . Carbon::parse($bookingDate)->translatedFormat('l'),
            ], 400);
        }

        // Cek Jam/Sesi Pertunjukan (Allowed Time)
        $timeToCheck = null;
        if ($request->filled('session_time')) {
            $timeToCheck = $this->parseSessionTimeToHi($request->session_time);
        }

        if (!$promo->isAllowedAtTime($timeToCheck)) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo hanya berlaku pada jam/sesi pertunjukan ' . $promo->allowedTimeLabel()
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'promo' => [
                'id'                 => $promo->id,
                'code'               => $promo->code,
                'name'               => $promo->name,
                'discount_type'      => $promo->discount_type,
                'discount_value'     => (float) $promo->discount_value,
                'min_purchase'       => (float) $promo->min_purchase,
                'max_discount'       => (float) $promo->max_discount,
                'banner_image'       => $promo->banner_image ? asset('storage/' . $promo->banner_image) : null,
            ],
            'message' => 'Promo valid!',
        ]);
    }


    private function buildWaUrl(BookingTicket $booking, $promoInfo, bool $isForeign = false, bool $klaimHompimplay = false, string $paymentMethod = 'walkin', ?string $buktiTransferUrl = null): string
    {
        $WA_NUMBER = '6282182821200';

        Carbon::setLocale('id');
        $tanggalID = Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('l, d F Y');
        $tanggalEN = Carbon::parse($booking->tanggal_kunjungan)->locale('en')->translatedFormat('l, d F Y');

        $fmt      = fn($n) => number_format($n, 0, ',', '.');
        $hasPromo = !empty($booking->promo_code) && $promoInfo;
        $sep      = '━━━━━━━━━━━━━━━━━━━━';

        $HARGA = [
            'dewasa'       => 85000,
            'anak'         => 60000,
             'kitas_dewasa' => 85000,  
            'manca_dewasa' => 120000,
            'manca_anak'   => 85000,
        ];

        $domestikSub = ($booking->jumlah_tiket_dewasa * $HARGA['dewasa'])
                     + ($booking->jumlah_tiket_anak   * $HARGA['anak']);
        $disc = (int) $booking->discount_amount;

        $tktBlock = '';

    

        // ── Tiket Domestik ──
        if ($booking->jumlah_tiket_dewasa > 0 || $booking->jumlah_tiket_anak > 0) {
            $label = $isForeign ? "🇮🇩 Domestic Ticket" : "🇮🇩 Tiket Domestik";
            $tktBlock .= "\n{$label}:\n";

            if ($booking->jumlah_tiket_dewasa > 0) {
                $h   = $HARGA['dewasa'];
                $tot = $h * $booking->jumlah_tiket_dewasa;
                $tktBlock .= $isForeign
                    ? "  ↳ Adult  : {$booking->jumlah_tiket_dewasa} pax × Rp {$fmt($h)} = Rp {$fmt($tot)}\n"
                    : "  ↳ Dewasa : {$booking->jumlah_tiket_dewasa} org × Rp {$fmt($h)} = Rp {$fmt($tot)}\n";
            }

            if ($booking->jumlah_tiket_anak > 0) {
                $h   = $HARGA['anak'];
                $tot = $h * $booking->jumlah_tiket_anak;
                $tktBlock .= $isForeign
                    ? "  ↳ Child  : {$booking->jumlah_tiket_anak} pax × Rp {$fmt($h)} = Rp {$fmt($tot)}\n"
                    : "  ↳ Anak   : {$booking->jumlah_tiket_anak} org × Rp {$fmt($h)} = Rp {$fmt($tot)}\n";
            }

            if ($hasPromo && $disc > 0) {
                $promoLabel = $promoInfo['name'] ?? $booking->promo_code;

                if ($promoInfo['discount_type'] === 'percent') {
                    $discDisplay = " ({$promoInfo['discount_value']}%)";
                } elseif ($domestikSub > 0) {
                    $pct = round(($disc / $domestikSub) * 100);
                    $discDisplay = " ({$pct}%)";
                } else {
                    $discDisplay = '';
                }

                $tktBlock .= "  ↳ Promo ({$promoLabel}){$discDisplay} : − Rp {$fmt($disc)}\n";
            }
        }

// ── Tiket KITAS ──
if ($booking->jumlah_tiket_kitas_dewasa > 0) {
    $label = $isForeign ? "🪪 KITAS Ticket" : "🪪 Tiket KITAS";
    $tktBlock .= "\n{$label}:\n";
    $h   = $HARGA['kitas_dewasa'];
    $tot = $h * $booking->jumlah_tiket_kitas_dewasa;
    $tktBlock .= $isForeign
        ? "  ↳ Adult  : {$booking->jumlah_tiket_kitas_dewasa} pax × Rp {$fmt($h)} = Rp {$fmt($tot)}\n"
        : "  ↳ Dewasa : {$booking->jumlah_tiket_kitas_dewasa} org × Rp {$fmt($h)} = Rp {$fmt($tot)}\n";
}
        // ── Tiket Mancanegara ──
        if ($booking->jumlah_tiket_manca_dewasa > 0 || $booking->jumlah_tiket_manca_anak > 0) {
            $label = $isForeign ? "🌍 International Ticket" : "🌍 Tiket Mancanegara";
            $tktBlock .= "\n{$label}:\n";

            if ($booking->jumlah_tiket_manca_dewasa > 0) {
                $h   = $HARGA['manca_dewasa'];
                $tot = $h * $booking->jumlah_tiket_manca_dewasa;
                $tktBlock .= $isForeign
                    ? "  ↳ Adult  : {$booking->jumlah_tiket_manca_dewasa} pax × Rp {$fmt($h)} = Rp {$fmt($tot)}\n"
                    : "  ↳ Dewasa : {$booking->jumlah_tiket_manca_dewasa} org × Rp {$fmt($h)} = Rp {$fmt($tot)}\n";
            }

            if ($booking->jumlah_tiket_manca_anak > 0) {
                $h   = $HARGA['manca_anak'];
                $tot = $h * $booking->jumlah_tiket_manca_anak;
                $tktBlock .= $isForeign
                    ? "  ↳ Child  : {$booking->jumlah_tiket_manca_anak} pax × Rp {$fmt($h)} = Rp {$fmt($tot)}\n"
                    : "  ↳ Anak   : {$booking->jumlah_tiket_manca_anak} org × Rp {$fmt($h)} = Rp {$fmt($tot)}\n";
            }
        }

        // ── Catatan Penting ──
        $noteID = "📌 *Catatan Penting:*\n"
                . "  • Mohon hadir 30 menit sebelum pertunjukan dimulai\n"
                . "  • Keterlambatan akan mempengaruhi tertinggalnya materi pertunjukan\n"
                . "  • Tidak ada nomor kursi — sistem First Come First Serve";

        $noteEN = "📌 *Important Notes:*\n"
                . "  • Please arrive 30 minutes before the show starts\n"
                . "  • Late arrival may cause you to miss part of the performance\n"
                . "  • No reserved seats — First Come First Serve system";

        // ── Hompimplay Voucher Info ──
    $hompimplayVoucherID = "🎁 *Klaim Voucher:* Selamat! Anda mendapatkan Voucher Diskon Rp50.000 HompimPlay. Tunjukkan bukti reservasi SAU via website ke kasir saat kunjungan untuk mendapatkan voucher fisik.";
    $hompimplayVoucherEN = "🎁 *Voucher Claim:* Congratulations! You have received a Rp50,000 HompimPlay Discount Voucher. Show your SAU website reservation proof to the cashier during your visit to receive the physical voucher.";

       // Baris metode pembayaran dinamis berdasarkan pilihan user
$payLabels = [
    'walkin'   => '🏠 Bayar di Tempat (Walk-in)',
    'qris'     => '📱 Sudah Bayar via QRIS',
    'transfer' => '🏦 Transfer Bank',
];
$payLine = "• Metode Pembayaran  : " . ($payLabels[$paymentMethod] ?? '🏠 Bayar di Tempat (Walk-in)');

if ($paymentMethod === 'qris') {
    $payLine .= "\n  ↳ *Mohon sertakan screenshot bukti pembayaran QRIS*";
}

        // ── Header & Closing ──
        if ($isForeign) {
            $header  = $hasPromo
                ? (($promoInfo['emoji'] ?? '🎉') . ' ' . ($promoInfo['name'] ?? 'PROMO') . "\nSaung Angklung Udjo · Bandung")
                : "TICKET RESERVATION\nSaung Angklung Udjo · Bandung";
            $closing = $hasPromo
                ? ($promoInfo['closing_en'] ?? 'Hello Admin, I would like to claim this promo. Please confirm my booking 🙏')
                : "Hello Admin, I would like to book tickets at Saung Angklung Udjo. Please confirm my reservation 🙏";

            if ($hasPromo && !empty($promoInfo['banner_image'])) {
                $closing .= "\n\n📷 *Promo Poster*: " . $promoInfo['banner_image'];
            }

            $payLabelEN = ['walkin' => '🏠 Pay at Venue (Walk-in)', 'transfer' => '🏦 Bank Transfer', 'qris' => '📱 QRIS'][$paymentMethod] ?? '🏠 Pay at Venue';
            $payLineEN  = "• Payment Method     : {$payLabelEN}";
            if ($buktiTransferUrl && in_array($paymentMethod, ['transfer', 'qris'])) {
                $payLineEN .= "\n• Payment Proof      : {$buktiTransferUrl}";
            }

            $pesan = "{$header}\n{$sep}\n"
                   . "- Booking Code    : {$booking->booking_code}\n"
                   . "- Full Name       : {$booking->nama}\n"
                   . "- Phone / WA      : {$booking->no_hp}\n"
                   . "- City            : " . ($booking->kota ?: '—') . "\n"
                   . "- Country         : " . ($booking->negara_asal ?: '—') . "\n"
                   . "- Visit Date      : {$tanggalEN}\n"
                   . "- Show Time       : {$booking->session_time}\n"
                   . $tktBlock . "\n"
                   . "{$sep}\n"
                   . "Estimated Total   : Rp {$fmt($booking->total_harga)}\n"
                   . "{$payLineEN}\n\n"
                   . $noteEN . "\n\n";

            if ($klaimHompimplay) {
                $pesan .= $hompimplayVoucherEN . "\n\n";
            }

            $pesan .= $closing;
        } else {
            $header  = $hasPromo
                ? (($promoInfo['emoji'] ?? '🎉') . ' ' . ($promoInfo['name'] ?? 'PROMO') . "\nSaung Angklung Udjo · Bandung")
                : "RESERVASI TIKET\nSaung Angklung Udjo · Bandung";
            $closing = $hasPromo
                ? ($promoInfo['closing'] ?? 'Halo Admin, saya ingin mengklaim promo. Mohon konfirmasinya 🙏')
                : "Halo Admin, saya ingin memesan tiket Saung Angklung Udjo. Mohon konfirmasinya 🙏";

            if ($hasPromo && !empty($promoInfo['banner_image'])) {
                $closing .= "\n\n📷 *Poster Promo*: " . $promoInfo['banner_image'];
            }

            $pesan = "{$header}\n{$sep}\n"
                   . "•  Kode Booking        : {$booking->booking_code}\n"
                   . "•  Nama                : {$booking->nama}\n"
                   . "•  No HP / WA          : {$booking->no_hp}\n"
                   . "•  Kota Asal           : " . ($booking->kota ?: '—') . "\n"
                   . "•  Negara Asal         : " . ($booking->negara_asal ?: '—') . "\n"
                   . "•  Tanggal Kunjungan   : {$tanggalID}\n"
                   . "•  Waktu Pertunjukan   : {$booking->session_time}\n"
                   . $tktBlock . "\n"
                   . "{$sep}\n"
                   . "Total Estimasi        : Rp {$fmt($booking->total_harga)}\n"
                   . "{$payLine}\n\n"
                   . $noteID . "\n\n";

            if ($klaimHompimplay) {
                $pesan .= $hompimplayVoucherID . "\n\n";
            }

            $pesan .= $closing;
        }

        return 'https://wa.me/' . $WA_NUMBER . '?text=' . rawurlencode($pesan);
    }

    private function parseSessionTimeToHi(?string $sessionTime): ?string
    {
        if (empty($sessionTime)) {
            return null;
        }

        // Contoh: "10.00 WIB" atau "10.00 - 11.30 WIB" atau "10:00"
        $clean = str_ireplace(['wib', ' '], '', $sessionTime); // "10.00" atau "10.00-11.30"

        if (str_contains($clean, '-')) {
            $parts = explode('-', $clean);
            $clean = $parts[0]; // "10.00"
        }

        $clean = str_replace('.', ':', $clean); // "10:00"

        if (preg_match('/^\d{1,2}:\d{2}$/', $clean)) {
            if (strlen(explode(':', $clean)[0]) === 1) {
                $clean = '0' . $clean;
            }
            return $clean;
        }

        return null;
    }
public function cekOnlineAvailable($selectedDate = null, ?OnlineBookingCounter $counter = null): array
{
    $now = Carbon::now('Asia/Jakarta');
    $today = $now->toDateString();

    // 1. Validasi tanggal kunjungan (booking online HANYA berlaku untuk hari ini)
    if ($selectedDate) {
        $selectedDateStr = Carbon::parse($selectedDate)->toDateString();
        if ($selectedDateStr !== $today) {
            return [
                'available' => false,
                'reason'    => 'Pemesanan online hanya berlaku untuk kunjungan hari ini.',
                'sisa'      => 0
            ];
        }
    }

    // 2. Validasi jam operasional (08:00 - 17:00 setiap hari)
    $startTime = Carbon::today('Asia/Jakarta')->setTime(8, 0, 0);
    $endTime = Carbon::today('Asia/Jakarta')->setTime(17, 0, 0);

    if ($now->lt($startTime) || $now->gt($endTime)) {
        return [
            'available' => false,
            'reason'    => 'Pemesanan online hanya tersedia pukul 08.00 s/d 17.00 WIB.',
            'sisa'      => 0
        ];
    }

    // 3. Ambil counter jika tidak disuplai
    if (!$counter) {
        $counter = OnlineBookingCounter::firstOrCreate(
            ['tanggal' => $today],
            ['total_klik' => 0, 'kapasitas' => 20]
        );
    }

    if ($counter->is_closed) {
        return [
            'available' => false,
            'reason'    => 'Pemesanan online sedang ditutup sementara.',
            'sisa'      => 0
        ];
    }

    if ($counter->total_klik >= $counter->kapasitas) {
        return [
            'available' => false,
            'reason'    => 'Kuota pemesanan online hari ini sudah habis.',
            'sisa'      => 0
        ];
    }

    return [
        'available' => true,
        'sisa'      => max(0, $counter->kapasitas - $counter->total_klik),
        'reason'    => null
    ];
}

public function redirectMajoo(Request $request)
{
    $bookingCode = $request->input('booking_code');
    $booking = BookingTicket::where('booking_code', $bookingCode)->first();

    if (!$booking) {
        return response()->json(['available' => false, 'reason' => 'Data booking tidak ditemukan.'], 404);
    }

    $cek = null;

    \Illuminate\Support\Facades\DB::transaction(function () use ($booking, &$cek) {
        $counter = OnlineBookingCounter::lockForUpdate()->firstOrCreate(
            ['tanggal' => Carbon::today('Asia/Jakarta')->toDateString()],
            ['total_klik' => 0, 'kapasitas' => 20]
        );

        $cek = $this->cekOnlineAvailable($booking->tanggal_kunjungan, $counter);

        if (!$cek['available']) {
            $booking->update(['status' => 'cancelled']);
            return;
        }

        $counter->increment('total_klik');
    });

    if (!$cek['available']) {
        return response()->json(['available' => false, 'reason' => $cek['reason']], 422);
    }

    return response()->json([
        'available' => true,
        'majoo_url' => 'https://saung-angklung-udjo-6104.majooshop.id',
        'sisa'      => $cek['sisa'] - 1,
    ]);
}

public function onlineStatus(Request $request)
{
    $selectedDate = $request->query('tanggal');
    $cek = $this->cekOnlineAvailable($selectedDate);
    return response()->json($cek);
}
    
}

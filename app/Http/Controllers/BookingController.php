<?php

namespace App\Http\Controllers;

use App\Models\BookingTicket;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('tickets.buy');
    }

    public function submit(Request $request)
    {
        /* ── 1. Validasi ── */
        $validated = $request->validate([
            'nama'                      => 'required|string|max:100',
            'no_hp'                     => 'required|string|max:30',
            'email'                     => 'required|email|max:120',
            'kota'                      => 'nullable|string|max:100',
            'tanggal_kunjungan'         => 'required|date|after_or_equal:today',
            'session_id'                => 'required|in:pagi,siang,sore,reg',
            'session_time'              => 'required|string|max:60',
            'jumlah_tiket_dewasa'       => 'required|integer|min:0',
            'jumlah_tiket_anak'         => 'required|integer|min:0',
            'jumlah_tiket_manca_dewasa' => 'required|integer|min:0',
            'jumlah_tiket_manca_anak'   => 'required|integer|min:0',
            'promo_code'                => 'nullable|string|max:30',
            'discount_amount'           => 'required|integer|min:0',
            'subtotal'                  => 'required|integer|min:0',
            'total_harga'               => 'required|integer|min:1',
        ], [
            'nama.required'             => 'Nama lengkap wajib diisi.',
            'no_hp.required'            => 'Nomor HP / WA wajib diisi.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'tanggal_kunjungan.required'=> 'Tanggal kunjungan wajib dipilih.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'session_id.required'       => 'Sesi pertunjukan wajib dipilih.',
            'total_harga.min'           => 'Pilih minimal 1 tiket.',
        ]);

        /* Pastikan minimal 1 tiket dipilih */
        $totalTiket = $validated['jumlah_tiket_dewasa']
                    + $validated['jumlah_tiket_anak']
                    + $validated['jumlah_tiket_manca_dewasa']
                    + $validated['jumlah_tiket_manca_anak'];

        if ($totalTiket < 1) {
            return response()->json([
                'errors' => ['jumlah_tiket_dewasa' => ['Pilih minimal 1 tiket.']]
            ], 422);
        }

        /* ── 2. Hapus pending duplikat untuk jadwal yang sama jika sudah ada confirmed booking ── */
        BookingTicket::where('no_hp', $validated['no_hp'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->where('session_id', $validated['session_id'])
            ->where('session_time', $validated['session_time'])
            ->where('status', 'pending')
            ->delete();

        /* ── 3. Simpan ke database ── */
        $booking = BookingTicket::create([
            'booking_code'              => BookingTicket::generateCode(),
            'nama'                      => $validated['nama'],
            'no_hp'                     => $validated['no_hp'],
            'email'                     => $validated['email'],
            'kota'                      => $validated['kota'] ?? null,
            'tanggal_kunjungan'         => $validated['tanggal_kunjungan'],
            'session_id'                => $validated['session_id'],
            'session_time'              => $validated['session_time'],
            'jumlah_tiket_dewasa'       => $validated['jumlah_tiket_dewasa'],
            'jumlah_tiket_anak'         => $validated['jumlah_tiket_anak'],
            'jumlah_tiket_manca_dewasa' => $validated['jumlah_tiket_manca_dewasa'],
            'jumlah_tiket_manca_anak'   => $validated['jumlah_tiket_manca_anak'],
            'promo_code'                => $validated['promo_code'] ?? null,
            'discount_amount'           => $validated['discount_amount'],
            'subtotal'                  => $validated['subtotal'],
            'total_harga'               => $validated['total_harga'],
            'status'                    => 'confirmed',
            'wa_opened_at'              => now(),
        ]);

        /* ── 3. Bangun WA URL ── */
        $waUrl = $this->buildWaUrl($booking, $request->input('promo_info'));

        return response()->json([
            'success'      => true,
            'booking_code' => $booking->booking_code,
            'wa_url'       => $waUrl,
        ]);
    }


public function getSeats(Request $request)
{
    $tanggal   = $request->query('tanggal');
    $sessionId = $request->query('session_id');
    $kapasitas = 100;

    $terpakai = BookingTicket::where('tanggal_kunjungan', $tanggal)
                             ->where('session_id', $sessionId)
                             ->whereIn('status', ['pending', 'confirmed'])
                             ->get()
                             ->sum(function ($b) {
                                 return $b->jumlah_tiket_dewasa
                                      + $b->jumlah_tiket_anak
                                      + $b->jumlah_tiket_manca_dewasa
                                      + $b->jumlah_tiket_manca_anak;
                             });

    return response()->json([
        'remaining' => max(0, $kapasitas - (int) $terpakai),
        'capacity'  => $kapasitas,
    ]);
}

    private function buildWaUrl(BookingTicket $booking, ?array $promoInfo): string
    {
        $WA_NUMBER = '6282182821200';

        $months = ['','Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];
        $days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        $tgl    = $booking->tanggal_kunjungan;
        $tglStr = $days[$tgl->dayOfWeek] . ', ' . $tgl->day . ' ' . $months[$tgl->month] . ' ' . $tgl->year;

        $sessStart = ['pagi'=>'10.00 WIB','siang'=>'13.00 WIB','sore'=>'15.30 WIB','reg'=>'15.30 WIB'];
        $sessWaktu = $sessStart[$booking->session_id] ?? $booking->session_time;

        $fmt = fn($n) => number_format($n, 0, ',', '.');

        $promoSuffix = $booking->promo_code ? ' (Promo)' : '';
        $tktBlock    = '';

        // Domestik
        $domLines = [];
        if ($booking->jumlah_tiket_dewasa > 0) {
            $h = $booking->promo_code
                ? (int) round(85000 * (1 - ($promoInfo['disc'] ?? 0)))
                : 85000;
            $domLines[] = "  ↳ Dewasa : {$booking->jumlah_tiket_dewasa} org × Rp {$fmt($h)} = Rp {$fmt($h * $booking->jumlah_tiket_dewasa)}";
        }
        if ($booking->jumlah_tiket_anak > 0) {
            $h = $booking->promo_code
                ? (int) round(60000 * (1 - ($promoInfo['disc'] ?? 0)))
                : 60000;
            $domLines[] = "  ↳ Anak   : {$booking->jumlah_tiket_anak} org × Rp {$fmt($h)} = Rp {$fmt($h * $booking->jumlah_tiket_anak)}";
        }
        if ($domLines) {
            $tktBlock .= "\n🇮🇩 Tiket Domestik{$promoSuffix}:\n" . implode("\n", $domLines);
        }

        // Mancanegara
        $intLines = [];
        if ($booking->jumlah_tiket_manca_dewasa > 0) {
            $h = $booking->promo_code
                ? (int) round(120000 * (1 - ($promoInfo['disc'] ?? 0)))
                : 120000;
            $intLines[] = "  ↳ Dewasa : {$booking->jumlah_tiket_manca_dewasa} org × Rp {$fmt($h)} = Rp {$fmt($h * $booking->jumlah_tiket_manca_dewasa)}";
        }
        if ($booking->jumlah_tiket_manca_anak > 0) {
            $h = $booking->promo_code
                ? (int) round(85000 * (1 - ($promoInfo['disc'] ?? 0)))
                : 85000;
            $intLines[] = "  ↳ Anak   : {$booking->jumlah_tiket_manca_anak} org × Rp {$fmt($h)} = Rp {$fmt($h * $booking->jumlah_tiket_manca_anak)}";
        }
        if ($intLines) {
            $tktBlock .= "\n🌍 Tiket Mancanegara{$promoSuffix}:\n" . implode("\n", $intLines);
        }

        $sep = '━━━━━━━━━━━━━━━━━━━━';
        if ($booking->promo_code && $promoInfo) {
            $header  = ($promoInfo['emoji'] ?? '🎉') . ' ' . ($promoInfo['label'] ?? 'PROMO') . "\nSaung Angklung Udjo · Bandung";
            if (!empty($promoInfo['periode'])) $header .= "\n🗓️ Periode: {$promoInfo['periode']}";
            $closing = $promoInfo['closing'] ?? 'Halo Admin, saya ingin mengklaim promo Saung Angklung Udjo. Mohon konfirmasinya 🙏';
        } else {
            $header  = "RESERVASI TIKET\nSaung Angklung Udjo · Bandung";
            $closing = "Halo Admin, saya ingin memesan tiket Saung Angklung Udjo. Mohon konfirmasinya";
        }

        $msg = "{$header}\n{$sep}\n"
             . "- Kode Booking : {$booking->booking_code}\n"
             . "-  Nama  : {$booking->nama}\n"
             . "-  No HP : {$booking->no_hp}\n"
             . "-  Kota  : " . ($booking->kota ?: '—') . "\n"
             . "-  Email : {$booking->email}\n"
             . "-  Tanggal Kunjungan : {$tglStr}\n"
             . "-  Waktu Pertunjukan : {$sessWaktu}\n"
             . $tktBlock . "\n"
             . "{$sep}\n"
             . "Total Estimasi : Rp {$fmt($booking->total_harga)}\n"
             . $closing;

        return 'https://wa.me/' . $WA_NUMBER . '?text=' . rawurlencode($msg);
    }

    /**
     * Validasi dan dapatkan informasi promo
     */
    public function validatePromo(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json([
                'valid' => false,
                'message' => 'Masukkan kode promo'
            ], 400);
        }

        $promo = \App\Models\Promo::where('code', strtoupper($code))
                                   ->active()
                                   ->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo tidak valid atau telah kadaluarsa'
            ], 404);
        }

        // Cek kuota
        if ($promo->isQuotaFull()) {
            return response()->json([
                'valid' => false,
                'message' => 'Kuota promo sudah habis'
            ], 400);
        }

        // Return promo info
        return response()->json([
            'valid' => true,
            'promo' => [
                'id' => $promo->id,
                'code' => $promo->code,
                'name' => $promo->name,
                'type' => $promo->type,
                'discount_type' => $promo->discount_type,
                'discount_value' => $promo->discount_value,
                'min_purchase' => $promo->min_purchase,
                'max_discount' => $promo->max_discount,
                'description' => $promo->description,
            ]
        ]);
    }
}

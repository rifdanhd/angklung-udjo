<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoKlaim;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo-long-weekend');
    }

    public function submit(Request $request)
    {
        // 1. VALIDASI DATA
        $request->validate([
            'nama'                => 'required|string|max:100',
            'no_hp'               => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,11}$/'],
            'tanggal_kunjungan'   => 'required|date|in:2026-05-14,2026-05-15,2026-05-16',
        ], [
            'tanggal_kunjungan.in' => 'Jadwal yang dipilih tidak valid untuk promo ini.',
            'no_hp.regex'          => 'Nomor WhatsApp tidak valid (Gunakan format 0812...).'
        ]);

        $dewasa  = (int)$request->jumlah_tiket_dewasa;
        $anak    = (int)$request->jumlah_tiket_anak;
        $mDewasa = (int)$request->jumlah_tiket_manca_dewasa;
        $mAnak   = (int)$request->jumlah_tiket_manca_anak;

        if (($dewasa + $anak + $mDewasa + $mAnak) < 1) {
            return back()->withErrors(['tiket' => 'Harap masukkan minimal 1 tiket.'])->withInput();
        }

        // 2. HITUNG HARGA (Dewasa diskon 10%, Anak Normal)
        $totalDomDewasa   = $dewasa * 76500;
        $totalDomAnak     = $anak * 60000;
        $totalMancaDewasa = $mDewasa * 108000;
        $totalMancaAnak   = $mAnak * 85000;
        
        $totalHarga = $totalDomDewasa + $totalDomAnak + $totalMancaDewasa + $totalMancaAnak;

        // 3. GENERATE KODE BOOKING (Contoh: SAU-20260514-ABCD)
        $bookingCode = 'SAU-' . date('Ymd', strtotime($request->tanggal_kunjungan)) . '-' . strtoupper(Str::random(4));

        // 4. SIMPAN KE DB
        PromoKlaim::create([
            'nama'                      => $request->nama,
            'kota'                      => $request->kota ?? '-',
            'jumlah_tiket_dewasa'       => $dewasa,
            'jumlah_tiket_anak'         => $anak,
            'jumlah_tiket_manca_dewasa' => $mDewasa,
            'jumlah_tiket_manca_anak'   => $mAnak,
            'tanggal_kunjungan'         => $request->tanggal_kunjungan,
            'no_hp'                     => $request->no_hp,
            'total_harga'               => $totalHarga,
            'status'                    => 'pending',
        ]);

        // 5. MAPPING JAM PERTUNJUKAN
        $jam = [
            '2026-05-14' => '10.00 WIB',
            '2026-05-15' => '15.30 WIB',
            '2026-05-16' => '13.00 WIB',
        ];
        $jamTerpilih = $jam[$request->tanggal_kunjungan];

        // 6. FORMAT TANGGAL INDONESIA
        Carbon::setLocale('id');
        $tglFormat = Carbon::parse($request->tanggal_kunjungan)->translatedFormat('l, d F Y');

        // 7. SUSUN PESAN WHATSAPP DETAIL
        $pesan  = "*RESERVASI TIKET*\n";
        $pesan .= "Saung Angklung Udjo · Bandung\n";
        $pesan .= "━━━━━━━━━━━━━━━━━━━━\n";
        $pesan .= "• *Nama*                : {$request->nama}\n";
        $pesan .= "• *No HP / WA*          : {$request->no_hp}\n";
        $pesan .= "• *Tanggal Kunjungan*   : {$tglFormat}\n";
        $pesan .= "• *Waktu Pertunjukan*   : {$jamTerpilih}\n\n";

        // Rincian Tiket Domestik
        if ($dewasa > 0 || $anak > 0) {
            $pesan .= "🇮🇩 *Tiket Domestik:*\n";
            if ($dewasa > 0) {
                $pesan .= "  ↳ Dewasa (Promo) : {$dewasa} org × Rp 76.500 = Rp " . number_format($totalDomDewasa, 0, ',', '.') . "\n";
            }
            if ($anak > 0) {
                $pesan .= "  ↳ Anak (Normal)  : {$anak} org × Rp 60.000 = Rp " . number_format($totalDomAnak, 0, ',', '.') . "\n";
            }
            $pesan .= "\n";
        }

        // Rincian Tiket Mancanegara
        if ($mDewasa > 0 || $mAnak > 0) {
            $pesan .= "🌏 *Tiket Mancanegara:*\n";
            if ($mDewasa > 0) {
                $pesan .= "  ↳ Adult (Promo) : {$mDewasa} org × Rp 108.000 = Rp " . number_format($totalMancaDewasa, 0, ',', '.') . "\n";
            }
            if ($mAnak > 0) {
                $pesan .= "  ↳ Child (Normal) : {$mAnak} org × Rp 85.000 = Rp " . number_format($totalMancaAnak, 0, ',', '.') . "\n";
            }
            $pesan .= "\n";
        }

        $pesan .= "━━━━━━━━━━━━━━━━━━━━\n";
        $pesan .= "*Total Estimasi : Rp " . number_format($totalHarga, 0, ',', '.') . "*\n\n";

        $pesan .= "📢 *Catatan Penting:*\n";
        $pesan .= "  • Mohon hadir 30 menit sebelum pertunjukan dimulai\n";
        $pesan .= "  • Keterlambatan akan mempengaruhi materi pertunjukan\n";
        $pesan .= "  • Tidak ada nomor kursi — sistem First Come First Serve\n\n";

        $pesan .= "Halo Admin, saya ingin memesan tiket *Promo Long Weekend*. Mohon konfirmasinya 🙏";

        $nomorAdmin = '6282182821200';
        return redirect()->away('https://wa.me/' . $nomorAdmin . '?text=' . urlencode($pesan));
    }
}
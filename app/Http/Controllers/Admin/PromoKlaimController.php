<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PromoKlaimExport;
use App\Http\Controllers\Controller;
use App\Models\PromoKlaim;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PromoKlaimController extends Controller
{
    const LONG_WEEKEND_DATES = ['2026-05-14', '2026-05-15', '2026-05-16'];

    public function index(Request $request)
    {
        $query = PromoKlaim::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                    ->orWhere('no_hp', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter per event
        $event = $request->get('event', 'all');
        if ($event === 'long_weekend') {
            $query->whereIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        } elseif ($event === 'ramadan') {
            $query->whereNotIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        }

        $klaims = $query->latest()->paginate(50);

        // Stats ikut filter event
        $base = PromoKlaim::query();
        if ($event === 'long_weekend') {
            $base->whereIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        } elseif ($event === 'ramadan') {
            $base->whereNotIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        }

        $totalKlaim = (clone $base)->count();
        $totalPendapatan = (clone $base)->where('status', 'confirmed')->sum('total_harga');
        $totalDewasa = (clone $base)->sum('jumlah_tiket_dewasa');
        $totalAnak = (clone $base)->sum('jumlah_tiket_anak');
        $totalMancaDewasa = (clone $base)->sum('jumlah_tiket_manca_dewasa');
        $totalMancaAnak = (clone $base)->sum('jumlah_tiket_manca_anak');
        $totalPax = $totalDewasa + $totalAnak + $totalMancaDewasa + $totalMancaAnak;
        $totalPending = (clone $base)->where('status', 'pending')->count();

        return view('admin.promo-klaim.index', compact(
            'klaims', 'totalKlaim', 'totalDewasa', 'totalAnak',
            'totalMancaDewasa', 'totalMancaAnak', 'totalPax',
            'totalPendapatan', 'totalPending', 'event'
        ));
    }

    public function updateStatus(Request $request, PromoKlaim $promoKlaim)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);
        $promoKlaim->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function destroy(PromoKlaim $promoKlaim)
    {
        $promoKlaim->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $event = $request->get('event', 'all');
        $query = PromoKlaim::where('status', 'confirmed');

        if ($event === 'long_weekend') {
            $query->whereIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        } elseif ($event === 'ramadan') {
            $query->whereNotIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        }

        $data = $query->get();
        $fileName = 'rekap-promo-'.$event.'-'.date('dmY').'.xlsx';

        return Excel::download(new PromoKlaimExport($data), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $event = $request->get('event', 'all');

        $query = PromoKlaim::where('status', 'confirmed')->latest();

        if ($event === 'long_weekend') {
            $query->whereIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        } elseif ($event === 'ramadan') {
            $query->whereNotIn('tanggal_kunjungan', self::LONG_WEEKEND_DATES);
        }

        $data = $query->get();

        $summary = [
            'total_klaim' => $data->count(),
            'total_pax' => $data->sum('jumlah_tiket_dewasa') + $data->sum('jumlah_tiket_anak') + $data->sum('jumlah_tiket_manca_dewasa') + $data->sum('jumlah_tiket_manca_anak'),
            'total_pendapatan' => $data->sum('total_harga'),
        ];

        $judul = match ($event) {
            'long_weekend' => 'Rekap Promo Long Weekend Mei 2026',
            'ramadan' => 'Rekap Promo Ramadan 2026',
            default => 'Rekap Semua Promo 2026',
        };

        $pdf = Pdf::loadView('admin.promo-klaim.pdf', compact('data', 'summary', 'judul'));

        return $pdf->download(strtolower(str_replace(' ', '-', $judul)).'.pdf');
    }
}

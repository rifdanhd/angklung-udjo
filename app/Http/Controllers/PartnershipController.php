<?php
namespace App\Http\Controllers;
use App\Models\Partnership;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnershipController extends Controller
{
    public function index()
    {
        return view('partnership');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_travel'         => 'required|string|max:255',
            'nama_pic'            => 'required|string|max:255',
            'alamat'              => 'required|string|max:1000',
            'no_wa'               => 'required|string|max:20',
            'status_kunjungan'    => 'required|in:pernah,belum',
            'kapan_pernah'        => 'nullable|string|max:255',
            'rencana_kunjungan'   => 'nullable|string|max:255',
            'sumber_info'         => 'required|array|min:1',
            'sumber_info.*'       => 'in:travel_fair,instagram,tiktok,youtube,facebook,website,kerabat,lainnya',
            'sumber_info_lainnya' => 'nullable|string|max:255',
        ], [
            'nama_travel.required'      => 'Nama tour & travel wajib diisi.',
            'nama_pic.required'         => 'Nama contact person wajib diisi.',
            'alamat.required'           => 'Alamat / domisili wajib diisi.',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi.',
            'status_kunjungan.required' => 'Status kunjungan wajib dipilih.',
            'sumber_info.required'      => 'Sumber informasi wajib dipilih minimal satu.',
        ]);

        // Simpan ke database
        Partnership::create([
            'nama_travel'         => $validated['nama_travel'],
            'nama_pic'            => $validated['nama_pic'],
            'alamat'              => $validated['alamat'],
            'no_wa'               => $validated['no_wa'],
            'status_kunjungan'    => $validated['status_kunjungan'],
            'kapan_pernah'        => $validated['kapan_pernah'] ?? null,
            'rencana_kunjungan'   => $validated['rencana_kunjungan'] ?? null,
            'sumber_info'         => implode(', ', $validated['sumber_info']),
            'sumber_info_lainnya' => $validated['sumber_info_lainnya'] ?? null,
        ]);

        // Kirim ke Google Sheets
        try {
            $sheetId = config('services.google.spreadsheet_id');

            if (empty($sheetId)) {
                throw new \RuntimeException('GOOGLE_SPREADSHEET_ID belum diset di .env');
            }

            $kunjunganDetail = $validated['status_kunjungan'] === 'pernah'
                ? 'Pernah' . (!empty($validated['kapan_pernah']) ? ' – ' . $validated['kapan_pernah'] : '')
                : 'Belum';

            $sumberList = $validated['sumber_info'];
            if (in_array('lainnya', $sumberList) && !empty($validated['sumber_info_lainnya'])) {
                $sumberList = array_map(
                    fn($s) => $s === 'lainnya' ? 'Lainnya: ' . $validated['sumber_info_lainnya'] : $s,
                    $sumberList
                );
            }

            $sheetsService = new GoogleSheetService();
            $sheetsService
                ->setSpreadsheetId($sheetId)
                ->appendData('DATA PARTNERSHIP!A:G', [[
                    now()->format('d/m/Y H:i'),
                    $validated['nama_travel'],
                    $validated['nama_pic'],
                    $validated['alamat'],
                    '+62' . $validated['no_wa'],
                    $kunjunganDetail,
                    implode(', ', $sumberList),
                ]]);

        } catch (\Exception $e) {
            Log::error('Google Sheets Partnership error: ' . $e->getMessage());
        }

        return redirect()->route('partnership.index')
            ->with('success', 'Terima kasih, ' . $validated['nama_pic'] . '! Pendaftaran partnership Anda berhasil diterima. Tim kami akan menghubungi Anda segera.');
    }
}
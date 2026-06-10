<?php

namespace App\Http\Controllers;

use App\Helpers\QrisHelper;
use Illuminate\Http\Request;

class QrisController extends Controller
{
    /**
     * Tampilkan halaman utama (form generator)
     */
    public function index()
    {
        return view('qris'); // resources/views/qris.blade.php
    }

    /**
     * Generate QRIS dinamis dari nominal yang dikirim frontend
     * POST /qris/generate
     */
    public function generate(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:50000000'],
        ]);

        $staticQris = config('qris.static');

        if (empty($staticQris)) {
            return response()->json([
                'success' => false,
                'message' => 'QRIS statis belum dikonfigurasi. Isi QRIS_STATIC di file .env',
            ], 500);
        }

        try {
            $amount  = (int) $request->input('amount');
            $dynamic = QrisHelper::toDynamic($staticQris, $amount);
            $valid   = QrisHelper::verifyCrc($dynamic);

            return response()->json([
                'success' => true,
                'dynamic' => $dynamic,
                'amount'  => $amount,
                'valid'   => $valid,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}

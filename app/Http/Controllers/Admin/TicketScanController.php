<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TicketScanController extends Controller
{
    public function index()
    {
        return view('admin.tickets.scan');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'order_code' => ['required', 'string'],
        ]);

        $orderCode = trim($request->input('order_code'));

        $order = Order::where('order_code', $orderCode)
            ->orWhere('id', $orderCode)
            ->first();

        if (! $order) {
            return response()->json([
                'message' => 'Order tidak ditemukan. Pastikan kode pesanan atau QR sudah benar.',
            ], 404);
        }

        if ($order->status !== 'paid') {
            return response()->json([
                'message' => 'Order belum dibayar. Status saat ini: ' . ucfirst($order->status) . '.',
                'order'   => $this->formatOrder($order),
            ], 422);
        }

        if ($order->used_at) {
            return response()->json([
                'message' => 'Tiket sudah pernah digunakan.',
                'order'   => $this->formatOrder($order),
            ], 409);
        }

        $order->update(['used_at' => now()]);

        return response()->json([
            'message' => 'Tiket valid. Pengunjung dapat masuk.',
            'order'   => $this->formatOrder($order->fresh()),
        ]);
    }

    private function formatOrder(Order $order): array
    {
        return [
            'id'                => $order->id,
            'order_code'        => $order->order_code,
            'nama_pemesan'      => $order->nama_pemesan,
            'email'             => $order->email,
            'no_telepon'        => $order->no_telepon,
            'tanggal_kunjungan' => optional($order->tanggal_kunjungan)->format('d M Y'),
            'sesi'              => $order->sesi,
            'jumlah_tiket'      => $order->jumlah_tiket,
            'total_bayar'       => 'Rp ' . number_format($order->total_bayar, 0, ',', '.'),
            'status'            => $order->status,
            'used_at'           => optional($order->used_at)->format('d M Y H:i'),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Notification;
use App\Mail\ETicketMail;
use Illuminate\Support\Facades\Mail;
class PaymentController extends Controller

{
    public function __construct(protected MidtransService $midtrans) {}

    public function createSnapToken(Request $request)
    {
        $data = $request->validate([
            'customer.name'   => 'required|string',
            'customer.email'  => 'required|email',
            'customer.phone'  => 'required|string',
            'customer.city'   => 'nullable|string',
            'booking.date'    => 'required|string',
            'booking.session' => 'required|string',
            'booking.items'   => 'required|array|min:1',
            'booking.total'   => 'required|integer|min:1',
        ]);

        // Buat order baru di DB
        $order = Order::create([
            'order_code'    => 'SAU-' . strtoupper(Str::random(8)),
            'nama_pemesan'  => $data['customer']['name'],
            'email'         => $data['customer']['email'],
            'no_telepon'    => $data['customer']['phone'],
            'kota_asal'     => $data['customer']['city'] ?? null,
            'tanggal_kunjungan' => $data['booking']['date'],
            'jumlah_tiket'      => array_sum(array_column($data['booking']['items'], 'qty')),
            'total_tiket'       => array_sum(array_column($data['booking']['items'], 'qty')),
            'harga_per_tiket'   => 0,
            'sesi'          => $data['booking']['session'],
            'items'         => json_encode($data['booking']['items']),
            'total_bayar'   => $data['booking']['total'],
            'status'        => 'pending',
            'user_id'       => auth()->id() ?? null,
        ]);

        $snapToken = $this->midtrans->createSnapToken($order);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id'   => $order->order_code,
        ]);
    }

   public function notification(Request $request)
{
    $notif       = new Notification();
    $status      = $notif->transaction_status;
    $fraudStatus = $notif->fraud_status;
    $orderCode   = $notif->order_id;

    $order = Order::where('order_code', $orderCode)->firstOrFail();

    $newStatus = match(true) {
        $status === 'capture' && $fraudStatus === 'accept' => 'paid',
        $status === 'settlement' => 'paid',
        in_array($status, ['cancel', 'deny', 'expire']) => 'cancelled',
        default => 'pending',
    };

    $order->update([
        'status'  => $newStatus,
        'paid_at' => $newStatus === 'paid' ? now() : null,
    ]);

    // Kirim e-ticket jika berhasil bayar
    if ($newStatus === 'paid' && $order->email) {
        Mail::to($order->email)->send(new ETicketMail($order));
    }

    return response()->json(['status' => 'ok']);
}
    public function success(Request $request)
    {
        // Kita ambil order berdasarkan order_id yang dikirim di URL nanti
        $order = Order::where('order_code', $request->order_id)->firstOrFail();
        return view('tickets.success', compact('order'));
    }
}

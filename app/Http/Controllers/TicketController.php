<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Schema;

class TicketController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    // 🔹 HALAMAN BELI
    public function buy()
    {
        return view('tickets.buy');
    }

    // 🔹 STORE ORDER + CHARGE VIA CORE API
    public function store(Request $request)
    {
        $booking  = $request->input('booking');
        $customer = $request->input('customer');
        $paymentMethod = $request->input('payment_method', 'qris'); // default qris

        // Cek apakah order dengan data sama sudah ada dan masih pending
        $existing = Order::where('user_id', \Auth::id())
            ->where('status', 'pending')
            ->where('tanggal_kunjungan', $booking['date'])
            ->where('total_bayar', $booking['total'])
            ->where('payment_method', $paymentMethod)
            ->where('created_at', '>=', now()->subMinutes(30))
            ->first();

        if ($existing && $existing->payment_data) {
            return response()->json([
                'success'        => true,
                'order_id'       => $existing->id,
                'order_code'     => $existing->order_code,
                'payment_method' => $existing->payment_method,
                'payment_data'   => $existing->payment_data,
            ]);
        }

        $order = Order::create([
            'order_code'          => Order::generateOrderCode(),
            'user_id'             => \Auth::id(),
            'nama_pemesan'        => $customer['name'],
            'email'               => $customer['email'],
            'no_telepon'          => $customer['phone'],
            'kota_asal'           => $customer['city'],
            'sesi'                => $booking['session'],
            'items'               => $booking['items'],
            'tanggal_kunjungan'   => $booking['date'],
            'jumlah_tiket'        => count($booking['items']),
            'jumlah_tiket_gratis' => 0,
            'total_tiket'         => count($booking['items']),
            'harga_per_tiket'     => $booking['items'][0]['price'] ?? 0,
            'total_bayar'         => $booking['total'],
            'status'              => 'pending',
            'payment_method'      => $paymentMethod,
        ]);

        try {
            // Determine which Core API method to call
            if (str_ends_with($paymentMethod, '_va')) {
                // VA: extract bank name (e.g. 'bca_va' -> 'bca')
                $bank = str_replace('_va', '', $paymentMethod);
                $response = $this->midtrans->chargeVA($order, $bank);
            } elseif ($paymentMethod === 'qris') {
                $response = $this->midtrans->chargeQris($order);
            } else {
                return response()->json(['error' => 'Metode pembayaran tidak didukung'], 400);
            }

            // Parse response data
            $paymentData = $this->parsePaymentResponse($response, $paymentMethod);

            // Save to order
            $order->update([
                'payment_data'           => $paymentData,
                'midtrans_transaction_id' => $response->transaction_id ?? null,
            ]);

            return response()->json([
                'success'        => true,
                'order_id'       => $order->id,
                'order_code'     => $order->order_code,
                'payment_method' => $paymentMethod,
                'payment_data'   => $paymentData,
            ]);

        } catch (\Exception $e) {
            $order->update(['status' => 'failed']);
            return response()->json([
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Parse Midtrans Core API response into structured payment data
     */
    private function parsePaymentResponse($response, string $method): array
    {
        $data = [
            'transaction_id'     => $response->transaction_id ?? null,
            'transaction_status' => $response->transaction_status ?? null,
            'expiry_time'        => $response->expiry_time ?? null,
            'gross_amount'       => $response->gross_amount ?? null,
        ];

        if (str_ends_with($method, '_va')) {
            // Virtual Account response
            if (isset($response->va_numbers) && count($response->va_numbers) > 0) {
                $data['va_number'] = $response->va_numbers[0]->va_number;
                $data['bank']      = $response->va_numbers[0]->bank;
            } elseif (isset($response->permata_va_number)) {
                // Permata has a different response format
                $data['va_number'] = $response->permata_va_number;
                $data['bank']      = 'permata';
            } elseif (isset($response->bill_key)) {
                // Mandiri Bill has different format
                $data['bill_key']    = $response->bill_key;
                $data['biller_code'] = $response->biller_code;
                $data['bank']        = 'mandiri';
            }
        } elseif ($method === 'qris') {
            // GoPay QRIS response
            if (isset($response->actions)) {
                foreach ($response->actions as $action) {
                    if ($action->name === 'generate-qr-code') {
                        $data['qr_url'] = $action->url;
                    }
                    if ($action->name === 'deeplink-redirect') {
                        $data['deeplink_url'] = $action->url;
                    }
                }
            }
        }

        return $data;
    }

    // 🔹 CHECK PAYMENT STATUS (polling from frontend)
    public function checkPaymentStatus(string $orderCode)
    {
        try {
            $order = Order::where('order_code', $orderCode)
                          ->orWhere('id', $orderCode)
                          ->firstOrFail();

            $status = $this->midtrans->checkStatus($order->order_code);

            $newStatus = match(true) {
                ($status->transaction_status === 'capture' && ($status->fraud_status ?? '') === 'accept') => 'paid',
                $status->transaction_status === 'settlement' => 'paid',
                in_array($status->transaction_status, ['cancel', 'deny', 'expire']) => 'cancelled',
                default => 'pending',
            };

            if ($order->status !== $newStatus) {
                $order->update([
                    'status'  => $newStatus,
                    'paid_at' => $newStatus === 'paid' ? now() : null,
                ]);

                // Send e-ticket if paid
                if ($newStatus === 'paid' && $order->email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($order->email)
                            ->send(new \App\Mail\ETicketMail($order));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send e-ticket: ' . $e->getMessage());
                    }
                }
            }

            return response()->json([
                'status'             => $newStatus,
                'transaction_status' => $status->transaction_status ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $order->status,
                'error'  => $e->getMessage(),
            ]);
        }
    }

    // 🔹 PAYMENT PAGE (legacy)
    public function payment(Order $order)
    {
        return view('tickets.payment', compact('order'));
    }

    // 🔹 SUCCESS
    public function success(Request $request)
    {
        $orderCode = $request->order_id ?? $request->route('order');

        $order = Order::where('order_code', $orderCode)
                      ->orWhere('id', $orderCode)
                      ->firstOrFail();

        return view('tickets.success', compact('order'));
    }
}
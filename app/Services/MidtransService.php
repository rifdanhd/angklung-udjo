<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$clientKey    = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Charge via Virtual Account (BCA, BNI, Mandiri, BRI, Permata)
     */
    public function chargeVA($order, string $bank): object
    {
        $items = is_string($order->items)
            ? json_decode($order->items, true)
            : $order->items;

        $params = [
            'payment_type' => 'bank_transfer',
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => (int) $order->total_bayar,
            ],
            'bank_transfer' => [
                'bank' => $bank,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'email'      => $order->email,
                'phone'      => $order->no_telepon ?? '',
            ],
            'item_details' => array_map(fn($item) => [
                'id'       => $item['id'],
                'name'     => $item['name'],
                'price'    => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
            ], $items),
        ];

        return CoreApi::charge($params);
    }

    /**
     * Charge via QRIS (GoPay)
     */
    public function chargeQris($order): object
    {
        $items = is_string($order->items)
            ? json_decode($order->items, true)
            : $order->items;

        $params = [
            'payment_type' => 'gopay',
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => (int) $order->total_bayar,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'email'      => $order->email,
                'phone'      => $order->no_telepon ?? '',
            ],
            'item_details' => array_map(fn($item) => [
                'id'       => $item['id'],
                'name'     => $item['name'],
                'price'    => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
            ], $items),
        ];

        return CoreApi::charge($params);
    }

    /**
     * Check transaction status via Midtrans API
     */
    public function checkStatus(string $orderCode): object
    {
        return Transaction::status($orderCode);
    }

    /**
     * Legacy: Create Snap Token (kept for backward compatibility)
     */
    public function createSnapToken($order)
    {
        $items = is_string($order->items)
            ? json_decode($order->items, true)
            : $order->items;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => $order->total_bayar,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'email'      => $order->email,
                'phone'      => $order->no_telepon ?? '',
            ],
            'item_details' => array_map(fn($item) => [
                'id'       => $item['id'],
                'name'     => $item['name'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
            ], $items),
        ];

        return Snap::getSnapToken($params);
    }
}
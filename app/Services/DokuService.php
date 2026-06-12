<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * DokuService — Wrapper untuk Doku Core API (JOKUL)
 *
 * Docs: https://developers.doku.com/accept-payment/quick-start-guide/core-api
 */
class DokuService
{
    protected string $clientId;
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId  = config('services.doku.client_id');
        $this->secretKey = config('services.doku.secret_key');
        $this->baseUrl   = rtrim(config('services.doku.base_url', 'https://api-sandbox.doku.com'), '/');
    }

    /* ─────────────────────────────────────────────────────────────────────
     | BUAT PAYMENT
     | Mendukung channel: VIRTUAL_ACCOUNT_BRI, VIRTUAL_ACCOUNT_MANDIRI,
     |   VIRTUAL_ACCOUNT_BNI, VIRTUAL_ACCOUNT_PERMATA,
     |   VIRTUAL_ACCOUNT_BSS, QRIS, OVO
     ───────────────────────────────────────────────────────────────────── */
    public function createPayment(array $params): array
    {
        $endpoint = $this->resolveEndpoint($params['channel']);
        $body     = $this->buildRequestBody($params);

        $requestId  = $this->generateRequestId();
        $requestAt  = Carbon::now()->toIso8601String();
        $digest     = $this->generateDigest(json_encode($body));
        $signature  = $this->generateSignature($endpoint, $requestId, $requestAt, $digest);

        $headers = [
            'Client-Id'     => $this->clientId,
            'Request-Id'    => $requestId,
            'Request-Timestamp' => $requestAt,
            'Signature'     => 'HMACSHA256=' . $signature,
            'Content-Type'  => 'application/json',
        ];

        Log::info('[Doku] createPayment request', [
            'endpoint' => $endpoint,
            'channel'  => $params['channel'],
            'body'     => $body,
        ]);

        $response = Http::withHeaders($headers)
            ->timeout(30)
            ->post($this->baseUrl . $endpoint, $body);

        $result = $response->json();

        Log::info('[Doku] createPayment response', ['status' => $response->status(), 'body' => $result]);

        if (!$response->successful()) {
            throw new \RuntimeException('[Doku] HTTP Error ' . $response->status() . ': ' . json_encode($result));
        }

        return $result;
    }

    /* ─────────────────────────────────────────────────────────────────────
     | VERIFIKASI NOTIFY (Webhook / Callback)
     ───────────────────────────────────────────────────────────────────── */
    public function verifyNotify(string $requestId, string $requestTimestamp, string $signatureHeader, string $rawBody): bool
    {
        $digest          = $this->generateDigest($rawBody);
        $expectedSignature = 'HMACSHA256=' . $this->generateSignature(
            // Doku menggunakan path notify yang sama untuk semua channel
            '/api/notify',
            $requestId,
            $requestTimestamp,
            $digest
        );

        return hash_equals($expectedSignature, $signatureHeader);
    }

    /* ─────────────────────────────────────────────────────────────────────
     | PRIVATE HELPERS
     ───────────────────────────────────────────────────────────────────── */

    /**
     * Map nama channel ke endpoint Doku Core API.
     */
    private function resolveEndpoint(string $channel): string
    {
        return match (strtoupper($channel)) {
            'VIRTUAL_ACCOUNT_BRI'      => '/checkout/v1/payment/virtual-account-bri',
            'VIRTUAL_ACCOUNT_MANDIRI'  => '/checkout/v1/payment/virtual-account-ecollection',
            'VIRTUAL_ACCOUNT_BNI'      => '/checkout/v1/payment/virtual-account-bni',
            'VIRTUAL_ACCOUNT_PERMATA'  => '/checkout/v1/payment/virtual-account-permata',
            'VIRTUAL_ACCOUNT_BSS'      => '/checkout/v1/payment/virtual-account-bss',
            'QRIS'                     => '/checkout/v1/payment/qris',
            'OVO'                      => '/checkout/v1/payment/ovo',
            default                    => throw new \InvalidArgumentException("Channel tidak dikenali: {$channel}"),
        };
    }

    /**
     * Bangun request body sesuai spesifikasi Doku Core API.
     */
    private function buildRequestBody(array $params): array
    {
        $invoiceNumber = $params['invoice_number'];     // booking_code
        $amount        = (int) $params['amount'];       // total_harga dalam Rupiah
        $channel       = strtoupper($params['channel']);
        $customer      = $params['customer'];           // ['name', 'email', 'phone']
        $expiredAt     = Carbon::now()->addHours(24)->toIso8601String();
        $callbackUrl   = url(config('services.doku.callback_url'));
        $successUrl    = url(config('services.doku.success_url') . '/' . $invoiceNumber);

        $base = [
            'order' => [
                'invoice_number' => $invoiceNumber,
                'line_items'     => [[
                    'name'     => 'Tiket Saung Angklung Udjo',
                    'price'    => $amount,
                    'quantity' => 1,
                ]],
                'amount'         => $amount,
                'currency'       => 'IDR',
                'callback_url'   => $callbackUrl,
                'auto_redirect'  => false,
            ],
            'customer' => [
                'name'  => $customer['name'],
                'email' => $customer['email'],
                'phone' => $customer['phone'],
            ],
            'payment' => [
                'payment_due_date' => 24, // jam
            ],
        ];

        // ── Channel-specific params ──
        if ($channel === 'OVO') {
            // OVO butuh nomor HP customer sebagai ID OVO
            $base['payment']['ovo'] = [
                'phone_number' => preg_replace('/[^0-9]/', '', $customer['phone']),
            ];
        }

        return $base;
    }

    /**
     * Generate digest (SHA-256 hash dari body, lalu Base64).
     */
    private function generateDigest(string $body): string
    {
        return base64_encode(hash('sha256', $body, true));
    }

    /**
     * Generate HMAC-SHA256 signature.
     * Format: Client-Id:Request-Id:Request-Timestamp:Digest
     */
    private function generateSignature(string $endpoint, string $requestId, string $requestAt, string $digest): string
    {
        $componentToSign = implode(':', [
            $this->clientId,
            $requestId,
            $requestAt,
            $digest,
        ]);

        return base64_encode(hash_hmac('sha256', $componentToSign, $this->secretKey, true));
    }

    /**
     * Generate unique Request-Id (UUID v4).
     */
    private function generateRequestId(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /* ─────────────────────────────────────────────────────────────────────
     | HELPER PUBLIK — parse result dari response Doku
     ───────────────────────────────────────────────────────────────────── */

    /**
     * Ambil info pembayaran dari response Doku (VA number, QR string, dll).
     * Mengembalikan array ['type', 'value', 'expired_at'].
     */
    public static function parsePaymentInfo(array $dokuResponse, string $channel): array
    {
        $channel = strtoupper($channel);

        $vaNumber  = $dokuResponse['virtual_account_info']['virtual_account_number']
                  ?? $dokuResponse['virtual_account_number']
                  ?? null;

        $qrString  = $dokuResponse['qris']['qr_string']
                  ?? $dokuResponse['qr_string']
                  ?? null;

        $ovoDeepLink = $dokuResponse['payment']['ovo']['deeplink_url']
                    ?? $dokuResponse['ovo_deeplink_url']
                    ?? null;

        return match (true) {
            $vaNumber   !== null => ['type' => 'va',    'value' => $vaNumber,    'expired_at' => now()->addHours(24)->toIso8601String()],
            $qrString   !== null => ['type' => 'qris',  'value' => $qrString,    'expired_at' => now()->addHours(24)->toIso8601String()],
            $ovoDeepLink !== null => ['type' => 'ovo',  'value' => $ovoDeepLink, 'expired_at' => now()->addHours(24)->toIso8601String()],
            default              => ['type' => 'unknown', 'value' => null,        'expired_at' => null],
        };
    }
}

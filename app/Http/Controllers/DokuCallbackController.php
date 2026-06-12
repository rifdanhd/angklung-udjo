<?php

namespace App\Http\Controllers;

use App\Models\BookingTicket;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokuCallbackController extends Controller
{
    /* ─────────────────────────────────────────────────────────────────────
     | POST /booking/doku/callback
     | Dipanggil oleh server Doku (webhook) setelah pembayaran berhasil.
     | URL ini HARUS diexclude dari CSRF.
     ───────────────────────────────────────────────────────────────────── */
    public function notify(Request $request)
    {
        $rawBody   = $request->getContent();
        $payload   = json_decode($rawBody, true) ?? [];

        $requestId        = $request->header('Request-Id', '');
        $requestTimestamp = $request->header('Request-Timestamp', '');
        $signatureHeader  = $request->header('Signature', '');

        Log::info('[Doku] notify webhook received', [
            'headers'   => $request->headers->all(),
            'body'      => $payload,
        ]);

        // ── Verifikasi Signature ──
        $doku = new DokuService();
        if (!$doku->verifyNotify($requestId, $requestTimestamp, $signatureHeader, $rawBody)) {
            Log::warning('[Doku] notify — signature mismatch!', compact('signatureHeader'));
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // ── Parse invoice number dari payload ──
        $invoiceNumber = $payload['order']['invoice_number']
                      ?? $payload['transaction']['original_request_id']
                      ?? null;

        if (!$invoiceNumber) {
            Log::warning('[Doku] notify — invoice_number tidak ditemukan', $payload);
            return response()->json(['message' => 'invoice_number missing'], 422);
        }

        // ── Ambil booking ──
        $booking = BookingTicket::where('booking_code', $invoiceNumber)->first();

        if (!$booking) {
            Log::warning('[Doku] notify — booking tidak ditemukan', compact('invoiceNumber'));
            return response()->json(['message' => 'booking not found'], 404);
        }

        // ── Cek status Doku ──
        $dokuStatus = strtoupper($payload['transaction']['status'] ?? '');

        if ($dokuStatus === 'SUCCESS') {
            $booking->update(['status' => 'completed']);

            Log::info('[Doku] notify — booking COMPLETED', ['code' => $invoiceNumber]);
        } elseif (in_array($dokuStatus, ['FAILED', 'EXPIRED', 'CANCELED'])) {
            $booking->update(['status' => 'cancelled']);

            Log::info('[Doku] notify — booking CANCELLED', ['code' => $invoiceNumber, 'doku_status' => $dokuStatus]);
        }

        // Doku mengharapkan respons 200 OK
        return response()->json(['message' => 'ok']);
    }

    /* ─────────────────────────────────────────────────────────────────────
     | GET /booking/doku/success/{bookingCode}
     | Halaman yang ditampilkan kepada user setelah pembayaran.
     ───────────────────────────────────────────────────────────────────── */
    public function success(string $bookingCode)
    {
        $booking = BookingTicket::where('booking_code', $bookingCode)->firstOrFail();

        return view('tickets.doku-success', compact('booking'));
    }

    /* ─────────────────────────────────────────────────────────────────────
     | GET /booking/doku/status/{bookingCode}
     | Endpoint polling — frontend cek apakah status sudah berubah.
     ───────────────────────────────────────────────────────────────────── */
    public function status(string $bookingCode)
    {
        $booking = BookingTicket::where('booking_code', $bookingCode)
            ->select(['booking_code', 'status'])
            ->firstOrFail();

        return response()->json([
            'booking_code' => $booking->booking_code,
            'status'       => $booking->status,
        ]);
    }
}

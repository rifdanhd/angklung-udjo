<?php

namespace App\Services;

use App\Models\BookingTicket;
use App\Mail\EticketMail;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class EticketService
{
    /**
     * Generate e-ticket PDF and save to public storage.
     */
    public function generatePdf(BookingTicket $booking): string
    {
        Log::info('[EticketService] Generating PDF for: ' . $booking->booking_code);

        // Render blade view to pdf
        $pdf = Pdf::loadView('pdf.eticket', compact('booking'));
        
        $fileName = 'etickets/e-ticket-' . $booking->booking_code . '.pdf';
        
        // Simpan ke storage disk public
        Storage::disk('public')->put($fileName, $pdf->output());
        
        Log::info('[EticketService] PDF generated and stored at: ' . $fileName);

        return $fileName;
    }

    /**
     * Send email with e-ticket attachment.
     */
    public function sendEmail(BookingTicket $booking, string $pdfPath): bool
    {
        if (empty($booking->email)) {
            Log::warning('[EticketService] Booking email empty, skipping email send.');
            return false;
        }

        Log::info('[EticketService] Sending e-ticket email to: ' . $booking->email);

        try {
            Mail::to($booking->email)->send(new EticketMail($booking, $pdfPath));
            Log::info('[EticketService] E-ticket email sent successfully.');
            return true;
        } catch (\Exception $e) {
            Log::error('[EticketService] Failed to send email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send WhatsApp notification with PDF link.
     */
    public function sendWhatsApp(BookingTicket $booking, string $pdfPath): bool
    {
        if (empty($booking->no_hp)) {
            Log::warning('[EticketService] Booking phone number empty, skipping WA notification.');
            return false;
        }

        Log::info('[EticketService] Preparing WhatsApp notification for: ' . $booking->no_hp);

        // Buat URL absolute ke PDF agar bisa diakses oleh Fonnte / didownload oleh user
        $pdfUrl = asset('storage/' . $pdfPath);

        // Siapkan pesan WA
        $message = "*E-Ticket Saung Angklung Udjo*\n\n"
                 . "Halo *" . $booking->nama . "*,\n"
                 . "Pembayaran Anda telah sukses diverifikasi! Pemesanan tiket Anda kini berstatus *Lunas*.\n\n"
                 . "*Detail Reservasi:*\n"
                 . "• Kode Booking: *" . $booking->booking_code . "*\n"
                 . "• Tanggal Kunjungan: " . \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('l, d F Y') . "\n"
                 . "• Sesi/Jam: " . $booking->session_time . "\n"
                 . "• Status: Lunas\n\n"
                 . "E-Ticket PDF Anda telah dikirimkan ke email: " . $booking->email . ".\n\n"
                 . "Anda juga dapat langsung mengunduh e-ticket Anda melalui tautan di bawah ini:\n"
                 . $pdfUrl . "\n\n"
                 . "Sampai jumpa di pertunjukan Saung Angklung Udjo!";

        $fonnte = new FonnteService();
        $response = $fonnte->sendMessage($booking->no_hp, $message, $pdfUrl);

        if (isset($response['status']) && $response['status']) {
            Log::info('[EticketService] WhatsApp notification sent successfully.');
            return true;
        } else {
            Log::error('[EticketService] WhatsApp notification failed: ' . json_encode($response));
            return false;
        }
    }

    /**
     * Orchestrates the entire flow: PDF Generation -> Save path to DB -> Send Email -> Send WA.
     */
    public function process(BookingTicket $booking): void
    {
        try {
            // 1. Generate PDF
            $pdfPath = $this->generatePdf($booking);
            
            // 2. Simpan path e-ticket ke DB
            $booking->update([
                'eticket_path' => $pdfPath
            ]);

            // 3. Kirim Email (independent try-catch)
            try {
                $this->sendEmail($booking, $pdfPath);
            } catch (\Exception $e) {
                Log::error('[EticketService] Isolated error sending email: ' . $e->getMessage());
            }

            // 4. Kirim WA via Fonnte (independent try-catch)
            try {
                $this->sendWhatsApp($booking, $pdfPath);
            } catch (\Exception $e) {
                Log::error('[EticketService] Isolated error sending WA: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            Log::error('[EticketService] Main process failed: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Mail;

use App\Models\BookingTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EticketMail extends Mailable
{
    use Queueable, SerializesModels;

    public BookingTicket $booking;
    public ?string $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(BookingTicket $booking, ?string $pdfPath = null)
    {
        $this->booking = $booking;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket Saung Angklung Udjo - ' . $this->booking->booking_code,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.eticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->pdfPath && Storage::disk('public')->exists($this->pdfPath)) {
            return [
                Attachment::fromPath(Storage::disk('public')->path($this->pdfPath))
                    ->as('E-Ticket-' . $this->booking->booking_code . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}

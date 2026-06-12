<?php

namespace App\Jobs;

use App\Models\BookingTicket;
use App\Services\EticketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEticketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BookingTicket $booking;

    /**
     * Create a new job instance.
     */
    public function __construct(BookingTicket $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('[SendEticketJob] Starting e-ticket generation & delivery for booking: ' . $this->booking->booking_code);

        try {
            $eticketService = new EticketService();
            $eticketService->process($this->booking);
        } catch (\Exception $e) {
            Log::error('[SendEticketJob] Error executing job: ' . $e->getMessage());
        }
    }
}

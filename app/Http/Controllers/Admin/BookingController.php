<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('show')->latest();

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('booking_code', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        // Update available seats
        $booking->show->updateAvailableSeats();

        return back()->with('success', 'Booking berhasil dikonfirmasi!');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        // Update available seats
        $booking->show->updateAvailableSeats();

        return back()->with('success', 'Booking berhasil dibatalkan!');
    }
}

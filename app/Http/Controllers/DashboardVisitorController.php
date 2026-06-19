<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardVisitorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
                       ->latest()
                       ->get();

        $totalBookings    = $orders->count();
        $paidBookings     = $orders->where('status', 'paid')->count();
        $upcomingBookings = $orders->where('status', 'paid')
                                   ->where('tanggal_kunjungan', '>=', now())
                                   ->count();

        return view('dashboard', [
            'bookings'         => $orders,
            'totalBookings'    => $totalBookings,
            'paidBookings'     => $paidBookings,
            'upcomingBookings' => $upcomingBookings,
        ]);
    }
}
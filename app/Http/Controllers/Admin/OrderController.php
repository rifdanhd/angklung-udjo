<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pemesan', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('order_code', 'like', '%' . $request->search . '%');
            });
        }

        $stats = [
            'total'     => Order::count(),
            'paid'      => Order::where('status', 'paid')->count(),
            'pending'   => Order::where('status', 'pending')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue'   => Order::where('status', 'paid')->sum('total_bayar'),
        ];

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,cancelled,expired']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status order berhasil diupdate!');
    }
}

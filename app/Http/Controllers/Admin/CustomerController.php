<?php
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/CustomerController.php
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
 
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('reservations')
            ->with('reservations')
            ->orderByDesc('last_visit_at');
 
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }
 
        $customers = $query->paginate(25)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }
 
    public function show(Customer $customer)
    {
        $customer->load(['reservations.items.ticketType', 'reservations.showSession']);
        return view('admin.customers.show', compact('customer'));
    }
}
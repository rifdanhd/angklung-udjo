<
// ─────────────────────────────────────────────────────────────
//  FILE: app/Http/Controllers/Admin/PromoController.php
//  (Update dari yang sudah ada)
// ─────────────────────────────────────────────────────────────
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = PromoCode::withCount('reservations')->latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.form', ['promo' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'             => 'required|string|unique:promo_codes,code|max:50',
            'label'            => 'required|string|max:255',
            'emoji'            => 'nullable|string|max:10',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'periode_start'    => 'nullable|date',
            'periode_end'      => 'nullable|date|after_or_equal:periode_start',
            'whatsapp_closing' => 'nullable|string',
            'max_usage'        => 'nullable|integer|min:1',
            'is_active'        => 'boolean',
        ]);
        $data['code']      = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        PromoCode::create($data);
        return redirect()->route('admin.promo.index')->with('success', 'Kode promo berhasil dibuat.');
    }

    public function edit(PromoCode $promo)
    {
        return view('admin.promo.form', compact('promo'));
    }

    public function update(Request $request, PromoCode $promo)
    {
        $data = $request->validate([
            'label'            => 'required|string|max:255',
            'emoji'            => 'nullable|string|max:10',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'periode_start'    => 'nullable|date',
            'periode_end'      => 'nullable|date|after_or_equal:periode_start',
            'whatsapp_closing' => 'nullable|string',
            'max_usage'        => 'nullable|integer|min:1',
            'is_active'        => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $promo->update($data);
        return redirect()->route('admin.promo.index')->with('success', 'Kode promo berhasil diperbarui.');
    }

    public function destroy(PromoCode $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promo.index')->with('success', 'Kode promo dihapus.');
    }

    // Klaim promo dari booking lama (redirect ke reservasi)
    public function claims()
    {
        $reservations = Reservation::with(['customer', 'promoCode', 'showSession'])
            ->whereNotNull('promo_code_used')
            ->latest()
            ->paginate(20);
        return view('admin.promo.claims', compact('reservations'));
    }
}

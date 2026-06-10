<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\PromoClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoAdminController extends Controller
{
    /* ────────────────────────────────────────────
       INDEX — Daftar semua promo
    ──────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = Promo::withCount('claims');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            match($request->status) {
                'active'   => $query->where('is_active', true)->whereDate('end_date', '>=', now()),
                'inactive' => $query->where('is_active', false),
                'expired'  => $query->whereDate('end_date', '<', now()),
                default    => null,
            };
        }

        $promos = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'   => Promo::count(),
            'active'  => Promo::where('is_active', true)->whereDate('end_date', '>=', now())->count(),
            'expired' => Promo::whereDate('end_date', '<', now())->count(),
            'claims'  => PromoClaim::count(),
        ];

        return view('admin.promos.index', compact('promos', 'stats'));
    }

    /* ────────────────────────────────────────────
       CREATE / STORE
    ──────────────────────────────────────────── */
    public function create()
    {
        return view('admin.promos.form', ['promo' => new Promo()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }

        if (empty($data['code']) && in_array($data['type'], ['voucher'])) {
            $data['code'] = strtoupper(Str::random(8));
        }

        // ✅ FIX: Simpan null jika tidak ada hari dipilih (= semua hari)
        $data['allowed_days'] = !empty($data['allowed_days']) ? $data['allowed_days'] : null;

        Promo::create($data);

        return redirect()->route('admin.promos.index')
                         ->with('success', 'Promo berhasil dibuat!');
    }

    /* ────────────────────────────────────────────
       EDIT / UPDATE
    ──────────────────────────────────────────── */
    public function edit(Promo $promo)
    {
        return view('admin.promos.form', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $data = $request->validate($this->rules($promo->id));

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('promos', 'public');
        }

        // ✅ FIX: Simpan null jika tidak ada hari dipilih (= semua hari)
        $data['allowed_days'] = !empty($data['allowed_days']) ? $data['allowed_days'] : null;

        $promo->update($data);

        return redirect()->route('admin.promos.index')
                         ->with('success', 'Promo berhasil diperbarui!');
    }

    /* ────────────────────────────────────────────
       TOGGLE ACTIVE
    ──────────────────────────────────────────── */
    public function toggleActive(Promo $promo)
    {
        $promo->update(['is_active' => !$promo->is_active]);
        return back()->with('success', 'Status promo diperbarui.');
    }

    /* ────────────────────────────────────────────
       DELETE
    ──────────────────────────────────────────── */
    public function destroy(Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo dihapus.');
    }

    /* ────────────────────────────────────────────
       CLAIMS — Daftar klaim promo tertentu
    ──────────────────────────────────────────── */
    public function claims(Request $request, Promo $promo)
    {
        $query = $promo->claims();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('claim_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $claims = $query->latest()->paginate(15)->withQueryString();

        return view('admin.promos.claims', compact('promo', 'claims'));
    }

    /* ────────────────────────────────────────────
       KLAIM — Semua klaim (semua promo)
    ──────────────────────────────────────────── */
    public function allClaims(Request $request)
    {
        $query = PromoClaim::with('promo');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('claim_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('promo_id')) {
            $query->where('promo_id', $request->promo_id);
        }

        $claims = $query->latest()->paginate(15)->withQueryString();
        $promos = Promo::orderBy('name')->get();

        $stats = [
            'total'    => PromoClaim::count(),
            'pending'  => PromoClaim::where('status', 'pending')->count(),
            'approved' => PromoClaim::where('status', 'approved')->count(),
            'used'     => PromoClaim::where('status', 'used')->count(),
        ];

        return view('admin.promos.all-claims', compact('claims', 'promos', 'stats'));
    }

    /* ────────────────────────────────────────────
       UPDATE STATUS KLAIM
    ──────────────────────────────────────────── */
    public function updateClaimStatus(Request $request, PromoClaim $claim)
    {
        $request->validate(['status' => 'required|in:pending,approved,used,rejected']);

        $claim->update([
            'status'  => $request->status,
            'used_at' => $request->status === 'used' ? now() : $claim->used_at,
        ]);

        if ($request->status === 'used') {
            $claim->promo->increment('used_count');
        }

        return back()->with('success', 'Status klaim diperbarui.');
    }

    /* ────────────────────────────────────────────
       VALIDATION RULES
    ──────────────────────────────────────────── */
    private function rules(?int $ignoreId = null): array
    {
        return [
            'name'            => 'required|string|max:255',
            'code'            => 'nullable|string|unique:promos,code,' . $ignoreId,
            'type'            => 'required|in:voucher,b1g1,early_bird,bundling,other',
            'description'     => 'nullable|string',
            'discount_type'   => 'required|in:percent,fixed',
            'discount_value'  => 'required|numeric|min:0',
            'min_purchase'    => 'nullable|numeric|min:0',
            'max_discount'    => 'nullable|numeric|min:0',
            'quota'           => 'nullable|integer|min:1',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'is_active'       => 'boolean',
            'banner_image'    => 'nullable|image|max:2048',
            'applicable_to'   => 'nullable|array',
               'specific_dates'  => 'nullable|array',
            // ✅ FIX: Validasi hari yang diizinkan
            // Array angka 0–6 (0=Minggu ... 6=Sabtu). Kosong = semua hari.
            'allowed_days'    => 'nullable|array',
            'allowed_days.*'  => 'integer|between:0,6',
            'allowed_time_start' => 'nullable|string',
            'allowed_time_end'   => 'nullable|string',
        ];
    }
}
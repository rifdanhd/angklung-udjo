<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partnership;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function index(Request $request)
    {
        $query = Partnership::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_travel', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pic', 'like', '%' . $request->search . '%')
                  ->orWhere('no_wa', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status_kunjungan) {
            $query->where('status_kunjungan', $request->status_kunjungan);
        }

        $partnerships = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.partnerships.index', compact('partnerships'));
    }

    public function destroy(Partnership $partnership)
    {
        $partnership->delete();
        return redirect()->route('admin.partnerships.index')->with('success', 'Data kemitraan berhasil dihapus!');
    }
}

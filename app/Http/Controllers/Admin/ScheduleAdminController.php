<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Filter untuk jadwal mendatang atau lampau
        if ($request->filter === 'past') {
            $query->where('date', '<', now()->toDateString())->orderBy('date', 'desc');
        } else {
            $query->where('date', '>=', now()->toDateString())->orderBy('date', 'asc');
        }

        $schedules = $query->paginate(15);

        $defaultCapacity = (int) SiteSettings::get('default_capacity', 20);

        return view('admin.schedules.index', compact('schedules', 'defaultCapacity'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'session_id'   => 'required|string',
            'session_time' => 'required|string|max:60',
            'capacity'     => 'required|integer|min:1',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate   = $request->end_date ? Carbon::parse($request->end_date) : $startDate;

        // Loop untuk input rentang tanggal (bulk save)
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            Schedule::updateOrCreate(
                [
                    'date'       => $current->toDateString(),
                    'session_id' => $request->session_id,
                ],
                [
                    'session_time' => $request->session_time,
                    'capacity'     => $request->capacity,
                ]
            );
            $current->addDay();
        }

        return back()->with('success', 'Jadwal khusus berhasil disimpan!');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'session_time' => 'required|string|max:60',
            'capacity'     => 'required|integer|min:1',
        ]);

        $schedule->update([
            'session_time' => $request->session_time,
            'capacity'     => $request->capacity,
        ]);

        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal khusus dihapus, kembali ke pengaturan default.');
    }

    public function clearPast()
    {
        Schedule::where('date', '<', now()->toDateString())->delete();
        return back()->with('success', 'Semua jadwal khusus yang sudah lampau berhasil dibersihkan!');
    }

    public function updateDefaultCapacity(Request $request)
    {
        $request->validate([
            'default_capacity' => 'required|integer|min:1',
        ]);

        SiteSettings::set(['default_capacity' => (int) $request->default_capacity]);

        return back()->with('success', 'Kapasitas default sistem berhasil diperbarui!');
    }
}
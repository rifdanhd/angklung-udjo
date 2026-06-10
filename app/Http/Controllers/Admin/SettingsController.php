<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSettings::all();
        $user = auth()->user();

        return view('admin.settings.index', compact('settings', 'user'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name'    => 'required|string|max:120',
            'site_tagline' => 'nullable|string|max:160',
        ]);

        SiteSettings::set($validated);

        return back()->with('success', 'Pengaturan umum berhasil disimpan.');
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'contact_phone'   => 'required|string|max:30',
            'whatsapp_number' => 'required|string|max:20|regex:/^[0-9]+$/',
            'contact_email'   => 'nullable|email|max:120',
            'address'         => 'required|string|max:500',
            'opening_hours'   => 'nullable|string|max:80',
        ]);

        SiteSettings::set($validated);

        return back()->with('success', 'Informasi kontak berhasil disimpan.');
    }

    public function updateOperational(Request $request)
    {
        $validated = $request->validate([
            'default_capacity' => 'required|integer|min:1|max:9999',
            'booking_enabled'  => 'nullable|boolean',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        SiteSettings::set([
            'default_capacity' => (int) $validated['default_capacity'],
            'booking_enabled'  => $request->boolean('booking_enabled'),
            'maintenance_mode' => $request->boolean('maintenance_mode'),
        ]);

        return back()->with('success', 'Pengaturan operasional berhasil disimpan.');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil akun Anda berhasil diperbarui.');
    }
}

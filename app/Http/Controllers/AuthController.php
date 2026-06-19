<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http; 

class AuthController extends Controller
{
    public function showVisitorLogin()
    {
        if (Auth::check()) return redirect('/dashboard');
        return view('auth.visitor-login');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback()
    {
        $g     = Socialite::driver('google')->stateless()->user();
        $email = $g->getEmail();
        if (!$email) return redirect('/visitor/login')->with('error', 'Email Google tidak tersedia');

        $user = User::where('google_id', $g->getId())->orWhere('email', $email)->first();
        if ($user) {
            $user->update(['google_id' => $g->getId(), 'name' => $g->getName() ?? $user->name, 'avatar' => $g->getAvatar()]);
        } else {
            $user = User::create(['google_id' => $g->getId(), 'name' => $g->getName() ?? 'User Google', 'email' => $email, 'avatar' => $g->getAvatar(), 'role' => 'visitor']);
        }
        Auth::login($user, true);
        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    // ─── WhatsApp OTP ─────────────────────────────────────────

  public function sendOtp(Request $request)
{
    $phone = preg_replace('/[^0-9]/', '', $request->input('phone', ''));

    if (strlen($phone) < 10) {
        return response()->json(['message' => 'Nomor WA tidak valid'], 422);
    }

    $wa  = '62' . ltrim($phone, '0');
    $otp = rand(100000, 999999);
    Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));

    \Log::info('OTP sent', ['phone' => $phone, 'otp' => $otp]);

    $message = "Kode OTP Saung Angklung Udjo kamu: *$otp*\nBerlaku 5 menit. Jangan bagikan ke siapapun.";

    $res = Http::withHeaders([
        'Authorization' => env('FONNTE_TOKEN'),
    ])->post('https://api.fonnte.com/send', [
        'target'  => $wa,
        'message' => $message,
    ]);

    if (!$res->successful()) {
        return response()->json(['message' => 'Gagal kirim OTP, coba lagi'], 500);
    }

    return response()->json(['message' => 'OTP terkirim']);
}

public function verifyOtp(Request $request)
{
    try {
        $phone = preg_replace('/[^0-9]/', '', $request->input('phone', ''));
        $otp   = $request->input('otp');
        $name  = $request->input('name');

        $cached = Cache::get('otp_' . $phone);

        \Log::info('OTP check', ['phone' => $phone, 'cached' => $cached, 'input' => $otp]);

        if (!$cached || (string)$cached !== (string)$otp) {
            return response()->json(['message' => 'OTP tidak valid atau kadaluarsa'], 422);
        }

        Cache::forget('otp_' . $phone);

        $wa   = '62' . ltrim($phone, '0');
        $user = User::where('phone', $phone)->orWhere('phone', $wa)->first();

        if (!$user) {
    $user = User::create([
        'name'  => $name ?? 'Pengunjung',
        'phone' => $phone,
        'email' => $phone . '@wa.local', // ← dummy email agar tidak null
        'role'  => 'visitor',
    ]);
}

        Auth::login($user, true);
        return response()->json(['message' => 'Berhasil', 'redirect' => '/dashboard']);

    } catch (\Exception $e) {
        \Log::error('verifyOtp error: ' . $e->getMessage());
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    // ─── Email Login & Register ────────────────────────────────

    public function loginEmail(Request $request)
    {
        $creds = $request->only('email', 'password');
        if (!Auth::attempt($creds, true)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }
        return response()->json(['redirect' => '/dashboard']);
    }

    public function registerEmail(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email sudah terdaftar'], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'visitor',
        ]);

        Auth::login($user, true);
        return response()->json(['redirect' => '/dashboard']);
    }
}
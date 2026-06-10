<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;        // ← tambah
use App\Models\BookingTicket;               // ← tambah

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Set locale dari session jika ada
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        // ← tambah: share pending count ke semua view admin
        View::composer('admin.layouts.app', function ($view) {
            try {
                $view->with('navPendingCount', BookingTicket::where('status', 'pending')->count());
            } catch (\Exception $e) {
                $view->with('navPendingCount', 0);
            }
        });
    }
}
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TicketB1G1Controller;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\Admin\PromoAdminController;
use App\Http\Controllers\ChatAIController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShowController as AdminShowController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\PromoKlaimController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\BookingTicketController;
use App\Http\Controllers\Admin\BookingTicketController as AdminBookingTicketController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ScheduleAdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PartnershipController as AdminPartnershipController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\DokuCallbackController;

Route::get('/booking/online-status', [BookingTicketController::class, 'onlineStatus']);
Route::post('/booking/redirect-majoo', [BookingTicketController::class, 'redirectMajoo']);

// ── DOKU ─────────────────────────────────────────────────────────────────
// Inisiasi pembayaran (dipanggil dari JS setelah booking dibuat)
Route::post('/booking/doku/pay',         [BookingTicketController::class, 'submitDoku'])->middleware(['throttle:10,1'])->name('booking.doku.pay');
// Webhook dari server Doku (TANPA CSRF — lihat bootstrap/app.php)
Route::post('/booking/doku/callback',    [DokuCallbackController::class, 'notify'])->name('booking.doku.callback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
// Halaman sukses (redirect setelah Doku selesai)
Route::get('/booking/doku/success/{bookingCode}', [DokuCallbackController::class, 'success'])->name('booking.doku.success');
// API polling status untuk JS countdown
Route::get('/booking/doku/status/{bookingCode}',  [DokuCallbackController::class, 'status'])->name('booking.doku.status');



// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap.xml/refresh', [SitemapController::class, 'refresh'])->name('sitemap.refresh');

Route::get('/partnership', [PartnershipController::class, 'index'])->name('partnership.index');
Route::post('/partnership', [PartnershipController::class, 'store'])->middleware(['honeypot', 'throttle:5,1'])->name('partnership.store');

Route::get('/tickets/buy', function () {
    $products = \App\Models\Product::all();
    $promos = \App\Models\Promo::where('is_active', true)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get()
        ->filter(function ($promo) {
            $applicable = $promo->applicable_to ?? [];
            return !in_array('Sembunyikan dari Halaman', $applicable);
        });
    return view('tickets.buy', compact('products', 'promos'));
})->name('tickets.buy');
Route::get('/booking/seats', [BookingTicketController::class, 'getSeats']);

// AI Chat
Route::post('/chat-ai', [ChatAIController::class, 'reply']);

// ============================================================
// FRONTEND ROUTES — letakkan di luar grup admin
// ============================================================
Route::get('/book-now',  [BookingTicketController::class, 'index'])->name('booking.ticket.index');
Route::post('/book-now', [BookingTicketController::class, 'submit'])->middleware(['honeypot', 'throttle:5,1'])->name('booking.ticket.submit');
Route::post('/booking/validate-promo', [BookingTicketController::class, 'validatePromo'])->middleware(['throttle:20,1'])->name('booking.validate-promo');
Route::post('/booking/upload-bukti', [BookingTicketController::class, 'uploadBukti'])->middleware(['throttle:3,1'])->name('booking.upload-bukti');

Route::get('/promo-longweekendselesai', [PromoController::class, 'index'])->name('promo.index');
Route::post('/promo-longweekendselesai', [PromoController::class, 'submit'])->middleware(['honeypot', 'throttle:5,1'])->name('promo.submit');

Route::get('/admin/promo-klaim/export-excel', [PromoKlaimController::class, 'exportExcel'])->name('admin.promo.exportExcel');
// Tiket Buy 1 Get 1

Route::controller(TicketB1G1Controller::class)->group(function () {
    Route::get('/tiket-b1g1', 'index')->name('tiket.b1g1.index');
    Route::post('/tiket-b1g1', 'store')->middleware(['honeypot', 'throttle:5,1'])->name('tiket.b1g1.store');
    Route::get('/tiket-b1g1/bayar/{orderCode}', 'payment')->name('tiket.b1g1.payment');
    Route::post('/tiket-b1g1/konfirmasi/{orderCode}', 'confirm')->middleware(['throttle:3,1'])->name('tiket.b1g1.confirm');
    Route::get('/tiket-b1g1/sukses/{orderCode}', 'success')->name('tiket.b1g1.success');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Pertunjukan & Booking
Route::controller(ShowController::class)->group(function () {
    Route::get('/pertunjukan', 'index')->name('shows.index');
    Route::get('/pertunjukan/{show}', 'show')->name('shows.show');
});

Route::controller(BookingController::class)->group(function () {
    Route::get('/pertunjukan/{show}/booking', 'create')->name('bookings.create');
    Route::post('/pertunjukan/{show}/booking', 'store')->name('bookings.store');
    Route::get('/booking/sukses/{bookingCode}', 'success')->name('bookings.success');
});

// Produk & Artikel
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/testimoni', [TestimonialController::class, 'store'])->middleware(['honeypot', 'throttle:5,1'])->name('testimonials.store');

// Static Pages
Route::get('/kebijakan-privasi', function () { return view('privacy-policy'); })->name('privacy-policy');
Route::get('/sejarah-angklung', function () { return view('heritage.angklung-history'); })->name('heritage.angklung');
Route::get('/experience/performances', function () { return view('experience.performances'); })->name('experience.performances');
Route::get('/heritage/angklung-unit', function () { return view('heritage.angklung-unit'); })->name('heritage.unit');
Route::get('/heritage/arumba', function () { return view('heritage.arumba'); })->name('heritage.arumba');
Route::get('/experience/souvenir-shop', function () { return view('experience.souvenir'); })->name('experience.souvenir');
Route::get('/experience/academy', function () { return view('experience.academy'); })->name('experience.academy');
Route::get('/heritage/cara-membuat-memainkan', function () { return view('heritage.angklung-craftsmanship'); })->name('heritage.craftsmanship');
Route::get('/experience/banguet', function () { return view('experience.banquet'); })->name('experience.banguet');
Route::get('/heritage/angklung-definition', function () { return view('heritage.angklung-definition'); })->name('heritage.angklung-definition');
Route::get('/heritage/history', function () { return view('heritage.history'); })->name('heritage.history');
Route::get('/heritage/vision-mission', function () { return view('heritage.vision-mission'); })->name('heritage.vision-mission');
Route::get('/heritage/achievements', function () { return view('heritage.achievements'); })->name('heritage.achievements');
Route::get('/heritage/jenis-angklung', function () { return view('heritage.jenis-angklung'); })->name('heritage.jenis-angklung');
Route::get('/Visitus/hotels', function () { return view('Visitus.hotel'); })->name('Visitus.hotel');
Route::get('/heritage/venue', function () { return view('heritage.venue'); })->name('heritage.venue');
Route::get('/Visitus/destinasi', function () { return view('Visitus.destinasi'); })->name('Visitus.destinasi');
Route::get('/experience/performancesoutdoor', function () { return view('experience.performancesoutdoor'); })->name('experience.performancesoutdoor');
Route::get('/Ramadhan', function () { return view('Ramadhan'); })->name('Ramadhan');

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

 // Route Manajemen Jadwal
    Route::get('/schedules', [ScheduleAdminController::class, 'index'])->name('schedules.index');
    Route::post('/schedules', [ScheduleAdminController::class, 'store'])->name('schedules.store');
    Route::put('/schedules/{schedule}', [ScheduleAdminController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [ScheduleAdminController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/clear-past', [ScheduleAdminController::class, 'clearPast'])->name('schedules.clear-past');
    Route::post('/schedules/update-default-capacity', [ScheduleAdminController::class, 'updateDefaultCapacity'])->name('schedules.update-default-capacity');

Route::get('analytics/clear-cache', [\App\Http\Controllers\Admin\AnalyticsController::class, 'clearCache'])
     ->name('analytics.clear-cache');
// ✅ BENAR
Route::get('analytics/realtime', [App\Http\Controllers\Admin\AnalyticsController::class, 'realtime'])->name('analytics.realtime');
Route::get('analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
// ── HISTORY SLIDES ────────────────────────────────
Route::resource('history-slides', \App\Http\Controllers\Admin\HistorySlideController::class);
Route::post('history-slides/order', [\App\Http\Controllers\Admin\HistorySlideController::class, 'updateOrder'])->name('history-slides.order');
Route::post('history-slides/{historySlide}/toggle', [\App\Http\Controllers\Admin\HistorySlideController::class, 'toggleActive'])->name('history-slides.toggle');

Route::post('events/reorder', [EventController::class, 'reorder'])->name('events.reorder');
Route::resource('events', EventController::class);

  Route::prefix('promos')->name('promos.')->group(function () {

    Route::get('/', [PromoAdminController::class, 'index'])
        ->name('index');

    Route::get('/create', [PromoAdminController::class, 'create'])
        ->name('create');

    Route::get('/all-claims', [PromoAdminController::class, 'allClaims'])
        ->name('all-claims');

    Route::post('/', [PromoAdminController::class, 'store'])
        ->name('store');

    // Dynamic routes setelah static
    Route::get('/{promo}/edit', [PromoAdminController::class, 'edit'])
        ->name('edit');

    Route::put('/{promo}', [PromoAdminController::class, 'update'])
        ->name('update');

    Route::patch('/{promo}/toggle', [PromoAdminController::class, 'toggleActive'])
        ->name('toggle');

    Route::delete('/{promo}', [PromoAdminController::class, 'destroy'])
        ->name('destroy');

    Route::get('/{promo}/claims', [PromoAdminController::class, 'claims'])
        ->name('claims');

    Route::patch('/claims/{claim}/status', [PromoAdminController::class, 'updateClaimStatus'])
        ->name('claim.status');
});

    // ── BOOKING TICKETS ───────────────────────────────
    Route::get('booking-tickets/online',          [AdminBookingTicketController::class, 'onlineBooking'])->name('booking.online');
    Route::post('booking-tickets/online',         [AdminBookingTicketController::class, 'createOnlineCounter'])->name('booking.online.store');
    Route::put('booking-tickets/online/{id}',     [AdminBookingTicketController::class, 'updateOnlineCapacity'])->name('booking.online.update');
    Route::post('booking-tickets/online/{id}/toggle', [AdminBookingTicketController::class, 'toggleOnlineClosed'])->name('booking.online.toggle');

    Route::get('booking-tickets/export-pdf',   [AdminBookingTicketController::class, 'exportPdf'])->name('booking.ticket.exportPdf');
    Route::delete('booking-tickets/bulk-destroy', [AdminBookingTicketController::class, 'bulkDestroy'])->name('booking.ticket.bulkDestroy');
    Route::post('booking-tickets/bulk-status', [AdminBookingTicketController::class, 'bulkUpdateStatus'])->name('booking.ticket.bulkUpdateStatus');
    Route::post('booking-tickets',             [AdminBookingTicketController::class, 'store'])->name('booking.ticket.store');
    Route::get('booking-tickets',              [AdminBookingTicketController::class, 'index'])->name('booking.ticket.index');
    Route::post('booking-tickets/{bookingTicket}/status', [AdminBookingTicketController::class, 'updateStatus'])->name('booking.ticket.updateStatus');
    Route::delete('booking-tickets/{bookingTicket}', [AdminBookingTicketController::class, 'destroy'])->name('booking.ticket.destroy');

    // ── DASHBOARD ─────────────────────────────────────
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ── RESOURCES ─────────────────────────────────────
    Route::resource('shows', AdminShowController::class);
    Route::resource('gallery', AdminGalleryController::class);
    Route::resource('articles', AdminArticleController::class);
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/delete-image', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::resource('partnerships', AdminPartnershipController::class)->only(['index', 'destroy']);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::resource('users', AdminUserController::class);

    // ── PENGATURAN ────────────────────────────────────
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::put('settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact');
    Route::put('settings/operational', [SettingsController::class, 'updateOperational'])->name('settings.operational');
    Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');

    // ── HERO CAROUSEL ─────────────────────────────────
    Route::prefix('hero')->name('hero.')->group(function () {
        Route::get('/',                    [HeroSlideController::class, 'index'])->name('index');
        Route::post('/',                   [HeroSlideController::class, 'store'])->name('store');
        Route::post('/{heroSlide}/toggle', [HeroSlideController::class, 'toggleActive'])->name('toggle');
        Route::post('/order',              [HeroSlideController::class, 'updateOrder'])->name('order');
        Route::delete('/{heroSlide}',      [HeroSlideController::class, 'destroy'])->name('destroy');
    });

    // ── BOOKINGS ──────────────────────────────────────
    Route::controller(AdminBookingController::class)->group(function () {
        Route::get('bookings',                     'index')->name('bookings.index');
        Route::patch('bookings/{booking}/confirm', 'confirm')->name('bookings.confirm');
        Route::patch('bookings/{booking}/cancel',  'cancel')->name('bookings.cancel');
    });

    // ── TESTIMONIALS ──────────────────────────────────
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::patch('testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');



    //PROMO KLAIM RAMADHAN
   Route::get('promo-klaim/export-pdf',              [PromoKlaimController::class, 'exportPdf'])->name('promo.exportPdf');
    Route::get('promo-klaim',                         [PromoKlaimController::class, 'index'])->name('promo.index');
    Route::delete('promo-klaim/{promoKlaim}',         [PromoKlaimController::class, 'destroy'])->name('promo.destroy');
    Route::post('promo-klaim/{promoKlaim}/status',    [PromoKlaimController::class, 'updateStatus'])->name('promo.updateStatus');

}); // ← satu-satunya penutup admin group
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
| Sitemap dinamis (XML) ditangani oleh SitemapController.
| Route sudah didefinisikan di awal file ini.
*/

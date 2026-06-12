<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingTicket;
use App\Models\Schedule;
use App\Models\Testimonial;
use App\Support\SiteSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = in_array($request->get('period'), ['harian', 'mingguan', 'bulanan'], true)
            ? $request->get('period')
            : 'harian';

        try {
            $anchor = $request->filled('date')
                ? Carbon::parse($request->get('date'))
                : Carbon::today();
        } catch (\Throwable) {
            $anchor = Carbon::today();
        }

        [$dateFrom, $dateTo, $periodLabel] = $this->resolvePeriodRange($period, $anchor);

        $rangeQuery = BookingTicket::query()
            ->whereBetween('tanggal_kunjungan', [$dateFrom->copy()->startOfDay(), $dateTo->copy()->endOfDay()]);

        $transactions     = (clone $rangeQuery)->count();
        $pendingInRange   = (clone $rangeQuery)->where('status', 'pending');
        $paidInRange      = (clone $rangeQuery)->whereIn('status', ['confirmed', 'completed']);

        $totalRevenue     = (clone $paidInRange)->sum('total_harga');
        $unpaidRevenue    = (clone $pendingInRange)->sum('total_harga');
        $paidRevenue      = $totalRevenue;
        $ticketsSold      = (clone $rangeQuery)->get()->sum(fn ($b) => $b->totalTickets());
        $avgPerTransaction = $transactions > 0 ? (int) round($totalRevenue / $transactions) : 0;
        $avgTicketsPerTx   = $transactions > 0 ? round($ticketsSold / $transactions, 1) : 0;

        // ── Ringkasan global (sidebar stat tetap berguna) ──
        $bookingTotal     = BookingTicket::count();
        $bookingPending   = BookingTicket::where('status', 'pending')->count();
        $bookingReserved  = BookingTicket::where('status', 'confirmed')->count();
        $bookingLunas     = BookingTicket::where('status', 'completed')->count();
        $bookingRevenue   = BookingTicket::whereNotIn('status', ['cancelled'])->sum('total_harga');

        $pendingTestimonialsCount = Testimonial::where('is_approved', false)->count();
        $pendingTestimonials      = Testimonial::where('is_approved', false)->latest()->take(5)->get();
        $recentBookings           = BookingTicket::latest()->take(6)->get();

        // ── Chart (30 hari, tidak tergantung filter tab) ──
        $days = collect(range(29, 0))->map(fn ($i) => Carbon::today()->subDays($i));

        $chartLabels    = $days->map(fn ($d) => $d->format('d/m'))->values()->toArray();
        $chartBooking   = $days->map(fn ($d) => BookingTicket::whereDate('tanggal_kunjungan', $d)->count())->values()->toArray();
        $chartConfirmed = $days->map(fn ($d) => BookingTicket::whereDate('tanggal_kunjungan', $d)->where('status', 'confirmed')->count())->values()->toArray();
        $chartRevenue   = $days->map(fn ($d) => BookingTicket::whereDate('tanggal_kunjungan', $d)->whereIn('status', ['confirmed', 'completed'])->sum('total_harga') / 1000)->values()->toArray();

        $onboardingSteps = $this->buildOnboardingSteps();
        $onboardingDone  = collect($onboardingSteps)->where('done', true)->count();
        $onboardingTotal = count($onboardingSteps);

        $prevDate = $this->shiftAnchor($anchor, $period, -1);
        $nextDate = $this->shiftAnchor($anchor, $period, 1);

        $updatedAt = BookingTicket::latest('updated_at')->value('updated_at');

        return view('admin.dashboard', compact(
            'period',
            'anchor',
            'dateFrom',
            'dateTo',
            'periodLabel',
            'prevDate',
            'nextDate',
            'transactions',
            'totalRevenue',
            'unpaidRevenue',
            'paidRevenue',
            'ticketsSold',
            'avgPerTransaction',
            'avgTicketsPerTx',
            'bookingTotal',
            'bookingPending',
            'bookingReserved',
            'bookingLunas',
            'bookingRevenue',
            'pendingTestimonialsCount',
            'pendingTestimonials',
            'recentBookings',
            'chartLabels',
            'chartBooking',
            'chartConfirmed',
            'chartRevenue',
            'onboardingSteps',
            'onboardingDone',
            'onboardingTotal',
            'updatedAt',
        ));
    }

    private function resolvePeriodRange(string $period, Carbon $anchor): array
    {
        return match ($period) {
            'mingguan' => [
                $anchor->copy()->startOfWeek(Carbon::MONDAY),
                $anchor->copy()->endOfWeek(Carbon::SUNDAY),
                'Mingguan',
            ],
            'bulanan' => [
                $anchor->copy()->startOfMonth(),
                $anchor->copy()->endOfMonth(),
                'Bulanan',
            ],
            default => [
                $anchor->copy(),
                $anchor->copy(),
                'Harian',
            ],
        };
    }

    private function shiftAnchor(Carbon $anchor, string $period, int $direction): Carbon
    {
        $copy = $anchor->copy();

        return match ($period) {
            'mingguan' => $copy->addWeeks($direction),
            'bulanan'  => $copy->addMonths($direction),
            default    => $copy->addDays($direction),
        };
    }

    private function buildOnboardingSteps(): array
    {
        $hasSchedule = Schedule::where('date', '>=', now()->toDateString())->exists();
        $hasBooking  = BookingTicket::exists();
        $hasSettings = file_exists(SiteSettings::path());

        return [
            [
                'key'   => 'schedule',
                'title' => 'Siapkan Jadwal',
                'desc'  => 'Atur jadwal pertunjukan & kapasitas',
                'done'  => $hasSchedule,
                'url'   => route('admin.schedules.index'),
                'icon'  => 'calendar',
            ],
            [
                'key'   => 'booking',
                'title' => 'Kelola Booking',
                'desc'  => 'Konfirmasi tiket dari pengunjung',
                'done'  => $hasBooking,
                'url'   => route('admin.booking.ticket.index'),
                'icon'  => 'ticket',
            ],
            [
                'key'   => 'settings',
                'title' => 'Lengkapi Pengaturan',
                'desc'  => 'Kontak, operasional & profil admin',
                'done'  => $hasSettings,
                'url'   => route('admin.settings.index'),
                'icon'  => 'settings',
            ],
        ];
    }
}

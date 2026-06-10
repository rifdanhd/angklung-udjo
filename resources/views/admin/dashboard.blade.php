@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $siteName = site_setting('site_name', 'Saung Angklung Udjo');
    $dateRangeLabel = $dateFrom->isSameDay($dateTo)
        ? $dateFrom->translatedFormat('d M Y')
        : $dateFrom->translatedFormat('d M y') . ' – ' . $dateTo->translatedFormat('d M y');

    $dashQuery = fn (array $extra = []) => array_merge(
        ['period' => $period, 'date' => $anchor->toDateString()],
        $extra
    );
@endphp

<div class="dash-home">

    {{-- Banner promosi --}}
    <div class="dash-banner">
        <div class="dash-banner-inner">
            <div class="dash-banner-brand">
                <img src="{{ asset('images/UdjoFullColor.png') }}" alt="{{ $siteName }}" class="dash-banner-logo">
                <div>
                    <div class="dash-banner-kicker">Panel Admin</div>
                    <div class="dash-banner-title">{{ $siteName }}</div>
                </div>
            </div>
            <div class="dash-banner-copy">
                <h2 class="dash-banner-headline">Kelola pertunjukan &amp; booking<br><span>dengan mudah.</span></h2>
                <p class="dash-banner-sub">Pantau tiket, jadwal, dan pendapatan dalam satu tempat.</p>
            </div>
            <div class="dash-banner-actions">
                <a href="{{ route('admin.booking.ticket.index') }}" class="btn btn-primary">Booking Tiket</a>
                <a href="{{ route('admin.analytics') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,.35);color:#fff;">Analytics</a>
            </div>
        </div>
    </div>

    {{-- Langkah onboarding --}}
    <div class="dash-onboard">
        <div class="dash-onboard-head">
            <h3 class="dash-onboard-title">Langkah Mudah Kelola SAU</h3>
            <div class="dash-onboard-progress-wrap">
                <span class="dash-onboard-count">{{ $onboardingDone }}/{{ $onboardingTotal }}</span>
                <div class="dash-onboard-bar" role="progressbar" aria-valuenow="{{ $onboardingDone }}" aria-valuemin="0" aria-valuemax="{{ $onboardingTotal }}">
                    <div class="dash-onboard-bar-fill" style="width: {{ $onboardingTotal > 0 ? round(($onboardingDone / $onboardingTotal) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="dash-onboard-steps">
            @foreach ($onboardingSteps as $step)
                <a href="{{ $step['url'] }}" class="dash-step-card {{ $step['done'] ? 'is-done' : '' }}">
                    <div class="dash-step-icon">
                        @if ($step['icon'] === 'calendar')
                            <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        @elseif ($step['icon'] === 'ticket')
                            <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        @else
                            <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @endif
                    </div>
                    <div class="dash-step-text">
                        <strong>{{ $step['title'] }}</strong>
                        <span>{{ $step['desc'] }}</span>
                    </div>
                    @if ($step['done'])
                        <span class="dash-step-check" aria-label="Selesai">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- Dashboard utama --}}
    <div class="dash-panel card">
        <div class="dash-panel-top">
            <div class="dash-panel-title-wrap">
                <h2 class="dash-panel-title">
                    Dashboard Booking
                    <button type="button" class="dash-icon-btn" title="Ringkasan booking tiket SAU" tabindex="-1">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    </button>
                </h2>
                <p class="dash-panel-updated">
                    Diperbarui {{ $updatedAt ? $updatedAt->timezone(config('app.timezone'))->translatedFormat('d M Y, H:i:s') : now()->translatedFormat('d M Y, H:i:s') }}
                </p>
            </div>
        </div>

        <div class="dash-panel-toolbar">
            <div class="dash-segment">
                <a href="{{ route('admin.dashboard', $dashQuery(['period' => 'harian'])) }}"
                   class="dash-segment-item {{ $period === 'harian' ? 'active' : '' }}">Harian</a>
                <a href="{{ route('admin.dashboard', $dashQuery(['period' => 'mingguan'])) }}"
                   class="dash-segment-item {{ $period === 'mingguan' ? 'active' : '' }}">Mingguan</a>
                <a href="{{ route('admin.dashboard', $dashQuery(['period' => 'bulanan'])) }}"
                   class="dash-segment-item {{ $period === 'bulanan' ? 'active' : '' }}">Bulanan</a>
            </div>

            <div class="dash-date-nav">
                <a href="{{ route('admin.dashboard', $dashQuery(['date' => $prevDate->toDateString()])) }}" class="dash-date-btn" aria-label="Periode sebelumnya">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                </a>
                <span class="dash-date-label">{{ $dateRangeLabel }}</span>
                <a href="{{ route('admin.dashboard', $dashQuery(['date' => $nextDate->toDateString()])) }}" class="dash-date-btn" aria-label="Periode berikutnya">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            </div>
        </div>

        <div class="dash-metrics">
            <div class="dash-metric-main">
                <span class="dash-metric-label">Total Pendapatan</span>
                <div class="dash-metric-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <span class="dash-metric-hint">{{ $periodLabel }} · terkonfirmasi &amp; selesai</span>
            </div>
            <div class="dash-metric-grid">
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Belum Lunas</span>
                    <span class="dash-metric-value-sm">Rp {{ number_format($unpaidRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Transaksi</span>
                    <span class="dash-metric-value-sm">{{ number_format($transactions, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Pendapatan Terkonfirmasi</span>
                    <span class="dash-metric-value-sm">Rp {{ number_format($paidRevenue, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Tiket Terjual</span>
                    <span class="dash-metric-value-sm">{{ number_format($ticketsSold, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Rata-rata / Transaksi</span>
                    <span class="dash-metric-value-sm">Rp {{ number_format($avgPerTransaction, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Tiket / Transaksi</span>
                    <span class="dash-metric-value-sm">{{ $avgTicketsPerTx }}</span>
                </div>
            </div>
        </div>

        <div class="dash-chart-section">
            <div class="dash-chart-head">
                <h3 class="dash-chart-title">Tren Booking — {{ $dateFrom->translatedFormat('d M Y') }}</h3>
                <div class="dash-segment dash-segment-sm">
                    <button type="button" id="ttBtn0" onclick="ttSwitch(0)" class="dash-segment-item metric-tab active">Booking</button>
                    <button type="button" id="ttBtn1" onclick="ttSwitch(1)" class="dash-segment-item metric-tab">Confirmed</button>
                    <button type="button" id="ttBtn2" onclick="ttSwitch(2)" class="dash-segment-item metric-tab">Pendapatan</button>
                </div>
            </div>
            <div class="dash-chart-wrap">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Ringkasan cepat --}}
    <div class="dash-summary-row">
        <div class="dash-mini-stat">
            <span class="dash-mini-label">Total Booking</span>
            <strong>{{ number_format($bookingTotal, 0, ',', '.') }}</strong>
        </div>
        <div class="dash-mini-stat {{ $bookingReserved > 0 ? 'is-warn' : '' }}">
            <span class="dash-mini-label">Reservasi</span>
            <strong>{{ number_format($bookingReserved, 0, ',', '.') }}</strong>
        </div>
        <div class="dash-mini-stat">
            <span class="dash-mini-label">Lunas</span>
            <strong>{{ number_format($bookingLunas, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="dashboard-bottom-grid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Booking Terbaru
                </div>
                <a href="{{ route('admin.booking.ticket.index') }}" class="card-action">Lihat semua →</a>
            </div>
            <div class="recent-list">
                @forelse($recentBookings as $b)
                    <div class="recent-item">
                        <div style="flex:1;min-width:0;">
                            <div class="recent-item-title">{{ $b->name }}</div>
                            <div class="recent-item-sub">{{ $b->visit_date->translatedFormat('d M Y') }} · {{ $b->session_time }}</div>
                            <div class="recent-item-code">{{ $b->booking_code }}</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                            @php
                                $statusClass = match($b->status) {
                                    'pending' => 'badge-warning',
                                    'confirmed' => 'badge-info',
                                    'completed' => 'badge-success',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-muted',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $b->statusLabel() }}</span>
                            <div style="font-size:12px;color:var(--text-muted);margin-top:6px;font-weight:500;">{{ $b->formattedTotal() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="recent-empty">
                        <div class="recent-empty-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>Belum ada booking</div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Testimoni Perlu Review
                    @if($pendingTestimonialsCount > 0)
                        <span class="badge badge-warning" style="margin-left:4px;">{{ $pendingTestimonialsCount }}</span>
                    @endif
                </div>
                <a href="{{ route('admin.testimonials.index') }}" class="card-action">Lihat semua →</a>
            </div>
            <div class="recent-list">
                @forelse($pendingTestimonials as $t)
                    <div class="recent-item">
                        <div style="flex:1;min-width:0;">
                            <div class="recent-item-title">{{ $t->name }}</div>
                            <div class="recent-item-sub" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:280px;">{{ $t->message }}</div>
                        </div>
                        <span class="badge badge-warning" style="flex-shrink:0;margin-left:12px;">Pending</span>
                    </div>
                @empty
                    <div class="recent-empty">
                        <div class="recent-empty-icon" style="color:var(--success);">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>Semua testimoni sudah direview</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const labels    = @json($chartLabels);
    const booking   = @json($chartBooking);
    const confirmed = @json($chartConfirmed);
    const revenue   = @json($chartRevenue);

    const palette = [
        { color: '#1a1445', data: booking,   label: 'Total Booking',          fmt: v => v },
        { color: '#3b348f', data: confirmed, label: 'Booking Reservasi',       fmt: v => v },
        { color: '#c4a47c', data: revenue,   label: 'Est. Pendapatan (ribu)', fmt: v => 'Rp ' + Number(v).toLocaleString('id-ID') + ' rb' },
    ];

    const canvas = document.getElementById('bookingChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    function makeGrad(color) {
        const g = ctx.createLinearGradient(0, 0, 0, 220);
        g.addColorStop(0, color + '28');
        g.addColorStop(1, color + '00');
        return g;
    }

    let currentIdx = 0;
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                data: booking,
                borderColor: palette[0].color,
                backgroundColor: makeGrad(palette[0].color),
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1445',
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: item => palette[currentIdx].fmt(item.parsed.y)
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#a1a1aa', font: { size: 11 }, maxTicksLimit: 8 } },
                y: { grid: { color: 'rgba(26,20,69,.06)' }, border: { display: false }, ticks: { color: '#a1a1aa', font: { size: 11 } }, beginAtZero: true }
            }
        }
    });

    window.ttSwitch = function (idx) {
        if (idx === currentIdx) return;
        currentIdx = idx;
        const p = palette[idx];
        chart.data.datasets[0].data = p.data;
        chart.data.datasets[0].borderColor = p.color;
        chart.data.datasets[0].backgroundColor = makeGrad(p.color);
        chart.update();
        document.querySelectorAll('.dash-chart-section .metric-tab').forEach((btn, i) => {
            btn.classList.toggle('active', i === idx);
        });
    };
})();
</script>
@endpush

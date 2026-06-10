@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
@php
    $siteName = site_setting('site_name', 'Saung Angklung Udjo');
    $totalSessions  = array_sum(array_column($data, 'sessions'));
    $totalUsers     = array_sum(array_column($data, 'users'));
    $totalPageviews = array_sum(array_column($data, 'pageviews'));
    $avgSessionPerDay = count($data) > 0 ? round($totalSessions / count($data)) : 0;
    $avgUserPerDay    = count($data) > 0 ? round($totalUsers / count($data)) : 0;
    $userSessionRate  = $totalSessions > 0 ? number_format(($totalUsers / $totalSessions) * 100, 1) : 0;
    $pagePerUser      = $totalUsers > 0 ? number_format($totalPageviews / $totalUsers, 1) : 0;
@endphp

<div class="dash-home analytics-page">

    <div class="dash-banner">
        <div class="dash-banner-inner">
            <div class="dash-banner-brand">
                <img src="{{ asset('images/UdjoFullColor.png') }}" alt="{{ $siteName }}" class="dash-banner-logo">
                <div>
                    <div class="dash-banner-kicker">Google Analytics</div>
                    <div class="dash-banner-title">{{ $siteName }}</div>
                </div>
            </div>
            <div class="dash-banner-copy">
                <h2 class="dash-banner-headline">Pantau kunjungan website<br><span>secara realtime.</span></h2>
                <p class="dash-banner-sub">Sesi, pengguna, halaman populer, dan sumber trafik dalam satu dashboard.</p>
            </div>
            <div class="dash-banner-actions">
                <button type="button" onclick="fetchRealtime()" class="btn btn-primary">Refresh Realtime</button>
                <a href="{{ route('admin.analytics.clear-cache') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,.35);color:#fff;" data-no-loader onclick="return confirm('Bersihkan cache analytics?')">Bersihkan Cache</a>
            </div>
        </div>
    </div>

    <div class="dash-onboard">
        <div class="dash-onboard-head">
            <h3 class="dash-onboard-title">Ringkasan Analytics</h3>
            <span style="font-size:12px;color:rgba(255,255,255,.7);">Auto-refresh realtime setiap 60 detik</span>
        </div>
        <div class="dash-onboard-steps">
            <div class="dash-step-card is-done" style="cursor:default;">
                <div class="dash-step-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div class="dash-step-text">
                    <strong>30 Hari Terakhir</strong>
                    <span>{{ count($data) }} hari data tercatat</span>
                </div>
            </div>
            <a href="#ga-realtime" class="dash-step-card">
                <div class="dash-step-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div class="dash-step-text">
                    <strong>Pengunjung Live</strong>
                    <span>Lihat tamu yang sedang online</span>
                </div>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="dash-step-card">
                <div class="dash-step-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                </div>
                <div class="dash-step-text">
                    <strong>Dashboard Booking</strong>
                    <span>Kembali ke ringkasan operasional</span>
                </div>
            </a>
        </div>
    </div>

    @if(isset($error))
    <div class="analytics-alert is-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
        Gagal tersambung ke Google Analytics API: {{ $error }}
    </div>
    @endif

    @if(session('success'))
    <div class="analytics-alert is-success">{{ session('success') }}</div>
    @endif

    <div id="ga-realtime" class="dash-live-banner">
        <div class="dash-live-topbar">
            <div class="dash-pulse-dot">
                <span class="dot"></span>
                Pengunjung Realtime (Live)
            </div>
            <span style="color:rgba(255,255,255,.45);font-size:11.5px;" id="last-refresh">Memuat data realtime...</span>
        </div>
        <div class="dash-live-body">
            <div class="dash-live-grid">
                <div>
                    <p class="dash-live-kicker">Pengguna aktif saat ini</p>
                    <div style="display:flex;align-items:flex-end;gap:8px;margin-bottom:6px;">
                        <span id="active-users">
                            <span class="skeleton" style="display:inline-block;width:65px;height:56px;background:rgba(255,255,255,.08);border-radius:8px;"></span>
                        </span>
                        <span style="color:var(--gold-premium);font-size:14px;font-weight:700;padding-bottom:8px;">tamu</span>
                    </div>
                    <p class="dash-live-sub">Sedang menelusuri website saungangklungudjo.co.id</p>
                    <div class="dash-live-stat-box">
                        <div class="dash-live-stat-row">
                            <span>Halaman aktif</span>
                            <span id="stat-pages">—</span>
                        </div>
                        <div class="dash-live-stat-row">
                            <span>Lokasi terbanyak</span>
                            <span id="stat-topcity">—</span>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="dash-live-kicker">Halaman yang sedang diakses</p>
                    <div id="page-list" class="dash-page-list">
                        <div class="skeleton" style="background:rgba(255,255,255,.06);border-radius:8px;height:38px;"></div>
                        <div class="skeleton" style="background:rgba(255,255,255,.06);border-radius:8px;height:38px;opacity:.6;"></div>
                    </div>
                </div>
            </div>
            <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(255,255,255,.08);">
                <p class="dash-live-kicker" style="margin-bottom:10px;">Sebaran lokasi pengunjung</p>
                <div id="city-list" style="display:flex;flex-wrap:wrap;gap:8px;">
                    <span class="skeleton" style="background:rgba(255,255,255,.08);border-radius:99px;width:110px;height:26px;"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-panel card">
        <div class="dash-panel-top">
            <div class="dash-panel-title-wrap">
                <h2 class="dash-panel-title">Performa 30 Hari Terakhir</h2>
                <p class="dash-panel-updated">Ringkasan sesi, pengguna, dan tayangan halaman website</p>
            </div>
        </div>
        <div class="dash-metrics">
            <div class="dash-metric-main">
                <span class="dash-metric-label">Total Sesi Kunjungan</span>
                <div class="dash-metric-value">{{ number_format($totalSessions, 0, ',', '.') }}</div>
                <span class="dash-metric-hint">Rata-rata {{ number_format($avgSessionPerDay, 0, ',', '.') }} / hari</span>
            </div>
            <div class="dash-metric-grid">
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Pengguna Unik</span>
                    <span class="dash-metric-value-sm">{{ number_format($totalUsers, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Tayangan Halaman</span>
                    <span class="dash-metric-value-sm">{{ number_format($totalPageviews, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Rata-rata User / Hari</span>
                    <span class="dash-metric-value-sm">{{ number_format($avgUserPerDay, 0, ',', '.') }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Halaman / User</span>
                    <span class="dash-metric-value-sm">{{ $pagePerUser }}</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Rasio User / Sesi</span>
                    <span class="dash-metric-value-sm">{{ $userSessionRate }}%</span>
                </div>
                <div class="dash-metric-cell">
                    <span class="dash-metric-label">Hari Tercatat</span>
                    <span class="dash-metric-value-sm">{{ count($data) }}</span>
                </div>
            </div>
        </div>
        <div class="dash-chart-section">
            <div class="dash-chart-head">
                <h3 class="dash-chart-title">Tren Kunjungan &amp; Interaksi</h3>
                <div class="analytics-legend">
                    <span class="analytics-legend-item"><span class="analytics-legend-dot" style="background:#1a1445;"></span> Sesi</span>
                    <span class="analytics-legend-item"><span class="analytics-legend-dot" style="background:#3b348f;"></span> Users</span>
                    <span class="analytics-legend-item"><span class="analytics-legend-dot" style="background:#c4a47c;"></span> Pageviews</span>
                </div>
            </div>
            <div class="dash-chart-wrap">
                <canvas id="gaChart"></canvas>
            </div>
        </div>
    </div>

{{-- ═══════════════════ ANALYSIS GRID (TOP PAGES & ACQUISITION) ═══════════════════ --}}
<div class="analysis-grid">
    {{-- Halaman Terpopuler (Top Pages) --}}
    <div class="card" style="padding:20px;">
        <div class="card-title" style="margin-bottom:6px;">📄 Halaman Terpopuler</div>
        <div class="card-sub" style="margin-bottom:18px;">Halaman yang paling sering dikunjungi tamu di website</div>
        
        <div class="analytics-progress-list">
            @php
                $maxViews = collect($topPages)->max('views') ?: 1;
            @endphp
            @forelse($topPages as $page)
            @php
                $percentage = ($page['views'] / $maxViews) * 100;
                $cleanPath = $page['path'] === '/' ? '/ (Beranda)' : $page['path'];
            @endphp
            <div class="analytics-progress-item">
                <div class="analytics-progress-label">
                    <span style="font-weight:600; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:70%;">
                        {{ $cleanPath }}
                        <small style="display:block; font-size:10px; color:var(--text-muted); font-weight:400;">{{ $page['title'] }}</small>
                    </span>
                    <span style="color:var(--text-muted); font-size:11.5px; font-weight:600;">{{ number_format($page['views']) }} views</span>
                </div>
                <div class="analytics-progress-bar">
                    <div class="analytics-progress-fill" style="width: {{ $percentage }}%;"></div>
                </div>
                <div style="font-size:10px; color:var(--text-muted); margin-top:2px;">
                    👤 {{ number_format($page['users']) }} user &bull; Rata-rata baca: <b>{{ $page['avg_time'] }} detik</b>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:32px 0; color:var(--text-muted); font-size:13px;">
                Belum ada data halaman terpopuler.
            </div>
            @endforelse
        </div>
    </div>

    {{-- Sumber Trafik & Perangkat (Acquisition & Devices) --}}
    <div style="display:flex; flex-direction:column; gap:20px;">
        {{-- Sumber Pengunjung (Traffic Acquisition) --}}
        <div class="card" style="padding:20px; flex:1;">
            <div class="card-title" style="margin-bottom:6px;">📢 Sumber Lalu Lintas (Acquisition)</div>
            <div class="card-sub" style="margin-bottom:18px;">Bagaimana cara tamu menemukan website Saung Angklung Udjo</div>
            
       <div class="analytics-progress-list">
    @php
        $sources = $sources ?? [];
        $totalSourceSessions = collect($sources)->sum('sessions') ?: 1;
    @endphp
    @forelse($sources as $src)
                @php
                    $percentage = ($src['sessions'] / $totalSourceSessions) * 100;
                    $cleanSource = match(strtolower($src['source'])) {
                        'direct' => '💻 Direct (Langsung ketik URL / Bookmark)',
                        'google / organic' => '🔍 Google Search (Organik)',
                        'whatsapp / referral' => '💬 WhatsApp / Tautan Obrolan',
                        'instagram / referral', 'instagram.com / referral' => '📸 Instagram',
                        'facebook / referral', 'facebook.com / referral' => '👥 Facebook',
                        default => '🌐 ' . $src['source']
                    };
                @endphp
                <div class="analytics-progress-item">
                    <div class="analytics-progress-label">
                        <span>{{ $cleanSource }}</span>
                        <span style="color:var(--text-muted);">{{ number_format($src['sessions']) }} sesi</span>
                    </div>
                    <div class="analytics-progress-bar">
                        <div class="analytics-progress-fill" style="width: {{ $percentage }}%; background:var(--info);"></div>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:13px;">
                    Belum ada data sumber lalu lintas.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Perangkat Pengunjung (Device Breakdown) --}}
        <div class="card" style="padding:20px;">
            <div class="card-title" style="margin-bottom:6px;">📱 Perangkat Tamu (Devices)</div>
            <div class="card-sub" style="margin-bottom:16px;">Jenis gawai yang digunakan tamu saat membuka website</div>
            
            <div class="analytics-device-grid" style="margin-top:8px;">
                @php
                    $totalDeviceSessions = collect($devices)->sum('sessions') ?: 1;
                @endphp
                @forelse($devices as $dev)
                @php
                    $pct = ($dev['sessions'] / $totalDeviceSessions) * 100;
                    $icon = match(strtolower($dev['device'])) {
                        'mobile' => '📱',
                        'desktop' => '💻',
                        'tablet' => '📟',
                        default => '🌐'
                    };
                    $label = match(strtolower($dev['device'])) {
                        'mobile' => 'Smartphone / HP',
                        'desktop' => 'Komputer / Laptop',
                        'tablet' => 'Tablet / iPad',
                        default => ucfirst($dev['device'])
                    };
                @endphp
                <div class="analytics-device-card">
                    <span style="font-size:22px;">{{ $icon }}</span>
                    <span style="font-size:11.5px; font-weight:700; color:var(--text); margin-top:4px;">{{ $label }}</span>
                    <strong>{{ number_format($pct, 1) }}%</strong>
                    <span style="font-size:10.5px; color:var(--text-muted);">{{ number_format($dev['sessions']) }} sesi</span>
                </div>
                @empty
                <div style="text-align:center; padding:12px; color:var(--text-muted); font-size:12px; grid-column:span 3;">
                    Belum ada data perangkat.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════ GEOGRAPHIC & INTERACTION GRID ═══════════════════ --}}
<div class="analytics-geo-grid">
    {{-- Sebaran Negara (Geographic) --}}
    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:18px 20px; border-bottom:1px solid var(--border);">
            <div class="card-title">🌏 Sebaran Negara Asal Tamu</div>
            <div class="card-sub">Top 20 asal negara kunjungan (30 hari terakhir)</div>
        </div>
        <div class="table-wrap">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:10px 16px; text-align:left; font-size:11px;">#</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px;">Negara</th>
                        <th style="padding:10px 16px; text-align:right; font-size:11px;">Pengguna (Users)</th>
                        <th style="padding:10px 16px; text-align:right; font-size:11px;">Sesi</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px;">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCountrySessions = array_sum(array_column($countries ?? [], 'sessions')) ?: 1;
                        $flagMap = ['ID'=>'🇮🇩','US'=>'🇺🇸','MY'=>'🇲🇾','SG'=>'🇸🇬','AU'=>'🇦🇺','GB'=>'🇬🇧','JP'=>'🇯🇵','DE'=>'🇩🇪','NL'=>'🇳🇱','SA'=>'🇸🇦','AE'=>'🇦🇪','IN'=>'🇮🇳','FR'=>'🇫🇷','KR'=>'🇰🇷','CN'=>'🇨🇳','CA'=>'🇨🇦','BR'=>'🇧🇷','IT'=>'🇮🇹','ES'=>'🇪🇸','PH'=>'🇵🇭','TH'=>'🇹🇭','VN'=>'🇻🇳','NZ'=>'🇳🇿','QA'=>'🇶🇦','KW'=>'🇰🇼'];
                    @endphp
                    @forelse($countries ?? [] as $i => $c)
                    @php
                        $share = round(($c['sessions'] / $totalCountrySessions) * 100, 1);
                        $flag  = $flagMap[$c['code']] ?? '🌍';
                    @endphp
                    <tr style="border-bottom:1px solid var(--border);" onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:11px 16px; font-size:12px; color:var(--text-muted); font-weight:700;">{{ $i + 1 }}</td>
                        <td style="padding:11px 16px; font-size:13px; font-weight:600; color:var(--text);">{{ $flag }} {{ $c['country'] }}</td>
                        <td style="padding:11px 16px; text-align:right; font-size:13px; font-weight:700; color:var(--success-text);">{{ number_format($c['users']) }}</td>
                        <td style="padding:11px 16px; text-align:right; font-size:13px; font-weight:700; color:var(--accent);">{{ number_format($c['sessions']) }}</td>
                        <td style="padding:11px 16px; min-width:100px;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <div class="analytics-progress-bar" style="flex:1; height:5px;">
                                    <div class="analytics-progress-fill" style="width:{{ $share }}%; background:var(--success);"></div>
                                </div>
                                <span style="font-size:11px; color:var(--text-muted); font-weight:600; min-width:30px;">{{ $share }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px 16px; text-align:center; color:var(--text-muted); font-size:13px;">Belum ada data negara</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Klik Tombol & Interaksi (Events) --}}
    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:18px 20px; border-bottom:1px solid var(--border);">
            <div class="card-title">🖱️ Interaksi &amp; Klik Tombol Tamu</div>
            <div class="card-sub">Event tracking elemen penting website (30 hari terakhir)</div>
        </div>
        @if(empty($events ?? []))
        <div style="padding:56px 20px; text-align:center; color:var(--text-muted);">
            <div style="font-size:36px; margin-bottom:12px;">📡</div>
            <p style="font-size:13.5px; font-weight:600; margin:0 0 4px; color:var(--text);">Belum ada data interaksi</p>
            <p style="font-size:11.5px; margin:0;">Pastikan kode GA4 tracking sudah aktif di website</p>
        </div>
        @else
        <div class="table-wrap" style="max-height: 380px; overflow-y: auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:10px 16px; text-align:left; font-size:11px;">Elemen / Tombol Website</th>
                        <th style="padding:10px 16px; text-align:right; font-size:11px;">Total Klik</th>
                        <th style="padding:10px 16px; text-align:right; font-size:11px;">Tamu</th>
                        <th style="padding:10px 16px; text-align:right; font-size:11px;">Klik/Tamu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $ev)
                    @php
                        $label     = ($ev['button_text'] && $ev['button_text'] !== '(not set)') ? $ev['button_text'] : $ev['event_name'];
                        $clickRate = $ev['users'] > 0 ? number_format($ev['count'] / $ev['users'], 1) : '-';
                        $icon      = match(true) {
                            str_contains(strtolower($label), 'book')     => '🎟️',
                            str_contains(strtolower($label), 'tiket')    => '🎫',
                            str_contains(strtolower($label), 'whatsapp') => '💬',
                            str_contains(strtolower($label), 'jadwal')   => '📅',
                            str_contains(strtolower($label), 'kontak')   => '📞',
                            default                                       => '🖱️',
                        };
                    @endphp
                    <tr style="border-bottom:1px solid var(--border);" onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:11px 16px; font-size:13px; font-weight:600; color:var(--text);">
                            {{ $icon }} {{ $label }}
                            <span style="display:block; font-size:10px; color:var(--text-muted); font-weight:400; margin-top:2px;">{{ $ev['event_name'] }}</span>
                        </td>
                        <td style="padding:11px 16px; text-align:right; font-size:15px; font-weight:800; color:var(--warning-text);">{{ number_format($ev['count']) }}</td>
                        <td style="padding:11px 16px; text-align:right; font-size:13px; font-weight:600; color:var(--text-muted);">{{ number_format($ev['users']) }}</td>
                        <td style="padding:11px 16px; text-align:right;">
                            <span style="background:var(--warning-soft); color:var(--warning-text); font-size:10.5px; font-weight:700; padding:2px 8px; border-radius:20px;">{{ $clickRate }}x</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- ═══════════════════ DETAILED DAILY TABLE ═══════════════════ --}}
<div class="card" style="padding:0; overflow:hidden; margin-top: 24px;">
    <div style="padding:18px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <div>
            <div class="card-title">📅 Rincian Lalu Lintas Harian (Lengkap)</div>
            <div class="card-sub">Tabel breakdown lengkap performa kunjungan harian</div>
        </div>
        <span class="badge badge-info" style="font-weight: 700;">{{ count($data) }} Hari Tercatat</span>
    </div>
    <div class="table-wrap">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="padding:12px 20px; text-align:left; font-size:11px;">Tanggal</th>
                    <th style="padding:12px 20px; text-align:right; font-size:11px;">Sesi Kunjungan (Sessions)</th>
                    <th style="padding:12px 20px; text-align:right; font-size:11px;">Pengguna (Users)</th>
                    <th style="padding:12px 20px; text-align:right; font-size:11px;">Tayangan Halaman (Pageviews)</th>
                    <th style="padding:12px 20px; text-align:right; font-size:11px;">Halaman / Tamu</th>
                    <th style="padding:12px 20px; text-align:left; font-size:11px;">Indikator Performa</th>
                </tr>
            </thead>
            <tbody>
                @php $maxSession = max(array_column($data, 'sessions') ?: [1]); @endphp
                @forelse($data as $row)
                @php
                    $pct = $maxSession > 0 ? ($row['sessions'] / $maxSession) * 100 : 0;
                    $ppu = $row['users'] > 0 ? round($row['pageviews'] / $row['users'], 1) : 0;
                @endphp
                <tr style="border-bottom:1px solid var(--border);" onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
                    <td style="padding:12px 20px; font-size:13px; font-weight:600; color:var(--text);">
                        {{ \Carbon\Carbon::parse($row['date'])->translatedFormat('d M Y') }}
                    </td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:700; color:#3b82f6;">{{ number_format($row['sessions']) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:600; color:#22c55e;">{{ number_format($row['users']) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:600; color:#a855f7;">{{ number_format($row['pageviews']) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; color:var(--text-muted);">{{ $ppu }}</td>
                    <td style="padding:12px 20px; min-width:130px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="analytics-progress-bar" style="flex:1;">
                                <div class="analytics-progress-fill" style="width:{{ $pct }}%; background: #3b82f6;"></div>
                            </div>
                            <span style="font-size:10.5px; color:var(--text-muted); min-width:28px; text-align:right; font-weight:600;">{{ round($pct) }}%</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:56px 20px; text-align:center; color:var(--text-muted);">
                        <div style="font-size:36px; margin-bottom:10px;">📭</div>
                        <p style="font-size:13.5px; margin:0;">Tidak ada data lalu lintas harian tersedia</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:var(--surface2); border-top:2px solid var(--border-strong);">
                    <td style="padding:12px 20px; font-size:13px; font-weight:700; color:var(--text);">Total Akumulasi</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:800; color:#2563eb;">{{ number_format($totalSessions) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:800; color:#16a34a;">{{ number_format($totalUsers) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:800; color:#9333ea;">{{ number_format($totalPageviews) }}</td>
                    <td style="padding:12px 20px; text-align:right; font-size:13px; font-weight:700; color:var(--text-muted);">{{ $pagePerUser }}</td>
                    <td style="padding:12px 20px;"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

</div>

@endsection

@push('scripts')
{{-- Chart.js & Realtime Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels    = @json(array_column($data, 'date'));
const sessions  = @json(array_column($data, 'sessions'));
const users     = @json(array_column($data, 'users'));
const pageviews = @json(array_column($data, 'pageviews'));

/* Convert simple date to local formatted date strings */
const formattedLabels = labels.map(d => {
    try {
        const parts = d.split('-');
        if (parts.length === 3) {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${parseInt(parts[2])} ${months[parseInt(parts[1]) - 1]}`;
        }
    } catch(e) {}
    return d;
});

const sharedOptions = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: { legend: { display: false } },
    scales: {
        x: {
            grid: { display: false },
            ticks: { font: { size: 10.5, family: 'var(--font)' }, color: 'var(--text-muted)', maxTicksLimit: 12 }
        },
        y: {
            grid: { color: 'var(--border)', lineWidth: 0.5 },
            ticks: { font: { size: 10.5, family: 'var(--font)' }, color: 'var(--text-muted)' },
            border: { display: false }
        }
    }
};

const chartCtx = document.getElementById('gaChart');
if (chartCtx) {
    new Chart(chartCtx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                { label:'Sesi',  data:sessions,  borderColor:'#1a1445', backgroundColor:'rgba(26,20,69,0.06)',  tension:0.35, fill:true, pointRadius:1, pointHoverRadius:4, borderWidth:2, pointBackgroundColor:'#1a1445' },
                { label:'User',  data:users,     borderColor:'#3b348f', backgroundColor:'rgba(59,52,143,0.06)',   tension:0.35, fill:true, pointRadius:1, pointHoverRadius:4, borderWidth:2, pointBackgroundColor:'#3b348f' },
                { label:'View',  data:pageviews, borderColor:'#c4a47c', backgroundColor:'rgba(196,164,124,0.12)', tension:0.35, fill:true, pointRadius:1, pointHoverRadius:4, borderWidth:2, pointBackgroundColor:'#c4a47c' },
            ]
        },
        options: sharedOptions
    });
}

/* ======================================================
   FLAG MAP & REALTIME UPDATE
   ====================================================== */
const flagMap = {
    'ID':'🇮🇩','US':'🇺🇸','MY':'🇲🇾','SG':'🇸🇬','AU':'🇦🇺',
    'GB':'🇬🇧','JP':'🇯🇵','DE':'🇩🇪','NL':'🇳🇱','SA':'🇸🇦',
    'AE':'🇦🇪','IN':'🇮🇳','FR':'🇫🇷','KR':'🇰🇷','CN':'🇨🇳',
    'CA':'🇨🇦','BR':'🇧🇷','IT':'🇮🇹','ES':'🇪🇸','PH':'🇵🇭',
    'TH':'🇹🇭','VN':'🇻🇳','NZ':'🇳🇿','QA':'🇶🇦','KW':'🇰🇼',
};

const cityPalette = [
    { bg:'rgba(196,164,124,0.22)',  color:'#6ee7b7', border:'rgba(16,185,129,0.35)'  },  // hijau
    { bg:'rgba(99,102,241,0.18)',  color:'#a5b4fc', border:'rgba(99,102,241,0.35)'  },  // ungu
    { bg:'rgba(251,191,36,0.18)',  color:'#fcd34d', border:'rgba(251,191,36,0.35)'  },  // kuning
    { bg:'rgba(236,72,153,0.18)',  color:'#f9a8d4', border:'rgba(236,72,153,0.35)'  },  // pink
    { bg:'rgba(20,184,166,0.18)',  color:'#5eead4', border:'rgba(20,184,166,0.35)'  },  // teal
];

function fetchRealtime() {
    fetch('/admin/analytics/realtime')
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                document.getElementById('active-users').innerHTML =
                    '<span style="font-size:38px; font-weight:800; color:var(--danger);">–</span>';
                document.getElementById('page-list').innerHTML =
                    '<div style="color:rgba(255,255,255,0.4); font-size:12.5px; padding:12px; text-align:center;">⚠️ Gagal tersambung ke GA4 realtime report</div>';
                return;
            }

            const count = data.active_users;
            const numColor = count >= 20 ? '#f59e0b' : '#c4a47c';
            
            document.getElementById('active-users').innerHTML =
                `<span class="dash-live-users-num" style="color:${numColor}; filter:drop-shadow(0 0 12px ${numColor}66); font-size:58px;">${count}</span>`;

            document.getElementById('last-refresh').textContent =
                'Update: Terakhir diperbarui jam ' + new Date().toLocaleTimeString('id-ID');

            /* ── Page list ── */
            const pageList = document.getElementById('page-list');
            if (!data.pages || data.pages.length === 0) {
                pageList.innerHTML =
                    '<div style="color:rgba(255,255,255,0.4); font-size:12px; text-align:center; padding:14px 0;">Tidak ada aktivitas saat ini</div>';
            } else {
                pageList.innerHTML = data.pages.map(p => {
                    const flag = flagMap[p.country] || '🌍';
                    const city = (p.city && p.city !== '(not set)') ? p.city : p.country;
                    return `
                    <div class="dash-page-item">
                        <div style="display:flex; align-items:center; gap:8px; min-width:0; flex:1;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#10b981; flex-shrink:0; box-shadow:0 0 4px #10b981;"></span>
                            <span style="color:#e2e8f0; font-size:12.5px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.page}</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px; flex-shrink:0;">
                            <span style="color:rgba(255,255,255,0.5); font-size:11.5px;">${flag} ${city}</span>
                            <span style="background:rgba(16,185,129,0.2); color:#6ee7b7; font-size:11px; font-weight:800; padding:2px 8px; border-radius:99px;">${p.users}</span>
                        </div>
                    </div>`;
                }).join('');
            }

            /* ── Mini stats ── */
            document.getElementById('stat-pages').textContent =
                data.pages ? data.pages.length + ' halaman' : '—';

            /* ── City breakdown ── */
            const cityMap = {};
            (data.pages || []).forEach(p => {
                const key  = (p.city && p.city !== '(not set)') ? p.city : p.country;
                const flag = flagMap[p.country] || '🌍';
                if (!cityMap[key]) cityMap[key] = { users: 0, flag };
                cityMap[key].users += p.users;
            });

            const sorted = Object.entries(cityMap).sort((a, b) => b[1].users - a[1].users);
            const cityListEl = document.getElementById('city-list');

            if (sorted.length > 0) {
                document.getElementById('stat-topcity').textContent =
                    sorted[0][1].flag + ' ' + sorted[0][0];
            }

            if (sorted.length === 0) {
                cityListEl.innerHTML = '<span style="color:rgba(255,255,255,0.4); font-size:11.5px;">Tidak ada data lokasi</span>';
            } else {
                cityListEl.innerHTML = sorted.map(([city, info], i) => {
                    const pal = cityPalette[i % cityPalette.length];
                    return `
                    <span class="dash-city-pill" style="background:${pal.bg}; color:${pal.color}; border: 1px solid ${pal.border};">
                        ${info.flag} ${city}
                        <span style="background:rgba(255,255,255,0.15); font-size:10.5px; padding:1px 6px; border-radius:99px; font-weight:800; color:#fff; margin-left:4px;">${info.users}</span>
                    </span>`;
                }).join('');
            }
        })
        .catch(() => {
            document.getElementById('active-users').innerHTML =
                '<span style="font-size:38px; font-weight:800; color:var(--danger);">–</span>';
            document.getElementById('last-refresh').textContent = '⚠️ Gagal memperbarui data realtime';
        });
}

fetchRealtime();
setInterval(fetchRealtime, 60000);
</script>
@endpush
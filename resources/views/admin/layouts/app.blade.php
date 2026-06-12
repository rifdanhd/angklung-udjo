{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Admin Panel') — Saung Angklung Udjo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('build/assets/app-CVN_iLpX.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">

    @stack('styles')
</head>
<body>

{{-- Loading: splash awal + progress navigasi --}}
<div id="admin-page-loader" class="admin-page-loader" aria-live="polite" aria-busy="true">
    <div class="admin-loader-card">
        <div class="admin-loader-spinner" aria-hidden="true"></div>
        <p class="admin-loader-title">Admin Panel</p>
        <p class="admin-loader-sub">Saung Angklung Udjo</p>
    </div>
</div>
<div id="admin-nav-progress" class="admin-nav-progress" role="progressbar" aria-hidden="true"></div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<div style="display:flex;height:100vh;overflow:hidden;">

    {{-- ═══════════════════ SIDEBAR ═══════════════════ --}}
    <aside id="sidebar" class="sidebar">

        <div class="sidebar-logo">
            <div class="sidebar-logo-inner">
                <div class="sidebar-logo-img">
                    <img src="{{ asset('images/UdjoFullColor.png') }}" alt="SAU">
                </div>
                <div class="sidebar-logo-text">
                    <div class="title">Admin Panel</div>
                    <div class="sub">SAU Bandung</div>
                </div>
            </div>
            <button id="close-sidebar"
                    style="display:none;background:none;border:none;cursor:pointer;color:var(--sidebar-text-muted);padding:4px;border-radius:6px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">Overview</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.analytics') }}"
               class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analytics
                <span id="sidebar-live-badge" class="nav-badge live" style="display:none;">● LIVE</span>
            </a>

            <div class="nav-section-label">Operasional</div>

            <a href="{{ route('admin.booking.ticket.index') }}"
               class="nav-item {{ request()->routeIs('admin.booking.ticket.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Booking Tiket
            </a>

            <a href="{{ route('admin.booking.online') }}"
               class="nav-item {{ request()->routeIs('admin.booking.online*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a15.3 15.3 0 014 9 15.3 15.3 0 01-4 9 15.3 15.3 0 01-4-9 15.3 15.3 0 014-9z" />
                </svg>
                Kuota Online
            </a>

            <a href="{{ route('admin.schedules.index') }}"
               class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Atur Jadwal &amp; Stok
            </a>

            <div class="nav-section-label">Promo</div>

            <a href="{{ route('admin.promos.index') }}"
               class="nav-item {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Buat Promo
            </a>

            <a href="{{ route('admin.promo.index') }}"
               class="nav-item {{ request()->routeIs('admin.promo.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4M5 7h14M5 7a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2"/>
                </svg>
                Klaim Promo
                @php
                    $countPendingPromo = \App\Models\PromoKlaim::whereIn('tanggal_kunjungan', ['2026-05-14', '2026-05-15', '2026-05-16'])->where('status', 'pending')->count();
                @endphp
                @if($countPendingPromo > 0)
                    <span class="nav-badge danger">{{ $countPendingPromo }}</span>
                @endif
            </a>

            <a href="{{ route('admin.partnerships.index') }}"
               class="nav-item {{ request()->routeIs('admin.partnerships.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Kemitraan / Sponsor
            </a>

            <div class="nav-section-label">Produk</div>

            <a href="{{ route('admin.products.index') }}"
               class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Semua Produk
            </a>

            <div class="nav-section-label">Manajemen Konten</div>

            <div class="nav-dropdown {{ (request()->routeIs('admin.hero.*') || request()->routeIs('admin.history-slides.*')) ? 'open' : '' }}">
                <button type="button" class="nav-item nav-dropdown-toggle {{ (request()->routeIs('admin.hero.*') || request()->routeIs('admin.history-slides.*')) ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Hero Carousel
                    <svg class="nav-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('admin.hero.index') }}"
                       class="nav-sub-item {{ request()->routeIs('admin.hero.index') ? 'active' : '' }}">
                        Carousel Home
                    </a>
                    <a href="{{ route('admin.history-slides.index') }}"
                       class="nav-sub-item {{ request()->routeIs('admin.history-slides.index') ? 'active' : '' }}">
                        Carousel History
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.articles.index') }}"
               class="nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                Artikel
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Events
            </a>

            <a href="{{ route('admin.testimonials.index') }}"
               class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                Testimoni
            </a>

            <a href="{{ route('admin.gallery.index') }}"
               class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Galeri
            </a>

            <div class="nav-section-label">Mendatang</div>

            @php
                $soonItems = [
                    ['label' => 'Pertunjukan',    'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                ];
            @endphp

            @foreach ($soonItems as $item)
                <div class="nav-item disabled" title="Segera hadir">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                    <span class="nav-badge soon">Soon</span>
                </div>
            @endforeach

            <div class="nav-section-label">Pengaturan</div>

            <a href="{{ route('admin.settings.index') }}"
               class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Pengaturan
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Manajemen User
            </a>

            <a href="{{ route('admin.reports.index') }}"
               class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Laporan Keuangan
            </a>

            <div class="nav-divider"></div>

            <a href="{{ route('home') }}" target="_blank" class="nav-item">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Website
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div style="min-width:0;">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Online</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;margin-left:auto;">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════ MAIN ═══════════════════ --}}
    <div class="main-wrap">

        {{-- ── TOPBAR ── --}}
        <header class="topbar">
            <button id="toggle-sidebar" class="mobile-menu-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Search --}}
            <div class="topbar-search">
                <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" placeholder="Cari menu, booking, produk..." id="topbar-search-input">
                <span class="search-kbd">⌘K</span>
            </div>

            <div class="topbar-right">

                {{-- Notification --}}
                <div class="dropdown-wrap" id="notif-wrap">
                    <button class="tb-btn" id="notif-btn" title="Notifikasi" aria-label="Notifikasi">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="notif-badge" id="notif-badge" style="display:none;">{{ $navPendingCount ?? 0 }}</span>
                    </button>

                    <div class="dropdown-panel notif-panel" id="notif-panel">
                        <div class="notif-header">
                            <div class="notif-header-title">
                                Notifikasi
                                <span class="notif-count-pill" id="notif-count-pill">0 baru</span>
                            </div>
                            <button class="mark-all-btn" id="mark-all-btn">Tandai semua</button>
                        </div>

                        <div class="notif-tabs">
                            <button class="notif-tab active" data-tab="all">Semua</button>
                            <button class="notif-tab" data-tab="unread">Belum Dibaca</button>
                        </div>

                        <div class="notif-list" id="notif-list">
                            {{-- rendered by JS --}}
                        </div>

                        <div class="notif-footer">
                            <a href="#">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                {{-- Settings --}}
                <a href="{{ route('admin.settings.index') }}" class="tb-btn" title="Pengaturan">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </a>

                <div class="topbar-divider"></div>

                {{-- User Profile --}}
                <div class="dropdown-wrap" id="user-wrap">
                    <button class="topbar-user-btn" id="user-btn" aria-label="User menu">
                        <div class="topbar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div class="topbar-user-info">
                            <span class="topbar-username">{{ auth()->user()->name }}</span>
                            <span class="topbar-userrole">Administrator</span>
                        </div>
                        <svg class="topbar-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </button>

                    <div class="dropdown-panel user-panel" id="user-panel">
                        <div class="user-panel-header">
                            <div class="user-panel-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <div style="min-width:0;">
                                <div class="user-panel-name">{{ auth()->user()->name }}</div>
                                <div class="user-panel-email">{{ auth()->user()->email }}</div>
                                <div class="user-panel-badge">Administrator</div>
                            </div>
                        </div>

                        <div class="user-menu">
                            <div class="user-menu-section">
                                <a href="{{ route('admin.settings.index') }}#profil" class="user-menu-item">
                                    <span class="umi-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                    <span class="umi-label">Profil Saya</span>
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="user-menu-item">
                                    <span class="umi-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </span>
                                    <span class="umi-label">Pengaturan</span>
                                </a>
                                <a href="#" class="user-menu-item">
                                    <span class="umi-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                    </span>
                                    <span class="umi-label">Notifikasi</span>
                                    <span class="umi-badge" id="user-notif-badge" style="display:none;">{{ $navPendingCount ?? 0 }}</span>
                                </a>
                            </div>

                            <div class="user-menu-section">
                                <a href="{{ route('home') }}" target="_blank" class="user-menu-item">
                                    <span class="umi-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </span>
                                    <span class="umi-label">Lihat Website</span>
                                </a>
                                <a href="#" class="user-menu-item">
                                    <span class="umi-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </span>
                                    <span class="umi-label">Bantuan</span>
                                </a>
                            </div>

                            <div class="user-menu-section">
                                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="user-menu-item danger-item">
                                        <span class="umi-icon">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </span>
                                        <span class="umi-label">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content">
            <div class="page-content-inner">

            @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')

            </div>
        </main>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toast-container"></div>

<script>
/* ═══════════ ADMIN LOADER ═══════════ */
(function () {
    const splash   = document.getElementById('admin-page-loader');
    const progress = document.getElementById('admin-nav-progress');
    const MIN_SPLASH_MS = 380;
    const splashStart = performance.now();
    let progressTimer = null;
    let progressValue = 0;

    function setProgressWidth(v) {
        if (!progress) return;
        progress.style.width = Math.min(100, Math.max(0, v)) + '%';
    }

    function hideSplash() {
        if (!splash || splash.classList.contains('is-hidden')) return;
        const wait = Math.max(0, MIN_SPLASH_MS - (performance.now() - splashStart));
        setTimeout(() => {
            splash.classList.add('is-hidden');
            splash.setAttribute('aria-busy', 'false');
            setTimeout(() => splash.remove(), 450);
        }, wait);
    }

    function startNavProgress() {
        if (!progress) return;
        clearInterval(progressTimer);
        progress.classList.add('is-active');
        progress.setAttribute('aria-hidden', 'false');
        progressValue = 12;
        setProgressWidth(progressValue);
        progressTimer = setInterval(() => {
            if (progressValue < 88) {
                progressValue += Math.random() * 6;
                setProgressWidth(progressValue);
            }
        }, 180);
    }

    function finishNavProgress() {
        if (!progress) return;
        clearInterval(progressTimer);
        progressValue = 100;
        setProgressWidth(100);
        setTimeout(() => {
            progress.classList.remove('is-active');
            progress.setAttribute('aria-hidden', 'true');
            setProgressWidth(0);
            progressValue = 0;
        }, 280);
    }

    function shouldTrackLink(a) {
        if (!a || a.target === '_blank' || a.hasAttribute('download')) return false;
        const href = a.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return false;
        if (a.dataset.noLoader !== undefined) return false;
        try {
            const url = new URL(href, window.location.origin);
            return url.origin === window.location.origin;
        } catch { return false; }
    }

    document.addEventListener('click', e => {
        const link = e.target.closest('a');
        if (shouldTrackLink(link)) startNavProgress();
    }, true);

    document.addEventListener('submit', e => {
        const form = e.target;
        if (form.dataset.noLoader !== undefined) return;
        if (form.target === '_blank') return;
        startNavProgress();
        form.classList.add('is-submitting');
        form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(btn => {
            btn.classList.add('is-loading');
            btn.disabled = true;
        });
    }, true);

    window.addEventListener('pageshow', () => {
        hideSplash();
        finishNavProgress();
        document.querySelectorAll('form.is-submitting').forEach(form => {
            form.classList.remove('is-submitting');
            form.querySelectorAll('.is-loading').forEach(btn => {
                btn.classList.remove('is-loading');
                btn.disabled = false;
            });
        });
    });

    if (document.readyState === 'complete') hideSplash();
    else window.addEventListener('load', hideSplash);

    window.adminLoader = {
        show: startNavProgress,
        hide: finishNavProgress,
        splash: hideSplash,
    };
})();

/* ═══════════ SIDEBAR ═══════════ */
const sidebar    = document.getElementById('sidebar');
const overlay    = document.getElementById('sidebar-overlay');
const toggleBtn  = document.getElementById('toggle-sidebar');
const closeBtn   = document.getElementById('close-sidebar');

const isMobile = () => window.innerWidth <= 768;

function openSidebar()  {
    sidebar.classList.remove('hidden-mobile');
    overlay.classList.add('active');
    if (closeBtn) closeBtn.style.display = 'block';
    if (isMobile()) document.body.classList.add('sidebar-open');
}
function closeSidebar() {
    sidebar.classList.add('hidden-mobile');
    overlay.classList.remove('active');
    document.body.classList.remove('sidebar-open');
}
function initMobile() {
    if (isMobile()) { sidebar.classList.add('hidden-mobile'); if (closeBtn) closeBtn.style.display = 'block'; }
    else { sidebar.classList.remove('hidden-mobile'); overlay.classList.remove('active'); if (closeBtn) closeBtn.style.display = 'none'; }
}

toggleBtn?.addEventListener('click', () => sidebar.classList.contains('hidden-mobile') ? openSidebar() : closeSidebar());
closeBtn?.addEventListener('click', closeSidebar);
overlay?.addEventListener('click', closeSidebar);
window.addEventListener('resize', initMobile);
initMobile();

// Dropdown sidebar toggle
document.querySelectorAll('.nav-dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const dropdown = btn.closest('.nav-dropdown');
        dropdown.classList.toggle('open');
    });
});

/* ═══════════ NOTIFICATION DATA ═══════════ */
const pendingCount = {{ $navPendingCount ?? 0 }};

// SVG icon helpers (no emoji — modern enterprise look)
const ICONS = {
    warning: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>',
    info:    '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>',
    success: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    danger:  '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>',
};

const notifications = [
    ...(pendingCount > 0 ? [{
        id: 0,
        type: 'warning',
        icon: ICONS.warning,
        title: `${pendingCount} Booking Menunggu Konfirmasi`,
        desc: 'Klik untuk melihat dan konfirmasi booking',
        time: 'Sekarang',
        unread: true,
        link: '{{ route("admin.booking.ticket.index") }}?status=pending'
    }] : []),
];

let notifData = [...notifications];
let activeTab = 'all';

function getFiltered() {
    return activeTab === 'unread' ? notifData.filter(n => n.unread) : notifData;
}

function unreadCount() {
    return notifData.filter(n => n.unread).length;
}

function updateBadges() {
    const badge  = document.getElementById('notif-badge');
    const pill   = document.getElementById('notif-count-pill');
    const ubadge = document.getElementById('user-notif-badge');

    const displayCount = pendingCount;

    badge.textContent   = displayCount > 99 ? '99+' : displayCount;
    badge.style.display = displayCount > 0 ? 'flex' : 'none';

    const totalUnread = unreadCount();
    pill.textContent  = totalUnread > 0 ? `${totalUnread} baru` : 'Semua dibaca';

    if (ubadge) {
        ubadge.textContent    = displayCount > 99 ? '99+' : displayCount;
        ubadge.style.display  = displayCount > 0 ? '' : 'none';
    }
}

function renderNotifications() {
    const list = document.getElementById('notif-list');
    const items = getFiltered();

    if (items.length === 0) {
        list.innerHTML = `
            <div class="notif-empty">
                <div class="notif-empty-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="notif-empty-text">Tidak ada notifikasi${activeTab === 'unread' ? ' yang belum dibaca' : ''}</div>
            </div>`;
        return;
    }

    list.innerHTML = items.map(n => `
        <div class="notif-item ${n.unread ? 'unread' : ''}" data-id="${n.id}">
            <div class="notif-icon-wrap ${n.type}">${n.icon}</div>
            <div class="notif-body">
                <div class="notif-title">${n.title}</div>
                <div class="notif-desc">${n.desc}</div>
                <div class="notif-time">${n.time}</div>
            </div>
            ${n.unread ? '<div class="notif-unread-dot"></div>' : ''}
        </div>
    `).join('');

    list.querySelectorAll('.notif-item').forEach(el => {
        el.addEventListener('click', () => {
            const id = parseInt(el.dataset.id);
            const item = notifData.find(n => n.id === id);
            if (item) {
                if (item.unread) {
                    item.unread = false;
                    renderNotifications();
                    updateBadges();
                }
                if (item.link) {
                    window.location.href = item.link;
                }
            }
        });
    });
}

/* ═══════════ DROPDOWN LOGIC ═══════════ */
function toggleDropdown(panel, btn) {
    const isOpen = panel.classList.contains('open');

    document.querySelectorAll('.dropdown-panel').forEach(p => p.classList.remove('open'));
    document.querySelectorAll('.tb-btn, .topbar-user-btn').forEach(b => b.classList.remove('active-btn'));

    if (!isOpen) {
        panel.classList.add('open');
        btn.classList.add('active-btn');
    }
}

const notifBtn   = document.getElementById('notif-btn');
const notifPanel = document.getElementById('notif-panel');
notifBtn.addEventListener('click', e => {
    e.stopPropagation();
    toggleDropdown(notifPanel, notifBtn);
    renderNotifications();
});

document.querySelectorAll('.notif-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.notif-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        activeTab = tab.dataset.tab;
        renderNotifications();
    });
});

document.getElementById('mark-all-btn').addEventListener('click', () => {
    notifData.forEach(n => n.unread = false);
    renderNotifications();
    updateBadges();
    showToast('Semua notifikasi telah ditandai dibaca', 'success');
});

const userBtn   = document.getElementById('user-btn');
const userPanel = document.getElementById('user-panel');
userBtn.addEventListener('click', e => {
    e.stopPropagation();
    toggleDropdown(userPanel, userBtn);
});

document.addEventListener('click', e => {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-panel').forEach(p => p.classList.remove('open'));
        document.querySelectorAll('.tb-btn, .topbar-user-btn').forEach(b => b.classList.remove('active-btn'));
    }
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.dropdown-panel').forEach(p => p.classList.remove('open'));
        document.querySelectorAll('.tb-btn, .topbar-user-btn').forEach(b => b.classList.remove('active-btn'));
    }
});

/* ═══════════ TOAST ═══════════ */
const TOAST_ICONS = {
    success: '<svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>',
    error:   '<svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>',
};

function showToast(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <span class="toast-icon">${TOAST_ICONS[type] || TOAST_ICONS.success}</span>
        <span class="toast-text">${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">×</button>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity .3s, transform .3s';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

/* ═══════════ SESSION TOAST ═══════════ */
@if (session('success'))
    showToast(@json(session('success')), 'success');
@endif
@if (session('error'))
    showToast(@json(session('error')), 'error');
@endif

/* ═══════════ KEYBOARD SHORTCUT ═══════════ */
document.addEventListener('keydown', e => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('topbar-search-input')?.focus();
    }
});

/* Init */
updateBadges();
renderNotifications();

/* ═══════════ MOBILE: SWIPE-TO-CLOSE SIDEBAR ═══════════ */
let touchStartX = 0;
let touchEndX = 0;
sidebar?.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
}, { passive: true });
sidebar?.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    if (touchStartX - touchEndX > 60 && isMobile()) closeSidebar();
}, { passive: true });

/* Auto-close sidebar saat klik nav-item (mobile only) */
document.querySelectorAll('.sidebar .nav-item').forEach(item => {
    item.addEventListener('click', () => {
        if (isMobile() && item.tagName === 'A') setTimeout(closeSidebar, 150);
    });
});

function updateSidebarLive() {
    fetch('/admin/analytics/realtime')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('sidebar-live-badge');
            if (!badge) return;
            if (data.active_users > 0) {
                badge.textContent = '● ' + data.active_users;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(() => {});
}

@auth
    updateSidebarLive();
    setInterval(updateSidebarLive, 30000);
@endauth
</script>

@stack('scripts')

</body>
</html>

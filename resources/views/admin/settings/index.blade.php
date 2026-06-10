{{-- resources/views/admin/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Pengaturan')

@section('content')

<div class="admin-page-header">
    <div>
        <h1 class="ph-title">Pengaturan</h1>
        <p class="ph-sub">Kelola informasi situs, operasional booking, dan profil akun admin Anda.</p>
    </div>
</div>

<div class="settings-layout">
    <nav class="settings-nav" aria-label="Bagian pengaturan">
        <a href="#umum" class="settings-nav-item">Umum</a>
        <a href="#kontak" class="settings-nav-item">Kontak</a>
        <a href="#operasional" class="settings-nav-item">Operasional</a>
        <a href="#profil" class="settings-nav-item">Profil Akun</a>
        <a href="#tautan" class="settings-nav-item">Tautan Cepat</a>
    </nav>

    <div class="settings-panels">

        {{-- UMUM --}}
        <section id="umum" class="card settings-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Umum</div>
                    <div class="card-sub">Nama dan identitas yang ditampilkan di panel admin</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.settings.general') }}" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="site_name">Nama Situs</label>
                    <input type="text" id="site_name" name="site_name" class="form-control"
                           value="{{ old('site_name', $settings['site_name']) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="site_tagline">Tagline / Subjudul</label>
                    <input type="text" id="site_tagline" name="site_tagline" class="form-control"
                           value="{{ old('site_tagline', $settings['site_tagline']) }}"
                           placeholder="Contoh: SAU Bandung">
                </div>
                <div class="settings-form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Umum</button>
                </div>
            </form>
        </section>

        {{-- KONTAK --}}
        <section id="kontak" class="card settings-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Kontak & Lokasi</div>
                    <div class="card-sub">Digunakan di halaman kontak website publik</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.settings.contact') }}" class="settings-form">
                @csrf
                @method('PUT')
                <div class="settings-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="contact_phone">Telepon (tampilan)</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="form-control"
                               value="{{ old('contact_phone', $settings['contact_phone']) }}" required
                               placeholder="0821-8282-1200">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="whatsapp_number">WhatsApp (angka saja)</label>
                        <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control"
                               value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}" required
                               placeholder="6282182821200" pattern="[0-9]+" inputmode="numeric">
                        <p class="form-hint">Tanpa + atau spasi, untuk link wa.me</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="contact_email">Email</label>
                    <input type="email" id="contact_email" name="contact_email" class="form-control"
                           value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Alamat</label>
                    <textarea id="address" name="address" class="form-control" rows="4" required>{{ old('address', $settings['address']) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="opening_hours">Jam Operasional</label>
                    <input type="text" id="opening_hours" name="opening_hours" class="form-control"
                           value="{{ old('opening_hours', $settings['opening_hours']) }}"
                           placeholder="08:00 - 17:00 WIB">
                </div>
                <div class="settings-form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Kontak</button>
                </div>
            </form>
        </section>

        {{-- OPERASIONAL --}}
        <section id="operasional" class="card settings-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Operasional Booking</div>
                    <div class="card-sub">Kapasitas default jadwal dan status layanan tiket</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.settings.operational') }}" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="default_capacity">Kapasitas Default per Sesi</label>
                    <input type="number" id="default_capacity" name="default_capacity" class="form-control"
                           min="1" max="9999"
                           value="{{ old('default_capacity', $settings['default_capacity']) }}" required>
                    <p class="form-hint">Sama dengan pengaturan di halaman Jadwal Pertunjukan</p>
                </div>

                <div class="settings-toggles">
                    <label class="settings-toggle">
                        <input type="hidden" name="booking_enabled" value="0">
                        <input type="checkbox" name="booking_enabled" value="1"
                               {{ old('booking_enabled', $settings['booking_enabled']) ? 'checked' : '' }}>
                        <span class="settings-toggle-ui"></span>
                        <span class="settings-toggle-text">
                            <strong>Booking tiket aktif</strong>
                            <small>Nonaktifkan untuk menutup sementara pemesanan online</small>
                        </span>
                    </label>

                    <label class="settings-toggle">
                        <input type="hidden" name="maintenance_mode" value="0">
                        <input type="checkbox" name="maintenance_mode" value="1"
                               {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}>
                        <span class="settings-toggle-ui"></span>
                        <span class="settings-toggle-text">
                            <strong>Mode pemeliharaan</strong>
                            <small>Tandai saat situs dalam perawatan (flag untuk pengembangan)</small>
                        </span>
                    </label>
                </div>

                <div class="settings-form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Operasional</button>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline">Kelola Jadwal</a>
                </div>
            </form>
        </section>

        {{-- PROFIL --}}
        <section id="profil" class="card settings-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Profil Akun</div>
                    <div class="card-sub">Perbarui nama, email, dan kata sandi Anda ({{ $user->email }})</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.settings.profile') }}" class="settings-form">
                @csrf
                @method('PUT')
                <div class="settings-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Login</label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
                <div class="settings-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="password">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" class="form-control"
                               autocomplete="new-password" placeholder="Kosongkan jika tidak diubah">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" autocomplete="new-password">
                    </div>
                </div>
                <div class="settings-form-actions">
                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                </div>
            </form>
        </section>

        {{-- TAUTAN CEPAT --}}
        <section id="tautan" class="card settings-card">
            <div class="card-header">
                <div>
                    <div class="card-title">Tautan Cepat</div>
                    <div class="card-sub">Akses fitur admin terkait lainnya</div>
                </div>
            </div>
            <div class="settings-quick-links">
                <a href="{{ route('admin.users.index') }}" class="settings-quick-link">
                    <span>Manajemen User</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="settings-quick-link">
                    <span>Laporan Keuangan</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.analytics') }}" class="settings-quick-link">
                    <span>Analytics</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('admin.analytics.clear-cache') }}" class="settings-quick-link"
                   data-no-loader onclick="return confirm('Bersihkan cache analytics?')">
                    <span>Bersihkan Cache Analytics</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="settings-quick-link">
                    <span>Lihat Website Publik</span>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </section>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.settings-nav-item').forEach(link => {
    link.addEventListener('click', e => {
        const id = link.getAttribute('href');
        if (!id?.startsWith('#')) return;
        const el = document.querySelector(id);
        if (!el) return;
        e.preventDefault();
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', id);
    });
});
if (location.hash) {
    const target = document.querySelector(location.hash);
    if (target) setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
}
</script>
@endpush

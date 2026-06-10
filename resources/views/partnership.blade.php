@extends('layouts.app')

@section('title', 'Partnership – Tourism & Travel Fair')

@push('styles')
<style>
body {
    background-color: #f5efe6;
}

main, section {
    background-color: #f5efe6;
}
    .hero-partnership {
         background: linear-gradient(135deg, rgba(26, 20, 69, 0.85) 0%, rgba(45, 31, 110, 0.80) 50%, rgba(26, 20, 69, 0.85) 100%),
                url("{{ asset('img/Angklungmasal.webp') }}") center/cover no-repeat;
        min-height: 420px;
        position: relative;
        overflow: hidden;
        
    }

    .hero-partnership::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c4a47c' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-partnership::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 80px;
        background:#f5efe6;
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    .form-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 30px 80px rgba(26, 20, 69, 0.12);
        border: 1px solid rgba(196, 164, 124, 0.15);
    }

    /* ── Partner Offer Banner ── */
    .partner-banner {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(26, 20, 69, 0.18);
        margin-bottom: 32px;
        border: 2px solid rgba(196, 164, 124, 0.25);
    }

  .partner-banner img {
    width: 100%;
    display: block;
    object-fit: cover;
    /* Hapus max-height dan object-position */
}

    .field-group label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #1a1445;
        display: block;
        margin-bottom: 8px;
    }

    .field-group input,
    .field-group textarea,
    .field-group select {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 14px;
        color: #1a1445;
        background: #fafafa;
        transition: all 0.25s ease;
        outline: none;
        font-family: 'Inter', sans-serif;
    }

    .field-group input:focus,
    .field-group textarea:focus,
    .field-group select:focus {
        border-color: #c4a47c;
        background: white;
        box-shadow: 0 0 0 4px rgba(196, 164, 124, 0.12);
    }

    .field-group input.error,
    .field-group textarea.error,
    .field-group select.error {
        border-color: #ef4444;
        background: #fff5f5;
    }

    .radio-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 18px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fafafa;
    }

    .radio-card:has(input:checked) {
        border-color: #c4a47c;
        background: rgba(196, 164, 124, 0.06);
    }

    .radio-card input[type="radio"] {
        accent-color: #c4a47c;
        width: 16px;
        height: 16px;
    }

    .checkbox-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fafafa;
    }

    .checkbox-card:has(input:checked) {
        border-color: #c4a47c;
        background: rgba(196, 164, 124, 0.06);
    }

    .checkbox-card input[type="checkbox"] {
        accent-color: #c4a47c;
        width: 15px;
        height: 15px;
    }

    /* ── SVG ikon di checkbox ── */
    .cbx-icon {
        width: 18px;
        height: 18px;
        color: #c4a47c;
        flex-shrink: 0;
    }

    .submit-btn {
        background: #1a1445;
        color: white;
        border: none;
        padding: 18px 48px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 4px;
        width: 100%;
    }

    .submit-btn:hover {
        background: #c4a47c;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(196, 164, 124, 0.3);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .divider-gold {
        height: 2px;
        background: linear-gradient(90deg, transparent, #c4a47c, transparent);
        margin: 32px 0;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(196, 164, 124, 0.1);
        border: 1px solid rgba(196, 164, 124, 0.3);
        color: #c4a47c;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 100px;
        margin-bottom: 16px;
    }

    .conditional-field {
        display: none;
        margin-top: 12px;
    }

    .conditional-field.show {
        display: block;
    }

    /* ── Info Section (Kenapa SAU + Rate) ── */
    .info-section {
        background: #f9f7f4;
        border: 1px solid rgba(196, 164, 124, 0.25);
        border-radius: 20px;
        padding: 28px 28px 24px;
        margin-bottom: 28px;
    }

    .info-block-title {
        font-size: 15px;
        font-weight: 800;
        color: #1a1445;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-check {
        width: 32px;
        height: 32px;
        background: #16a34a;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        font-size: 13px;
        color: #4b5563;
        padding: 4px 0 4px 16px;
        position: relative;
        line-height: 1.55;
    }

    .info-list li::before {
        content: '•';
        position: absolute;
        left: 2px;
        color: #c4a47c;
        font-weight: 900;
    }

    .badge-green {
        display: inline-block;
        background: #16a34a;
        color: white;
        font-size: 12px;
        font-weight: 700;
        padding: 10px 14px;
        border-radius: 10px;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
    }

    .badge-discount {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #111827;
        border: 2.5px solid #ef4444;
        border-radius: 10px;
        padding: 10px 20px;
        color: #ef4444;
        font-weight: 900;
        line-height: 1.15;
        text-align: center;
        min-width: 100px;
    }

    .badge-discount .d-special   { font-size: 10px; letter-spacing: 0.12em; }
    .badge-discount .d-discount  { font-size: 10px; letter-spacing: 0.08em; }
    .badge-discount .d-pct       { font-size: 32px; letter-spacing: -0.02em; }
    .badge-discount .d-off       { font-size: 10px; letter-spacing: 0.15em; }
</style>
@endpush

@section('content')

{{-- ══ HERO ══ --}}
<section class="hero-partnership flex items-center justify-center pt-28 pb-24 relative">
    <div class="relative z-10 text-center px-6">
        <div class="section-badge">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
            </svg>
            Tourism & Travel Fair
        </div>
        <h1 class="font-editorial text-4xl md:text-5xl text-white mb-4 leading-tight">
            Partnership <span>Registration</span>
        </h1>
        <p class="text-white/60 text-sm max-w-md mx-auto leading-relaxed">
            Daftarkan agen perjalanan atau grup wisata Anda sebagai mitra resmi Saung Angklung Udjo.
        </p>
    </div>
</section>

{{-- ══ FORM SECTION ══ --}}
<section class="py-20 px-6" style="background:f5efe6;">
    <div class="max-w-2xl mx-auto">

           

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-8 p-5 rounded-2xl bg-green-50 border border-green-200 flex items-start gap-4">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-green-800 text-sm">Pendaftaran Berhasil!</p>
                <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="form-card p-8 md:p-12">

            {{-- Header --}}
            <div class="mb-10">
                <p class="text-[10px] font-bold tracking-[0.3em] uppercase text-amber-500 mb-3">Formulir Kemitraan</p>
                <h2 class="font-editorial text-2xl text-[#1a1445] mb-3">Data Tour & Travel</h2>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Lengkapi formulir berikut untuk mendaftarkan kemitraan Anda bersama Saung Angklung Udjo.
                </p>
            </div>

            <div class="divider-gold"></div>

            <form action="{{ route('partnership.store') }}" method="POST" id="partnershipForm">
                @csrf

                {{-- Honeypot field to prevent spam bots --}}
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="company_name_verification" tabindex="-1" autocomplete="off">
                </div>

                <div class="space-y-6">

                    {{-- 1. Nama Tour & Travel / Grup --}}
                    <div class="field-group">
                        <label>1. Nama Tour & Travel / Grup <span class="text-red-500">*</span></label>
                        <input type="text"
                            name="nama_travel"
                            placeholder="Contoh: PT. Wisata Nusantara / Grup Alumni SMA 3"
                            value="{{ old('nama_travel') }}"
                            class="{{ $errors->has('nama_travel') ? 'error' : '' }}"
                            required>
                        @error('nama_travel')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. Nama PIC --}}
                    <div class="field-group">
                        <label>2. Nama (Contact Person) <span class="text-red-500">*</span></label>
                        <input type="text"
                            name="nama_pic"
                            placeholder="Nama lengkap penanggung jawab"
                            value="{{ old('nama_pic') }}"
                            class="{{ $errors->has('nama_pic') ? 'error' : '' }}"
                            required>
                        @error('nama_pic')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. Alamat / Domisili --}}
                    <div class="field-group">
                        <label>3. Alamat / Domisili Travel <span class="text-red-500">*</span></label>
                        <textarea name="alamat"
                            rows="3"
                            placeholder="Alamat lengkap kantor atau domisili travel"
                            class="{{ $errors->has('alamat') ? 'error' : '' }}"
                            required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 4. No WA Aktif --}}
                    <div class="field-group">
                        <label>4. No. WhatsApp Aktif <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold pointer-events-none" style="color:#1a1445; opacity:0.5;">+62</span>
                            <input type="tel"
                                name="no_wa"
                                placeholder="812 3456 7890"
                                value="{{ old('no_wa') }}"
                                class="{{ $errors->has('no_wa') ? 'error' : '' }}"
                                style="padding-left: 52px;"
                                required>
                        </div>
                        @error('no_wa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 5. Sudah Pernah Kunjungan --}}
                    <div class="field-group">
                        <label>5. Sudah Pernah Kunjungan ke Saung Angklung Udjo? <span class="text-red-500">*</span></label>
                        <div class="space-y-3">

                            {{-- Pernah --}}
                            <label class="radio-card flex items-start gap-3">
                                <input type="radio" name="status_kunjungan" value="pernah"
                                    class="mt-0.5" onchange="toggleKunjungan(this)"
                                    {{ old('status_kunjungan') === 'pernah' ? 'checked' : '' }}>
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-[#1a1445]">Pernah</span>
                                    {{-- Conditional: kapan terakhir (hanya muncul jika pilih Pernah) --}}
                                    <div id="field-pernah" class="conditional-field {{ old('status_kunjungan') === 'pernah' ? 'show' : '' }}">
                                        <input type="text" name="kapan_pernah"
                                            placeholder="Kapan terakhir berkunjung? (opsional)"
                                            value="{{ old('kapan_pernah') }}">
                                    </div>
                                </div>
                            </label>

                            {{-- Belum – tanpa textfield sama sekali --}}
                            <label class="radio-card flex items-center gap-3">
                                <input type="radio" name="status_kunjungan" value="belum"
                                    class="mt-0.5" onchange="toggleKunjungan(this)"
                                    {{ old('status_kunjungan') === 'belum' ? 'checked' : '' }}>
                                <span class="text-sm font-semibold text-[#1a1445]">Belum</span>
                            </label>

                        </div>
                        @error('status_kunjungan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 6. Sumber Info --}}
                    <div class="field-group">
                        <label>6. Tahu Info tentang SAU dari mana? <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-400 mb-3">(Bisa pilih lebih dari satu)</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            {{-- Travel Fair --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="travel_fair"
                                    {{ in_array('travel_fair', old('sumber_info', [])) ? 'checked' : '' }}>
                                {{-- ikon kalender / event --}}
                                <svg class="cbx-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Travel Fair</span>
                            </label>

                            {{-- Sosial Media --}}
                            {{-- Instagram --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="instagram"
                                    {{ in_array('instagram', old('sumber_info', [])) ? 'checked' : '' }}>
                                <svg class="cbx-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Instagram</span>
                            </label>

                            {{-- TikTok --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="tiktok"
                                    {{ in_array('tiktok', old('sumber_info', [])) ? 'checked' : '' }}>
                                <svg class="cbx-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.19 8.19 0 004.79 1.54V6.78a4.85 4.85 0 01-1.02-.09z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">TikTok</span>
                            </label>

                            {{-- YouTube --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="youtube"
                                    {{ in_array('youtube', old('sumber_info', [])) ? 'checked' : '' }}>
                                <svg class="cbx-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">YouTube</span>
                            </label>

                            {{-- Facebook --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="facebook"
                                    {{ in_array('facebook', old('sumber_info', [])) ? 'checked' : '' }}>
                                <svg class="cbx-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Facebook</span>
                            </label>

                            {{-- Website --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="website"
                                    {{ in_array('website', old('sumber_info', [])) ? 'checked' : '' }}>
                                <svg class="cbx-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Website</span>
                            </label>

                            {{-- Kerabat / Rekomendasi --}}
                            <label class="checkbox-card flex items-center gap-3">
                                <input type="checkbox" name="sumber_info[]" value="kerabat"
                                    {{ in_array('kerabat', old('sumber_info', [])) ? 'checked' : '' }}>
                                {{-- ikon orang --}}
                                <svg class="cbx-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Kerabat / Rekomendasi</span>
                            </label>

                            {{-- Lainnya --}}
                            <label class="checkbox-card flex items-center gap-3" id="lainnya-card">
                                <input type="checkbox" name="sumber_info[]" value="lainnya"
                                    onchange="toggleLainnya(this)"
                                    {{ in_array('lainnya', old('sumber_info', [])) ? 'checked' : '' }}>
                                {{-- ikon pensil --}}
                                <svg class="cbx-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                <span class="text-sm font-medium text-[#1a1445]">Lainnya</span>
                            </label>

                        </div>

                        {{-- Lainnya input --}}
                        <div id="field-lainnya" class="conditional-field mt-3 {{ in_array('lainnya', old('sumber_info', [])) ? 'show' : '' }}">
                            <input type="text"
                                name="sumber_info_lainnya"
                                placeholder="Sebutkan sumber informasi lainnya..."
                                value="{{ old('sumber_info_lainnya') }}">
                        </div>

                        @error('sumber_info')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="divider-gold"></div>

                {{-- Submit --}}
                <div>
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span id="btnText">Kirim Pendaftaran</span>
                        <span id="btnLoading" class="hidden">Mengirim...</span>
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4">
                        Data Anda akan tersimpan dan tim kami akan menghubungi dalam 1×24 jam.
                    </p>
                </div>

            </form>
        </div>

        {{-- Info Card --}}
        <div class="mt-8 p-6 rounded-2xl bg-[#1a1445]/5 border border-[#1a1445]/10">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-500/10 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-[#1a1445] text-sm mb-1">Butuh informasi lebih lanjut?</p>
                    <p class="text-sm text-gray-500">Hubungi tim kami langsung via WhatsApp</p>
                    <a href="https://wa.me/6282182821200"
                        target="_blank"
                        class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-green-600 hover:text-green-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        +62 821 8282 1200
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    function toggleKunjungan(radio) {
        // Selalu sembunyikan dulu kedua field
        document.getElementById('field-pernah').classList.remove('show');

        // Hanya tampilkan field jika pilih "pernah"
        if (radio.value === 'pernah') {
            document.getElementById('field-pernah').classList.add('show');
        }
        // Jika pilih "belum" → tidak ada field yang muncul
    }

    function toggleLainnya(checkbox) {
        const field = document.getElementById('field-lainnya');
        field.classList.toggle('show', checkbox.checked);
        if (!checkbox.checked) {
            field.querySelector('input').value = '';
        }
    }

    // Submit loader
    document.getElementById('partnershipForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        document.getElementById('btnText').classList.add('hidden');
        document.getElementById('btnLoading').classList.remove('hidden');
        btn.disabled = true;
    });
</script>
@endpush
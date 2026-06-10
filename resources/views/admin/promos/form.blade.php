@extends('admin.layouts.app')
@section('title', isset($promo->id) ? 'Edit Promo' : 'Tambah Promo')

@push('styles')
<style>
/* ── Base ── */
.fc-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #f0eff4;
    padding: 24px;
    margin-bottom: 16px;
}
.fc-section-title {
    font-size: 11px;
    font-weight: 800;
    color: #1a1445;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin: 0 0 20px;
    padding-bottom: 12px;
    border-bottom: 1.5px solid #f0eff4;
}

/* ── Form Fields ── */
.fc-group { margin-bottom: 16px; }
.fc-group:last-child { margin-bottom: 0; }
.fc-label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
}
.fc-label .req { color: #e53e3e; margin-left: 2px; }
.fc-label .opt {
    font-weight: 400;
    text-transform: none;
    letter-spacing: 0;
    color: #9ca3af;
    font-size: 11px;
}
.fc-input,
.fc-select,
.fc-textarea {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    padding: 9px 13px;
    font-size: 13.5px;
    color: #1f2937;
    background: #fff;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
}
.fc-input:focus,
.fc-select:focus,
.fc-textarea:focus {
    border-color: #1a1445;
    box-shadow: 0 0 0 3px rgba(26,20,69,0.07);
}
.fc-input.error,
.fc-select.error { border-color: #f87171; }
.fc-textarea { resize: vertical; min-height: 88px; line-height: 1.5; }
.fc-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; cursor: pointer; }
.fc-hint { font-size: 11.5px; color: #9ca3af; margin-top: 5px; }
.fc-error { font-size: 11.5px; color: #dc2626; margin-top: 5px; font-weight: 500; }

/* ── Input with prefix ── */
.fc-input-wrap { position: relative; }
.fc-prefix {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12.5px;
    font-weight: 600;
    color: #9ca3af;
    pointer-events: none;
    user-select: none;
}
.fc-input-wrap .fc-input { padding-left: 30px; }
.fc-input-wrap.rp .fc-input { padding-left: 34px; }

/* ── Grid helpers ── */
.fc-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* ── Toggle Switch ── */
.fc-toggle-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: #f9f9fb;
    border-radius: 10px;
    border: 1.5px solid #efefef;
    cursor: pointer;
    user-select: none;
    transition: border-color 0.15s;
}
.fc-toggle-wrap:hover { border-color: #d1d5db; }
.fc-toggle-input { display: none; }
.fc-toggle-track {
    width: 40px;
    height: 22px;
    border-radius: 11px;
    background: #d1d5db;
    position: relative;
    flex-shrink: 0;
    transition: background 0.2s;
}
.fc-toggle-thumb {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #fff;
    position: absolute;
    top: 3px;
    left: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.18);
    transition: transform 0.2s;
}
.fc-toggle-input:checked ~ .fc-toggle-track { background: #22c55e; }
.fc-toggle-input:checked ~ .fc-toggle-track .fc-toggle-thumb { transform: translateX(18px); }
.fc-toggle-text { font-size: 13.5px; font-weight: 600; color: #374151; }
.fc-toggle-sub { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

/* ── Upload area ── */
.fc-upload-zone {
    border: 1.5px dashed #d1d5db;
    border-radius: 10px;
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.15s, background 0.15s;
}
.fc-upload-zone:hover { border-color: #a5b4fc; background: #f5f3ff; }
.fc-upload-zone.dragover { border-color: #6366f1; background: #eef2ff; }
.fc-upload-icon { width: 28px; height: 28px; color: #d1d5db; margin: 0 auto 10px; display: block; }
.fc-upload-text { font-size: 13px; font-weight: 600; color: #374151; }
.fc-upload-sub { font-size: 11.5px; color: #9ca3af; margin-top: 3px; }
.fc-upload-name { font-size: 12px; color: #6366f1; font-weight: 600; margin-top: 6px; }
.fc-banner-preview {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
    display: block;
    border: 1px solid #f0eff4;
}

/* ── Checkbox items ── */
.fc-check-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.12s;
    margin-bottom: 4px;
}
.fc-check-item:last-child { margin-bottom: 0; }
.fc-check-item:hover { background: #f9f9fb; }
.fc-check-input { display: none; }
.fc-check-box {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    border: 1.5px solid #d1d5db;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, border-color 0.15s;
    background: #fff;
}
.fc-check-box svg { display: none; }
.fc-check-input:checked ~ .fc-check-box {
    background: #1a1445;
    border-color: #1a1445;
}
.fc-check-input:checked ~ .fc-check-box svg { display: block; }
.fc-check-label { font-size: 13px; color: #374151; font-weight: 500; }

/* ── ✅ NEW: Day pill buttons ── */
.day-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 4px;
}
.day-pill-input { display: none; }
.day-pill-label {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s;
    background: #f9f9fb;
    user-select: none;
}
.day-pill-label:hover {
    border-color: #1a1445;
    color: #1a1445;
    background: #f0effe;
}
.day-pill-input:checked + .day-pill-label {
    background: #1a1445;
    border-color: #1a1445;
    color: #fff;
    box-shadow: 0 2px 6px rgba(26,20,69,0.25);
}
/* Weekend highlight */
.day-pill-input[data-weekend] + .day-pill-label {
    border-color: #e5e7eb;
    color: #d97706;
    background: #f9f9fb;
}
.day-pill-input[data-weekend]:checked + .day-pill-label {
    background: #d97706;
    border-color: #d97706;
    color: #fff;
    box-shadow: 0 2px 6px rgba(217,119,6,0.25);
}
.day-all-hint {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 8px;
    padding: 6px 10px;
    background: #f9f9fb;
    border-radius: 7px;
    border: 1px solid #f0eff4;
}
.day-all-hint.active-days {
    color: #1a1445;
    background: #f0effe;
    border-color: #c7d2fe;
    font-weight: 600;
}

/* ── Buttons ── */
.fc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid transparent;
    transition: background 0.15s, border-color 0.15s, box-shadow 0.15s;
    text-decoration: none;
    line-height: 1;
}
.fc-btn-primary {
    background: #1a1445;
    color: #fff;
    border-color: #1a1445;
}
.fc-btn-primary:hover { background: #2a2460; border-color: #2a2460; }
.fc-btn-ghost {
    background: transparent;
    color: #6b7280;
    border-color: #e5e7eb;
}
.fc-btn-ghost:hover { background: #f9fafb; }
.fc-btn-full { width: 100%; }
</style>
@endpush

@section('content')
<div style="padding: 28px 32px; max-width: 900px; margin: 0 auto;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; gap:14px; margin-bottom:28px;">
        <a href="{{ route('admin.promos.index') }}"
           style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1.5px solid #e5e7eb;color:#6b7280;text-decoration:none;transition:background 0.15s;flex-shrink:0;"
           onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0;">
                {{ isset($promo->id) ? 'Edit Promo' : 'Tambah Promo Baru' }}
            </h1>
            <p style="font-size:12px;color:#9ca3af;margin:3px 0 0;">
                Dashboard › Promo › {{ isset($promo->id) ? $promo->name : 'Baru' }}
            </p>
        </div>
    </div>

    <form method="POST"
          action="{{ isset($promo->id) ? route('admin.promos.update', $promo) : route('admin.promos.store') }}"
          enctype="multipart/form-data"
          id="promo-form">
        @csrf
        @if(isset($promo->id)) @method('PUT') @endif

        <div style="display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

            {{-- ══ LEFT COLUMN ══ --}}
            <div>

                {{-- Informasi Promo --}}
                <div class="fc-card">
                    <p class="fc-section-title">Informasi Promo</p>

                    <div class="fc-group">
                        <label class="fc-label">Nama Promo <span class="req">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name', $promo->name ?? '') }}"
                               placeholder="Contoh: Promo Lebaran 50% Off"
                               class="fc-input {{ $errors->has('name') ? 'error' : '' }}">
                        @error('name') <p class="fc-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="fc-grid-2">
                        <div class="fc-group">
                            <label class="fc-label">Tipe Promo <span class="req">*</span></label>
                            <select name="type" class="fc-select {{ $errors->has('type') ? 'error' : '' }}">
                                @foreach(['voucher' => 'Voucher Diskon', 'b1g1' => 'Buy 1 Get 1', 'early_bird' => 'Early Bird', 'bundling' => 'Paket Bundling', 'other' => 'Lainnya'] as $val => $label)
                                    <option value="{{ $val }}" @selected(old('type', $promo->type ?? '') == $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type') <p class="fc-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="fc-group">
                            <label class="fc-label">Kode Voucher <span class="opt">(opsional)</span></label>
                            <input type="text" name="code"
                                   value="{{ old('code', $promo->code ?? '') }}"
                                   placeholder="Contoh: LEBARAN50"
                                   class="fc-input {{ $errors->has('code') ? 'error' : '' }}"
                                   style="font-family: monospace; letter-spacing: 0.05em;">
                            @error('code') <p class="fc-error">{{ $message }}</p> @enderror
                            <p class="fc-hint">Kosongkan untuk generate otomatis</p>
                        </div>
                    </div>

                    <div class="fc-group">
                        <label class="fc-label">Deskripsi <span class="opt">(opsional)</span></label>
                        <textarea name="description"
                                  placeholder="Deskripsi singkat tentang promo ini..."
                                  class="fc-textarea">{{ old('description', $promo->description ?? '') }}</textarea>
                    </div>
                </div>


                {{-- Konfigurasi Diskon --}}
                <div class="fc-card">
                    <p class="fc-section-title">Konfigurasi Diskon</p>

                    <div class="fc-grid-2">
                        <div class="fc-group">
                            <label class="fc-label">Tipe Diskon <span class="req">*</span></label>
                            <select name="discount_type" id="discountType" class="fc-select" onchange="toggleDiscountType()">
                                <option value="percent" @selected(old('discount_type', $promo->discount_type ?? 'percent') == 'percent')>Persen (%)</option>
                                <option value="fixed"   @selected(old('discount_type', $promo->discount_type ?? '') == 'fixed')>Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="fc-group">
                            <label class="fc-label">Nilai Diskon <span class="req">*</span></label>
                            <div class="fc-input-wrap">
                                <span class="fc-prefix" id="discountPrefix">%</span>
                                <input type="number" name="discount_value"
                                       value="{{ old('discount_value', $promo->discount_value ?? 0) }}"
                                       min="0" step="0.01"
                                       class="fc-input {{ $errors->has('discount_value') ? 'error' : '' }}">
                            </div>
                            @error('discount_value') <p class="fc-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="fc-grid-2">
                        <div class="fc-group">
                            <label class="fc-label">Minimum Pembelian</label>
                            <div class="fc-input-wrap rp">
                                <span class="fc-prefix">Rp</span>
                                <input type="number" name="min_purchase"
                                       value="{{ old('min_purchase', $promo->min_purchase ?? 0) }}"
                                       min="0" class="fc-input">
                            </div>
                        </div>
                        <div class="fc-group" id="maxDiscountField">
                            <label class="fc-label">Maks. Diskon <span class="opt">(opsional)</span></label>
                            <div class="fc-input-wrap rp">
                                <span class="fc-prefix">Rp</span>
                                <input type="number" name="max_discount"
                                       value="{{ old('max_discount', $promo->max_discount ?? '') }}"
                                       min="0" placeholder="Unlimited" class="fc-input">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Periode & Kuota --}}
                <div class="fc-card">
                    <p class="fc-section-title">Periode & Kuota</p>

                    <div class="fc-grid-2">
                        <div class="fc-group">
                            <label class="fc-label">Mulai Berlaku <span class="req">*</span></label>
                            <input type="date" name="start_date"
                                   value="{{ old('start_date', isset($promo->start_date) ? $promo->start_date->format('Y-m-d') : '') }}"
                                   class="fc-input {{ $errors->has('start_date') ? 'error' : '' }}">
                            @error('start_date') <p class="fc-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="fc-group">
                            <label class="fc-label">Berakhir <span class="req">*</span></label>
                            <input type="date" name="end_date"
                                   value="{{ old('end_date', isset($promo->end_date) ? $promo->end_date->format('Y-m-d') : '') }}"
                                   class="fc-input {{ $errors->has('end_date') ? 'error' : '' }}">
                            @error('end_date') <p class="fc-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="fc-group">
                        <label class="fc-label">Kuota Penggunaan <span class="opt">(opsional)</span></label>
                        <input type="number" name="quota"
                               value="{{ old('quota', $promo->quota ?? '') }}"
                               min="1" placeholder="Biarkan kosong untuk unlimited"
                               class="fc-input {{ $errors->has('quota') ? 'error' : '' }}">
                        <p class="fc-hint">Kosongkan jika tidak ada batas penggunaan</p>
                        @error('quota') <p class="fc-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="fc-group">
                        <label class="fc-label">Hanya Berlaku di Tanggal Tertentu <span class="opt">(opsional)</span></label>
                        <input type="text" name="specific_dates[]" id="specific_dates_picker" 
                               class="fc-input datepicker-multiple" placeholder="Pilih tanggal...">
                        <p class="fc-hint">Kosongkan jika ingin berlaku setiap hari selama periode promo.</p>
                    </div>


                    {{-- ✅ BARU: Jam Kunjungan yang Diizinkan --}}
                    <div class="fc-group" style="margin-top: 1.5rem; border-top: 1px solid var(--gray-soft); padding-top: 1.5rem;">
                        <label class="fc-label" style="margin-bottom: 2px;">
                            Jam Kunjungan yang Diizinkan
                            <span class="opt">(kosongkan = sepanjang hari)</span>
                        </label>
                        <p class="fc-hint" style="margin-bottom: 12px; margin-top: 2px;">Batasi jam pertunjukan/sesi kunjungan yang mendapatkan promo ini</p>
                        
                        @php
                            $start = old('allowed_time_start', $promo->allowed_time_start ?? '');
                            $end = old('allowed_time_end', $promo->allowed_time_end ?? '');
                            // normalize seconds if exists (e.g. 10:00:00 -> 10:00)
                            $start = substr($start, 0, 5);
                            $end = substr($end, 0, 5);
                            $currentTimeSlot = $start && $end ? $start . '-' . $end : '';
                        @endphp
                        <div>
                            <select id="time_slot_selector" class="fc-select" onchange="updateTimeSlots()">
                                <option value="">Sepanjang Hari (Tidak Dibatasi Jam)</option>
                                <option value="10:00-11:30" @selected($currentTimeSlot == '10:00-11:30')>Sesi 1: 10.00 - 11.30</option>
                                <option value="13:00-14:30" @selected($currentTimeSlot == '13:00-14:30')>Sesi 2: 13.00 - 14.30</option>
                                <option value="15:30-17:00" @selected($currentTimeSlot == '15:30-17:00')>Sesi 3: 15.30 - 17.00</option>
                                <option value="18:30-20:00" @selected($currentTimeSlot == '18:30-20:00')>Sesi 4: 18.30 - 20.00</option>
                            </select>
                            <input type="hidden" name="allowed_time_start" id="allowed_time_start" value="{{ $start }}">
                            <input type="hidden" name="allowed_time_end" id="allowed_time_end" value="{{ $end }}">
                        </div>
                        <p class="fc-hint" style="margin-top: 8px;">Contoh: Mulai <b>10:00</b> s/d Selesai <b>12:00</b> (Promo hanya bisa digunakan pada pertunjukan Sesi Pagi 10.00 WIB)</p>
                    </div>

                </div>

            </div>

            {{-- ══ RIGHT SIDEBAR ══ --}}
            <div>

                {{-- Status Toggle --}}
                <div class="fc-card">
                    <p class="fc-section-title">Status Promo</p>
                    <label class="fc-toggle-wrap">
                        <input type="checkbox" name="is_active" value="1"
                               id="toggleActive" class="fc-toggle-input"
                               @checked(old('is_active', $promo->is_active ?? true))>
                        <div class="fc-toggle-track">
                            <div class="fc-toggle-thumb"></div>
                        </div>
                        <div>
                            <div class="fc-toggle-text" id="toggleLabel">
                                {{ old('is_active', $promo->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                            </div>
                            <div class="fc-toggle-sub">Tampil ke pengunjung</div>
                        </div>
                    </label>
                </div>

                {{-- Banner Upload --}}
                <div class="fc-card">
                    <p class="fc-section-title">Banner Promo</p>

                    @if(isset($promo->banner_image) && $promo->banner_image)
                        <img src="{{ asset('storage/' . $promo->banner_image) }}"
                             alt="Banner saat ini" class="fc-banner-preview" id="bannerPreview">
                    @else
                        <img src="" alt="" class="fc-banner-preview" id="bannerPreview" style="display:none;">
                    @endif

                    <div class="fc-upload-zone" id="uploadZone"
                         onclick="document.getElementById('bannerInput').click()"
                         ondragover="event.preventDefault();this.classList.add('dragover')"
                         ondragleave="this.classList.remove('dragover')"
                         ondrop="handleBannerDrop(event)">
                        <svg class="fc-upload-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        <div class="fc-upload-text">Klik atau drag foto</div>
                        <div class="fc-upload-sub">JPG, PNG, WEBP · maks. 2MB</div>
                        <div class="fc-upload-name" id="bannerFileName"></div>
                        <input type="file" id="bannerInput" name="banner_image"
                               accept="image/*" style="display:none;"
                               onchange="handleBannerChange(this)">
                    </div>
                </div>

                {{-- Berlaku Untuk --}}
                <div class="fc-card">
                    <p class="fc-section-title">Berlaku Untuk</p>
                    @foreach(['Tiket Pertunjukan', 'Souvenir', 'Paket Wisata', 'Semua Produk', 'Sembunyikan dari Halaman'] as $item)
                    <label class="fc-check-item">
                        <input type="checkbox" name="applicable_to[]" value="{{ $item }}"
                               class="fc-check-input"
                               @checked(in_array($item, old('applicable_to', $promo->applicable_to ?? [])))>
                        <div class="fc-check-box">
                            <svg width="10" height="10" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="fc-check-label">{{ $item }}</span>
                    </label>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex; gap:10px;">
                    <a href="{{ route('admin.promos.index') }}" class="fc-btn fc-btn-ghost fc-btn-full">
                        Batal
                    </a>
                    <button type="submit" class="fc-btn fc-btn-primary fc-btn-full">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ isset($promo->id) ? 'Simpan' : 'Buat Promo' }}
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function toggleDiscountType() {
    const type   = document.getElementById('discountType').value;
    const prefix = document.getElementById('discountPrefix');
    const maxEl  = document.getElementById('maxDiscountField');
    prefix.textContent  = type === 'percent' ? '%' : 'Rp';
    maxEl.style.display = type === 'percent' ? 'block' : 'none';
}

function handleBannerChange(input) {
    if (!input.files[0]) return;
    showBannerPreview(input.files[0]);
}

function handleBannerDrop(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('bannerInput').files = dt.files;
        showBannerPreview(file);
    }
}

function showBannerPreview(file) {
    const preview = document.getElementById('bannerPreview');
    const name    = document.getElementById('bannerFileName');
    preview.src   = URL.createObjectURL(file);
    preview.style.display = 'block';
    name.textContent = '✓ ' + file.name;
}

/* ── Toggle label update ── */
const toggleInput = document.getElementById('toggleActive');
const toggleLabel = document.getElementById('toggleLabel');
toggleInput.addEventListener('change', function() {
    toggleLabel.textContent = this.checked ? 'Aktif' : 'Nonaktif';
});

function updateTimeSlots() {
    const val = document.getElementById('time_slot_selector').value;
    if(val) {
        const parts = val.split('-');
        document.getElementById('allowed_time_start').value = parts[0];
        document.getElementById('allowed_time_end').value = parts[1];
    } else {
        document.getElementById('allowed_time_start').value = '';
        document.getElementById('allowed_time_end').value = '';
    }
}

/* Init */
toggleDiscountType();
</script>
@endpush
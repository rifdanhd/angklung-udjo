<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Promo extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'description',
        'discount_type', 'discount_value',
        'min_purchase', 'max_discount',
        'quota', 'used_count',
        'start_date', 'end_date',
        'is_active', 'banner_image', 'applicable_to',
        'allowed_days',        // ✅ BARU: array hari [0=Min..6=Sab]
        'allowed_time_start',  // ✅ BARU: jam mulai "10:00"
        'allowed_time_end',    // ✅ BARU: jam selesai "11:59"
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'is_active'      => 'boolean',
        'applicable_to'  => 'array',
        'allowed_days'   => 'array',   // ✅ BARU
        'discount_value' => 'decimal:2',
        'min_purchase'   => 'decimal:2',
        'max_discount'   => 'decimal:2',
          'specific_dates' => 'array',
        // allowed_time_start & allowed_time_end → string biasa (format H:i)
    ];

    /* ────────────────────────────────────────────
       Relations
    ──────────────────────────────────────────── */
    public function claims(): HasMany
    {
        return $this->hasMany(PromoClaim::class);
    }

    /* ────────────────────────────────────────────
       Scopes
    ──────────────────────────────────────────── */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    /* ────────────────────────────────────────────
       Helpers — existing (tidak diubah)
    ──────────────────────────────────────────── */
    public function isExpired(): bool
    {
        return $this->end_date->isPast();
    }

    public function isQuotaFull(): bool
    {
        return $this->quota !== null && $this->used_count >= $this->quota;
    }

    public function remainingQuota(): ?int
    {
        return $this->quota ? max(0, $this->quota - $this->used_count) : null;
    }

    public function typeLabel(): string
    {
        return match($this->type) {
            'voucher'    => 'Voucher Diskon',
            'b1g1'       => 'Buy 1 Get 1',
            'early_bird' => 'Early Bird',
            'bundling'   => 'Paket Bundling',
            default      => 'Lainnya',
        };
    }

    public function discountLabel(): string
    {
        if ($this->discount_type === 'percent') {
            return $this->discount_value . '%';
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }

    public function statusBadge(): string
    {
        if (!$this->is_active)             return 'nonaktif';
        if ($this->isExpired())            return 'kadaluarsa';
        if ($this->isQuotaFull())          return 'habis';
        if ($this->start_date->isFuture()) return 'belum_mulai';
        return 'aktif';
    }

    /* ────────────────────────────────────────────
       BARU — Validasi Hari
    ──────────────────────────────────────────── */

    /**
     * Cek apakah tanggal kunjungan sesuai hari yang diizinkan promo.
     * allowed_days null/kosong = semua hari boleh.
     *
     * @param  Carbon|string  $date
     */
    public function isAllowedOnDate(Carbon|string $date): bool
    {
        $date = Carbon::parse($date);

        if (empty($this->allowed_days)) {
            return true;
        }

        // dayOfWeek: 0=Minggu, 1=Senin, ..., 6=Sabtu
        return in_array($date->dayOfWeek, $this->allowed_days);
    }

    /**
     * Label hari yang diizinkan untuk pesan error.
     * Contoh: "Sabtu, Minggu" | "Semua Hari"
     */
    public function allowedDaysLabel(): string
    {
        if (empty($this->allowed_days)) {
            return 'Semua Hari';
        }

        $map = [
            0 => 'Minggu', 1 => 'Senin',  2 => 'Selasa',
            3 => 'Rabu',   4 => 'Kamis',  5 => 'Jumat', 6 => 'Sabtu',
        ];

        $sorted = $this->allowed_days;
        sort($sorted);

        return implode(', ', array_map(fn($d) => $map[$d] ?? "Hari-{$d}", $sorted));
    }

    /* ────────────────────────────────────────────
       BARU — Validasi Jam
    ──────────────────────────────────────────── */

    /**
     * Cek apakah jam sekarang masuk rentang allowed_time_start–end.
     * Keduanya null = tidak ada batasan jam, selalu true.
     *
     * Contoh:
     *   allowed_time_start="10:00", allowed_time_end="11:59"
     *   jam 10:30 => true | jam 12:00 => false
     */
  public function isAllowedAtTime(Carbon|string|null $time = null): bool
{
    if (empty($this->allowed_time_start) && empty($this->allowed_time_end)) {
        return true;
    }

    // Jika null, pakai waktu sekarang
    if ($time === null) {
        $currentTime = Carbon::now()->format('H:i');
    } elseif ($time instanceof Carbon) {
        $currentTime = $time->format('H:i');
    } else {
        $currentTime = $time; // sudah string "H:i"
    }

    $start = $this->allowed_time_start ?? '00:00';
    $end   = $this->allowed_time_end   ?? '23:59';

    return $currentTime >= $start && $currentTime <= $end;
}
    /**
     * Label jam yang diizinkan untuk pesan error.
     * Contoh: "10:00 – 11:59 WIB" | "Sepanjang Hari"
     */
    public function allowedTimeLabel(): string
    {
        if (empty($this->allowed_time_start) && empty($this->allowed_time_end)) {
            return 'Sepanjang Hari';
        }

        $start = $this->allowed_time_start ?? '00:00';
        $end   = $this->allowed_time_end   ?? '23:59';

        return "{$start} – {$end} WIB";
    }
}
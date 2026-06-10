<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoKlaim extends Model
{
    protected $fillable = [
        'nama',
        'kota',
        'jumlah_tiket_dewasa',
        'jumlah_tiket_anak',
        'jumlah_tiket_manca_dewasa', // ✅ Baru
        'jumlah_tiket_manca_anak',   // ✅ Baru
        'tanggal_kunjungan',
        'no_hp',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan'         => 'date',
        'total_harga'               => 'integer',
        'jumlah_tiket_dewasa'       => 'integer',
        'jumlah_tiket_anak'         => 'integer',
        'jumlah_tiket_manca_dewasa' => 'integer', // ✅ Baru
        'jumlah_tiket_manca_anak'   => 'integer', // ✅ Baru
    ];

    // ── Total tiket domestik saja ──
    public function getTotalTiketDomestikAttribute(): int
    {
        return $this->jumlah_tiket_dewasa + $this->jumlah_tiket_anak;
    }

    // ── Total tiket mancanegara saja ✅ Baru ──
    public function getTotalTiketMancanegaraAttribute(): int
    {
        return $this->jumlah_tiket_manca_dewasa + $this->jumlah_tiket_manca_anak;
    }

    // ── Total semua tiket (domestik + mancanegara) ✅ Diperbarui ──
    public function getTotalTiketAttribute(): int
    {
        return $this->total_tiket_domestik + $this->total_tiket_mancanegara;
    }

    // ── Apakah rombongan campuran? ✅ Baru ──
    public function getIsCampuranAttribute(): bool
    {
        return $this->total_tiket_domestik > 0 && $this->total_tiket_mancanegara > 0;
    }

    // ── Label status dengan warna (untuk badge di view) ✅ Baru ──
    public function getStatusLabelAttribute(): array
    {
        return match ($this->status) {
            'confirmed' => ['label' => 'Confirmed', 'color' => 'green'],
            'cancelled' => ['label' => 'Cancelled', 'color' => 'red'],
            default     => ['label' => 'Pending',   'color' => 'yellow'],
        };
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable = [
        'nama_travel',
        'nama_pic',
        'alamat',
        'no_wa',
        'status_kunjungan',
        'kapan_pernah',
        'rencana_kunjungan',
        'sumber_info',
        'sumber_info_lainnya',
    ];

    // Helper: sumber_info sebagai array
    public function getSumberInfoArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->sumber_info));
    }

    // Label untuk status kunjungan
    public function getStatusLabelAttribute(): string
    {
        if ($this->status_kunjungan === 'pernah') {
            return 'Pernah' . ($this->kapan_pernah ? ' (' . $this->kapan_pernah . ')' : '');
        }
        return 'Belum' . ($this->rencana_kunjungan ? ' – Rencana: ' . $this->rencana_kunjungan : '');
    }
}
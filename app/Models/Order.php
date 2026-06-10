<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'nama_pemesan',
        'email',
        'no_telepon',
        'tanggal_kunjungan',
        'jumlah_tiket',
        'jumlah_tiket_gratis',
        'total_tiket',
        'harga_per_tiket',
        'total_bayar',
        'status',
        'bukti_bayar',
        'paid_at',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'paid_at' => 'datetime',
    ];

    public static function generateOrderCode(): string
    {
        $date = now()->format('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return 'SUO-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_per_tiket, 0, ',', '.');
    }

    public function getTotalFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_bayar, 0, ',', '.');
    }
}
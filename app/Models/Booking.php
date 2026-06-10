<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama', 'kota', 'no_hp', 'tanggal_kunjungan',
        'jumlah_tiket_dewasa', 'jumlah_tiket_anak',
        'jumlah_tiket_manca_dewasa', 'jumlah_tiket_manca_anak',
        'total_harga', 'status',
    ];

    protected $casts = ['tanggal_kunjungan' => 'date'];
}
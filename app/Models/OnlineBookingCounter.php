<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineBookingCounter extends Model
{
    protected $fillable = ['tanggal', 'total_klik', 'kapasitas', 'is_closed'];
    
    protected $casts = [
        'tanggal'   => 'date',
        'is_closed' => 'boolean',
    ];
}
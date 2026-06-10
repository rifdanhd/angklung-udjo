<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorySlide extends Model
{
    protected $table = 'history_slides';

    protected $fillable = [
        'image_path',
        'alt_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image_path',
        'alt_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope: hanya yang aktif, urut by order
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
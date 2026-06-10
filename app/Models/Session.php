<?php
// app/Models/Session.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    protected $fillable = [
        'session_id', 'name', 'time', 
        'default_capacity', 'available_days', 'is_active'
    ];

    protected $casts = [
        'available_days' => 'array',
        'is_active' => 'boolean',
    ];

    public function availability(): HasMany
    {
        return $this->hasMany(SessionAvailability::class, 'session_id', 'session_id');
    }

    // Helper: Apakah session tersedia di hari tertentu (0=minggu, 6=sabtu)
    public function isAvailableOnDay(int $dayOfWeek): bool
    {
        return in_array($dayOfWeek, $this->available_days);
    }
}
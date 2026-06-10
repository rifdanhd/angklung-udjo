<?php
// app/Models/SessionAvailability.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionAvailability extends Model
{
    protected $table = 'session_availability';
    
    protected $fillable = [
        'date', 'session_id', 'total_capacity', 
        'booked', 'is_open', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'is_open' => 'boolean',
    ];

    // ── Relations ──────────────────────────────────────────────
    
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class, 'session_id', 'session_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BookingTicket::class, 'session_id', 'session_id')
                    ->whereDate('tanggal_kunjungan', $this->date);
    }

    // ── Helpers ────────────────────────────────────────────────
    
    public function getRemainingAttribute(): int
    {
        return max(0, $this->total_capacity - $this->booked);
    }

    public function isFull(): bool
    {
        return $this->remaining <= 0;
    }

    public function isAlmostFull(): bool
    {
        return $this->remaining > 0 && $this->remaining <= 5;
    }

    public function getStatusBadge(): string
    {
        if (!$this->is_open) return 'tutup';
        if ($this->isFull()) return 'penuh';
        if ($this->isAlmostFull()) return 'hampir_penuh';
        return 'tersedia';
    }

    public function incrementBooked(int $qty): void
    {
        $this->increment('booked', $qty);
    }

    public function decrementBooked(int $qty): void
    {
        $this->decrement('booked', max(0, $qty));
    }
}
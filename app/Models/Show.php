<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'capacity',
        'available_seats',
        'price_domestic',
        'price_foreign',
        'image',
        'is_active'
    ];

    protected $casts = [
        'date'      => 'date',
        'is_active' => 'boolean',
    ];

    // --- Relationships ---
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // --- Helpers ---
    public function isFull(): bool
    {
        return $this->available_seats <= 0;
    }

    public function updateAvailableSeats(): void
    {
        $bookedSeats = $this->bookings()->where('status', 'confirmed')->sum('num_tickets');
        $this->update(['available_seats' => $this->capacity - $bookedSeats]);
    }

    // --- Accessors (Biar tampilan di Blade cantik otomatis) ---
    protected function priceDomesticRp(): Attribute
    {
        return Attribute::make(get: fn() => 'Rp ' . number_format($this->price_domestic, 0, ',', '.'));
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->is_active
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-danger">Non-Aktif</span>'
        );
    }
}

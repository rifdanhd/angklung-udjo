<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class ShowSession extends Model
{
    protected $fillable = [
        'session_key', 'name', 'day_type',
        'start_time', 'end_time', 'capacity',
        'is_active', 'sort_order',
    ];
 
    protected $casts = [
        'is_active' => 'boolean',
        'capacity'  => 'integer',
    ];
 
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
 
    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }
 
    public function getTimeRangeAttribute(): string
    {
        // Format: "10.00 – 11.30 WIB"
        $start = substr($this->start_time, 0, 5);
        $end   = substr($this->end_time, 0, 5);
        return str_replace(':', '.', $start) . ' – ' . str_replace(':', '.', $end) . ' WIB';
    }
 
   public function getDayTypeLabelAttribute(): string
{
    $labels = [
        'weekday'  => 'Senin - Jumat',
        'saturday' => 'Sabtu',
        'sunday'   => 'Minggu',
    ];

    return $labels[$this->day_type] ?? $this->day_type;
}
}
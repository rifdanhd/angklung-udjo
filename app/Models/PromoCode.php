<?php
namespace App\Models;
 
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class PromoCode extends Model
{
    protected $fillable = [
        'code', 'label', 'emoji', 'discount_percent',
        'periode_start', 'periode_end', 'whatsapp_closing',
        'usage_count', 'max_usage', 'is_active',
    ];
 
    protected $casts = [
        'discount_percent' => 'float',
        'is_active'        => 'boolean',
        'periode_start'    => 'date',
        'periode_end'      => 'date',
    ];
 
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
 
    public function getIsValidNowAttribute(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_usage && $this->usage_count >= $this->max_usage) return false;
        $now = Carbon::today();
        if ($this->periode_start && $now->lt($this->periode_start)) return false;
        if ($this->periode_end && $now->gt($this->periode_end)) return false;
        return true;
    }
 
   public function getPeriodeStringAttribute(): string
{
    if (!$this->periode_start && !$this->periode_end) {
        return 'Tanpa batas waktu';
    }

    // Menggunakan ternary operator yang lebih kompatibel
    $s = $this->periode_start ? $this->periode_start->format('d M Y') : '-';
    $e = $this->periode_end ? $this->periode_end->format('d M Y') : '-';

    return "{$s} - {$e}";
}
}
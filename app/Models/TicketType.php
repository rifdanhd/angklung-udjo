<?php
// ═══════════════════════════════════════════════════════════════
//  MODELS — Simpan masing-masing di app/Models/
// ═══════════════════════════════════════════════════════════════
 
// ─────────────────────────────────────────────────────────────
//  FILE: app/Models/TicketType.php
// ─────────────────────────────────────────────────────────────
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class TicketType extends Model
{
    protected $fillable = [
        'slug', 'name', 'category', 'type',
        'description', 'price', 'is_active', 'sort_order',
    ];
 
    protected $casts = [
        'price'     => 'integer',
        'is_active' => 'boolean',
    ];
 
    public function reservationItems(): HasMany
    {
        return $this->hasMany(ReservationItem::class);
    }
 
    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order');
    }
 
    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
 
    public function getCategoryLabelAttribute(): string
    {
        return $this->category === 'domestic' ? '🇮🇩 Domestik' : '🌍 Mancanegara';
    }
}
 
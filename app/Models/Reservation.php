<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Reservation extends Model
{
    protected $fillable = [
        'reservation_code', 'customer_id', 'visit_date',
        'show_session_id', 'promo_code_id', 'promo_code_used',
        'subtotal', 'discount_amount', 'grand_total',
        'status', 'notes', 'whatsapp_sent_at',
    ];
 
    protected $casts = [
        'visit_date'      => 'date',
        'subtotal'        => 'integer',
        'discount_amount' => 'integer',
        'grand_total'     => 'integer',
    ];
 
    // ── Relationships ──────────────────────────────────────
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
 
    public function showSession(): BelongsTo
    {
        return $this->belongsTo(ShowSession::class);
    }
 
    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class);
    }
 
    public function items(): HasMany
    {
        return $this->hasMany(ReservationItem::class);
    }
 
    // ── Scopes ────────────────────────────────────────────
    public function scopePending($q)      { return $q->where('status', 'pending'); }
    public function scopeConfirmed($q)    { return $q->where('status', 'confirmed'); }
    public function scopeCancelled($q)    { return $q->where('status', 'cancelled'); }
    public function scopeCompleted($q)    { return $q->where('status', 'completed'); }
 
    // ── Helpers ───────────────────────────────────────────
   public function getStatusBadgeAttribute(): array
{
    $statuses = [
        'pending'   => ['class' => 'badge-warning', 'label' => 'Menunggu'],
        'confirmed' => ['class' => 'badge-success', 'label' => 'Terkonfirmasi'],
        'cancelled' => ['class' => 'badge-danger', 'label' => 'Dibatalkan'],
        'completed' => ['class' => 'badge-brand', 'label' => 'Selesai'],
    ];

    return $statuses[$this->status] ?? ['class' => 'badge-muted', 'label' => $this->status];
}
 
    public function getGrandTotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->grand_total, 0, ',', '.');
    }
 
    public function getTotalTicketsAttribute(): int
    {
        return $this->items->sum('quantity');
    }
 
    // ── Auto-generate kode unik ───────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Reservation $r) {
            if (!$r->reservation_code) {
                $year  = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $r->reservation_code = 'SAU-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
 
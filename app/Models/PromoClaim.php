<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PromoClaim extends Model
{
    protected $fillable = [
        'promo_id', 'name', 'email', 'phone', 'city',
        'visit_date', 'quantity',
        'original_amount', 'discount_amount', 'final_amount',
        'claim_code', 'status', 'notes', 'used_at',
    ];

    protected $casts = [
        'visit_date'      => 'date',
        'used_at'         => 'datetime',
        'original_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount'    => 'decimal:2',
    ];

    /* ── Boot ── */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($claim) {
            if (empty($claim->claim_code)) {
                $claim->claim_code = 'CLM-' . strtoupper(Str::random(8));
            }
        });
    }

    /* ── Relations ── */
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    /* ── Helpers ── */
    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu',
            'approved' => 'Disetujui',
            'used'     => 'Digunakan',
            'rejected' => 'Ditolak',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'  => 'yellow',
            'approved' => 'blue',
            'used'     => 'green',
            'rejected' => 'red',
            default    => 'gray',
        };
    }
}
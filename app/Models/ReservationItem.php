<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class ReservationItem extends Model
{
    protected $fillable = [
        'reservation_id', 'ticket_type_id',
        'quantity', 'unit_price', 'subtotal',
    ];
 
    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'integer',
        'subtotal'   => 'integer',
    ];
 
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
 
    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }
}
<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class Customer extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'phone_code',
        'city', 'visit_count', 'last_visit_at',
    ];
 
    protected $casts = [
        'last_visit_at' => 'datetime',
    ];
 
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
 
    public function getFullPhoneAttribute(): string
    {
        return $this->phone_code . $this->phone;
    }
 
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $init  = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $init .= strtoupper($w[0]);
        }
        return $init;
    }
}
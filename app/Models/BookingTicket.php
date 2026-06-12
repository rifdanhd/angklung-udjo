<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingTicket extends Model
{
    const PRICES = [
        'dewasa'        => 85000,
        'anak'          => 60000,
        'kitas_dewasa'  => 85000,
        'manca_dewasa'  => 120000,
        'manca_anak'    => 85000,
    ];

    const TICKET_TYPES = [
        'dewasa'        => ['col' => 'jumlah_tiket_dewasa',       'name' => 'Domestik — Dewasa'],
        'anak'          => ['col' => 'jumlah_tiket_anak',         'name' => 'Domestik — Anak'],
        'kitas_dewasa'  => ['col' => 'jumlah_tiket_kitas_dewasa', 'name' => 'KITAS — Dewasa'],
        'manca_dewasa'  => ['col' => 'jumlah_tiket_manca_dewasa', 'name' => 'Mancanegara — Dewasa'],
        'manca_anak'    => ['col' => 'jumlah_tiket_manca_anak',   'name' => 'Mancanegara — Anak'],
    ];

    protected $fillable = [
        'booking_code', 'nama', 'no_hp', 'email', 'kota',
        'tanggal_kunjungan', 'jumlah_tiket_dewasa', 'jumlah_tiket_anak',
        'jumlah_tiket_kitas_dewasa',
        'jumlah_tiket_manca_dewasa', 'jumlah_tiket_manca_anak',
        'session_id', 'session_time', 'total_harga',
        'promo_code', 'discount_amount', 'subtotal', 'status', 'wa_opened_at', 'negara_asal', 'klaim_hompimplay',
        'payment_method',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'wa_opened_at'      => 'datetime',
    ];

    /* ── Accessor ── */
    public function getNameAttribute(): string      { return $this->nama; }
    public function getPhoneAttribute(): string     { return $this->no_hp; }
    public function getCityAttribute(): ?string     { return $this->kota; }
    public function getVisitDateAttribute(): Carbon { return $this->tanggal_kunjungan; }

    public function getTicketItemsAttribute(): array
    {
        $items = [];
        if ($this->jumlah_tiket_dewasa > 0)
            $items[] = ['name' => 'Domestik — Dewasa',    'qty' => $this->jumlah_tiket_dewasa,       'subtotal' => $this->jumlah_tiket_dewasa       * self::PRICES['dewasa']];
        if ($this->jumlah_tiket_anak > 0)
            $items[] = ['name' => 'Domestik — Anak',      'qty' => $this->jumlah_tiket_anak,         'subtotal' => $this->jumlah_tiket_anak         * self::PRICES['anak']];
        if ($this->jumlah_tiket_kitas_dewasa > 0)
            $items[] = ['name' => 'KITAS — Dewasa',       'qty' => $this->jumlah_tiket_kitas_dewasa, 'subtotal' => $this->jumlah_tiket_kitas_dewasa * self::PRICES['kitas_dewasa']];
        if ($this->jumlah_tiket_manca_dewasa > 0)
            $items[] = ['name' => 'Mancanegara — Dewasa', 'qty' => $this->jumlah_tiket_manca_dewasa, 'subtotal' => $this->jumlah_tiket_manca_dewasa * self::PRICES['manca_dewasa']];
        if ($this->jumlah_tiket_manca_anak > 0)
            $items[] = ['name' => 'Mancanegara — Anak',   'qty' => $this->jumlah_tiket_manca_anak,   'subtotal' => $this->jumlah_tiket_manca_anak   * self::PRICES['manca_anak']];
        return $items;
    }

    /* ── Helpers ── */
    public static function generateCode(): string
    {
        do {
            $code = 'SAU-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('booking_code', $code)->exists());
        return $code;
    }

    public function totalTickets(): int
    {
        return $this->jumlah_tiket_dewasa
             + $this->jumlah_tiket_anak
             + $this->jumlah_tiket_kitas_dewasa
             + $this->jumlah_tiket_manca_dewasa
             + $this->jumlah_tiket_manca_anak;
    }

    public function ticketSummary(): array
    {
        return array_filter([
            'Domestik — Dewasa'    => $this->jumlah_tiket_dewasa,
            'Domestik — Anak'      => $this->jumlah_tiket_anak,
            'KITAS — Dewasa'       => $this->jumlah_tiket_kitas_dewasa,
            'Mancanegara — Dewasa' => $this->jumlah_tiket_manca_dewasa,
            'Mancanegara — Anak'   => $this->jumlah_tiket_manca_anak,
        ], fn($q) => $q > 0);
    }

    public function formattedTotal(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending', 'confirmed' => 'Reservasi',
            'completed'            => 'Lunas',
            'cancelled'            => 'Dibatalkan',
            default                => $this->status,
        };
    }

    public function statusBadge(): string
    {
        return match ($this->status) {
            'pending', 'confirmed' => 'badge-warning',
            'completed'            => 'badge-success',
            'cancelled'            => 'badge-danger',
            default                => 'badge-muted',
        };
    }
}
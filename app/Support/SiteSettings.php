<?php

namespace App\Support;

class SiteSettings
{
    protected static array $defaults = [
        'site_name'          => 'Saung Angklung Udjo',
        'site_tagline'       => 'SAU Bandung',
        'contact_phone'      => '0821-8282-1200',
        'whatsapp_number'    => '6282182821200',
        'contact_email'      => 'angklung.udjo@gmail.com',
        'address'            => "Jl. Padasuka No. 118,\nPasirlayung, Cibeunying Kidul,\nBandung, Jawa Barat 40192",
        'opening_hours'      => '08:00 - 17:00 WIB',
        'default_capacity'   => 20,
        'booking_enabled'    => true,
        'maintenance_mode'   => false,
    ];

    public static function path(): string
    {
        return storage_path('app/settings.json');
    }

    public static function all(): array
    {
        $stored = [];
        if (file_exists(static::path())) {
            $decoded = json_decode(file_get_contents(static::path()), true);
            $stored = is_array($decoded) ? $decoded : [];
        }

        return array_merge(static::$defaults, $stored);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::all();

        return $all[$key] ?? $default ?? (static::$defaults[$key] ?? null);
    }

    public static function set(array $data): void
    {
        $dir = dirname(static::path());
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $merged = array_merge(static::all(), $data);
        file_put_contents(
            static::path(),
            json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    public static function keys(): array
    {
        return array_keys(static::$defaults);
    }
}

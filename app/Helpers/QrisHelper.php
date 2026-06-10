<?php

namespace App\Helpers;

class QrisHelper
{
    /**
     * Parse QRIS string menjadi array TLV
     * Return: [['tag'=>'00','len'=>2,'val'=>'01','raw'=>'000201'], ...]
     */
    private static function parseTLV(string $qris): array
    {
        $fields = [];
        $i      = 0;
        $len    = strlen($qris);

        while ($i < $len - 3) {
            $tag    = substr($qris, $i, 2);
            $lenStr = substr($qris, $i + 2, 2);
            if (!is_numeric($lenStr)) break;
            $flen = (int) $lenStr;
            $val  = substr($qris, $i + 4, $flen);
            $fields[] = [
                'tag' => $tag,
                'len' => $flen,
                'val' => $val,
                'raw' => $tag . $lenStr . $val,
                'pos' => $i,
            ];
            $i += 4 + $flen;
        }

        return $fields;
    }

    /**
     * Rebuild string QRIS dari array TLV (tanpa CRC)
     */
    private static function buildQris(array $fields): string
    {
        return implode('', array_column($fields, 'raw'));
    }

    public static function toDynamic(string $staticQris, int $amount): string
    {
        // Hapus CRC (tag 63 + 4 char CRC di akhir)
        $crcPos = strrpos($staticQris, '6304');
        $body   = substr($staticQris, 0, $crcPos);

        // Parse TLV
        $fields = self::parseTLV($body);

        $result = [];
        foreach ($fields as $f) {
            if ($f['tag'] === '01') {
                // Ubah mode: ambil 2 char terakhir value, ganti "11" → "12"
                $newVal = substr($f['val'], 0, -2) . '12';
                $result[] = [
                    'tag' => '01',
                    'raw' => '01' . str_pad(strlen($newVal), 2, '0', STR_PAD_LEFT) . $newVal,
                ];
            } elseif ($f['tag'] === '54') {
                // Skip tag 54 lama — akan diganti di bawah
                continue;
            } elseif ($f['tag'] === '53') {
                // Simpan tag 53, lalu langsung tambah tag 54 baru
                $result[] = $f;
                $amtStr   = (string) $amount;
                $result[] = [
                    'tag' => '54',
                    'raw' => '54' . str_pad(strlen($amtStr), 2, '0', STR_PAD_LEFT) . $amtStr,
                ];
            } else {
                $result[] = $f;
            }
        }

        // Kalau tag 53 tidak ada (edge case), append tag 54 sebelum tag 58
        $hasFn54 = count(array_filter($result, fn($f) => $f['tag'] === '54')) > 0;
        if (!$hasFn54) {
            $final = [];
            $amtStr = (string) $amount;
            $tag54raw = '54' . str_pad(strlen($amtStr), 2, '0', STR_PAD_LEFT) . $amtStr;
            foreach ($result as $f) {
                if ($f['tag'] === '58') {
                    $final[] = ['tag' => '54', 'raw' => $tag54raw];
                }
                $final[] = $f;
            }
            $result = $final;
        }

        // Build string dan hitung CRC
        $qrisBody = implode('', array_column($result, 'raw'));
        $forCrc   = $qrisBody . '6304';
        return $forCrc . self::crc16($forCrc);
    }

    public static function verifyCrc(string $qris): bool
    {
        $pos = strrpos($qris, '6304');
        if ($pos === false) return false;
        $forCrc = substr($qris, 0, $pos + 4);
        $given  = strtoupper(substr($qris, $pos + 4, 4));
        return self::crc16($forCrc) === $given;
    }

    private static function crc16(string $data): string
    {
        $crc  = 0xFFFF;
        $poly = 0x1021;
        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $crc = ($crc & 0x8000)
                    ? (($crc << 1) ^ $poly) & 0xFFFF
                    : ($crc << 1) & 0xFFFF;
            }
        }
        return str_pad(strtoupper(dechex($crc)), 4, '0', STR_PAD_LEFT);
    }
}

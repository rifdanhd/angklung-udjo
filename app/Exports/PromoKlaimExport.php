<?php

namespace App\Exports;

use App\Models\PromoKlaim;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PromoKlaimExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    private $rowNumber = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    // Header Kolom
    public function headings(): array
    {
        return [
            ['LAPORAN REKAPITULASI PROMO SAUNG ANGKLUNG UDJO 2026'],
            ['Dicetak pada: ' . Carbon::now()->format('d/m/Y H:i') . ' WIB'],
            [''], // Baris Kosong
            [
                'NO',
                'TANGGAL',
                'JAM',
                'NAMA TAMU',
                'WHATSAPP',
                'DOMESTIK',
                'MANCANEGARA',
                'TOTAL PAX',
                'TOTAL HARGA (RP)',
                'STATUS'
            ]
        ];
    }

    // Mapping Data per Baris
    public function map($item): array
    {
        $this->rowNumber++;
        
        // Logika Jam Pertunjukan
        $tgl = Carbon::parse($item->tanggal_kunjungan)->format('Y-m-d');
        $jamMapping = [
            '2026-05-14' => '10.00 WIB',
            '2026-05-15' => '15.30 WIB',
            '2026-05-16' => '13.00 WIB',
        ];

        return [
            $this->rowNumber,
            Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y'),
            $jamMapping[$tgl] ?? '-',
            strtoupper($item->nama),
            $item->no_hp,
            ($item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak),
            ($item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak),
            ($item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak + $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak),
            $item->total_harga,
            strtoupper($item->status),
        ];
    }

    // Styling Excel (Corporate Look)
    public function styles(Worksheet $sheet)
    {
        // Merge judul
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');

        return [
            // Style Judul Utama
            1 => ['font' => ['bold' => true, 'size' => 14]],
            
            // Style Header Tabel (Baris ke-4)
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '000000']
                ],
                'alignment' => ['horizontal' => 'center']
            ],

            // Border untuk seluruh data
            'A4:J' . ($this->data->count() + 4) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
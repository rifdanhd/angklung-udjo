<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Exception;

class GoogleSheetService
{
    private $client;
    private $service;
    private $spreadsheetId;

    public function __construct()
    {
        $this->initializeClient();
    }

    /**
     * Initialize Google Client with Service Account
     */
   private function initializeClient()
{
    try {
        $this->client = new Client();
        $this->client->setApplicationName('Kopiderr Booking System');
        
        $credentialsPath = storage_path('app/google/kopiderr-562d2f5ff13a.json');
        
        if (!file_exists($credentialsPath)) {
            throw new Exception("Google credentials file not found at: {$credentialsPath}");
        }

        $this->client->setAuthConfig($credentialsPath);
        $this->client->addScope(Sheets::SPREADSHEETS);

        // ✅ Tambahkan timeout agar tidak hanging
        $this->client->setHttpClient(new \GuzzleHttp\Client([
            'timeout'         => 10,  // maksimal 10 detik total
            'connect_timeout' => 5,   // maksimal 5 detik untuk koneksi
        ]));
        
        $this->service = new Sheets($this->client);
        
    } catch (Exception $e) {
        throw new Exception("Failed to initialize Google Sheets client: " . $e->getMessage());
    }
}

    /**
     * Set Spreadsheet ID
     * 
     * @param string $spreadsheetId
     * @return self
     */
    public function setSpreadsheetId(string $spreadsheetId)
    {
        $this->spreadsheetId = $spreadsheetId;
        return $this;
    }

    /**
     * Append data to Google Sheets
     * 
     * @param string $range Sheet name and range (e.g., 'Bookings!A:F')
     * @param array $values Array of data to append
     * @return array Response from Google Sheets API
     */
    public function appendData(string $range, array $values)
    {
        try {
            if (empty($this->spreadsheetId)) {
                throw new Exception("Spreadsheet ID not set. Use setSpreadsheetId() first.");
            }

            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'RAW',
                 'insertDataOption' => 'INSERT_ROWS' 
            ];

            $result = $this->service->spreadsheets_values->append(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );

            return [
                'success' => true,
                'updates' => $result->getUpdates()->getUpdatedRows(),
                'message' => 'Data successfully added to Google Sheets'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to append data: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update specific range in Google Sheets
     * 
     * @param string $range Sheet name and range (e.g., 'Bookings!A2:F2')
     * @param array $values Array of data to update
     * @return array Response from Google Sheets API
     */
    public function updateData(string $range, array $values)
    {
        try {
            if (empty($this->spreadsheetId)) {
                throw new Exception("Spreadsheet ID not set. Use setSpreadsheetId() first.");
            }

            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'USER_ENTERED'
            ];

            $result = $this->service->spreadsheets_values->update(
                $this->spreadsheetId,
                $range,
                $body,
                $params
            );

            return [
                'success' => true,
                'updates' => $result->getUpdatedRows(),
                'message' => 'Data successfully updated in Google Sheets'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to update data: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Read data from Google Sheets
     * 
     * @param string $range Sheet name and range (e.g., 'Bookings!A:F')
     * @return array Response from Google Sheets API
     */
    public function readData(string $range)
    {
        try {
            if (empty($this->spreadsheetId)) {
                throw new Exception("Spreadsheet ID not set. Use setSpreadsheetId() first.");
            }

            $response = $this->service->spreadsheets_values->get(
                $this->spreadsheetId,
                $range
            );

            $values = $response->getValues();

            return [
                'success' => true,
                'data' => $values ?? [],
                'message' => 'Data successfully retrieved from Google Sheets'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to read data: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Clear specific range in Google Sheets
     * 
     * @param string $range Sheet name and range (e.g., 'Bookings!A2:F100')
     * @return array Response from Google Sheets API
     */
    public function clearData(string $range)
    {
        try {
            if (empty($this->spreadsheetId)) {
                throw new Exception("Spreadsheet ID not set. Use setSpreadsheetId() first.");
            }

            $body = new \Google\Service\Sheets\ClearValuesRequest();

            $result = $this->service->spreadsheets_values->clear(
                $this->spreadsheetId,
                $range,
                $body
            );

            return [
                'success' => true,
                'message' => 'Data successfully cleared from Google Sheets'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to clear data: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Batch update multiple ranges at once
     * 
     * @param array $dataRanges Array of ['range' => 'A1:B2', 'values' => [[...]]]
     * @return array Response from Google Sheets API
     */
    public function batchUpdate(array $dataRanges)
    {
        try {
            if (empty($this->spreadsheetId)) {
                throw new Exception("Spreadsheet ID not set. Use setSpreadsheetId() first.");
            }

            $data = [];
            foreach ($dataRanges as $item) {
                $data[] = new \Google\Service\Sheets\ValueRange([
                    'range' => $item['range'],
                    'values' => $item['values']
                ]);
            }

            $body = new \Google\Service\Sheets\BatchUpdateValuesRequest([
                'valueInputOption' => 'USER_ENTERED',
                'data' => $data
            ]);

            $result = $this->service->spreadsheets_values->batchUpdate(
                $this->spreadsheetId,
                $body
            );

            return [
                'success' => true,
                'updates' => $result->getTotalUpdatedRows(),
                'message' => 'Batch update successfully completed'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to batch update: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format booking data for Google Sheets
     * 
     * @param object $booking Booking model instance
     * @return array Formatted data array
     */
 public function formatBookingData($booking)
{
    $totalTiket = $booking->jumlah_tiket_dewasa
                + $booking->jumlah_tiket_anak
                + $booking->jumlah_tiket_manca_dewasa
                + $booking->jumlah_tiket_manca_anak;

    // Tipe Tamu: Domestik / Mancanegara / Campuran
    $manca = $booking->jumlah_tiket_manca_dewasa + $booking->jumlah_tiket_manca_anak;
    $dom   = $booking->jumlah_tiket_dewasa + $booking->jumlah_tiket_anak;
    $tipeTamu = ($manca > 0 && $dom > 0) ? 'Campuran'
              : ($manca > 0 ? 'Mancanegara' : 'Domestik');

    return [[
        $booking->booking_code              ?? '',
        $booking->nama                      ?? '',
        $booking->no_hp                     ?? '',
        $booking->email                     ?? '',
        $booking->kota                      ?? '',
        $booking->negara_asal               ?? '',
        $tipeTamu,
       \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('Y-m-d'),
        $booking->session_time              ?? '',
        $booking->jumlah_tiket_dewasa       ?? 0,
        $booking->jumlah_tiket_anak         ?? 0,
        $booking->jumlah_tiket_manca_dewasa ?? 0,
        $booking->jumlah_tiket_manca_anak   ?? 0,
        $totalTiket,
        $booking->promo_code                ?? '',
        $booking->discount_amount           ?? 0,
        $booking->subtotal                  ?? 0,
        $booking->total_harga               ?? 0,
        $booking->status                    ?? '',
        \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d H:i:s')  // → "2026-04-14 04:35:29"
    ]];
}
}
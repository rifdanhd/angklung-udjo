<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $baseUrl = 'https://api-sandbox.fonnte.com'; // Default fallback, but production is api.fonnte.com

    public function __construct()
    {
        $this->token = config('services.fonnte.token') ?? env('FONNTE_TOKEN', 'KHszSqP69McJ8svakdZK');
    }

    /**
     * Send message using Fonnte API
     *
     * @param string $phone Target number (e.g. 628xxxx)
     * @param string $message Text message content
     * @param string|null $fileUrl Optional file url attachment (e.g. PDF ticket link)
     * @return array
     */
    public function sendMessage(string $phone, string $message, ?string $fileUrl = null): array
    {
        $phone = $this->formatPhoneNumber($phone);
        $url = 'https://api.fonnte.com/send';

        $data = [
            'target' => $phone,
            'message' => $message,
        ];

        if ($fileUrl) {
            $data['url'] = $fileUrl;
        }

        Log::info('[Fonnte] Sending WA notification to ' . $phone, ['has_file' => !empty($fileUrl)]);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->asForm()->post($url, $data);

            $result = $response->json();
            Log::info('[Fonnte] Response: ', ['status' => $response->status(), 'data' => $result]);

            return $result ?? [];
        } catch (\Exception $e) {
            Log::error('[Fonnte] Exception: ' . $e->getMessage());
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }

    /**
     * Format phone number to standard international prefix without +, spaces or leading 0.
     */
    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }
}

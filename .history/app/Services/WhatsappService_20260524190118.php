// app/Services/WhatsappService.php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    /**
     * Kirim pesan WhatsApp via Fonnte
     */
    public static function send(string $phone, string $message): bool
    {
        try {
            $phone = self::normalizePhone($phone);

            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                return true;
            }

            Log::warning('WhatsApp send failed', ['response' => $result, 'phone' => $phone]);
            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp service error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Normalisasi nomor HP ke format internasional (628xxx)
     */
    public static function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // hapus non-digit

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+')) {
            $phone = ltrim($phone, '+');
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

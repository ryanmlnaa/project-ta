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

            $token = config('services.fonnte.token');

            if (empty($token)) {
                Log::error('FONNTE_TOKEN kosong di .env');
                return false;
            }

            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->post('https://api.fonnte.com/send', [
                    'target'  => $phone,
                    'message' => $message,
                    'countryCode' => '62',
                ]);

            $result = $response->json();

            Log::info('Fonnte response', [
                'phone'       => $phone,
                'http_status' => $response->status(),
                'response'    => $result,
            ]);

            // Fonnte kadang return status sebagai bool true atau string "true"
            if ($response->successful() && !empty($result['status'])) {
                return true;
            }

            Log::warning('Fonnte gagal kirim', [
                'phone'    => $phone,
                'response' => $result,
            ]);
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
        // Hapus semua karakter selain angka
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '+62')) {
            $phone = '62' . substr($phone, 3);
        } elseif (str_starts_with($phone, '+')) {
            $phone = ltrim($phone, '+');
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

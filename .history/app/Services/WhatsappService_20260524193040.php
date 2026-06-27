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
            // Normalisasi nomor langsung di sini (tidak pakai self::)
            $phone = preg_replace('/\D/', '', $phone);

            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '+')) {
                $phone = ltrim($phone, '+');
            } elseif (!str_starts_with($phone, '62')) {
                $phone = '62' . $phone;
            }

            $token = config('services.fonnte.token');

            if (empty($token)) {
                Log::error('FONNTE_TOKEN kosong di .env');
                return false;
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target'  => $phone,
                'message' => $message,
            ]);

            $result = $response->json();

            Log::info('Fonnte response', [
                'phone'    => $phone,
                'status'   => $response->status(),
                'response' => $result,
            ]);

            if ($response->successful() && isset($result['status']) && $result['status'] === true) {
                return true;
            }

            Log::warning('Fonnte gagal kirim', ['response' => $result]);
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
        $phone = preg_replace('/\D/', '', $phone);

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

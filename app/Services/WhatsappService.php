<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function send(string $phone, string $message): bool
    {
        try {
            $phone = self::normalizePhone($phone);

            $token = config('services.fonnte.token');

            if (empty($token)) {
                Log::error('[WhatsApp] FONNTE_TOKEN kosong. Pastikan sudah ada di .env dan config/services.php');
                return false;
            }

            Log::info('[WhatsApp] Mencoba kirim ke: ' . $phone);

            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' => $token,
                ])
                ->post('https://api.fonnte.com/send', [
                    'target'      => $phone,
                    'message'     => $message,
                    'countryCode' => '62',
                ]);

            $result = $response->json();

            Log::info('[WhatsApp] Fonnte response', [
                'phone'       => $phone,
                'http_status' => $response->status(),
                'response'    => $result,
            ]);

            if ($response->successful() && !empty($result['status'])) {
                return true;
            }

            Log::warning('[WhatsApp] Fonnte gagal kirim', [
                'phone'    => $phone,
                'response' => $result,
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('[WhatsApp] Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Normalisasi nomor HP ke format 628xxx
     * Preg_replace dulu SEBELUM cek prefix
     */
    public static function normalizePhone(string $phone): string
    {
        // Simpan original untuk cek prefix sebelum strip
        $original = $phone;

        // Hapus semua karakter selain angka
        $phone = preg_replace('/\D/', '', $phone);

        // Cek prefix dari string ORIGINAL (sebelum strip)
        if (str_starts_with($original, '+62')) {
            // +6281xxx → sudah jadi 6281xxx setelah strip, tidak perlu ubah
        } elseif (str_starts_with($phone, '62')) {
            // sudah benar
        } elseif (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } else {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

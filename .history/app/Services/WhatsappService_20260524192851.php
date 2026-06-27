public static function send(string $phone, string $message): bool
{
    try {
        $phone = self::normalizePhone($phone);

        $token = env('FONNTE_TOKEN');

        // Cek token ada atau tidak
        if (empty($token)) {
            \Illuminate\Support\Facades\Log::error('FONNTE_TOKEN kosong di .env');
            return false;
        }

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'  => $phone,
            'message' => $message,
        ]);

        $result = $response->json();

        // Log semua response untuk debug
        \Illuminate\Support\Facades\Log::info('Fonnte response', [
            'phone'    => $phone,
            'status'   => $response->status(),
            'response' => $result,
        ]);

        if ($response->successful() && isset($result['status']) && $result['status'] === true) {
            return true;
        }

        return false;

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('WhatsApp error: ' . $e->getMessage());
        return false;
    }
}

public function sendOtp(Request $request)
{
    $request->validate([
        'email'   => 'required|email',
        'otp_via' => 'required|in:email,whatsapp',
        // ✅ Wajib isi nomor jika pilih WhatsApp
        'phone'   => 'required_if:otp_via,whatsapp',
    ], [
        'phone.required_if' => 'Nomor WhatsApp wajib diisi jika memilih metode WhatsApp.',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()
            ->withInput()
            ->with('error', 'Email tidak ditemukan.');
    }

    $otpVia = $request->input('otp_via');

    // Generate OTP 6 digit
    $otp = rand(100000, 999999);
    $user->otp_code    = $otp;
    $user->otp_expired = now()->addMinutes(5);
    $user->save();

    if ($otpVia === 'whatsapp') {
        // ✅ Gunakan nomor dari input form, bukan dari DB
        $telepon = $request->input('phone');
        $telepon = WhatsappService::normalizePhone($telepon);

        $message = "🔐 *GREEN VIEW - Reset Password*\n\n"
                 . "Kode OTP Anda: *{$otp}*\n\n"
                 . "Kode berlaku selama *5 menit*.\n"
                 . "Jangan bagikan kode ini kepada siapapun.\n\n"
                 . "_PT Tunggal Griya Sakinah_";

        $sent = WhatsappService::send($telepon, $message);

        if (!$sent) {
            return back()
                ->withInput()
                ->with('error', 'Gagal mengirim OTP via WhatsApp. Pastikan nomor aktif & coba lagi.');
        }

        session([
            'reset_email'   => $user->email,
            'otp_method'    => 'whatsapp',
            'reset_telepon' => $telepon,
        ]);

        $maskedPhone = $this->maskPhone($telepon);
        return redirect()->route('password.otp')
            ->with('success', "OTP berhasil dikirim ke WhatsApp {$maskedPhone}");

    } else {
        // Kirim via Email
        Mail::to($user->email)->send(new OtpMail($otp));

        session([
            'reset_email'   => $user->email,
            'otp_method'    => 'email',
            'reset_telepon' => null,
        ]);

        $maskedEmail = $this->maskEmail($user->email);
        return redirect()->route('password.otp')
            ->with('success', "OTP berhasil dikirim ke email {$maskedEmail}");
    }
}

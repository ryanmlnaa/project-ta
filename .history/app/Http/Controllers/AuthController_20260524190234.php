// app/Http/Controllers/AuthController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Services\WhatsappService;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ================= LOGIN =================

    public function login()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required'
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $login, 'password' => $request->password])) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            return match($user->role) {
                'admin' => redirect('/admin/dashboard'),
                'rt'    => redirect('/rt/dashboard'),
                default => redirect('/user/home'),
            };
        }

        return back()->with('error', 'Login gagal!');
    }

    // ================= REGISTER =================

    public function register()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user'
        ]);

        return redirect('/login')->with('success', 'Register berhasil');
    }

    // ================= LOGOUT =================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ================= FORGOT PASSWORD =================

    public function forgotForm()
    {
        return view('auth.forgot');
    }

    /**
     * Kirim OTP — user pilih via Email atau WhatsApp
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email'  => 'required|email',
            'method' => 'required|in:email,whatsapp',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Validasi WhatsApp — pastikan user punya nomor HP
        if ($request->method === 'whatsapp') {
            if (empty($user->phone)) {
                return back()->with('error', 'Akun ini tidak memiliki nomor WhatsApp terdaftar. Gunakan metode Email.');
            }
        }

        // Generate OTP 6 digit
        $otp = rand(100000, 999999);

        $user->otp_code    = $otp;
        $user->otp_expired = now()->addMinutes(5);
        $user->save();

        session([
            'reset_email'  => $user->email,
            'otp_method'   => $request->method,
        ]);

        if ($request->method === 'whatsapp') {
            // Kirim via WhatsApp
            $message = "🔐 *GREEN VIEW - Reset Password*\n\n"
                     . "Kode OTP Anda: *{$otp}*\n\n"
                     . "Kode berlaku selama *5 menit*.\n"
                     . "Jangan bagikan kode ini kepada siapapun.\n\n"
                     . "_PT Tunggal Griya Sakinah_";

            $sent = WhatsappService::send($user->phone, $message);

            if (!$sent) {
                return back()->with('error', 'Gagal mengirim OTP via WhatsApp. Coba metode Email.');
            }

            $maskedPhone = $this->maskPhone($user->phone);
            return redirect()->route('password.otp')
                ->with('success', "OTP berhasil dikirim ke WhatsApp {$maskedPhone}");
        } else {
            // Kirim via Email
            Mail::to($user->email)->send(new OtpMail($otp));

            $maskedEmail = $this->maskEmail($user->email);
            return redirect()->route('password.otp')
                ->with('success', "OTP berhasil dikirim ke email {$maskedEmail}");
        }
    }

    // ================= OTP =================

    public function otpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.forgot');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('email', session('reset_email'))->first();

        if (!$user) {
            return redirect()->route('password.forgot')
                ->with('error', 'Sesi habis, silakan ulangi.');
        }

        if ($user->otp_code != $request->otp) {
            return back()->with('error', 'Kode OTP salah.');
        }

        if (Carbon::now()->gt($user->otp_expired)) {
            return back()->with('error', 'Kode OTP sudah expired. Minta ulang kode baru.');
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.reset');
    }

    // Kirim ulang OTP
    public function resendOtp(Request $request)
    {
        $email  = session('reset_email');
        $method = session('otp_method', 'email');

        if (!$email) {
            return redirect()->route('password.forgot');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.forgot');
        }

        $otp = rand(100000, 999999);
        $user->otp_code    = $otp;
        $user->otp_expired = now()->addMinutes(5);
        $user->save();

        if ($method === 'whatsapp' && $user->phone) {
            $message = "🔐 *GREEN VIEW - Reset Password*\n\n"
                     . "Kode OTP baru Anda: *{$otp}*\n\n"
                     . "Kode berlaku selama *5 menit*.\n"
                     . "Jangan bagikan kode ini kepada siapapun.\n\n"
                     . "_PT Tunggal Griya Sakinah_";
            WhatsappService::send($user->phone, $message);
            return back()->with('success', 'OTP baru dikirim via WhatsApp.');
        } else {
            Mail::to($user->email)->send(new OtpMail($otp));
            return back()->with('success', 'OTP baru dikirim via Email.');
        }
    }

    // ================= RESET PASSWORD =================

    public function resetForm()
    {
        if (!session('reset_email') || !session('otp_verified')) {
            return redirect()->route('password.forgot');
        }
        return view('auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', session('reset_email'))->first();

        if (!$user) {
            return redirect()->route('password.forgot');
        }

        $user->password    = Hash::make($request->password);
        $user->otp_code    = null;
        $user->otp_expired = null;
        $user->save();

        // Hapus session
        session()->forget(['reset_email', 'otp_method', 'otp_verified']);

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login.');
    }

    // ================= HELPERS =================

    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 3));
        return $masked . '@' . $domain;
    }

    private function maskPhone(string $phone): string
    {
        $phone = WhatsappService::normalizePhone($phone);
        return substr($phone, 0, 4) . str_repeat('*', strlen($phone) - 7) . substr($phone, -3);
    }
}

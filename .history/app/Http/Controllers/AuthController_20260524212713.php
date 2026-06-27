<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penghuni;
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
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
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
        $email   = session('reset_email');
        $method  = session('otp_method', 'email');
        $telepon = session('reset_telepon');

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

        if ($method === 'whatsapp' && !empty($telepon)) {
            $message = "🔐 *GREEN VIEW - Reset Password*\n\n"
                     . "Kode OTP baru Anda: *{$otp}*\n\n"
                     . "Kode berlaku selama *5 menit*.\n"
                     . "Jangan bagikan kode ini kepada siapapun.\n\n"
                     . "_PT Tunggal Griya Sakinah_";

            $sent = WhatsappService::send($telepon, $message);

            if ($sent) {
                return back()->with('success', 'OTP baru dikirim via WhatsApp.');
            }

            Mail::to($user->email)->send(new OtpMail($otp));
            return back()->with('success', 'WhatsApp gagal, OTP dikirim via Email.');
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

        session()->forget(['reset_email', 'otp_method', 'otp_verified', 'reset_telepon']);

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

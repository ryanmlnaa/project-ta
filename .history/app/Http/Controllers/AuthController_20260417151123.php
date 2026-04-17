<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
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
            'login' => 'required',
            'password' => 'required'
        ]);

        $login = $request->login;

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $login, 'password' => $request->password])) {

            $request->session()->regenerate();

          $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role == 'rt') {
                return redirect('/rt/dashboard');
            }

           return match($user->role) {
                'admin' => redirect('/admin/dashboard'),
                'rt' => redirect('/rt/iuran'),
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
        // VALIDASI
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // DEBUG (WAJIB COBA)
        // dd($request->all());

        User::create([
            'name' => $request->name,
            'username' => $request->username, // 🔥 INI WAJIB ADA
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
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

    public function forgotForm()
    {
        return view('auth.forgot');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expired = now()->addMinutes(5);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        session(['reset_email' => $user->email]);

        return redirect()->route('password.otp')->with('success', 'OTP dikirim ke email');
    }


}

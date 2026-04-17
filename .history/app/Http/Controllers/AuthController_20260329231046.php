<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

            if (Auth::user()->role == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/penghuni/dashboard');
            }
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
            'role' => 'penghuni'
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
}

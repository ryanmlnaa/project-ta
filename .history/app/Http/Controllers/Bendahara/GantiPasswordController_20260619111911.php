<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GantiPasswordController extends Controller
{
    // Tampilkan form ganti password
        public function form()
    {
        $user = Auth::user();

        // Kalau ternyata sudah tidak wajib ganti (misal akses manual), lempar ke dashboard
        if (!$user->wajib_ganti_password) {
            return redirect()->route('bendahara.iuran.index');
        }

        return view('bendahara.ganti-password.form');
    }

    // Proses simpan password baru
        public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        // Wajib beda dari password default
        if ($request->password === '12345678') {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password default (12345678).']);
        }

            $user->update([
                'password'              => Hash::make($request->password),
                'wajib_ganti_password'  => false,
            ])

        return redirect()->route('bendahara.iuran.index')->with('success', 'Password berhasil diganti. Selamat datang!');
    }
}

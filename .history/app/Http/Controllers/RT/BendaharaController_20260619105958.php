<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BendaharaController extends Controller
{
    // Halaman kelola bendahara
    public function index()
    {
        $rt = Auth::user();
        $bendaharas = User::where('rt_id', $rt->id)
                          ->where('role', 'bendahara')
                          ->orderBy('created_at', 'desc')
                          ->get();

        $bendaharaAktif = $bendaharas->where('status_akun', 'aktif')->first();

        return view('rt.bendahara.index', compact('bendaharas', 'bendaharaAktif'));
    }

    // Simpan akun bendahara baru
    // Simpan akun bendahara baru
    public function store(Request $request)
    {
        $rt = Auth::user();

        // Cek apakah RT sudah punya bendahara aktif
        $sudahAda = User::where('rt_id', $rt->id)
                        ->where('role', 'bendahara')
                        ->where('status_akun', 'aktif')
                        ->exists();

        if ($sudahAda) {
            return back()->withErrors(['bendahara' => 'Nonaktifkan bendahara aktif dulu sebelum membuat akun baru.']);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email'    => 'required|email|unique:users,email',
        ]);

        User::create([
            'name'                  => $request->name,
            'username'              => $request->username,
            'email'                 => $request->email,
            'password'              => Hash::make('12345678'), // password default
            'role'                  => 'bendahara',
            'rt_id'                 => $rt->id,
            'status_akun'           => 'aktif',
            'wajib_ganti_password'  => true,
        ]);

        return back()->with('success', 'Akun bendahara berhasil dibuat. Password default: 12345678 (wajib diganti saat login pertama).');
    }

    // Nonaktifkan bendahara (bukan hapus)
    public function nonaktifkan($id)
    {
        $rt = Auth::user();

        $bendahara = User::where('id', $id)
                         ->where('rt_id', $rt->id)
                         ->where('role', 'bendahara')
                         ->firstOrFail();

        $bendahara->update(['status_akun' => 'nonaktif']);

        return back()->with('success', 'Akun bendahara berhasil dinonaktifkan.');
    }
}

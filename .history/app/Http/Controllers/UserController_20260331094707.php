<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // =========================
    // BERANDA USER
    // =========================
    public function index()
    {
        $penghuni = Penghuni::with('rumah')
            ->where('email', Auth::user()->email)
            ->first();

        return view('user.home');
    }

    // =========================
    // PROFIL
    // =========================
    public function profil()
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();
        return view('user.profil', compact('penghuni'));
    }

    public function updateProfil(Request $request)
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        $penghuni->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diupdate');
    }

    // =========================
    // RUMAH
    // =========================
    public function rumah()
    {
        $penghuni = Penghuni::with('rumah')
            ->where('email', Auth::user()->email)
            ->first();

        return view('user.rumah', compact('penghuni'));
    }

    // =========================
    // IURAN
    // =========================
    public function iuran()
    {
        return view('user.iuran');
    }

    // =========================
    // PENGADUAN
    // =========================
    public function pengaduan()
    {
        return view('user.pengaduan');
    }

    public function storePengaduan(Request $request)
    {
        // sementara dummy dulu
        return back()->with('success', 'Pengaduan berhasil dikirim');
    }

    // =========================
    // PENGUMUMAN
    // =========================
    public function pengumuman()
    {
        return view('user.pengumuman');
    }
}

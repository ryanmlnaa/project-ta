<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Auth;

class UserLayananController extends Controller
{
    public function create()
    {
        return view('user.layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_masalah' => 'required',
            'deskripsi' => 'required|min:10'
        ]);

        // 🔥 AMBIL BERDASARKAN EMAIL (SESUAI DB KAMU)
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni belum ada!');
        }

        Layanan::create([
            'penghuni_id' => $penghuni->id,
            'tanggal_pengaduan' => now(),
            'kategori_masalah' => $request->kategori_masalah,
            'deskripsi' => $request->deskripsi,
            'status' => 'diajukan'
        ]);

        return redirect()->route('user.layanan.status')
            ->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function status()
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan!');
        }

        $layanan = Layanan::where('penghuni_id', $penghuni->id)
            ->latest()
            ->get();

        return view('user.layanan.status', compact('layanan'));
    }
}

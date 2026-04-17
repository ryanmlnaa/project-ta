<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class UserLayananController extends Controller
{
    // FORM PENGADUAN
    public function create()
    {
        return view('user.layanan.create');
    }

    // SIMPAN PENGADUAN
    public function store(Request $request)
    {
        $request->validate([
            'kategori_masalah' => 'required',
            'deskripsi' => 'required|min:10',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pengaduan', 'public');
        }

        Layanan::create([
            'penghuni_id' => Auth::user()->penghuni->id,
            'tanggal_pengaduan' => now(),
            'kategori_masalah' => $request->kategori_masalah,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => 'diajukan'
        ]);

        return redirect()->route('user.layanan.status')
            ->with('success', 'Pengaduan berhasil dikirim!');
    }

    // STATUS USER
    public function status()
    {
        $layanan = Layanan::where('penghuni_id', Auth::user()->penghuni->id)
            ->latest()
            ->get();

        return view('user.layanan.status', compact('layanan'));
    }
}

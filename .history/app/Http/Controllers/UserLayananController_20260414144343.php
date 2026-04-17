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
        'deskripsi' => 'required|min:10',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $penghuni = Penghuni::where('email', Auth::user()->email)->firstOrFail();

    $fotoPath = null;

    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('pengaduan', 'public');
    }

    Layanan::create([
        'penghuni_id' => $penghuni->id,
        'tanggal_pengaduan' => now(),
        'kategori_masalah' => $request->kategori_masalah,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
        'status' => 'diajukan'
    ]);

    return redirect()->route('user.layanan.status')
        ->with('success', 'Pengaduan berhasil dikirim!');
}

    public function status()
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->firstOrFail();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan!');
        }

        $layanan = Layanan::where('penghuni_id', $penghuni->id)
            ->latest()
            ->get();

        return view('user.layanan.status', compact('layanan'));
    }

    public function delete($id)
{
    // ambil data dari session
    $hidden = session()->get('hidden_pengaduan', []);

    // tambahkan id ke list hidden
    $hidden[] = $id;

    // simpan kembali ke session
    session()->put('hidden_pengaduan', $hidden);

    return back()->with('success', 'Pengaduan disembunyikan dari halaman ini');
}
}

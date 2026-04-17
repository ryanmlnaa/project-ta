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

        return view('user.home', compact('penghuni'));
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

        // ambil semua rumah
        $rumah = Rumah::all();

        return view('user.rumah', compact('penghuni', 'rumah'));
    }
    // =========================
    // 🔥 TAMBAHAN: PILIH RUMAH
    // =========================
    public function pilihRumah($id)
    {
        $rumah = Rumah::findOrFail($id);

        // kalau sudah terisi
        if ($rumah->status == 'Terisi') {
            return back()->with('error', 'Rumah sudah terisi');
        }

        // cari penghuni berdasarkan email user login
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        // kalau belum ada, buat otomatis
        if (!$penghuni) {
            $penghuni = Penghuni::create([
                'nama' => Auth::user()->name,
                'email' => Auth::user()->email,
                'status' => 'Aktif'
            ]);
        }

        // update rumah ke penghuni
        $penghuni->update([
            'rumah_id' => $rumah->id
        ]);

        // update status rumah
        $rumah->update([
            'status' => 'Terisi'
        ]);

        return back()->with('success', 'Berhasil memilih rumah');
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

    public function simpanRumah(Request $request)
{
    // kalau belum ada rumah → create
    $rumah = Rumah::updateOrCreate(
        ['id' => $request->rumah_id],
        [
            'blok' => $request->blok,
            'no_rumah' => $request->no_rumah,
            'status' => 'Terisi',
            'luas_tanah' => $request->luas_tanah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
        ]
    );

        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            $penghuni = Penghuni::create([
                'nama' => Auth::user()->name,
                'email' => Auth::user()->email,
                'status' => 'Aktif'
            ]);
        }

        $penghuni->update([
            'rumah_id' => $rumah->id
        ]);

        return redirect()->route('user.rumah')
    ->with('success', 'Rumah berhasil dipilih');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with('penghuni')->latest()->get();
        $penghuni = Penghuni::all();

        return view('admin.layanan.index', compact('layanan', 'penghuni'));
    }

    public function store(Request $request)
    {
        Layanan::create([
            'penghuni_id'       => $request->penghuni_id,
            'tanggal_pengaduan' => now(),
            'kategori_masalah'  => $request->kategori_masalah,
            'deskripsi'         => $request->deskripsi,
            'status'            => 'diajukan'
        ]);

        return back()->with('success', 'Pengaduan berhasil ditambahkan');
    }

    public function tanggapi(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

       $layanan->update([
            'tanggapan_admin' => $request->tanggapan_admin,
            'status' => $request->status
        ]);

        return back()->with('success', 'Tanggapan berhasil diberikan');
    }

    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function tanggapi(Request $request, $id)
{
    // VALIDASI
    $request->validate([
        'tanggapan_admin' => 'required|string',
        'status' => 'required|in:diproses,selesai'
    ]);

    // AMBIL DATA
    $layanan = Layanan::find($id);

    if (!$layanan) {
        return back()->with('error', 'Data tidak ditemukan');
    }

    // UPDATE DATA
    $layanan->tanggapan_admin = $request->tanggapan_admin;
    $layanan->status = $request->status;
    $layanan->save();

    return back()->with('success', 'Tanggapan berhasil diberikan');
}
}

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

    use Illuminate\Http\Request;

    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }


}

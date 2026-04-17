<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use App\Models\Penghuni;

class IuranController extends Controller
{
    public function index()
    {
        $iuran = Iuran::with('penghuni')->get(); // relasi ke penghuni
        return view('admin.iuran.index', compact('iuran'));
    }

    public function create()
    {
        $penghuni = Penghuni::all(); // ambil data penghuni
        return view('admin.iuran.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
            'jenis_iuran' => 'required', // 🔥 WAJIB
            'keterangan' => 'required', // 🔥 tambahkan ini
            'status' => 'required|in:lunas,belum',
        ]);

        Iuran::create([
            'penghuni_id' => $request->penghuni_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'jenis_iuran' => $request->jenis_iuran, // ✅
            'keterangan' => $request->keterangan, // ✅
            'status' => 'belum',
            'tanggal_bayar' => $request->status == 'lunas' ? now() : null,
        ]);

        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $iuran = Iuran::findOrFail($id);
        $penghuni = Penghuni::all();

        return view('admin.iuran.edit', compact('iuran', 'penghuni'));
    }

    public function update(Request $request, $id)
{
    $iuran = Iuran::findOrFail($id);

    $request->validate([
        'penghuni_id' => 'required',
        'bulan' => 'required',
        'tahun' => 'required',
        'jumlah' => 'required',
        'jenis_iuran' => 'required',
        'keterangan' => 'required',
        'status' => 'required',
    ]);

    $iuran->update([
        'penghuni_id' => $request->penghuni_id,
        'bulan' => $request->bulan,
        'tahun' => $request->tahun,
        'jumlah' => $request->jumlah,
        'jenis_iuran' => $request->jenis_iuran,
        'keterangan' => $request->keterangan,
        'status' => $request->status,
        'tanggal_bayar' => $request->status == 'lunas'
            ? ($request->tanggal_bayar ?? now())
            : null,
    ]);

    return redirect()->route('iuran.index')->with('success', 'Data berhasil diupdate');
}

   public function destroy($id)
    {
        $iuran = Iuran::findOrFail($id);
        $iuran->delete();

        return redirect()->route('iuran.index')->with('success', 'Data berhasil dihapus');
    }

    public function approve($id)
    {
        $iuran = Iuran::findOrFail($id);

        $iuran->update([
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::now() // 🔥 otomatis waktu Indonesia
        ]);

        return back()->with('success', 'Pembayaran berhasil di-approve');
    }
}

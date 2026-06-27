<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IuranController extends Controller
{
    // Daftar iuran yang dibuat bendahara ini
    public function index()
    {
        $bendahara = Auth::user();

        $iurans = Iuran::where('dibuat_oleh', $bendahara->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('bendahara.iuran.index', compact('iurans'));
    }

    // Form buat iuran baru
    public function create()
    {
        $bendahara = Auth::user();
        $penghunis = \App\Models\Penghuni::where('rt_id', $bendahara->rt_id)->get();

        return view('bendahara.iuran.create', compact('penghunis'));
    }

    // Simpan iuran baru -> status otomatis 'diajukan'
    public function store(Request $request)
    {
        $bendahara = Auth::user();

        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'bulan'       => 'required',
            'tahun'       => 'required',
            'jumlah'      => 'required|numeric',
            'jenis_iuran' => 'required',
        ]);

        Iuran::create([
            'penghuni_id' => $request->penghuni_id,
            'rt_id'       => $bendahara->rt_id,
            'dibuat_oleh' => $bendahara->id,
            'bulan'       => $request->bulan,
            'tahun'       => $request->tahun,
            'jumlah'      => $request->jumlah,
            'jenis_iuran' => $request->jenis_iuran,
            'keterangan'  => $request->keterangan,
            'status'      => 'diajukan',
        ]);

        return redirect()->route('bendahara.iuran.index')->with('success', 'Iuran berhasil diajukan ke RT.');
    }

    // Form edit iuran yang ditolak
    public function edit($id)
    {
        $bendahara = Auth::user();

        $iuran = Iuran::where('id', $id)
                      ->where('dibuat_oleh', $bendahara->id)
                      ->where('status', 'ditolak')
                      ->firstOrFail();

        $penghunis = \App\Models\Penghuni::where('rt_id', $bendahara->rt_id)->get();

        return view('bendahara.iuran.edit', compact('iuran', 'penghunis'));
    }

    // Update iuran yang ditolak -> ajukan ulang (status balik ke 'diajukan')
    public function update(Request $request, $id)
    {
        $bendahara = Auth::user();

        $iuran = Iuran::where('id', $id)
                      ->where('dibuat_oleh', $bendahara->id)
                      ->where('status', 'ditolak')
                      ->firstOrFail();

        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'bulan'       => 'required',
            'tahun'       => 'required',
            'jumlah'      => 'required|numeric',
            'jenis_iuran' => 'required',
        ]);

        $iuran->update([
            'penghuni_id' => $request->penghuni_id,
            'bulan'       => $request->bulan,
            'tahun'       => $request->tahun,
            'jumlah'      => $request->jumlah,
            'jenis_iuran' => $request->jenis_iuran,
            'keterangan'  => $request->keterangan,
            'status'      => 'diajukan', // ajukan ulang
            'catatan_rt'  => null,       // reset catatan penolakan lama
        ]);

        return redirect()->route('bendahara.iuran.index')->with('success', 'Iuran berhasil diajukan ulang ke RT.');
    }

    // Bendahara konfirmasi iuran 'menunggu' jadi 'lunas' langsung
    public function konfirmasiLunas($id)
    {
        $bendahara = Auth::user();

        $iuran = Iuran::where('id', $id)
                      ->where('dibuat_oleh', $bendahara->id)
                      ->where('status', 'menunggu')
                      ->firstOrFail();

        $iuran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        return back()->with('success', 'Iuran dikonfirmasi lunas.');
    }
}

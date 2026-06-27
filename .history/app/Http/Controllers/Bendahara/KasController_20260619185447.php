<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\KasBendahara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasController extends Controller
{
    // Riwayat kas + saldo berjalan
    public function index()
    {
        $bendahara = Auth::user();

        $kas = KasBendahara::where('bendahara_id', $bendahara->id)
                           ->orderBy('created_at', 'asc')
                           ->get();

        $totalMasuk  = $kas->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $kas->where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        // Urutkan terbaru di atas untuk ditampilkan
        $kas = $kas->sortByDesc('created_at');

        return view('bendahara.kas.index', compact('kas', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    // Catat kas keluar manual
    public function store(Request $request)
    {
        $bendahara = Auth::user();

        $request->validate([
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        KasBendahara::create([
            'bendahara_id' => $bendahara->id,
            'rt_id'        => $bendahara->rt_id,
            'jenis'        => 'keluar',
            'jumlah'       => $request->jumlah,
            'keterangan'   => $request->keterangan,
            'iuran_id'     => null,
        ]);

        return back()->with('success', 'Kas keluar berhasil dicatat.');
    }
}

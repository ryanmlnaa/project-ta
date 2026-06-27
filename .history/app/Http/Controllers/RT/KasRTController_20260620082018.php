<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\KasBendahara;
use Illuminate\Support\Facades\Auth;

class KasRTController extends Controller
{
    public function index()
    {
        $rt = Auth::user();

        $kas = KasBendahara::where('rt_id', $rt->id)
                           ->orderBy('created_at', 'asc')
                           ->get();

        $kasTerhitung = $kas->whereIn('status', ['manual', 'lunas']);

        $totalMasuk  = $kasTerhitung->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $kasTerhitung->where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        return view('rt.kas.index', compact('kas', 'totalMasuk', 'totalKeluar', 'saldo'));
    }
}

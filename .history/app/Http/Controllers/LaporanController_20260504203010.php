<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Iuran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;

        // 🔥 DATA PENGADUAN
        $dataPengaduan = Layanan::whereMonth('created_at', $bulan)->get();

        $sukses = $dataPengaduan->where('status', 'selesai')->count();
        $gagal  = $dataPengaduan->where('status', 'diajukan')->count();

        // 🔥 DATA TAMBAHAN
        $totalRumah   = Rumah::count();
        $totalPenghuni= Penghuni::count();

        $totalIuran = Iuran::whereMonth('created_at', $bulan)->sum('jumlah');

        return view('admin.laporan.index', compact(
            'bulan',
            'sukses',
            'gagal',
            'totalRumah',
            'totalPenghuni',
            'totalIuran'
        ));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;

        // 🔥 DATA PENGADUAN
        $dataPengaduan = Layanan::whereMonth('created_at', $bulan)->get();

        $sukses = $dataPengaduan->where('status', 'selesai')->count();
        $gagal  = $dataPengaduan->where('status', 'diajukan')->count();

        // 🔥 DATA TAMBAHAN
        $totalRumah   = Rumah::count();
        $totalPenghuni= Penghuni::count();
        $totalIuran   = Iuran::whereMonth('created_at', $bulan)->sum('jumlah');

        return view('admin.laporan.cetak', [
        'bulan' => $bulan,
        'sukses' => $sukses,
        'gagal' => $gagal,

        // 🔥 TAMBAHAN INI
        'penghuni' => Penghuni::count(),
        'rumah'    => Rumah::count(),
        'iuran'    => Iuran::sum('jumlah'),

        'data' => $dataPengaduan
    ]);
    }
}

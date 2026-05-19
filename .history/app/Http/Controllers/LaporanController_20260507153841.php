<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Iuran;

class LaporanController extends Controller
{
    // ========================
    // Helper: filter by role
    // ========================
    private function getFilteredData($bulan)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin → semua data
            $pengaduanQuery = Layanan::whereMonth('created_at', $bulan);
            $totalRumah     = Rumah::count();
            $totalPenghuni  = Penghuni::count();
            $totalIuran     = Iuran::whereMonth('created_at', $bulan)->sum('jumlah');
            $penghuni       = Penghuni::with('rumah')->get();
            $dataPengaduan  = $pengaduanQuery->get();

        } else {
            // RT → hanya wilayahnya
            $rtId = $user->id;

            $pengaduanQuery = Layanan::whereMonth('created_at', $bulan)
                ->whereHas('penghuni.rumah', fn($q) => $q->where('rt_id', $rtId));

            $totalRumah    = Rumah::where('rt_id', $rtId)->count();
            $totalPenghuni = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rtId))->count();
            $totalIuran    = Iuran::whereHas('penghuni.rumah', fn($q) => $q->where('rt_id', $rtId))
                                  ->whereMonth('created_at', $bulan)->sum('jumlah');
            $penghuni      = Penghuni::with('rumah')
                                     ->whereHas('rumah', fn($q) => $q->where('rt_id', $rtId))
                                     ->get();
            $dataPengaduan = $pengaduanQuery->get();
        }

        return [
            'totalRumah'    => $totalRumah,
            'totalPenghuni' => $totalPenghuni,
            'totalIuran'    => $totalIuran,
            'penghuni'      => $penghuni,
            'dataPengaduan' => $dataPengaduan,
            'sukses'        => $dataPengaduan->where('status', 'selesai')->count(),
            'gagal'         => $dataPengaduan->where('status', 'diajukan')->count(),
        ];
    }

    // ========================
    // INDEX
    // ========================
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $data  = $this->getFilteredData($bulan);

        // Tentukan view berdasarkan role
        $view = Auth::user()->role === 'admin'
            ? 'admin.laporan.index'
            : 'rt.laporan.index';

        return view('admin.laporan.index', array_merge($data, ['bulan' => $bulan]));
    }

    // ========================
    // CETAK PDF
    // ========================
   public function cetak(Request $request)
{
    $bulan = $request->bulan ?? now()->month;
    $tahun = $request->tahun ?? now()->year;
    $data  = $this->getFilteredData($bulan);
    $user  = Auth::user();

    return view('admin.laporan.cetak', array_merge($data, [
        'bulan'    => $bulan,
        'tahun'    => $tahun,
        'user'     => $user,
        'penghuni' => $data['totalPenghuni'],
        'rumah'    => $data['totalRumah'],
        'iuran'    => $data['totalIuran'],
        'data'     => $data['dataPengaduan'],
    ]));
}
}

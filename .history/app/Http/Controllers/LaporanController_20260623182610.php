<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Iuran;
use App\Models\KasBendahara;
use App\Models\User;

class LaporanController extends Controller
{
    private function getFilteredData($bulan, $tahun)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $dataPengaduan = Layanan::whereMonth('created_at', $bulan)
                                   ->whereYear('created_at', $tahun)
                                   ->get();
            return [
                'dataPengaduan' => $dataPengaduan,
                'sukses'        => $dataPengaduan->where('status', 'selesai')->count(),
                'gagal'         => $dataPengaduan->where('status', 'diajukan')->count(),
            ];

        } else {
            // RT
            $rtId = $user->id;

            $dataPengaduan = Layanan::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->whereHas('penghuni.rumah', fn($q) => $q->where('rt_id', $rtId))
                ->get();

            $totalRumah    = Rumah::where('rt_id', $rtId)->count();
            $totalPenghuni = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rtId))->count();

            $dataIuran = Iuran::where('rt_id', $rtId)
                              ->whereMonth('created_at', $bulan)
                              ->whereYear('created_at', $tahun)
                              ->with('penghuni')
                              ->get();

            // Kas bendahara aktif
            $bendaharaAktif = User::where('rt_id', $rtId)
                                  ->where('role', 'bendahara')
                                  ->where('status_akun', 'aktif')
                                  ->first();

            $dataKas = collect();
            $saldoKas = 0;
            if ($bendaharaAktif) {
                $dataKas = KasBendahara::where('bendahara_id', $bendaharaAktif->id)
                                       ->whereMonth('created_at', $bulan)
                                       ->whereYear('created_at', $tahun)
                                       ->get();
                $kasAll = KasBendahara::where('bendahara_id', $bendaharaAktif->id)
                                      ->whereIn('status', ['manual', 'lunas'])
                                      ->get();
                $saldoKas = $kasAll->where('jenis','masuk')->sum('jumlah')
                          - $kasAll->where('jenis','keluar')->sum('jumlah');
            }

            return [
                'totalRumah'    => $totalRumah,
                'totalPenghuni' => $totalPenghuni,
                'totalIuran'    => $dataIuran->sum('jumlah'),
                'dataIuran'     => $dataIuran,
                'dataKas'       => $dataKas,
                'saldoKas'      => $saldoKas,
                'dataPengaduan' => $dataPengaduan,
                'sukses'        => $dataPengaduan->where('status', 'selesai')->count(),
                'gagal'         => $dataPengaduan->where('status', 'diajukan')->count(),
                'bendaharaAktif' => $bendaharaAktif,
            ];
        }
    }

    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $data  = $this->getFilteredData($bulan, $tahun);
        $view  = Auth::user()->role === 'admin' ? 'admin.laporan.index' : 'rt.laporan.index';

        return view($view, array_merge($data, ['bulan' => $bulan, 'tahun' => $tahun]));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        $data  = $this->getFilteredData($bulan, $tahun);
        $user  = Auth::user();
        $view  = $user->role === 'admin' ? 'admin.laporan.cetak' : 'rt.laporan.cetak';

        return view($view, array_merge($data, [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'user'  => $user,
        ]));
    }
}

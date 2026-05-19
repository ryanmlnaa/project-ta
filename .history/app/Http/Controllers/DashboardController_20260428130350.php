<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 🔥 Statistik status
        $statistik = Layanan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $diajukan = $statistik['diajukan'] ?? 0;
        $menunggu = $statistik['menunggu'] ?? 0;
        $selesai  = $statistik['selesai'] ?? 0;

        return view('rt.dashboard', [
            'totalPenghuni' => Penghuni::count(),
            'totalRumah'    => Rumah::count(),
            'totalIuran'    => Iuran::count(),
            'totalPengaduan'=> Layanan::count(),

            'menungguRT'    => $diajukan,
            'menungguAdmin' => $menunggu,

            'diajukan' => $diajukan,
            'menunggu' => $menunggu,
            'selesai'  => $selesai,
        ]);
    }

    // 🔥 DASHBOARD ADMIN
   public function admin()
{
    $totalPenghuni   = Penghuni::count();
    $totalRumah      = Rumah::count();
    $totalPengaduan  = Layanan::count();
    $totalIuran      = Iuran::sum('jumlah');

    // =========================
    // 🔥 BULANAN (REAL - 12 BULAN)
    // =========================
    $chartBulananRaw = Layanan::selectRaw("MONTH(created_at) as bulan, COUNT(*) as total")
        ->groupBy('bulan')
        ->pluck('total','bulan');

    $chartBulanan = [];
    for ($i = 1; $i <= 12; $i++) {
        $chartBulanan[] = $chartBulananRaw[$i] ?? 0;
    }

    // =========================
    // 🔥 HARIAN (7 HARI TERAKHIR)
    // =========================
    $harianRaw = Layanan::selectRaw("DATE(created_at) as tgl, COUNT(*) as total")
        ->whereDate('created_at', '>=', now()->subDays(6))
        ->groupBy('tgl')
        ->pluck('total','tgl');

    $chartHarian = [];
    for ($i = 6; $i >= 0; $i--) {
        $tgl = now()->subDays($i)->format('Y-m-d');
        $chartHarian[] = $harianRaw[$tgl] ?? 0;
    }

    // =========================
    // 🔥 MINGGUAN (4 MINGGU TERAKHIR)
    // =========================
    $chartMingguan = [];
    for ($i = 3; $i >= 0; $i--) {
        $start = now()->subWeeks($i)->startOfWeek();
        $end   = now()->subWeeks($i)->endOfWeek();

        $total = Layanan::whereBetween('created_at', [$start, $end])->count();
        $chartMingguan[] = $total;
    }

    // =========================
    // 🔥 TAHUNAN (4 TAHUN TERAKHIR)
    // =========================
    $tahunanRaw = Layanan::selectRaw("YEAR(created_at) as tahun, COUNT(*) as total")
        ->groupBy('tahun')
        ->pluck('total','tahun');

    $chartTahunan = [];
    $tahunSekarang = now()->year;

    for ($i = 3; $i >= 0; $i--) {
        $tahun = $tahunSekarang - $i;
        $chartTahunan[] = $tahunanRaw[$tahun] ?? 0;
    }

    return view('admin.dashboard', compact(
        'totalPenghuni',
        'totalRumah',
        'totalPengaduan',
        'totalIuran',
        'chartHarian',
        'chartMingguan',
        'chartBulanan',
        'chartTahunan'
    ));
}}

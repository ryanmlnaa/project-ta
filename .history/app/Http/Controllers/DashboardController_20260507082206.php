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
        $rtId = $user->id; // rt_id di tabel rumah = user id si RT

        // Statistik status layanan
        $statistik = Layanan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $diajukan = $statistik['diajukan'] ?? 0;
        $menunggu = $statistik['menunggu'] ?? 0;
        $selesai  = $statistik['selesai'] ?? 0;

        // ── PER RT ──
        $rt1Id = 13; // blok D
        $rt2Id = 19; // blok E
        $rt3Id = 28; // blok C
        // (blok B = 34, kalau ada RT ke-4)

        $rt1_penghuni     = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rt1Id))->count();
        $rt2_penghuni     = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rt2Id))->count();
        $rt3_penghuni     = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rt3Id))->count();

        $rt1_rumah_terisi = Rumah::where('rt_id', $rt1Id)->where('status', 'Terisi')->count();
        $rt2_rumah_terisi = Rumah::where('rt_id', $rt2Id)->where('status', 'Terisi')->count();
        $rt3_rumah_terisi = Rumah::where('rt_id', $rt3Id)->where('status', 'Terisi')->count();

        $rt1_rumah_total  = Rumah::where('rt_id', $rt1Id)->count();
        $rt2_rumah_total  = Rumah::where('rt_id', $rt2Id)->count();
        $rt3_rumah_total  = Rumah::where('rt_id', $rt3Id)->count();

        return view('rt.dashboard', [
            'totalPenghuni'   => Penghuni::count(),
            'totalRumah'      => Rumah::count(),
            'totalIuran'      => Iuran::count(),
            'totalPengaduan'  => Layanan::count(),
            'menungguRT'      => $diajukan,
            'menungguAdmin'   => $menunggu,
            'diajukan'        => $diajukan,
            'menunggu'        => $menunggu,
            'selesai'         => $selesai,

            // ── tambahan per RT ──
            'rt1_penghuni'    => $rt1_penghuni,
            'rt2_penghuni'    => $rt2_penghuni,
            'rt3_penghuni'    => $rt3_penghuni,
            'rt1_rumah_terisi'=> $rt1_rumah_terisi,
            'rt2_rumah_terisi'=> $rt2_rumah_terisi,
            'rt3_rumah_terisi'=> $rt3_rumah_terisi,
            'rt1_rumah_total' => $rt1_rumah_total,
            'rt2_rumah_total' => $rt2_rumah_total,
            'rt3_rumah_total' => $rt3_rumah_total,
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

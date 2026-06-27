<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Iuran;
use App\Models\KasBendahara;
use App\Models\RekapIuran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
    {
        $rtId = Auth::id(); // rt_id di tabel rumah = id user yang login

       $statistik = Layanan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $diajukan = $statistik['diajukan'] ?? 0;
        $menunggu = $statistik['menunggu'] ?? 0;
        $selesai  = $statistik['selesai'] ?? 0;

        // Data chart bulanan real (12 bulan)
        $chartDiajukan = [];
        $chartMenunggu = [];
        $chartSelesai  = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = now()->subMonths($i)->month;
            $tahun = now()->subMonths($i)->year;
            $chartDiajukan[] = Layanan::where('status','diajukan')->whereMonth('created_at',$bulan)->whereYear('created_at',$tahun)->count();
            $chartMenunggu[] = Layanan::where('status','menunggu')->whereMonth('created_at',$bulan)->whereYear('created_at',$tahun)->count();
            $chartSelesai[]  = Layanan::where('status','selesai')->whereMonth('created_at',$bulan)->whereYear('created_at',$tahun)->count();
        }

        // Data khusus RT yang sedang login
        $totalPenghuni = Penghuni::whereHas('rumah', fn($q) => $q->where('rt_id', $rtId))->count();
        $totalRumah    = Rumah::where('rt_id', $rtId)->count();
        $rumahTerisi   = Rumah::where('rt_id', $rtId)->where('status', 'Terisi')->count();
        $rumahKosong   = Rumah::where('rt_id', $rtId)->where('status', 'Kosong')->count();

        // Data bendahara aktif milik RT ini
        $bendaharaAktif = User::where('rt_id', $rtId)
                              ->where('role', 'bendahara')
                              ->where('status_akun', 'aktif')
                              ->first();

        $menungguKonfirmasi  = 0;
        $lunasBuilanIni      = 0;
        $saldoKas            = 0;
        $rekapBelumDikirim   = 0;
        $tagihanKasBelumBayar = 0;

        if ($bendaharaAktif) {
            $menungguKonfirmasi = Iuran::where('dibuat_oleh', $bendaharaAktif->id)
                                       ->where('status', 'menunggu')
                                       ->count();

            $lunasBuilanIni = Iuran::where('dibuat_oleh', $bendaharaAktif->id)
                                   ->where('status', 'lunas')
                                   ->whereMonth('updated_at', now()->month)
                                   ->whereYear('updated_at', now()->year)
                                   ->count();

            $kas = KasBendahara::where('bendahara_id', $bendaharaAktif->id)
                               ->whereIn('status', ['manual', 'lunas'])
                               ->get();
            $saldoKas = $kas->where('jenis', 'masuk')->sum('jumlah')
                      - $kas->where('jenis', 'keluar')->sum('jumlah');

            $rekapBelumDikirim = Iuran::where('dibuat_oleh', $bendaharaAktif->id)
                                      ->where('status', 'lunas')
                                      ->whereNull('rekap_id')
                                      ->count();

            $tagihanKasBelumBayar = KasBendahara::where('bendahara_id', $bendaharaAktif->id)
                                                ->where('status', 'menunggu_bayar')
                                                ->count();
        }

        return view('rt.dashboard', [
            'totalPenghuni'        => $totalPenghuni,
            'totalRumah'           => $totalRumah,
            'rumahTerisi'          => $rumahTerisi,
            'rumahKosong'          => $rumahKosong,
            'totalIuran'           => Iuran::count(),
            'totalPengaduan'       => Layanan::count(),
            'menungguRT'           => $diajukan,
            'menungguAdmin'        => $menunggu,
            'diajukan'             => $diajukan,
            'menunggu'             => $menunggu,
            'selesai'              => $selesai,
            'bendaharaAktif'       => $bendaharaAktif,
            'menungguKonfirmasi'   => $menungguKonfirmasi,
            'lunasBuilanIni'       => $lunasBuilanIni,
            'saldoKas'             => $saldoKas,
            'rekapBelumDikirim'    => $rekapBelumDikirim,
            'tagihanKasBelumBayar' => $tagihanKasBelumBayar,
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
        }
}

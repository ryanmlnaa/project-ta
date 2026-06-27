<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use App\Models\Penghuni;
use App\Models\Rumah;
use App\Models\Layanan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class IuranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $iuran = Iuran::with('penghuni')->get();
        } else {
            $iuran = Iuran::with('penghuni')
                ->where('rt_id', $user->id)
                ->get();
        }

        return view('admin.iuran.index', compact('iuran'));
    }

    public function create()
    {
        $rtId = Auth::id();

        $penghuni = Penghuni::where('rt_id', $rtId)->get();

        return view('admin.iuran.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
            'jenis_iuran' => 'required',
            'keterangan' => 'required',
        ]);

        // 🔥 ambil penghuni
        $penghuni = Penghuni::findOrFail($request->penghuni_id);

        Iuran::create([
            'penghuni_id' => $request->penghuni_id,

            // 🔥 FIX UTAMA (ambil dari penghuni)
            'rt_id' => $penghuni->rt_id,

            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'jenis_iuran' => $request->jenis_iuran,
            'keterangan' => $request->keterangan,
            'status' => 'belum',
        ]);

         // 🔥 WHATSAPP
        $penghuni = Penghuni::find($request->penghuni_id);

        if ($penghuni && $penghuni->telepon) {
            $nohp = preg_replace('/^0/', '62', $penghuni->telepon);

            $pesan = "Halo {$penghuni->nama},\n";
            $pesan .= "Iuran baru ditambahkan:\n";
            $pesan .= "Bulan: {$request->bulan} {$request->tahun}\n";
            $pesan .= "Jumlah: Rp " . number_format($request->jumlah,0,',','.') . "\n";
            $pesan .= "Jenis: {$request->jenis_iuran}\n";
            $pesan .= "Terima kasih 🙏";

            Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $nohp,
                'message' => $pesan,
            ]);
        }

        return redirect()->route('iuran.index')
            ->with('success', 'Data iuran berhasil ditambahkan');
    }
    public function edit($id)
    {
        $iuran = Iuran::where('rt_id', Auth::id())->findOrFail($id);
        $penghuni = Penghuni::where('rt_id', Auth::id())->get();

        return view('admin.iuran.edit', compact('iuran', 'penghuni'));
    }

    public function update(Request $request, $id)
    {
        $iuran = Iuran::where('rt_id', Auth::id())->findOrFail($id);

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
            'tanggal_bayar' => $request->status == 'lunas' ? now() : null,
        ]);

        return redirect()->route('iuran.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $iuran = Iuran::where('rt_id', Auth::id())->findOrFail($id);
        $iuran->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function dashboardRT()
    {
        $rtId = Auth::id();

       $totalPenghuni = Penghuni::count();
        $totalRumah = Rumah::count();
        $totalIuran = Iuran::count();
        $totalPengaduan = Layanan::count();

        $menungguRT = Iuran::where('rt_id', $rtId)
            ->where('status', 'belum')
            ->count();

        $menungguAdmin = Iuran::where('rt_id', $rtId)
            ->where('status', 'proses')
            ->count();

        return view('rt.dashboard', compact(
            'totalPenghuni',
            'totalRumah',
            'totalIuran',
            'totalPengaduan',
            'menungguRT',
            'menungguAdmin'
        ));
    }

    public function approveRT($id)
    {
        $iuran = Iuran::where('rt_id', Auth::id())->findOrFail($id);

        // Pastikan ada bukti sebelum approve
        if (!$iuran->bukti_pembayaran) {
            return back()->with('error', 'Tidak bisa approve, belum ada bukti pembayaran!');
        }

        $iuran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now()
        ]);

        // Kirim notif WA ke penghuni
        $penghuni = $iuran->penghuni;
        if ($penghuni && $penghuni->telepon) {
            $nohp = preg_replace('/^0/', '62', $penghuni->telepon);
            $pesan = "Halo {$penghuni->nama},\n";
            $pesan .= "Pembayaran iuran Anda telah diverifikasi RT.\n";
            $pesan .= "Bulan: {$iuran->bulan} {$iuran->tahun}\n";
            $pesan .= "Jumlah: Rp " . number_format($iuran->jumlah,0,',','.') . "\n";
            $pesan .= "Status: LUNAS ✅\nTerima kasih 🙏";

            \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $nohp,
                'message' => $pesan,
            ]);
        }

        return back()->with('success', 'Iuran disetujui dan dinyatakan lunas');
    }

    public function generateMassal(Request $request)
    {
        $request->validate([
            'bulan'      => 'required',
            'tahun'      => 'required',
            'jumlah'     => 'required|numeric',
            'jenis_iuran'=> 'required',
            'keterangan' => 'nullable',
        ]);

        $rtId     = Auth::id();
        $penghuni = \App\Models\Penghuni::where('rt_id', $rtId)->get();

        $dibuat = 0;
        foreach ($penghuni as $p) {
            // Cek agar tidak double generate bulan yang sama
            $sudahAda = Iuran::where('penghuni_id', $p->id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->where('jenis_iuran', $request->jenis_iuran)
                ->exists();

            if (!$sudahAda) {
                Iuran::create([
                    'penghuni_id' => $p->id,
                    'rt_id'       => $rtId,
                    'bulan'       => $request->bulan,
                    'tahun'       => $request->tahun,
                    'jumlah'      => $request->jumlah,
                    'jenis_iuran' => $request->jenis_iuran,
                    'keterangan'  => $request->keterangan,
                    'status'      => 'belum',
                ]);
                $dibuat++;

                // Kirim WA notifikasi
                if ($p->telepon) {
                    $nohp = preg_replace('/^0/', '62', $p->telepon);
                    $pesan = "Halo {$p->nama},\nTagihan iuran baru:\nBulan: {$request->bulan} {$request->tahun}\nJumlah: Rp " . number_format($request->jumlah,0,',','.') . "\nJenis: {$request->jenis_iuran}\nSilakan bayar via QRIS. Terima kasih 🙏";

                    \Illuminate\Support\Facades\Http::withHeaders([
                        'Authorization' => env('FONNTE_TOKEN')
                    ])->post('https://api.fonnte.com/send', [
                        'target'  => $nohp,
                        'message' => $pesan,
                    ]);
                }
            }
        }

        return redirect()->route('iuran.index')
            ->with('success', "Berhasil generate {$dibuat} tagihan iuran untuk semua penghuni RT");
    }

    //     public function approveAdmin($id)
    // {
    //     $iuran = Iuran::findOrFail($id);

    //     $iuran->update([
    //         'status' => 'lunas',
    //         'tanggal_bayar' => now()
    //     ]);

    //     return back()->with('success', 'Iuran disetujui admin');
    // }
}

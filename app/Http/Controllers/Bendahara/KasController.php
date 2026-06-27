<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\KasBendahara;
use App\Models\Penghuni;
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

        $kasTerhitung = $kas->whereIn('status', ['manual', 'lunas']);

        $totalMasuk  = $kasTerhitung->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $kasTerhitung->where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        $kas = $kas->sortByDesc('created_at');

        return view('bendahara.kas.index', compact('kas', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    // Catat kas manual (masuk ATAU keluar, tanpa penghuni)
    public function store(Request $request)
    {
        $bendahara = Auth::user();

        $request->validate([
            'jenis'      => 'required|in:masuk,keluar',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        KasBendahara::create([
            'bendahara_id' => $bendahara->id,
            'rt_id'        => $bendahara->rt_id,
            'penghuni_id'  => null,
            'jenis'        => $request->jenis,
            'jumlah'       => $request->jumlah,
            'keterangan'   => $request->keterangan,
            'status'       => 'manual',
            'iuran_id'     => null,
        ]);

        return back()->with('success', 'Kas berhasil dicatat.');
    }

    // Form buat tagihan kas ke penghuni
    public function createTagihan()
    {
        $bendahara = Auth::user();
        $penghunis = Penghuni::where('rt_id', $bendahara->rt_id)->get();

        return view('bendahara.kas.create-tagihan', compact('penghunis'));
    }

    // Simpan tagihan kas ke penghuni -> status 'menunggu_bayar'
    public function storeTagihan(Request $request)
    {
        $bendahara = Auth::user();

        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'required|string|max:255',
        ]);

        KasBendahara::create([
            'bendahara_id' => $bendahara->id,
            'rt_id'        => $bendahara->rt_id,
            'penghuni_id'  => $request->penghuni_id,
            'jenis'        => 'masuk',
            'jumlah'       => $request->jumlah,
            'keterangan'   => $request->keterangan,
            'status'       => 'menunggu_bayar',
            'iuran_id'     => null,
        ]);

        return redirect()->route('bendahara.kas.index')->with('success', 'Tagihan kas berhasil dikirim ke penghuni.');
    }

    // Bendahara konfirmasi kas yang sudah dibayar penghuni -> jadi 'lunas'
    public function konfirmasi($id)
    {
        $bendahara = Auth::user();

        $kas = KasBendahara::where('id', $id)
                           ->where('bendahara_id', $bendahara->id)
                           ->where('status', 'menunggu_konfirmasi')
                           ->firstOrFail();

        $kas->update(['status' => 'lunas']);

        return back()->with('success', 'Pembayaran kas dikonfirmasi.');
    }
}

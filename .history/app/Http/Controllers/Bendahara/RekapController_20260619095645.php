<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use App\Models\RekapIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    // Daftar rekap yang sudah dikirim bendahara ini
    public function index()
    {
        $bendahara = Auth::user();

        $rekaps = RekapIuran::where('bendahara_id', $bendahara->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Iuran berstatus 'menunggu' yang belum masuk rekap manapun
        $iuranSiapRekap = Iuran::where('rt_id', $bendahara->rt_id)
                               ->where('status', 'menunggu')
                               ->whereNull('rekap_id')
                               ->get();

        return view('bendahara.rekap.index', compact('rekaps', 'iuranSiapRekap'));
    }

    // Kirim rekap baru -> kumpulkan semua iuran 'menunggu' jadi 1 batch
    public function store(Request $request)
    {
        $bendahara = Auth::user();

        $iuranIds = Iuran::where('rt_id', $bendahara->rt_id)
                         ->where('status', 'menunggu')
                         ->whereNull('rekap_id')
                         ->pluck('id');

        if ($iuranIds->isEmpty()) {
            return back()->withErrors(['rekap' => 'Tidak ada iuran berstatus menunggu untuk direkap.']);
        }

        $rekap = RekapIuran::create([
            'bendahara_id' => $bendahara->id,
            'rt_id'        => $bendahara->rt_id,
            'periode'      => $request->periode ?? now()->translatedFormat('F Y'),
            'status'       => 'diajukan',
        ]);

        Iuran::whereIn('id', $iuranIds)->update(['rekap_id' => $rekap->id]);

        return redirect()->route('bendahara.rekap.index')->with('success', 'Rekap berhasil dikirim ke RT.');
    }

    // Lihat detail isi 1 rekap
    public function show($id)
    {
        $bendahara = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('bendahara_id', $bendahara->id)
                           ->with('iurans.penghuni')
                           ->firstOrFail();

        return view('bendahara.rekap.show', compact('rekap'));
    }
}

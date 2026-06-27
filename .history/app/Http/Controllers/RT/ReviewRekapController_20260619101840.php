<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\RekapIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ReviewRekapController extends Controller
{
    // Daftar rekap berstatus 'diajukan' yang menunggu review RT
    public function index()
    {
        $rt = Auth::user();

        $rekaps = RekapIuran::where('rt_id', $rt->id)
                            ->where('status', 'diajukan')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('rt.review-rekap.index', compact('rekaps'));
    }

    // Lihat detail isi rekap sebelum setuju/tolak
    public function show($id)
    {
        $rt = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->with('iurans.penghuni', 'bendahara')
                           ->firstOrFail();

        return view('rt.review-rekap.show', compact('rekap'));
    }

    // RT setujui -> semua iuran di rekap ini otomatis jadi 'lunas'
    public function setujui($id)
    {
        $rt = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->where('status', 'diajukan')
                           ->firstOrFail();

        $rekap->update(['status' => 'disetujui']);

        $rekap->iurans()->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        return redirect()->route('rt.review-rekap.index')->with('success', 'Rekap disetujui, semua iuran di dalamnya jadi lunas.');
    }

    // RT tolak -> rekap_id dilepas dari semua iuran, supaya bisa direkap ulang
    public function tolak(Request $request, $id)
    {
        $rt = Auth::user();

        $request->validate([
            'catatan_rt' => 'required|string',
        ]);

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->where('status', 'diajukan')
                           ->firstOrFail();

        // Lepas rekap_id dari semua iuran di dalamnya
        $rekap->iurans()->update(['rekap_id' => null]);

        $rekap->update([
            'status'     => 'ditolak',
            'catatan_rt' => $request->catatan_rt,
        ]);

        return redirect()->route('rt.review-rekap.index')->with('success', 'Rekap ditolak, iuran dikembalikan untuk direkap ulang.');
    }
}

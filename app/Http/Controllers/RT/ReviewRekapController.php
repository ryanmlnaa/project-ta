<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\RekapIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewRekapController extends Controller
{
    public function index()
    {
        $rt = Auth::user();

        $rekaps = RekapIuran::where('rt_id', $rt->id)
                            ->where('status', 'diajukan')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('rt.review-rekap.index', compact('rekaps'));
    }

    public function show($id)
    {
        $rt = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->with('iurans.penghuni', 'bendahara')
                           ->firstOrFail();

        return view('rt.review-rekap.show', compact('rekap'));
    }

    // RT setujui -> rekap selesai, iuran TETAP lunas (sudah lunas duluan dari bendahara)
    public function setujui($id)
    {
        $rt = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->where('status', 'diajukan')
                           ->firstOrFail();

        $rekap->update(['status' => 'disetujui']);

        return redirect()->route('rt.review-rekap.index')->with('success', 'Rekap disetujui.');
    }

    // RT tolak -> rekap_id dilepas, iuran balik jadi 'menunggu' lagi
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

        // Lepas rekap_id + balikin status iuran jadi 'menunggu'
        $rekap->iurans()->update([
            'rekap_id' => null,
            'status'   => 'menunggu',
        ]);

        $rekap->update([
            'status'     => 'ditolak',
            'catatan_rt' => $request->catatan_rt,
        ]);

        return redirect()->route('rt.review-rekap.index')->with('success', 'Rekap ditolak, iuran dikembalikan ke bendahara.');
    }
}

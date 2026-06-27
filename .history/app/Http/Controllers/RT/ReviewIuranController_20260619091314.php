<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\Iuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewIuranController extends Controller
{
    // Daftar iuran berstatus 'diajukan' yang menunggu review RT
    public function index()
    {
        $rt = Auth::user();

        $iurans = Iuran::where('rt_id', $rt->id)
                       ->where('status', 'diajukan')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('rt.review-iuran.index', compact('iurans'));
    }

    // RT setujui -> status jadi 'aktif' (tampil ke penghuni)
    public function setujui($id)
    {
        $rt = Auth::user();

        $iuran = Iuran::where('id', $id)
                      ->where('rt_id', $rt->id)
                      ->where('status', 'diajukan')
                      ->firstOrFail();

        $iuran->update(['status' => 'aktif']);

        return back()->with('success', 'Iuran disetujui dan tampil ke penghuni.');
    }

    // RT tolak -> status jadi 'ditolak' + catatan alasan
    public function tolak(Request $request, $id)
    {
        $rt = Auth::user();

        $request->validate([
            'catatan_rt' => 'required|string',
        ]);

        $iuran = Iuran::where('id', $id)
                      ->where('rt_id', $rt->id)
                      ->where('status', 'diajukan')
                      ->firstOrFail();

        $iuran->update([
            'status'     => 'ditolak',
            'catatan_rt' => $request->catatan_rt,
        ]);

        return back()->with('success', 'Iuran ditolak, bendahara akan diminta merevisi.');
    }
}

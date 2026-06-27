<?php

namespace App\Http\Controllers\RT;

use App\Http\Controllers\Controller;
use App\Models\RekapIuran;
use Illuminate\Support\Facades\Auth;

class ReviewRekapController extends Controller
{
    // Daftar SEMUA rekap (laporan, bukan untuk approval)
    public function index()
    {
        $rt = Auth::user();

        $rekaps = RekapIuran::where('rt_id', $rt->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('rt.review-rekap.index', compact('rekaps'));
    }

    // Lihat detail isi rekap (read only)
    public function show($id)
    {
        $rt = Auth::user();

        $rekap = RekapIuran::where('id', $id)
                           ->where('rt_id', $rt->id)
                           ->with('iurans.penghuni', 'bendahara')
                           ->firstOrFail();

        return view('rt.review-rekap.show', compact('rekap'));
    }
}

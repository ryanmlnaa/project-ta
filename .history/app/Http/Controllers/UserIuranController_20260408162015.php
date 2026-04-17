<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;

class UserIuranController extends Controller
{
    // 🔹 LIHAT DATA IURAN
    public function index()
    {
        $iuran = Iuran::where('penghuni_id', Auth::user()->id)->get();
        return view('user.iuran.index', compact('iuran'));
    }

    // 🔹 FORM UPLOAD
    public function upload($id)
    {
        $iuran = Iuran::findOrFail($id);
        return view('user.iuran.upload', compact('iuran'));
    }

    // 🔹 SIMPAN BUKTI BAYAR
    public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $iuran = Iuran::findOrFail($id);

         // 🔥 CEK FILE
        if ($request->hasFile('bukti_pembayaran')) {

            $file = $request->file('bukti_pembayaran');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            // simpan ke folder public/bukti
            $file->move(public_path('bukti'), $namaFile);

            // 🔥 SIMPAN KE DATABASE (INI YANG KAMU TANYA)
            $iuran->update([
                'bukti_pembayaran' => $namaFile,
                'status' => 'belum'
            ]);
        }

        return redirect()->route('user.iuran.status')
            ->with('success', 'Bukti pembayaran berhasil diupload');
    }

    // 🔹 STATUS PEMBAYARAN
    public function status()
    {
        $iuran = Iuran::where('penghuni_id', Auth::user()->id)->get();
        return view('user.iuran.status', compact('iuran'));
    }
}

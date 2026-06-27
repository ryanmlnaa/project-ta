<?php

namespace App\Http\Controllers;

use App\Models\KasBendahara;
use Illuminate\Http\Request;

class UserKasController extends Controller
{
    public function bayarQris($id)
    {
        $kas = KasBendahara::where('id', $id)->where('status', 'menunggu_bayar')->firstOrFail();

        $kas->update([
            'status' => 'menunggu_konfirmasi',
            'metode' => 'qris',
        ]);

        return response()->json(['success' => true]);
    }

    public function upload($id)
    {
        $kas = KasBendahara::where('id', $id)->where('status', 'menunggu_bayar')->firstOrFail();
        return view('user.kas.upload', compact('kas'));
    }

    public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $kas = KasBendahara::where('id', $id)->where('status', 'menunggu_bayar')->firstOrFail();

        $file = $request->file('bukti_pembayaran');
        $namaFile = time() . '_kas.' . $file->getClientOriginalExtension();
        $file->move(public_path('bukti'), $namaFile);

        $kas->update([
            'bukti_pembayaran' => $namaFile,
            'status' => 'menunggu_konfirmasi',
            'metode' => 'upload',
        ]);

        return redirect()->route('user.iuran.index')->with('success', 'Bukti kas berhasil diupload.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;

class UserIuranController extends Controller
{
   public function index()
    {
        $penghuni = \App\Models\Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan');
        }

        $iuran = Iuran::where('penghuni_id', $penghuni->id)->get();

        return view('user.iuran.index', compact('iuran'));
    }

    Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/iuran', [UserIuranController::class, 'index'])->name('user.iuran.index');

    Route::post('/iuran/qris/{id}', [UserIuranController::class, 'bayarQris'])
        ->name('user.iuran.qris');
});

Route::get('/admin/iuran/realtime', [IuranController::class, 'realtime'])
    ->name('iuran.realtime');

    public function upload($id)
    {
        $iuran = Iuran::findOrFail($id);
        return view('user.iuran.upload', compact('iuran'));
    }

    public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $iuran = Iuran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {

            $file = $request->file('bukti_pembayaran');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('bukti'), $namaFile);

            $iuran->update([
                'bukti_pembayaran' => $namaFile,
                'status' => 'belum'
            ]);
        }

        return redirect()->route('user.iuran.status')
            ->with('success', 'Bukti pembayaran berhasil diupload');
    }

   public function status()
    {
        $penghuni = \App\Models\Penghuni::where('email', Auth::user()->email)->first();

        $iuran = Iuran::where('penghuni_id', $penghuni->id)->get();

        return view('user.iuran.status', compact('iuran'));
    }
}

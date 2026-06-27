<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iuran;
use Illuminate\Support\Facades\Auth;
use App\Models\KasBendahara;

class UserIuranController extends Controller
{
        public function index()
    {
        $penghuni = \App\Models\Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan');
        }

        // Hanya tampilkan iuran yang sudah disetujui RT (bukan 'diajukan' atau 'ditolak')
        $iuran = Iuran::where('penghuni_id', $penghuni->id)
                      ->whereIn('status', ['aktif', 'menunggu', 'lunas'])
                      ->get();

        $kas = \App\Models\KasBendahara::where('penghuni_id', $penghuni->id)
                      ->whereIn('status', ['menunggu_bayar', 'menunggu_konfirmasi', 'lunas'])
                      ->get();

        if ($penghuni && $penghuni->status_huni == 'Kontrak' && $penghuni->tanggal_keluar) {
            if (now()->gt($penghuni->tanggal_keluar)) {
                return redirect()->route('user.home')
                    ->with('error', 'Kontrak Anda telah berakhir!');
            }
        }

        return view('user.iuran.index', compact('iuran', 'kas'));
    }

        public function bayarQris($id)
    {
        $iuran = Iuran::findOrFail($id);

        $iuran->update([
            'status' => 'menunggu',
            'metode' => 'qris',
            'tanggal_bayar' => now()
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    // 🔥 HALAMAN UPLOAD
    public function upload($id)
    {
        $iuran = Iuran::findOrFail($id);
        return view('user.iuran.upload', compact('iuran'));
    }
    // 🔥 SIMPAN BUKTI
        public function storeUpload(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $iuran = Iuran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {

            $file = $request->file('bukti_pembayaran');
            $namaFile = time().'.'.$file->getClientOriginalExtension();

            $file->move(public_path('bukti'), $namaFile);

            $iuran->update([
                'bukti_pembayaran' => $namaFile,
                'status' => 'menunggu' // fix: dulu salah jadi 'belum'
            ]);
        }

        return redirect()->route('user.iuran.index')
            ->with('success', 'Bukti berhasil diupload, menunggu konfirmasi bendahara & RT');
    }

   public function status()
    {
        $penghuni = \App\Models\Penghuni::where('email', Auth::user()->email)->first();

        $iuran = Iuran::where('penghuni_id', $penghuni->id)->get();

        return view('user.iuran.status', compact('iuran'));
    }

    public function delete($id)
    {
        // ambil data dari session
        $hidden = session()->get('hidden_iuran', []);

        // tambahkan id ke list hidden
        $hidden[] = $id;

        // simpan kembali ke session
        session()->put('hidden_iuran', $hidden);

        return back()->with('success', 'Data disembunyikan dari halaman ini');
    }
}

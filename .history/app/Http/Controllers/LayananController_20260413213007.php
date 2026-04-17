<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifPengaduan;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::with('penghuni')->latest()->get();
        $penghuni = Penghuni::all();

        return view('admin.layanan.index', compact('layanan', 'penghuni'));
    }

    public function store(Request $request)
    {
        Layanan::create([
            'penghuni_id'       => $request->penghuni_id,
            'tanggal_pengaduan' => now(),
            'kategori_masalah'  => $request->kategori_masalah,
            'deskripsi'         => $request->deskripsi,
            'status'            => 'diajukan'
        ]);

        return back()->with('success', 'Pengaduan berhasil ditambahkan');
    }

   public function tanggapi(Request $request, $id)
    {
        // VALIDASI
        $request->validate([
            'tanggapan_admin' => 'required|string',
            'status' => 'required|in:diproses,selesai'
        ]);

        // AMBIL DATA
        $layanan = Layanan::with('penghuni')->find($id);

        if (!$layanan) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // UPDATE DATA
        $layanan->tanggapan_admin = $request->tanggapan_admin;
        $layanan->status = $request->status;
        $layanan->save();

        // 🔥 =========================
        // 🔥 KIRIM EMAIL KE USER
        // 🔥 =========================
        if ($layanan->penghuni && $layanan->penghuni->email) {
            Mail::to($layanan->penghuni->email)
                ->send(new NotifPengaduan($layanan));
        }

        // 🔥 =========================
        // 🔥 WHATSAPP OTOMATIS
        // 🔥 =========================
        if ($layanan->penghuni && $layanan->penghuni->telepon) {

            $pesan = "Halo {$layanan->penghuni->nama},
    Pengaduan Anda telah ditanggapi.

    Status: {$layanan->status}
    Tanggapan: {$layanan->tanggapan_admin}";

            $wa = "https://wa.me/62" . ltrim($layanan->penghuni->telepon, '0') . "?text=" . urlencode($pesan);

            return redirect($wa);
        }

        return back()->with('success', 'Tanggapan berhasil diberikan & notifikasi dikirim');
    }

    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }


}

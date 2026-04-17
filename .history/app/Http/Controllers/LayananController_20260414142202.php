<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifPengaduan;
use Illuminate\Support\Facades\Http;

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
    $request->validate([
        'tanggapan_admin' => 'required|string',
        'status' => 'required|in:diproses,selesai'
    ]);

    $layanan = Layanan::with('penghuni')->find($id);

    if (!$layanan) {
        return back()->with('error', 'Data tidak ditemukan');
    }

    // UPDATE
    $layanan->tanggapan_admin = $request->tanggapan_admin;
    $layanan->status = $request->status;
    $layanan->save();

    // =========================
    // 🔥 WHATSAPP AUTO (FONNTE)
    // =========================
    if ($layanan->penghuni && $layanan->penghuni->telepon) {

    $no = preg_replace('/^0/', '62', $layanan->penghuni->telepon);

    $status = $layanan->status == 'selesai'
        ? '✅ Selesai'
        : '⏳ Sedang Diproses';

    $pesan = "🏡 *GREEN VIEW RESIDENCE*\n";
    $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
    $pesan .= "📢 *NOTIFIKASI PENGADUAN*\n";
    $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";

    $pesan .= "Halo *{$layanan->penghuni->nama}* 👋\n\n";

    $pesan .= "Terima kasih telah menggunakan layanan pengaduan kami 🙏\n";
    $pesan .= "Kami ingin menginformasikan bahwa laporan Anda telah ditindaklanjuti oleh admin.\n\n";

    $pesan .= "📌 *DETAIL PENGADUAN ANDA*\n";
    $pesan .= "──────────────────────\n";
    $pesan .= "🗂️ Status Saat Ini : *$status*\n";
    $pesan .= "📅 Tanggal Tanggapan : " . now()->format('d-m-Y H:i') . "\n\n";

    $pesan .= "💬 *TANGGAPAN ADMIN*\n";
    $pesan .= "──────────────────────\n";
    $pesan .= "{$layanan->tanggapan_admin}\n\n";

    $pesan .= "📢 *INFORMASI TAMBAHAN*\n";
    $pesan .= "──────────────────────\n";
    $pesan .= "• Tim kami sedang berupaya memberikan pelayanan terbaik\n";
    $pesan .= "• Jika status *selesai*, maka pengaduan Anda telah ditangani\n";
    $pesan .= "• Jika masih diproses, mohon menunggu sebentar ya 🙏\n\n";

    $pesan .= "📲 *CEK STATUS SECARA LANGSUNG*\n";
    $pesan .= "Klik link berikut untuk melihat detail lengkap:\n";
    $pesan .= url('/') . "\n\n";

    $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
    $pesan .= "🙏 Terima kasih atas kepercayaan Anda\n";
    $pesan .= "🏡 *Green View Residence*\n";
    $pesan .= "✨ Sistem Informasi Perumahan Modern\n";
    $pesan .= "━━━━━━━━━━━━━━━━━━━━━━";

    Http::withHeaders([
        'Authorization' => env('FONNTE_TOKEN')
    ])->post('https://api.fonnte.com/send', [
        'target' => $no,
        'message' => $pesan,
    ]);
}

    // =========================
    // 🔥 EMAIL
    // =========================
    if ($layanan->penghuni && $layanan->penghuni->email) {
        Mail::to($layanan->penghuni->email)
            ->send(new NotifPengaduan($layanan));
    }

    // 🔥 RETURN NORMAL (TIDAK REDIRECT WA)
    return redirect()->route('layanan.index')
        ->with('success', 'Tanggapan berhasil dikirim + WA otomatis terkirim');
}
    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }


}

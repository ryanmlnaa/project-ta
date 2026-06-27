<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifPengaduan;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService; // ✅ Gunakan service yang sudah fix
use Illuminate\Support\Facades\Log;

class LayananController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $layanan = Layanan::with('penghuni')
                ->whereIn('status', ['menunggu', 'selesai'])
                ->latest()
                ->get();
        } else {
            $rtId = $user->id;
            $layanan = Layanan::with('penghuni')
                ->whereHas('penghuni', function ($q) use ($rtId) {
                    $q->where('rt_id', $rtId);
                })
                ->latest()
                ->get();
        }

        return view('admin.layanan.index', compact('layanan'));
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

    public function tanggapiRT(Request $request, $id)
{
    $request->validate([
        'tanggapan_admin' => 'required'
    ]);

    $layanan = Layanan::with('penghuni')->findOrFail($id);
    $layanan->tanggapan_admin = $request->tanggapan_admin;
    $layanan->status          = 'diproses'; // RT yang menangani langsung, tanpa admin
    $layanan->save();

    $this->kirimNotif($layanan);

    return back()->with('success', 'Berhasil ditanggapi RT & notifikasi terkirim.');
}

// =========================================================
// ✅ RT KONFIRMASI SELESAI (gantikan approve admin)
// Manual: catatan penyelesaian + foto bukti
// Tidak perlu kolom/migration baru:
// - tanggapan_admin dipakai utk gabungkan catatan RT awal + catatan selesai
// - foto digabung koma (foto pengaduan awal tetap ada, foto bukti selesai ditambahkan)
// =========================================================
public function konfirmasiRT(Request $request, $id)
{
    $request->validate([
        'catatan_selesai' => 'required|string',
        'foto_bukti'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $layanan = Layanan::with('penghuni')->findOrFail($id);

    $catatanLama = $layanan->tanggapan_admin ? $layanan->tanggapan_admin . "\n\n" : '';
    $layanan->tanggapan_admin = $catatanLama . '✅ Konfirmasi Selesai (RT): ' . $request->catatan_selesai;

    if ($request->hasFile('foto_bukti')) {
        $path = $request->file('foto_bukti')->store('pengaduan', 'public');
        $layanan->foto = $layanan->foto ? $layanan->foto . ',' . $path : $path;
    }

    $layanan->status = 'selesai';
    $layanan->save();

    $this->kirimNotif($layanan);

    return back()->with('success', 'Pengaduan dikonfirmasi selesai oleh RT & notifikasi terkirim.');
}
    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function tanggapiRT(Request $request, $id)
    {
        $request->validate([
            'tanggapan_admin' => 'required'
        ]);

        $layanan = Layanan::with('penghuni')->findOrFail($id);
        $layanan->tanggapan_admin = $request->tanggapan_admin;
        $layanan->status          = 'menunggu'; // diteruskan ke admin
        $layanan->save();

        $this->kirimNotif($layanan);

        return back()->with('success', 'Berhasil ditanggapi RT & notifikasi terkirim.');
    }

    public function approveAdmin($id)
    {
        $layanan = Layanan::with('penghuni')->findOrFail($id);
        $layanan->status = 'selesai';
        $layanan->save();

        $this->kirimNotif($layanan);

        return back()->with('success', 'Disetujui Admin & notifikasi terkirim.');
    }

    public function indexAdmin()
    {
        $layanan = Layanan::with('penghuni')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        return view('admin.layanan.index', compact('layanan'));
    }

    // =========================================================
    // ✅ PRIVATE: Kirim Notifikasi WA + Email sekaligus
    // =========================================================
    private function kirimNotif($layanan)
    {
        if (!$layanan->penghuni) return;

        $nama       = $layanan->penghuni->nama;
        $statusText = $layanan->status === 'selesai' ? '✅ SELESAI' : '⏳ SEDANG DIPROSES';
        $tanggapan  = $layanan->tanggapan_admin ?? '-';
        $tanggal    = now()->format('d-m-Y H:i');

        // =====================
        // 📱 WHATSAPP via WhatsappService (Fix Fonnte)
        // =====================
        if (!empty($layanan->penghuni->telepon)) {

            $pesan  = "🏡 *GREEN VIEW RESIDENCE*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "📢 *NOTIFIKASI PENGADUAN*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $pesan .= "Halo *{$nama}* 👋\n\n";
            $pesan .= "Pengaduan Anda telah mendapatkan update terbaru.\n\n";
            $pesan .= "📌 *DETAIL PENGADUAN*\n";
            $pesan .= "──────────────────────\n";
            $pesan .= "🗂️ Status       : *{$statusText}*\n";
            $pesan .= "📅 Tanggal      : {$tanggal}\n\n";
            $pesan .= "💬 *TANGGAPAN*\n";
            $pesan .= "──────────────────────\n";
            $pesan .= "{$tanggapan}\n\n";
            $pesan .= "📲 Cek detail: " . url('/') . "\n\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "🙏 Terima kasih atas kepercayaan Anda\n";
            $pesan .= "🏡 *Green View Residence*";

            // ✅ Pakai WhatsappService (sudah ada normalizePhone & config token)
            $terkirim = WhatsappService::send($layanan->penghuni->telepon, $pesan);

            if (!$terkirim) {
                Log::warning('[Layanan] WA gagal ke: ' . $layanan->penghuni->telepon);
            }
        }

        // =====================
        // 📧 EMAIL
        // =====================
        if (!empty($layanan->penghuni->email)) {
            try {
                Mail::to($layanan->penghuni->email)
                    ->send(new NotifPengaduan($layanan));
            } catch (\Exception $e) {
                Log::error('[Layanan] Email gagal: ' . $e->getMessage());
            }
        }
    }
}

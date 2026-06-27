<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifPengaduan;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LayananController extends Controller
{
    // ============================================================
    // AUTO-ALTER: Tambah kolom baru tanpa migration file
    // Dipanggil sekali di constructor, aman dijalankan berkali-kali
    // ============================================================
    public function __construct()
    {
        try {
            if (!Schema::hasColumn('layanan', 'foto_bukti_rt')) {
                DB::statement('ALTER TABLE layanan ADD COLUMN foto_bukti_rt VARCHAR(255) NULL AFTER foto');
            }
            if (!Schema::hasColumn('layanan', 'catatan_selesai')) {
                DB::statement('ALTER TABLE layanan ADD COLUMN catatan_selesai TEXT NULL AFTER foto_bukti_rt');
            }
        } catch (\Exception $e) {
            Log::error('[LayananController] ALTER TABLE gagal: ' . $e->getMessage());
        }
    }

    // ============================================================
    // INDEX — RT & Admin
    // ============================================================
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Admin hanya lihat (tidak ada approve lagi, hanya view)
            $layanan = Layanan::with('penghuni')
                ->latest()
                ->get();
        } else {
            // RT lihat pengaduan penghuni di RT-nya
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

    // ============================================================
    // STORE — dari admin panel (jika ada)
    // ============================================================
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

    // ============================================================
    // TANGGAPI RT — RT memberi tanggapan awal (status: diproses)
    // ============================================================
    public function tanggapiRT(Request $request, $id)
    {
        $request->validate([
            'tanggapan_admin' => 'required|string',
        ]);

        $layanan = Layanan::with('penghuni')->findOrFail($id);
        $layanan->tanggapan_admin = $request->tanggapan_admin;
        $layanan->status          = 'diproses';
        $layanan->save();

        $this->kirimNotif($layanan);

        return back()->with('success', 'Tanggapan berhasil dikirim ke penghuni.');
    }

    // ============================================================
    // KONFIRMASI SELESAI — RT konfirmasi selesai + foto bukti
    // ============================================================
    public function konfirmasiSelesai(Request $request, $id)
    {
        $request->validate([
            'catatan_selesai' => 'required|string',
            'foto_bukti_rt'   => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $layanan = Layanan::with('penghuni')->findOrFail($id);

        // Simpan catatan selesai
        $layanan->catatan_selesai = $request->catatan_selesai;
        $layanan->status          = 'selesai';

        // Upload foto bukti RT jika ada
        if ($request->hasFile('foto_bukti_rt')) {
            $path = $request->file('foto_bukti_rt')->store('bukti_rt', 'public');
            $layanan->foto_bukti_rt = $path;
        }

        $layanan->save();

        // Kirim notifikasi selesai
        $this->kirimNotifSelesai($layanan);

        return back()->with('success', 'Pengaduan dikonfirmasi selesai & notifikasi terkirim.');
    }

    // ============================================================
    // DESTROY
    // ============================================================
    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // ============================================================
    // INDEX ADMIN (view only)
    // ============================================================
    public function indexAdmin()
    {
        $layanan = Layanan::with('penghuni')->latest()->get();
        return view('admin.layanan.index', compact('layanan'));
    }

    // ============================================================
    // PRIVATE: Notif tanggapan awal (diproses)
    // ============================================================
    private function kirimNotif($layanan)
    {
        if (!$layanan->penghuni) return;

        $nama      = $layanan->penghuni->nama;
        $tanggapan = $layanan->tanggapan_admin ?? '-';
        $tanggal   = now()->format('d-m-Y H:i');

        // WhatsApp
        if (!empty($layanan->penghuni->telepon)) {
            $pesan  = "🏡 *GREEN VIEW RESIDENCE*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "📢 *NOTIFIKASI PENGADUAN*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $pesan .= "Halo *{$nama}* 👋\n\n";
            $pesan .= "Pengaduan Anda sedang *DIPROSES* oleh RT.\n\n";
            $pesan .= "📌 *TANGGAPAN RT*\n";
            $pesan .= "──────────────────────\n";
            $pesan .= "{$tanggapan}\n\n";
            $pesan .= "📅 Tanggal: {$tanggal}\n";
            $pesan .= "📲 Cek detail: " . url('/') . "\n\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "🙏 Terima kasih atas kepercayaan Anda\n";
            $pesan .= "🏡 *Green View Residence*";

            $terkirim = WhatsappService::send($layanan->penghuni->telepon, $pesan);
            if (!$terkirim) {
                Log::warning('[Layanan] WA gagal ke: ' . $layanan->penghuni->telepon);
            }
        }

        // Email
        if (!empty($layanan->penghuni->email)) {
            try {
                Mail::to($layanan->penghuni->email)->send(new NotifPengaduan($layanan));
            } catch (\Exception $e) {
                Log::error('[Layanan] Email gagal: ' . $e->getMessage());
            }
        }
    }

    // ============================================================
    // PRIVATE: Notif selesai (RT konfirmasi selesai)
    // ============================================================
    private function kirimNotifSelesai($layanan)
    {
        if (!$layanan->penghuni) return;

        $nama    = $layanan->penghuni->nama;
        $catatan = $layanan->catatan_selesai ?? '-';
        $tanggal = now()->format('d-m-Y H:i');

        // WhatsApp
        if (!empty($layanan->penghuni->telepon)) {
            $pesan  = "🏡 *GREEN VIEW RESIDENCE*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "✅ *PENGADUAN SELESAI*\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
            $pesan .= "Halo *{$nama}* 👋\n\n";
            $pesan .= "Pengaduan Anda telah *SELESAI* ditangani oleh RT.\n\n";
            $pesan .= "📋 *KETERANGAN PENYELESAIAN*\n";
            $pesan .= "──────────────────────\n";
            $pesan .= "{$catatan}\n\n";
            $pesan .= "📅 Tanggal Selesai: {$tanggal}\n";
            $pesan .= "📲 Lihat bukti: " . url('/') . "\n\n";
            $pesan .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $pesan .= "🙏 Terima kasih telah menggunakan layanan kami\n";
            $pesan .= "🏡 *Green View Residence*";

            $terkirim = WhatsappService::send($layanan->penghuni->telepon, $pesan);
            if (!$terkirim) {
                Log::warning('[Layanan] WA selesai gagal ke: ' . $layanan->penghuni->telepon);
            }
        }

        // Email
        if (!empty($layanan->penghuni->email)) {
            try {
                Mail::to($layanan->penghuni->email)->send(new \App\Mail\NotifPengaduanSelesai($layanan));
            } catch (\Exception $e) {
                Log::error('[Layanan] Email selesai gagal: ' . $e->getMessage());
            }
        }
    }
}

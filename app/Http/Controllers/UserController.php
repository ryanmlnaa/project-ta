<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Informasi;

class UserController extends Controller
{
    // =========================
    // BERANDA USER
    // =========================
    public function index()
{
    $user = Auth::user();

    // 🔥 Query by EMAIL (karena user_id masih null sebelum pilih rumah)
    $penghuni = Penghuni::with('rumah')
        ->where('email', $user->email)
        ->latest()
        ->first();

    $rumah = $penghuni ? $penghuni->rumah : null;

    // 🔥 WAJIB ADA - dipakai di hero stats view
    $rumahList = \App\Models\Rumah::all();

    $rtUser = null;
    if ($rumah && $rumah->rt_id) {
        $rtUser = \App\Models\User::where('id', $rumah->rt_id)->first();
    }

    $iuran = collect();
    $hidden = session()->get('hidden_iuran', []);
    $hiddenLayanan = session()->get('hidden_layanan', []);

    if ($penghuni) {
        $iuran = \App\Models\Iuran::where('penghuni_id', $penghuni->id)
                    ->whereNotIn('id', $hidden)
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'asc')
                    ->get();
    }

    $pengaduan = collect();
    $informasi = \App\Models\Informasi::orderBy('is_penting', 'desc')
                    ->orderBy('tanggal', 'desc')
                    ->get();

    if ($penghuni) {
        $pengaduan = \App\Models\Layanan::where('penghuni_id', $penghuni->id)
            ->whereNotIn('id', $hiddenLayanan)
            ->latest()
            ->get();
    }

    $isExpired = false;
    if ($penghuni && $penghuni->status == 'Tidak Aktif') {
        $isExpired = true;
    }

    return view('user.home', compact(
        'penghuni', 'rumah', 'rumahList', 'rtUser',
        'iuran', 'pengaduan', 'informasi', 'isExpired'
    ));
}
    // =========================
    // PROFIL
    // =========================
    public function profil()
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();
        return view('user.profile.edit', compact('penghuni'));
    }

    public function updateProfil(Request $request)
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        $penghuni->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diupdate');
    }

    // =========================
    // RUMAH
    // =========================
public function rumah()
{
    $user = Auth::user();

    $penghuni = \App\Models\Penghuni::with('rumah')
                ->where('email', $user->email)  // 🔥 BY EMAIL, BUKAN user_id
                ->latest()
                ->first();

    $rumah = $penghuni ? $penghuni->rumah : null;

    $rtUser = null;
    if ($rumah && $rumah->rt_id) {
        $rtUser = \App\Models\User::where('id', $rumah->rt_id)
                    ->where('role', 'rt')
                    ->first();
    }

    $rumahList = \App\Models\Rumah::all();

    return view('user.rumah', compact('penghuni', 'rumah', 'rtUser', 'rumahList'));
}
    // =========================
    // 🔥 TAMBAHAN: PILIH RUMAH
    // =========================
public function pilihRumah($id)
{
    $user = Auth::user();

    $rumah = \App\Models\Rumah::findOrFail($id);

    // ❌ kalau rumah sudah terisi
    if ($rumah->status == 'Terisi') {
        return back()->with('error', 'Rumah sudah diambil!');
    }

    // 🔥 cari penghuni berdasarkan EMAIL ATAU USER_ID
    $penghuni = \App\Models\Penghuni::where('user_id', $user->id)
        ->orWhere('email', $user->email)
        ->first();

    // 🔥 kalau belum ada sama sekali
    if (!$penghuni) {
        $penghuni = new \App\Models\Penghuni();
    }

    // 🔥 SET DATA WAJIB (update juga kalau sudah ada)
    $penghuni->user_id = $user->id;
    $penghuni->nama = $user->name;
    // $penghuni->no_ktp = $user->no_ktp ?? '-';
    $penghuni->email = $user->email;
    // $penghuni->telepon = $user->telepon ?? 'Belum diisi';
    // $penghuni->alamat = $user->alamat ?? 'Belum diisi';
    $penghuni->status = 'Aktif';
    $penghuni->status_huni = 'Tetap';

    // 🔥 kalau belum ada tanggal masuk
    if (!$penghuni->tanggal_masuk) {
        $penghuni->tanggal_masuk = now();
    }

    // 🔥 SET RUMAH
    $penghuni->rumah_id = $rumah->id;

    // ✅ TAMBAHKAN INI (PENTING BANGET)
    $penghuni->rt_id = $rumah->rt_id;

    $penghuni->save();

    // 🔥 UPDATE STATUS RUMAH
    $rumah->status = 'Terisi';
    $rumah->save();

    return redirect()->route('user.rumah')->with('success', 'Berhasil pilih rumah!');
}

    // // =========================
    // // IURAN
    // // =========================
    // public function iuran()
    // {
    //     return view('user.iuran');
    // }

    // // =========================
    // // PENGADUAN
    // // =========================
    // public function pengaduan()
    // {
    //     return view('user.pengaduan');
    // }

    // public function storePengaduan(Request $request)
    // {
    //     // sementara dummy dulu
    //     return back()->with('success', 'Pengaduan berhasil dikirim');
    // }

    // // =========================
    // // PENGUMUMAN
    // // =========================
    // public function pengumuman()
    // {
    //     return view('user.pengumuman');
    // }

public function ambilRumah(Request $request)
{
    $user = Auth::user();

    $rumah = \App\Models\Rumah::findOrFail($request->rumah_id);

    // 🔥 ambil penghuni yang SUDAH ADA
    $penghuni = \App\Models\Penghuni::where('email', $user->email)->first();

    if (!$penghuni) {
        return back()->with('error', 'Data penghuni belum ada!');
    }

    // 🔥 hanya update yang penting saja
    $penghuni->user_id = $user->id; // pastikan tidak null
    $penghuni->rumah_id = $rumah->id;
    $penghuni->rt_id = $rumah->rt_id;

    $penghuni->save();

    // 🔥 update status rumah
    $rumah->status = 'Terisi';
    $rumah->save();

    return redirect()->route('user.rumah')->with('success', 'Berhasil ambil rumah!');
}

 public function simpanPenghuni(Request $request)
{
    $request->validate([
        'nama'           => 'required',
        'no_ktp'         => 'required',
        'telepon'        => 'required',
        'alamat'         => 'required',
        'status_huni'    => 'required|in:Tetap,Kontrak',
        'tanggal_keluar' => 'nullable|date'
    ]);

    $user = Auth::user();

    // 🔥 Cek duplikat by EMAIL
    if (Penghuni::where('email', $user->email)->exists()) {
        return redirect()->route('user.rumah')
                         ->with('info', 'Data penghuni sudah ada!');
    }

    Penghuni::create([
        'nama'           => $request->nama,
        'email'          => $user->email,
        'no_ktp'         => $request->no_ktp,
        'telepon'        => $request->telepon,
        'alamat'         => $request->alamat,
        'status_huni'    => $request->status_huni,
        'tanggal_masuk'  => now(),
        'tanggal_keluar' => $request->status_huni == 'Kontrak'
                            ? $request->tanggal_keluar
                            : null,
        'status'         => 'Aktif',
    ]);

    // 🔥 REDIRECT KE user.rumah (bukan user.home)
    return redirect()->route('user.rumah')
                     ->with('success', 'Data penghuni berhasil disimpan!');
}

//   public function ambilRumah(Request $request)
// {
//     $request->validate([
//         'rumah_id' => 'required|exists:rumah,id'
//     ]);

//     $rumah = Rumah::findOrFail($request->rumah_id);

//     if ($rumah->status == 'Terisi') {
//         return back()->with('error', 'Rumah sudah diambil!');
//     }

//     $penghuni = Penghuni::where('email', Auth::user()->email)->first();

//     if (!$penghuni) {
//         return back()->with('error', 'Isi data penghuni dulu!');
//     }

//     if ($penghuni->rumah_id) {
//         return back()->with('error', 'Anda sudah memiliki rumah!');
//     }

//     DB::transaction(function () use ($rumah, $penghuni) {
//         $rumah->update(['status' => 'Terisi']);
//         $penghuni->update(['rumah_id' => $rumah->id]);
//     });

//     return redirect()->route('user.rumah')
//         ->with('success', 'Berhasil mengambil rumah!');
// }
    public function storeRumah(Request $request)
    {
        $request->validate([
            'blok' => 'required',
            'no_rumah' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // 🔥 HANDLE FOTO
        $namaFile = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('foto_rumah'), $namaFile);
        }

        Rumah::create([
            'blok' => $request->blok,
            'no_rumah' => $request->no_rumah,
            'status' => $request->status,
            'luas_tanah' => $request->luas_tanah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'foto' => $namaFile // 🔥 INI WAJIB ADA
        ]);

        return back()->with('success', 'Rumah berhasil ditambahkan');
    }

    public function updateRumah(Request $request, $id)
    {
        $rumah = \App\Models\Rumah::findOrFail($id);

        $rumah->update([
            'blok' => $request->blok,
            'no_rumah' => $request->no_rumah,
            'status' => $request->status,
            'luas_tanah' => $request->luas_tanah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Berhasil update rumah');
    }

    public function detailInformasi($id)
    {
        $info = Informasi::findOrFail($id);
        $info->increment('views');

        return view('user.informasi.detail', compact('info'));
    }

    // =========================
    // UPLOAD PEMBAYARAN
    // =========================
    // public function uploadPembayaran()
    // {
    //     return view('user.upload_pembayaran');
    // }

    // // =========================
    // // STATUS PEMBAYARAN
    // // =========================
    // public function statusPembayaran()
    // {
    //     return view('user.status_pembayaran');
    // }

    // // =========================
    // // STATUS PENGADUAN
    // // =========================
    // public function statusPengaduan()
    // {
    //     return view('user.status_pengaduan');
    // }
}

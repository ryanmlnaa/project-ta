<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // =========================
    // BERANDA USER
    // =========================
    public function index()
    {
        $penghuni = Penghuni::with('rumah')
            ->where('email', Auth::user()->email)
            ->first();

            // 🔥 PASTIKAN NULL JIKA TIDAK ADA
    if (!$penghuni) {
        $penghuni = null;
    }

            // 🔥 TAMBAHAN INI
    // if (!$penghuni) {
    //     $penghuni = \App\Models\Penghuni::create([
    //         'nama' => Auth::user()->name,
    //         'no_ktp' => rand(1000000000000000, 9999999999999999),
    //         'email' => Auth::user()->email,
    //         'telepon' => '-',
    //         'alamat' => '-',
    //         'status_huni' => 'Kontrak',
    //     ]);
    // }

        // 🔥 AMBIL IURAN BERDASARKAN PENGHUNI
        $iuran = null;

        $iuran = collect();

        // 🔥 TAMBAHAN (JANGAN DIHAPUS)
        $hidden = session()->get('hidden_iuran', []);

        $hiddenLayanan = session()->get('hidden_layanan', []);

        if ($penghuni) {
            $iuran = \App\Models\Iuran::where('penghuni_id', $penghuni->id)
                        ->whereNotIn('id', $hidden) // 🔥 TAMBAHAN FILTER
                        ->orderBy('tahun', 'desc') // 🔥 tahun terbaru dulu
                        ->orderBy('bulan', 'asc')  // 🔥 bulan urut
                        ->get();
        }

        $pengaduan = collect();

        if ($penghuni) {
            $pengaduan = \App\Models\Layanan::where('penghuni_id', $penghuni->id)
                ->whereNotIn('id', $hiddenLayanan) // 🔥 INI PENTING
                ->latest()
                ->get();
        }

       return view('user.home', compact('penghuni', 'iuran', 'pengaduan'));
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

    if (!$user) {
        return redirect('/login');
    }

    $penghuni = Penghuni::with('rumah')
        ->where('email', $user->email)
        ->first();

    // 🔥 TAMBAHAN INI (WAJIB)
    $rumahList = Rumah::all();

    return view('user.rumah', compact('penghuni', 'rumahList'));
    }
    // =========================
    // 🔥 TAMBAHAN: PILIH RUMAH
    // =========================
    public function pilihRumah($id)
    {
        $rumah = Rumah::findOrFail($id);

        // kalau sudah terisi
        if ($rumah->status == 'Terisi') {
            return back()->with('error', 'Rumah sudah terisi');
        }

        // cari penghuni berdasarkan email user login
       $penghuni = Penghuni::where('email', Auth::user()->email)->first();

if (!$penghuni) {
    return back()->with('error', 'Isi data penghuni dulu!');
}

        // kalau belum ada, buat otomatis
        // if (!$penghuni) {
        //     $penghuni = Penghuni::create([
        //         'nama' => Auth::user()->name,
        //         'email' => Auth::user()->email,
        //         'status' => 'Aktif'
        //     ]);
        // }

        // update rumah ke penghuni
        $penghuni->update([
            'rumah_id' => $rumah->id
        ]);

        // update status rumah
        $rumah->update([
            'status' => 'Terisi'
        ]);

        return back()->with('success', 'Berhasil memilih rumah');
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
    $request->validate([
        'rumah_id' => 'required|exists:rumah,id'
    ]);

    $rumah = Rumah::findOrFail($request->rumah_id);

    if ($rumah->status == 'Terisi') {
        return back()->with('error', 'Rumah sudah diambil!');
    }

   $penghuni = Penghuni::where('email', Auth::user()->email)->firstOrFail();

    if (!$penghuni) {
        return back()->with('error', 'Isi data penghuni dulu!');
    }

    if ($penghuni->rumah_id) {
        return back()->with('error', 'Anda sudah memiliki rumah!');
    }

   $rumah->status = 'Terisi';
$rumah->save();

$penghuni->rumah_id = $rumah->id;
$penghuni->save();

    return redirect()->route('user.rumah')
        ->with('success', 'Berhasil mengambil rumah!');
}

  public function simpanPenghuni(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'no_ktp' => 'required|unique:penghuni,no_ktp',
        'telepon' => 'required',
        'alamat' => 'required',
        'status_huni' => 'required|in:Tetap,Kontrak',
        'tanggal_masuk' => 'nullable|date',
        'tanggal_keluar' => 'nullable|date'
    ]);

    if (Penghuni::where('email', Auth::user()->email)->exists()) {
    return back()->with('error', 'Data sudah pernah diisi');
}

    \App\Models\Penghuni::create([
        // 🔥 TAMBAHAN WAJIB
        'user_id' => \Illuminate\Support\Facades\Auth::id(),

        'nama' => $request->nama,
        'email' => \Illuminate\Support\Facades\Auth::user()->email,
        'no_ktp' => $request->no_ktp,
        'telepon' => $request->telepon,
        'alamat' => $request->alamat,
        'status_huni' => $request->status_huni,
        'tanggal_masuk' => $request->tanggal_masuk,
        'tanggal_keluar' => $request->status_huni == 'Kontrak' ? $request->tanggal_keluar : null,
    ]);

    return redirect()->route('user.home')->with('success', 'Data penghuni berhasil disimpan');
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

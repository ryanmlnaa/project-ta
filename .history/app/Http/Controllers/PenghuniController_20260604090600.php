<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;

class PenghuniController extends Controller
{
    // =========================
    // TAMPILKAN DATA
    // =========================
    public function index(Request $request)
    {
        // tambah rumah dari modal
        if ($request->has('blok')) {

            $namaFile = null;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $namaFile = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto_rumah'), $namaFile);
            }

            $rtId = $this->getRtOtomatis($request->blok);

            if (!$rtId) {
                return back()->with('error', 'Blok tidak dikenali!');
            }

            Rumah::create([
                'blok' => $request->blok,
                'no_rumah' => $request->no_rumah,
                'status' => $request->status,
                'luas_tanah' => $request->luas_tanah,
                'harga' => $request->harga,
                'keterangan' => $request->keterangan,
                'foto' => $namaFile,
                'rt_id' => $rtId
            ]);

            return redirect()->back()->with('success', 'Rumah berhasil ditambahkan');
        }

        $penghuni = Penghuni::with('rumah')->get();
        $rumahList = Rumah::with('penghuni')->get();

        return view('admin.penghuni.index', compact('penghuni', 'rumahList'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        $rumah = Rumah::where('status', 'Kosong')->get();
        return view('admin.penghuni.create', compact('rumah'));
    }

    // =========================
    // SIMPAN DATA
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama' => 'required|string|max:100',
            'no_ktp' => 'required|string|max:20|unique:penghuni,no_ktp',
            'email' => 'required|email|max:100|unique:penghuni,email',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',
            'rumah_id' => 'nullable|exists:rumah,id',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
        ]);

                    if ($request->rumah_id) {

                $rumah = \App\Models\Rumah::find($request->rumah_id);

                if ($rumah && $rumah->rt_id) {

                   $jumlah = \App\Models\Penghuni::whereHas('rumah', function ($q) use ($rumah) {
                        $q->where('rt_id', $rumah->rt_id);
                    })->count();

                    if ($jumlah >= 20) {
                        return back()->with('error', 'RT sudah penuh (max 20 penghuni)');
                    }
                }
            }

     // 🔥 AUTO ISI TANGGAL MASUK
   $validated['tanggal_masuk'] = $request->input('tanggal_masuk') ?: now();

   $validated['user_id'] = Auth::id();

    $penghuni = Penghuni::create($validated);

        // set rumah jadi terisi
        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)
                ->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil disimpan.');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $rumahList = Rumah::where('status', 'Kosong')
            ->orWhere('id', $penghuni->rumah_id)
            ->get();

        return view('admin.penghuni.edit', compact('penghuni', 'rumahList'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_ktp' => ['required', Rule::unique('penghuni')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('penghuni')->ignore($id)],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',
            'rumah_id' => 'nullable|exists:rumah,id',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
        ]);

        $oldRumahId = $penghuni->rumah_id;

        $penghuni->update($validated);

        // kosongkan rumah lama
        if ($oldRumahId && $oldRumahId != $request->rumah_id) {
            Rumah::where('id', $oldRumahId)
                ->update(['status' => 'Kosong']);
        }

        // set rumah baru jadi terisi
        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)
                ->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        // kosongkan rumah
        if ($penghuni->rumah_id) {
            Rumah::where('id', $penghuni->rumah_id)
                ->update(['status' => 'Kosong']);
        }

        $penghuni->delete();

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil dihapus!');
    }

    // =========================
    // SIMPAN RUMAH (MODAL)
    // =========================
    public function storeRumah(Request $request)
    {
        $request->validate([
            'blok' => 'required',
            'no_rumah' => 'required',
            'status' => 'required',
        ]);

        $namaFile = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_rumah'), $namaFile);
        }

        // 🔥 INI YANG DIPAKAI
       $rtId = $this->getRtOtomatis($request->blok);

        if (!$rtId) {
            return back()->with('error', 'Blok tidak dikenali!');
        }

        \App\Models\Rumah::create([
            'blok' => $request->blok,
            'no_rumah' => $request->no_rumah,
            'status' => $request->status,
            'luas_tanah' => $request->luas_tanah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'foto' => $namaFile,
            'rt_id' => $rtId
        ]);

            return redirect()->back()->with('success', 'Rumah berhasil ditambahkan');
        }

    // =========================
    // EDIT RUMAH
    // =========================
    public function editRumah($id)
    {
        $rumah = Rumah::findOrFail($id);

        return view('admin.penghuni.edit', [
            'penghuni' => null,
            'rumah' => $rumah,
            'rumahList' => Rumah::with('penghuni')->get()
        ]);
    }

    // =========================
    // UPDATE RUMAH
    // =========================
  public function updateRumah(Request $request, $id)
{
    $rumah = Rumah::findOrFail($id);

    $request->validate([
        'blok' => 'required',
        'no_rumah' => 'required',
        'status' => 'required',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $rtId = $this->getRtOtomatis($request->blok);

    if (!$rtId) {
        return back()->with('error', 'Blok tidak dikenali!');
    }

    $data = [
        'blok' => $request->blok,
        'no_rumah' => $request->no_rumah,
        'status' => $request->status,
        'luas_tanah' => $request->luas_tanah,
        'harga' => $request->harga,
        'keterangan' => $request->keterangan,
        'rt_id' => $rtId
    ];

    // ===============================
    // 🔥 TAMBAHAN LOGIC (PENTING)
    // ===============================
    $penghuni = \App\Models\Penghuni::where('rumah_id', $rumah->id)->first();

    if ($penghuni) {
        // kalau ada penghuni → paksa jadi terisi
        $data['status'] = 'Terisi';
    } else {
        // kalau tidak ada penghuni → kosong
        $data['status'] = 'Kosong';
    }
    // ===============================

    if ($request->hasFile('foto')) {

        // hapus lama
        if ($rumah->foto && file_exists(public_path('foto_rumah/'.$rumah->foto))) {
            unlink(public_path('foto_rumah/'.$rumah->foto));
        }

        $file = $request->file('foto');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('foto_rumah'), $namaFile);

        $data['foto'] = $namaFile;
    }

    $rumah->update($data);

    return redirect()->route('penghuni.index')
        ->with('success', 'Data rumah berhasil diupdate');
}

    // =========================
    // HAPUS RUMAH
    // =========================
    public function destroyRumah($id)
    {
        $rumah = Rumah::findOrFail($id);
        $rumah->delete();

        return redirect()->back()
            ->with('success', 'Data rumah berhasil dihapus');
    }

        public function indexRT()
    {
        $rtId = Auth::id();

        $penghuni = \App\Models\Penghuni::whereHas('rumah', function ($q) use ($rtId) {
            $q->where('rt_id', $rtId);
        })->get();

        return view('rt.penghuni.index', compact('penghuni'));
    }

        public function bagiRT()
    {
        $rtList = User::where('role', 'rt')->get();
        $rumahs = Rumah::orderBy('id')->get();

        if ($rtList->count() == 0) {
            return back()->with('error', 'RT belum ada!');
        }

        $rtIndex = 0;
        $counter = 0;

        foreach ($rumahs as $rumah) {

            $rumah->rt_id = $rtList[$rtIndex]->id;
            $rumah->save();

            $counter++;

            if ($counter == 20) {
                $rtIndex++;
                $counter = 0;

                if ($rtIndex >= $rtList->count()) {
                    $rtIndex = 0;
                }
            }
        }

        return back()->with('success', 'Pembagian RT berhasil!');
    }

        public function rumahRT()
    {
        $rtId = Auth::id();

        $rumah = \App\Models\Rumah::where('rt_id', $rtId)->get();

        return view('rt.rumah.index', compact('rumah'));
    }

        public function iuranRT()
    {
        $rtId = Auth::id();

        $iuran = \App\Models\Iuran::whereHas('penghuni.rumah', function ($q) use ($rtId) {
            $q->where('rt_id', $rtId);
        })->get();

        return view('rt.iuran.index', compact('iuran'));
    }

        public function dashboardRT()
    {
        $rtId = Auth::id();

        $totalRumah = \App\Models\Rumah::where('rt_id', $rtId)->count();

        $totalPenghuni = \App\Models\Penghuni::whereHas('rumah', function ($q) use ($rtId) {
            $q->where('rt_id', $rtId);
        })->count();

        return view('rt.dashboard', compact('totalRumah', 'totalPenghuni'));
    }
    private function getRtOtomatis($blok)
    {
        if (!$blok) return null;

        // 🔥 bersihin input
        $blok = trim($blok);
        $blok = strtoupper($blok);

        $prefix = substr($blok, 0, 1);

        $mapping = [
            'A' => 13, // RT 1
            'B' => 13, // RT 1 (gabung A+B kalau 1 blok = 10 rumah)
            'C' => 13, // RT 2
            'D' => 13, // RT 2
            'E' => 13, // RT 3
            'F' => 13, // RT 3
            'G' => 13, // RT 4
            'H' => 13, // RT 4
            'I' => 13,
            
        ];

        return $mapping[$prefix] ?? null;
    }

    //     private function getRtOtomatis()
    // {
    //     $rtList = \App\Models\User::where('role', 'rt')->orderBy('id')->get();

    //     if ($rtList->count() == 0) {
    //         return null;
    //     }

    //     $jumlahRumah = \App\Models\Rumah::count();

    //     // tiap 10 rumah pindah RT
    //     $rtIndex = floor($jumlahRumah / 10);

    //     // reset kalau melebihi jumlah RT
    //     if ($rtIndex >= $rtList->count()) {
    //         $rtIndex = 0;
    //     }

    //     return $rtList[$rtIndex]->id;
    // }

        public function layananRT()
    {
       $rtId = Auth::user()->id;

        $data = Layanan::whereHas('penghuni', function ($q) use ($rtId) {
            $q->where('rt_id', $rtId);
        })->get();

       return view('rt.layanan.index', ['layanan' => $data]);
    }

    public function home()
    {
        $user = Auth::user();

        $penghuni = \App\Models\Penghuni::where('user_id', $user->id)->first();

        $rumah = null;
        $rtUser = null;

        if ($penghuni && $penghuni->rumah) {
            $rumah = $penghuni->rumah;

            // 🔥 ambil user RT dari rt_id
            $rtUser = \App\Models\User::where('id', $rumah->rt_id)
                        ->where('role', 'rt')
                        ->first();
        }

        return view('user.rumah', compact('penghuni', 'rumah', 'rtUser'));
    }

     public function editProfile()
    {
        $user = Auth::user();
        return view('rt.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());

        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('photo')) {

            if ($user->photo && file_exists(public_path('profile/'.$user->photo))) {
                unlink(public_path('profile/'.$user->photo));
            }

            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('profile'), $filename);

            $user->photo = $filename;
        }

        $user->save();

        Auth::login($user); // 🔥 penting

        return back()->with('success', 'Foto berhasil diupdate!');
    }

}


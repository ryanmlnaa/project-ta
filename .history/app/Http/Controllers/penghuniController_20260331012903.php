<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // =========================
    // TAMPILKAN DATA
    // =========================
    public function index(Request $request)
    {
        // tambah rumah dari modal
        if ($request->has('blok')) {
            Rumah::create([
                'blok' => $request->blok,
                'no_rumah' => $request->no_rumah,
                'status' => $request->status,
                'luas_tanah' => $request->luas_tanah,
                'harga' => $request->harga,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Rumah berhasil ditambahkan');
        }

        $penghuni = Penghuni::with('rumah')->get();
        $rumahList = Rumah::all();

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

        // 🔥 WAJIB (fix bug)
        $penghuni->delete();

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil dihapus!');
    }

    public function storeRumah(Request $request)
    {
        $request->validate([
            'blok' => 'required',
            'no_rumah' => 'required',
            'status' => 'required',
        ]);

        Rumah::create([
            'blok' => $request->blok,
            'no_rumah' => $request->no_rumah,
            'status' => $request->status,
            'luas_tanah' => $request->luas_tanah,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
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
            'rumahList' => Rumah::all()
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
        ]);

        $rumah->update($request->all());

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // =========================
    // TAMPIL DATA (2 TABEL)
    // =========================
    public function index()
    {
        $penghuni = Penghuni::all();
        $rumah = Rumah::all(); // <- tambahan penting

        return view('admin.penghuni.index', compact('penghuni', 'rumah'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        $rumah = Rumah::all(); // biar bisa pilih rumah

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
            'email' => 'required|string|email|max:100|unique:penghuni,email',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',

            // relasi rumah
            'blok_rumah' => 'required|string|max:10',
            'no_rumah' => 'required|string|max:10',

            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => $request->status_huni === 'Kontrak'
                ? 'required|date|after_or_equal:tanggal_masuk'
                : 'nullable',
        ]);

        Penghuni::create($validated);

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil disimpan.');
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $rumah = Rumah::all();

        return view('admin.penghuni.edit', compact('penghuni', 'rumah'));
    }

    // =========================
    // UPDATE DATA
    // =========================
    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',

            'no_ktp' => [
                'required',
                'string',
                'max:20',
                Rule::unique('penghuni', 'no_ktp')->ignore($id),
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('penghuni', 'email')->ignore($id),
            ],

            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',

            'blok_rumah' => 'required|string|max:10',
            'no_rumah' => 'required|string|max:10',

            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => $request->status_huni === 'Kontrak'
                ? 'required|date|after_or_equal:tanggal_masuk'
                : 'nullable',
        ]);

        // ✅ FIX: pakai validated, bukan request->all()
        $penghuni->update($validated);

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil diupdate.');
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil dihapus!');
    }
}

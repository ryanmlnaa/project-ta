<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah; // ✅ tambahkan ini
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // =========================
    // TAMPILKAN DATA
    // =========================
    public function index()
    {
        $penghuni = Penghuni::all();
        $rumah = Rumah::all(); // ✅ tambahan sesuai view

        return view('admin.penghuni.index', compact('penghuni', 'rumah'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        return view('admin.penghuni.create');
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
            'blok_rumah' => 'nullable|string|max:10',
            'no_rumah' => 'nullable|string|max:10',
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
        return view('admin.penghuni.edit', compact('penghuni'));
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
                Rule::unique('penghuni', 'no_ktp')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('penghuni', 'email')->ignore($id),
            ],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',
            'blok_rumah' => 'nullable|string|max:10',
            'no_rumah' => 'nullable|string|max:10',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => $request->status_huni === 'Kontrak'
                ? 'required|date|after_or_equal:tanggal_masuk'
                : 'nullable',
        ]);

        $penghuni->update($validated); // ✅ pakai validated

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
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

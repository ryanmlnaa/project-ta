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
    public function index()
    {
        $penghuni = Penghuni::with('rumah')->get(); // 🔥 relasi eager load
        $rumah = Rumah::all();

        return view('admin.penghuni.index', compact('penghuni', 'rumah'));
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        // hanya tampilkan rumah yang belum dipakai
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
            'email' => 'required|string|email|max:100|unique:penghuni,email',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',

            // 🔥 RELASI BARU
            'rumah_id' => [
                'nullable',
                'exists:rumah,id',
                Rule::unique('penghuni', 'rumah_id') // ❗ biar tidak double
            ],

            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => $request->status_huni === 'Kontrak'
                ? 'required|date|after_or_equal:tanggal_masuk'
                : 'nullable',
        ]);

        $penghuni = Penghuni::create($validated);

        // 🔥 UPDATE STATUS RUMAH JADI TERISI
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

        // tampilkan rumah kosong + rumah yang sedang dipakai penghuni ini
        $rumah = Rumah::where('status', 'Kosong')
            ->orWhere('id', $penghuni->rumah_id)
            ->get();

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
                Rule::unique('penghuni', 'no_ktp')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('penghuni', 'email')->ignore($id),
            ],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',

            // 🔥 RELASI
            'rumah_id' => [
                'nullable',
                'exists:rumah,id',
                Rule::unique('penghuni', 'rumah_id')->ignore($id),
            ],

            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => $request->status_huni === 'Kontrak'
                ? 'required|date|after_or_equal:tanggal_masuk'
                : 'nullable',
        ]);

        $oldRumahId = $penghuni->rumah_id;

        $penghuni->update($validated);

        // 🔥 KOSONGKAN RUMAH LAMA
        if ($oldRumahId && $oldRumahId != $request->rumah_id) {
            Rumah::where('id', $oldRumahId)
                ->update(['status' => 'Kosong']);
        }

        // 🔥 SET RUMAH BARU JADI TERISI
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

        // 🔥 KOSONGKAN RUMAH
        if ($penghuni->rumah_id) {
            Rumah::where('id', $penghuni->rumah_id)
                ->update(['status' => 'Kosong']);
        }

        $penghuni->delete();

        return redirect()->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil dihapus!');
    }
}

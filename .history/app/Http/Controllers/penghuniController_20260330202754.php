<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    // Daftar penghuni
    public function index()
    {
        $penghuni = Penghuni::all();
        return view('admin.penghuni.index', compact('penghuni'));
    }

    // Form tambah penghuni
    public function create()
    {
        return view('admin.penghuni.create');
    }

    // Simpan data baru
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

    // Form edit
    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        return view('admin.penghuni.edit', compact('penghuni'));
    }

    // Update data
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

    $penghuni = Penghuni::findOrFail($id);
    $penghuni->update($request->all());

    return redirect()->route('penghuni.index')
                     ->with('success', 'Data penghuni berhasil disimpan.');
    }

    // Hapus data
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);
        $penghuni->delete();

        return redirect()->route('penghuni.index')->with('success', 'Data penghuni berhasil dihapus!');
    }
}

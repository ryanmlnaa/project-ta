<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
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
        $rumah = Rumah::all();

        return view('admin.penghuni.index', compact('penghuni', 'rumah'));
    }

    public function create()
    {
        $rumah = Rumah::where('status', 'Kosong')->get();
        return view('admin.penghuni.create', compact('rumah'));
    }

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

        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $rumah = Rumah::where('status', 'Kosong')
            ->orWhere('id', $penghuni->rumah_id)
            ->get();

        return view('admin.penghuni.edit', compact('penghuni', 'rumah'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_ktp' => ['required', Rule::unique('penghuni')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('penghuni')->ignore($id)],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'required|string|max:150',
            'rumah_id' => ['nullable','exists:rumah,id'],
            'status' => 'required|in:Aktif,Tidak Aktif',
            'status_huni' => 'required|in:Tetap,Kontrak',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
        ]);

        $oldRumah = $penghuni->rumah_id;

        $penghuni->update($validated);

        if ($oldRumah && $oldRumah != $request->rumah_id) {
            Rumah::where('id', $oldRumah)->update(['status' => 'Kosong']);
        }

        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')->with('success', 'Berhasil update');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        if ($penghuni->rumah_id) {
            Rumah::where('id', $penghuni->rumah_id)->update(['status' => 'Kosong']);
        }

        $penghuni->delete(); // 🔥 FIX PENTING

        return redirect()->route('penghuni.index')->with('success', 'Berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Penghuni;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with('rumah')->get();
        $rumahList = Rumah::all();

        return view('admin.penghuni.index', compact('penghuni', 'rumahList'));
    }

    public function create()
    {
        $rumahList = Rumah::where('status', 'Kosong')->get();
        return view('admin.penghuni.create', compact('rumahList'));
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
        ]);

        $penghuni = Penghuni::create($validated);

        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)
                ->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')->with('success', 'Berhasil tambah');
    }

    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $rumahList = Rumah::where('status', 'Kosong')
            ->orWhere('id', $penghuni->rumah_id)
            ->get();

        return view('admin.penghuni.edit', compact('penghuni', 'rumahList'));
    }

    public function update(Request $request, $id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'no_ktp' => ['required', Rule::unique('penghuni')->ignore($id)],
            'email' => ['required', 'email', Rule::unique('penghuni')->ignore($id)],
            'alamat' => 'required',
            'rumah_id' => 'nullable|exists:rumah,id',
        ]);

        $oldRumah = $penghuni->rumah_id;

        $penghuni->update($validated);

        if ($oldRumah && $oldRumah != $request->rumah_id) {
            Rumah::where('id', $oldRumah)->update(['status' => 'Kosong']);
        }

        if ($request->rumah_id) {
            Rumah::where('id', $request->rumah_id)->update(['status' => 'Terisi']);
        }

        return redirect()->route('penghuni.index')->with('success', 'Update berhasil');
    }

    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        if ($penghuni->rumah_id) {
            Rumah::where('id', $penghuni->rumah_id)->update(['status' => 'Kosong']);
        }

        $penghuni->delete();

        return back()->with('success', 'Hapus berhasil');
    }

    // =========================
    // RUMAH
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

    public function updateRumah(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);

        $rumah->update($request->all());

        return redirect()->route('penghuni.index')->with('success', 'Rumah diupdate');
    }

    public function destroyRumah($id)
    {
        Rumah::findOrFail($id)->delete();
        return back()->with('success', 'Rumah dihapus');
    }
}

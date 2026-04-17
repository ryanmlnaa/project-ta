<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Informasi;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
        public function index()
    {
        // 🔥 TAMBAHAN INI
        $informasi = Informasi::orderBy('is_penting', 'desc')
                        ->orderBy('tanggal', 'desc')
                        ->get();
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambar = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('informasi'), $gambar);
        }

        Informasi::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'penulis' => Auth::user()->name,
            'gambar' => $gambar,
            'is_penting' => $request->is_penting ? 1 : 0,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Informasi::findOrFail($id);
        return view('admin.informasi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date',
        ]);

        $gambar = $data->gambar;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambar = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('informasi'), $gambar);
        }

        $data->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'gambar' => $gambar,
            'is_penting' => $request->is_penting ? 1 : 0,
        ]);

        return redirect()->route('informasi.index')->with('success', 'Berhasil diupdate');
    }

    public function destroy($id)
    {
        Informasi::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }

    public function detailInformasi($id)
    {
        $info = Informasi::findOrFail($id);

        // 🔥 TAMBAH VIEW DI SINI
        $info->increment('views');

        return view('user.informasi.detail', compact('info'));
    }
}

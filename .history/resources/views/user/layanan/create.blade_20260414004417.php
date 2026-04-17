@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card shadow">
            <div class="card-header text-white" style="background: linear-gradient(90deg,#4f46e5,#6366f1)">
                <h5>Formulir Pengaduan Online</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('user.layanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Kategori Pengaduan</label>
                        <select name="kategori_masalah" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kebersihan">Kebersihan</option>
                            <option value="keamanan">Keamanan</option>
                            <option value="fasilitas">Fasilitas</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Masalah</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan masalah..."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Gambar (Opsional)</label>
                        <input type="file" name="foto" class="form-control" onchange="previewImage(event)">
                        <img id="preview" width="100" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-secondary mr-2">Reset</button>
                       <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Auth;

class UserLayananController extends Controller
{
    public function create()
    {
        return view('user.layanan.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'kategori_masalah' => 'required',
        'deskripsi' => 'required|min:10',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $penghuni = \App\Models\Penghuni::where('email', Auth::user()->email)->first();

    if (!$penghuni) {
        return back()->with('error', 'Data penghuni tidak ditemukan!');
    }

    $fotoPath = null;

    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('pengaduan', 'public');
    }

    \App\Models\Layanan::create([
        'penghuni_id' => $penghuni->id,
        'tanggal_pengaduan' => now(),
        'kategori_masalah' => $request->kategori_masalah,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
        'status' => 'diajukan'
    ]);

    return redirect()->route('user.layanan.status')
        ->with('success', 'Pengaduan berhasil dikirim!');
}

    public function status()
    {
        $penghuni = Penghuni::where('email', Auth::user()->email)->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan!');
        }

        $layanan = Layanan::where('penghuni_id', $penghuni->id)
            ->latest()
            ->get();

        return view('user.layanan.status', compact('layanan'));
    }
}

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

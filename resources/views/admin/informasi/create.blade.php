@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Tambah Informasi</h3>

    <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="judul" class="form-control mb-2" placeholder="Judul" required>

        <textarea name="isi" class="form-control mb-2" placeholder="Isi Informasi"></textarea>

        <input type="date" name="tanggal" class="form-control mb-2">

        <select name="kategori" class="form-control mb-2">
            <option>Umum</option>
            <option>Iuran</option>
            <option>Keamanan</option>
            <option>Pengumuman</option>
        </select>

        <label>
            <input type="checkbox" name="is_penting"> Tandai penting
        </label>

        <input type="file" name="gambar" class="form-control mb-2">

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection

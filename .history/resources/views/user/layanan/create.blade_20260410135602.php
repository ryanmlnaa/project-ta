@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Buat Pengaduan</h4>

    <form action="{{ route('user.layanan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_masalah" class="form-control">
                <option value="kebersihan">Kebersihan</option>
                <option value="keamanan">Keamanan</option>
                <option value="fasilitas">Fasilitas</option>
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary mt-2">Kirim</button>
    </form>

</div>
@endsection

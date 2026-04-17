@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Edit Informasi</h3>

    <form action="{{ route('informasi.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="judul" value="{{ $data->judul }}" class="form-control mb-2">

        <textarea name="isi" class="form-control mb-2">{{ $data->isi }}</textarea>

        <input type="date" name="tanggal" value="{{ $data->tanggal }}" class="form-control mb-2">

        <select name="kategori" class="form-control mb-2">
            <option {{ $data->kategori == 'Umum' ? 'selected' : '' }}>Umum</option>
            <option {{ $data->kategori == 'Iuran' ? 'selected' : '' }}>Iuran</option>
            <option {{ $data->kategori == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
            <option {{ $data->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
        </select>

        <label>
            <input type="checkbox" name="is_penting" {{ $data->is_penting ? 'checked' : '' }}>
            Penting
        </label>

        <input type="file" name="gambar" class="form-control mb-2">

        <button class="btn btn-success">Update</button>
        <a href="{{ route('informasi.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection

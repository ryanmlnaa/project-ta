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
<textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan masalah..." required></textarea>
</div>

<div class="form-group">
<label>Upload Gambar (Opsional)</label>
<input type="file" name="foto" class="form-control" onchange="previewImage(event)">
<img id="preview" width="100" class="mt-2"/>
</div>

<div class="d-flex justify-content-end">
<button type="reset" class="btn btn-secondary mr-2">Reset</button>
<button class="btn btn-primary">Kirim Pengaduan</button>
</div>

</form>

</div>
</div>

</div>
@endsection

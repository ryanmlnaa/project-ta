@extends('layouts.app')

@section('content')
<div class="container">

@php
    $isEditPenghuni = isset($penghuni) && $penghuni && isset($penghuni->id);
    $isEditRumah = isset($rumah) && is_object($rumah);
@endphp

{{-- JUDUL --}}
@if($isEditPenghuni)
    <h3>Edit Data Penghuni</h3>
@elseif($isEditRumah)
    <h3>Edit Data Rumah</h3>
@endif

{{-- ERROR --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- FORM --}}
@if($isEditPenghuni)
    <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
@elseif($isEditRumah)
    <form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST">
@endif

@csrf
@method('PUT')

{{-- ========================= --}}
{{-- PENGHUNI --}}
{{-- ========================= --}}
@if($isEditPenghuni)

    <input type="text" name="nama" class="form-control mb-2"
        value="{{ old('nama', $penghuni->nama) }}" placeholder="Nama">

    <input type="text" name="no_ktp" class="form-control mb-2"
        value="{{ old('no_ktp', $penghuni->no_ktp) }}" placeholder="KTP">

    <input type="email" name="email" class="form-control mb-2"
        value="{{ old('email', $penghuni->email) }}" placeholder="Email">

    <input type="text" name="alamat" class="form-control mb-2"
        value="{{ old('alamat', $penghuni->alamat) }}" placeholder="Alamat">

    {{-- PILIH RUMAH --}}
    <select name="rumah_id" class="form-control mb-2">
        <option value="">-- Pilih Rumah --</option>
        @foreach($rumahList as $r)
            <option value="{{ $r->id }}"
                {{ $penghuni->rumah_id == $r->id ? 'selected' : '' }}>
                {{ $r->blok }} - {{ $r->no_rumah }}
            </option>
        @endforeach
    </select>

{{-- ========================= --}}
{{-- RUMAH --}}
{{-- ========================= --}}
@elseif($isEditRumah)

<form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- BLOK --}}
    <input type="text" name="blok" class="form-control mb-2"
        value="{{ old('blok', $rumah->blok) }}" required>

    {{-- NO RUMAH --}}
    <input type="text" name="no_rumah" class="form-control mb-2"
        value="{{ old('no_rumah', $rumah->no_rumah) }}" required>

    {{-- STATUS --}}
    <select name="status" class="form-control mb-2" required>
        <option value="Kosong" {{ $rumah->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
        <option value="Terisi" {{ $rumah->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
    </select>

    {{-- LUAS --}}
    <input type="number" name="luas_tanah" class="form-control mb-2"
        value="{{ old('luas_tanah', $rumah->luas_tanah) }}">

    {{-- HARGA --}}
    <input type="number" name="harga" class="form-control mb-2"
        value="{{ old('harga', $rumah->harga) }}">

    {{-- KETERANGAN --}}
    <textarea name="keterangan" class="form-control mb-2">{{ old('keterangan', $rumah->keterangan) }}</textarea>

    {{-- FOTO --}}
    <div class="mb-2">
        <b>Foto Saat Ini</b><br>
        @if($rumah->foto)
            <img src="{{ asset('foto_rumah/'.$rumah->foto) }}" width="120">
        @else
            <span class="text-muted">Belum ada foto</span>
        @endif
    </div>

    <input type="file" name="foto" class="form-control mb-3">

    <button class="btn btn-success">Update</button>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>

</form>

@endif

{{-- <button class="btn btn-success mt-2">Update</button>
<a href="{{ route('penghuni.index') }}" class="btn btn-secondary mt-2">Kembali</a>
</div> --}}
@endsection

<script>
document.getElementById('fotoEdit').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewEdit');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

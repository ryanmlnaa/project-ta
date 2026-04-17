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

{{-- ========================= --}}
{{-- FORM PENGHUNI --}}
{{-- ========================= --}}
@if($isEditPenghuni)

<form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-2">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control"
            value="{{ old('nama', $penghuni->nama) }}">
    </div>

    <div class="form-group mb-2">
        <label>No KTP</label>
        <input type="text" name="no_ktp" class="form-control"
            value="{{ old('no_ktp', $penghuni->no_ktp) }}">
    </div>

    <div class="form-group mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
            value="{{ old('email', $penghuni->email) }}">
    </div>

    {{-- 🔥 TAMBAHAN --}}
    <div class="form-group mb-2">
        <label>No HP</label>
        <input type="text" name="telepon" class="form-control"
            value="{{ old('telepon', $penghuni->telepon) }}">
    </div>

    <div class="form-group mb-2">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control"
            value="{{ old('alamat', $penghuni->alamat) }}">
    </div>

    <div class="form-group mb-3">
        <label>Pilih Rumah</label>
        <select name="rumah_id" class="form-control">
            <option value="">-- Pilih Rumah --</option>
            @foreach($rumahList as $r)
                <option value="{{ $r->id }}"
                    {{ $penghuni->rumah_id == $r->id ? 'selected' : '' }}>
                    {{ $r->blok }} - {{ $r->no_rumah }}
                </option>
            @endforeach
        </select>
    </div>

        <div class="form-group mb-2">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Aktif" {{ $penghuni->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Tidak Aktif" {{ $penghuni->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
    </div>

    <div class="form-group mb-2">
        <label>Status Huni</label>
        <select name="status_huni" id="statusHuni" class="form-control">
            <option value="Tetap" {{ $penghuni->status_huni == 'Tetap' ? 'selected' : '' }}>Tetap</option>
            <option value="Kontrak" {{ $penghuni->status_huni == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
        </select>
    </div>

    <div class="form-group mb-2" id="tanggalKeluarField"
        style="{{ $penghuni->status_huni == 'Kontrak' ? '' : 'display:none;' }}">
        <label>Tanggal Keluar</label>
        <input type="date" name="tanggal_keluar" class="form-control"
            value="{{ $penghuni->tanggal_keluar }}">
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>

</form>

{{-- ========================= --}}
{{-- FORM RUMAH --}}
{{-- ========================= --}}
@elseif($isEditRumah)

<form action="{{ route('admin.rumah.update', $rumah->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="form-group mb-2">
        <label>Blok</label>
        <input type="text" name="blok" class="form-control"
            value="{{ $rumah->blok }}">
    </div>

    <div class="form-group mb-2">
        <label>No Rumah</label>
        <input type="text" name="no_rumah" class="form-control"
            value="{{ $rumah->no_rumah }}">
    </div>

    <div class="form-group mb-2">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Kosong" {{ $rumah->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
            <option value="Terisi" {{ $rumah->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
        </select>
    </div>

    <div class="form-group mb-2">
        <label>Luas Tanah (m²)</label>
        <input type="number" name="luas_tanah" class="form-control"
            value="{{ $rumah->luas_tanah }}">
    </div>

    <div class="form-group mb-2">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control"
            value="{{ $rumah->harga }}">
    </div>

    <div class="form-group mb-2">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control">{{ $rumah->keterangan }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label>Foto Rumah</label><br>

        @if($rumah->foto)
            <img id="previewEdit" src="{{ asset('foto_rumah/'.$rumah->foto) }}" width="120"><br>
        @endif

        <input type="file" name="foto" id="fotoEdit" class="form-control mt-2">
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>

</form>

@endif

</div>
@endsection

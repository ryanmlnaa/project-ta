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
{{-- FORM --}}
{{-- ========================= --}}
@if($isEditPenghuni)

<form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama" class="form-control mb-2"
        value="{{ old('nama', $penghuni->nama) }}" placeholder="Nama">

    <input type="text" name="no_ktp" class="form-control mb-2"
        value="{{ old('no_ktp', $penghuni->no_ktp) }}" placeholder="KTP">

    <input type="email" name="email" class="form-control mb-2"
        value="{{ old('email', $penghuni->email) }}" placeholder="Email">

    <input type="text" name="alamat" class="form-control mb-2"
        value="{{ old('alamat', $penghuni->alamat) }}" placeholder="Alamat">

    <select name="rumah_id" class="form-control mb-2">
        <option value="">-- Pilih Rumah --</option>
        @foreach($rumahList as $r)
            <option value="{{ $r->id }}"
                {{ $penghuni->rumah_id == $r->id ? 'selected' : '' }}>
                {{ $r->blok }} - {{ $r->no_rumah }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>

</form>

{{-- ========================= --}}
{{-- RUMAH --}}
{{-- ========================= --}}
@elseif($isEditRumah)

<form action="{{ route('admin.rumah.update', $rumah->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <input type="text" name="blok" class="form-control mb-2"
        value="{{ $rumah->blok }}">

    <input type="text" name="no_rumah" class="form-control mb-2"
        value="{{ $rumah->no_rumah }}">

    <select name="status" class="form-control mb-2">
        <option value="Kosong" {{ $rumah->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
        <option value="Terisi" {{ $rumah->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
    </select>

    <input type="number" name="luas_tanah" class="form-control mb-2"
        value="{{ $rumah->luas_tanah }}">

    <input type="number" name="harga" class="form-control mb-2"
        value="{{ $rumah->harga }}">

    <textarea name="keterangan" class="form-control mb-2">{{ $rumah->keterangan }}</textarea>

    {{-- FOTO LAMA --}}
    @if($rumah->foto)
        <img id="previewEdit" src="{{ asset('foto_rumah/'.$rumah->foto) }}" width="120"><br>
    @else
        <img id="previewEdit" style="display:none;" width="120"><br>
    @endif

    {{-- INPUT FOTO --}}
    <input type="file" name="foto" id="fotoEdit" class="form-control mb-3">

    <button class="btn btn-success">Update</button>
    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>

</form>

@endif

</div>
@endsection

{{-- PREVIEW FOTO --}}
<script>
document.getElementById('fotoEdit')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewEdit');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

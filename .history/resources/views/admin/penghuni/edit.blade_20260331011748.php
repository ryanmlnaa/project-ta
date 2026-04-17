@extends('layouts.app')

@section('content')
<div class="container">

    {{-- JUDUL DINAMIS --}}
    @if(isset($penghuni) && $penghuni && isset($penghuni->id))
        <h3>Edit Data Penghuni</h3>
    @else
        <h3>Edit Data Rumah</h3>
    @endif

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- INFO RUMAH SAAT INI --}}
    @if(isset($penghuni) && $penghuni && $penghuni->rumah)
        <div class="alert alert-info">
            Rumah saat ini:
            <b>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</b>
        </div>
    @endif

    {{-- FORM DINAMIS --}}
    @if(isset($penghuni) && $penghuni && isset($penghuni->id))
        <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
    @elseif(isset($rumah) && is_object($rumah))
        <form action="{{ route('rumah.update', $rumah->id) }}" method="POST">
    @endif

    @csrf
    @method('PUT')

    {{-- ========================= --}}
    {{-- FORM PENGHUNI --}}
    {{-- ========================= --}}
    @if(isset($penghuni) && $penghuni && isset($penghuni->id))

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $penghuni->nama ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>No KTP</label>
            <input type="text" name="no_ktp" class="form-control"
                   value="{{ old('no_ktp', $penghuni->no_ktp ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $penghuni->email ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="telepon" class="form-control"
                   value="{{ old('telepon', $penghuni->telepon ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control"
                   value="{{ old('alamat', $penghuni->alamat ?? '') }}" required>
        </div>

        {{-- PILIH RUMAH --}}
        <div class="mb-3">
            <label>Pilih Rumah</label>
            <select name="rumah_id" class="form-control">
                <option value="">-- Pilih Rumah --</option>
                @foreach($rumahList ?? $rumah as $r)
                    <option value="{{ $r->id }}"
                        {{ old('rumah_id', $penghuni->rumah_id ?? '') == $r->id ? 'selected' : '' }}>
                        Blok {{ $r->blok }} - No {{ $r->no_rumah }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Aktif" {{ old('status', $penghuni->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status', $penghuni->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status Huni</label>
            <select name="status_huni" id="status_huni" class="form-control">
                <option value="Tetap" {{ old('status_huni', $penghuni->status_huni ?? '') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ old('status_huni', $penghuni->status_huni ?? '') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control"
                   value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk ?? '') }}">
        </div>

        <div class="mb-3" id="tanggal_keluar_group" style="display:none;">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control"
                   value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar ?? '') }}">
        </div>

    @else

    {{-- ========================= --}}
    {{-- FORM RUMAH --}}
    {{-- ========================= --}}

        <div class="mb-3">
            <label>Blok</label>
            <input type="text" name="blok" class="form-control"
                   value="{{ old('blok', $rumah->blok ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>No Rumah</label>
            <input type="text" name="no_rumah" class="form-control"
                   value="{{ old('no_rumah', $rumah->no_rumah ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Kosong" {{ ($rumah->status ?? '') == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                <option value="Terisi" {{ ($rumah->status ?? '') == 'Terisi' ? 'selected' : '' }}>Terisi</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Luas Tanah</label>
            <input type="number" name="luas_tanah" class="form-control"
                   value="{{ old('luas_tanah', $rumah->luas_tanah ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control"
                   value="{{ old('harga', $rumah->harga ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ old('keterangan', $rumah->keterangan ?? '') }}</textarea>
        </div>

    @endif

    {{-- BUTTON --}}
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Update
    </button>

    <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">
        Kembali
    </a>

    </form>
</div>

{{-- SCRIPT --}}
<script>
function toggleTanggalKeluar() {
    let status = document.getElementById('status_huni');
    let keluar = document.getElementById('tanggal_keluar_group');

    if (status && status.value === 'Kontrak') {
        keluar.style.display = 'block';
    } else if (keluar) {
        keluar.style.display = 'none';
    }
}

if(document.getElementById('status_huni')){
    toggleTanggalKeluar();
    document.getElementById('status_huni').addEventListener('change', toggleTanggalKeluar);
}
</script>

@endsection

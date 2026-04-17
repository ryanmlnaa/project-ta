@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($penghuni->id))
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

    {{-- 🔥 TAMBAHAN: INFO RUMAH SAAT INI --}}
    @if($penghuni->rumah)
        <div class="alert alert-info">
            Rumah saat ini:
            <b>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</b>
        </div>
    @endif

    @if(isset($penghuni->id))
        <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
    @else
        <form action="{{ route('rumah.update', $rumah->id ?? 0) }}" method="POST">
    @endif

    @csrf
    @method('PUT')

        {{-- NAMA --}}
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $penghuni->nama) }}" required>
        </div>

        {{-- KTP --}}
        <div class="mb-3">
            <label>No KTP</label>
            <input type="text" name="no_ktp" class="form-control"
                   value="{{ old('no_ktp', $penghuni->no_ktp) }}" required>
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $penghuni->email) }}" required>
        </div>

        {{-- TELEPON --}}
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="telepon" class="form-control"
                   value="{{ old('telepon', $penghuni->telepon) }}">
        </div>

        {{-- ALAMAT --}}
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control"
                   value="{{ old('alamat', $penghuni->alamat) }}" required>
        </div>

        {{-- 🔥 PILIH RUMAH --}}
        <div class="mb-3">
            <label>Pilih Rumah</label>
            <select name="rumah_id" class="form-control">
                <option value="">-- Pilih Rumah --</option>
                @foreach($rumah as $r)
                    <option value="{{ $r->id }}"
                        {{ old('rumah_id', $penghuni->rumah_id) == $r->id ? 'selected' : '' }}>
                        Blok {{ $r->blok }} - No {{ $r->no_rumah }}
                    </option>
                @endforeach
            </select>

            {{-- 🔥 TAMBAHAN --}}
            <small class="text-muted">
                Pilih rumah kosong atau tetap gunakan rumah saat ini
            </small>
        </div>

        {{-- STATUS --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Aktif" {{ old('status', $penghuni->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status', $penghuni->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        {{-- STATUS HUNI --}}
        <div class="mb-3">
            <label>Status Huni</label>
            <select name="status_huni" id="status_huni" class="form-control" required>
                <option value="Tetap" {{ old('status_huni', $penghuni->status_huni) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ old('status_huni', $penghuni->status_huni) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
        </div>

        {{-- TANGGAL MASUK --}}
        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control"
                   value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk) }}">
        </div>

        {{-- TANGGAL KELUAR --}}
        <div class="mb-3" id="tanggal_keluar_group" style="display:none;">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control"
                   value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar) }}">
        </div>

        {{-- 🔥 TAMBAHAN BUTTON STYLE --}}
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Update
        </button>

        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </form>
</div>

{{-- SCRIPT --}}
<script>
function toggleTanggalKeluar() {
    let statusHuni = document.getElementById('status_huni').value;
    let keluarGroup = document.getElementById('tanggal_keluar_group');

    if (statusHuni === 'Kontrak') {
        keluarGroup.style.display = 'block';
    } else {
        keluarGroup.style.display = 'none';
        document.getElementById('tanggal_keluar').value = '';
    }
}

toggleTanggalKeluar();
document.getElementById('status_huni').addEventListener('change', toggleTanggalKeluar);
</script>

@endsection

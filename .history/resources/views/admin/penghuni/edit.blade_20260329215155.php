@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Penghuni</h3>

    {{-- tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $penghuni->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>No KTP</label>
            <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp', $penghuni->no_ktp) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $penghuni->email) }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $penghuni->telepon) }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $penghuni->alamat) }}" required>
        </div>

        <div class="mb-3">
            <label>Blok</label>
            <input type="text" name="blok_rumah" class="form-control" value="{{ old('blok_rumah', $penghuni->blok_rumah) }}">
        </div>

        <div class="mb-3">
            <label>No Rumah</label>
            <input type="text" name="no_rumah" class="form-control" value="{{ old('no_rumah', $penghuni->no_rumah) }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Aktif" {{ old('status', $penghuni->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status', $penghuni->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status Huni</label>
            <select name="status_huni" id="status_huni" class="form-control">
                <option value="Tetap" {{ old('status_huni', $penghuni->status_huni) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Kontrak" {{ old('status_huni', $penghuni->status_huni) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control"
                   value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk) }}">
        </div>

        <div class="mb-3" id="tanggal_keluar_group" style="display:none;">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control"
                   value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar) }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

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

    // jalankan saat halaman dibuka
    toggleTanggalKeluar();

    // jalankan saat pilihan berubah
    document.getElementById('status_huni').addEventListener('change', toggleTanggalKeluar);
</script>
@endsection

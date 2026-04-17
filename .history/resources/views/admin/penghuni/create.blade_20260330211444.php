@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Data Penghuni</h3>

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

    <form action="{{ route('penghuni.store') }}" method="POST">
        @csrf

        {{-- NAMA --}}
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">
        </div>

        {{-- KTP --}}
        <div class="mb-3">
            <label>No KTP</label>
            <input type="text" name="no_ktp" class="form-control" required value="{{ old('no_ktp') }}">
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        {{-- TELEPON --}}
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}">
        </div>

        {{-- ALAMAT --}}
        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required value="{{ old('alamat') }}">
        </div>

        {{-- 🔥 PILIH RUMAH (PENGGANTI BLOK & NO RUMAH) --}}
        <div class="mb-3">
            <label>Pilih Rumah</label>
            <select name="rumah_id" class="form-control">
                <option value="">-- Pilih Rumah --</option>
                @foreach($rumah as $r)
                    <option value="{{ $r->id }}" {{ old('rumah_id') == $r->id ? 'selected' : '' }}>
                        Blok {{ $r->blok }} - No {{ $r->no_rumah }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- STATUS --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        {{-- STATUS HUNI --}}
        <div class="mb-3">
            <label>Status Huni</label>
            <select name="status_huni" id="status_huni" class="form-control">
                <option value="Tetap">Tetap</option>
                <option value="Kontrak">Kontrak</option>
            </select>
        </div>

        {{-- TANGGAL MASUK --}}
        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
        </div>

        {{-- TANGGAL KELUAR --}}
        <div class="mb-3" id="tanggal_keluar_group" style="display:none;">
            <label>Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar') }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penghuni.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- SCRIPT --}}
<script>
    document.getElementById('status_huni').addEventListener('change', function() {
        let keluarGroup = document.getElementById('tanggal_keluar_group');
        if (this.value === 'Kontrak') {
            keluarGroup.style.display = 'block';
        } else {
            keluarGroup.style.display = 'none';
            document.getElementById('tanggal_keluar').value = '';
        }
    });

    // trigger saat reload (biar tidak hilang)
    document.getElementById('status_huni').dispatchEvent(new Event('change'));
</script>
@endsection

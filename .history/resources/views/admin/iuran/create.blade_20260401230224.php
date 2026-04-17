@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Iuran</h3>
    <a href="{{ route('iuran.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('iuran.store') }}" method="POST">
        @csrf

        {{-- NAMA PENGHUNI --}}
        <div class="form-group mb-3">
            <label>Nama Penghuni</label>
            <select name="penghuni_id" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghuni as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- BULAN --}}
        <div class="form-group mb-3">
            <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" placeholder="Contoh: Januari" required>
        </div>

        {{-- TAHUN --}}
        <div class="form-group mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" placeholder="2025" required>
        </div>

        {{-- JUMLAH --}}
        <div class="form-group mb-3">
            <label>Jumlah Iuran</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 100000" required>
        </div>

        {{-- 🔥 JENIS IURAN --}}
        <div class="form-group mb-3">
            <label>Jenis Iuran</label>
            <select name="jenis_iuran" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="Keamanan">Keamanan</option>
                <option value="Kebersihan">Kebersihan</option>
                <option value="Air">Air</option>
                <option value="Sampah">Sampah</option>
                <option value="Listrik">Listrik</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        {{-- 🔥 KETERANGAN --}}
        <div class="form-group mb-3">
            <label>Keterangan / Rincian</label>
            <textarea name="keterangan" class="form-control" placeholder="Contoh: Iuran keamanan bulan Januari"></textarea>
        </div>

        {{-- STATUS --}}
        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="belum">Belum Bayar</option>
                <option value="lunas">Lunas</option>
            </select>
        </div>

        {{-- TANGGAL BAYAR --}}
        <div class="form-group mb-3">
            <label>Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

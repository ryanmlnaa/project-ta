@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Iuran</h3>
    <a href="{{ route('iuran.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('iuran.update', $iuran->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA PENGHUNI --}}
        <div class="form-group mb-3">
            <label>Nama Penghuni</label>
            <select name="penghuni_id" class="form-control" required>
                @foreach($penghuni as $p)
                    <option value="{{ $p->id }}" {{ $iuran->penghuni_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- BULAN --}}
        <div class="form-group mb-3">
            <label>Bulan</label>
            <input type="text" name="bulan" class="form-control" value="{{ $iuran->bulan }}" required>
        </div>

        {{-- TAHUN --}}
        <div class="form-group mb-3">
            <label>Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ $iuran->tahun }}" required>
        </div>

        {{-- JUMLAH --}}
        <div class="form-group mb-3">
            <label>Jumlah Iuran</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $iuran->jumlah }}" required>
        </div>

        {{-- 🔥 JENIS IURAN --}}
        <div class="form-group mb-3">
            <label>Jenis Iuran</label>
            <select name="jenis_iuran" class="form-control" required>
                <option {{ $iuran->jenis_iuran == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                <option {{ $iuran->jenis_iuran == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                <option {{ $iuran->jenis_iuran == 'Air' ? 'selected' : '' }}>Air</option>
                <option {{ $iuran->jenis_iuran == 'Sampah' ? 'selected' : '' }}>Sampah</option>
                <option {{ $iuran->jenis_iuran == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                <option {{ $iuran->jenis_iuran == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        {{-- 🔥 KETERANGAN --}}
        <div class="form-group mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $iuran->keterangan }}</textarea>
        </div>

        {{-- STATUS --}}
        <div class="form-group mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="belum" {{ $iuran->status == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="lunas" {{ $iuran->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        {{-- TANGGAL BAYAR --}}
        {{-- <div class="form-group mb-3">
            <label>Tanggal Bayar</label>
            <input type="date" name="tanggal_bayar" class="form-control"
                value="{{ $iuran->tanggal_bayar }}">
        </div> --}}

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection

@extends('layouts.bendahara')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit & Ajukan Ulang Iuran</h4>

    <div class="alert alert-danger">
        <strong>Alasan ditolak RT:</strong> {{ $iuran->catatan_rt }}
    </div>

    <form action="{{ route('bendahara.iuran.update', $iuran->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Penghuni</label>
            <select name="penghuni_id" class="form-control" required>
                @foreach($penghunis as $p)
                    <option value="{{ $p->id }}" {{ $iuran->penghuni_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }} ({{ $p->no_rumah ?? '-' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Bulan</label>
                <select name="bulan" class="form-control" required>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                        <option value="{{ $b }}" {{ $iuran->bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ $iuran->tahun }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ $iuran->jumlah }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis Iuran</label>
            <input type="text" name="jenis_iuran" class="form-control" value="{{ $iuran->jenis_iuran }}" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $iuran->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Ajukan Ulang ke RT</button>
        <a href="{{ route('bendahara.iuran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

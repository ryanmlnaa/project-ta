@extends('layouts.bendahara')

@section('content')
<div class="container">
    <h4 class="mb-4">Ajukan Iuran Baru</h4>

    <form action="{{ route('bendahara.iuran.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Penghuni</label>
            <select name="penghuni_id" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghunis as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rumah ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Bulan</label>
                <select name="bulan" class="form-control" required>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Iuran</label>
            <input type="text" name="jenis_iuran" class="form-control" placeholder="Misal: Iuran Bulanan" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan ke RT</button>
        <a href="{{ route('bendahara.iuran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

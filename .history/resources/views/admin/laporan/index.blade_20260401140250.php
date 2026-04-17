@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Cetak Laporan</h3>

    <form action="{{ route('laporan.cetak') }}" method="GET">
        <div class="mb-3">
            <label>Bulan</label>
            <select class="form-control" name="bulan">
                <option>Januari</option>
                <option>Februari</option>
            </select>
        </div>

        <button class="btn btn-success">
            Cetak Laporan
        </button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Detail Rekap — {{ $rekap->periode }}</h4>

    @if($rekap->status === 'ditolak')
    <div class="alert alert-danger">
        <strong>Alasan ditolak RT:</strong> {{ $rekap->catatan_rt }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Penghuni</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap->iurans as $i)
            <tr>
                <td>{{ $i->penghuni->nama ?? '-' }}</td>
                <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($i->status) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('bendahara.rekap.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <h4 class="mb-4">Detail Rekap — {{ $rekap->periode }}</h4>

    @if($rekap->status === 'ditolak')
    <div class="alert alert-danger">
        <strong>Alasan ditolak RT:</strong> {{ $rekap->catatan_rt }}
    </div>
    @endif

    {{-- Desktop Table --}}
    <div class="d-none d-md-block">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
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
                    <td>
                        <span class="badge
                            @if($i->status === 'lunas') bg-success
                            @elseif($i->status === 'belum') bg-warning text-dark
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($i->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-secondary fw-bold">
                    <td colspan="2">Total</td>
                    <td>Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Mobile Cards --}}
    <div class="d-md-none">
        @foreach($rekap->iurans as $i)
        <div class="card mb-3 shadow-sm">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold">{{ $i->penghuni->nama ?? '-' }}</div>
                        <small class="text-muted">{{ $i->bulan }} {{ $i->tahun }}</small>
                    </div>
                    <span class="badge ms-2
                        @if($i->status === 'lunas') bg-success
                        @elseif($i->status === 'belum') bg-warning text-dark
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($i->status) }}
                    </span>
                </div>
                <div class="mt-1 text-end fw-bold text-primary">
                    Rp {{ number_format($i->jumlah, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach

        {{-- Total Mobile --}}
        <div class="card border-secondary mb-3">
            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-secondary">Total</span>
                <span class="fw-bold text-primary">
                    Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <a href="{{ route('bendahara.rekap.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>
@endsection

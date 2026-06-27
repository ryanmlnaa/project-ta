@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Kas Bendahara (RT)</h4>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Total Masuk</div>
                    <div class="h5 text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Total Keluar</div>
                    <div class="h5 text-danger">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">Saldo</div>
                    <div class="h5 text-primary">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Riwayat Kas (Read Only)</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kas as $k)
                    <tr>
                        <td>{{ $k->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if($k->jenis === 'masuk')
                                <span class="badge bg-success">Masuk</span>
                            @else
                                <span class="badge bg-danger">Keluar</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($k->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $k->keterangan }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Belum ada catatan kas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

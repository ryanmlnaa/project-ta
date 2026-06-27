@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Kas Bendahara</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <div class="d-flex justify-content-between mb-3">
        <h5>Catat Kas Manual</h5>
        <a href="{{ route('bendahara.kas.tagihan.create') }}" class="btn btn-success btn-sm">+ Tagih Kas ke Penghuni</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">Catat Kas Manual (Masuk/Keluar)</div>
        <div class="card-body">
            <form action="{{ route('bendahara.kas.store') }}" method="POST" class="row g-2">
                @csrf
                <div class="col-md-2">
                    <select name="jenis" class="form-control" required>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="jumlah" class="form-control" placeholder="Jumlah (Rp)" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Catat</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Riwayat Kas</div>
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

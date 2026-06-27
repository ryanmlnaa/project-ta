@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Detail Rekap — {{ $rekap->periode }}</h4>
    <p>Diajukan oleh: <strong>{{ $rekap->bendahara->name ?? '-' }}</strong></p>

    <table class="table">
        <thead>
            <tr>
                <th>Penghuni</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
                <th>Metode Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap->iurans as $i)
            <tr>
                <td>{{ $i->penghuni->nama ?? '-' }}</td>
                <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                <td>{{ $i->metode ?? '-' }}</td>
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

    <div class="d-flex gap-2 mt-3">
        <form action="{{ route('rt.review-rekap.setujui', $rekap->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button class="btn btn-success" onclick="return confirm('Setujui rekap ini? Semua iuran di dalamnya akan jadi lunas.')">Setujui Semua</button>
        </form>

        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakRekapModal">Tolak</button>
    </div>

    <div class="modal fade" id="tolakRekapModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('rt.review-rekap.tolak', $rekap->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header"><h5>Alasan Penolakan Rekap</h5></div>
                    <div class="modal-body">
                        <textarea name="catatan_rt" class="form-control" required placeholder="Tulis alasan..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('rt.review-rekap.index') }}" class="btn btn-link mt-2">← Kembali</a>
</div>
@endsection

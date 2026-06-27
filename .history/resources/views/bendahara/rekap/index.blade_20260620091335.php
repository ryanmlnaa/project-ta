@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Rekap Iuran</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->has('rekap'))
        <div class="alert alert-danger">{{ $errors->first('rekap') }}</div>
    @endif

    {{-- Form kirim rekap baru --}}
    <div class="card mb-4">
        <div class="card-header">Kirim Rekap Baru</div>
        <div class="card-body">
            <p>Iuran siap direkap (status menunggu, belum masuk rekap manapun): <strong>{{ $iuranSiapRekap->count() }}</strong></p>

            @if($iuranSiapRekap->count() > 0)
            <table class="table table-sm mb-3">
                <thead>
                    <tr>
                        <th>Penghuni</th>
                        <th>Bulan/Tahun</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($iuranSiapRekap as $i)
                    <tr>
                        <td>{{ $i->penghuni->nama ?? '-' }}</td>
                        <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                        <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('bendahara.rekap.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Periode</label>
                    <input type="text" name="periode" class="form-control" value="{{ now()->translatedFormat('F Y') }}" readonly style="background:#f0f4f0;cursor:not-allowed;">
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Kirim rekap ke RT?')">Kirim Rekap ke RT</button>
            </form>
            @else
                <p class="text-muted">Belum ada iuran yang siap direkap.</p>
            @endif
        </div>
    </div>

    {{-- Riwayat rekap --}}
    <div class="card">
        <div class="card-header">Riwayat Rekap</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Status</th>
            <th>Catatan RT</th>
            <th>Bukti</th>
            <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekaps as $r)
                    <tr>
                        <td>{{ $r->periode }}</td>
                        <td>
                            @php
                                $badge = ['diajukan' => 'warning', 'ditolak' => 'danger', 'disetujui' => 'success'][$r->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($r->status) }}</span>
                        </td>
                        <td>{{ $r->catatan_rt ?? '-' }}</td>
                        <td><a href="{{ route('bendahara.rekap.show', $r->id) }}" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Belum ada rekap.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

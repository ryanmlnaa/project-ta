@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Daftar Iuran</h4>
        <a href="{{ route('bendahara.iuran.create') }}" class="btn btn-primary">+ Ajukan Iuran</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Penghuni</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Catatan RT</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($iurans as $i)
            <tr>
                <td>{{ $i->penghuni->nama ?? '-' }}</td>
                <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                <td>{{ $i->jenis_iuran }}</td>
                <td>
                    @php
                        $badge = [
                            'diajukan' => 'warning',
                            'ditolak'  => 'danger',
                            'aktif'    => 'info',
                            'menunggu' => 'primary',
                            'lunas'    => 'success',
                        ][$i->status] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ ucfirst($i->status) }}</span>
                </td>
                <td>{{ $i->catatan_rt ?? '-' }}</td>
                <td>
                    @if($i->status === 'ditolak')
                        <a href="{{ route('bendahara.iuran.edit', $i->id) }}" class="btn btn-sm btn-warning">Edit & Ajukan Ulang</a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada iuran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Review Rekap dari Bendahara</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Periode</th>
                <th>Bendahara</th>
                <th>Jumlah Iuran</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekaps as $r)
            <tr>
                <td>{{ $r->periode }}</td>
                <td>{{ $r->bendahara->name ?? '-' }}</td>
                <td>{{ $r->iurans->count() }}</td>
                <td>Rp {{ number_format($r->iurans->sum('jumlah'),0,',','.') }}</td>
                <td>
                    <a href="{{ route('rt.review-rekap.show', $r->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Tidak ada rekap yang menunggu review.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

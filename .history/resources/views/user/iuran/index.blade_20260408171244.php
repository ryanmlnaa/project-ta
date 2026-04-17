@extends('layouts.app')
@section('content')
<h3>Data Iuran Saya</h3>

<table class="table">
    <tr>
        <th>Bulan</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($iuran as $i)
    <tr>
        <td>{{ $i->bulan }}</td>
        <td>Rp {{ number_format($i->jumlah) }}</td>
        <td>{{ $i->status }}</td>
        <td>
            <a href="{{ route('user.iuran.upload', $i->id) }}" class="btn btn-primary btn-sm">
                Upload
            </a>
        </td>
        <td>
    @if($i->bukti_pembayaran)
        <img src="{{ asset('bukti/' . $i->bukti_pembayaran) }}" width="80">
    @else
        -
    @endif
</td>
    </tr>
    @endforeach
</table>
@endsection

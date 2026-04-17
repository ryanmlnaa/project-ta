@extends('layouts.app')
@section('content')
<h3>Status Pembayaran</h3>

<table class="table">
    <tr>
        <th>Bulan</th>
        <th>Bukti</th>
        <th>Status</th>
    </tr>

    @foreach($iuran as $i)
    <tr>
        <td>{{ $i->bulan }}</td>
        <td>
            @if($i->bukti_bayar)
                <img src="{{ asset('bukti/'.$i->bukti_bayar) }}" width="80">
            @else
                -
            @endif
        </td>
        <td>
            @if($i->status == 'lunas')
                <span class="badge bg-success">Lunas</span>
            @else
                <span class="badge bg-warning">Menunggu</span>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection

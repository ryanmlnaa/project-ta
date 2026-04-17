@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Status Pembayaran</h3>

    <table class="table table-bordered">
        <tr>
            <th>Bulan</th>
            <th>Status</th>
            <th>Bukti</th>
        </tr>

        @foreach($iuran as $i)
        <tr>
            <td>{{ $i->bulan }}</td>
            <td>{{ $i->status }}</td>
            <td>
                @if($i->bukti_pembayaran)
                    <img src="{{ asset('bukti/'.$i->bukti_pembayaran) }}" width="100">
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

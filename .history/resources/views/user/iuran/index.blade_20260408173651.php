@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Iuran Saya</h3>

    <table class="table table-bordered">
        <tr>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach($iuran as $i)
        <tr>
            <td>{{ $i->bulan }}</td>
            <td>{{ $i->tahun }}</td>
            <td>Rp {{ number_format($i->jumlah,0,',','.') }}</td>
            <td>
                @if($i->status == 'lunas')
                    <span class="badge bg-success">Lunas</span>
                @elseif($i->bukti_pembayaran)
                    <span class="badge bg-warning">Menunggu</span>
                @else
                    <span class="badge bg-danger">Belum Bayar</span>
                @endif
            </td>
            <td>
                @if(!$i->bukti_pembayaran)
                <a href="{{ route('user.iuran.upload', $i->id) }}" class="btn btn-primary btn-sm">
                    Upload
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

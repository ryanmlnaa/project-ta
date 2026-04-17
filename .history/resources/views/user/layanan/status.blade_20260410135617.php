@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Status Pengaduan</h4>

    <table class="table table-bordered">
        <tr>
            <th>Kategori</th>
            <th>Status</th>
            <th>Tanggapan</th>
        </tr>

        @foreach($layanan as $item)
        <tr>
            <td>{{ $item->kategori_masalah }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->tanggapan_admin ?? '-' }}</td>
        </tr>
        @endforeach

    </table>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">

    <h4>Status Pengaduan Saya</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>

        <tbody>
            @foreach($layanan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tanggal_pengaduan }}</td>
                <td>{{ $item->kategori_masalah }}</td>
                <td>
                    @if($item->status == 'diajukan')
                        <span class="badge badge-secondary">Diajukan</span>
                    @elseif($item->status == 'diproses')
                        <span class="badge badge-warning">Diproses</span>
                    @else
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-info btn-sm"
                        data-toggle="modal"
                        data-target="#detail{{ $item->id }}">
                        Detail
                    </button>
                </td>
            </tr>

            <!-- MODAL -->
            <div class="modal fade" id="detail{{ $item->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5>Detail Pengaduan</h5>
                        </div>

                        <div class="modal-body">
                            <p><b>Deskripsi:</b> {{ $item->deskripsi }}</p>
                            <p><b>Tanggapan:</b> {{ $item->tanggapan_admin ?? 'Belum ada' }}</p>
                            <p><b>Status:</b> {{ $item->status }}</p>

                            @if($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" width="100%">
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>

</div>
@endsection

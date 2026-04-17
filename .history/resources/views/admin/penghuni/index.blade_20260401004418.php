@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Kelola Data Perumahan</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===================== --}}
    {{-- DATA RUMAH --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-success">Data Rumah</h6>

            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalRumah">
                + Tambah Rumah
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="tableRumah">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Blok</th>
                        <th>No Rumah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($rumahList as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->blok }}</td>
                        <td>{{ $r->no_rumah }}</td>

                        <td>
                            @if($r->status == 'Kosong')
                                <span class="badge badge-success">Kosong</span>
                            @else
                                <span class="badge badge-danger">Terisi</span>
                            @endif
                        </td>

                        <td>

                            {{-- 🔥 DETAIL --}}
                            <button
                                type="button"
                                class="btn btn-info btn-sm btn-detail"
                                data-nama="{{ $r->penghuni->nama ?? 'Belum ada penghuni' }}"
                                data-email="{{ $r->penghuni->email ?? '-' }}"
                                data-telepon="{{ $r->penghuni->telepon ?? '-' }}"
                                data-status="{{ $r->status }}"
                                data-blok="{{ $r->blok }}"
                                data-nomor="{{ $r->no_rumah }}"
                            >
                                Detail
                            </button>

                            <a href="{{ route('rumah.edit', $r->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

{{-- ===================== --}}
{{-- MODAL DETAIL --}}
{{-- ===================== --}}
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Detail Rumah & Penghuni</h5>
            </div>

            <div class="modal-body">
                <p><b>Blok:</b> <span id="d_blok"></span></p>
                <p><b>No Rumah:</b> <span id="d_nomor"></span></p>
                <p><b>Status:</b> <span id="d_status"></span></p>

                <hr>

                <h6>Data Penghuni</h6>
                <p><b>Nama:</b> <span id="d_nama"></span></p>
                <p><b>Email:</b> <span id="d_email"></span></p>
                <p><b>No HP:</b> <span id="d_telepon"></span></p>
            </div>

        </div>
    </div>
</div>

{{-- ===================== --}}
{{-- STYLE --}}
{{-- ===================== --}}
<style>
.btn-detail {
    position: relative;
    z-index: 9999;
}
</style>

{{-- ===================== --}}
{{-- SCRIPT (WAJIB DI SINI) --}}
{{-- ===================== --}}
<script>
$(document).ready(function () {

    // DataTables
    $('#tableRumah').DataTable();

    // 🔥 FIX DETAIL BUTTON
    $(document).on('click', '.btn-detail', function () {

        let btn = $(this);

        $('#d_blok').text(btn.data('blok'));
        $('#d_nomor').text(btn.data('nomor'));
        $('#d_status').text(btn.data('status'));

        $('#d_nama').text(btn.data('nama'));
        $('#d_email').text(btn.data('email'));
        $('#d_telepon').text(btn.data('telepon'));

        $('#modalDetail').modal('show');
    });

});
</script>

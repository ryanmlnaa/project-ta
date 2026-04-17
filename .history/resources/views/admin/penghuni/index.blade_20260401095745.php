@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Kelola Data Perumahan</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- ===================== --}}
    {{-- KAVLING VISUAL --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="font-weight-bold text-success">Pilih Kavling</h6>
        </div>
        <div class="card-body">

            <div class="kavling-grid">
                @for($i = 1; $i <= 30; $i++)
                    @php
                        $dataRumah = $rumahList->where('no_rumah', $i)->first();
                    @endphp

                    <div
                        class="kavling {{ !$dataRumah || $dataRumah->status == 'Kosong' ? 'kosong' : 'terisi' }}"
                        onclick="pilihKavling('{{ $dataRumah && $dataRumah->status == 'Terisi' ? '' : $i }}')"
                    >
                        {{ $i }}
                    </div>
                @endfor
            </div>

            <small class="text-muted">
                🟢 Kosong | 🔴 Terisi
            </small>

        </div>
    </div>

    {{-- ===================== --}}
    {{-- DATA PENGHUNI --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-primary">Data Penghuni</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tablePenghuni">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>No KTP</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Blok</th>
                            <th>No Rumah</th>
                            <th>Status</th>
                            <th>Status Huni</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penghuni as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->no_ktp }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->rumah->blok ?? '-' }}</td>
                            <td>{{ $p->rumah->no_rumah ?? '-' }}</td>

                            <td>
                                @if($p->status == 'Aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>

                            <td>{{ $p->status_huni }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d-m-Y') }}</td>
                            <td>{{ $p->tanggal_keluar }}</td>

                            <td>
                                <a href="{{ route('penghuni.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('penghuni.delete', $p->id) }}" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableRumah">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Blok</th>
                            <th>No Rumah</th>
                            <th>Status</th>
                            <th>Luas Tanah</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumahList as $r)
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

                            <td>{{ $r->luas_tanah ? $r->luas_tanah.' m²' : '-' }}</td>

                            <td>
                                @if($r->harga)
                                    Rp {{ number_format($r->harga, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $r->keterangan ?? '-' }}</td>
                            <td>

                                <button
                                    class="btn btn-info btn-sm btn-detail"
                                    data-blok="{{ $r->blok }}"
                                    data-nomor="{{ $r->no_rumah }}"
                                    data-status="{{ $r->status }}"
                                    data-nama="{{ $r->penghuni->nama ?? 'Kosong' }}"
                                    data-email="{{ $r->penghuni->email ?? '-' }}"
                                    data-telepon="{{ $r->penghuni->telepon ?? '-' }}"
                                >
                                    Detail
                                </button>

                                <a href="{{ route('rumah.edit', $r->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('rumah.destroy', $r->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data rumah</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
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

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    $('#tablePenghuni').DataTable();
    $('#tableRumah').DataTable();

    $(document).on('click', '.btn-detail', function () {

        let btn = $(this);

        console.log("DETAIL CLICK OK");

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
@endsection

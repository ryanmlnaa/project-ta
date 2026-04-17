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
    {{-- TABEL 1: DATA PENGHUNI --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-primary">Data Penghuni</h6>
            <a href="{{ route('penghuni.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Penghuni
            </a>
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
                            <td>{{ $p->blok_rumah }}</td>
                            <td>{{ $p->no_rumah }}</td>
                            <td>{{ $p->status }}</td>
                            <td>{{ $p->status_huni }}</td>
                            <td>{{ $p->tanggal_masuk }}</td>
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
    {{-- TABEL 2: DATA RUMAH --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-success">Data Rumah</h6>
            <a href="{{ route('rumah.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Rumah
            </a>
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
                            <th>Gambar</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumah as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->blok }}</td>
                            <td>{{ $r->no_rumah }}</td>
                            <td>{{ $r->status }}</td>
                            <td>{{ $r->luas_tanah }} m²</td>
                            <td>Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($r->gambar)
                                    <img src="{{ asset('storage/' . $r->gambar) }}" width="80">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $r->keterangan }}</td>
                            <td>
                                <a href="{{ route('rumah.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('rumah.delete', $r->id) }}" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data rumah</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#tablePenghuni').DataTable();
    $('#tableRumah').DataTable();
});
</script>
@endpush

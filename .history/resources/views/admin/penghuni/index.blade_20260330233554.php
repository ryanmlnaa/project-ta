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
    {{-- KAVLING --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="font-weight-bold text-success">Pilih Kavling</h6>
        </div>
        <div class="card-body">

            <div class="kavling-grid">
                @for($i = 1; $i <= 30; $i++)
                    @php
                        $dataRumah = $rumah->where('no_rumah', $i)->first();
                    @endphp

                    <div
                        class="kavling {{ !$dataRumah || $dataRumah->status == 'Kosong' ? 'kosong' : 'terisi' }}"
                        onclick="pilihKavling('{{ $dataRumah && $dataRumah->status == 'Terisi' ? '' : $i }}')"
                    >
                        {{ $i }}
                    </div>
                @endfor
            </div>

            <small>
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
                            <td>{{ $p->rumah->blok ?? '-' }}</td>
                            <td>{{ $p->rumah->no_rumah ?? '-' }}</td>
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
    {{-- DATA RUMAH --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-success">Data Rumah</h6>

            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalRumah">
                <i class="fas fa-plus"></i> Tambah Rumah
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

                            {{-- TAMBAHAN --}}
                            <th>Type</th>

                            <th>Status</th>

                            {{-- TAMBAHAN --}}
                            <th>Kepemilikan</th>

                            <th>Luas Tanah</th>
                            <th>Harga</th>

                            {{-- TAMBAHAN --}}
                            <th>Posisi</th>

                            <th>Keterangan</th>

                            {{-- TAMBAHAN --}}
                            <th>Dibuat</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rumah as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><b>{{ $r->blok }}</b></td>
                            <td>{{ $r->no_rumah }}</td>

                            <td>{{ $r->type_rumah ?? '-' }}</td>

                            <td>
                                @if($r->status == 'Kosong')
                                    <span class="badge badge-success">Kosong</span>
                                @else
                                    <span class="badge badge-danger">Terisi</span>
                                @endif
                            </td>

                            <td>
                                @if($r->status_kepemilikan == 'Tersedia')
                                    <span class="badge badge-success">Tersedia</span>
                                @elseif($r->status_kepemilikan == 'Booking')
                                    <span class="badge badge-warning">Booking</span>
                                @else
                                    <span class="badge badge-danger">Terjual</span>
                                @endif
                            </td>

                            <td>{{ $r->luas_tanah ?? '-' }} m²</td>

                            <td>
                                @if($r->harga)
                                    Rp {{ number_format($r->harga, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $r->posisi ?? '-' }}</td>

                            <td>{{ $r->keterangan ?? '-' }}</td>

                            <td>{{ $r->created_at ? $r->created_at->format('d-m-Y') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">Belum ada data rumah</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>
@endsection

<style>
.kavling-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 12px;
}

.kavling {
    display: flex;
    justify-content: center;
    align-items: center;

    height: 50px;
    border-radius: 8px;

    font-weight: bold;
    color: white;

    cursor: pointer;
    transition: 0.2s;
}

/* HIJAU */
.kosong {
    background: #28a745;
}

/* MERAH */
.terisi {
    background: #dc3545;
    cursor: not-allowed;
}

/* HOVER */
.kosong:hover {
    background: #218838;
    transform: scale(1.05);
}
</style>

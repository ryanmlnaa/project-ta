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
            {{-- <a href="{{ route('penghuni.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Penghuni
            </a> --}}
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
                            {{-- DETAIL --}}
                            <button
                                class="btn btn-info btn-sm btn-detail"
                                data-nama="{{ $r->penghuni->nama ?? '-' }}"
                                data-email="{{ $r->penghuni->email ?? '-' }}"
                                data-telepon="{{ $r->penghuni->telepon ?? '-' }}"
                                data-status="{{ $r->status }}"
                                data-blok="{{ $r->blok }}"
                                data-nomor="{{ $r->no_rumah }}"
                            >
                                Detail
                            </button>

                            {{-- EDIT --}}
                            <a href="{{ route('rumah.edit', $r->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            {{-- HAPUS --}}
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

</div>
@endsection

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

{{-- MODAL --}}
<div class="modal fade" id="modalRumah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('rumah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <input type="text" name="blok" class="form-control mb-2" placeholder="Blok" required>

                    <input type="text" name="no_rumah" id="no_rumah" class="form-control mb-2" placeholder="No Rumah" required>

                    <select name="status" class="form-control mb-2">
                        <option value="Kosong">Kosong</option>
                        <option value="Terisi">Terisi</option>
                    </select>

                    <input type="number" name="luas_tanah" class="form-control mb-2" placeholder="Luas Tanah">

                    <input type="number" name="harga" class="form-control mb-2" placeholder="Harga">

                    <textarea name="keterangan" class="form-control mb-2" placeholder="Keterangan"></textarea>

                    {{-- 🔥 TAMBAHAN FOTO --}}
                    <div class="form-group mt-2">
                        <label>Foto Kavling</label>
                        <input type="file" name="foto" class="form-control" id="fotoInput" accept="image/*">
                    </div>

                    {{-- 🔥 PREVIEW FOTO --}}
                    <div class="text-center mt-2">
                        <img id="previewFoto" src="" style="max-height:150px; display:none;" class="img-fluid rounded">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.kavling-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 10px;
}

.kavling {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 45px;
    border-radius: 8px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.kosong {
    background: #28a745;
}

.terisi {
    background: #dc3545;
    cursor: not-allowed;
}

.kosong:hover {
    background: #218838;
    transform: scale(1.05);
}
</style>

<script>
function pilihKavling(no) {
    if (!no) {
        alert('Kavling sudah terisi!');
        return;
    }

    document.getElementById('no_rumah').value = no;
    $('#modalRumah').modal('show');
}
</script>

@push('scripts')
<script>
$(document).ready(function () {
    $('#tablePenghuni').DataTable();
    $('#tableRumah').DataTable();
});
</script>

<script>
document.getElementById('fotoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('previewFoto');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // pakai event delegation (ANTI ERROR DataTables)
    document.addEventListener('click', function(e) {

        if (e.target.classList.contains('btn-detail')) {

            let btn = e.target;

            document.getElementById('d_blok').innerText = btn.dataset.blok;
            document.getElementById('d_nomor').innerText = btn.dataset.nomor;
            document.getElementById('d_status').innerText = btn.dataset.status;

            document.getElementById('d_nama').innerText = btn.dataset.nama;
            document.getElementById('d_email').innerText = btn.dataset.email;
            document.getElementById('d_telepon').innerText = btn.dataset.telepon;

            let modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            modal.show();
        }

    });

});
</script>
@endpush

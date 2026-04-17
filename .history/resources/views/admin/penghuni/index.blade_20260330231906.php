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
                        $terisi = $rumah->contains('no_rumah', $i);
                    @endphp

                    @php
    $dataRumah = $rumah->where('no_rumah', $i)->first();
@endphp

<div
    class="kavling
        {{ !$dataRumah ? 'kosong' : ($dataRumah->status == 'Kosong' ? 'kosong' : 'terisi') }}"
    onclick="pilihKavling('{{ $dataRumah && $dataRumah->status == 'Terisi' ? '' : $i }}')"
>
    {{ $i }}
</div>
                @endfor
            </div>

            <small class="text-muted">
                <span style="color:green;">■</span> Kosong |
                <span style="color:red;">■</span> Terisi
            </small>

        </div>
    </div>

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
    {{-- TABEL 2: DATA RUMAH --}}
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumah as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->blok }}</td>
                            <td>{{ $r->no_rumah }}</td>
                            <td>{{ $r->status }}</td>
                            <td>{{ $r->luas_tanah }}</td>
                            <td>{{ $r->harga }}</td>
                            <td>{{ $r->keterangan }}</td>
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

{{-- MODAL --}}
<div class="modal fade" id="modalRumah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penghuni.index') }}" method="POST">
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
                    <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
.kavling-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 8px;
}

.kavling {
    padding: 10px;
    text-align: center;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
}

.kosong {
    background: green;
    color: white;
}

.terisi {
    background: red;
    color: white;
    cursor: not-allowed;
}
</style>

{{-- SCRIPT --}}
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
@endpush

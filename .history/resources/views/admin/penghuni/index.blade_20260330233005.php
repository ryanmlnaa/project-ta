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
                            <th>Type</th>
                            <th>Status</th>
                            <th>Kepemilikan</th>
                            <th>Luas</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rumah as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><b>{{ $r->blok }}</b></td>
                            <td>{{ $r->no_rumah }}</td>

                            {{-- TYPE --}}
                            <td>{{ $r->type_rumah ?? '-' }}</td>

                            {{-- STATUS --}}
                            <td>
                                @if($r->status == 'Kosong')
                                    <span class="badge badge-success">Kosong</span>
                                @else
                                    <span class="badge badge-danger">Terisi</span>
                                @endif
                            </td>

                            {{-- KEPEMILIKAN --}}
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

                            <td>{{ $r->keterangan ?? '-' }}</td>
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

{{-- MODAL --}}
<div class="modal fade" id="modalRumah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('penghuni.index') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <input type="text" name="blok" class="form-control mb-2" placeholder="Blok" required>
                    <input type="text" name="no_rumah" id="no_rumah" class="form-control mb-2" placeholder="No Rumah" required>

                    <input type="text" name="type_rumah" class="form-control mb-2" placeholder="Type Rumah (ex: 36/72)">

                    <select name="status" class="form-control mb-2">
                        <option value="Kosong">Kosong</option>
                        <option value="Terisi">Terisi</option>
                    </select>

                    <select name="status_kepemilikan" class="form-control mb-2">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Booking">Booking</option>
                        <option value="Terjual">Terjual</option>
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
    $('#tableRumah').DataTable();
});
</script>
@endpush

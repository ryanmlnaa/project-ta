@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Kelola Layanan Pengaduan</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengaduan</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Penghuni</th>
                                <th>Tanggal Pengaduan</th>
                                <th>Kategori Masalah</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Tanggapan Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($layanan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $item->penghuni->nama ?? '-' }}</td>

                                    <td>{{ $item->tanggal_pengaduan }}</td>

                                    <td>{{ ucfirst($item->kategori_masalah) }}</td>

                                    <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 40) }}</td>

                                    <td>
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" width="80">
                                        @else
                                            -
                                        @endif
                                    </td>

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
                                        {{ $item->tanggapan_admin ?? 'Belum ada tanggapan' }}
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modalTanggapi" data-id="{{ $item->id }}">
                                            Tanggapi
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('layanan.delete', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>



                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Belum ada data pengaduan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 🔥 MODAL HANYA 1 -->
            <div class="modal fade" id="modalTanggapi">
                <div class="modal-dialog">
                    <form id="formTanggapi" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tanggapi Pengaduan</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <textarea name="tanggapan_admin" class="form-control mb-2" required></textarea>

                                <select name="status" class="form-control" required>
                                    <option value="diproses">Diproses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#modalTanggapi').on('show.bs.modal', function (event) {

            let button = $(event.relatedTarget);
            let id = button.data('id');

            let action = "/layanan/" + id + "/tanggapi";

            $('#formTanggapi').attr('action', action);

        });

        $.fn.modal.Constructor.prototype._enforceFocus = function () { };

    </script>
@endpush

<style>
    .modal {
        z-index: 1055 !important;
    }

    .modal-backdrop {
        z-index: 1050 !important;
    }

    body.modal-open {
        padding-right: 0 !important;
    }

    .modal {
        position: fixed !important;
    }
</style>
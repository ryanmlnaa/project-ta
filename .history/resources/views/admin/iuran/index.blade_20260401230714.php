@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Kelola Data Iuran</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Iuran</h6>
            <a href="{{ route('iuran.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Iuran
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Penghuni</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Jenis Iuran</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($iuran as $i)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ $i->bulan }}</td>
                            <td>{{ $i->tahun }}</td>
                            <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $item->jenis_iuran }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                @if ($i->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>{{ $i->tanggal_bayar ?? '-' }}</td>
                            <td>
                                <a href="{{ route('iuran.edit', $i->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('iuran.destroy', $i->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data iuran</td>
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
        $('#dataTable').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "language": {
                "search": "Cari:",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Berikutnya"
                },
                "emptyTable": "Tidak ada data tersedia"
            }
        });
    });
</script>
@endpush

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
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($iuran as $i)
                       <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $i->penghuni->nama ?? '-' }}</td>
    <td>{{ $i->bulan }}</td>
    <td>{{ $i->tahun }}</td>
    <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
    <td>{{ $i->jenis_iuran }}</td>
    <td>{{ $i->keterangan ?? '-' }}</td>

    {{-- STATUS --}}
    <td>
        @if ($i->status == 'lunas')
            <span class="badge bg-success">Lunas</span>
        @elseif($i->bukti_pembayaran)
            <span class="badge bg-warning">Menunggu</span>
        @else
            <span class="badge bg-danger">Belum Bayar</span>
        @endif
    </td>

    {{-- TANGGAL --}}
    <td>
        {{ $i->tanggal_bayar
            ? \Carbon\Carbon::parse($i->tanggal_bayar)->translatedFormat('d M Y')
            : '-'
        }}
    </td>

    {{-- BUKTI --}}
    <td>
        @if($i->bukti_pembayaran)
            <img src="{{ asset('bukti/' . $i->bukti_pembayaran) }}" width="80">
        @else
            -
        @endif
    </td>

    {{-- AKSI --}}
    <td>

        {{-- 🔥 APPROVE --}}
        @if($i->bukti_pembayaran && $i->status == 'belum')
        <form action="{{ route('iuran.approve', $i->id) }}" method="POST" style="display:inline;">
            @csrf
            <button class="btn btn-success btn-sm"
                onclick="return confirm('Approve pembayaran ini?')">
                Approve
            </button>
        </form>
        @endif

        {{-- EDIT --}}
        <a href="{{ route('iuran.edit', $i->id) }}" class="btn btn-sm btn-warning">
            Edit
        </a>

        {{-- DELETE --}}
        <form action="{{ route('iuran.destroy', $i->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm"
                onclick="return confirm('Yakin hapus?')">
                Hapus
            </button>
        </form>

    </td>
</tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data iuran</td>
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

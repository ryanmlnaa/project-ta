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
                        <tbody id="tbody-iuran">
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
                                                            <img src="{{ asset('bukti/' . $i->bukti_pembayaran) }}" width="70">
                                                        @endif
                                                    </td>

                                                    {{-- AKSI --}}
                                                    <td>

                                                        @if(auth()->user()->role == 'rt' && $i->status == 'belum' && $i->bukti_pembayaran)
                                                            <form action="{{ route('iuran.approve.rt', $i->id) }}" method="POST">
                                                                @csrf
                                                                <button class="btn btn-warning btn-sm">Approve RT</button>
                                                            </form>
                                                        @endif

                                                        {{-- 🔥 APPROVE --}}
                                                        @if($i->bukti_pembayaran && $i->status == 'belum')
                                                            <form action="{{ route('iuran.approve', $i->id) }}" method="POST"
                                                                style="display:inline;">
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
                                                        <form action="{{ route('iuran.destroy', $i->id) }}" method="POST"
                                                            style="display:inline;">
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
                                    <td colspan="10" class="text-center text-muted">Belum ada data iuran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if(session('wa_url'))
        <script>
            window.open("{{ session('wa_url') }}", "_blank");
        </script>
    @endif
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

{{--
<script>
    function loadData() {
        fetch("{{ route('iuran.realtime') }}")
            .then(res => res.json())
            .then(data => {

                let html = '';

                data.forEach((i, index) => {

                    html += `
            <tr>
                <td>${index + 1}</td>
                <td>${i.penghuni.nama}</td>
                <td>${i.bulan}</td>
                <td>${i.tahun}</td>
                <td>Rp ${parseInt(i.jumlah).toLocaleString()}</td>
                <td>${i.metode ?? '-'}</td>
                <td>${i.keterangan ?? '-'}</td>

                <td>
                    ${i.status == 'lunas'
                            ? '<span class="badge bg-success">Lunas</span>'
                            : '<span class="badge bg-danger">Belum</span>'
                        }
                </td>

                <td>${i.tanggal_bayar ?? '-'}</td>

            </tr>
            `;
                });

                document.getElementById('tbody-iuran').innerHTML = html;
            });
    }

    // 🔥 AUTO REFRESH 3 DETIK
    setInterval(loadData, 3000);

    // pertama load
    loadData();
</script> --}}

<script>
    function loadData() {
        fetch("{{ route('iuran.realtime') }}")
            .then(res => res.json())
            .then(data => {

                let html = '';

                data.forEach((i, index) => {

                    let urlEdit = "{{ route('iuran.edit', ':id') }}".replace(':id', i.id);
                    let urlDelete = "{{ route('iuran.destroy', ':id') }}".replace(':id', i.id);
                    let urlApprove = "{{ route('iuran.approve', ':id') }}".replace(':id', i.id);

                    let statusBadge = i.status == 'lunas'
                        ? '<span class="badge bg-success">Lunas</span>'
                        : '<span class="badge bg-danger">Belum</span>';

                    let bukti = i.bukti_pembayaran
                        ? `<img src="/bukti/${i.bukti_pembayaran}" width="70">`
                        : '-';

                    let tombolApprove = '';
                    if (i.bukti_pembayaran && i.status == 'belum') {
                        tombolApprove = `
                    <form action="${urlApprove}" method="POST" style="display:inline;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>
                `;
                    }

                    html += `
            <tr>
                <td>${index + 1}</td>
                <td>${i.penghuni.nama}</td>
                <td>${i.bulan}</td>
                <td>${i.tahun}</td>
                <td>Rp ${parseInt(i.jumlah).toLocaleString()}</td>
                <td>${i.jenis_iuran ?? '-'}</td>
                <td>${i.keterangan ?? '-'}</td>
                <td>${statusBadge}</td>
                <td>${i.tanggal_bayar ?? '-'}</td>
                <td>${bukti}</td>

                <td>
                    <a href="${urlEdit}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="${urlDelete}" method="POST" style="display:inline;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                    ${tombolApprove}
                </td>
            </tr>
            `;
                });

                document.getElementById('tbody-iuran').innerHTML = html;
            });
    }

    setInterval(loadData, 3000);
    loadData();
</script>
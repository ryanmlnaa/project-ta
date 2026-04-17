@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">👥 Data Penghuni (RT)</h3>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>No KTP</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Blok</th>
                        <th>No Rumah</th>
                        <th>Status</th>
                        <th>Status Huni</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($penghuni as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->no_ktp }}</td>

                        {{-- 🔥 EMAIL DIHILANGKAN --}}

                        <td>{{ $p->telepon }}</td>
                        <td>{{ $p->alamat }}</td>

                        <td>{{ $p->rumah->blok ?? '-' }}</td>
                        <td>{{ $p->rumah->no_rumah ?? '-' }}</td>

                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>

                        <td>{{ $p->status_huni }}</td>
                        <td>{{ $p->tangga_masuk }}</td>
                        <td>{{ $p->tanggal_keluar ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Kelola Informasi</h3>

    <a href="{{ route('informasi.create') }}" class="btn btn-primary mb-3">
        + Tambah Informasi
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Contoh Informasi</td>
                <td>2026-01-01</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

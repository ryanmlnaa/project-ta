@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Kelola Informasi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('informasi.create') }}" class="btn btn-primary mb-3">
        + Tambah Informasi
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penting</th>
                <th>Views</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($informasi as $i)
            <tr>
                <td>{{ $i->judul }}</td>
                <td>{{ $i->kategori }}</td>

                <td>
                    @if($i->is_penting)
                        <span class="badge bg-danger">Penting</span>
                    @else
                        -
                    @endif
                </td>

                <td>{{ $i->views }}</td>

                <td>{{ $i->tanggal }}</td>

                <td>
                    <a href="{{ route('informasi.edit', $i->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('informasi.destroy', $i->id) }}" method="POST" style="display:inline;">
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
                <td colspan="6" class="text-center">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection

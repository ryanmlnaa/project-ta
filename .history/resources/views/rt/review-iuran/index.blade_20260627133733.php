@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Review Iuran dari Bendahara</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Penghuni</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Diajukan oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($iurans as $i)
            <tr>
                <td>{{ $i->penghuni->nama ?? '-' }}</td>
                <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                <td>{{ $i->jenis_iuran }}</td>
                <td>{{ $i->bendahara->name ?? '-' }}</td>
                <td>
                    <form action="{{ route('rt.review-iuran.setujui', $i->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-success" onclick="return confirm('Setujui iuran ini?')">Setujui</button>
                    </form>

                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $i->id }}">
                        Tolak
                    </button>

                    {{-- Modal alasan tolak --}}
                    <div class="modal fade" id="tolakModal{{ $i->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('rt.review-iuran.tolak', $i->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-header">
                                        <h5>Alasan Penolakan</h5>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="catatan_rt" class="form-control" required placeholder="Tulis alasan..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada iuran yang menunggu review.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

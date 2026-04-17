@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Status Pembayaran Iuran</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($iuran as $i)
                    <tr>
                        <td>{{ $i->bulan }} {{ $i->tahun }}</td>

                        <td>
                            Rp {{ number_format($i->jumlah, 0, ',', '.') }}
                        </td>

                        {{-- BUKTI --}}
                        <td>
                            @if($i->bukti_pembayaran)
                                <img src="{{ asset('bukti/'.$i->bukti_pembayaran) }}"
                                     width="80"
                                     class="img-thumbnail">
                            @else
                                <span class="text-muted">Belum upload</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($i->status == 'lunas')
                                <span class="badge bg-success">✔ Lunas</span>

                            @elseif($i->bukti_pembayaran)
                                <span class="badge bg-warning text-dark">⏳ Menunggu Konfirmasi</span>

                            @else
                                <span class="badge bg-danger">✖ Belum Bayar</span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Tidak ada data iuran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')

<style>
.stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.step {
    text-align: center;
    flex: 1;
    position: relative;
}

.step::after {
    content: '';
    position: absolute;
    top: 18px;
    left: 50%;
    width: 100%;
    height: 4px;
    background: #ddd;
    z-index: -1;
}

.step:last-child::after {
    display: none;
}

.circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #ddd;
    color: white;
    line-height: 35px;
    margin: auto;
    font-weight: bold;
}

.done {
    background: #28a745;
}

.active {
    background: orange;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid orange;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    margin: auto;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}
</style>

<div class="container">

    <h3 class="mb-4">Beranda Penghuni</h3>

    @if($penghuni)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Data Anda</h5>
                <p><b>Nama:</b> {{ $penghuni->nama }}</p>
                <p><b>Email:</b> {{ $penghuni->email }}</p>

                <p><b>Status Huni:</b>
                    @if($penghuni->status_huni == 'Tetap')
                        <span class="badge bg-success">Tetap</span>
                    @else
                        <span class="badge bg-warning text-dark">Kontrak</span>
                    @endif
                </p>

                @if($penghuni->status_huni == 'Kontrak')
                    <p><b>Tanggal Keluar:</b> {{ $penghuni->tanggal_keluar }}</p>
                @endif
            </div>
        </div>

        @if($penghuni->rumah)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Rumah Anda</h5>
                <p>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</p>
                <p>Status: {{ $penghuni->rumah->status }}</p>
            </div>
        </div>
        @endif

        {{-- 🔥 PROGRESS IURAN --}}
      @if($iuran->count())
    <div class="card mt-3">
        <div class="card-body">

            <h5>Riwayat Iuran</h5>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tanggal Bayar</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($iuran as $i)
                    <tr>
                        {{-- BULAN --}}
                        <td>{{ $i->bulan }} {{ $i->tahun }}</td>

                        {{-- TANGGAL --}}
                        <td>
                            {{ $i->tanggal_bayar
                                ? \Carbon\Carbon::parse($i->tanggal_bayar)->translatedFormat('d M Y')
                                : '-' }}
                        </td>

                        {{-- PROGRESS --}}
                        <td>
                            <div style="display:flex; gap:10px; align-items:center;">

                                {{-- STEP 1 --}}
                                @if($i->bukti_pembayaran)
                                    <span class="badge bg-success">✔ Upload</span>
                                @else
                                    <span class="badge bg-secondary">Upload</span>
                                @endif

                                {{-- STEP 2 --}}
                                @if($i->status == 'lunas')
                                    <span class="badge bg-success">✔ Verifikasi</span>
                                @elseif($i->bukti_pembayaran)
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @else
                                    <span class="badge bg-secondary">Verifikasi</span>
                                @endif

                                {{-- STEP 3 --}}
                                @if($i->status == 'lunas')
                                    <span class="badge bg-success">✔ Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Selesai</span>
                                @endif

                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($i->status == 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($i->bukti_pembayaran)
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-danger">Belum Bayar</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>
                            {{-- BAYAR --}}
                            @if($i->status != 'lunas')
                                <a href="{{ route('user.iuran.upload', $i->id) }}"
                                class="btn btn-primary btn-sm mb-1">
                                    Bayar
                                </a>
                            @endif

                            {{-- HAPUS --}}
                            <form action="{{ route('user.iuran.delete', $i->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
    @endif

    @else
        <div class="alert alert-warning">
            Data penghuni belum tersedia
        </div>
    @endif

</div>
@endsection

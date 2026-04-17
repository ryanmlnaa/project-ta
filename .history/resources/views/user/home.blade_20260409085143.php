@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Beranda Penghuni</h3>

    {{-- DATA PENGHUNI --}}
    @if(isset($penghuni))
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

        {{-- RUMAH --}}
        @if($penghuni->rumah)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Rumah Anda</h5>
                <p>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</p>
                <p>Status: {{ $penghuni->rumah->status }}</p>
            </div>
        </div>
        @endif
    @endif


    {{-- ========================= --}}
    {{-- 🔥 DATA IURAN FINAL --}}
    {{-- ========================= --}}
    <h4 class="mt-4">Data Iuran Saya</h4>

    @if(isset($iuran) && count($iuran) > 0)

        @foreach($iuran as $i)
        <div class="card mb-3">
            <div class="card-body">

                {{-- JUDUL --}}
                <h5>Iuran {{ $i->bulan }} {{ $i->tahun }}</h5>

                {{-- JUMLAH --}}
                <p><b>Jumlah:</b> Rp {{ number_format($i->jumlah,0,',','.') }}</p>

                {{-- TANGGAL --}}
                <p><b>Tanggal Bayar:</b>
                    {{ $i->tanggal_bayar
                        ? \Carbon\Carbon::parse($i->tanggal_bayar)->translatedFormat('d M Y')
                        : '-' }}
                </p>

                {{-- PROGRESS --}}
                <div class="d-flex justify-content-between mt-3">

                    {{-- STEP 1 --}}
                    <div class="text-center">
                        @if($i->bukti_pembayaran)
                            <div class="circle done">✔</div>
                        @else
                            <div class="circle active"></div>
                        @endif
                        <small>Upload</small>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="text-center">
                        @if($i->status == 'lunas')
                            <div class="circle done">✔</div>
                        @elseif($i->bukti_pembayaran)
                            <div class="circle active"></div>
                        @else
                            <div class="circle">2</div>
                        @endif
                        <small>Verifikasi</small>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="text-center">
                        @if($i->status == 'lunas')
                            <div class="circle done">✔</div>
                        @else
                            <div class="circle">3</div>
                        @endif
                        <small>Selesai</small>
                    </div>

                </div>

                {{-- STATUS --}}
                <div class="mt-3">
                    <b>Status:</b>

                    @if($i->status == 'lunas')
                        <span class="badge bg-success">Lunas</span>

                    @elseif(!empty($i->bukti_pembayaran))
                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>

                    @else
                        <span class="badge bg-danger">Belum Bayar</span>

                    @endif
                </div>

            </div>
        </div>
        @endforeach

    @else
        <div class="alert alert-warning">
            Belum ada data iuran
        </div>
    @endif

</div>
@endsection


{{-- 🔥 STYLE --}}
@section('scripts')
<style>
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
</style>
@endsection

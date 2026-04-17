@extends('layouts.app')

@section('content')
<div class="container">

    {{-- 🔥 DATA ANDA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">👤 Data Anda</h5>

            <p><b>Nama:</b> {{ auth()->user()->name }}</p>
            <p><b>Email:</b> {{ auth()->user()->email }}</p>

            <p>
                <b>Status Huni:</b>
                @if($penghuni && $penghuni->rumah)
                    <span class="badge bg-success">Tetap</span>
                @else
                    <span class="badge bg-warning text-dark">Belum Punya Rumah</span>
                @endif
            </p>

        </div>
    </div>


    {{-- 🔥 RUMAH SAYA --}}
    <h3 class="mb-3">🏠 Rumah Saya</h3>

    @if($penghuni && $penghuni->rumah)

        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <p><b>Blok:</b> {{ $penghuni->rumah->blok }}</p>
                <p><b>No Rumah:</b> {{ $penghuni->rumah->no_rumah }}</p>
                <p><b>Status:</b> {{ $penghuni->rumah->status }}</p>
            </div>
        </div>

    @else

        <div class="alert alert-warning">
            Anda belum memiliki rumah, silakan pilih kavling
        </div>

        {{-- PILIH KAVLING --}}
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Pilih Kavling</div>

            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">

                    @foreach($rumahList as $r)
                    <button
                        type="button"
                        class="btn m-1 kavling-btn
                        {{ $r->status == 'Kosong' ? 'btn-success' : 'btn-danger' }}"

                        data-id="{{ $r->id }}"
                        data-blok="{{ $r->blok }}"
                        data-nomor="{{ $r->no_rumah }}"
                        data-luas="{{ $r->luas_tanah }}"
                        data-harga="{{ $r->harga }}"
                        data-foto="{{ asset('foto_rumah/'.$r->foto) }}"
                        data-status="{{ $r->status }}"
                    >
                        {{ $r->no_rumah }}
                    </button>
                    @endforeach

                </div>

                <div class="mt-3">
                    <span class="badge bg-success">Kosong</span>
                    <span class="badge bg-danger">Terisi</span>
                </div>

            </div>
        </div>

    @endif

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold text-warning">
        🏡 Dashboard RT
    </h3>

    <div class="row">

        {{-- TOTAL PENGHUNI --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 text-center p-3">
                <h5>👨‍👩‍👧‍👦 Penghuni</h5>
                <h3 class="fw-bold">{{ $totalPenghuni }}</h3>
            </div>
        </div>

        {{-- TOTAL IURAN --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 text-center p-3">
                <h5>💰 Iuran</h5>
                <h3 class="fw-bold">{{ $totalIuran }}</h3>
            </div>
        </div>

        {{-- PENGADUAN --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 text-center p-3">
                <h5>📢 Pengaduan</h5>
                <h3 class="fw-bold">{{ $totalPengaduan }}</h3>
            </div>
        </div>

        {{-- MENUNGGU RT --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 text-center p-3 bg-warning text-white">
                <h5>⏳ Menunggu RT</h5>
                <h3 class="fw-bold">{{ $menungguRT }}</h3>
            </div>
        </div>

        {{-- MENUNGGU ADMIN --}}
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 text-center p-3 bg-info text-white">
                <h5>📤 Ke Admin</h5>
                <h3 class="fw-bold">{{ $menungguAdmin }}</h3>
            </div>
        </div>

    </div>

</div>
@endsection

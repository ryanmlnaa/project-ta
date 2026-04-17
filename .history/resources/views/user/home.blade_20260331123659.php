@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Beranda Penghuni</h3>

    @if($penghuni)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Data Anda</h5>
                <p><b>Nama:</b> {{ $penghuni->nama }}</p>
                <p><b>Email:</b> {{ $penghuni->email }}</p>
            </div>
        </div>

        @if($penghuni->rumah)
        <div class="card">
            <div class="card-body">
                <h5>Rumah Anda</h5>
                <p>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</p>
                <p>Status: {{ $penghuni->rumah->status }}</p>
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

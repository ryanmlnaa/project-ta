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

    @if(!$penghuni)
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Lengkapi Data Penghuni
    </div>

    <div class="card-body">
        <form action="{{ route('user.simpan.penghuni') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No KTP</label>
                <input type="text" name="no_ktp" class="form-control" required>
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="telepon" class="form-control">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control">
            </div>

            <button class="btn btn-primary mt-2">Simpan Data</button>
        </form>
    </div>
</div>
@endif

</div>
@endsection

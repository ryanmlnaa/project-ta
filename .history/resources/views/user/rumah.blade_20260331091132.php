@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Rumah Saya</h3>

    @if($penghuni && $penghuni->rumah)
        <div class="card">
            <div class="card-body">
                <p>Blok {{ $penghuni->rumah->blok }}</p>
                <p>No Rumah {{ $penghuni->rumah->no_rumah }}</p>
                <p>Status {{ $penghuni->rumah->status }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Anda belum memiliki rumah
        </div>
    @endif
</div>
@endsection

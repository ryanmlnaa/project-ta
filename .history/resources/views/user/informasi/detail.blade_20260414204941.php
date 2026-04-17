@extends('layouts.app')

@section('content')
<div class="container">

    <h3>{{ $info->judul }}</h3>

    <p class="text-muted">
        📅 {{ $info->tanggal }} | 👁️ {{ $info->views }}x
    </p>

    @if($info->gambar)
        <img src="{{ asset('informasi/'.$info->gambar) }}" class="img-fluid mb-3">
    @endif

    <p>{{ $info->isi }}</p>

    <a href="{{ route('user.home') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Rumah Saya</h3>

    {{-- DATA RUMAH USER --}}
    @if($penghuni && $penghuni->rumah)
        <div class="card mb-4">
            <div class="card-body">
                <p><b>Blok:</b> {{ $penghuni->rumah->blok }}</p>
                <p><b>No Rumah:</b> {{ $penghuni->rumah->no_rumah }}</p>
                <p><b>Status:</b> {{ $penghuni->rumah->status }}</p>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            Anda belum memiliki rumah
        </div>
    @endif

    {{-- 🔥 TAMBAHAN: PILIH RUMAH --}}
    <div class="card">
        <div class="card-header bg-success text-white">
            Pilih Rumah Tersedia
        </div>

        <div class="card-body">
            <div class="row">

                @foreach($rumahKosong as $r)
                    <div class="col-md-2 col-4 mb-2">

                        <a href="{{ route('user.pilih.rumah', $r->id) }}"
                           class="btn btn-success w-100">
                            {{ $r->no_rumah }}
                        </a>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Rumah Saya</h3>

    {{-- DATA RUMAH --}}
    @if($penghuni && $penghuni->rumah)
        <div class="alert alert-success">
            Rumah Anda:
            <b>Blok {{ $penghuni->rumah->blok }} - No {{ $penghuni->rumah->no_rumah }}</b>
        </div>
    @else
        <div class="alert alert-warning">
            Anda belum memiliki rumah, silakan pilih kavling
        </div>
    @endif

    {{-- KAVLING --}}
    <div class="card shadow">
        <div class="card-header">
            Pilih Kavling
        </div>

        <div class="card-body">

            <div class="kavling-grid">
            @for($i = 1; $i <= 30; $i++)

                @php
                    $dataRumah = $rumah->firstWhere('no_rumah', $i);
                @endphp

                @if($dataRumah)
                    @if($dataRumah->status == 'Kosong')
                        <div class="kavling kosong"
                            onclick="pilihRumah({{ $dataRumah->id }}, '{{ $dataRumah->blok }}', '{{ $dataRumah->no_rumah }}')">
                            {{ $i }}
                        </div>
                    @else
                        <div class="kavling terisi">
                            {{ $i }}
                        </div>
                    @endif
                @else
                    <div class="kavling kosong"
                        onclick="pilihRumah(null, '', '{{ $i }}')">
                        {{ $i }}
                    </div>
                @endif

            @endfor
            </div>

            {{-- KETERANGAN --}}
            <div class="mt-3">
                <span class="badge badge-success">Kosong</span>
                <span class="badge badge-danger">Terisi</span>
            </div>

        </div>
    </div>
</div>
@endsection

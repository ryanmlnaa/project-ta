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

<div class="modal fade" id="modalRumah">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('user.simpan.rumah') }}" method="POST">
                @csrf

                <input type="hidden" name="rumah_id" id="rumah_id">

                <div class="modal-header">
                    <h5 class="modal-title">Ambil Rumah</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Blok</label>
                        <input type="text" name="blok" id="blok" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>No Rumah</label>
                        <input type="text" name="no_rumah" id="no_rumah" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Luas Tanah</label>
                        <input type="number" name="luas_tanah" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function pilihRumah(id, blok, noRumah) {

    document.getElementById('rumah_id').value = id ?? '';
    document.getElementById('blok').value = blok ?? '';
    document.getElementById('no_rumah').value = noRumah ?? '';

    $('#modalRumah').modal('show');
}
</script>

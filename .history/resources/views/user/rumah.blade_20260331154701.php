@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Rumah Saya</h3>

    {{-- DATA RUMAH --}}

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
    <div class="card">
    <div class="card-header">Pilih Kavling</div>

    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">

            @foreach($rumahList as $r)
                <button
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

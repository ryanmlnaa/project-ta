@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Rumah Saya</h3>

    {{-- CEK SUDAH PUNYA RUMAH --}}
    @if($penghuni && $penghuni->rumah)

        <div class="card mb-3">
            <div class="card-body">
                <p><b>Blok:</b> {{ $penghuni->rumah->blok }}</p>
                <p><b>No Rumah:</b> {{ $penghuni->rumah->no_rumah }}</p>
                <p><b>Status:</b> {{ $penghuni->rumah->status }}</p>
            </div>
        </div>

    @else

        {{-- BELUM PUNYA RUMAH --}}
        <div class="alert alert-warning">
            Anda belum memiliki rumah, silakan pilih kavling
        </div>

        {{-- 🔥 BAGIAN INI TEMPAT KODE KAMU --}}
        <div class="card">
            <div class="card-header">Pilih Kavling</div>

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

<div class="modal fade" id="modalAmbil" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('user.ambil.rumah') }}">
                @csrf
                <input type="hidden" name="rumah_id" id="rumah_id">

                <div class="modal-header">
                    <h5>Detail Rumah</h5>
                </div>

                <div class="modal-body text-center">

                    <img id="fotoRumah" class="img-fluid mb-3 rounded" style="max-height:200px;">

                    <p><b>Blok:</b> <span id="blok"></span></p>
                    <p><b>No Rumah:</b> <span id="nomor"></span></p>
                    <p><b>Luas:</b> <span id="luas"></span> m²</p>
                    <p><b>Harga:</b> Rp <span id="harga"></span></p>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Ambil Rumah</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.querySelectorAll('.kavling-btn').forEach(btn => {

    btn.addEventListener('click', function() {

        // ❌ kalau terisi
        if (this.dataset.status === 'Terisi') {
            alert('Rumah sudah terisi!');
            return;
        }

        // isi data ke modal
        document.getElementById('rumah_id').value = this.dataset.id;
        document.getElementById('blok').innerText = this.dataset.blok;
        document.getElementById('nomor').innerText = this.dataset.nomor;
        document.getElementById('luas').innerText = this.dataset.luas;
        document.getElementById('harga').innerText = this.dataset.harga;

        document.getElementById('fotoRumah').src = this.dataset.foto;

        // tampilkan modal
        $('#modalAmbil').modal('show');
    });

});
</script>

<script>
function pilihRumah(id, blok, noRumah) {

    document.getElementById('rumah_id').value = id ?? '';
    document.getElementById('blok').value = blok ?? '';
    document.getElementById('no_rumah').value = noRumah ?? '';

    $('#modalRumah').modal('show');
}
</script>

@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Beranda Penghuni</h3>

    {{-- 🔥 ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($penghuni)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Data Anda</h5>
                <p><b>Nama:</b> {{ $penghuni->nama }}</p>
                <p><b>Email:</b> {{ $penghuni->email }}</p>

                <p><b>Status Huni:</b>
                    @if($penghuni->status_huni == 'Tetap')
                        <span class="badge bg-success">Tetap</span>
                    @else
                        <span class="badge bg-warning text-dark">Kontrak</span>
                    @endif
                </p>

                @if($penghuni->status_huni == 'Kontrak')
                    <p><b>Tanggal Keluar:</b> {{ $penghuni->tanggal_keluar }}</p>
                @endif

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

                <div class="form-group">
                    <label>Status Huni</label>
                    <select name="status_huni" class="form-control" required id="statusHuni">
                        <option value="">-- Pilih Status --</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                    </select>
                </div>

                {{-- 🔥 FIX: pakai d-none biar tetap terkirim --}}
                <div class="form-group d-none" id="tanggalKeluarField">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggalKeluarInput" class="form-control">
                </div>

                <button class="btn btn-primary mt-2">Simpan Data</button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const statusHuni = document.getElementById('statusHuni');
    const tanggalKeluarField = document.getElementById('tanggalKeluarField');
    const tanggalKeluarInput = document.getElementById('tanggalKeluarInput');

    if (statusHuni) {

        statusHuni.addEventListener('change', function () {

            if (this.value === 'Kontrak') {
                tanggalKeluarField.classList.remove('d-none');
                tanggalKeluarInput.required = true;
            } else {
                tanggalKeluarField.classList.add('d-none');
                tanggalKeluarInput.required = false;
                tanggalKeluarInput.value = '';
            }

        });

    }
});
</script>
@endsection

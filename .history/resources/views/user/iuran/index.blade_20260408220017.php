@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Pembayaran Iuran</h3>

    <div class="card">
        <div class="card-body">

            {{-- INFO --}}
            <p><b>Bulan:</b> {{ $->bulan }}</p>
            <p><b>Jumlah:</b> Rp {{ number_format($iuran->jumlah,0,',','.') }}</p>

            <hr>

            {{-- 🔥 QRIS --}}
            <div class="text-center mb-3">
                <h5>Scan QRIS</h5>

                <img src="{{ asset('qris/qris.jpeg') }}" width="250">

                <p class="text-muted mt-2">Scan menggunakan e-wallet / m-banking</p>
            </div>

            <hr>

            {{-- 🔥 UPLOAD BUKTI --}}
            <form action="{{ route('user.iuran.storeUpload', $iuran->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-group">
                    <label>Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_pembayaran" class="form-control" required>
                </div>

                <button class="btn btn-success mt-2">
                    Upload & Kirim
                </button>

            </form>

        </div>
    </div>

</div>
@endsection

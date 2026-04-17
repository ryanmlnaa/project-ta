@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Upload Bukti Pembayaran</h3>

    <div class="card p-4">

        <p><b>Bulan:</b> {{ $iuran->bulan }}</p>
        <p><b>Tahun:</b> {{ $iuran->tahun }}</p>
        <p><b>Jumlah:</b> Rp {{ number_format($iuran->jumlah,0,',','.') }}</p>

        <form action="{{ route('user.iuran.storeUpload', $iuran->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="file" name="bukti_pembayaran" class="form-control mb-3" required>

            <button type="submit" class="btn btn-success">Upload</button>
        </form>

    </div>

</div>
@endsection

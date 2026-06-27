@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px;">
    <h4 class="mb-4">Upload Bukti Bayar Kas</h4>
    <p>{{ $kas->keterangan }} — Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</p>

    <form action="{{ route('user.kas.storeUpload', $kas->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Upload</button>
    </form>
</div>
@endsection

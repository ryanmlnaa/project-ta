@extends('layouts.app')
@section('content')
<h3>Upload Pembayaran</h3>

<form action="{{ route('user.iuran.storeUpload', $iuran->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Bukti Pembayaran</label>
        <input type="file" name="bukti_bayar" class="form-control" required>
    </div>

    <button class="btn btn-success">Upload</button>
</form>
@endsection

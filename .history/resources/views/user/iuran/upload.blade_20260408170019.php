@extends('layouts.app')
@section('content')
<h3>Upload Pembayaran</h3>

<form action="{{ route('user.iuran.storeUpload', $iuran->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="bukti_pembayaran" class="form-control" required>

    <button type="submit" class="btn btn-success mt-2">Upload</button>
</form>
@endsection

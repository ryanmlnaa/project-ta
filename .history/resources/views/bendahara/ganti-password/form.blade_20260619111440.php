@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 480px; margin-top: 60px;">
    <div class="card">
        <div class="card-header bg-warning">
            <strong>⚠️ Wajib Ganti Password</strong>
        </div>
        <div class="card-body">
            <p class="text-muted">Ini login pertama kamu. Demi keamanan, silakan buat password baru sebelum melanjutkan.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bendahara.ganti-password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan & Lanjutkan</button>
            </form>
        </div>
    </div>
</div>
@endsection

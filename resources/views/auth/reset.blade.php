@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="password" name="password" placeholder="Password Baru" class="form-control mb-2">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="form-control">

        <button class="btn btn-primary mt-2">Reset Password</button>

    </form>
@endsection
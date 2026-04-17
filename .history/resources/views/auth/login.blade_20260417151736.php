@extends('layouts.auth')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <div class="card shadow">
            <div class="card-header text-center">
                <h4>Login Sistem</h4>
            </div>

            <div class="card-body">

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.proses') }}">
                    @csrf

                    <div class="form-group">
                        <label>Username / Email</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary btn-block">
                        Login
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('register') }}">Belum punya akun? Register</a>
                </div>

                <div class="text-center mt-2">
    <a href="{{ route('password.forgot') }}">Lupa Password?</a>
</div>

            </div>
        </div>

    </div>
</div>
@endsection

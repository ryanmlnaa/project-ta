@extends('layouts.auth')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <div class="card shadow">
            <div class="card-header text-center">
                <h4>Register Penghuni</h4>
            </div>

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

              <form method="POST" action="{{ route('register.proses') }}">
                @csrf

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-success btn-block">Register</button>
            </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

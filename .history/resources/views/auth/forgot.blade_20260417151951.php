@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header text-center">
                <h4>Lupa Password</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.sendOtp') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Masukkan Email" class="form-control" required>
                    </div>
                    <button class="btn btn-primary btn-block">
                        Kirim OTP
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

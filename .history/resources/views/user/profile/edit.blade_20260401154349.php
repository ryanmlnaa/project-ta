@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        {{-- PROFILE KIRI --}}
        <div class="col-md-4">
            <div class="card text-center p-3 shadow-sm">

                <img src="https://i.pravatar.cc/150?img=3"
                     class="rounded-circle mx-auto mb-3"
                     width="120" height="120">

                <h5>{{ auth()->user()->name }}</h5>
                <p class="text-muted">{{ auth()->user()->email }}</p>

                <form method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control mb-2">
                    <button class="btn btn-primary btn-sm w-100">
                        Upload Image
                    </button>
                </form>

            </div>
        </div>

        {{-- FORM KANAN --}}
        <div class="col-md-8">
            <div class="card p-4 shadow-sm">

                <h5 class="mb-3">Account Details</h5>

                <form action="{{ route('user.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name"
                                   class="form-control"
                                   value="{{ auth()->user()->name }}">
                        </div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control"
                                value="{{ auth()->user()->username }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email"
                                   class="form-control"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        Save changes
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection


<style>
.card {
    border-radius: 10px;
}
</style>

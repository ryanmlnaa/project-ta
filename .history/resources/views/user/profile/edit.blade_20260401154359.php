@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">

        {{-- LEFT PROFILE --}}
        <div class="col-md-4">
            <div class="card profile-card text-center p-4">

                <div class="avatar-wrapper">
                    <img src="https://i.pravatar.cc/150?img=3" class="avatar">
                </div>

                <h5 class="mt-3 mb-0">{{ auth()->user()->name }}</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>

                <form class="mt-3">
                    <input type="file" class="form-control mb-2">
                    <button class="btn btn-primary w-100 btn-modern">
                        Upload Image
                    </button>
                </form>

            </div>
        </div>

        {{-- RIGHT FORM --}}
        <div class="col-md-7">
            <div class="card form-card p-4">

                <h5 class="mb-4 fw-bold">Account Settings</h5>

                <form action="{{ route('user.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name"
                                class="form-control modern-input"
                                value="{{ auth()->user()->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control modern-input"
                                value="{{ auth()->user()->username }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email"
                                class="form-control modern-input"
                                value="{{ auth()->user()->email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password"
                                class="form-control modern-input">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control modern-input">
                        </div>

                    </div>

                    <button class="btn btn-success btn-modern px-4">
                        Save Changes
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

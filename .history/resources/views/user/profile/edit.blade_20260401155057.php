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

                <form action="{{ route('user.upload.photo') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="photo" class="form-control mb-2" required>

    <button class="btn btn-primary w-100">
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

/* CARD */
.profile-card, .form-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* AVATAR */
.avatar-wrapper {
    display: flex;
    justify-content: center;
}

.avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 4px solid #f1f1f1;
    object-fit: cover;
}

/* INPUT */
.modern-input {
    border-radius: 8px;
    padding: 10px;
    transition: 0.3s;
}

.modern-input:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

/* BUTTON */
.btn-modern {
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0,0,0,0.2);
}
</style>

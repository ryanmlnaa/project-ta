@extends('layouts.app')

@section('content')

<style>
/* FULL HEIGHT */
.container-fluid {
    min-height: 100vh;
    padding: 25px;
}

/* GRID LAYOUT */
.create-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
}

/* CARD */
.card-box {
    background: #fff;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

/* TITLE */
.page-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* INPUT */
.form-control {
    border-radius: 10px;
    padding: 10px;
}

/* BUTTON */
.btn-main {
    background: linear-gradient(135deg,#22c55e,#16a34a);
    border: none;
    border-radius: 10px;
    padding: 12px;
    width: 100%;
    color: white;
    font-weight: 600;
}

.btn-back {
    margin-top: 10px;
    width: 100%;
    border-radius: 10px;
    padding: 10px;
    background: #e5e7eb;
}

/* INFO PANEL */
.info-box {
    background: linear-gradient(180deg, #2b8a1e, #18b640) !important;
    color: white;
    border-radius: 18px;
    padding: 30px;
    height: 100%;
}

.info-box h4 {
    font-weight: 700;
}

.info-box ul {
    padding-left: 20px;
}

/* RESPONSIVE */
@media(max-width: 768px){
    .create-layout {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container-fluid">

    <div class="create-layout">

        <!-- FORM -->
        <div class="card-box">

            <div class="page-title">➕ Tambah User RT</div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <input type="text" value="RT" class="form-control" readonly>
                    <input type="hidden" name="role" value="rt">
                </div>

                <button class="btn-main">💾 Simpan User</button>

                <a href="{{ route('admin.user.index') }}" class="btn-back text-center d-block">
                    ← Kembali
                </a>

            </form>

        </div>

        <!-- PANEL KANAN -->
        <div class="info-box">

            <h4>📌 Informasi</h4>
            <p>
                Form ini digunakan untuk menambahkan user RT ke dalam sistem.
            </p>

            <hr>

            <ul>
                <li>Pastikan email belum digunakan</li>
                <li>Password minimal 6 karakter</li>
                <li>Role otomatis sebagai RT</li>
            </ul>

            <hr>

            <p>
                Setelah disimpan, user dapat langsung login ke sistem.
            </p>

        </div>

    </div>

</div>

@endsection

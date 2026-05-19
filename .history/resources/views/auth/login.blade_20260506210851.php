@extends('layouts.auth')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    background: #0a3d1e;
}

/* ─── WRAPPER ─── */
.auth-wrapper {
    display: flex;
    min-height: 100vh;
}

/* ─── LEFT PANEL (Logo) ─── */
.auth-left {
    width: 55%;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #ffffff;
}

.auth-left::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 50% at 80% 110%, rgba(25,148,84,0.10) 0%, transparent 70%),
        radial-gradient(ellipse 50% 40% at -10% -10%, rgba(16,110,54,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.auth-left .brand-tagline {
    margin-top: 18px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #2d7a4f;
    opacity: 0.7;
}

.auth-left img {
    width: 68%;
    max-width: 340px;
    object-fit: contain;
    position: relative;
    filter: drop-shadow(0 12px 32px rgba(15,80,40,0.18));
    animation: floatLogo 5s ease-in-out infinite;
}

@keyframes floatLogo {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
}

.deco-circle {
    position: absolute;
    border-radius: 50%;
    border: 1.5px solid rgba(25,148,84,0.12);
    pointer-events: none;
}
.deco-circle.c1 { width: 420px; height: 420px; bottom: -120px; right: -120px; }
.deco-circle.c2 { width: 260px; height: 260px; bottom: -60px;  right: -60px; }
.deco-circle.c3 { width: 160px; height: 160px; top: 30px;      left: 30px; }

/* ─── RIGHT PANEL (Form) ─── */
.auth-right {
    width: 45%;
    background: linear-gradient(145deg, #1a6e3a 0%, #2e9e58 45%, #1a8040 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 40px;
    position: relative;
    overflow: hidden;
}

.auth-right::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
    opacity: 0.5;
    pointer-events: none;
}

.auth-right::after {
    content: '';
    position: absolute;
    width: 340px; height: 340px;
    background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
    bottom: -80px; right: -80px;
    border-radius: 50%;
    pointer-events: none;
}

.blob-top {
    position: absolute;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
    top: -60px; left: -60px;
    border-radius: 50%;
    pointer-events: none;
}

/* ─── CARD ─── */
.auth-card {
    width: 100%;
    max-width: 360px;
    position: relative;
    z-index: 1;
    animation: slideUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ─── HEADER ─── */
.card-header-area {
    text-align: center;
    margin-bottom: 32px;
}

.card-header-area .badge-pill {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 99px;
    margin-bottom: 14px;
}

.card-header-area h4 {
    color: #ffffff;
    font-size: 18px;
    font-weight: 800;
    line-height: 1.3;
    margin-bottom: 6px;
}

.card-header-area p {
    color: rgba(255,255,255,0.65);
    font-size: 12.5px;
    margin: 0;
}

/* ─── ALERTS ─── */
.alert {
    border-radius: 10px;
    font-size: 13px;
    padding: 10px 14px;
    margin-bottom: 16px;
    border: none;
}
.alert-danger  { background: rgba(220,53,69,0.85);  color: #fff; }
.alert-success { background: rgba(25,135,84,0.85);  color: #fff; }

/* ─── FORM GROUP ─── */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    color: rgba(255,255,255,0.85);
    font-size: 12.5px;
    font-weight: 600;
    margin-bottom: 7px;
    letter-spacing: 0.4px;
}

.input-wrap {
    position: relative;
}

.input-wrap .icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(0,0,0,0.3);
    font-size: 15px;
    pointer-events: none;
}

.form-control {
    width: 100%;
    padding: 11px 12px 11px 38px;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.94);
    color: #1a2e1a;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
}

.form-control::placeholder { color: #aab7aa; }

.form-control:focus {
    border-color: rgba(255,255,255,0.6);
    box-shadow: 0 0 0 3px rgba(255,255,255,0.18);
    background: #ffffff;
}

.toggle-eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
    font-size: 15px;
    background: none;
    border: none;
    padding: 0;
    line-height: 1;
}

/* ─── LOGIN BUTTON ─── */
.btn-login {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #ffffff;
    color: #1a6e3a;
    font-size: 14.5px;
    font-weight: 800;
    font-family: inherit;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.2s, background 0.2s;
    box-shadow: 0 4px 18px rgba(0,0,0,0.15);
    margin-top: 4px;
}

.btn-login:hover {
    background: #f0faf4;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}

.btn-login:active {
    transform: translateY(0);
}

/* ─── LINKS ─── */
.links-area {
    text-align: center;
    margin-top: 20px;
}

.links-area a {
    color: rgba(255,255,255,0.75);
    font-size: 12.5px;
    text-decoration: none;
    transition: color 0.15s;
}

.links-area a:hover { color: #fff; }

.links-area .divider {
    color: rgba(255,255,255,0.35);
    margin: 0 8px;
    font-size: 11px;
}

/* ─── RESPONSIVE: Tablet ─── */
@media (min-width: 769px) and (max-width: 1024px) {
    .auth-left  { width: 40%; }
    .auth-right { width: 60%; padding: 40px 28px; }
    .auth-left img { width: 80%; }
}

/* ─── RESPONSIVE: Mobile ─── */
@media (max-width: 768px) {
    body { overflow-y: auto; }

    .auth-wrapper {
        flex-direction: column;
        min-height: 100vh;
    }

    /* Panel kiri jadi banner logo di atas */
    .auth-left {
        width: 100%;
        height: auto;
        padding: 40px 24px 32px;
        flex-shrink: 0;
    }

    .auth-left img {
        width: 52%;
        max-width: 200px;
        animation: none; /* matikan animasi agar tidak aneh saat scroll */
    }

    .auth-left .brand-tagline {
        margin-top: 12px;
        font-size: 11px;
        letter-spacing: 2px;
    }

    /* Sembunyikan lingkaran dekoratif besar di mobile agar rapi */
    .deco-circle.c1,
    .deco-circle.c2 { display: none; }
    .deco-circle.c3 { width: 100px; height: 100px; top: 10px; left: 10px; }

    /* Panel kanan jadi form di bawah, mengisi sisa layar */
    .auth-right {
        width: 100%;
        flex: 1;
        padding: 36px 24px 48px;
        align-items: flex-start;
        justify-content: center;
    }

    .auth-card {
        max-width: 100%;
    }

    .card-header-area {
        margin-bottom: 24px;
    }

    .card-header-area h4 {
        font-size: 16px;
    }

    /* Link login ditumpuk vertikal agar mudah diklik */
    .links-area {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .links-area .divider { display: none; }

    /* Mencegah auto-zoom di iOS saat tap input */
    .form-control { font-size: 16px; }
}

/* ─── RESPONSIVE: Small Mobile ─── */
@media (max-width: 400px) {
    .auth-left { padding: 32px 16px 24px; }
    .auth-left img { width: 48%; }
    .auth-right { padding: 28px 16px 40px; }
}
</style>

<div class="auth-wrapper">

    {{-- LEFT: Logo Panel --}}
    <div class="auth-left">
        <div class="deco-circle c1"></div>
        <div class="deco-circle c2"></div>
        <div class="deco-circle c3"></div>
        <img src="{{ asset('tunggal.png') }}" alt="Green View Logo">
        <span class="brand-tagline">Real Estate &bull; Bondowoso</span>
    </div>

    {{-- RIGHT: Form Panel --}}
    <div class="auth-right">
        <div class="blob-top"></div>

        <div class="auth-card">

            <div class="card-header-area">
                <div class="badge-pill">🏡 Real Estate</div>
                <h4>PT Tunggal Griya Sakinah<br>(GREEN VIEW)</h4>
                <p>Kab. Bondowoso, Jawa Timur</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.proses') }}">
                @csrf

                <div class="form-group">
                    <label>Username / Email</label>
                    <div class="input-wrap">
                        <span class="icon">👤</span>
                        <input type="text" name="login" class="form-control" placeholder="Masukkan username atau email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <span class="icon">🔒</span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-eye" onclick="togglePassword()">👁</button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Login
                </button>
            </form>

            <div class="links-area">
                <a href="{{ route('register') }}">Belum punya akun? Register</a>
                <span class="divider">|</span>
                <a href="{{ route('password.forgot') }}">Lupa Password?</a>
            </div>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const p = document.getElementById("password");
    p.type = p.type === "password" ? "text" : "password";
}
</script>

@endsection

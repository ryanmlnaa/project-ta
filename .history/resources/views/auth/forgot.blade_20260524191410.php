<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - Green View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100%; background: #0a3d1e; overflow-x: hidden; }

    .auth-wrapper { display: flex; flex-direction: row; min-height: 100vh; }

    /* LEFT */
    .auth-left { width: 55%; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; background: #ffffff; }
    .auth-left::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 50% at 80% 110%, rgba(25,148,84,0.10) 0%, transparent 70%), radial-gradient(ellipse 50% 40% at -10% -10%, rgba(16,110,54,0.08) 0%, transparent 70%); pointer-events: none; }
    .auth-left .brand-tagline { margin-top: 18px; font-size: 13px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: #2d7a4f; opacity: 0.7; }
    .auth-left img { width: 68%; max-width: 340px; object-fit: contain; position: relative; filter: drop-shadow(0 12px 32px rgba(15,80,40,0.18)); animation: floatLogo 5s ease-in-out infinite; }
    @keyframes floatLogo { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .deco-circle { position: absolute; border-radius: 50%; border: 1.5px solid rgba(25,148,84,0.12); pointer-events: none; }
    .deco-circle.c1 { width: 420px; height: 420px; bottom: -120px; right: -120px; }
    .deco-circle.c2 { width: 260px; height: 260px; bottom: -60px; right: -60px; }
    .deco-circle.c3 { width: 160px; height: 160px; top: 30px; left: 30px; }

    /* RIGHT */
    .auth-right { width: 45%; background: linear-gradient(145deg, #1a6e3a 0%, #2e9e58 45%, #1a8040 100%); display: flex; align-items: center; justify-content: center; padding: 48px 40px; position: relative; overflow: hidden; }
    .auth-right::before { content: ''; position: absolute; inset: 0; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E"); opacity: 0.5; pointer-events: none; }
    .auth-right::after { content: ''; position: absolute; width: 340px; height: 340px; background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%); bottom: -80px; right: -80px; border-radius: 50%; pointer-events: none; }
    .blob-top { position: absolute; width: 240px; height: 240px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -60px; left: -60px; border-radius: 50%; pointer-events: none; }

    /* CARD */
    .auth-card { width: 100%; max-width: 380px; position: relative; z-index: 1; animation: slideUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) both; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }

    .card-header-area { text-align: center; margin-bottom: 24px; }
    .card-header-area .badge-pill { display: inline-block; background: rgba(255,255,255,0.15); backdrop-filter: blur(6px); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 5px 14px; border-radius: 99px; margin-bottom: 14px; }
    .card-header-area h4 { color: #ffffff; font-size: 20px; font-weight: 800; margin-bottom: 8px; }
    .card-header-area p { color: rgba(255,255,255,0.65); font-size: 13px; line-height: 1.5; }

    /* ALERTS */
    .alert { border-radius: 10px; font-size: 13px; padding: 10px 14px; margin-bottom: 16px; border: none; text-align: center; }
    .alert-danger  { background: rgba(220,53,69,0.85); color: #fff; }
    .alert-success { background: rgba(25,135,84,0.85); color: #fff; }
    .alert-info    { background: rgba(13,110,253,0.75); color: #fff; }

    /* METHOD SELECTOR */
    .method-label { color: rgba(255,255,255,0.8); font-size: 12px; font-weight: 600; margin-bottom: 8px; display: block; }
    .method-group { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 18px; }
    .method-option { display: none; }
    .method-card {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 5px; padding: 12px 8px; border-radius: 12px;
        border: 2px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08);
        cursor: pointer; transition: all 0.2s; user-select: none;
    }
    .method-card .mc-icon { font-size: 22px; line-height: 1; }
    .method-card .mc-title { font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.85); }
    .method-card .mc-sub { font-size: 10px; color: rgba(255,255,255,0.5); }
    .method-option:checked + .method-card {
        border-color: #ffffff; background: rgba(255,255,255,0.2);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.15);
    }
    .method-option:checked + .method-card .mc-title { color: #fff; }

    /* INPUT */
    .form-group { margin-bottom: 16px; }
    .input-wrap { position: relative; }
    .input-wrap .icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-size: 14px; pointer-events: none; }
    .form-control { width: 100%; padding: 11px 12px 11px 38px; border-radius: 10px; border: 1.5px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.94); color: #1a2e1a; font-size: 16px; font-family: inherit; outline: none; transition: border 0.2s, box-shadow 0.2s; -webkit-appearance: none; }
    .form-control::placeholder { color: #aab7aa; }
    .form-control:focus { border-color: rgba(255,255,255,0.6); box-shadow: 0 0 0 3px rgba(255,255,255,0.18); background: #ffffff; }

    /* BUTTON */
    .btn-submit { width: 100%; padding: 13px; border-radius: 10px; border: none; background: #ffffff; color: #1a6e3a; font-size: 14.5px; font-weight: 800; font-family: inherit; letter-spacing: 0.5px; cursor: pointer; transition: transform 0.15s, box-shadow 0.2s; box-shadow: 0 4px 18px rgba(0,0,0,0.15); margin-top: 4px; }
    .btn-submit:hover { background: #f0faf4; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
    .btn-submit:active { transform: translateY(0); background: #e4f5ec; }

    .links-area { text-align: center; margin-top: 18px; }
    .links-area a { color: rgba(255,255,255,0.75); font-size: 12.5px; text-decoration: none; transition: color 0.15s; }
    .links-area a:hover { color: #fff; }

    /* RESPONSIVE */
    @media screen and (min-width: 769px) and (max-width: 1024px) {
        .auth-left { width: 40%; } .auth-right { width: 60%; padding: 40px 28px; }
    }
    @media screen and (max-width: 768px) {
        .auth-wrapper { flex-direction: column !important; }
        .auth-left { width: 100% !important; padding: 44px 24px 36px !important; background: linear-gradient(160deg, #ffffff 60%, #f0faf5 100%) !important; order: 0; }
        .auth-left img { width: 50% !important; max-width: 185px !important; animation: none !important; }
        .auth-left .brand-tagline { margin-top: 12px !important; font-size: 10px !important; }
        .deco-circle.c1, .deco-circle.c2 { display: none !important; }
        .auth-right { width: 100% !important; flex: 1 !important; padding: 36px 24px 52px !important; border-radius: 28px 28px 0 0 !important; margin-top: -24px !important; order: 1; }
        .auth-card { max-width: 100% !important; }
        .method-card .mc-title { font-size: 11px; }
    }
    </style>
</head>
<body>

<div class="auth-wrapper">

    <div class="auth-left">
        <div class="deco-circle c1"></div>
        <div class="deco-circle c2"></div>
        <div class="deco-circle c3"></div>
        <img src="{{ asset('tunggal.png') }}" alt="Green View Logo">
        <span class="brand-tagline">Real Estate &bull; Bondowoso</span>
    </div>

    <div class="auth-right">
        <div class="blob-top"></div>

        <div class="auth-card">

            <div class="card-header-area">
                <div class="badge-pill">🔑 Reset Password</div>
                <h4>Lupa Password?</h4>
                <p>Tenang, kami akan bantu.<br>Masukkan email & pilih metode pengiriman OTP.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('password.sendOtp') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <div class="input-wrap">
                        <span class="icon">✉️</span>
                        <input type="email" name="email" class="form-control"
                               placeholder="Masukkan email Anda"
                               value="{{ old('email') }}"
                               required autocomplete="email">
                    </div>
                </div>

                {{-- Pilihan Metode OTP --}}
                <span class="method-label">Kirim OTP via:</span>
                <div class="method-group">

                    <label>
                        <input type="radio" name="otp_via" value="email" class="method-option" checked>
                        <div class="method-card">
                            <span class="mc-icon">📧</span>
                            <span class="mc-title">Email</span>
                            <span class="mc-sub">ke inbox email</span>
                        </div>
                    </label>

                    <label>
                        <input type="radio" name="otp_via" value="whatsapp" class="method-option">
                        <div class="method-card">
                            <span class="mc-icon">💬</span>
                            <span class="mc-title">WhatsApp</span>
                            <span class="mc-sub">ke nomor WA</span>
                        </div>
                    </label>

                </div>

                <button type="submit" class="btn-submit">
                    Kirim Kode OTP
                </button>
            </form>

            <div class="links-area">
                <a href="{{ route('login') }}">← Kembali ke Login</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>

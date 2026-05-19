<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - Green View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-height: 100%;
        background: #0a3d1e;
        overflow-x: hidden;
    }

    /* ─── WRAPPER ─── */
    .auth-wrapper {
        display: flex;
        flex-direction: row;
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
        margin-bottom: 28px;
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
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .card-header-area p {
        color: rgba(255,255,255,0.65);
        font-size: 13px;
        line-height: 1.5;
        margin: 0;
    }

    /* ─── INFO BOX ─── */
    .info-box {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 12px 14px;
        color: rgba(255,255,255,0.85);
        font-size: 12.5px;
        text-align: center;
        margin-bottom: 22px;
        line-height: 1.5;
    }

    /* ─── ALERTS ─── */
    .alert {
        border-radius: 10px;
        font-size: 13px;
        padding: 10px 14px;
        margin-bottom: 16px;
        border: none;
        text-align: center;
    }
    .alert-danger  { background: rgba(220,53,69,0.85);  color: #fff; }
    .alert-success { background: rgba(25,135,84,0.85);  color: #fff; }
    .alert-info    { background: rgba(13,110,253,0.75);  color: #fff; }

    /* ─── INPUT ─── */
    .form-group {
        margin-bottom: 18px;
    }

    .input-wrap {
        position: relative;
    }

    .input-wrap .icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px 11px 38px;
        border-radius: 10px;
        border: 1.5px solid rgba(255,255,255,0.2);
        background: rgba(255,255,255,0.94);
        color: #1a2e1a;
        font-size: 16px; /* cegah auto-zoom iOS */
        font-family: inherit;
        outline: none;
        transition: border 0.2s, box-shadow 0.2s;
        -webkit-appearance: none;
        appearance: none;
    }

    .form-control::placeholder { color: #aab7aa; }

    .form-control:focus {
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.18);
        background: #ffffff;
    }

    /* ─── BUTTON ─── */
    .btn-submit {
        width: 100%;
        padding: 13px;
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
        -webkit-tap-highlight-color: transparent;
    }

    .btn-submit:hover {
        background: #f0faf4;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .btn-submit:active {
        transform: translateY(0);
        background: #e4f5ec;
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

    /* ─── RESPONSIVE: Tablet ─── */
    @media screen and (min-width: 769px) and (max-width: 1024px) {
        .auth-left  { width: 40%; }
        .auth-right { width: 60%; padding: 40px 28px; }
        .auth-left img { width: 80%; }
    }

    /* ══════════════════════════════════════════
       MOBILE ≤ 768px  —  LAYOUT: atas-bawah
       ══════════════════════════════════════════ */
    @media screen and (max-width: 768px) {

        .auth-wrapper {
            flex-direction: column !important;
            min-height: 100vh;
        }

        /* ── Panel Atas: Logo ── */
        .auth-left {
            width: 100% !important;
            height: auto !important;
            min-height: unset !important;
            padding: 44px 24px 36px !important;
            flex-shrink: 0;
            background: linear-gradient(160deg, #ffffff 60%, #f0faf5 100%) !important;
            order: 0;
        }

        .auth-left img {
            width: 50% !important;
            max-width: 185px !important;
            animation: none !important;
            filter: drop-shadow(0 8px 20px rgba(15,80,40,0.14)) !important;
        }

        .auth-left .brand-tagline {
            margin-top: 12px !important;
            font-size: 10px !important;
            letter-spacing: 2.5px !important;
        }

        .deco-circle.c1,
        .deco-circle.c2 { display: none !important; }
        .deco-circle.c3 { width: 90px !important; height: 90px !important; top: 12px !important; left: 12px !important; }

        /* ── Panel Bawah: Form ── */
        .auth-right {
            width: 100% !important;
            flex: 1 !important;
            padding: 36px 24px 52px !important;
            align-items: flex-start !important;
            justify-content: center !important;
            border-radius: 28px 28px 0 0 !important;
            margin-top: -24px !important;
            order: 1;
        }

        .auth-card {
            max-width: 100% !important;
            width: 100% !important;
        }

        .card-header-area {
            margin-bottom: 20px !important;
        }

        .card-header-area .badge-pill {
            font-size: 10px !important;
            padding: 4px 12px !important;
        }

        .card-header-area h4 {
            font-size: 18px !important;
        }

        .card-header-area p {
            font-size: 12px !important;
        }

        .info-box {
            font-size: 12px !important;
            padding: 10px 12px !important;
            margin-bottom: 18px !important;
        }

        .form-group {
            margin-bottom: 14px !important;
        }

        .form-control {
            padding: 13px 12px 13px 40px !important;
            border-radius: 12px !important;
            font-size: 16px !important;
        }

        .btn-submit {
            padding: 14px !important;
            font-size: 15px !important;
            border-radius: 12px !important;
        }

        .links-area {
            margin-top: 22px !important;
        }

        .links-area a {
            font-size: 13px !important;
            padding: 4px 0 !important;
            display: inline-block !important;
        }
    }

    /* ─── Small Mobile ≤ 390px ─── */
    @media screen and (max-width: 390px) {
        .auth-left { padding: 36px 16px 28px !important; }
        .auth-left img { width: 46% !important; max-width: 160px !important; }
        .auth-right { padding: 28px 20px 44px !important; }
    }

    /* ─── Landscape Mobile ─── */
    @media screen and (max-width: 768px) and (orientation: landscape) {
        .auth-left {
            padding: 18px 24px 16px !important;
        }
        .auth-left img { width: 26% !important; max-width: 100px !important; }
        .auth-left .brand-tagline { margin-top: 6px !important; font-size: 9px !important; }
        .auth-right {
            padding: 22px 24px 32px !important;
            border-radius: 20px 20px 0 0 !important;
            margin-top: -10px !important;
        }
        .card-header-area { margin-bottom: 14px !important; }
        .form-group { margin-bottom: 10px !important; }
    }
    </style>
</head>

<body>

<div class="auth-wrapper">

    {{-- TOP / LEFT: Logo Panel --}}
    <div class="auth-left">
        <div class="deco-circle c1"></div>
        <div class="deco-circle c2"></div>
        <div class="deco-circle c3"></div>
        <img src="{{ asset('tunggal.png') }}" alt="Green View Logo">
        <span class="brand-tagline">Real Estate &bull; Bondowoso</span>
    </div>

    {{-- BOTTOM / RIGHT: Form Panel --}}
    <div class="auth-right">
        <div class="blob-top"></div>

        <div class="auth-card">

            <div class="card-header-area">
                <div class="badge-pill">🔑 Reset Password</div>
                <h4>Lupa Password?</h4>
                <p>Tenang, kami akan bantu.<br>Masukkan email akun Anda.</p>
            </div>

            <div class="info-box">
                📧 Link reset password akan dikirim ke email Anda
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.sendOtp') }}">
                @csrf

                <div class="form-group">
                    <div class="input-wrap">
                        <span class="icon">✉️</span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required autocomplete="email">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Kirim Link Reset
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

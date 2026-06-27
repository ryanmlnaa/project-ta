@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.gp-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
}

.gp-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.10);
    width: 100%;
    max-width: 440px;
    overflow: hidden;
}

.gp-header {
    background: linear-gradient(135deg, #92400e, #d97706);
    padding: 24px 28px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.gp-header-icon {
    width: 44px;
    height: 44px;
    background: rgba(255,255,255,0.18);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
}

.gp-header h5 {
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 2px;
}

.gp-header p {
    color: rgba(255,255,255,0.75);
    font-size: 12px;
    margin: 0;
}

.gp-body {
    padding: 24px 28px 28px;
}

.gp-notice {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-left: 4px solid #f59e0b;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13px;
    color: #78350f;
    margin-bottom: 22px;
    line-height: 1.5;
}

.gp-alert-error {
    background: #fdf0f0;
    border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13px;
    color: #7a1a1a;
    margin-bottom: 18px;
}

.gp-form-group {
    margin-bottom: 18px;
}

.gp-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}

.gp-input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e0ede0;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    background: #fafafa;
}

.gp-input:focus {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
    background: #fff;
}

.gp-btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #065f46, #059669);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    margin-top: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.gp-btn:hover { opacity: 0.90; transform: translateY(-1px); }
.gp-btn:active { transform: translateY(0); }

@media (max-width: 480px) {
    .gp-body { padding: 20px 18px 24px; }
    .gp-header { padding: 20px 18px 16px; }
}
</style>

<div class="gp-wrapper">
    <div class="gp-card">

        <div class="gp-header">
            <div class="gp-header-icon"><i class="fas fa-lock"></i></div>
            <div>
                <h5>Wajib Ganti Password</h5>
                <p>Keamanan akun Anda dimulai dari sini</p>
            </div>
        </div>

        <div class="gp-body">

            <div class="gp-notice">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Ini adalah login pertama Anda. Demi keamanan, silakan buat password baru sebelum melanjutkan.
            </div>

            @if($errors->any())
                <div class="gp-alert-error">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-times-circle me-1"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bendahara.ganti-password.update') }}" method="POST">
                @csrf

                <div class="gp-form-group">
                    <label class="gp-label"><i class="fas fa-key me-1"></i> Password Baru</label>
                    <input type="password" name="password" class="gp-input"
                           placeholder="Minimal 6 karakter" required minlength="6">
                </div>

                <div class="gp-form-group">
                    <label class="gp-label"><i class="fas fa-shield-alt me-1"></i> Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="gp-input"
                           placeholder="Ulangi password baru" required minlength="6">
                </div>

                <button type="submit" class="gp-btn">
                    <i class="fas fa-check-circle"></i> Simpan & Lanjutkan
                </button>

            </form>
        </div>
    </div>
</div>

@endsection

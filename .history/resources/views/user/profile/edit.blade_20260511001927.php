@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="prf-wrapper">

    <div class="prf-page-header">
        <div class="prf-header-decoration"></div>
        <div class="prf-header-inner">
            <div class="prf-header-icon"><i class="fas fa-user-cog"></i></div>
            <div>
                <h1 class="prf-header-title">Pengaturan Akun</h1>
                <p class="prf-header-sub">Kelola informasi profil dan keamanan akun Anda</p>
            </div>
        </div>
    </div>

    <div class="prf-grid">

        {{-- LEFT: PROFILE PHOTO --}}
        <div class="prf-left">

           

        </div>

        {{-- RIGHT: FORM --}}
        <div class="prf-right">
            <div class="prf-form-card">

                <div class="prf-form-header">
                    <div class="prf-form-header-left">
                        <div class="prf-form-icon"><i class="fas fa-edit"></i></div>
                        <div>
                            <h5 class="prf-form-title">Edit Profil</h5>
                            <span class="prf-form-sub">Perbarui data diri Anda</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.profil.update') }}" method="POST" class="prf-form-body">
                    @csrf
                    @method('PUT')

                    <div class="prf-section-label">Informasi Dasar</div>

                    <div class="prf-field-grid">
                        <div class="prf-field">
                            <label class="prf-label" for="name">
                                <i class="fas fa-user me-1"></i> Nama Lengkap
                            </label>
                            <input type="text" id="name" name="name"
                                class="prf-input"
                                value="{{ auth()->user()->name }}"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="prf-field">
                            <label class="prf-label" for="username">
                                <i class="fas fa-at me-1"></i> Username
                            </label>
                            <input type="text" id="username" name="username"
                                class="prf-input"
                                value="{{ auth()->user()->username }}"
                                placeholder="Masukkan username">
                        </div>

                        <div class="prf-field prf-field--full">
                            <label class="prf-label" for="email">
                                <i class="fas fa-envelope me-1"></i> Alamat Email
                            </label>
                            <input type="email" id="email" name="email"
                                class="prf-input"
                                value="{{ auth()->user()->email }}"
                                placeholder="Masukkan email">
                        </div>
                    </div>

                    <div class="prf-section-label prf-section-label--mt">
                        <i class="fas fa-lock me-1"></i> Keamanan Akun
                        <span class="prf-section-note">Kosongkan jika tidak ingin mengubah password</span>
                    </div>

                    <div class="prf-field-grid">
                        <div class="prf-field">
                            <label class="prf-label" for="password">Password Baru</label>
                            <div class="prf-input-wrap">
                                <input type="password" id="password" name="password"
                                    class="prf-input prf-input--icon"
                                    placeholder="Min. 8 karakter">
                                <span class="prf-eye" onclick="togglePass('password', this)">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="prf-field">
                            <label class="prf-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="prf-input-wrap">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="prf-input prf-input--icon"
                                    placeholder="Ulangi password baru">
                                <span class="prf-eye" onclick="togglePass('password_confirmation', this)">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="prf-form-footer">
                        <button type="reset" class="prf-btn-reset">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                        <button type="submit" class="prf-btn-save">
                            <i class="fas fa-check me-2"></i>Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        const name = input.files[0].name;
        document.getElementById('fileLabel').textContent = name.length > 18 ? name.substring(0,18)+'…' : name;
    }
}

function togglePass(id, el) {
    const inp = document.getElementById(id);
    const icon = el.querySelector('i');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'far fa-eye-slash';
    } else {
        inp.type = 'password';
        icon.className = 'far fa-eye';
    }
}
</script>

@endsection

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --em50:  #ecfdf5;
    --em100: #d1fae5;
    --em200: #a7f3d0;
    --em400: #34d399;
    --em500: #10b981;
    --em600: #059669;
    --em700: #047857;
    --em800: #065f46;
    --em900: #064e3b;

    --g50:  #f9fafb;
    --g100: #f3f4f6;
    --g200: #e5e7eb;
    --g300: #d1d5db;
    --g400: #9ca3af;
    --g500: #6b7280;
    --g600: #4b5563;
    --g700: #374151;
    --g800: #1f2937;

    --blue50:  #eff6ff;
    --blue100: #dbeafe;
    --blue400: #60a5fa;
    --blue600: #2563eb;
    --blue700: #1d4ed8;
}

body { background: #f0f4f8; font-family: 'Plus Jakarta Sans', sans-serif; }

/* ===== WRAPPER ===== */
.prf-wrapper {
    max-width: 100%;        /* hapus batasan lebar */
    margin: 0;
    padding: 28px 28px 60px;   /* padding kiri kanan saja */
}

/* ===== PAGE HEADER ===== */
.prf-page-header {
    position: relative;
    background: linear-gradient(135deg, var(--em900) 0%, var(--em700) 55%, var(--em500) 100%);
    border-radius: 20px;
    margin-bottom: 24px;
    overflow: hidden;
    padding: 26px 28px;
}

.prf-header-decoration {
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%),
        radial-gradient(circle at 10% 85%, rgba(255,255,255,0.05) 0%, transparent 40%);
    pointer-events: none;
}

.prf-header-inner {
    position: relative;
    display: flex;
    align-items: center;
    gap: 16px;
}

.prf-header-icon {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
}

.prf-header-title {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
    letter-spacing: -0.3px;
}

.prf-header-sub {
    font-size: 13px;
    color: rgba(255,255,255,0.7);
    margin: 0;
}

/* ===== GRID ===== */
.prf-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 20px;
    align-items: start;
}

@media (max-width: 768px) {
    .prf-grid { grid-template-columns: 1fr; }
}

/* ===== LEFT: PHOTO CARD ===== */
.prf-photo-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--g100);
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 28px 20px 22px;
    text-align: center;
}

.prf-avatar-ring {
    position: relative;
    display: inline-block;
    margin-bottom: 14px;
}

.prf-avatar {
    width: 108px;
    height: 108px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow:
        0 0 0 3px var(--em200),
        0 8px 24px rgba(5,150,105,0.15);
    display: block;
    transition: filter 0.2s;
}

.prf-avatar-overlay {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: rgba(5,150,105,0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #fff;
    opacity: 0;
    transition: opacity 0.2s;
    cursor: pointer;
}

.prf-avatar-ring:hover .prf-avatar-overlay { opacity: 1; }
.prf-avatar-ring:hover .prf-avatar { filter: brightness(0.85); }

.prf-name {
    font-size: 16px;
    font-weight: 800;
    color: var(--g800);
    margin: 0 0 4px;
}

.prf-email {
    font-size: 12.5px;
    color: var(--g400);
    display: block;
}

.prf-divider {
    height: 1px;
    background: var(--g100);
    margin: 18px 0;
}

.prf-file-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 9px 14px;
    background: var(--em50);
    color: var(--em700);
    border: 1.5px dashed var(--em300, #6ee7b7);
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 10px;
}

.prf-file-label:hover {
    background: var(--em100);
    border-color: var(--em500);
}

.prf-file-input { display: none; }

.prf-btn-upload {
    width: 100%;
    padding: 10px;
    background: linear-gradient(135deg, var(--em600), var(--em500));
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(5,150,105,0.28);
    transition: all 0.2s;
}

.prf-btn-upload:hover {
    background: linear-gradient(135deg, var(--em700), var(--em600));
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(5,150,105,0.35);
}

.prf-file-hint {
    font-size: 11.5px;
    color: var(--g400);
    margin: 8px 0 0;
}

/* ===== INFO CARD ===== */
.prf-info-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--g100);
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    padding: 16px;
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.prf-info-row {
    display: flex;
    align-items: center;
    gap: 12px;
}

.prf-info-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.prf-icon-green { background: var(--em50); color: var(--em700); }
.prf-icon-blue  { background: var(--blue50); color: var(--blue700); }

.prf-info-label {
    display: block;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--g400);
    text-transform: uppercase;
    letter-spacing: 0.6px;
}

.prf-info-value {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--g700);
    margin-top: 1px;
    word-break: break-all;
}

/* ===== RIGHT: FORM CARD ===== */
.prf-form-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--g100);
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
}

.prf-form-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--g100);
    background: var(--g50);
}

.prf-form-header-left {
    display: flex;
    align-items: center;
    gap: 13px;
}

.prf-form-icon {
    width: 38px;
    height: 38px;
    background: var(--em50);
    color: var(--em700);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    border: 1px solid var(--em100);
}

.prf-form-title {
    font-size: 15px;
    font-weight: 800;
    color: var(--g800);
    margin: 0 0 2px;
}

.prf-form-sub {
    font-size: 12px;
    color: var(--g400);
    font-weight: 400;
}

/* ===== FORM BODY ===== */
.prf-form-body {
    padding: 22px 24px;
}

.prf-section-label {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--em700);
    text-transform: uppercase;
    letter-spacing: 0.7px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.prf-section-label--mt { margin-top: 22px; }

.prf-section-note {
    font-size: 11px;
    font-weight: 500;
    color: var(--g400);
    text-transform: none;
    letter-spacing: 0;
    margin-left: auto;
}

.prf-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

@media (max-width: 576px) {
    .prf-field-grid { grid-template-columns: 1fr; }
}

.prf-field--full { grid-column: 1 / -1; }

.prf-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--g600);
    margin-bottom: 6px;
    letter-spacing: 0.1px;
}

.prf-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid var(--g200);
    border-radius: 10px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--g800);
    background: #fff;
    transition: all 0.2s;
    outline: none;
}

.prf-input:focus {
    border-color: var(--em500);
    box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
}

.prf-input::placeholder { color: var(--g300); }

.prf-input-wrap { position: relative; }

.prf-input--icon { padding-right: 40px; }

.prf-eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--g400);
    cursor: pointer;
    font-size: 14px;
    transition: color 0.2s;
}

.prf-eye:hover { color: var(--em600); }

/* ===== FORM FOOTER ===== */
.prf-form-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--g100);
}

.prf-btn-reset {
    padding: 10px 20px;
    background: var(--g100);
    color: var(--g600);
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
}

.prf-btn-reset:hover { background: var(--g200); color: var(--g800); }

.prf-btn-save {
    padding: 10px 24px;
    background: linear-gradient(135deg, var(--em600), var(--em500));
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(5,150,105,0.28);
    transition: all 0.2s;
}

.prf-btn-save:hover {
    background: linear-gradient(135deg, var(--em700), var(--em600));
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(5,150,105,0.35);
}
</style>

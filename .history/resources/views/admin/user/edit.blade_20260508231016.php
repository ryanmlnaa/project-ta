@extends('layouts.app')

@section('content')

{{-- ============================================================
     FILE: resources/views/admin/user/edit.blade.php
============================================================ --}}

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f8 !important; }

/* ── WRAPPER ── */
.eu-wrap {
    padding: 28px 28px;
    max-width: 2000px;
}

/* ── TOP NAV ── */
.eu-topnav {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}

.eu-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: #ffffff;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    text-decoration: none;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

.eu-back:hover {
    background: #f0fdf4;
    border-color: #064e3b;
    color: #064e3b;
    transform: translateX(-2px);
    text-decoration: none;
}

.eu-page-title h1 {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    line-height: 1.2;
}

.eu-page-title p {
    font-size: 12.5px;
    color: #6b7280;
    margin: 2px 0 0;
}

/* ── CARD ── */
.eu-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    overflow: hidden;
    animation: slideUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── CARD HEADER ── */
.eu-card-head {
    background: linear-gradient(135deg, #064e3b 0%, #0a6b52 50%, #0d7a5f 100%);
    padding: 24px 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
    overflow: hidden;
}

.eu-card-head::before {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}

.eu-card-head::after {
    content: '';
    position: absolute;
    right: 60px; bottom: -60px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}

.eu-avatar {
    width: 52px;
    height: 52px;
    background: rgba(255,255,255,0.18);
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 20px;
    color: #fff;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.eu-head-info {
    position: relative;
    z-index: 1;
}

.eu-head-info h5 {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 3px;
}

.eu-head-info small {
    color: rgba(255,255,255,0.65);
    font-size: 12.5px;
}

/* ── CARD BODY ── */
.eu-card-body {
    padding: 28px 28px;
}

/* ── FORM GROUPS ── */
.eu-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
}

.eu-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 7px;
    letter-spacing: 0.3px;
}

.eu-group label .lock-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #fef3c7;
    color: #d97706;
    border: 1px solid #fde68a;
    border-radius: 999px;
    padding: 1px 8px;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.2px;
}

.eu-group input,
.eu-group select {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #111827;
    background: #ffffff;
    outline: none;
    transition: all 0.2s ease;
}

.eu-group input:focus,
.eu-group select:focus {
    border-color: #064e3b;
    box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
    background: #f9fffc;
}

.eu-group input.is-invalid,
.eu-group select.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    font-size: 12px;
    color: #ef4444;
    margin-top: 5px;
    display: block;
}

/* ── LOCKED / DISABLED FIELD ── */
.eu-group input.field-locked,
.eu-group select.field-locked {
    background: #f9fafb !important;
    color: #9ca3af !important;
    border: 1.5px solid #e5e7eb !important;
    cursor: not-allowed !important;
    -webkit-user-select: none;
    user-select: none;
}

.eu-locked-wrapper {
    position: relative;
}

.eu-locked-wrapper input,
.eu-locked-wrapper select {
    padding-right: 42px !important;
}

.eu-lock-icon {
    position: absolute;
    right: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #d1d5db;
    font-size: 13px;
    pointer-events: none;
}

/* ── LOCKED INFO BOX ── */
.eu-locked-notice {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 13px 16px;
    margin-bottom: 22px;
    font-size: 12.5px;
    color: #92400e;
    line-height: 1.55;
}

.eu-locked-notice i {
    color: #f59e0b;
    font-size: 14px;
    margin-top: 1px;
    flex-shrink: 0;
}

/* ── DIVIDER ── */
.eu-divider {
    height: 1px;
    background: #f3f4f6;
    margin: 24px 0;
}

/* ── SECTION LABEL ── */
.eu-section-label {
    font-size: 11px;
    font-weight: 800;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 14px;
}

/* ── ACTIONS ── */
.eu-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.eu-btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    background: #ffffff;
    color: #6b7280;
    font-size: 13.5px;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.eu-btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
    text-decoration: none;
}

.eu-btn-save {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 24px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: #ffffff;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}

.eu-btn-save:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(6,78,59,0.35);
}

.eu-btn-save:active { transform: translateY(0); }

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
    .eu-row { grid-template-columns: 1fr; }
    .eu-wrap { padding: 16px; }
    .eu-card-body { padding: 20px; }
}
</style>

<div class="eu-wrap">

    {{-- TOP NAV --}}
    <div class="eu-topnav">
        <a href="{{ route('admin.user.index') }}" class="eu-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="eu-page-title">
            <h1>Edit User</h1>
            <p>Update informasi dan hak akses user</p>
        </div>
    </div>

    {{-- CARD --}}
    <div class="eu-card">

        {{-- HEAD --}}
        <div class="eu-card-head">
            <div class="eu-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div class="eu-head-info">
                <h5>{{ $user->name }}</h5>
                <small>{{ $user->email }}</small>
            </div>
        </div>

        {{-- BODY --}}
        <div class="eu-card-body">

            {{-- INFO NOTICE --}}
            <div class="eu-locked-notice">
                <i class="fas fa-lock"></i>
                <span>
                    <strong>Perhatian:</strong> Field <strong>Email</strong>, <strong>Password</strong>, dan <strong>Konfirmasi Password</strong>
                    tidak dapat diubah oleh Admin. Hanya pemilik akun yang dapat mengubah data tersebut.
                </span>
            </div>

            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- SECTION: INFO AKUN --}}
                <p class="eu-section-label"><i class="fas fa-user" style="margin-right:5px;"></i>Informasi Akun</p>

                <div class="eu-row">
                    {{-- Nama Lengkap — bisa diedit --}}
                    <div class="eu-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name"
                            class="@error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    {{-- Email — LOCKED --}}
                    <div class="eu-group">
                        <label>
                            Email
                            <span class="lock-badge"><i class="fas fa-lock" style="font-size:9px;"></i> Terkunci</span>
                        </label>
                        <div class="eu-locked-wrapper">
                            <input type="email"
                                class="field-locked"
                                value="{{ $user->email }}"
                                readonly
                                disabled
                                tabindex="-1">
                            <i class="fas fa-lock eu-lock-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="eu-row">
                    {{-- Role — bisa diedit --}}
                    <div class="eu-group">
                        <label>Role</label>
                        <select name="role" class="@error('role') is-invalid @enderror" required>
                            <option value="admin"  {{ old('role', $user->role) == 'admin'  ? 'selected' : '' }}>Admin</option>
                            <option value="rt"     {{ old('role', $user->role) == 'rt'     ? 'selected' : '' }}>RT</option>
                            <option value="user"   {{ old('role', $user->role) == 'user'   ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    {{-- Username — bisa diedit --}}
                    <div class="eu-group">
                        <label>Username</label>
                        <input type="text" name="username"
                            class="@error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username ?? '') }}">
                        @error('username')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="eu-divider"></div>

                {{-- SECTION: KEAMANAN --}}
                <p class="eu-section-label"><i class="fas fa-shield-alt" style="margin-right:5px;"></i>Keamanan</p>

                <div class="eu-row">
                    {{-- Password Baru — LOCKED --}}
                    <div class="eu-group">
                        <label>
                            Password Baru
                            <span class="lock-badge"><i class="fas fa-lock" style="font-size:9px;"></i> Terkunci</span>
                        </label>
                        <div class="eu-locked-wrapper">
                            <input type="password"
                                class="field-locked"
                                placeholder="Tidak dapat diubah oleh admin"
                                readonly
                                disabled
                                tabindex="-1">
                            <i class="fas fa-lock eu-lock-icon"></i>
                        </div>
                    </div>

                    {{-- Konfirmasi Password — LOCKED --}}
                    <div class="eu-group">
                        <label>
                            Konfirmasi Password
                            <span class="lock-badge"><i class="fas fa-lock" style="font-size:9px;"></i> Terkunci</span>
                        </label>
                        <div class="eu-locked-wrapper">
                            <input type="password"
                                class="field-locked"
                                placeholder="Tidak dapat diubah oleh admin"
                                readonly
                                disabled
                                tabindex="-1">
                            <i class="fas fa-lock eu-lock-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="eu-divider"></div>

                <div class="eu-actions">
                    <a href="{{ route('admin.user.index') }}" class="eu-btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="eu-btn-save">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection

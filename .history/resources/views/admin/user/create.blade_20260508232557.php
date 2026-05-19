@extends('layouts.app')

@section('content')

{{-- ============================================================
     FILE: resources/views/admin/user/create.blade.php
============================================================ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* {
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

body { background: #f1f5f9 !important; margin: 0; }

/* ─── HERO HEADER ─── */
.hero {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #059669 100%);
    padding: 2rem 2.5rem 2.2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.hero::after {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    pointer-events: none;
}

.hero::before {
    content: '';
    position: absolute;
    right: 80px; bottom: -80px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}

.hero-left {
    display: flex;
    align-items: center;
    gap: 1.1rem;
    position: relative;
    z-index: 1;
}

.hero-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    border: 1px solid rgba(255,255,255,0.2);
}

.hero-icon i { font-size: 1.4rem; color: #fff; }

.hero-text h2 {
    font-size: 1.4rem; font-weight: 800;
    color: #fff; margin: 0 0 3px;
    letter-spacing: -0.01em;
}

.hero-text p {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.7);
    margin: 0;
}

.btn-hero-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    border: 1.5px solid rgba(255,255,255,0.4);
    background: rgba(255,255,255,0.15);
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    backdrop-filter: blur(8px);
    position: relative;
    z-index: 1;
}

.btn-hero-back:hover {
    background: rgba(255,255,255,0.28);
    border-color: rgba(255,255,255,0.6);
    color: #fff;
    text-decoration: none;
}

/* ─── PAGE BODY ─── */
.page-body {
    width: 100%;
    padding: 2rem 2.5rem 3rem;
}

/* ─── FORM META ─── */
.form-meta {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 1.1rem 1.75rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.meta-icon {
    width: 38px; height: 38px;
    background: #dcfce7;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.meta-icon i { color: #16a34a; font-size: 0.95rem; }

.meta-text h3 {
    font-size: 0.95rem; font-weight: 700;
    color: #0f172a; margin: 0 0 2px;
}

.meta-text p {
    font-size: 0.75rem; color: #64748b; margin: 0;
}

/* ─── SECTION CARD ─── */
.section-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    animation: fadeUp 0.35s ease both;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.section-card:nth-child(2) { animation-delay: 0.05s; }
.section-card:nth-child(3) { animation-delay: 0.1s; }

.section-header {
    padding: 0.85rem 1.75rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 9px;
}

.section-header i { color: #16a34a; font-size: 0.82rem; }

.section-header span {
    font-size: 0.72rem; font-weight: 800;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.09em;
}

.section-body { padding: 1.75rem; }

/* ─── FIELD GRID ─── */
.field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

@media (max-width: 768px) {
    .field-grid { grid-template-columns: 1fr; }
    .page-body { padding: 1.25rem 1rem 2rem; }
    .hero { padding: 1.5rem 1.25rem; }
}

/* ─── FIELD ─── */
.field-group { margin-bottom: 0; }

.field-label {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.8rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.field-label i { color: #6b7280; font-size: 0.75rem; width: 14px; }

.field-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.92rem;
    color: #0f172a;
    background: #fff;
    transition: all 0.2s;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.field-input:hover { border-color: #94a3b8; }

.field-input:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34,197,94,0.12);
}

.field-input::placeholder { color: #9ca3af; }

/* ─── LOCKED FIELD ─── */
.field-locked-wrap { position: relative; }

.field-locked-wrap .field-input {
    background: #f9fafb !important;
    color: #9ca3af !important;
    border-color: #e5e7eb !important;
    cursor: not-allowed;
    padding-right: 2.8rem;
}

.field-lock-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #d1d5db;
    font-size: 0.78rem;
    pointer-events: none;
}

/* ─── PASSWORD TOGGLE ─── */
.field-pw-wrap { position: relative; }

.field-pw-wrap .field-input { padding-right: 3rem; }

.btn-pw-toggle {
    position: absolute;
    right: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #9ca3af;
    cursor: pointer;
    padding: 0;
    font-size: 0.82rem;
    transition: color 0.15s;
}

.btn-pw-toggle:hover { color: #374151; }

/* ─── NOTICE BOX ─── */
.notice-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-left: 4px solid #22c55e;
    border-radius: 10px;
    padding: 0.85rem 1.1rem;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.82rem;
    color: #15803d;
    line-height: 1.55;
    margin-bottom: 1.25rem;
}

.notice-box i { color: #22c55e; font-size: 0.9rem; margin-top: 1px; flex-shrink: 0; }

/* ─── ALERT ERROR ─── */
.alert-err {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 0.85rem 1.1rem;
    color: #b91c1c;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ─── ACTION BAR ─── */
.action-bar {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 1.25rem 1.75rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.action-hint {
    font-size: 0.78rem;
    color: #94a3b8;
}

.action-hint i { font-size: 0.55rem; color: #ef4444; }

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 0.75rem 2.5rem;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: #fff;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(22,163,74,0.3);
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: 0.02em;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(22,163,74,0.38);
}

.btn-submit:active { transform: translateY(0); }

/* ─── STRENGTH METER ─── */
.pw-strength {
    margin-top: 7px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pw-bars {
    display: flex;
    gap: 4px;
    flex: 1;
}

.pw-bar {
    height: 4px;
    flex: 1;
    border-radius: 99px;
    background: #e5e7eb;
    transition: background 0.3s;
}

.pw-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    white-space: nowrap;
    min-width: 60px;
    text-align: right;
}
</style>

{{-- ─── HERO ─── --}}
<div class="hero">
    <div class="hero-left">
        <div class="hero-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="hero-text">
            <h2>Tambah User RT</h2>
            <p>Daftarkan akun baru untuk pengurus RT</p>
        </div>
    </div>
    <a href="{{ route('admin.user.index') }}" class="btn-hero-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="page-body">

    {{-- META --}}
    <div class="form-meta">
        <div class="meta-icon"><i class="fas fa-user-shield"></i></div>
        <div class="meta-text">
            <h3>Form Tambah User RT</h3>
            <p>Lengkapi data akun — role otomatis ditetapkan sebagai RT</p>
        </div>
    </div>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        {{-- ERROR --}}
        @if(session('error'))
            <div class="alert-err">
                <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-err">
                <i class="fas fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        {{-- NOTICE --}}
        <div class="notice-box">
            <i class="fas fa-circle-info"></i>
            <span>
                Pastikan <strong>email belum terdaftar</strong> di sistem.
                Password minimal <strong>6 karakter</strong>.
                Setelah disimpan, user dapat langsung login ke sistem.
            </span>
        </div>

        {{-- SEKSI 1: INFORMASI AKUN --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-user"></i>
                <span>Informasi Akun</span>
            </div>
            <div class="section-body">
                <div class="field-grid">

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-id-card"></i> Nama Lengkap
                        </label>
                        <input type="text" name="name" class="field-input"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" name="email" class="field-input"
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}" required>
                    </div>

                </div>
            </div>
        </div>

        {{-- SEKSI 2: KEAMANAN --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-shield-alt"></i>
                <span>Keamanan</span>
            </div>
            <div class="section-body">
                <div class="field-grid">

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="field-pw-wrap">
                            <input type="password" name="password" id="pwField"
                                   class="field-input"
                                   placeholder="Minimal 6 karakter"
                                   oninput="checkStrength(this.value)"
                                   required>
                            <button type="button" class="btn-pw-toggle" onclick="togglePw('pwField', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        {{-- Strength meter --}}
                        <div class="pw-strength" id="strengthMeter" style="display:none;">
                            <div class="pw-bars">
                                <div class="pw-bar" id="bar1"></div>
                                <div class="pw-bar" id="bar2"></div>
                                <div class="pw-bar" id="bar3"></div>
                                <div class="pw-bar" id="bar4"></div>
                            </div>
                            <span class="pw-label" id="pwLabel">Lemah</span>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-shield"></i> Role
                        </label>
                        <div class="field-locked-wrap">
                            <input type="text" class="field-input" value="RT" readonly>
                            <i class="fas fa-lock field-lock-icon"></i>
                        </div>
                        <input type="hidden" name="role" value="rt">
                    </div>

                </div>
            </div>
        </div>

        {{-- ACTION BAR --}}
        <div class="action-bar">
            <p class="action-hint">
                <i class="fas fa-asterisk"></i>
                Semua field wajib diisi
            </p>
            <button type="submit" class="btn-submit">
                <i class="fas fa-floppy-disk"></i>
                Simpan User RT
            </button>
        </div>

    </form>
</div>

<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function checkStrength(val) {
    const meter = document.getElementById('strengthMeter');
    const label = document.getElementById('pwLabel');
    const bars  = [document.getElementById('bar1'), document.getElementById('bar2'),
                   document.getElementById('bar3'), document.getElementById('bar4')];

    if (!val) { meter.style.display = 'none'; return; }
    meter.style.display = 'flex';

    let score = 0;
    if (val.length >= 6)  score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    const labels = ['Lemah','Cukup','Kuat','Sangat Kuat'];

    bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score - 1] : '#e5e7eb';
    });

    label.textContent  = labels[score - 1] || 'Lemah';
    label.style.color  = colors[score - 1] || '#ef4444';
}
</script>

@endsection

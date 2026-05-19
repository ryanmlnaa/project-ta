@extends('layouts.app')

@section('content')

{{-- HERO BANNER --}}
<div class="profile-hero">
    <div class="profile-hero-icon">
        <i class="fas fa-user-cog"></i>
    </div>
    <div>
        <div class="profile-hero-title">Pengaturan Akun</div>
        <div class="profile-hero-sub">Kelola informasi profil dan keamanan akun Anda</div>
    </div>
</div>

<div class="profile-wrap">

     {{-- NOTIFIKASI --}}
    @if(session('success'))
    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #064e3b;
                color:#065f46; border-radius:10px; padding:12px 16px; font-size:13px;
                font-weight:600; display:flex; align-items:center; gap:8px; margin-bottom:18px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; border-left:4px solid #dc2626;
                color:#dc2626; border-radius:10px; padding:12px 16px; font-size:13px;
                font-weight:600; margin-bottom:18px;">
        <i class="fas fa-exclamation-circle"></i>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <div class="profile-grid">

        {{-- KOLOM KIRI --}}
        <div class="profile-left">

            {{-- FOTO CARD --}}
            <div class="pcard">
                <div class="pcard-avatar-wrap">
                    <
                </div>
                

               <form action="{{ route('rt.upload.photo') }}" method="POST"

                </form>
            </div>

            {{-- INFO CARD --}}


        </div>

        {{-- KOLOM KANAN --}}
        <div class="profile-right">
            <div class="pcard">

                <div class="pform-header">
                    <div class="pform-header-icon"><i class="fas fa-edit"></i></div>
                    <div>
                        <div class="pform-title">Edit Profil</div>
                        <div class="pform-sub">Perbarui data diri Anda</div>
                    </div>
                </div>

                <form action="{{ route('rt.updateprofile') }}" method="POST" id="profileForm">


                </form>
            </div>
        </div>

    </div>
</div>

<style>
/* =================================================
   WARNA UTAMA: #064e3b (hijau tua) — sama dgn Edit User
================================================= */

.profile-hero {
    display: flex;
    align-items: center;
    gap: 18px;
    background: linear-gradient(135deg, #064e3b 0%, #0a6b52 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin: 0 0 28px 0;
    box-shadow: 0 4px 20px rgba(6,78,59,0.2);
}

.profile-hero-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff; flex-shrink: 0;
}

.profile-hero-title { font-size: 20px; font-weight: 800; color: #fff; line-height: 1.2; }
.profile-hero-sub   { font-size: 13px; color: rgba(255,255,255,0.65); margin-top: 3px; }

.profile-wrap { padding: 0; }

.profile-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    align-items: start;
}

.pcard {
    background: #fff;
    border-radius: 16px;
    padding: 28px 24px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07);
    border: 1px solid #e5e7eb;
}

.profile-left { display: flex; flex-direction: column; gap: 16px; }

.pcard-avatar-wrap { display: flex; justify-content: center; margin-bottom: 14px; }

.pcard-avatar {
    width: 110px; height: 110px;
    border-radius: 50%; object-fit: cover;
    border: 4px solid #a7f3d0;
    box-shadow: 0 4px 16px rgba(6,78,59,0.15);
}

.pcard-name  { text-align: center; font-size: 16px; font-weight: 700; color: #111827; }
.pcard-email { text-align: center; font-size: 12.5px; color: #6b7280; margin-top: 3px; margin-bottom: 18px; }

.pcard-upload-form { display: flex; flex-direction: column; gap: 10px; }

.btn-pilih-foto {
    display: block; text-align: center; padding: 10px;
    border-radius: 10px; border: 2px dashed #6ee7b7;
    color: #064e3b; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: all 0.2s; background: #f0fdf4;
}
.btn-pilih-foto:hover { background: #d1fae5; }

.btn-upload-foto {
    display: block; width: 100%; padding: 11px;
    border-radius: 10px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: #fff; font-size: 13.5px; font-weight: 700; border: none;
    cursor: pointer; box-shadow: 0 4px 12px rgba(6,78,59,0.25); transition: opacity 0.2s;
}
.btn-upload-foto:hover { opacity: 0.88; }

.pcard-hint { text-align: center; font-size: 11.5px; color: #9ca3af; }

.pcard-info { padding: 20px 24px; }

.pinfo-row {
    display: flex; align-items: center; gap: 14px;
    padding: 10px 0; border-bottom: 1px solid #f3f4f6;
}
.pinfo-row:last-child { border-bottom: none; }

.pinfo-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #f0fdf4; display: flex; align-items: center;
    justify-content: center; color: #064e3b; font-size: 14px; flex-shrink: 0;
}
.pinfo-icon-blue { background: #eff6ff; color: #2563eb; }

.pinfo-label  { font-size: 10px; font-weight: 700; color: #9ca3af; letter-spacing: 1px; text-transform: uppercase; }
.pinfo-value  { font-size: 13.5px; font-weight: 600; color: #111827; margin-top: 2px; }

.pform-header {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid #f3f4f6;
}

.pform-header-icon {
    width: 40px; height: 40px; background: #f0fdf4; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #064e3b; font-size: 16px; flex-shrink: 0;
}

.pform-title { font-size: 16px; font-weight: 700; color: #111827; }
.pform-sub   { font-size: 12.5px; color: #6b7280; margin-top: 2px; }

.pform-section-label {
    font-size: 11px; font-weight: 800; color: #064e3b;
    letter-spacing: 1px; text-transform: uppercase;
    margin: 0 0 14px; display: flex; align-items: center; gap: 4px;
}

.pform-section-hint {
    font-size: 11px; font-weight: 400; color: #9ca3af;
    letter-spacing: 0; text-transform: none; margin-left: auto;
}

.pform-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

.pform-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
.pform-row-2 .pform-group { margin-bottom: 0; }

.pform-label { font-size: 12.5px; font-weight: 600; color: #374151; }

.pform-input {
    padding: 11px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px;
    font-size: 13.5px; color: #111827; background: #fafafa;
    transition: border 0.2s, box-shadow 0.2s; outline: none; width: 100%; box-sizing: border-box;
}
.pform-input:focus {
    border-color: #064e3b;
    box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
    background: #fff;
}

.pform-input-wrap { position: relative; }
.pform-input-icon { padding-right: 42px; }

.pform-eye {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; cursor: pointer; font-size: 14px; transition: color 0.15s;
}
.pform-eye:hover { color: #064e3b; }

.pform-actions {
    display: flex; justify-content: flex-end; gap: 12px;
    margin-top: 8px; padding-top: 20px; border-top: 1px solid #f3f4f6;
}

.btn-reset {
    padding: 11px 22px; border-radius: 10px; border: 1.5px solid #e5e7eb;
    background: #fff; color: #6b7280; font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.btn-reset:hover { background: #f9fafb; border-color: #d1d5db; color: #374151; }

.btn-simpan {
    padding: 11px 28px; border-radius: 10px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: #fff; font-size: 13.5px; font-weight: 700; border: none;
    cursor: pointer; transition: opacity 0.2s;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}
.btn-simpan:hover { opacity: 0.88; }
</style>

<script>
document.getElementById('fotoInput').addEventListener('change', function(e) {
    if (e.target.files[0]) {
        document.getElementById('previewImg').src = URL.createObjectURL(e.target.files[0]);
    }
});

function togglePw(id, el) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    el.innerHTML = isHidden ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
}
</script>

@endsection

@extends('layouts.app')

@section('content')

<div class="ei-wrapper">

    {{-- HERO --}}
    <div class="ei-hero">
        <div class="ei-hero-icon"><i class="fas fa-bullhorn"></i></div>
        <div>
            <div class="ei-hero-title">Edit Informasi</div>
            <div class="ei-hero-sub">Perbarui informasi yang akan ditampilkan ke warga</div>
        </div>
    </div>

    <div class="ei-card">

        <div class="ei-card-header">
            <div class="ei-header-icon"><i class="fas fa-edit"></i></div>
            <div>
                <div class="ei-card-title">Form Edit Informasi</div>
                <div class="ei-card-sub">Lengkapi semua field yang diperlukan</div>
            </div>
        </div>

        <form action="{{ route('informasi.update', $data->id) }}" method="POST"
              enctype="multipart/form-data" class="ei-form">
            @csrf
            @method('PUT')

            {{-- SECTION: KONTEN --}}
            <div class="ei-section-label">
                <i class="fas fa-file-alt me-1"></i> Konten Informasi
            </div>

            <div class="ei-field">
                <label class="ei-label"><i class="fas fa-heading me-1"></i> Judul Informasi</label>
                <input type="text" name="judul" class="ei-input"
                    value="{{ $data->judul }}" placeholder="Masukkan judul informasi">
            </div>

            <div class="ei-field">
                <label class="ei-label"><i class="fas fa-align-left me-1"></i> Isi Informasi</label>
                <textarea name="isi" class="ei-input ei-textarea"
                    rows="4" placeholder="Tulis isi informasi...">{{ $data->isi }}</textarea>
            </div>

            {{-- SECTION: DETAIL --}}
            <div class="ei-section-label ei-section-label--mt">
                <i class="fas fa-info-circle me-1"></i> Detail Informasi
            </div>

            <div class="ei-grid-2">
                <div class="ei-field">
                    <label class="ei-label"><i class="fas fa-calendar-alt me-1"></i> Tanggal</label>
                    <input type="date" name="tanggal" class="ei-input"
                        value="{{ $data->tanggal }}">
                </div>

                <div class="ei-field">
                    <label class="ei-label"><i class="fas fa-tag me-1"></i> Kategori</label>
                    <select name="kategori" class="ei-input ei-select">
                        <option {{ $data->kategori == 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option {{ $data->kategori == 'Iuran' ? 'selected' : '' }}>Iuran</option>
                        <option {{ $data->kategori == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option {{ $data->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    </select>
                </div>

                <div class="ei-field">
                    <label class="ei-label"><i class="fas fa-toggle-on me-1"></i> Status</label>
                    <label class="ei-toggle-wrap">
                        <input type="checkbox" name="is_penting"
                            {{ $data->is_penting ? 'checked' : '' }}
                            class="ei-checkbox" id="isPenting">
                        <div class="ei-toggle-box">
                            <div class="ei-toggle-thumb"></div>
                        </div>
                        <span class="ei-toggle-label">Tandai sebagai Penting</span>
                    </label>
                </div>

                <div class="ei-field">
                    <label class="ei-label"><i class="fas fa-image me-1"></i> Upload Gambar</label>
                    @if($data->gambar ?? false)
                        <img id="imgPreview"
                            src="{{ asset('informasi/' . $data->gambar) }}"
                            class="ei-img-preview mb-2">
                    @else
                        <img id="imgPreview" src="" class="ei-img-preview mb-2" style="display:none;">
                    @endif
                    <input type="file" name="gambar" class="ei-input ei-file"
                        accept="image/*" onchange="previewImg(this)">
                    <div class="ei-file-hint">JPG, PNG maks. 2MB</div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="ei-footer">
                <a href="{{ route('informasi.index') }}" class="ei-btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="ei-btn-save">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
*, *::before, *::after { box-sizing: border-box; }

.ei-wrapper { padding: 4px 0 40px; }

/* HERO */
.ei-hero {
    display: flex;
    align-items: center;
    gap: 16px;
    background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #10b981 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(6,78,59,0.2);
}

.ei-hero-icon {
    width: 48px; height: 48px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #fff; flex-shrink: 0;
}

.ei-hero-title {
    font-size: 19px; font-weight: 800; color: #fff; margin-bottom: 3px;
}

.ei-hero-sub { font-size: 13px; color: rgba(255,255,255,0.7); }

/* CARD */
.ei-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

.ei-card-header {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 28px;
    border-bottom: 1px solid #f3f4f6;
    background: #f9fafb;
}

.ei-header-icon {
    width: 38px; height: 38px;
    background: #ecfdf5; color: #064e3b;
    border: 1px solid #d1fae5;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}

.ei-card-title { font-size: 15px; font-weight: 800; color: #1f2937; }
.ei-card-sub { font-size: 12px; color: #9ca3af; margin-top: 2px; }

/* FORM */
.ei-form { padding: 24px 28px; }

.ei-section-label {
    font-size: 11.5px; font-weight: 700;
    color: #064e3b; text-transform: uppercase;
    letter-spacing: 0.7px; margin-bottom: 16px;
    display: flex; align-items: center; gap: 4px;
}
.ei-section-label--mt { margin-top: 24px; }

.ei-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.ei-field {
    display: flex; flex-direction: column; gap: 6px;
    margin-bottom: 16px;
}

.ei-grid-2 .ei-field { margin-bottom: 0; }

.ei-label { font-size: 12.5px; font-weight: 600; color: #4b5563; }

.ei-input {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13.5px; color: #1f2937;
    background: #fafafa;
    outline: none;
    transition: all 0.2s;
    font-family: inherit;
}

.ei-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
    background: #fff;
}

.ei-textarea { resize: vertical; min-height: 110px; }
.ei-select { cursor: pointer; }
.ei-file { padding: 8px 14px; cursor: pointer; }
.ei-file-hint { font-size: 11.5px; color: #9ca3af; }

.ei-img-preview {
    width: 120px; height: 80px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #d1fae5;
    display: block;
}

/* TOGGLE */
.ei-toggle-wrap {
    display: flex; align-items: center; gap: 10px;
    cursor: pointer; padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px; background: #fafafa;
    transition: all 0.2s;
}

.ei-toggle-wrap:hover { border-color: #10b981; background: #f0fdf4; }

.ei-checkbox { display: none; }

.ei-toggle-box {
    width: 40px; height: 22px;
    background: #d1d5db;
    border-radius: 100px;
    position: relative;
    transition: background 0.2s;
    flex-shrink: 0;
}

.ei-toggle-thumb {
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.2s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}

.ei-checkbox:checked + .ei-toggle-box {
    background: #10b981;
}

.ei-checkbox:checked + .ei-toggle-box .ei-toggle-thumb {
    transform: translateX(18px);
}

.ei-toggle-label { font-size: 13px; font-weight: 600; color: #374151; }

/* FOOTER */
.ei-footer {
    display: flex; justify-content: flex-end; align-items: center;
    gap: 10px; margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid #f3f4f6;
}

.ei-btn-back {
    padding: 10px 20px;
    background: #f3f4f6; color: #4b5563;
    border: none; border-radius: 10px;
    font-size: 13px; font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.ei-btn-back:hover { background: #e5e7eb; color: #1f2937; }

.ei-btn-save {
    padding: 10px 24px;
    background: linear-gradient(135deg, #064e3b, #10b981);
    color: #fff; border: none; border-radius: 10px;
    font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
    transition: all 0.2s;
}
.ei-btn-save:hover {
    opacity: 0.9; transform: translateY(-1px);
}
</style>

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const preview = document.getElementById('imgPreview');
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}
</script>

@endsection

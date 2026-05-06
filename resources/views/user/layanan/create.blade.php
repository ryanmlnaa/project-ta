@extends('layouts.app')

@section('content')

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="pengaduan-wrapper">

    <div class="pengaduan-card">

        {{-- HEADER --}}
        <div class="pengaduan-header">
            <div class="header-icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <div>
                <h5 class="header-title">Formulir Pengaduan Online</h5>
                <p class="header-subtitle">Sampaikan keluhan Anda kepada kami</p>
            </div>
        </div>

        <div class="pengaduan-body">

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('user.layanan.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="form-grid">

                    {{-- KIRI = PREVIEW --}}
                    <div class="preview-column">
                        <div class="preview-box" id="preview-box">
                            <div class="preview-placeholder" id="preview-placeholder">
                                <div class="preview-icon-wrap">
                                    <i class="fas fa-image"></i>
                                </div>
                                <p class="preview-label">Preview gambar</p>
                                <p class="preview-sub">akan tampil di sini</p>
                            </div>
                            <img id="preview"
                                 class="preview-img d-none"
                                 src=""
                                 alt="Preview Gambar"/>
                        </div>

                        {{-- TIPS CARD --}}
                        <div class="tips-card">
                            <p class="tips-title"><i class="fas fa-lightbulb me-2"></i>Tips Pengaduan</p>
                            <ul class="tips-list">
                                <li>Deskripsikan masalah secara jelas</li>
                                <li>Sertakan lokasi kejadian</li>
                                <li>Lampirkan foto sebagai bukti</li>
                            </ul>
                        </div>
                    </div>

                    {{-- KANAN = FORM --}}
                    <div class="form-column">

                        {{-- KATEGORI --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-tag me-1 label-icon"></i>
                                Kategori Pengaduan
                            </label>
                            <div class="select-wrapper">
                                <select name="kategori_masalah" class="form-field" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="kebersihan">🧹 Kebersihan</option>
                                    <option value="keamanan">🚨 Keamanan</option>
                                    <option value="fasilitas">🏠 Fasilitas</option>
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-align-left me-1 label-icon"></i>
                                Deskripsi Masalah
                            </label>
                            <textarea name="deskripsi"
                                      class="form-field textarea-field"
                                      rows="6"
                                      id="deskripsiField"
                                      placeholder="Jelaskan masalah secara detail..."
                                      required></textarea>
                            <div class="char-counter">
                                <span id="charCount">0</span> karakter
                            </div>
                        </div>

                        {{-- UPLOAD --}}
                        <div class="field-group">
                            <label class="field-label">
                                <i class="fas fa-cloud-upload-alt me-1 label-icon"></i>
                                Upload Gambar
                                <span class="optional-badge">Opsional</span>
                            </label>
                            <div class="upload-box" id="upload-box">
                                <input type="file"
                                       name="foto"
                                       id="fotoInput"
                                       class="upload-input"
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                <div class="upload-content" id="upload-content">
                                    <div class="upload-icon-circle">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <p class="upload-main-text">Klik atau drag gambar ke sini</p>
                                    <p class="upload-sub-text">PNG, JPG, JPEG hingga 2MB</p>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="btn-row">
                            <button type="reset" class="btn-reset" onclick="resetForm()">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Pengaduan
                            </button>
                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>

</div>

{{-- ========== STYLE ========== --}}
<style>
*, *::before, *::after { box-sizing: border-box; }

.pengaduan-wrapper {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 2rem 1.5rem;
    min-height: 100vh;
    background: #f0f4f8;
}

/* ---- CARD ---- */
.pengaduan-card {
    max-width: 1000px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* ---- HEADER ---- */
.pengaduan-header {
    background: linear-gradient(135deg, #064e3b 0%, #0a6b52 60%, #0d7a5f 100%);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.pengaduan-header::before {
    content: '';
    position: absolute;
    right: -40px; top: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}

.pengaduan-header::after {
    content: '';
    position: absolute;
    right: 80px; bottom: -50px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}

.header-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
    border: 1.5px solid rgba(255,255,255,0.25);
    position: relative;
    z-index: 1;
}

.header-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #ffffff;
    position: relative;
    z-index: 1;
}

.header-subtitle {
    margin: 2px 0 0;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.65);
    font-weight: 500;
    position: relative;
    z-index: 1;
}

/* ---- BODY ---- */
.pengaduan-body {
    padding: 2rem;
}

/* ---- ALERT ---- */
.alert-error {
    background: #fff1f2;
    border: 1.5px solid #fda4af;
    border-radius: 12px;
    padding: 14px 18px;
    color: #be123c;
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

/* ---- GRID ---- */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 2rem;
}

@media (max-width: 768px) {
    .form-grid { grid-template-columns: 1fr; }
    .pengaduan-body { padding: 1.25rem; }
}

/* ---- PREVIEW COLUMN ---- */
.preview-column {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.preview-box {
    background: #f9fafb;
    border: 2px dashed #d1d5db;
    border-radius: 16px;
    min-height: 230px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: border-color 0.3s;
    position: relative;
}

.preview-box.has-image {
    border-style: solid;
    border-color: #064e3b;
}

.preview-placeholder {
    text-align: center;
    padding: 2rem;
}

.preview-icon-wrap {
    width: 56px;
    height: 56px;
    background: #f0fdf4;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 22px;
    color: #064e3b;
    border: 1px solid #d1fae5;
}

.preview-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    margin: 0 0 4px;
}

.preview-sub {
    color: #9ca3af;
    font-size: 0.8rem;
    margin: 0;
}

.preview-img {
    width: 100%;
    height: 100%;
    max-height: 260px;
    object-fit: cover;
    border-radius: 14px;
}

/* ---- TIPS CARD ---- */
.tips-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px 18px;
}

.tips-title {
    font-weight: 700;
    color: #064e3b;
    font-size: 0.82rem;
    margin: 0 0 10px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.tips-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.tips-list li {
    font-size: 0.82rem;
    color: #374151;
    margin-bottom: 6px;
    position: relative;
    padding-left: 1.2rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.tips-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #064e3b;
    font-weight: 700;
}

/* ---- FORM COLUMN ---- */
.form-column {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* ---- FIELD GROUP ---- */
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 4px;
}

.label-icon {
    color: #064e3b;
    font-size: 0.78rem;
}

.optional-badge {
    margin-left: auto;
    font-size: 0.7rem;
    font-weight: 500;
    color: #6b7280;
    background: #f3f4f6;
    border-radius: 20px;
    padding: 2px 10px;
    border: 1px solid #e5e7eb;
}

/* ---- FORM FIELDS ---- */
.form-field {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 11px 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem;
    color: #1f2937;
    background: #fafafa;
    transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
    outline: none;
    appearance: none;
}

.form-field:focus {
    border-color: #064e3b;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
}

.form-field::placeholder { color: #9ca3af; }

.textarea-field { resize: vertical; min-height: 130px; }

/* ---- SELECT WRAPPER ---- */
.select-wrapper { position: relative; }

.select-wrapper .form-field {
    padding-right: 36px;
    cursor: pointer;
}

.select-arrow {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #064e3b;
    font-size: 12px;
    pointer-events: none;
}

/* ---- CHAR COUNTER ---- */
.char-counter {
    font-size: 0.75rem;
    color: #9ca3af;
    text-align: right;
}

/* ---- UPLOAD BOX ---- */
.upload-box {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background: #fafafa;
}

.upload-box:hover {
    border-color: #064e3b;
    background: #f9fafb;
}

.upload-input {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.upload-icon-circle {
    width: 48px;
    height: 48px;
    background: #f0fdf4;
    border: 1px solid #d1fae5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 20px;
    color: #064e3b;
    transition: background 0.3s;
}

.upload-box:hover .upload-icon-circle {
    background: #dcfce7;
}

.upload-main-text {
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    margin: 0 0 4px;
}

.upload-sub-text {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 0;
}

/* ---- BUTTONS ---- */
.btn-row {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.btn-reset {
    padding: 10px 20px;
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-reset:hover {
    border-color: #d1d5db;
    background: #f9fafb;
    color: #374151;
}

.btn-submit {
    padding: 10px 24px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.875rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-submit:hover {
    opacity: 0.9;
    box-shadow: 0 6px 20px rgba(6,78,59,0.4);
    transform: translateY(-1px);
}

.btn-submit:active { transform: translateY(0); }
</style>

{{-- ========== JS ========== --}}
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function () {
        const img = document.getElementById('preview');
        const placeholder = document.getElementById('preview-placeholder');
        const box = document.getElementById('preview-box');

        img.src = reader.result;
        img.classList.remove('d-none');
        placeholder.style.display = 'none';
        box.classList.add('has-image');
    };
    reader.readAsDataURL(file);
}

function resetForm() {
    const img = document.getElementById('preview');
    const placeholder = document.getElementById('preview-placeholder');
    const box = document.getElementById('preview-box');

    img.src = '';
    img.classList.add('d-none');
    placeholder.style.display = 'block';
    box.classList.remove('has-image');
    document.getElementById('charCount').textContent = '0';
}

document.getElementById('deskripsiField')?.addEventListener('input', function () {
    document.getElementById('charCount').textContent = this.value.length;
});
</script>

@endsection

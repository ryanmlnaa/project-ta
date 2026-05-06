@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* {
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

/* RESET BODY */
body {
    background: #f1f5f9 !important;
    margin: 0;
}

/* ─── HERO HEADER ─── */
.info-hero {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #059669 100%);
    padding: 2rem 2.5rem 2.2rem;
    display: flex;
    align-items: center;
    gap: 1.1rem;
    position: relative;
    overflow: hidden;
}

.info-hero::after {
    content: '';
    position: absolute;
    right: -60px;
    top: -60px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.info-hero::before {
    content: '';
    position: absolute;
    right: 80px;
    bottom: -80px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.hero-icon {
    width: 52px;
    height: 52px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
}

.hero-icon i {
    font-size: 1.4rem;
    color: #fff;
}

.hero-text h2 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
    letter-spacing: -0.01em;
}

.hero-text p {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.7);
    margin: 0;
}

/* ─── MAIN CONTENT ─── */
.page-body {
    width: 100%;
    max-width: 100%;
    padding: 2rem 2.5rem 3rem;
}

/* ─── FORM META CARD ─── */
.form-meta {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.meta-icon {
    width: 40px;
    height: 40px;
    background: #dcfce7;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.meta-icon i { color: #16a34a; font-size: 1rem; }

.meta-text h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 2px;
}

.meta-text p {
    font-size: 0.78rem;
    color: #64748b;
    margin: 0;
}

/* ─── SECTION CARDS ─── */
.section-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.section-header {
    padding: 0.9rem 1.75rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 9px;
}

.section-header i {
    color: #16a34a;
    font-size: 0.85rem;
}

.section-header span {
    font-size: 0.75rem;
    font-weight: 800;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.09em;
}

.section-body {
    padding: 1.75rem;
}

/* ─── FORM ELEMENTS ─── */
.field-group {
    margin-bottom: 1.4rem;
}

.field-group:last-child { margin-bottom: 0; }

.field-label {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
}

.field-label i {
    color: #6b7280;
    font-size: 0.78rem;
    width: 14px;
}

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

textarea.field-input {
    resize: vertical;
    min-height: 130px;
    line-height: 1.6;
}

select.field-input {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2316a34a' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
    cursor: pointer;
}

/* ─── TWO COLUMN GRID ─── */
.field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

@media (max-width: 768px) {
    .field-grid { grid-template-columns: 1fr; }
    .page-body { padding: 1.25rem 1rem 2rem; }
    .info-hero { padding: 1.5rem 1.25rem; }
}

/* ─── TOGGLE SWITCH ─── */
.toggle-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.85rem 1rem;
    background: #f8fafc;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
}

.toggle-row:hover { border-color: #22c55e; background: #f0fdf4; }

.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
    flex-shrink: 0;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.toggle-track {
    position: absolute;
    inset: 0;
    background: #cbd5e1;
    border-radius: 24px;
    transition: background 0.25s;
}

.toggle-switch input:checked ~ .toggle-track {
    background: #22c55e;
}

.toggle-thumb {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
}

.toggle-switch input:checked ~ .toggle-track ~ .toggle-thumb,
.toggle-switch input:checked + .toggle-track + .toggle-thumb {
    transform: translateX(20px);
}

.toggle-label {
    font-size: 0.88rem;
    font-weight: 600;
    color: #374151;
}

.toggle-hint {
    font-size: 0.75rem;
    color: #64748b;
    margin-left: auto;
}

/* ─── FILE UPLOAD ─── */
.upload-zone {
    border: 2px dashed #a7f3d0;
    border-radius: 12px;
    background: #f0fdf4;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s;
    position: relative;
}

.upload-zone:hover, .upload-zone.dragover {
    border-color: #16a34a;
    background: #dcfce7;
}

.upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

.upload-icon {
    width: 48px;
    height: 48px;
    background: #bbf7d0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    transition: transform 0.2s;
}

.upload-zone:hover .upload-icon { transform: translateY(-3px); }
.upload-icon i { color: #16a34a; font-size: 1.2rem; }

.upload-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
}

.upload-desc {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0 0 10px;
}

.upload-formats {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.fmt-tag {
    background: #fff;
    border: 1px solid #bbf7d0;
    color: #16a34a;
    font-size: 0.68rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 20px;
    letter-spacing: 0.05em;
}

/* PREVIEW GAMBAR */
.img-preview-box {
    display: none;
    margin-top: 12px;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #bbf7d0;
    position: relative;
}

.img-preview-box img {
    width: 100%;
    max-height: 180px;
    object-fit: cover;
    display: block;
}

.img-preview-box .img-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 26px;
    height: 26px;
    background: rgba(0,0,0,0.55);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    font-size: 0.7rem;
    border: none;
    transition: background 0.2s;
}

.img-preview-box .img-remove:hover { background: #ef4444; }

/* FILE CHOSEN */
.file-chosen {
    display: none;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 8px 12px;
}

.file-chosen.show { display: flex; }
.file-chosen i { color: #16a34a; font-size: 0.9rem; }
.file-chosen span {
    font-size: 0.8rem;
    font-weight: 600;
    color: #166534;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
}

/* ─── ALERT ─── */
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

.action-hint i { margin-right: 4px; }

.btn-row { display: flex; gap: 10px; align-items: center; }

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 0.65rem 1.3rem;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-cancel:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1e293b;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 0.7rem 1.75rem;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: #fff;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(22,163,74,0.3);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(22,163,74,0.38);
}

.btn-save:active { transform: translateY(0); }
</style>

{{-- ─── HERO HEADER ─── --}}
<div class="info-hero">
    <div class="hero-icon">
        <i class="fas fa-bullhorn"></i>
    </div>
    <div class="hero-text">
        <h2>Tambah Informasi</h2>
        <p>Buat pengumuman baru yang akan ditampilkan kepada warga</p>
    </div>
</div>

<div class="page-body">

    {{-- META CARD --}}
    <div class="form-meta">
        <div class="meta-icon">
            <i class="fas fa-pen-to-square"></i>
        </div>
        <div class="meta-text">
            <h3>Form Tambah Informasi</h3>
            <p>Lengkapi semua field yang diperlukan</p>
        </div>
    </div>

    <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert-err">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ─── SEKSI 1: KONTEN ─── --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-file-lines"></i>
                <span>Konten Informasi</span>
            </div>
            <div class="section-body">

                {{-- JUDUL --}}
                <div class="field-group">
                    <label class="field-label">
                        <i class="fas fa-heading"></i>
                        Judul Informasi
                    </label>
                    <input type="text" name="judul" class="field-input"
                           placeholder="Masukkan judul informasi..."
                           value="{{ old('judul') }}" required>
                </div>

                {{-- ISI --}}
                <div class="field-group">
                    <label class="field-label">
                        <i class="fas fa-align-left"></i>
                        Isi Informasi
                    </label>
                    <textarea name="isi" class="field-input"
                              placeholder="Tulis isi informasi di sini..." required>{{ old('isi') }}</textarea>
                </div>

            </div>
        </div>

        {{-- ─── SEKSI 2: DETAIL ─── --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-circle-info"></i>
                <span>Detail Informasi</span>
            </div>
            <div class="section-body">

                <div class="field-grid">

                    {{-- TANGGAL --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-calendar"></i>
                            Tanggal
                        </label>
                        <input type="date" name="tanggal" class="field-input"
                               value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-tag"></i>
                            Kategori
                        </label>
                        <select name="kategori" class="field-input" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Iuran" {{ old('kategori') == 'Iuran' ? 'selected' : '' }}>Iuran</option>
                            <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                            <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-circle-dot"></i>
                            Status
                        </label>
                        <label class="toggle-row">
                            <div class="toggle-switch">
                                <input type="checkbox" name="is_penting" id="toggle-penting"
                                       {{ old('is_penting') ? 'checked' : '' }}>
                                <div class="toggle-track"></div>
                                <div class="toggle-thumb"></div>
                            </div>
                            <span class="toggle-label">Tandai sebagai Penting</span>
                            <span class="toggle-hint" id="toggle-hint">Tidak aktif</span>
                        </label>
                    </div>

                    {{-- UPLOAD GAMBAR --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-image"></i>
                            Upload Gambar
                        </label>
                        <div class="upload-zone" id="upload-zone">
                            <input type="file" name="gambar" id="file-input" accept="image/*">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-arrow-up"></i>
                            </div>
                            <p class="upload-title">Klik atau Seret Gambar</p>
                            <p class="upload-desc">Format yang didukung:</p>
                            <div class="upload-formats">
                                <span class="fmt-tag">JPG</span>
                                <span class="fmt-tag">PNG</span>
                                <span class="fmt-tag">WEBP</span>
                            </div>
                        </div>

                        <div class="img-preview-box" id="img-preview-box">
                            <img id="preview-img" src="" alt="Preview">
                            <button type="button" class="img-remove" id="img-remove">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>

                        <div class="file-chosen" id="file-chosen">
                            <i class="fas fa-check-circle"></i>
                            <span id="file-name"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── ACTION BAR ─── --}}
        <div class="action-bar">
            <p class="action-hint">
                <i class="fas fa-asterisk" style="font-size:0.6rem; color:#ef4444;"></i>
                Semua field wajib diisi
            </p>
            <div class="btn-row">
                <a href="{{ route('informasi.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-floppy-disk"></i> Simpan Informasi
                </button>
            </div>
        </div>

    </form>
</div>

<script>
const fileInput    = document.getElementById('file-input');
const previewImg   = document.getElementById('preview-img');
const previewBox   = document.getElementById('img-preview-box');
const fileChosen   = document.getElementById('file-chosen');
const fileName     = document.getElementById('file-name');
const uploadZone   = document.getElementById('upload-zone');
const imgRemove    = document.getElementById('img-remove');
const togglePenting= document.getElementById('toggle-penting');
const toggleHint   = document.getElementById('toggle-hint');
const toggleThumb  = document.querySelector('.toggle-thumb');

function loadFile(file) {
    if (!file) return;
    previewImg.src = URL.createObjectURL(file);
    previewBox.style.display = 'block';
    fileName.textContent = file.name;
    fileChosen.classList.add('show');
    uploadZone.style.display = 'none';
}

fileInput.addEventListener('change', e => {
    loadFile(e.target.files[0]);
});

imgRemove.addEventListener('click', () => {
    fileInput.value = '';
    previewImg.src = '';
    previewBox.style.display = 'none';
    fileChosen.classList.remove('show');
    uploadZone.style.display = 'block';
});

uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        const dt = new DataTransfer();
        dt.items.add(e.dataTransfer.files[0]);
        fileInput.files = dt.files;
        loadFile(e.dataTransfer.files[0]);
    }
});

function updateToggle() {
    toggleHint.textContent = togglePenting.checked ? 'Aktif' : 'Tidak aktif';
    toggleHint.style.color = togglePenting.checked ? '#16a34a' : '#94a3b8';
    toggleThumb.style.transform = togglePenting.checked ? 'translateX(20px)' : 'translateX(0)';
}

togglePenting.addEventListener('change', updateToggle);
updateToggle();
</script>

@endsection

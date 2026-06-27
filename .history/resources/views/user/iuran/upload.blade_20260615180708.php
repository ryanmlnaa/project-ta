@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* {
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

.upload-page {
    min-height: 100vh;
    background: #f0f4f8;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 2.5rem 1rem;
}

.upload-wrapper {
    width: 100%;
    max-width: 860px;
}

/* BREADCRUMB */
.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.82rem;
    color: #64748b;
}

.breadcrumb-nav a {
    color: #16a34a;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: opacity 0.2s;
}

.breadcrumb-nav a:hover { opacity: 0.75; }

.breadcrumb-nav span { color: #94a3b8; }

/* MAIN CARD */
.main-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}

/* TOP ACCENT BAR */
.card-accent {
    height: 5px;
    background: linear-gradient(90deg, #16a34a 0%, #4ade80 100%);
}

/* CARD BODY */
.card-body {
    padding: 2.25rem 2.5rem 2.5rem;
}

/* PAGE TITLE */
.page-title-row {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 1.75rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f1f5f9;
}

.title-icon {
    width: 46px;
    height: 46px;
    background: #dcfce7;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #16a34a;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 0.82rem;
    color: #64748b;
    margin: 3px 0 0;
}

/* INFO BANNER */
.info-banner {
    display: grid;
    grid-template-columns: 1fr 1px 1fr 1px 1fr;
    gap: 0;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
    align-items: center;
}

.info-divider {
    background: #e2e8f0;
    height: 36px;
    margin: 0 1.5rem;
}

.info-item {}

.info-label {
    font-size: 0.72rem;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 4px;
}

.info-value {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
}

.info-value.green {
    color: #16a34a;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef9c3;
    color: #854d0e;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid #fde68a;
}

.status-pill i { font-size: 0.7rem; }

/* ALERT */
.alert-danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 0.9rem 1.1rem;
    color: #b91c1c;
    font-size: 0.88rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* UPLOAD GRID */
.upload-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.75rem;
    margin-bottom: 2rem;
}

@media (max-width: 640px) {
    .upload-grid { grid-template-columns: 1fr; }
    .info-banner { grid-template-columns: 1fr; }
    .info-divider { display: none; }
    .card-body { padding: 1.5rem; }
}

/* PREVIEW SIDE */
.preview-side {}

.preview-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 10px;
}

.preview-frame {
    border-radius: 14px;
    border: 1.5px dashed #cbd5e1;
    background: #f8fafc;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: border-color 0.2s;
    position: relative;
}

.preview-frame.has-image {
    border-style: solid;
    border-color: #bbf7d0;
    background: #fff;
}

.preview-placeholder {
    text-align: center;
}

.preview-placeholder i {
    font-size: 2.2rem;
    color: #cbd5e1;
    display: block;
    margin-bottom: 8px;
}

.preview-placeholder p {
    font-size: 0.8rem;
    color: #94a3b8;
    margin: 0;
}

#preview-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 12px;
    display: none;
}

/* UPLOAD SIDE */
.upload-side {}

.upload-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 10px;
}

.upload-zone {
    border-radius: 14px;
    border: 2px dashed #a7f3d0;
    background: #f0fdf4;
    height: 240px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    text-align: center;
    padding: 1.5rem;
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

.upload-icon-circle {
    width: 56px;
    height: 56px;
    background: #bbf7d0;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    transition: transform 0.2s;
}

.upload-zone:hover .upload-icon-circle {
    transform: translateY(-3px);
}

.upload-icon-circle i {
    font-size: 1.4rem;
    color: #16a34a;
}

.upload-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 5px;
}

.upload-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0 0 12px;
    line-height: 1.5;
}

.upload-formats {
    display: flex;
    gap: 6px;
    justify-content: center;
    flex-wrap: wrap;
}

.format-tag {
    background: #fff;
    border: 1px solid #bbf7d0;
    color: #16a34a;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 20px;
    letter-spacing: 0.04em;
}

/* FILE CHOSEN INDICATOR */
.file-chosen {
    display: none;
    align-items: center;
    gap: 8px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 10px 14px;
    margin-top: 12px;
}

.file-chosen.show { display: flex; }

.file-chosen i { color: #16a34a; font-size: 1rem; }

.file-chosen span {
    font-size: 0.82rem;
    font-weight: 600;
    color: #166534;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

/* TIPS */
.tips-box {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.75rem;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

.tips-box i {
    color: #d97706;
    margin-top: 2px;
    flex-shrink: 0;
}

.tips-box p {
    font-size: 0.82rem;
    color: #92400e;
    margin: 0;
    line-height: 1.55;
}

.tips-box strong { font-weight: 700; }

/* ACTION ROW */
.action-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid #f1f5f9;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.7rem 1.4rem;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1e293b;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: #fff;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 16px rgba(22,163,74,0.28);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(22,163,74,0.38);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit i { font-size: 0.95rem; }
</style>

<div class="upload-page">
    <div class="upload-wrapper">

        {{-- BREADCRUMB --}}
        <div class="breadcrumb-nav">
            <a href="{{ route('user.iuran') }}">
                <i class="fas fa-chevron-left" style="font-size:0.7rem;"></i>
                Iuran Saya
            </a>
            <span>/</span>
            <span>Upload Bukti Pembayaran</span>
        </div>

        <div class="main-card">
            <div class="card-accent"></div>
            <div class="card-body">

                {{-- JUDUL --}}
                <div class="page-title-row">
                    <div class="title-icon">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <div>
                        <p class="page-title">Upload Bukti Pembayaran</p>
                        <p class="page-subtitle">Lampirkan foto atau scan bukti transfer iuran Anda</p>
                    </div>
                </div>

                {{-- INFO IURAN --}}
                <div class="info-banner" style="grid-template-columns: 1fr 1px 1fr 1px 1fr 1px 1fr;">
                    <div class="info-item">
                        <p class="info-label">Bulan</p>
                        <p class="info-value">{{ $iuran->bulan }} {{ $iuran->tahun }}</p>
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-item">
                        <p class="info-label">Jumlah Tagihan</p>
                        <p class="info-value green">Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-item">
                        <p class="info-label">Jenis Iuran</p>
                        <p class="info-value">{{ $iuran->jenis_iuran ?? '-' }}</p>
                    </div>
                    <div class="info-divider"></div>
                    <div class="info-item">
                        <p class="info-label">Status</p>
                        <div class="status-pill">
                            <i class="fas fa-clock"></i>
                            Menunggu Konfirmasi RT
                        </div>
                    </div>
                </div>

                {{-- KETERANGAN --}}
                @if($iuran->keterangan)
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:12px 16px; margin-bottom:1.5rem; display:flex; gap:10px; align-items:flex-start;">
                    <i class="fas fa-info-circle" style="color:#16a34a; margin-top:2px; flex-shrink:0;"></i>
                    <div>
                        <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#16a34a; margin:0 0 3px;">Keterangan dari RT</p>
                        <p style="font-size:13px; color:#166534; margin:0; line-height:1.5;">{{ $iuran->keterangan }}</p>
                    </div>
                </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('user.iuran.storeUpload', $iuran->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- GRID UPLOAD --}}
                    <div class="upload-grid">

                        {{-- PREVIEW --}}
                        <div class="preview-side">
                            <p class="preview-label"><i class="fas fa-image me-1"></i> Pratinjau Gambar</p>
                            <div class="preview-frame" id="preview-frame">
                                <div class="preview-placeholder" id="preview-placeholder">
                                    <i class="fas fa-image"></i>
                                    <p>Gambar akan muncul di sini</p>
                                </div>
                                <img id="preview-img" src="" alt="Preview bukti pembayaran" />
                            </div>
                        </div>

                        {{-- UPLOAD ZONE --}}
                        <div class="upload-side">
                            <p class="upload-label"><i class="fas fa-cloud-upload-alt me-1"></i> Pilih File</p>
                            <div class="upload-zone" id="upload-zone">
                                <input type="file" name="bukti_pembayaran"
                                       id="file-input"
                                       accept="image/*" required>
                                <div class="upload-icon-circle">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <p class="upload-title">Klik atau Seret File</p>
                                <p class="upload-desc">Pilih foto bukti transfer dari<br>galeri atau kamera Anda</p>
                                <div class="upload-formats">
                                    <span class="format-tag">JPG</span>
                                    <span class="format-tag">PNG</span>
                                    <span class="format-tag">WEBP</span>
                                    <span class="format-tag">HEIC</span>
                                </div>
                            </div>
                            <div class="file-chosen" id="file-chosen">
                                <i class="fas fa-check-circle"></i>
                                <span id="file-name">nama-file.jpg</span>
                            </div>
                        </div>

                    </div>

                    {{-- TIPS --}}
                    <div class="tips-box">
                        <i class="fas fa-lightbulb"></i>
                        <p>
                            <strong>Tips:</strong> Pastikan foto bukti transfer terlihat jelas,
                            nominal dan nama tujuan transfer terbaca, serta tidak terpotong.
                            Ukuran file maksimal <strong>2 MB</strong>.
                        </p>
                    </div>

                    {{-- ACTION --}}
                    <div class="action-row">
                        <a href="{{ route('user.iuran') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Bukti Pembayaran
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
const fileInput   = document.getElementById('file-input');
const previewImg  = document.getElementById('preview-img');
const previewFrame= document.getElementById('preview-frame');
const placeholder = document.getElementById('preview-placeholder');
const fileChosen  = document.getElementById('file-chosen');
const fileName    = document.getElementById('file-name');
const uploadZone  = document.getElementById('upload-zone');

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const url = URL.createObjectURL(file);
    previewImg.src = url;
    previewImg.style.display = 'block';
    placeholder.style.display = 'none';
    previewFrame.classList.add('has-image');

    fileName.textContent = file.name;
    fileChosen.classList.add('show');
});

uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});

uploadZone.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragover');
});

uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        const dt = new DataTransfer();
        dt.items.add(e.dataTransfer.files[0]);
        fileInput.files = dt.files;
        fileInput.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection

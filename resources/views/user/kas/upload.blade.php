@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.uk-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f0f4f0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.uk-card {
    background: #fff;
    border-radius: 22px;
    width: 100%;
    max-width: 440px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.06);
}

.uk-header {
    background: linear-gradient(135deg, #0f2d0f 0%, #1a5c1a 50%, #22a022 100%);
    padding: 28px 28px 22px;
    text-align: center;
}
.uk-header-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.15);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
    margin: 0 auto 14px;
}
.uk-header h4 { color: #fff; font-size: 18px; font-weight: 800; margin: 0 0 4px; }
.uk-header p { color: rgba(255,255,255,0.65); font-size: 12.5px; margin: 0; }

.uk-body { padding: 26px 28px 28px; }

.uk-info-box {
    background: #f8faf8;
    border: 1.5px dashed #c8e6c8;
    border-radius: 16px;
    padding: 16px 18px;
    margin-bottom: 22px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.uk-info-icon {
    width: 42px; height: 42px;
    background: #ede9fe; color: #6d28d9;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}
.uk-info-label { font-size: 11px; color: #9aaa9a; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
.uk-info-title { font-size: 14.5px; font-weight: 700; color: #1a2a1a; margin-bottom: 2px; }
.uk-info-amount { font-family: 'DM Mono', monospace; font-size: 15px; font-weight: 700; color: #15803d; }

.uk-label { font-size: 13px; font-weight: 600; color: #4a5a4a; margin-bottom: 8px; display: block; }

.uk-dropzone {
    border: 2px dashed #c8e6c8;
    border-radius: 16px;
    padding: 28px 20px;
    text-align: center;
    background: #f8faf8;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    margin-bottom: 22px;
}
.uk-dropzone:hover { background: #f0fdf4; border-color: #86d99a; }
.uk-dropzone.has-file { border-color: #22c55e; background: #f0fdf4; }
.uk-dropzone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.uk-dropzone-icon { font-size: 26px; color: #16a34a; margin-bottom: 10px; }
.uk-dropzone-text { font-size: 13.5px; font-weight: 600; color: #2a3a2a; margin-bottom: 3px; }
.uk-dropzone-sub { font-size: 11.5px; color: #9aaa9a; }
.uk-filename { font-size: 12.5px; color: #15803d; font-weight: 600; margin-top: 8px; word-break: break-all; }

.uk-preview {
    margin-top: 14px;
    border-radius: 12px;
    overflow: hidden;
    display: none;
    border: 1px solid #e8f0e8;
}
.uk-preview img { width: 100%; display: block; max-height: 220px; object-fit: contain; background: #fafafa; }

.uk-btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #0f2d0f, #1a6c1a);
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 16px rgba(22,163,74,0.3);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.uk-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(22,163,74,0.4); }

.uk-back {
    display: block;
    text-align: center;
    margin-top: 16px;
    font-size: 12.5px;
    color: #7a8a7a;
    text-decoration: none;
    font-weight: 500;
}
.uk-back:hover { color: #1a5c1a; }
</style>

<div class="uk-wrap">
    <div class="uk-card">

        <div class="uk-header">
            <div class="uk-header-icon"><i class="fas fa-receipt"></i></div>
            <h4>Upload Bukti Bayar Kas</h4>
            <p>Lampirkan bukti transfer untuk konfirmasi bendahara</p>
        </div>

        <div class="uk-body">

            <div class="uk-info-box">
                <div class="uk-info-icon"><i class="fas fa-coins"></i></div>
                <div>
                    <div class="uk-info-label">Tagihan Kas</div>
                    <div class="uk-info-title">{{ $kas->keterangan }}</div>
                    <div class="uk-info-amount">Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</div>
                </div>
            </div>

            <form action="{{ route('user.kas.storeUpload', $kas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label class="uk-label">Bukti Transfer</label>
                <div class="uk-dropzone" id="dropzone">
                    <div class="uk-dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="uk-dropzone-text">Klik atau seret gambar ke sini</div>
                    <div class="uk-dropzone-sub">JPG atau PNG, maksimal 2MB</div>
                    <div class="uk-filename" id="filename"></div>
                    <input type="file" name="bukti_pembayaran" id="fileInput" accept="image/*" required>
                </div>

                <div class="uk-preview" id="preview">
                    <img id="previewImg" src="" alt="Preview">
                </div>

                <button type="submit" class="uk-btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                </button>
            </form>

            <a href="{{ route('user.iuran.index') }}" class="uk-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat Iuran
            </a>

        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById('fileInput');
const dropzone  = document.getElementById('dropzone');
const filename  = document.getElementById('filename');
const preview   = document.getElementById('preview');
const previewImg = document.getElementById('previewImg');

fileInput.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        filename.textContent = '📎 ' + file.name;
        dropzone.classList.add('has-file');

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection

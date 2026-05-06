@extends('layouts.app')

@section('content')

@php
    $isEditPenghuni = isset($penghuni) && $penghuni && isset($penghuni->id);
    $isEditRumah = isset($rumah) && is_object($rumah);
@endphp

<div class="ep-wrapper">

    {{-- HERO --}}
    <div class="ep-hero">
        <div class="ep-hero-icon">
            <i class="fas {{ $isEditPenghuni ? 'fa-user-edit' : 'fa-home' }}"></i>
        </div>
        <div>
            <div class="ep-hero-title">
                {{ $isEditPenghuni ? 'Edit Data Penghuni' : 'Edit Data Rumah' }}
            </div>
            <div class="ep-hero-sub">
                {{ $isEditPenghuni ? 'Perbarui informasi data penghuni' : 'Perbarui informasi data rumah' }}
            </div>
        </div>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="ep-alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ep-card">

        {{-- ========================= --}}
        {{-- FORM PENGHUNI --}}
        {{-- ========================= --}}
        @if($isEditPenghuni)

        <div class="ep-card-header">
            <div class="ep-card-header-icon"><i class="fas fa-user"></i></div>
            <div>
                <div class="ep-card-title">Informasi Penghuni</div>
                <div class="ep-card-sub">Lengkapi semua field yang diperlukan</div>
            </div>
        </div>

        <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST" class="ep-form">
            @csrf
            @method('PUT')

            <div class="ep-section-label">
                <i class="fas fa-id-card me-1"></i> Data Pribadi
            </div>

            <div class="ep-grid-2">
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-user me-1"></i> Nama Lengkap</label>
                    <input type="text" name="nama" class="ep-input"
                        value="{{ old('nama', $penghuni->nama) }}" placeholder="Masukkan nama lengkap">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-id-badge me-1"></i> No KTP</label>
                    <input type="text" name="no_ktp" class="ep-input"
                        value="{{ old('no_ktp', $penghuni->no_ktp) }}" placeholder="16 digit NIK">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-envelope me-1"></i> Email</label>
                    <input type="email" name="email" class="ep-input"
                        value="{{ old('email', $penghuni->email) }}" placeholder="email@contoh.com">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-phone me-1"></i> No HP</label>
                    <input type="text" name="telepon" class="ep-input"
                        value="{{ old('telepon', $penghuni->telepon) }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="ep-field ep-field--full">
                    <label class="ep-label"><i class="fas fa-map-marker-alt me-1"></i> Alamat</label>
                    <input type="text" name="alamat" class="ep-input"
                        value="{{ old('alamat', $penghuni->alamat) }}" placeholder="Alamat lengkap">
                </div>
            </div>

            <div class="ep-section-label ep-section-label--mt">
                <i class="fas fa-home me-1"></i> Data Hunian
            </div>

            <div class="ep-grid-2">
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-building me-1"></i> Pilih Rumah</label>
                    <select name="rumah_id" class="ep-input ep-select">
                        <option value="">-- Pilih Rumah --</option>
                        @foreach($rumahList as $r)
                            <option value="{{ $r->id }}"
                                {{ $penghuni->rumah_id == $r->id ? 'selected' : '' }}>
                                {{ $r->blok }} - {{ $r->no_rumah }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-toggle-on me-1"></i> Status</label>
                    <select name="status" class="ep-input ep-select">
                        <option value="Aktif" {{ $penghuni->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $penghuni->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-house-user me-1"></i> Status Huni</label>
                    <select name="status_huni" id="statusHuni" class="ep-input ep-select">
                        <option value="Tetap" {{ $penghuni->status_huni == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="Kontrak" {{ $penghuni->status_huni == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    </select>
                </div>
                <div class="ep-field" id="tanggalKeluarField"
                    style="{{ $penghuni->status_huni == 'Kontrak' ? '' : 'display:none;' }}">
                    <label class="ep-label"><i class="fas fa-calendar-alt me-1"></i> Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="ep-input"
                        value="{{ $penghuni->tanggal_keluar }}">
                </div>
            </div>

            <div class="ep-footer">
                <a href="{{ route('penghuni.index') }}" class="ep-btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="ep-btn-save">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>

        {{-- ========================= --}}
        {{-- FORM RUMAH --}}
        {{-- ========================= --}}
        @elseif($isEditRumah)

        <div class="ep-card-header">
            <div class="ep-card-header-icon"><i class="fas fa-home"></i></div>
            <div>
                <div class="ep-card-title">Informasi Rumah</div>
                <div class="ep-card-sub">Lengkapi semua field yang diperlukan</div>
            </div>
        </div>

        <form action="{{ route('admin.rumah.update', $rumah->id) }}" method="POST"
              enctype="multipart/form-data" class="ep-form">
            @csrf
            @method('PUT')

            <div class="ep-section-label">
                <i class="fas fa-info-circle me-1"></i> Detail Rumah
            </div>

            <div class="ep-grid-2">
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-th me-1"></i> Blok</label>
                    <input type="text" name="blok" class="ep-input" value="{{ $rumah->blok }}" placeholder="Contoh: A, B, D32">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-hashtag me-1"></i> No Rumah</label>
                    <input type="text" name="no_rumah" class="ep-input" value="{{ $rumah->no_rumah }}" placeholder="Nomor rumah">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-toggle-on me-1"></i> Status</label>
                    <select name="status" class="ep-input ep-select">
                        <option value="Kosong" {{ $rumah->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                        <option value="Terisi" {{ $rumah->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
                    </select>
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-ruler-combined me-1"></i> Luas Tanah (m²)</label>
                    <input type="number" name="luas_tanah" class="ep-input" value="{{ $rumah->luas_tanah }}" placeholder="0">
                </div>
                <div class="ep-field">
                    <label class="ep-label"><i class="fas fa-money-bill-wave me-1"></i> Harga</label>
                    <input type="number" name="harga" class="ep-input" value="{{ $rumah->harga }}" placeholder="0">
                </div>
                <div class="ep-field ep-field--full">
                    <label class="ep-label"><i class="fas fa-align-left me-1"></i> Keterangan</label>
                    <textarea name="keterangan" class="ep-input ep-textarea" rows="3"
                        placeholder="Keterangan tambahan...">{{ $rumah->keterangan }}</textarea>
                </div>
                <div class="ep-field ep-field--full">
                    <label class="ep-label"><i class="fas fa-camera me-1"></i> Foto Rumah</label>
                    @if($rumah->foto)
                        <img id="previewEdit" src="{{ asset('foto_rumah/'.$rumah->foto) }}"
                            class="ep-img-preview mb-2">
                    @endif
                    <input type="file" name="foto" id="fotoEdit" class="ep-input ep-file"
                        onchange="previewFoto(this)">
                    <div class="ep-file-hint">JPG, PNG maks. 2MB</div>
                </div>
            </div>

            <div class="ep-footer">
                <a href="{{ route('penghuni.index') }}" class="ep-btn-back">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="ep-btn-save">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>

        @endif

    </div>
</div>

<style>
*, *::before, *::after { box-sizing: border-box; }

.ep-wrapper {
    padding: 4px 0 40px;
}

/* HERO */
.ep-hero {
    display: flex;
    align-items: center;
    gap: 16px;
    background: linear-gradient(135deg, #064e3b 0%, #047857 55%, #10b981 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(4,120,87,0.2);
}

.ep-hero-icon {
    width: 48px; height: 48px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #fff; flex-shrink: 0;
}

.ep-hero-title {
    font-size: 19px; font-weight: 800; color: #fff; margin-bottom: 3px;
}

.ep-hero-sub {
    font-size: 13px; color: rgba(255,255,255,0.7);
}

/* ALERT */
.ep-alert {
    display: flex; align-items: flex-start;
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: 12px; padding: 14px 18px;
    color: #dc2626; font-size: 13px; margin-bottom: 20px;
}

/* CARD */
.ep-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    overflow: hidden;
}

.ep-card-header {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 28px;
    border-bottom: 1px solid #f3f4f6;
    background: #f9fafb;
}

.ep-card-header-icon {
    width: 38px; height: 38px;
    background: #ecfdf5; color: #047857;
    border: 1px solid #d1fae5;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}

.ep-card-title {
    font-size: 15px; font-weight: 800; color: #1f2937;
}

.ep-card-sub {
    font-size: 12px; color: #9ca3af; margin-top: 2px;
}

/* FORM */
.ep-form { padding: 24px 28px; }

.ep-section-label {
    font-size: 11.5px; font-weight: 700;
    color: #047857; text-transform: uppercase;
    letter-spacing: 0.7px; margin-bottom: 16px;
    display: flex; align-items: center; gap: 4px;
}

.ep-section-label--mt { margin-top: 24px; }

.ep-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.ep-field { display: flex; flex-direction: column; gap: 6px; }
.ep-field--full { grid-column: 1 / -1; }

.ep-label {
    font-size: 12.5px; font-weight: 600; color: #4b5563;
}

.ep-input {
    width: 100%; padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13.5px; color: #1f2937;
    background: #fafafa;
    outline: none;
    transition: all 0.2s;
    font-family: inherit;
}

.ep-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
    background: #fff;
}

.ep-select { cursor: pointer; }

.ep-textarea { resize: vertical; min-height: 90px; }

.ep-img-preview {
    width: 120px; height: 90px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #d1fae5;
    display: block;
}

.ep-file { padding: 8px 14px; cursor: pointer; }

.ep-file-hint {
    font-size: 11.5px; color: #9ca3af; margin-top: 2px;
}

/* FOOTER */
.ep-footer {
    display: flex; justify-content: flex-end; align-items: center;
    gap: 10px; margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid #f3f4f6;
}

.ep-btn-back {
    padding: 10px 20px;
    background: #f3f4f6; color: #4b5563;
    border: none; border-radius: 10px;
    font-size: 13px; font-weight: 600;
    text-decoration: none;
    transition: all 0.2s; cursor: pointer;
    font-family: inherit;
}

.ep-btn-back:hover { background: #e5e7eb; color: #1f2937; }

.ep-btn-save {
    padding: 10px 24px;
    background: linear-gradient(135deg, #047857, #10b981);
    color: #fff; border: none; border-radius: 10px;
    font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 14px rgba(4,120,87,0.25);
    transition: all 0.2s;
}

.ep-btn-save:hover {
    opacity: 0.9; transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(4,120,87,0.32);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const statusHuni = document.getElementById('statusHuni');
    const tanggalKeluarField = document.getElementById('tanggalKeluarField');

    if (statusHuni) {
        statusHuni.addEventListener('change', function () {
            tanggalKeluarField.style.display = this.value === 'Kontrak' ? 'block' : 'none';
        });
    }
});

function previewFoto(input) {
    if (input.files && input.files[0]) {
        let preview = document.getElementById('previewEdit');
        if (!preview) {
            preview = document.createElement('img');
            preview.id = 'previewEdit';
            preview.className = 'ep-img-preview mb-2';
            input.parentNode.insertBefore(preview, input);
        }
        preview.src = URL.createObjectURL(input.files[0]);
    }
}
</script>

@endsection

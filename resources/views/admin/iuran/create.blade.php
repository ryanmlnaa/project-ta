@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* {
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

body {
    background: #f1f5f9 !important;
    margin: 0;
}

/* ─── HERO HEADER ─── */
.iuran-hero {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #059669 100%);
    padding: 2rem 2.5rem 2.2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.iuran-hero::after {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.iuran-hero::before {
    content: '';
    position: absolute;
    right: 80px; bottom: -80px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.hero-left {
    display: flex;
    align-items: center;
    gap: 1.1rem;
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

.btn-back {
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

.btn-back:hover {
    background: rgba(255,255,255,0.28);
    border-color: rgba(255,255,255,0.6);
    color: #fff;
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
}

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

.field-grid.full { grid-template-columns: 1fr; }

@media (max-width: 768px) {
    .field-grid { grid-template-columns: 1fr; }
    .page-body { padding: 1.25rem 1rem 2rem; }
    .iuran-hero { padding: 1.5rem 1.25rem; }
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

textarea.field-input {
    resize: vertical;
    min-height: 110px;
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

select.field-input option { color: #0f172a; }

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

/* ERROR */
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
</style>

{{-- ─── HERO ─── --}}
<div class="iuran-hero">
    <div class="hero-left">
        <div class="hero-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="hero-text">
            <h2>Tambah Iuran</h2>
            <p>Tambahkan data iuran baru untuk penghuni</p>
        </div>
    </div>
    <a href="{{ route('iuran.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="page-body">

    {{-- META --}}
    <div class="form-meta">
        <div class="meta-icon"><i class="fas fa-pen-to-square"></i></div>
        <div class="meta-text">
            <h3>Form Tambah Iuran</h3>
            <p>Lengkapi semua field yang diperlukan</p>
        </div>
    </div>

    <form action="{{ route('iuran.store') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div class="alert-err">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- SEKSI 1: DATA PENGHUNI --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-user"></i>
                <span>Data Penghuni</span>
            </div>
            <div class="section-body">
                <div class="field-grid">

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-user"></i> Nama Penghuni
                        </label>
                        <select name="penghuni_id" class="field-input" required>
                            <option value="">-- Pilih Penghuni --</option>
                            @foreach($penghuni as $p)
                                <option value="{{ $p->id }}" {{ old('penghuni_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-tag"></i> Jenis Iuran
                        </label>
                        <select name="jenis_iuran" class="field-input" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Keamanan"  {{ old('jenis_iuran')=='Keamanan'  ? 'selected':'' }}>Keamanan</option>
                            <option value="Kebersihan"{{ old('jenis_iuran')=='Kebersihan'? 'selected':'' }}>Kebersihan</option>
                            <option value="Air"       {{ old('jenis_iuran')=='Air'       ? 'selected':'' }}>Air</option>
                            <option value="Sampah"    {{ old('jenis_iuran')=='Sampah'    ? 'selected':'' }}>Sampah</option>
                            <option value="Listrik"   {{ old('jenis_iuran')=='Listrik'   ? 'selected':'' }}>Listrik</option>
                            <option value="Lainnya"   {{ old('jenis_iuran')=='Lainnya'   ? 'selected':'' }}>Lainnya</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- SEKSI 2: DETAIL IURAN --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-circle-info"></i>
                <span>Detail Iuran</span>
            </div>
            <div class="section-body">
                <div class="field-grid" style="margin-bottom: 1.25rem;">

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-calendar"></i> Bulan
                        </label>
                        <select name="bulan" class="field-input" required>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                <option value="{{ $bln }}" {{ old('bulan')==$bln ? 'selected':'' }}>{{ $bln }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-calendar-days"></i> Tahun
                        </label>
                        <select name="tahun" class="field-input" required>
                            @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                <option value="{{ $y }}" {{ old('tahun', date('Y'))==$y ? 'selected':'' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                </div>

                <div class="field-grid">

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-money-bill"></i> Jumlah Iuran
                        </label>
                        <input type="number" name="jumlah" class="field-input"
                               placeholder="0" value="{{ old('jumlah') }}" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-circle-dot"></i> Status
                        </label>
                        <select name="status" class="field-input" required>
                            <option value="belum" {{ old('status')=='belum' ? 'selected':'' }}>Belum Bayar</option>
                            <option value="lunas" {{ old('status')=='lunas' ? 'selected':'' }}>Lunas</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- SEKSI 3: KETERANGAN --}}
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-note-sticky"></i>
                <span>Keterangan</span>
            </div>
            <div class="section-body">
                <div class="field-group">
                    <label class="field-label">
                        <i class="fas fa-align-left"></i> Keterangan Tambahan
                    </label>
                    <textarea name="keterangan" class="field-input"
                              placeholder="Masukkan keterangan tambahan...">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ACTION BAR --}}
        <div class="action-bar">
            <p class="action-hint">
                <i class="fas fa-asterisk" style="font-size:0.6rem; color:#ef4444;"></i>
                Semua field wajib diisi
            </p>
            <button type="submit" class="btn-submit">
                <i class="fas fa-floppy-disk"></i>
                Simpan Data Iuran
            </button>
        </div>

    </form>
</div>

@endsection

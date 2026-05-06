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
.lap-hero {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #059669 100%);
    padding: 2rem 2.5rem 2.2rem;
    display: flex;
    align-items: center;
    gap: 1.1rem;
    position: relative;
    overflow: hidden;
}

.lap-hero::after {
    content: '';
    position: absolute;
    right: -60px; top: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.lap-hero::before {
    content: '';
    position: absolute;
    right: 80px; bottom: -80px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
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

/* ─── PAGE BODY ─── */
.page-body {
    width: 100%;
    padding: 2rem 2.5rem 3rem;
}

/* ─── STATS ROW ─── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.4rem 1rem;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}

.stat-card:nth-child(1)::before { background: #064e3b; }
.stat-card:nth-child(2)::before { background: #dc2626; }
.stat-card:nth-child(3)::before { background: #2563eb; }
.stat-card:nth-child(4)::before { background: #7c3aed; }
.stat-card:nth-child(5)::before { background: #d97706; }

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.09);
}

.stat-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 1rem;
}

.stat-card:nth-child(1) .stat-icon { background: #d1fae5; color: #064e3b; }
.stat-card:nth-child(2) .stat-icon { background: #fee2e2; color: #dc2626; }
.stat-card:nth-child(3) .stat-icon { background: #dbeafe; color: #2563eb; }
.stat-card:nth-child(4) .stat-icon { background: #ede9fe; color: #7c3aed; }
.stat-card:nth-child(5) .stat-icon { background: #fef3c7; color: #d97706; }

.stat-value {
    font-size: 1.6rem; font-weight: 800;
    line-height: 1.1; margin-bottom: 5px;
}

.stat-card:nth-child(1) .stat-value { color: #064e3b; }
.stat-card:nth-child(2) .stat-value { color: #dc2626; }
.stat-card:nth-child(3) .stat-value { color: #2563eb; }
.stat-card:nth-child(4) .stat-value { color: #7c3aed; }
.stat-card:nth-child(5) .stat-value { color: #d97706; }

.stat-label {
    font-size: 0.78rem; color: #6b7280;
    font-weight: 600; margin: 0;
    text-transform: uppercase; letter-spacing: 0.05em;
}

/* ─── MAIN GRID ─── */
.main-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.25rem;
}

/* ─── CARD ─── */
.info-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.card-header {
    padding: 1rem 1.5rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 9px;
}

..card-header i { color: #064e3b; }

.card-header span {
    font-size: 0.75rem; font-weight: 800;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.09em;
}

.card-body { padding: 1.75rem; }

/* ─── FORM AREA ─── */
.form-row-inline {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.field-wrap { flex: 1; }

.field-label {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 8px;
}

.field-label i { color: #6b7280; font-size: 0.78rem; }

.field-select {
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.92rem;
    color: #0f172a;
    background: #fff;
    transition: all 0.2s;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23064e3b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    cursor: pointer;
}

.field-select:hover { border-color: #94a3b8; }
.field-select:focus { border-color: #064e3b; box-shadow: 0 0 0 3px rgba(6,78,59,0.12); }

/* ─── CETAK BUTTON ─── */
.btn-cetak {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    padding: 0.85rem 1.5rem;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: #fff;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-cetak:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(6,78,59,0.38);
}

.btn-cetak:active { transform: translateY(0); }

/* ─── INFO STRIP ─── */
.info-strip {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 0.85rem 1rem;
    margin-top: 1.25rem;
}

.info-strip i { color: #064e3b; }
.info-strip p { font-size: 0.8rem; color: #166534; margin: 0; font-weight: 500; line-height: 1.5; }

/* ─── RINGKASAN KANAN ─── */
.ringkasan-list {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ringkasan-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.875rem;
    color: #374151;
    font-weight: 600;
    padding: 0.65rem 0.85rem;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    transition: all 0.15s;
}

.ringkasan-list li:hover {
    background: #f0fdf4;
    border-color: #bbf7d0;
}

.check-circle {
    width: 24px; height: 24px;
    background: #d1fae5; color: #064e3b;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #16a34a;
    font-size: 0.7rem;
    flex-shrink: 0;
}

.ringkasan-desc {
    font-size: 0.8rem;
    color: #64748b;
    margin: 0 0 1rem;
    line-height: 1.55;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 900px) {
    .main-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: repeat(3, 1fr); }
    .page-body { padding: 1.5rem 1.25rem 2rem; }
    .lap-hero { padding: 1.5rem 1.25rem; }
}

@media (max-width: 576px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}
</style>

{{-- ─── HERO ─── --}}
<div class="lap-hero">
    <div class="hero-icon">
        <i class="fas fa-chart-bar"></i>
    </div>
    <div class="hero-text">
        <h2>Laporan Bulanan</h2>
        <p>Ringkasan data iuran dan aktivitas penghuni per bulan</p>
    </div>
</div>

<div class="page-body">

    {{-- ─── STATS ─── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
            <p class="stat-value">{{ $sukses }}</p>
            <p class="stat-label">Sukses</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-circle-xmark"></i></div>
            <p class="stat-value">{{ $gagal }}</p>
            <p class="stat-label">Gagal</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <p class="stat-value">{{ $totalPenghuni }}</p>
            <p class="stat-label">Penghuni</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-house"></i></div>
            <p class="stat-value">{{ $totalRumah }}</p>
            <p class="stat-label">Rumah</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <p class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($totalIuran, 0, ',', '.') }}</p>
            <p class="stat-label">Total Iuran</p>
        </div>
    </div>

    {{-- ─── MAIN GRID ─── --}}
    <div class="main-grid">

        {{-- KIRI: FORM CETAK --}}
        <div class="info-card">
            <div class="card-header">
                <i class="fas fa-print"></i>
                <span>Cetak Laporan</span>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan.cetak') }}" method="GET">

                    <div class="form-row-inline">
                        <div class="field-wrap">
                            <label class="field-label">
                                <i class="fas fa-calendar"></i>
                                Pilih Bulan
                            </label>
                            <select name="bulan" class="field-select">
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                                    <option value="{{ $i + 1 }}" {{ (request('bulan') == $i+1 || (!request('bulan') && $i+1 == date('n'))) ? 'selected' : '' }}>
                                        {{ $bln }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-wrap">
                            <label class="field-label">
                                <i class="fas fa-calendar-days"></i>
                                Tahun
                            </label>
                            <select name="tahun" class="field-select">
                                @for($y = date('Y'); $y >= date('Y') - 4; $y--)
                                    <option value="{{ $y }}" {{ (request('tahun', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-cetak">
                        <i class="fas fa-print"></i>
                        Cetak Laporan PDF
                    </button>

                </form>

                <div class="info-strip">
                    <i class="fas fa-circle-info"></i>
                    <p>Laporan akan dibuka dalam format PDF dan siap untuk dicetak atau disimpan.</p>
                </div>
            </div>
        </div>

        {{-- KANAN: RINGKASAN --}}
        <div class="info-card">
            <div class="card-header">
                <i class="fas fa-list-check"></i>
                <span>Isi Laporan</span>
            </div>
            <div class="card-body">
                <p class="ringkasan-desc">
                    Laporan mencakup data lengkap periode yang dipilih:
                </p>
                <ul class="ringkasan-list">
                    <li>
                        <div class="check-circle"><i class="fas fa-check"></i></div>
                        Data Iuran Bulanan
                    </li>
                    <li>
                        <div class="check-circle"><i class="fas fa-check"></i></div>
                        Data Penghuni Aktif
                    </li>
                    <li>
                        <div class="check-circle"><i class="fas fa-check"></i></div>
                        Aktivitas Pembayaran
                    </li>
                    <li>
                        <div class="check-circle"><i class="fas fa-check"></i></div>
                        Rekap Rumah & Unit
                    </li>
                    <li>
                        <div class="check-circle"><i class="fas fa-check"></i></div>
                        Status Tunggakan
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>

@endsection

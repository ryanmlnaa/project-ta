@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --green:      #064e3b;
    --green-mid:  #065f46;
    --green-lite: #10b981;
    --border:     #e8ede9;
    --surface:    #f8faf8;
    --text-main:  #0f1f0f;
    --text-sub:   #94a3b8;
}

*,*::before,*::after { box-sizing:border-box; }

.lp-wrap {
    font-family:'Plus Jakarta Sans',sans-serif;
    padding:24px;
    max-width:1100px;
    margin:0 auto;
}

/* ── HERO ── */
.lp-hero {
    background:linear-gradient(135deg,#064e3b,#10b981);
    border-radius:20px;
    padding:32px 36px;
    margin-bottom:20px;
    color:#fff;
    position:relative;
    overflow:hidden;
}
.lp-hero::before {
    content:'';
    position:absolute;
    width:220px; height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.07);
    top:-60px; right:-40px;
}
.lp-hero::after {
    content:'';
    position:absolute;
    width:100px; height:100px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    bottom:-20px; right:180px;
}
.lp-hero h2 { font-size:22px; font-weight:800; margin:0 0 5px; position:relative; z-index:1; }
.lp-hero p  { font-size:13px; opacity:.78; margin:0; position:relative; z-index:1; }

/* ── FILTER FORM ── */
.lp-form {
    background:#fff;
    border-radius:16px;
    border:1px solid var(--border);
    padding:18px 20px;
    margin-bottom:20px;
}
.lp-form-title {
    font-size:13px; font-weight:700;
    color:var(--green); margin-bottom:14px;
    display:flex; align-items:center; gap:7px;
}
.lp-form-row {
    display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;
}
.lp-field { display:flex; flex-direction:column; gap:5px; }
.lp-field label {
    font-size:11px; font-weight:700;
    color:#64748b; text-transform:uppercase; letter-spacing:.04em;
}
.lp-field select {
    padding:9px 12px;
    border:1.5px solid var(--border);
    border-radius:10px;
    font-size:13px;
    font-family:'Plus Jakarta Sans',sans-serif;
    color:var(--text-main);
    outline:none;
    transition:border-color .15s;
    background:#fff;
    min-width:130px;
}
.lp-field select:focus { border-color:var(--green-lite); }

.lp-btn {
    display:inline-flex; align-items:center; gap:7px;
    padding:10px 20px;
    border:none; border-radius:10px;
    font-size:13px; font-weight:700;
    cursor:pointer; text-decoration:none;
    transition:opacity .15s, transform .15s;
    white-space:nowrap;
}
.lp-btn:hover { opacity:.88; transform:translateY(-1px); }
.lp-btn-green { background:linear-gradient(135deg,#064e3b,#10b981); color:#fff; }
.lp-btn-blue  { background:linear-gradient(135deg,#1e3a5f,#2563eb); color:#fff; }

/* ── STATS ── */
.lp-stats {
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px;
    margin-bottom:20px;
}
.lp-stat {
    background:#fff;
    border-radius:16px;
    border:1px solid var(--border);
    padding:16px 14px;
    text-align:center;
    transition:transform .2s, box-shadow .2s;
}
.lp-stat:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(0,0,0,.08); }
.lp-stat-icon {
    width:42px; height:42px; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:16px; color:#fff; margin:0 auto 10px;
}
.lp-stat-val { font-size:20px; font-weight:800; color:var(--text-main); line-height:1; margin-bottom:5px; }
.lp-stat-lbl { font-size:10px; color:var(--text-sub); font-weight:700; text-transform:uppercase; letter-spacing:.05em; }

/* ── CARDS ── */
.lp-card {
    background:#fff;
    border-radius:16px;
    border:1px solid var(--border);
    margin-bottom:18px;
    overflow:hidden;
}
.lp-card-head {
    padding:14px 20px;
    border-bottom:1px solid #f0f4f0;
    display:flex; align-items:center; gap:9px;
}
.lp-card-head-icon {
    width:32px; height:32px; border-radius:9px;
    background:linear-gradient(135deg,#064e3b,#10b981);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:13px; flex-shrink:0;
}
.lp-card-head h5 { font-size:14px; font-weight:700; color:var(--green); margin:0; flex:1; }
.lp-card-head .lp-count {
    font-size:11px; font-weight:700;
    background:var(--surface); color:var(--text-sub);
    border:1px solid var(--border);
    padding:3px 9px; border-radius:50px;
}

/* ── TABLE ── */
.lp-table-wrap { overflow-x:auto; }
.lp-table { width:100%; border-collapse:collapse; min-width:500px; }
.lp-table th {
    padding:10px 18px;
    font-size:10px; font-weight:700;
    text-transform:uppercase; letter-spacing:.05em;
    color:var(--text-sub); background:var(--surface);
    border-bottom:1px solid #eef2ee;
    white-space:nowrap;
}
.lp-table td { padding:11px 18px; font-size:13px; border-bottom:1px solid #f4f7f4; vertical-align:middle; }
.lp-table tr:last-child td { border-bottom:none; }
.lp-table tbody tr:hover { background:#fafcfa; }
.lp-num { color:var(--text-sub); font-size:12px; }
.lp-jumlah { font-weight:700; font-variant-numeric:tabular-nums; color:var(--green); }

/* ── BADGES ── */
.lp-badge {
    display:inline-flex; padding:3px 10px;
    border-radius:50px; font-size:11px; font-weight:700;
    white-space:nowrap;
}
.bg-lunas    { background:#dcfce7; color:#15803d; }
.bg-menunggu { background:#fef3c7; color:#a16207; }
.bg-aktif    { background:#dbeafe; color:#1d4ed8; }
.bg-masuk    { background:#dcfce7; color:#15803d; }
.bg-keluar   { background:#fee2e2; color:#b91c1c; }
.bg-selesai  { background:#dcfce7; color:#15803d; }
.bg-diajukan { background:#fef3c7; color:#a16207; }
.bg-default  { background:#f0f4f0; color:#64748b; }

/* ── EMPTY ── */
.lp-empty {
    padding:36px; text-align:center;
    color:var(--text-sub); font-size:13px;
}
.lp-empty i { font-size:28px; margin-bottom:10px; display:block; opacity:.5; }

/* ── MOBILE CARDS (table alt) ── */
.lp-mobile-cards { display:none; }
.lp-row-card {
    padding:14px 16px;
    border-bottom:1px solid #f4f7f4;
}
.lp-row-card:last-child { border-bottom:none; }
.lp-row-card .rc-top {
    display:flex; justify-content:space-between;
    align-items:flex-start; gap:8px; margin-bottom:6px;
}
.lp-row-card .rc-name  { font-weight:700; font-size:.88rem; color:var(--text-main); }
.lp-row-card .rc-sub   { font-size:.73rem; color:var(--text-sub); margin-top:2px; }
.lp-row-card .rc-right { text-align:right; flex-shrink:0; }
.lp-row-card .rc-amount { font-weight:700; font-size:.9rem; color:var(--green); }
.lp-row-card .rc-meta  { display:flex; gap:6px; flex-wrap:wrap; align-items:center; margin-top:5px; }

/* ── RESPONSIVE ── */
@media (max-width:900px) {
    .lp-stats { grid-template-columns:repeat(3,1fr); }
}

@media (max-width:640px) {
    .lp-wrap   { padding:14px; }
    .lp-hero   { padding:24px 20px; border-radius:16px; }
    .lp-hero h2 { font-size:18px; }
    .lp-stats  { grid-template-columns:repeat(2,1fr); }
    .lp-stats .lp-stat:last-child { grid-column:span 2; }
    .lp-form-row { flex-direction:column; align-items:stretch; }
    .lp-field select { width:100%; }
    .lp-btn    { justify-content:center; }

    /* Hide table, show cards */
    .lp-table-wrap { display:none; }
    .lp-mobile-cards { display:block; }
}

@media (max-width:400px) {
    .lp-stats { grid-template-columns:1fr 1fr; }
    .lp-stats .lp-stat:last-child { grid-column:span 2; }
}
</style>

<div class="lp-wrap">

    {{-- HERO --}}
    <div class="lp-hero">
        <h2>📊 Laporan RT</h2>
        <p>Ringkasan iuran, kas, dan pengaduan per periode</p>
    </div>

    {{-- FILTER --}}
    <div class="lp-form">
        <div class="lp-form-title"><i class="fas fa-filter"></i> Filter Periode</div>
        <form method="GET" action="{{ route('laporan.index') }}">
            <div class="lp-form-row">
                <div class="lp-field">
                    <label>Bulan</label>
                    <select name="bulan">
                        @foreach(['Januari'=>1,'Februari'=>2,'Maret'=>3,'April'=>4,'Mei'=>5,'Juni'=>6,'Juli'=>7,'Agustus'=>8,'September'=>9,'Oktober'=>10,'November'=>11,'Desember'=>12] as $nama => $num)
                            <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lp-field">
                    <label>Tahun</label>
                    <select name="tahun">
                        @for($y = now()->year; $y >= now()->year - 3; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="lp-btn lp-btn-green">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
                <a href="{{ route('laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                   class="lp-btn lp-btn-blue" target="_blank">
                    <i class="fas fa-print"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>

    {{-- STATS --}}
    <div class="lp-stats">
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#064e3b,#10b981)"><i class="fas fa-users"></i></div>
            <div class="lp-stat-val">{{ $totalPenghuni }}</div>
            <div class="lp-stat-lbl">Penghuni</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#0d7377,#14a085)"><i class="fas fa-home"></i></div>
            <div class="lp-stat-val">{{ $totalRumah }}</div>
            <div class="lp-stat-lbl">Rumah</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#b45309,#d97706)"><i class="fas fa-money-bill-wave"></i></div>
            <div class="lp-stat-val" style="font-size:13px">Rp {{ number_format($totalIuran,0,',','.') }}</div>
            <div class="lp-stat-lbl">Total Iuran</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#0369a1,#0284c7)"><i class="fas fa-wallet"></i></div>
            <div class="lp-stat-val" style="font-size:13px">Rp {{ number_format($saldoKas,0,',','.') }}</div>
            <div class="lp-stat-lbl">Saldo Kas</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#be123c,#e11d48)"><i class="fas fa-bullhorn"></i></div>
            <div class="lp-stat-val">{{ $dataPengaduan->count() }}</div>
            <div class="lp-stat-lbl">Pengaduan</div>
        </div>
    </div>

    {{-- TABEL IURAN --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <div class="lp-card-head-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <h5>Data Iuran</h5>
            <span class="lp-count">{{ $dataIuran->count() }} iuran</span>
        </div>
        @if($dataIuran->count() > 0)

        {{-- Desktop --}}
        <div class="lp-table-wrap">
            <table class="lp-table">
                <thead>
                    <tr>
                        <th>#</th><th>Penghuni</th><th>Bulan/Tahun</th>
                        <th>Jenis</th><th>Jumlah</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataIuran as $i => $iuran)
                    <tr>
                        <td class="lp-num">{{ $i+1 }}</td>
                        <td style="font-weight:600">{{ $iuran->penghuni->nama ?? '-' }}</td>
                        <td style="color:var(--text-sub)">{{ $iuran->bulan }} {{ $iuran->tahun }}</td>
                        <td>{{ $iuran->jenis_iuran ?? '-' }}</td>
                        <td class="lp-jumlah">Rp {{ number_format($iuran->jumlah,0,',','.') }}</td>
                        <td><span class="lp-badge bg-{{ $iuran->status }}">{{ ucfirst($iuran->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="lp-mobile-cards">
            @foreach($dataIuran as $iuran)
            <div class="lp-row-card">
                <div class="rc-top">
                    <div>
                        <div class="rc-name">{{ $iuran->penghuni->nama ?? '-' }}</div>
                        <div class="rc-sub">{{ $iuran->bulan }} {{ $iuran->tahun }} · {{ $iuran->jenis_iuran ?? '-' }}</div>
                    </div>
                    <div class="rc-right">
                        <div class="rc-amount">Rp {{ number_format($iuran->jumlah,0,',','.') }}</div>
                    </div>
                </div>
                <div class="rc-meta">
                    <span class="lp-badge bg-{{ $iuran->status }}">{{ ucfirst($iuran->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="lp-empty"><i class="fas fa-inbox"></i>Tidak ada data iuran periode ini.</div>
        @endif
    </div>

    {{-- TABEL KAS --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <div class="lp-card-head-icon"><i class="fas fa-coins"></i></div>
            <h5>Kas Bendahara</h5>
            <span class="lp-count">{{ $dataKas->count() }} transaksi</span>
        </div>
        @if($dataKas->count() > 0)

        {{-- Desktop --}}
        <div class="lp-table-wrap">
            <table class="lp-table">
                <thead>
                    <tr>
                        <th>#</th><th>Tanggal</th><th>Jenis</th>
                        <th>Jumlah</th><th>Keterangan</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataKas as $i => $kas)
                    <tr>
                        <td class="lp-num">{{ $i+1 }}</td>
                        <td style="color:var(--text-sub);white-space:nowrap">{{ $kas->created_at->format('d M Y') }}</td>
                        <td><span class="lp-badge bg-{{ $kas->jenis }}">{{ ucfirst($kas->jenis) }}</span></td>
                        <td class="lp-jumlah">Rp {{ number_format($kas->jumlah,0,',','.') }}</td>
                        <td style="color:var(--text-sub)">{{ $kas->keterangan ?: '—' }}</td>
                        <td><span class="lp-badge bg-default">{{ ucfirst($kas->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="lp-mobile-cards">
            @foreach($dataKas as $kas)
            <div class="lp-row-card">
                <div class="rc-top">
                    <div>
                        <div class="rc-name">{{ $kas->keterangan ?: '(Tidak ada keterangan)' }}</div>
                        <div class="rc-sub">{{ $kas->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="rc-right">
                        <div class="rc-amount">Rp {{ number_format($kas->jumlah,0,',','.') }}</div>
                    </div>
                </div>
                <div class="rc-meta">
                    <span class="lp-badge bg-{{ $kas->jenis }}">{{ ucfirst($kas->jenis) }}</span>
                    <span class="lp-badge bg-default">{{ ucfirst($kas->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="lp-empty"><i class="fas fa-inbox"></i>Tidak ada transaksi kas periode ini.</div>
        @endif
    </div>

    {{-- TABEL PENGADUAN --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <div class="lp-card-head-icon"><i class="fas fa-bullhorn"></i></div>
            <h5>Data Pengaduan</h5>
            <span class="lp-count">{{ $dataPengaduan->count() }} pengaduan</span>
        </div>
        @if($dataPengaduan->count() > 0)

        {{-- Desktop --}}
        <div class="lp-table-wrap">
            <table class="lp-table">
                <thead>
                    <tr>
                        <th>#</th><th>Penghuni</th><th>Judul</th>
                        <th>Status</th><th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPengaduan as $i => $p)
                    <tr>
                        <td class="lp-num">{{ $i+1 }}</td>
                        <td style="font-weight:600">{{ $p->penghuni->nama ?? '-' }}</td>
                        <td>{{ $p->judul ?? $p->pesan ?? '-' }}</td>
                        <td><span class="lp-badge bg-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td style="color:var(--text-sub);white-space:nowrap">{{ $p->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="lp-mobile-cards">
            @foreach($dataPengaduan as $p)
            <div class="lp-row-card">
                <div class="rc-top">
                    <div>
                        <div class="rc-name">{{ $p->penghuni->nama ?? '-' }}</div>
                        <div class="rc-sub">{{ $p->judul ?? $p->pesan ?? '-' }}</div>
                    </div>
                    <div class="rc-right">
                        <div style="font-size:.72rem;color:var(--text-sub)">{{ $p->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="rc-meta">
                    <span class="lp-badge bg-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="lp-empty"><i class="fas fa-inbox"></i>Tidak ada pengaduan periode ini.</div>
        @endif
    </div>

</div>
@endsection

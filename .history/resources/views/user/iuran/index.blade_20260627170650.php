@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

* { box-sizing: border-box; }

.iv-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f0f4f0;
    min-height: 100vh;
    padding: 20px 16px 60px;
    color: #1a1f1a;
}

/* ── HEADER ── */
.iv-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:20px; }
.iv-header-left h2 { font-size:20px; font-weight:800; color:#0f1f0f; letter-spacing:-0.4px; margin:0 0 2px; }
.iv-header-left p  { font-size:12px; color:#6b7c6b; margin:0; }
.iv-header-badge { background:#1a3d1a; color:#7edd7e; font-size:11px; font-weight:700; padding:5px 12px; border-radius:50px; white-space:nowrap; }

/* ── STATS ── */
.iv-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-bottom:20px; }
.iv-stat-card { background:#fff; border-radius:16px; padding:16px; border:1px solid rgba(0,0,0,0.06); position:relative; overflow:hidden; transition:transform .2s,box-shadow .2s; }
.iv-stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,0,0,.09); }
.iv-stat-card::after { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:16px 16px 0 0; }
.iv-stat-card.green::after { background:linear-gradient(90deg,#22c55e,#16a34a); }
.iv-stat-card.amber::after { background:linear-gradient(90deg,#f59e0b,#d97706); }
.iv-stat-card.blue::after  { background:linear-gradient(90deg,#3b82f6,#2563eb); }
.iv-stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; margin-bottom:10px; }
.iv-stat-card.green .iv-stat-icon { background:#dcfce7; color:#16a34a; }
.iv-stat-card.amber .iv-stat-icon { background:#fef3c7; color:#d97706; }
.iv-stat-card.blue  .iv-stat-icon { background:#dbeafe; color:#2563eb; }
.iv-stat-val { font-size:20px; font-weight:800; color:#0f1f0f; line-height:1; }
.iv-stat-lbl { font-size:11px; color:#7a8a7a; font-weight:500; margin-top:4px; }
.iv-progress-bar { width:100%; height:4px; background:#e8f0e8; border-radius:4px; overflow:hidden; margin-top:10px; }
.iv-progress-fill { height:100%; background:linear-gradient(90deg,#22c55e,#16a34a); border-radius:4px; }

/* ── MAIN GRID ── */
.iv-main { display:grid; grid-template-columns:280px 1fr; gap:16px; align-items:start; }

/* ── QRIS CARD ── */
.iv-qris-card { background:#fff; border-radius:20px; overflow:hidden; border:1px solid rgba(0,0,0,.06); box-shadow:0 4px 20px rgba(0,0,0,.05); }
.iv-qris-top { background:linear-gradient(135deg,#0f2d0f,#1a5c1a,#22a022); padding:18px; text-align:center; }
.iv-qris-top h6 { color:#fff; font-size:13px; font-weight:700; margin:0 0 3px; }
.iv-qris-top p  { color:rgba(255,255,255,.6); font-size:11px; margin:0; }
.iv-qris-body { padding:16px; text-align:center; }
.iv-qris-img-wrap { background:#f8faf8; border-radius:14px; padding:10px; border:1.5px dashed #c8e6c8; margin-bottom:12px; }
.iv-qris-img { width:100%; border-radius:8px; object-fit:contain; max-height:220px; }
.iv-qris-footer { background:#f8faf8; border-top:1px solid #e8f0e8; padding:12px 16px; display:flex; align-items:center; gap:10px; }
.iv-qris-icon { width:34px; height:34px; background:#dcfce7; border-radius:9px; display:flex; align-items:center; justify-content:center; color:#16a34a; font-size:14px; flex-shrink:0; }
.iv-qris-footer span { font-size:11px; color:#5a6e5a; line-height:1.4; }

/* ── TABLE CARD ── */
.iv-table-card { background:#fff; border-radius:20px; overflow:hidden; border:1px solid rgba(0,0,0,.06); box-shadow:0 4px 20px rgba(0,0,0,.05); }
.iv-table-head { padding:16px 20px 14px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #f0f4f0; flex-wrap:wrap; gap:10px; }
.iv-table-head-left { display:flex; align-items:center; gap:10px; }
.iv-table-icon { width:38px; height:38px; background:linear-gradient(135deg,#dcfce7,#bbf7d0); border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:16px; color:#15803d; flex-shrink:0; }
.iv-table-head h5 { font-size:15px; font-weight:800; color:#0f1f0f; margin:0 0 2px; }
.iv-table-head p  { font-size:11px; color:#7a8a7a; margin:0; }
.iv-filter-tabs { display:flex; gap:5px; flex-wrap:wrap; }
.iv-tab { padding:5px 12px; border-radius:50px; font-size:11px; font-weight:600; cursor:pointer; border:none; transition:all .2s; font-family:'Plus Jakarta Sans',sans-serif; }
.iv-tab.active { background:#1a3d1a; color:#7edd7e; }
.iv-tab:not(.active) { background:#f0f4f0; color:#6b7c6b; }

/* ── TABLE ── */
.iv-table-wrap { overflow-x:auto; }
table.iv-table { width:100%; border-collapse:collapse; min-width:520px; }
table.iv-table thead th { padding:10px 16px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#7a8a7a; background:#f8faf8; border-bottom:1px solid #eef2ee; white-space:nowrap; }
table.iv-table tbody tr { border-bottom:1px solid #f4f7f4; transition:background .15s; }
table.iv-table tbody tr:hover { background:#f8fdf8; }
table.iv-table tbody tr:last-child { border-bottom:none; }
table.iv-table td { padding:13px 16px; font-size:13px; vertical-align:middle; }

.iv-month-cell { display:flex; align-items:center; gap:10px; }
.iv-month-icon { width:36px; height:36px; background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:13px; color:#15803d; flex-shrink:0; }
.iv-month-name { font-weight:700; color:#1a2a1a; font-size:13px; }
.iv-month-year { font-size:10px; color:#9aaa9a; margin-top:1px; }

.iv-amount       { font-family:'DM Mono',monospace; font-size:13px; font-weight:500; color:#1a5c1a; }
.iv-amount-small { font-size:10px; color:#9aaa9a; }

.iv-badge { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:50px; font-size:11px; font-weight:700; white-space:nowrap; }
.iv-badge-green { background:#dcfce7; color:#15803d; }
.iv-badge-amber { background:#fef3c7; color:#a16207; }
.iv-badge-blue  { background:#dbeafe; color:#1d4ed8; }
.iv-badge-red   { background:#fee2e2; color:#b91c1c; }

.iv-status-paid { display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#15803d; }
.iv-status-dot  { width:7px; height:7px; border-radius:50%; background:#22c55e; box-shadow:0 0 0 3px rgba(34,197,94,.2); flex-shrink:0; }

.iv-btn-pay { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:linear-gradient(135deg,#0f2d0f,#1a6c1a); color:#fff; font-size:12px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border:none; border-radius:9px; cursor:pointer; transition:all .2s; box-shadow:0 3px 12px rgba(22,163,74,.3); text-decoration:none; white-space:nowrap; }
.iv-btn-pay:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(22,163,74,.4); color:#fff; }
.iv-btn-detail { display:inline-flex; align-items:center; gap:5px; padding:6px 12px; background:#f0f4f0; color:#4a5a4a; font-size:11px; font-weight:600; font-family:'Plus Jakarta Sans',sans-serif; border:none; border-radius:8px; cursor:pointer; transition:all .2s; white-space:nowrap; }
.iv-btn-detail:hover { background:#e2eae2; }

.iv-empty { padding:48px 24px; text-align:center; }
.iv-empty-icon { width:64px; height:64px; background:#f0f4f0; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:26px; margin:0 auto 14px; }
.iv-empty h6 { font-size:15px; font-weight:700; color:#2a3a2a; margin-bottom:5px; }
.iv-empty p  { font-size:12px; color:#7a8a7a; margin:0; }

/* ── MOBILE IURAN CARDS ── */
.iv-mobile-list { display:none; }
.iv-mob-card {
    background:#fff;
    border:1px solid rgba(0,0,0,.06);
    border-radius:14px;
    padding:14px;
    margin-bottom:10px;
}
.iv-mob-card .mc-top { display:flex; justify-content:space-between; align-items:flex-start; gap:8px; margin-bottom:10px; }
.iv-mob-card .mc-left .mc-bulan { font-weight:700; font-size:.92rem; color:#1a2a1a; }
.iv-mob-card .mc-left .mc-tahun { font-size:.72rem; color:#9aaa9a; margin-top:1px; }
.iv-mob-card .mc-amount { font-weight:700; font-size:.92rem; color:#1a5c1a; font-family:'DM Mono',monospace; }
.iv-mob-card .mc-meta { display:flex; gap:6px; flex-wrap:wrap; align-items:center; margin-bottom:10px; }
.iv-mob-card .mc-foot { display:flex; justify-content:flex-end; }

/* ── KAS SECTION ── */
.iv-kas-section { margin-top:16px; }

/* ── ANIMATIONS ── */
@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.fade-up { opacity:0; animation:fadeUp .4s ease forwards; }
.d1{animation-delay:.05s} .d2{animation-delay:.10s} .d3{animation-delay:.15s} .d4{animation-delay:.20s}

/* ── MODAL ── */
.iv-modal-header { background:linear-gradient(135deg,#0f2d0f,#1a6c1a); padding:18px 22px; display:flex; align-items:center; justify-content:space-between; }
.iv-modal-icon { width:40px; height:40px; background:rgba(255,255,255,.15); border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:17px; }
.iv-modal-title { font-size:15px; font-weight:800; color:#fff; }
.iv-modal-sub { font-size:11px; color:rgba(255,255,255,.6); margin-top:2px; }
.iv-modal-close { color:#fff; opacity:.7; font-size:22px; background:none; border:none; cursor:pointer; line-height:1; padding:0; }
.iv-modal-close:hover { opacity:1; }
.iv-modal-body { padding:20px; }
.iv-modal-badge { text-align:center; margin-bottom:16px; }
.iv-modal-row { display:flex; align-items:center; justify-content:space-between; padding:11px 0; border-bottom:1px solid #f0f4f0; gap:8px; }
.iv-modal-row:last-child { border-bottom:none; }
.iv-modal-row-left { display:flex; align-items:center; gap:9px; color:#6b7c6b; font-size:12px; font-weight:500; }
.iv-modal-row-icon { width:30px; height:30px; background:#f0f4f0; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.iv-modal-row-icon i { font-size:12px; color:#4a7a4a; }
.iv-modal-row-val { font-size:12px; font-weight:700; color:#1a2a1a; text-align:right; }
.iv-modal-keterangan { margin-top:12px; background:#f8faf8; border-radius:10px; padding:12px 14px; border:1px solid #e8f0e8; }
.iv-modal-keterangan-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#9aaa9a; margin-bottom:5px; }
.iv-modal-keterangan-val { font-size:12px; color:#4a5a4a; line-height:1.55; }
.iv-modal-footer { padding:14px 20px; background:#f8faf8; border-top:1px solid #eef2ee; text-align:right; }
.iv-modal-btn-close { padding:8px 20px; border-radius:9px; border:none; background:#1a3d1a; color:#7edd7e; font-size:12px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; transition:opacity .2s; }
.iv-modal-btn-close:hover { opacity:.85; }

/* ── RESPONSIVE ── */
@media (max-width:900px) {
    .iv-main { grid-template-columns:1fr; }
    .iv-qris-card { display:grid; grid-template-columns:1fr 1fr; }
    .iv-qris-top { border-radius:0; }
    .iv-stats { grid-template-columns:repeat(2,1fr); }
}

@media (max-width:640px) {
    .iv-wrap { padding:14px 12px 48px; }
    .iv-stats { grid-template-columns:1fr 1fr; gap:8px; }
    .iv-stat-val { font-size:16px; }
    .iv-stat-card { padding:13px 12px; }

    /* QRIS jadi full column di mobile */
    .iv-qris-card { display:block; }

    /* Sembunyikan tabel, tampilkan cards */
    .iv-table-wrap { display:none; }
    .iv-mobile-list { display:block; padding:12px; }

    .iv-table-head { padding:12px 14px; }
    .iv-table-head h5 { font-size:14px; }
}

@media (max-width:400px) {
    .iv-stats { grid-template-columns:1fr; }
    .iv-header-left h2 { font-size:17px; }
}
</style>

<div class="iv-wrap">

    {{-- HEADER --}}
    <div class="iv-header fade-up d1">
        <div class="iv-header-left">
            <h2>💰 Data Iuran Saya</h2>
            <p>Kelola pembayaran iuran bulanan Anda</p>
        </div>
        <span class="iv-header-badge">Tahun {{ date('Y') }}</span>
    </div>

    {{-- STATS --}}
    @php
    $lunas = $iuran->where('status','lunas')->count();
    $belum = $iuran->filter(fn($x) => $x->status != 'lunas' && !$x->bukti_pembayaran)->count();
    $total = $iuran->where('status','lunas')->sum('jumlah');
    $pct   = $iuran->count() > 0 ? round($lunas / $iuran->count() * 100) : 0;
    @endphp
    <div class="iv-stats fade-up d2">
        <div class="iv-stat-card green">
            <div class="iv-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="iv-stat-val">{{ $lunas }}</div>
            <div class="iv-stat-lbl">Bulan Lunas</div>
            <div class="iv-progress-bar"><div class="iv-progress-fill" style="width:{{ $pct }}%"></div></div>
        </div>
        <div class="iv-stat-card amber">
            <div class="iv-stat-icon"><i class="fas fa-clock"></i></div>
            <div class="iv-stat-val">{{ $belum }}</div>
            <div class="iv-stat-lbl">Belum Bayar</div>
        </div>
        <div class="iv-stat-card blue">
            <div class="iv-stat-icon"><i class="fas fa-coins"></i></div>
            <div class="iv-stat-val" style="font-size:15px">Rp {{ number_format($total,0,',','.') }}</div>
            <div class="iv-stat-lbl">Total Dibayar</div>
        </div>
        <div class="iv-stat-card" style="border-top:3px solid #ef4444;">
            <div class="iv-stat-icon" style="background:#fee2e2;color:#b91c1c;"><i class="fas fa-exclamation-circle"></i></div>
            <div class="iv-stat-val" style="color:#b91c1c;font-size:15px">Rp {{ number_format($totalBelumBayar,0,',','.') }}</div>
            <div class="iv-stat-lbl">Total Belum Bayar</div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="iv-main">

        {{-- QRIS --}}
        <div class="iv-qris-card fade-up d3">
            <div class="iv-qris-top">
                <h6><i class="fas fa-qrcode me-2"></i> Bayar via QRIS</h6>
                <p>Scan dengan e-wallet apapun</p>
            </div>
            <div class="iv-qris-body">
                <div class="iv-qris-img-wrap">
                    <img src="{{ asset('qris/qris_baru.png') }}" class="iv-qris-img" alt="QRIS">
                </div>
                <div style="font-size:11px;color:#7a8a7a;line-height:1.6">
                    Scan menggunakan <strong style="color:#1a3d1a">GoPay, OVO, Dana,</strong> atau e-wallet lainnya
                </div>
            </div>
            <div class="iv-qris-footer">
                <div class="iv-qris-icon"><i class="fas fa-shield-alt"></i></div>
                <span>Pembayaran aman & terenkripsi oleh sistem QRIS nasional</span>
            </div>
        </div>

        {{-- TABLE + MOBILE CARDS --}}
        <div class="iv-table-card fade-up d4">
            <div class="iv-table-head">
                <div class="iv-table-head-left">
                    <div class="iv-table-icon"><i class="fas fa-wallet"></i></div>
                    <div>
                        <h5>Riwayat Iuran</h5>
                        <p>{{ $iuran->count() }} tagihan tahun berjalan</p>
                    </div>
                </div>
                <div class="iv-filter-tabs">
                    <button class="iv-tab active" onclick="filterTab(this,'all')">Semua</button>
                    <button class="iv-tab" onclick="filterTab(this,'lunas')">Lunas</button>
                    <button class="iv-tab" onclick="filterTab(this,'belum')">Belum</button>
                </div>
            </div>

            {{-- Desktop table --}}
            <div class="iv-table-wrap">
                <table class="iv-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="iuranBody">
                        @forelse($iuran as $i)
                        <tr data-status="{{ $i->status == 'lunas' ? 'lunas' : ($i->bukti_pembayaran ? 'proses' : 'belum') }}">
                            <td>
                                <div class="iv-month-cell">
                                    <div class="iv-month-icon"><i class="fas fa-calendar-alt"></i></div>
                                    <div>
                                        <div class="iv-month-name">{{ $i->bulan }}</div>
                                        <div class="iv-month-year">{{ $i->tahun ?? date('Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="iv-amount">Rp {{ number_format($i->jumlah,0,',','.') }}</div>
                                <div class="iv-amount-small">Bulanan</div>
                            </td>
                            <td><span class="iv-badge iv-badge-blue">{{ $i->jenis_iuran ?? '-' }}</span></td>
                            <td style="font-size:12px;color:#4a5a4a;max-width:140px;">{{ $i->keterangan ?? '-' }}</td>
                            <td>
                                @if($i->status == 'lunas')
                                    <div class="iv-status-paid"><div class="iv-status-dot"></div> Lunas</div>
                                @elseif($i->status == 'rt')
                                    <span class="iv-badge iv-badge-blue">⏳ Menunggu Admin</span>
                                @elseif($i->bukti_pembayaran)
                                    <span class="iv-badge iv-badge-amber">⏳ Menunggu Bendahara</span>
                                @else
                                    <span class="iv-badge iv-badge-red">⚠ Belum Bayar</span>
                                @endif
                            </td>
                            <td style="text-align:right">
                                @if($i->status == 'lunas')
                                    <button class="iv-btn-detail" data-toggle="modal" data-target="#modalDetail{{ $i->id }}">🧾 Detail</button>
                                @elseif($i->bukti_pembayaran)
                                    <span style="font-size:11px;color:#9aaa9a;font-style:italic">Sedang diproses</span>
                                @else
                                    <a href="{{ route('user.iuran.upload', $i->id) }}" class="iv-btn-pay"><i class="fas fa-credit-card"></i> Bayar</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6">
                            <div class="iv-empty">
                                <div class="iv-empty-icon">💳</div>
                                <h6>Belum Ada Data Iuran</h6>
                                <p>Data iuran Anda akan muncul di sini</p>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="iv-mobile-list" id="iuranMobile">
                @forelse($iuran as $i)
                <div class="iv-mob-card" data-status="{{ $i->status == 'lunas' ? 'lunas' : ($i->bukti_pembayaran ? 'proses' : 'belum') }}">
                    <div class="mc-top">
                        <div class="mc-left">
                            <div class="mc-bulan">{{ $i->bulan }}</div>
                            <div class="mc-tahun">{{ $i->tahun ?? date('Y') }}</div>
                        </div>
                        <div class="mc-amount">Rp {{ number_format($i->jumlah,0,',','.') }}</div>
                    </div>
                    <div class="mc-meta">
                        <span class="iv-badge iv-badge-blue">{{ $i->jenis_iuran ?? '-' }}</span>
                        @if($i->status == 'lunas')
                            <div class="iv-status-paid"><div class="iv-status-dot"></div> Lunas</div>
                        @elseif($i->status == 'rt')
                            <span class="iv-badge iv-badge-blue">⏳ Menunggu Admin</span>
                        @elseif($i->bukti_pembayaran)
                            <span class="iv-badge iv-badge-amber">⏳ Menunggu</span>
                        @else
                            <span class="iv-badge iv-badge-red">⚠ Belum Bayar</span>
                        @endif
                    </div>
                    @if($i->keterangan)
                    <div style="font-size:11px;color:#7a8a7a;margin-bottom:8px;">{{ $i->keterangan }}</div>
                    @endif
                    <div class="mc-foot">
                        @if($i->status == 'lunas')
                            <button class="iv-btn-detail" data-toggle="modal" data-target="#modalDetail{{ $i->id }}">🧾 Detail</button>
                        @elseif($i->bukti_pembayaran)
                            <span style="font-size:11px;color:#9aaa9a;font-style:italic">Sedang diproses</span>
                        @else
                            <a href="{{ route('user.iuran.upload', $i->id) }}" class="iv-btn-pay"><i class="fas fa-credit-card"></i> Bayar</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="iv-empty">
                    <div class="iv-empty-icon">💳</div>
                    <h6>Belum Ada Data Iuran</h6>
                    <p>Data iuran Anda akan muncul di sini</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- KAS SECTION --}}
    <div class="iv-kas-section">
        <div class="iv-table-card fade-up d4">
            <div class="iv-table-head">
                <div class="iv-table-head-left">
                    <div class="iv-table-icon" style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);color:#6d28d9;"><i class="fas fa-coins"></i></div>
                    <div>
                        <h5>Tagihan Kas</h5>
                        <p>{{ $kas->count() }} tagihan kas</p>
                    </div>
                </div>
            </div>

            {{-- Desktop --}}
            <div class="iv-table-wrap">
                <table class="iv-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kas as $k)
                        <tr>
                            <td>
                                <div class="iv-month-cell">
                                    <div class="iv-month-icon"><i class="fas fa-wallet"></i></div>
                                    <div>
                                        <div class="iv-month-name">{{ $k->keterangan }}</div>
                                        <div class="iv-month-year">{{ $k->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><div class="iv-amount">Rp {{ number_format($k->jumlah,0,',','.') }}</div></td>
                            <td>
                                @if($k->status == 'lunas')
                                    <div class="iv-status-paid"><div class="iv-status-dot"></div> Lunas</div>
                                @elseif($k->status == 'menunggu_konfirmasi')
                                    <span class="iv-badge iv-badge-amber">⏳ Menunggu Konfirmasi</span>
                                @else
                                    <span class="iv-badge iv-badge-red">⚠ Belum Bayar</span>
                                @endif
                            </td>
                            <td style="text-align:right">
                                @if($k->status == 'menunggu_bayar')
                                    <button class="iv-btn-pay" data-toggle="modal" data-target="#modalBayarKas{{ $k->id }}">
                                        <i class="fas fa-credit-card"></i> Bayar
                                    </button>
                                @else
                                    <span style="font-size:11px;color:#9aaa9a;font-style:italic">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="padding:30px;text-align:center;color:#9aaa9a;font-size:13px;">Belum ada tagihan kas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile kas cards --}}
            <div class="iv-mobile-list">
                @forelse($kas as $k)
                <div class="iv-mob-card">
                    <div class="mc-top">
                        <div class="mc-left">
                            <div class="mc-bulan">{{ $k->keterangan }}</div>
                            <div class="mc-tahun">{{ $k->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="mc-amount">Rp {{ number_format($k->jumlah,0,',','.') }}</div>
                    </div>
                    <div class="mc-meta">
                        @if($k->status == 'lunas')
                            <div class="iv-status-paid"><div class="iv-status-dot"></div> Lunas</div>
                        @elseif($k->status == 'menunggu_konfirmasi')
                            <span class="iv-badge iv-badge-amber">⏳ Menunggu Konfirmasi</span>
                        @else
                            <span class="iv-badge iv-badge-red">⚠ Belum Bayar</span>
                        @endif
                    </div>
                    <div class="mc-foot">
                        @if($k->status == 'menunggu_bayar')
                            <button class="iv-btn-pay" data-toggle="modal" data-target="#modalBayarKas{{ $k->id }}">
                                <i class="fas fa-credit-card"></i> Bayar
                            </button>
                        @else
                            <span style="font-size:11px;color:#9aaa9a;font-style:italic">-</span>
                        @endif
                    </div>
                </div>
                @empty
                <div style="padding:24px;text-align:center;color:#9aaa9a;font-size:13px;">Belum ada tagihan kas.</div>
                @endforelse
            </div>

        </div>
    </div>

</div>

{{-- MODAL DETAIL --}}
@foreach($iuran->where('status','lunas') as $i)
<div class="modal fade" id="modalDetail{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:440px;">
        <div class="modal-content" style="border-radius:18px;border:none;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.15);">
            <div class="iv-modal-header">
                <div style="display:flex;align-items:center;gap:11px;">
                    <div class="iv-modal-icon">🧾</div>
                    <div>
                        <div class="iv-modal-title">Detail Iuran</div>
                        <div class="iv-modal-sub">{{ $i->bulan }} {{ $i->tahun ?? date('Y') }}</div>
                    </div>
                </div>
                <button class="iv-modal-close" data-dismiss="modal">&times;</button>
            </div>
            <div class="iv-modal-body">
                <div class="iv-modal-badge">
                    <span style="background:#dcfce7;color:#15803d;font-size:12px;font-weight:700;padding:5px 16px;border-radius:50px;display:inline-flex;align-items:center;gap:7px;">
                        <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;box-shadow:0 0 0 3px rgba(34,197,94,.2);"></span>
                        Pembayaran Lunas
                    </span>
                </div>
                <div class="iv-modal-row">
                    <div class="iv-modal-row-left"><div class="iv-modal-row-icon"><i class="fas fa-calendar-alt"></i></div> Bulan</div>
                    <div class="iv-modal-row-val">{{ $i->bulan }} {{ $i->tahun ?? date('Y') }}</div>
                </div>
                <div class="iv-modal-row">
                    <div class="iv-modal-row-left"><div class="iv-modal-row-icon"><i class="fas fa-coins"></i></div> Jumlah</div>
                    <div class="iv-modal-row-val" style="color:#1a5c1a;font-family:'DM Mono',monospace;">Rp {{ number_format($i->jumlah,0,',','.') }}</div>
                </div>
                <div class="iv-modal-row">
                    <div class="iv-modal-row-left"><div class="iv-modal-row-icon"><i class="fas fa-tag"></i></div> Jenis Iuran</div>
                    <div class="iv-modal-row-val">{{ $i->jenis_iuran ?? '-' }}</div>
                </div>
                <div class="iv-modal-row">
                    <div class="iv-modal-row-left"><div class="iv-modal-row-icon"><i class="fas fa-check-circle"></i></div> Status</div>
                    <div class="iv-modal-row-val"><span class="iv-badge iv-badge-green">Lunas</span></div>
                </div>
                <div class="iv-modal-row">
                    <div class="iv-modal-row-left"><div class="iv-modal-row-icon"><i class="fas fa-calendar-check"></i></div> Tgl Bayar</div>
                    <div class="iv-modal-row-val">{{ $i->updated_at ? \Carbon\Carbon::parse($i->updated_at)->format('d M Y') : '-' }}</div>
                </div>
                @if($i->keterangan)
                <div class="iv-modal-keterangan">
                    <div class="iv-modal-keterangan-label">Keterangan</div>
                    <div class="iv-modal-keterangan-val">{{ $i->keterangan }}</div>
                </div>
                @endif
            </div>
            <div class="iv-modal-footer">
                <button class="iv-modal-btn-close" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- MODAL BAYAR KAS --}}
@foreach($kas->where('status','menunggu_bayar') as $k)
<div class="modal fade" id="modalBayarKas{{ $k->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;">
            <div class="modal-body" style="padding:22px;text-align:center;">
                <h6 style="font-weight:800;margin-bottom:4px;">{{ $k->keterangan }}</h6>
                <p style="color:#7a8a7a;font-size:13px;margin-bottom:18px;">Rp {{ number_format($k->jumlah,0,',','.') }}</p>
                <button onclick="bayarKasQris({{ $k->id }})" class="iv-btn-pay" style="width:100%;margin-bottom:8px;justify-content:center;">
                    <i class="fas fa-qrcode"></i> Bayar via QRIS
                </button>
                <a href="{{ route('user.kas.upload', $k->id) }}" class="iv-btn-detail" style="width:100%;justify-content:center;display:flex;">
                    <i class="fas fa-upload"></i> Upload Bukti Transfer
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
function bayarKasQris(id) {
    fetch(`/user/kas/qris/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Pembayaran berhasil, menunggu konfirmasi bendahara.');
            location.reload();
        }
    });
}

function filterTab(btn, status) {
    document.querySelectorAll('.iv-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    // Filter tabel desktop
    document.querySelectorAll('#iuranBody tr').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });

    // Filter mobile cards
    document.querySelectorAll('#iuranMobile .iv-mob-card').forEach(card => {
        card.style.display = (status === 'all' || card.dataset.status === status) ? '' : 'none';
    });
}
</script>
@endsection

@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

* { box-sizing: border-box; }

.iv-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f0f4f0;
    min-height: 100vh;
    padding: 28px 24px 60px;
    color: #1a1f1a;
}

.iv-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
.iv-header-left h2 { font-size:22px; font-weight:800; color:#0f1f0f; letter-spacing:-0.4px; }
.iv-header-left p  { font-size:13px; color:#6b7c6b; margin-top:2px; }
.iv-header-badge { background:#1a3d1a; color:#7edd7e; font-size:12px; font-weight:700; padding:6px 14px; border-radius:50px; }

.iv-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:24px; }
.iv-stat-card { background:#fff; border-radius:18px; padding:18px 20px; border:1px solid rgba(0,0,0,0.06); position:relative; overflow:hidden; transition:transform 0.2s,box-shadow 0.2s; }
.iv-stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,0,0,0.09); }
.iv-stat-card::after { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:18px 18px 0 0; }
.iv-stat-card.green::after { background:linear-gradient(90deg,#22c55e,#16a34a); }
.iv-stat-card.amber::after { background:linear-gradient(90deg,#f59e0b,#d97706); }
.iv-stat-card.blue::after  { background:linear-gradient(90deg,#3b82f6,#2563eb); }
.iv-stat-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:16px; margin-bottom:12px; }
.iv-stat-card.green .iv-stat-icon { background:#dcfce7; color:#16a34a; }
.iv-stat-card.amber .iv-stat-icon { background:#fef3c7; color:#d97706; }
.iv-stat-card.blue  .iv-stat-icon { background:#dbeafe; color:#2563eb; }
.iv-stat-val { font-size:24px; font-weight:800; color:#0f1f0f; line-height:1; }
.iv-stat-lbl { font-size:12px; color:#7a8a7a; font-weight:500; margin-top:4px; }
.iv-progress-bar { width:100%; height:4px; background:#e8f0e8; border-radius:4px; overflow:hidden; margin-top:10px; }
.iv-progress-fill { height:100%; background:linear-gradient(90deg,#22c55e,#16a34a); border-radius:4px; }

.iv-main { display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start; }
@media(max-width:900px){ .iv-main { grid-template-columns:1fr; } }

.iv-qris-card { background:#fff; border-radius:22px; overflow:hidden; border:1px solid rgba(0,0,0,0.06); box-shadow:0 4px 20px rgba(0,0,0,0.05); }
.iv-qris-top { background:linear-gradient(135deg,#0f2d0f 0%,#1a5c1a 50%,#22a022 100%); padding:20px; text-align:center; }
.iv-qris-top h6 { color:#fff; font-size:14px; font-weight:700; margin-bottom:4px; }
.iv-qris-top p  { color:rgba(255,255,255,0.6); font-size:11px; }
.iv-qris-body { padding:20px; text-align:center; }
.iv-qris-img-wrap { background:#f8faf8; border-radius:16px; padding:12px; border:1.5px dashed #c8e6c8; margin-bottom:16px; }
.iv-qris-img { width:100%; border-radius:10px; object-fit:contain; max-height:240px; }
.iv-qris-footer { background:#f8faf8; border-top:1px solid #e8f0e8; padding:14px 20px; display:flex; align-items:center; gap:10px; }
.iv-qris-icon { width:36px; height:36px; background:#dcfce7; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#16a34a; font-size:15px; flex-shrink:0; }
.iv-qris-footer span { font-size:12px; color:#5a6e5a; line-height:1.4; }

.iv-table-card { background:#fff; border-radius:22px; overflow:hidden; border:1px solid rgba(0,0,0,0.06); box-shadow:0 4px 20px rgba(0,0,0,0.05); }
.iv-table-head { padding:20px 24px 16px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #f0f4f0; flex-wrap:wrap; gap:12px; }
.iv-table-head-left { display:flex; align-items:center; gap:12px; }
.iv-table-icon { width:40px; height:40px; background:linear-gradient(135deg,#dcfce7,#bbf7d0); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:17px; color:#15803d; }
.iv-table-head h5 { font-size:16px; font-weight:800; color:#0f1f0f; margin:0 0 2px; }
.iv-table-head p  { font-size:12px; color:#7a8a7a; margin:0; }
.iv-filter-tabs { display:flex; gap:6px; }
.iv-tab { padding:6px 14px; border-radius:50px; font-size:12px; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; font-family:'Plus Jakarta Sans',sans-serif; }
.iv-tab.active { background:#1a3d1a; color:#7edd7e; }
.iv-tab:not(.active) { background:#f0f4f0; color:#6b7c6b; }

.iv-table-wrap { overflow-x:auto; }
table.iv-table { width:100%; border-collapse:collapse; }
table.iv-table thead th { padding:12px 24px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.6px; color:#7a8a7a; background:#f8faf8; border-bottom:1px solid #eef2ee; }
table.iv-table tbody tr { border-bottom:1px solid #f4f7f4; transition:background 0.15s; }
table.iv-table tbody tr:hover { background:#f8fdf8; }
table.iv-table tbody tr:last-child { border-bottom:none; }
table.iv-table td { padding:16px 24px; font-size:14px; vertical-align:middle; }

.iv-month-cell { display:flex; align-items:center; gap:12px; }
.iv-month-icon { width:40px; height:40px; background:linear-gradient(135deg,#f0fdf4,#dcfce7); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:14px; color:#15803d; flex-shrink:0; }
.iv-month-name { font-weight:700; color:#1a2a1a; font-size:14px; }
.iv-month-year { font-size:11px; color:#9aaa9a; margin-top:1px; }

.iv-amount { font-family:'DM Mono',monospace; font-size:14px; font-weight:500; color:#1a5c1a; }
.iv-amount-small { font-size:11px; color:#9aaa9a; }

.iv-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:50px; font-size:11.5px; font-weight:700; }
.iv-badge-green { background:#dcfce7; color:#15803d; }
.iv-badge-amber { background:#fef3c7; color:#a16207; }
.iv-badge-blue  { background:#dbeafe; color:#1d4ed8; }
.iv-badge-red   { background:#fee2e2; color:#b91c1c; }

.iv-status-paid { display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#15803d; }
.iv-status-dot  { width:8px; height:8px; border-radius:50%; background:#22c55e; box-shadow:0 0 0 3px rgba(34,197,94,0.2); }

.iv-btn-pay { display:inline-flex; align-items:center; gap:7px; padding:8px 18px; background:linear-gradient(135deg,#0f2d0f,#1a6c1a); color:#fff; font-size:12.5px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border:none; border-radius:10px; cursor:pointer; transition:all 0.2s; box-shadow:0 3px 12px rgba(22,163,74,0.3); text-decoration:none; }
.iv-btn-pay:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(22,163,74,0.4); color:#fff; }
.iv-btn-detail { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; background:#f0f4f0; color:#4a5a4a; font-size:12px; font-weight:600; font-family:'Plus Jakarta Sans',sans-serif; border:none; border-radius:9px; cursor:pointer; transition:all 0.2s; }
.iv-btn-detail:hover { background:#e2eae2; }

.iv-empty { padding:60px 24px; text-align:center; }
.iv-empty-icon { width:72px; height:72px; background:#f0f4f0; border-radius:22px; display:flex; align-items:center; justify-content:center; font-size:28px; margin:0 auto 16px; }
.iv-empty h6 { font-size:16px; font-weight:700; color:#2a3a2a; margin-bottom:6px; }
.iv-empty p  { font-size:13px; color:#7a8a7a; }

@keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
.fade-up { opacity:0; animation:fadeUp 0.45s ease forwards; }
.d1{animation-delay:0.05s} .d2{animation-delay:0.1s} .d3{animation-delay:0.15s} .d4{animation-delay:0.2s}

/* MODAL */
.iv-modal-header { background:linear-gradient(135deg,#0f2d0f,#1a6c1a); padding:20px 24px; display:flex; align-items:center; justify-content:space-between; }
.iv-modal-icon { width:42px; height:42px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; }
.iv-modal-title { font-size:16px; font-weight:800; color:#fff; }
.iv-modal-sub { font-size:12px; color:rgba(255,255,255,0.6); margin-top:2px; }
.iv-modal-close { color:#fff; opacity:0.7; font-size:22px; background:none; border:none; cursor:pointer; line-height:1; padding:0; }
.iv-modal-close:hover { opacity:1; }
.iv-modal-body { padding:24px; }
.iv-modal-badge { text-align:center; margin-bottom:20px; }
.iv-modal-row { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f0f4f0; }
.iv-modal-row:last-child { border-bottom:none; }
.iv-modal-row-left { display:flex; align-items:center; gap:10px; color:#6b7c6b; font-size:13px; font-weight:500; }
.iv-modal-row-icon { width:32px; height:32px; background:#f0f4f0; border-radius:9px; display:flex; align-items:center; justify-content:center; }
.iv-modal-row-icon i { font-size:13px; color:#4a7a4a; }
.iv-modal-row-val { font-size:13px; font-weight:700; color:#1a2a1a; }
.iv-modal-keterangan { margin-top:14px; background:#f8faf8; border-radius:12px; padding:14px 16px; border:1px solid #e8f0e8; }
.iv-modal-keterangan-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#9aaa9a; margin-bottom:6px; }
.iv-modal-keterangan-val { font-size:13px; color:#4a5a4a; line-height:1.55; }
.iv-modal-footer { padding:16px 24px; background:#f8faf8; border-top:1px solid #eef2ee; text-align:right; }
.iv-modal-btn-close { padding:9px 22px; border-radius:10px; border:none; background:#1a3d1a; color:#7edd7e; font-size:13px; font-weight:700; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; transition:opacity 0.2s; }
.iv-modal-btn-close:hover { opacity:0.85; }
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
  $lunas  = $iuran->where('status','lunas')->count();
  $belum  = $iuran->filter(fn($x) => $x->status != 'lunas' && !$x->bukti_pembayaran)->count();
  $total  = $iuran->where('status','lunas')->sum('jumlah');
  $pct    = $iuran->count() > 0 ? round($lunas / $iuran->count() * 100) : 0;
  @endphp
  <div class="iv-stats fade-up d2">
    <div class="iv-stat-card green">
      <div class="iv-stat-icon"><i class="fas fa-check-circle"></i></div>
      <div class="iv-stat-val">{{ $lunas }}</div>
      <div class="iv-stat-lbl">Bulan Lunas</div>
      <div class="iv-progress-bar">
        <div class="iv-progress-fill" style="width:{{ $pct }}%"></div>
      </div>
    </div>
    <div class="iv-stat-card amber">
      <div class="iv-stat-icon"><i class="fas fa-clock"></i></div>
      <div class="iv-stat-val">{{ $belum }}</div>
      <div class="iv-stat-lbl">Belum Bayar</div>
    </div>
    <div class="iv-stat-card blue">
      <div class="iv-stat-icon"><i class="fas fa-coins"></i></div>
      <div class="iv-stat-val">Rp {{ number_format($total,0,',','.') }}</div>
      <div class="iv-stat-lbl">Total Dibayar</div>
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
          <img src="{{ asset('qris/qris.jpeg') }}" class="iv-qris-img" alt="QRIS">
        </div>
        <div style="font-size:12px;color:#7a8a7a;line-height:1.6">
          Scan menggunakan <strong style="color:#1a3d1a">GoPay, OVO, Dana,</strong> atau e-wallet lainnya
        </div>
      </div>
      <div class="iv-qris-footer">
        <div class="iv-qris-icon"><i class="fas fa-shield-alt"></i></div>
        <span>Pembayaran aman & terenkripsi oleh sistem QRIS nasional</span>
      </div>
    </div>

    {{-- TABLE --}}
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

      <div class="iv-table-wrap">
        <table class="iv-table">
          <thead>
            <tr>
              <th>Bulan</th>
              <th>Jumlah</th>
              <th>Jenis</th>
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
              <td>
                <span class="iv-badge iv-badge-blue">{{ $i->jenis_iuran ?? '-' }}</span>
              </td>
              <td>
            @if($i->status == 'lunas')
                <div class="iv-status-paid">
                <div class="iv-status-dot"></div> Lunas
                </div>
            @elseif($i->status == 'rt')
                <span class="iv-badge iv-badge-blue">⏳ Menunggu Admin</span>
            @elseif($i->bukti_pembayaran)
                <span class="iv-badge iv-badge-amber">⏳ Menunggu RT</span>
            @else
                <span class="iv-badge iv-badge-red">⚠ Belum Bayar</span>
            @endif
              </td>
              <td style="text-align:right">
                @if($i->status == 'lunas')
                  <button class="iv-btn-detail"
                    data-toggle="modal"
                    data-target="#modalDetail{{ $i->id }}">
                    🧾 Detail
                  </button>
                @else
                  <a href="{{ route('user.iuran.upload', $i->id) }}" class="iv-btn-pay">
                    <i class="fas fa-credit-card"></i> Bayar
                  </a>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5">
                <div class="iv-empty">
                  <div class="iv-empty-icon">💳</div>
                  <h6>Belum Ada Data Iuran</h6>
                  <p>Data iuran Anda akan muncul di sini</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

{{-- ── MODAL DETAIL ── --}}
@foreach($iuran->where('status','lunas') as $i)
<div class="modal fade" id="modalDetail{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:460px;">
    <div class="modal-content" style="border-radius:20px;border:none;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.15);">

      <div class="iv-modal-header">
        <div style="display:flex;align-items:center;gap:12px;">
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
          <span style="background:#dcfce7;color:#15803d;font-size:12.5px;font-weight:700;padding:6px 18px;border-radius:50px;display:inline-flex;align-items:center;gap:7px;">
            <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;box-shadow:0 0 0 3px rgba(34,197,94,0.2);"></span>
            Pembayaran Lunas
          </span>
        </div>

        <div class="iv-modal-row">
          <div class="iv-modal-row-left">
            <div class="iv-modal-row-icon"><i class="fas fa-calendar-alt"></i></div>
            Bulan
          </div>
          <div class="iv-modal-row-val">{{ $i->bulan }} {{ $i->tahun ?? date('Y') }}</div>
        </div>

        <div class="iv-modal-row">
          <div class="iv-modal-row-left">
            <div class="iv-modal-row-icon"><i class="fas fa-coins"></i></div>
            Jumlah
          </div>
          <div class="iv-modal-row-val" style="color:#1a5c1a;font-family:'DM Mono',monospace;">
            Rp {{ number_format($i->jumlah,0,',','.') }}
          </div>
        </div>

        <div class="iv-modal-row">
          <div class="iv-modal-row-left">
            <div class="iv-modal-row-icon"><i class="fas fa-tag"></i></div>
            Jenis Iuran
          </div>
          <div class="iv-modal-row-val">{{ $i->jenis_iuran ?? '-' }}</div>
        </div>

        <div class="iv-modal-row">
          <div class="iv-modal-row-left">
            <div class="iv-modal-row-icon"><i class="fas fa-check-circle"></i></div>
            Status
          </div>
          <div class="iv-modal-row-val">
            <span class="iv-badge iv-badge-green">Lunas</span>
          </div>
        </div>

        <div class="iv-modal-row">
          <div class="iv-modal-row-left">
            <div class="iv-modal-row-icon"><i class="fas fa-calendar-check"></i></div>
            Tgl Bayar
          </div>
          <div class="iv-modal-row-val">
            {{ $i->updated_at ? \Carbon\Carbon::parse($i->updated_at)->format('d M Y') : '-' }}
          </div>
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

<script>
function filterTab(btn, status) {
  document.querySelectorAll('.iv-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#iuranBody tr').forEach(row => {
    row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
  });
}
</script>
@endsection

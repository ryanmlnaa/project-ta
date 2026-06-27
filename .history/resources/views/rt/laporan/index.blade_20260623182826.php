@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
.lp-wrap { font-family:'Plus Jakarta Sans',sans-serif; padding:24px; }
.lp-hero { background:linear-gradient(135deg,#064e3b,#10b981); border-radius:20px; padding:32px 36px; margin-bottom:24px; color:#fff; }
.lp-hero h2 { font-size:22px; font-weight:800; margin:0 0 4px; }
.lp-hero p  { font-size:13px; opacity:0.75; margin:0; }
.lp-stats { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:24px; }
.lp-stat { background:#fff; border-radius:16px; border:1px solid #e8ede9; padding:18px; text-align:center; }
.lp-stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:16px; color:#fff; margin:0 auto 10px; }
.lp-stat-val { font-size:22px; font-weight:800; color:#0f1f0f; line-height:1; margin-bottom:4px; }
.lp-stat-lbl { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
.lp-card { background:#fff; border-radius:16px; border:1px solid #e8ede9; margin-bottom:20px; overflow:hidden; }
.lp-card-head { padding:16px 20px; border-bottom:1px solid #f0f4f0; display:flex; align-items:center; gap:10px; }
.lp-card-head h5 { font-size:15px; font-weight:700; color:#064e3b; margin:0; }
.lp-card-head span { font-size:12px; color:#94a3b8; }
.lp-table { width:100%; border-collapse:collapse; }
.lp-table th { padding:10px 20px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8; background:#f8faf8; border-bottom:1px solid #eef2ee; }
.lp-table td { padding:12px 20px; font-size:13px; border-bottom:1px solid #f4f7f4; }
.lp-table tr:last-child td { border-bottom:none; }
.lp-badge { display:inline-flex; padding:4px 10px; border-radius:50px; font-size:11px; font-weight:700; }
.bg-lunas    { background:#dcfce7; color:#15803d; }
.bg-menunggu { background:#fef3c7; color:#a16207; }
.bg-aktif    { background:#dbeafe; color:#1d4ed8; }
.bg-masuk    { background:#dcfce7; color:#15803d; }
.bg-keluar   { background:#fee2e2; color:#b91c1c; }
.bg-selesai  { background:#dcfce7; color:#15803d; }
.bg-diajukan { background:#fef3c7; color:#a16207; }
.lp-form { background:#fff; border-radius:16px; border:1px solid #e8ede9; padding:20px; margin-bottom:24px; }
.lp-form h5 { font-size:14px; font-weight:700; color:#064e3b; margin:0 0 14px; }
.lp-form select { padding:8px 12px; border:1px solid #d1d5db; border-radius:10px; font-size:13px; font-family:'Plus Jakarta Sans',sans-serif; }
.lp-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 22px; background:linear-gradient(135deg,#064e3b,#10b981); color:#fff; font-size:13px; font-weight:700; border:none; border-radius:10px; cursor:pointer; text-decoration:none; }
.lp-empty { padding:30px; text-align:center; color:#94a3b8; font-size:13px; }
</style>

<div class="lp-wrap">

    <div class="lp-hero">
        <h2>📊 Laporan RT</h2>
        <p>Ringkasan iuran, kas, dan pengaduan per periode</p>
    </div>

    {{-- FORM FILTER --}}
    <div class="lp-form">
        <h5><i class="fas fa-filter"></i> Filter Periode</h5>
        <form method="GET" action="{{ route('laporan.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div>
                <label style="font-size:12px;color:#64748b;font-weight:600;display:block;margin-bottom:5px;">Bulan</label>
                <select name="bulan">
                    @foreach(['Januari'=>1,'Februari'=>2,'Maret'=>3,'April'=>4,'Mei'=>5,'Juni'=>6,'Juli'=>7,'Agustus'=>8,'September'=>9,'Oktober'=>10,'November'=>11,'Desember'=>12] as $nama => $num)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px;color:#64748b;font-weight:600;display:block;margin-bottom:5px;">Tahun</label>
                <select name="tahun">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="lp-btn"><i class="fas fa-search"></i> Tampilkan</button>
            <a href="{{ route('laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="lp-btn" style="background:linear-gradient(135deg,#1e3a5f,#2563eb);" target="_blank">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </form>
    </div>

    {{-- STATS --}}
    <div class="lp-stats">
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#064e3b,#10b981);"><i class="fas fa-users"></i></div>
            <div class="lp-stat-val">{{ $totalPenghuni }}</div>
            <div class="lp-stat-lbl">Penghuni</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#0d7377,#14a085);"><i class="fas fa-home"></i></div>
            <div class="lp-stat-val">{{ $totalRumah }}</div>
            <div class="lp-stat-lbl">Rumah</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#b45309,#d97706);"><i class="fas fa-money-bill-wave"></i></div>
            <div class="lp-stat-val" style="font-size:14px;">Rp {{ number_format($totalIuran,0,',','.') }}</div>
            <div class="lp-stat-lbl">Total Iuran</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#0369a1,#0284c7);"><i class="fas fa-wallet"></i></div>
            <div class="lp-stat-val" style="font-size:14px;">Rp {{ number_format($saldoKas,0,',','.') }}</div>
            <div class="lp-stat-lbl">Saldo Kas</div>
        </div>
        <div class="lp-stat">
            <div class="lp-stat-icon" style="background:linear-gradient(135deg,#be123c,#e11d48);"><i class="fas fa-bullhorn"></i></div>
            <div class="lp-stat-val">{{ $dataPengaduan->count() }}</div>
            <div class="lp-stat-lbl">Pengaduan</div>
        </div>
    </div>

    {{-- TABEL IURAN --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <i class="fas fa-file-invoice-dollar" style="color:#064e3b;"></i>
            <h5>Data Iuran</h5>
            <span>{{ $dataIuran->count() }} iuran periode ini</span>
        </div>
        @if($dataIuran->count() > 0)
        <table class="lp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penghuni</th>
                    <th>Bulan/Tahun</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataIuran as $i => $iuran)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $iuran->penghuni->nama ?? '-' }}</td>
                    <td>{{ $iuran->bulan }} {{ $iuran->tahun }}</td>
                    <td>{{ $iuran->jenis_iuran ?? '-' }}</td>
                    <td>Rp {{ number_format($iuran->jumlah,0,',','.') }}</td>
                    <td><span class="lp-badge bg-{{ $iuran->status }}">{{ ucfirst($iuran->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="lp-empty">Tidak ada data iuran periode ini.</div>
        @endif
    </div>

    {{-- TABEL KAS --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <i class="fas fa-coins" style="color:#064e3b;"></i>
            <h5>Kas Bendahara</h5>
            <span>{{ $dataKas->count() }} transaksi periode ini</span>
        </div>
        @if($dataKas->count() > 0)
        <table class="lp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataKas as $i => $kas)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $kas->created_at->format('d M Y') }}</td>
                    <td><span class="lp-badge bg-{{ $kas->jenis }}">{{ ucfirst($kas->jenis) }}</span></td>
                    <td>Rp {{ number_format($kas->jumlah,0,',','.') }}</td>
                    <td>{{ $kas->keterangan }}</td>
                    <td><span class="lp-badge" style="background:#f0f4f0;color:#64748b;">{{ ucfirst($kas->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="lp-empty">Tidak ada transaksi kas periode ini.</div>
        @endif
    </div>

    {{-- TABEL PENGADUAN --}}
    <div class="lp-card">
        <div class="lp-card-head">
            <i class="fas fa-bullhorn" style="color:#064e3b;"></i>
            <h5>Data Pengaduan</h5>
            <span>{{ $dataPengaduan->count() }} pengaduan periode ini</span>
        </div>
        @if($dataPengaduan->count() > 0)
        <table class="lp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penghuni</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataPengaduan as $i => $p)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $p->penghuni->nama ?? '-' }}</td>
                    <td>{{ $p->judul ?? $p->pesan ?? '-' }}</td>
                    <td><span class="lp-badge bg-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="lp-empty">Tidak ada pengaduan periode ini.</div>
        @endif
    </div>

</div>
@endsection

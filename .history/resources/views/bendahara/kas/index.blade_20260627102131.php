@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ki-wrapper { max-width: 980px; margin: 0 auto; padding: 28px 16px 60px; }

/* ── HEADER ── */
.ki-page-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; margin-bottom: 24px; flex-wrap: wrap;
}
.ki-page-header-left { display: flex; align-items: center; gap: 14px; }
.ki-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #064e3b, #059669);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
}
.ki-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ki-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ki-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 16px; border: none; border-radius: 11px;
    font-size: 13px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; text-decoration: none; white-space: nowrap;
    transition: opacity 0.15s, transform 0.1s;
}
.ki-btn:hover { opacity: 0.88; transform: translateY(-1px); text-decoration: none; }
.ki-btn-tagihan { background: linear-gradient(135deg, #065f46, #059669); color: #fff; }

.ki-alert-success {
    background: #f0faf4; border: 1px solid #a8e6be;
    border-left: 4px solid #059669; border-radius: 12px;
    padding: 12px 16px; color: #1a4e2a;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 20px;
}

/* ── SUMMARY CARDS ── */
.ki-summary-row {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 14px; margin-bottom: 22px;
}
.ki-summary-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 16px; display: flex; align-items: center; gap: 13px;
}
.ki-summary-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.ki-summary-icon.masuk  { background: #d1fae5; color: #059669; }
.ki-summary-icon.keluar { background: #fee2e2; color: #dc2626; }
.ki-summary-icon.saldo  { background: #dbeafe; color: #1d4ed8; }
.ki-summary-label { font-size: 11.5px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
.ki-summary-val   { font-size: 16px; font-weight: 800; color: #1a2e1a; margin-top: 2px; line-height: 1.2; }
.ki-summary-val.masuk  { color: #059669; }
.ki-summary-val.keluar { color: #dc2626; }
.ki-summary-val.saldo  { color: #1d4ed8; }

/* ── CARD ── */
.ki-card {
    background: #fff; border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden; margin-bottom: 20px;
}
.ki-card-header {
    padding: 14px 20px; background: #f6fbf7;
    border-bottom: 1px solid #e8f0e8;
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
}
.ki-card-header-left { display: flex; align-items: center; gap: 10px; }
.ki-card-header-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: #d1fae5; color: #064e3b;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.ki-card-header h6 { font-size: 13px; font-weight: 700; color: #1a2e1a; margin: 0; }
.ki-card-body { padding: 20px; }

/* ── FORM CATAT ── */
.ki-catat-grid {
    display: grid;
    grid-template-columns: 120px 1fr 2fr auto;
    gap: 10px; align-items: end;
}
.ki-form-group { display: flex; flex-direction: column; gap: 6px; }
.ki-label {
    font-size: 11px; font-weight: 700; color: #374151;
    text-transform: uppercase; letter-spacing: 0.4px;
}
.ki-input, .ki-select {
    width: 100%; padding: 10px 12px;
    border: 1.5px solid #e0ede0; border-radius: 10px;
    font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937; outline: none; background: #fafafa;
    transition: border-color 0.15s, box-shadow 0.15s;
    appearance: none; -webkit-appearance: none;
}
.ki-input:focus, .ki-select:focus {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.10);
    background: #fff;
}
.ki-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;
}
.ki-btn-catat {
    padding: 10px 18px; background: linear-gradient(135deg, #065f46, #059669);
    color: #fff; border: none; border-radius: 10px;
    font-size: 13px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; white-space: nowrap;
    transition: opacity 0.15s; display: flex; align-items: center; gap: 6px;
}
.ki-btn-catat:hover { opacity: 0.88; }

/* ── TABLE desktop ── */
.ki-table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.ki-table {
    width: 100%; border-collapse: collapse; font-size: 13px; min-width: 680px;
}
.ki-table thead th {
    background: #f6fbf7; color: #3a5a3a;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; padding: 11px 14px;
    border-bottom: 2px solid #e0ede0; white-space: nowrap;
}
.ki-table tbody td {
    padding: 12px 14px; border-bottom: 1px solid #f2f7f2;
    color: #2a3a2a; vertical-align: middle;
}
.ki-table tbody tr:last-child td { border-bottom: none; }
.ki-table tbody tr:hover td { background: #f8fdf8; }

/* ── BADGES ── */
.ki-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 11px; font-weight: 600; white-space: nowrap;
}
.ki-badge-masuk   { background: #d1fae5; color: #065f46; }
.ki-badge-keluar  { background: #fee2e2; color: #b91c1c; }
.ki-badge-warning { background: #fefce8; color: #a16207; }
.ki-badge-info    { background: #eff6ff; color: #1d4ed8; }
.ki-badge-success { background: #f0fdf4; color: #15803d; }
.ki-badge-gray    { background: #f3f4f6; color: #4b5563; }

.ki-btn-sm {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 11px; border-radius: 8px;
    font-size: 12px; font-weight: 600; border: none;
    cursor: pointer; text-decoration: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: opacity 0.15s;
}
.ki-btn-sm:hover { opacity: 0.85; text-decoration: none; }
.ki-btn-konfirmasi { background: #d1fae5; color: #065f46; }
.ki-btn-lihat      { background: #eff6ff; color: #1d4ed8; }

/* ── MOBILE CARD LIST ── */
.ki-mobile-list { display: none; padding: 12px; }
.ki-mobile-item {
    background: #fff; border: 1px solid #e8f0e8;
    border-radius: 14px; padding: 15px;
    margin-bottom: 12px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
.ki-mobile-item-header {
    display: flex; align-items: center;
    justify-content: space-between; gap: 10px; margin-bottom: 10px;
}
.ki-mobile-tanggal { font-size: 11.5px; color: #9ca3af; }
.ki-mobile-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 0; border-top: 1px solid #f2f7f2; font-size: 12.5px;
}
.ki-mobile-row-label { color: #9ca3af; font-weight: 600; font-size: 11px; text-transform: uppercase; }
.ki-mobile-keterangan { font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 4px; }
.ki-mobile-penghuni { font-size: 11.5px; color: #6b7280; }
.ki-mobile-actions { display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap; }

@media (max-width: 640px) {
    .ki-wrapper { padding: 16px 12px 48px; }
    .ki-summary-row { grid-template-columns: 1fr; gap: 10px; }
    .ki-summary-card { padding: 13px; }
    .ki-summary-val { font-size: 15px; }
    .ki-catat-grid { grid-template-columns: 1fr 1fr; }
    .ki-catat-grid .ki-form-group:nth-child(3) { grid-column: span 2; }
    .ki-catat-grid .ki-btn-catat { grid-column: span 2; justify-content: center; padding: 11px; }
    .ki-table-wrap { display: none; }
    .ki-mobile-list { display: block; }
    .ki-page-header h1 { font-size: 17px; }
    .ki-btn-tagihan { font-size: 12px; padding: 9px 13px; }
}
</style>

<div class="ki-wrapper">

    {{-- Header --}}
    <div class="ki-page-header">
        <div class="ki-page-header-left">
            <div class="ki-header-icon"><i class="fas fa-wallet"></i></div>
            <div>
                <h1>Kas Bendahara</h1>
                <p>Kelola pemasukan & pengeluaran kas</p>
            </div>
        </div>
        <a href="{{ route('bendahara.kas.tagihan.create') }}" class="ki-btn ki-btn-tagihan">
            <i class="fas fa-file-invoice"></i> Tagih Kas ke Penghuni
        </a>
    </div>

    @if(session('success'))
        <div class="ki-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Summary --}}
    <div class="ki-summary-row">
        <div class="ki-summary-card">
            <div class="ki-summary-icon masuk"><i class="fas fa-arrow-down"></i></div>
            <div>
                <div class="ki-summary-label">Total Masuk</div>
                <div class="ki-summary-val masuk">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="ki-summary-card">
            <div class="ki-summary-icon keluar"><i class="fas fa-arrow-up"></i></div>
            <div>
                <div class="ki-summary-label">Total Keluar</div>
                <div class="ki-summary-val keluar">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="ki-summary-card">
            <div class="ki-summary-icon saldo"><i class="fas fa-coins"></i></div>
            <div>
                <div class="ki-summary-label">Saldo</div>
                <div class="ki-summary-val saldo">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Form Catat Manual --}}
    <div class="ki-card" style="margin-bottom:20px;">
        <div class="ki-card-header">
            <div class="ki-card-header-left">
                <div class="ki-card-header-icon"><i class="fas fa-pencil-alt"></i></div>
                <h6>Catat Kas Manual (Masuk / Keluar)</h6>
            </div>
        </div>
        <div class="ki-card-body">
            <form action="{{ route('bendahara.kas.store') }}" method="POST">
                @csrf
                <div class="ki-catat-grid">
                    <div class="ki-form-group">
                        <label class="ki-label">Jenis</label>
                        <select name="jenis" class="ki-select" required>
                            <option value="masuk">Masuk</option>
                            <option value="keluar">Keluar</option>
                        </select>
                    </div>
                    <div class="ki-form-group">
                        <label class="ki-label">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="ki-input" placeholder="0" required min="0">
                    </div>
                    <div class="ki-form-group">
                        <label class="ki-label">Keterangan</label>
                        <input type="text" name="keterangan" class="ki-input" placeholder="Keterangan kas..." required>
                    </div>
                    <button type="submit" class="ki-btn-catat">
                        <i class="fas fa-plus"></i> Catat
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Riwayat Kas --}}
    <div class="ki-card">
        <div class="ki-card-header">
            <div class="ki-card-header-left">
                <div class="ki-card-header-icon"><i class="fas fa-history"></i></div>
                <h6>Riwayat Kas</h6>
            </div>
        </div>

        {{-- TABLE desktop --}}
        <div class="ki-table-wrap">
            <table class="ki-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kas as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="white-space:nowrap;font-size:12px;">
                            {{ $k->created_at->format('d M Y') }}<br>
                            <span style="color:#9ca3af;">{{ $k->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            @if($k->jenis === 'masuk')
                                <span class="ki-badge ki-badge-masuk"><i class="fas fa-arrow-down" style="font-size:9px"></i> Masuk</span>
                            @else
                                <span class="ki-badge ki-badge-keluar"><i class="fas fa-arrow-up" style="font-size:9px"></i> Keluar</span>
                            @endif
                        </td>
                        <td style="font-weight:700;">
                            <span style="color:{{ $k->jenis === 'masuk' ? '#059669' : '#dc2626' }}">
                                Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                        <td style="max-width:200px;">
                            {{ $k->keterangan }}
                            @if($k->penghuni)
                                <br><small style="color:#9ca3af;">Tagihan: {{ $k->penghuni->nama }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $sc = ['manual'=>'gray','menunggu_bayar'=>'warning','menunggu_konfirmasi'=>'info','lunas'=>'success'][$k->status] ?? 'gray';
                                $sl = ['manual'=>'Manual','menunggu_bayar'=>'Menunggu Bayar','menunggu_konfirmasi'=>'Menunggu Konfirmasi','lunas'=>'Lunas'][$k->status] ?? $k->status;
                            @endphp
                            <span class="ki-badge ki-badge-{{ $sc }}">{{ $sl }}</span>
                        </td>
                        <td>
                            @if($k->bukti_pembayaran)
                                <a href="{{ asset('bukti/'.$k->bukti_pembayaran) }}" target="_blank" class="ki-btn-sm ki-btn-lihat">
                                    <i class="fas fa-eye" style="font-size:10px"></i> Lihat
                                </a>
                            @else
                                <span style="color:#d1d5db;font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($k->status === 'menunggu_konfirmasi')
                                <form action="{{ route('bendahara.kas.konfirmasi', $k->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="ki-btn-sm ki-btn-konfirmasi"
                                        onclick="return confirm('Konfirmasi pembayaran ini?')">
                                        <i class="fas fa-check" style="font-size:10px"></i> Konfirmasi
                                    </button>
                                </form>
                            @else
                                <span style="color:#d1d5db;font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:36px;color:#aaa;">
                            <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada catatan kas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE card list --}}
        <div class="ki-mobile-list">
            @forelse($kas as $k)
            <div class="ki-mobile-item">
                <div class="ki-mobile-item-header">
                    <div>
                        <div class="ki-mobile-keterangan">{{ $k->keterangan }}</div>
                        @if($k->penghuni)
                            <div class="ki-mobile-penghuni">Tagihan: {{ $k->penghuni->nama }}</div>
                        @endif
                        <div class="ki-mobile-tanggal">{{ $k->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    @if($k->jenis === 'masuk')
                        <span class="ki-badge ki-badge-masuk"><i class="fas fa-arrow-down" style="font-size:9px"></i> Masuk</span>
                    @else
                        <span class="ki-badge ki-badge-keluar"><i class="fas fa-arrow-up" style="font-size:9px"></i> Keluar</span>
                    @endif
                </div>
                <div class="ki-mobile-row">
                    <span class="ki-mobile-row-label">Jumlah</span>
                    <span style="font-weight:800;font-size:14px;color:{{ $k->jenis === 'masuk' ? '#059669' : '#dc2626' }}">
                        Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                    </span>
                </div>
                <div class="ki-mobile-row">
                    <span class="ki-mobile-row-label">Status</span>
                    @php
                        $sc = ['manual'=>'gray','menunggu_bayar'=>'warning','menunggu_konfirmasi'=>'info','lunas'=>'success'][$k->status] ?? 'gray';
                        $sl = ['manual'=>'Manual','menunggu_bayar'=>'Menunggu Bayar','menunggu_konfirmasi'=>'Menunggu Konfirmasi','lunas'=>'Lunas'][$k->status] ?? $k->status;
                    @endphp
                    <span class="ki-badge ki-badge-{{ $sc }}">{{ $sl }}</span>
                </div>
                <div class="ki-mobile-actions">
                    @if($k->status === 'menunggu_konfirmasi')
                        <form action="{{ route('bendahara.kas.konfirmasi', $k->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="ki-btn-sm ki-btn-konfirmasi"
                                onclick="return confirm('Konfirmasi pembayaran ini?')">
                                <i class="fas fa-check"></i> Konfirmasi
                            </button>
                        </form>
                    @endif
                    @if($k->bukti_pembayaran)
                        <a href="{{ asset('bukti/'.$k->bukti_pembayaran) }}" target="_blank" class="ki-btn-sm ki-btn-lihat">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px 20px;color:#aaa;">
                <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;opacity:.4;"></i>
                Belum ada catatan kas
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

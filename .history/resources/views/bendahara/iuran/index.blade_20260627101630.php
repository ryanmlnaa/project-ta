@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ii-wrapper { max-width: 960px; margin: 0 auto; padding: 28px 16px 60px; }

.ii-page-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; margin-bottom: 24px; flex-wrap: wrap;
}
.ii-page-header-left { display: flex; align-items: center; gap: 14px; }
.ii-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #064e3b, #059669);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
}
.ii-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ii-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ii-btn-ajukan {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px;
    background: linear-gradient(135deg, #065f46, #059669);
    color: #fff; border: none; border-radius: 11px;
    font-size: 13px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none; cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    white-space: nowrap;
}
.ii-btn-ajukan:hover { opacity: 0.88; transform: translateY(-1px); color: #fff; text-decoration: none; }

.ii-alert-success {
    background: #f0faf4; border: 1px solid #a8e6be;
    border-left: 4px solid #059669; border-radius: 12px;
    padding: 12px 16px; color: #1a4e2a;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 20px;
}

/* ── CARD ── */
.ii-card {
    background: #fff; border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}
.ii-card-header {
    padding: 14px 20px; background: #f6fbf7;
    border-bottom: 1px solid #e8f0e8;
    display: flex; align-items: center; gap: 10px;
}
.ii-card-header-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: #d1fae5; color: #064e3b;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
}
.ii-card-header h6 { font-size: 13px; font-weight: 700; color: #1a2e1a; margin: 0; }

/* ── TABLE (desktop) ── */
.ii-table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.ii-table {
    width: 100%; border-collapse: collapse; font-size: 13px;
    min-width: 700px;
}
.ii-table thead th {
    background: #f6fbf7; color: #3a5a3a;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 11px 14px; border-bottom: 2px solid #e0ede0;
    white-space: nowrap;
}
.ii-table tbody td {
    padding: 12px 14px; border-bottom: 1px solid #f2f7f2;
    color: #2a3a2a; vertical-align: middle;
}
.ii-table tbody tr:last-child td { border-bottom: none; }
.ii-table tbody tr:hover td { background: #f8fdf8; }

/* ── BADGES ── */
.ii-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 11.5px; font-weight: 600; white-space: nowrap;
}
.ii-badge-warning { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
.ii-badge-danger  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.ii-badge-info    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.ii-badge-primary { background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; }
.ii-badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.ii-badge-gray    { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }

/* ── ACTION BUTTONS ── */
.ii-btn-sm {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px;
    font-size: 12px; font-weight: 600;
    border: none; cursor: pointer; text-decoration: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: opacity 0.15s, transform 0.1s;
    white-space: nowrap;
}
.ii-btn-sm:hover { opacity: 0.85; transform: translateY(-1px); text-decoration: none; }
.ii-btn-edit    { background: #fef3c7; color: #92400e; }
.ii-btn-lunas   { background: #d1fae5; color: #065f46; }
.ii-btn-lihat   { background: #eff6ff; color: #1d4ed8; }

/* ── MOBILE CARD VIEW ── */
.ii-mobile-list { display: none; padding: 12px; }
.ii-mobile-item {
    background: #fff; border: 1px solid #e8f0e8;
    border-radius: 14px; padding: 16px;
    margin-bottom: 12px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
.ii-mobile-item-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 10px;
    margin-bottom: 10px;
}
.ii-mobile-nama { font-size: 14px; font-weight: 700; color: #1a2e1a; }
.ii-mobile-periode { font-size: 12px; color: #6b7280; margin-top: 2px; }
.ii-mobile-row {
    display: flex; justify-content: space-between;
    align-items: center; padding: 7px 0;
    border-top: 1px solid #f2f7f2; font-size: 12.5px;
}
.ii-mobile-row-label { color: #9ca3af; font-weight: 600; font-size: 11px; text-transform: uppercase; }
.ii-mobile-row-val   { color: #1f2937; font-weight: 600; text-align: right; }
.ii-mobile-catatan {
    background: #fef2f2; border-radius: 8px;
    padding: 8px 10px; font-size: 12px;
    color: #7a1a1a; margin-top: 8px;
    border-left: 3px solid #ef4444;
}
.ii-mobile-actions { margin-top: 10px; display: flex; gap: 8px; flex-wrap: wrap; }

@media (max-width: 640px) {
    .ii-wrapper { padding: 16px 12px 48px; }
    .ii-page-header { gap: 10px; }
    .ii-page-header h1 { font-size: 17px; }
    .ii-table-wrap { display: none; }
    .ii-mobile-list { display: block; }
    .ii-btn-ajukan { font-size: 12px; padding: 9px 14px; }
}
</style>

<div class="ii-wrapper">

    {{-- Header --}}
    <div class="ii-page-header">
        <div class="ii-page-header-left">
            <div class="ii-header-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div>
                <h1>Daftar Iuran</h1>
                <p>Kelola pengajuan iuran penghuni</p>
            </div>
        </div>
        <a href="{{ route('bendahara.iuran.create') }}" class="ii-btn-ajukan">
            <i class="fas fa-plus"></i> Ajukan Iuran
        </a>
    </div>

    @if(session('success'))
        <div class="ii-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="ii-card">
        <div class="ii-card-header">
            <div class="ii-card-header-icon"><i class="fas fa-list"></i></div>
            <h6>Riwayat Iuran</h6>
        </div>

        {{-- TABLE — desktop --}}
        <div class="ii-table-wrap">
            <table class="ii-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Penghuni</th>
                        <th>Bulan/Tahun</th>
                        <th>Jumlah</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Catatan RT</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($iurans as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $i->penghuni->nama ?? '-' }}</strong></td>
                        <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                        <td>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $i->jenis_iuran }}</td>
                        <td>
                            @php
                                $cls = ['diajukan'=>'warning','ditolak'=>'danger','aktif'=>'info','menunggu'=>'primary','lunas'=>'success'][$i->status] ?? 'gray';
                                $icon = ['diajukan'=>'clock','ditolak'=>'times-circle','aktif'=>'check','menunggu'=>'hourglass-half','lunas'=>'check-circle'][$i->status] ?? 'circle';
                            @endphp
                            <span class="ii-badge ii-badge-{{ $cls }}">
                                <i class="fas fa-{{ $icon }}" style="font-size:9px"></i>
                                {{ ucfirst($i->status) }}
                            </span>
                        </td>
                        <td style="max-width:160px;">
                            <span style="font-size:12px;color:#6b7280;">{{ $i->catatan_rt ?? '-' }}</span>
                        </td>
                        <td>
                            @if($i->bukti_pembayaran)
                                <a href="{{ asset('bukti/'.$i->bukti_pembayaran) }}" target="_blank" class="ii-btn-sm ii-btn-lihat">
                                    <i class="fas fa-eye" style="font-size:10px"></i> Lihat
                                </a>
                            @else
                                <span style="color:#d1d5db;font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            @if($i->status === 'ditolak')
                                <a href="{{ route('bendahara.iuran.edit', $i->id) }}" class="ii-btn-sm ii-btn-edit">
                                    <i class="fas fa-edit" style="font-size:10px"></i> Edit & Ajukan
                                </a>
                            @elseif($i->status === 'menunggu')
                                <form action="{{ route('bendahara.iuran.konfirmasi', $i->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button class="ii-btn-sm ii-btn-lunas"
                                        onclick="return confirm('Konfirmasi iuran ini lunas?')">
                                        <i class="fas fa-check-circle" style="font-size:10px"></i> Konfirmasi Lunas
                                    </button>
                                </form>
                            @else
                                <span style="color:#d1d5db;font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:36px;color:#aaa;">
                            <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada iuran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="ii-mobile-list">
            @forelse($iurans as $i)
            <div class="ii-mobile-item">
                <div class="ii-mobile-item-header">
                    <div>
                        <div class="ii-mobile-nama">{{ $i->penghuni->nama ?? '-' }}</div>
                        <div class="ii-mobile-periode">{{ $i->bulan }} {{ $i->tahun }} · {{ $i->jenis_iuran }}</div>
                    </div>
                    @php
                        $cls = ['diajukan'=>'warning','ditolak'=>'danger','aktif'=>'info','menunggu'=>'primary','lunas'=>'success'][$i->status] ?? 'gray';
                        $icon = ['diajukan'=>'clock','ditolak'=>'times-circle','aktif'=>'check','menunggu'=>'hourglass-half','lunas'=>'check-circle'][$i->status] ?? 'circle';
                    @endphp
                    <span class="ii-badge ii-badge-{{ $cls }}">
                        <i class="fas fa-{{ $icon }}" style="font-size:9px"></i>
                        {{ ucfirst($i->status) }}
                    </span>
                </div>

                <div class="ii-mobile-row">
                    <span class="ii-mobile-row-label">Jumlah</span>
                    <span class="ii-mobile-row-val" style="color:#059669;font-weight:700;">
                        Rp {{ number_format($i->jumlah, 0, ',', '.') }}
                    </span>
                </div>

                @if($i->catatan_rt)
                <div class="ii-mobile-catatan">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <strong>Catatan RT:</strong> {{ $i->catatan_rt }}
                </div>
                @endif

                <div class="ii-mobile-actions">
                    @if($i->status === 'ditolak')
                        <a href="{{ route('bendahara.iuran.edit', $i->id) }}" class="ii-btn-sm ii-btn-edit">
                            <i class="fas fa-edit"></i> Edit & Ajukan Ulang
                        </a>
                    @elseif($i->status === 'menunggu')
                        <form action="{{ route('bendahara.iuran.konfirmasi', $i->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <button class="ii-btn-sm ii-btn-lunas"
                                onclick="return confirm('Konfirmasi iuran ini lunas?')">
                                <i class="fas fa-check-circle"></i> Konfirmasi Lunas
                            </button>
                        </form>
                    @endif
                    @if($i->bukti_pembayaran)
                        <a href="{{ asset('bukti/'.$i->bukti_pembayaran) }}" target="_blank" class="ii-btn-sm ii-btn-lihat">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px 20px;color:#aaa;">
                <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;opacity:.4;"></i>
                Belum ada iuran
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

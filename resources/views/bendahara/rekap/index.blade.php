@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ri-wrapper { max-width: 860px; margin: 0 auto; padding: 28px 16px 60px; }

/* ── HEADER ── */
.ri-page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
}
.ri-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #064e3b, #059669);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
}
.ri-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ri-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ri-alert-success {
    background: #f0faf4; border: 1px solid #a8e6be;
    border-left: 4px solid #059669; border-radius: 12px;
    padding: 12px 16px; color: #1a4e2a;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}
.ri-alert-error {
    background: #fdf0f0; border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444; border-radius: 12px;
    padding: 12px 16px; color: #7a1a1a;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}

/* ── CARD ── */
.ri-card {
    background: #fff; border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden; margin-bottom: 20px;
}
.ri-card-header {
    padding: 14px 20px; background: #f6fbf7;
    border-bottom: 1px solid #e8f0e8;
    display: flex; align-items: center; gap: 10px;
}
.ri-card-header-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: #d1fae5; color: #064e3b;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
}
.ri-card-header h6 { font-size: 13px; font-weight: 700; color: #1a2e1a; margin: 0; }
.ri-card-body { padding: 20px; }

/* ── STAT BOX ── */
.ri-stat-box {
    display: flex; align-items: center; gap: 14px;
    background: #f6fbf7; border: 1px solid #e0ede0;
    border-radius: 12px; padding: 14px 16px; margin-bottom: 16px;
}
.ri-stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: #d1fae5; color: #059669;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; flex-shrink: 0;
}
.ri-stat-label { font-size: 11.5px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }
.ri-stat-val   { font-size: 22px; font-weight: 800; color: #059669; line-height: 1.1; margin-top: 2px; }

/* ── PREVIEW TABLE ── */
.ri-preview-table-wrap { width: 100%; overflow-x: auto; margin-bottom: 16px; }
.ri-preview-table {
    width: 100%; border-collapse: collapse; font-size: 13px; min-width: 380px;
}
.ri-preview-table thead th {
    background: #f6fbf7; color: #3a5a3a; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 10px 14px; border-bottom: 2px solid #e0ede0;
}
.ri-preview-table tbody td {
    padding: 10px 14px; border-bottom: 1px solid #f2f7f2; color: #2a3a2a;
}
.ri-preview-table tbody tr:last-child td { border-bottom: none; }

/* ── PERIODE INPUT ── */
.ri-form-group { margin-bottom: 16px; }
.ri-label {
    display: block; font-size: 11.5px; font-weight: 700;
    color: #374151; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 7px;
}
.ri-input {
    width: 100%; padding: 10px 13px;
    border: 1.5px solid #e0ede0; border-radius: 10px;
    font-size: 13.5px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #6b7280; outline: none;
    background: #f3f4f6; cursor: not-allowed;
}

.ri-btn-kirim {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 22px; background: linear-gradient(135deg, #065f46, #059669);
    color: #fff; border: none; border-radius: 11px;
    font-size: 13.5px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: opacity 0.15s, transform 0.1s;
}
.ri-btn-kirim:hover { opacity: 0.88; transform: translateY(-1px); }
.ri-btn-kirim:active { transform: translateY(0); }

.ri-empty-rekap {
    text-align: center; padding: 28px 20px;
    color: #9ca3af; font-size: 13px;
    background: #f9fafb; border-radius: 12px;
}

/* ── RIWAYAT TABLE desktop ── */
.ri-table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.ri-table {
    width: 100%; border-collapse: collapse; font-size: 13px; min-width: 480px;
}
.ri-table thead th {
    background: #f6fbf7; color: #3a5a3a; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 11px 14px; border-bottom: 2px solid #e0ede0; white-space: nowrap;
}
.ri-table tbody td {
    padding: 12px 14px; border-bottom: 1px solid #f2f7f2;
    color: #2a3a2a; vertical-align: middle;
}
.ri-table tbody tr:last-child td { border-bottom: none; }
.ri-table tbody tr:hover td { background: #f8fdf8; }

/* ── BADGES ── */
.ri-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 11.5px; font-weight: 600; white-space: nowrap;
}
.ri-badge-warning  { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
.ri-badge-danger   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.ri-badge-success  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.ri-badge-gray     { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }

.ri-btn-sm {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 12px; border-radius: 8px;
    font-size: 12px; font-weight: 600; border: none;
    cursor: pointer; text-decoration: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: opacity 0.15s;
}
.ri-btn-sm:hover { opacity: 0.85; text-decoration: none; }
.ri-btn-detail { background: #eff6ff; color: #1d4ed8; }

/* ── MOBILE CARD LIST ── */
.ri-mobile-list { display: none; padding: 12px; }
.ri-mobile-item {
    background: #fff; border: 1px solid #e8f0e8;
    border-radius: 14px; padding: 15px; margin-bottom: 12px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.05);
}
.ri-mobile-item-header {
    display: flex; align-items: center;
    justify-content: space-between; gap: 10px; margin-bottom: 10px;
}
.ri-mobile-periode { font-size: 14px; font-weight: 700; color: #1a2e1a; }
.ri-mobile-catatan {
    background: #fef2f2; border-radius: 8px;
    padding: 8px 10px; font-size: 12px; color: #7a1a1a;
    margin-top: 8px; border-left: 3px solid #ef4444;
}
.ri-mobile-actions { margin-top: 10px; }

@media (max-width: 640px) {
    .ri-wrapper { padding: 16px 12px 48px; }
    .ri-card-body { padding: 14px; }
    .ri-page-header h1 { font-size: 17px; }
    .ri-table-wrap { display: none; }
    .ri-mobile-list { display: block; }
    .ri-btn-kirim { width: 100%; justify-content: center; }
    .ri-stat-val { font-size: 19px; }
}
</style>

<div class="ri-wrapper">

    {{-- Header --}}
    <div class="ri-page-header">
        <div class="ri-header-icon"><i class="fas fa-chart-pie"></i></div>
        <div>
            <h1>Rekap Iuran</h1>
            <p>Kirim rekap iuran bulanan ke RT</p>
        </div>
    </div>

    @if(session('success'))
        <div class="ri-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->has('rekap'))
        <div class="ri-alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first('rekap') }}
        </div>
    @endif

    {{-- Form Kirim Rekap Baru --}}
    <div class="ri-card">
        <div class="ri-card-header">
            <div class="ri-card-header-icon"><i class="fas fa-paper-plane"></i></div>
            <h6>Kirim Rekap Baru ke RT</h6>
        </div>
        <div class="ri-card-body">

            {{-- Stat: jumlah iuran siap rekap --}}
            <div class="ri-stat-box">
                <div class="ri-stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <div>
                    <div class="ri-stat-label">Iuran Siap Direkap</div>
                    <div class="ri-stat-val">{{ $iuranSiapRekap->count() }} item</div>
                </div>
            </div>

            @if($iuranSiapRekap->count() > 0)

                {{-- Preview iuran --}}
                <div class="ri-preview-table-wrap">
                    <table class="ri-preview-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Penghuni</th>
                                <th>Bulan / Tahun</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iuranSiapRekap as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $i->penghuni->nama ?? '-' }}</strong></td>
                                <td>{{ $i->bulan }} {{ $i->tahun }}</td>
                                <td style="font-weight:700;color:#059669;">
                                    Rp {{ number_format($i->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="font-weight:700;color:#374151;padding:10px 14px;border-top:2px solid #e0ede0;font-size:12px;">
                                    TOTAL
                                </td>
                                <td style="font-weight:800;color:#059669;padding:10px 14px;border-top:2px solid #e0ede0;">
                                    Rp {{ number_format($iuranSiapRekap->sum('jumlah'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <form action="{{ route('bendahara.rekap.store') }}" method="POST">
                    @csrf
                    <div class="ri-form-group">
                        <label class="ri-label"><i class="fas fa-calendar-alt me-1"></i> Periode</label>
                        <input type="text" name="periode" class="ri-input"
                               value="{{ now()->translatedFormat('F Y') }}" readonly>
                    </div>
                    <button type="submit" class="ri-btn-kirim"
                        onclick="return confirm('Kirim rekap ini ke RT?')">
                        <i class="fas fa-paper-plane"></i> Kirim Rekap ke RT
                    </button>
                </form>

            @else
                <div class="ri-empty-rekap">
                    <i class="fas fa-inbox" style="font-size:30px;display:block;margin-bottom:10px;opacity:.4;"></i>
                    Belum ada iuran yang siap direkap
                </div>
            @endif

        </div>
    </div>

    {{-- Riwayat Rekap --}}
    <div class="ri-card">
        <div class="ri-card-header">
            <div class="ri-card-header-icon"><i class="fas fa-history"></i></div>
            <h6>Riwayat Rekap</h6>
        </div>

        {{-- TABLE desktop --}}
        <div class="ri-table-wrap">
            <table class="ri-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Catatan RT</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekaps as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $r->periode }}</strong></td>
                        <td>
                            @php
                                $cls  = ['diajukan'=>'warning','ditolak'=>'danger','disetujui'=>'success'][$r->status] ?? 'gray';
                                $icon = ['diajukan'=>'clock','ditolak'=>'times-circle','disetujui'=>'check-circle'][$r->status] ?? 'circle';
                            @endphp
                            <span class="ri-badge ri-badge-{{ $cls }}">
                                <i class="fas fa-{{ $icon }}" style="font-size:9px"></i>
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td style="max-width:200px;font-size:12px;color:#6b7280;">
                            {{ $r->catatan_rt ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('bendahara.rekap.show', $r->id) }}" class="ri-btn-sm ri-btn-detail">
                                <i class="fas fa-eye" style="font-size:10px"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:36px;color:#aaa;">
                            <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;opacity:.4;"></i>
                            Belum ada riwayat rekap
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE card list --}}
        <div class="ri-mobile-list">
            @forelse($rekaps as $r)
            <div class="ri-mobile-item">
                <div class="ri-mobile-item-header">
                    <div class="ri-mobile-periode">{{ $r->periode }}</div>
                    @php
                        $cls  = ['diajukan'=>'warning','ditolak'=>'danger','disetujui'=>'success'][$r->status] ?? 'gray';
                        $icon = ['diajukan'=>'clock','ditolak'=>'times-circle','disetujui'=>'check-circle'][$r->status] ?? 'circle';
                    @endphp
                    <span class="ri-badge ri-badge-{{ $cls }}">
                        <i class="fas fa-{{ $icon }}" style="font-size:9px"></i>
                        {{ ucfirst($r->status) }}
                    </span>
                </div>
                @if($r->catatan_rt)
                <div class="ri-mobile-catatan">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <strong>Catatan RT:</strong> {{ $r->catatan_rt }}
                </div>
                @endif
                <div class="ri-mobile-actions">
                    <a href="{{ route('bendahara.rekap.show', $r->id) }}" class="ri-btn-sm ri-btn-detail">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px 20px;color:#aaa;">
                <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;opacity:.4;"></i>
                Belum ada riwayat rekap
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

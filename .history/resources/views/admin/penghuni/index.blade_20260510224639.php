@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

body { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
}

.page-header-icon {
    width: 46px;
    height: 46px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}

.page-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #1a2e1a;
    margin: 0;
    line-height: 1.2;
}

.page-header p {
    font-size: 13px;
    color: #8a9e8a;
    margin: 0;
}

/* ── ALERT ── */
.alert-success-custom {
    background: #f0faf4;
    border: 1px solid #a8e6be;
    border-left: 4px solid #1a6e3a;
    border-radius: 12px;
    padding: 12px 16px;
    color: #1a4e2a;
    font-size: 13.5px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}

/* ── CARD ── */
.premium-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    margin-bottom: 24px;
    overflow: hidden;
}

.premium-card-header {
    padding: 16px 22px;
    background: #ffffff;
    border-bottom: 1px solid #f0f5f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.premium-card-header .header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.header-icon.green { background: #d1fae5; color: #064e3b; }
.header-icon.blue  { background: #eaf0fb; color: #1a4e8e; }

.premium-card-header h6 {
    font-size: 14px;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0;
}

.premium-card-body { padding: 20px 22px; }

/* ── KAVLING GRID ── */
.kavling-legend {
    display: flex;
    gap: 16px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12.5px;
    color: #5a6e5a;
    font-weight: 500;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 4px;
}

.legend-dot.kosong { background: #064e3b; }
.legend-dot.terisi { background: #e53e3e; }

.kavling-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 8px;
}

.kavling {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 52px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    color: white;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.15s;
    position: relative;
    user-select: none;
}

.kavling span.kav-label {
    font-size: 9px;
    font-weight: 500;
    opacity: 0.75;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 1px;
}

.kosong {
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    box-shadow: 0 2px 8px rgba(6,78,59,0.3);
}

.terisi {
    background: linear-gradient(135deg, #c53030, #e53e3e);
    cursor: not-allowed;
    box-shadow: 0 2px 8px rgba(197,48,48,0.25);
}

.kosong:hover {
    box-shadow: 0 6px 18px rgba(6,78,59,0.4);
}

/* ── TABLE ── */
.table-responsive { overflow-x: auto !important; -webkit-overflow-scrolling: touch; }

.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
}

.premium-table thead tr th {
    background: #f6fbf7;
    color: #3a5a3a;
    font-weight: 700;
    font-size: 11.5px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 11px 14px;
    border-bottom: 2px solid #e0ede0;
    white-space: nowrap;
}

.premium-table thead tr th:first-child { border-radius: 10px 0 0 0; }
.premium-table thead tr th:last-child  { border-radius: 0 10px 0 0; }

.premium-table tbody tr td {
    padding: 11px 14px;
    border-bottom: 1px solid #f2f7f2;
    color: #2a3a2a;
    vertical-align: middle;
}

.premium-table tbody tr:hover td {
    background: #f8fdf8;
}

.premium-table tbody tr:last-child td { border-bottom: none; }

/* badges */
.badge-pill-custom {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 600;
}

.badge-green  { background: #eaf7f0; color: #1a6e3a; }
.badge-red    { background: #fdf0f0; color: #c53030; }
.badge-yellow { background: #fdfbea; color: #7a6010; }

.btn-tambah {
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    box-shadow: 0 3px 10px rgba(6,78,59,0.3);
}

/* action buttons */
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 11px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: opacity 0.15s, transform 0.1s;
    position: relative !important;
    z-index: 9999 !important;
}

.btn-action:hover { opacity: 0.85; transform: translateY(-1px); }
.btn-action:active { transform: translateY(0); }

.btn-action.info   { background: #eaf0fb; color: #1a4e8e; }
.btn-action.warn   { background: #fdf8ea; color: #8a6000; }
.btn-action.danger { background: #fdf0f0; color: #c53030; }

/* ── MODAL ── */
.modal-content {
    border-radius: 16px !important;
    border: none !important;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
}

.modal-header-custom {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #10b981 100%);
    padding: 18px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-header-custom h5 {
    color: white;
    font-size: 15px;
    font-weight: 700;
    margin: 0;
}

.modal-header-custom .modal-icon {
    width: 34px;
    height: 34px;
    background: rgba(255,255,255,0.18);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.modal-detail-body {
    padding: 22px 24px;
}

.modal-detail-body button[type="submit"] {
    background: linear-gradient(135deg, #064e3b, #10b981) !important;
}

.detail-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #f2f7f2;
}

.detail-row:last-child { border-bottom: none; }

.detail-row .detail-icon {
    width: 30px;
    height: 30px;
    background: #ecfdf5;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #064e3b;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 1px;
}

.detail-row .detail-label {
    font-size: 11px;
    color: #8a9e8a;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.detail-row .detail-value {
    font-size: 13.5px;
    color: #1a2e1a;
    font-weight: 600;
}

.detail-section-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #064e3b;
    padding: 14px 0 6px;
    border-top: 2px dashed #d1fae5;
    margin-top: 6px;
}

/* DataTable pagination styling - FIXED */
.dataTables_wrapper {
    padding: 0;
}

.dataTables_wrapper > div:first-child {
    padding: 14px 22px 10px;
    border-bottom: 1px solid #f0f5f0;
}

.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    font-size: 13px;
    color: #5a6e5a;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 9px;
    border: 1.5px solid #e0ede0;
    padding: 6px 12px;
    font-size: 13px;
    outline: none;
    margin-left: 6px;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #1a6e3a;
    box-shadow: 0 0 0 3px rgba(26,110,58,0.12);
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 9px;
    border: 1.5px solid #e0ede0;
    padding: 5px 10px;
    font-size: 13px;
    margin: 0 6px;
}

/* Bottom bar */
.dataTables_wrapper .dataTables_info {
    font-size: 12.5px;
    color: #8a9e8a;
    font-weight: 500;
    padding: 0;
    line-height: 36px;
}

div.dataTables_wrapper div.dataTables_paginate {
    display: flex !important;
    align-items: center;
    gap: 3px;
    margin: 0;
    padding: 0;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 0;
}

/* Semua tombol paginate */
div.dataTables_wrapper div.dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    width: 34px !important;
    height: 34px !important;
    min-width: 34px !important;
    border-radius: 50% !important;
    padding: 0 !important;
    margin: 0 2px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    border: 1.5px solid #e0ede0 !important;
    color: #5a6e5a !important;
    background: #ffffff !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    line-height: 1 !important;
    cursor: pointer !important;
    text-decoration: none !important;
    transition: all 0.15s ease !important;
    box-shadow: none !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
    background: #f0f7ff !important;
    border-color: #90caf9 !important;
    color: #1976d2 !important;
    box-shadow: none !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
    background: #ffffff !important;
    border: 2px solid #2196f3 !important;
    color: #2196f3 !important;
    box-shadow: 0 0 0 3px rgba(33,150,243,0.12) !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled,
div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled:hover {
    color: #c8d8c8 !important;
    border-color: #edf5ed !important;
    background: #fafafa !important;
    cursor: default !important;
    box-shadow: none !important;
}

/* Bottom wrapper padding */
.dataTables_wrapper > div:last-child {
    padding: 14px 22px;
    border-top: 1px solid #f0f5f0;
}

/* ═══════════════════════════════════════════
   RESPONSIVE STYLES
   ═══════════════════════════════════════════ */

/* ── Tablet (≤ 992px) ── */
@media (max-width: 992px) {

    .page-header h1 { font-size: 18px; }
    .page-header p  { font-size: 12px; }

    /* Kavling: 6 kolom */
    .kavling-grid {
        grid-template-columns: repeat(6, 1fr);
        gap: 6px;
    }

    .kavling { height: 48px; font-size: 12px; }
    .kavling span.kav-label { font-size: 8px; }

    /* DataTable top bar — stack vertically */
    .dataTables_wrapper > div:first-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
        padding: 12px 16px 10px;
    }

    .dataTables_wrapper > div:last-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        padding: 12px 16px;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 100%;
        margin-left: 0;
    }

    .dataTables_wrapper .dataTables_filter label {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }

    .premium-card-body { padding: 16px; }
    .premium-card-header { padding: 14px 16px; }
}

/* ── Mobile (≤ 576px) ── */
@media (max-width: 576px) {

    .container-fluid { padding-left: 12px; padding-right: 12px; }

    /* Page header */
    .page-header { gap: 10px; margin-bottom: 20px; }
    .page-header-icon { width: 38px; height: 38px; font-size: 16px; border-radius: 10px; }
    .page-header h1 { font-size: 15px; }
    .page-header p  { font-size: 11px; }

    /* Alert */
    .alert-success-custom { font-size: 12.5px; padding: 10px 14px; }

    /* Card */
    .premium-card { border-radius: 12px; margin-bottom: 16px; }
    .premium-card-header { padding: 12px 14px; }
    .premium-card-header h6 { font-size: 13px; }
    .premium-card-body { padding: 12px; }

    /* Kavling: 5 kolom di mobile */
    .kavling-grid {
        grid-template-columns: repeat(5, 1fr);
        gap: 5px;
    }

    .kavling {
        height: 42px;
        font-size: 11px;
        border-radius: 8px;
    }

    .kavling span.kav-label { display: none; } /* sembunyikan label di mobile kecil */

    /* Legend */
    .kavling-legend { gap: 12px; }
    .legend-item { font-size: 11.5px; }

    /* Table: scroll horizontal */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0;
    }

    .premium-table { min-width: 600px; }  /* tabel penghuni butuh lebih lebar */
    #tablePenghuni { min-width: 860px; }

    .premium-table thead tr th { padding: 9px 10px; font-size: 10.5px; }
    .premium-table tbody tr td { padding: 9px 10px; font-size: 12px; }

    /* Badge lebih kecil */
    .badge-pill-custom { font-size: 10.5px; padding: 3px 8px; }

    /* Action buttons lebih kecil, bungkus vertikal */
    .btn-action { padding: 4px 8px; font-size: 11px; gap: 3px; }
    td[style*="white-space:nowrap"] { white-space: normal !important; }
    .btn-group-action { display: flex; flex-wrap: wrap; gap: 4px; }

    /* DataTable controls */
    .dataTables_wrapper > div:first-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        padding: 10px 12px 8px;
    }

    .dataTables_wrapper > div:last-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        padding: 10px 12px;
    }

    .dataTables_wrapper .dataTables_info { line-height: 1.5; }

    div.dataTables_wrapper div.dataTables_paginate .paginate_button {
        width: 30px !important;
        height: 30px !important;
        min-width: 30px !important;
        font-size: 12px !important;
    }

    /* Modal */
    .modal-dialog { margin: 10px; }
    .modal-content { border-radius: 12px !important; }
    .modal-header-custom { padding: 14px 16px; }
    .modal-header-custom h5 { font-size: 13.5px; }
    .modal-detail-body { padding: 16px; }
    .detail-row .detail-value { font-size: 13px; }
}

/* ── Extra small (≤ 380px) ── */
@media (max-width: 380px) {

    .kavling-grid {
        grid-template-columns: repeat(5, 1fr);
        gap: 4px;
    }

    .kavling { height: 36px; font-size: 10px; border-radius: 6px; }

    .page-header h1 { font-size: 14px; }
}
</style>

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-icon">
            <i class="fas fa-home"></i>
        </div>
        <div>
            <h1>Kelola Data Perumahan</h1>
            <p>Manajemen kavling, penghuni, dan rumah</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- KAVLING VISUAL --}}
    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-left">
                <div class="header-icon green"><i class="fas fa-th"></i></div>
                <h6>Pilih Kavling</h6>
            </div>
        </div>
        <div class="premium-card-body">

            <div class="kavling-legend">
                <div class="legend-item">
                    <div class="legend-dot kosong"></div>
                    Kosong — tersedia
                </div>
                <div class="legend-item">
                    <div class="legend-dot terisi"></div>
                    Terisi — tidak tersedia
                </div>
            </div>

            <div class="kavling-grid">
                @for($i = 1; $i <= 30; $i++)
                    @php $dataRumah = $rumahList->where('no_rumah', $i)->first(); @endphp
                    <div class="kavling {{ !$dataRumah || $dataRumah->status == 'Kosong' ? 'kosong' : 'terisi' }}"
                        onclick="pilihKavling('{{ $dataRumah && $dataRumah->status == 'Terisi' ? '' : $i }}')">
                        {{ $i }}
                        <span class="kav-label">{{ !$dataRumah || $dataRumah->status == 'Kosong' ? 'Kosong' : 'Terisi' }}</span>
                    </div>
                @endfor
            </div>

        </div>
    </div>

    {{-- DATA PENGHUNI --}}
    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-left">
                <div class="header-icon blue"><i class="fas fa-users"></i></div>
                <h6>Data Penghuni</h6>
            </div>
        </div>
        <div class="premium-card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table class="premium-table" id="tablePenghuni">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No KTP</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Blok</th>
                            <th>No Rumah</th>
                            <th>Status</th>
                            <th>Status Huni</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @forelse($penghuni as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $p->nama }}</strong></td>
                                <td>{{ $p->no_ktp }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->telepon }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->rumah->blok ?? '-' }}</td>
                                <td>{{ $p->rumah->no_rumah ?? '-' }}</td>
                                <td>
                                    @if($p->status_huni == 'Kontrak' && $p->tanggal_keluar && now()->gt($p->tanggal_keluar))
                                        <span class="badge-pill-custom badge-red"><i class="fas fa-times-circle" style="font-size:10px"></i> Tidak Aktif</span>
                                    @else
                                        <span class="badge-pill-custom badge-green"><i class="fas fa-check-circle" style="font-size:10px"></i> Aktif</span>
                                    @endif
                                </td>
                                <td><span class="badge-pill-custom badge-yellow">{{ $p->status_huni }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d-m-Y') }}</td>
                                <td>{{ $p->tanggal_keluar ?? '-' }}</td>
                                <td style="white-space:nowrap;">
                                    <div class="btn-group-action">
                                        <a href="{{ route('penghuni.edit', $p->id) }}" class="btn-action warn">
                                            <i class="fas fa-edit" style="font-size:11px"></i> Edit
                                        </a>
                                        <a href="{{ route('penghuni.delete', $p->id) }}" class="btn-action danger"
                                            onclick="return confirm('Yakin hapus?')">
                                            <i class="fas fa-trash" style="font-size:11px"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" style="text-align:center; padding: 32px; color: #aaa;">
                                    <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                    Belum ada data penghuni
                                </td>
                            </tr>
                        @endforelse
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>

    {{-- DATA RUMAH --}}
    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-left">
                <div class="header-icon green"><i class="fas fa-house-user"></i></div>
                <h6>Data Rumah</h6>
            </div>
        </div>
        <div class="premium-card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table class="premium-table" id="tableRumah">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Blok</th>
                            <th>No Rumah</th>
                            <th>Status</th>
                            <th>Luas Tanah</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumahList as $r)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $r->blok }}</strong></td>
                                <td>{{ $r->no_rumah }}</td>
                                <td>
                                    @if($r->status == 'Kosong')
                                        <span class="badge-pill-custom badge-green"><i class="fas fa-check-circle" style="font-size:10px"></i> Kosong</span>
                                    @else
                                        <span class="badge-pill-custom badge-red"><i class="fas fa-times-circle" style="font-size:10px"></i> Terisi</span>
                                    @endif
                                </td>
                                <td>{{ $r->luas_tanah ? $r->luas_tanah . ' m²' : '-' }}</td>
                                <td>
                                    @if($r->harga)
                                        <strong>Rp {{ number_format($r->harga, 0, ',', '.') }}</strong>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $r->keterangan ?? '-' }}</td>
                                <td style="white-space:nowrap;">
                                    <div class="btn-group-action">
                                        <button class="btn-action info btn-detail"
                                            data-blok="{{ $r->blok }}"
                                            data-nomor="{{ $r->no_rumah }}"
                                            data-status="{{ $r->status }}"
                                            data-nama="{{ $r->penghuni->nama ?? 'Kosong' }}"
                                            data-email="{{ $r->penghuni->email ?? '-' }}"
                                            data-telepon="{{ $r->penghuni->telepon ?? '-' }}">
                                            <i class="fas fa-eye" style="font-size:11px"></i> Detail
                                        </button>
                                        <a href="{{ route('rumah.edit', $r->id) }}" class="btn-action warn">
                                            <i class="fas fa-edit" style="font-size:11px"></i> Edit
                                        </a>
                                        <form action="{{ route('rumah.destroy', $r->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action danger" onclick="return confirm('Yakin hapus?')">
                                                <i class="fas fa-trash" style="font-size:11px"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center; padding: 32px; color: #aaa;">
                                    <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                    Belum ada data rumah
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header-custom">
                <div class="modal-icon"><i class="fas fa-home"></i></div>
                <h5>Detail Rumah &amp; Penghuni</h5>
            </div>

            <div class="modal-detail-body">

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <div class="detail-label">Blok</div>
                        <div class="detail-value" id="d_blok">—</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-hashtag"></i></div>
                    <div>
                        <div class="detail-label">Nomor Rumah</div>
                        <div class="detail-value" id="d_nomor">—</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-info-circle"></i></div>
                    <div>
                        <div class="detail-label">Status</div>
                        <div class="detail-value" id="d_status">—</div>
                    </div>
                </div>

                <div class="detail-section-title"><i class="fas fa-user" style="margin-right:6px;"></i>Data Penghuni</div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="detail-label">Nama</div>
                        <div class="detail-value" id="d_nama">—</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="detail-label">Email</div>
                        <div class="detail-value" id="d_email">—</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="detail-label">No HP</div>
                        <div class="detail-value" id="d_telepon">—</div>
                    </div>
                </div>

                <div style="text-align:right; margin-top:18px;">
                    <button class="btn-action info" data-dismiss="modal">
                        <i class="fas fa-times" style="font-size:11px"></i> Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL TAMBAH RUMAH --}}
<div class="modal fade" id="modalRumah">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('rumah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header-custom">
                    <div class="modal-icon"><i class="fas fa-plus"></i></div>
                    <h5>Tambah Data Rumah</h5>
                </div>
                <div class="modal-detail-body">
                    <div style="display:grid; gap:12px;">
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Blok</div>
                            <input type="text" name="blok" class="form-control" placeholder="Masukkan blok" required style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px;">
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">No Rumah</div>
                            <input type="text" name="no_rumah" id="no_rumah" class="form-control" placeholder="Nomor rumah" required style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px;">
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Status</div>
                            <select name="status" class="form-control" style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px;">
                                <option value="Kosong">Kosong</option>
                                <option value="Terisi">Terisi</option>
                            </select>
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Luas Tanah (m²)</div>
                            <input type="number" name="luas_tanah" class="form-control" placeholder="Luas tanah" style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px;">
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Harga</div>
                            <input type="number" name="harga" class="form-control" placeholder="Harga jual" style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px;">
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Keterangan</div>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan tambahan" rows="2" style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13.5px; padding:9px 12px; resize:none;"></textarea>
                        </div>
                        <div>
                            <div class="detail-label" style="margin-bottom:5px;">Foto Kavling</div>
                            <input type="file" name="foto" class="form-control" id="fotoInput" accept="image/*" style="border-radius:9px; border:1.5px solid #e0ede0; font-size:13px; padding:8px 12px;">
                            <div class="text-center mt-2">
                                <img id="previewFoto" src="" style="max-height:140px; display:none; border-radius:10px; object-fit:cover;" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div style="text-align:right; margin-top:18px; display:flex; gap:8px; justify-content:flex-end;">
                        <button type="button" class="btn-action info" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-action" style="background:linear-gradient(135deg,#1a6e3a,#2e9e58); color:white;">
                            <i class="fas fa-save" style="font-size:11px"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function pilihKavling(no) {
    if (!no) { alert('Kavling sudah terisi!'); return; }
    document.getElementById('no_rumah').value = no;
    $('#modalRumah').modal('show');
}

document.getElementById('fotoInput') && document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const img = document.getElementById('previewFoto');
        img.src = ev.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
});
</script>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    if ($.fn.DataTable) {

        $('#tablePenghuni').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: '<"d-flex justify-content-between align-items-center px-3 pt-3"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                },
                emptyTable: "Belum ada data penghuni"
            }
        });

        $('#tableRumah').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: '<"d-flex justify-content-between align-items-center px-3 pt-3"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                },
                emptyTable: "Belum ada data rumah"
            }
        });

    }

    $(document).on('click', '.btn-detail', function () {
        let btn = $(this);
        $('#d_blok').text(btn.data('blok'));
        $('#d_nomor').text(btn.data('nomor'));
        $('#d_status').text(btn.data('status'));
        $('#d_nama').text(btn.data('nama'));
        $('#d_email').text(btn.data('email'));
        $('#d_telepon').text(btn.data('telepon'));
        $('#modalDetail').modal('show');
    });
});
</script>
@endsection

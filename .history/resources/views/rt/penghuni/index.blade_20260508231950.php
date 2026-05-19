@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }

.page-header-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 20px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}

.page-header h1 { font-size: 22px; font-weight: 800; color: #1a2e1a; margin: 0; line-height: 1.2; }
.page-header p  { font-size: 13px; color: #8a9e8a; margin: 0; }

.premium-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    overflow: hidden;
}

.premium-card-header {
    padding: 16px 22px;
    background: #ffffff;
    border-bottom: 1px solid #f0f5f0;
    display: flex; align-items: center; gap: 10px;
}

.header-icon {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}

.header-icon.green { background: #d1fae5; color: #064e3b; }
.premium-card-header h6 { font-size: 14px; font-weight: 700; color: #1a2e1a; margin: 0; }

/* ── TABLE WRAPPER ── */
.table-responsive-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.premium-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; min-width: 900px; }

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

.premium-table tbody tr td {
    padding: 11px 14px;
    border-bottom: 1px solid #f2f7f2;
    color: #2a3a2a;
    vertical-align: middle;
}

.premium-table tbody tr:hover td { background: #f8fdf8; }
.premium-table tbody tr:last-child td { border-bottom: none; }

.badge-pill-custom {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 11.5px; font-weight: 600;
    white-space: nowrap;
}

.badge-green  { background: #eaf7f0; color: #1a6e3a; border: 1px solid #a7f3d0; }
.badge-red    { background: #fdf0f0; color: #c53030; border: 1px solid #fca5a5; }
.badge-yellow { background: #fdfbea; color: #7a6010; border: 1px solid #fde68a; }
.badge-blue   { background: #edf4ff; color: #1a4a8a; border: 1px solid #bfdbfe; }

.btn-action {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 8px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; border: none; text-decoration: none;
    transition: opacity 0.15s, transform 0.1s;
}

.btn-action:hover { opacity: 0.85; transform: translateY(-1px); }
.btn-action.warn   { background: #fdf8ea; color: #8a6000; }
.btn-action.danger { background: #fdf0f0; color: #c53030; }

/* ── MOBILE CARD VIEW ── */
.mobile-card-list { display: none; }

.m-card {
    border: 1px solid #e8f0e8;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: #fff;
}

.m-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    gap: 8px;
}

.m-card-name {
    font-size: 14px;
    font-weight: 700;
    color: #1a2e1a;
}

.m-card-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6px 12px;
    margin-bottom: 12px;
}

.m-card-row { display: flex; flex-direction: column; gap: 1px; }
.m-card-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; }
.m-card-val { font-size: 12.5px; color: #2a3a2a; font-weight: 500; }

.m-card-actions { display: flex; gap: 8px; }

/* ── DATATABLES ── */
.dataTables_wrapper { padding: 0; }

.dataTables_wrapper .dataTables_length label,
.dataTables_wrapper .dataTables_filter label {
    font-size: 13px; color: #5a6e5a; font-weight: 500;
    display: flex; align-items: center; gap: 8px; margin: 0;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 9px; border: 1.5px solid #e0ede0;
    padding: 6px 12px; font-size: 13px; outline: none; margin-left: 6px;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #064e3b; box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 9px; border: 1.5px solid #e0ede0;
    padding: 5px 10px; font-size: 13px; margin: 0 6px;
}

.dataTables_wrapper .dataTables_info {
    font-size: 12.5px; color: #8a9e8a; font-weight: 500; padding: 0; line-height: 36px;
}

div.dataTables_wrapper div.dataTables_paginate {
    display: flex !important; align-items: center; gap: 3px; margin: 0; padding: 0;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button {
    box-sizing: border-box !important;
    width: 34px !important; height: 34px !important; min-width: 34px !important;
    border-radius: 50% !important; padding: 0 !important; margin: 0 2px !important;
    font-size: 13px !important; font-weight: 600 !important;
    border: 1.5px solid #e0ede0 !important; color: #5a6e5a !important;
    background: #ffffff !important;
    display: inline-flex !important; align-items: center !important; justify-content: center !important;
    cursor: pointer !important; text-decoration: none !important;
    transition: all 0.15s ease !important; box-shadow: none !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
    background: #f0fdf4 !important; border-color: #6ee7b7 !important; color: #064e3b !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button.current,
div.dataTables_wrapper div.dataTables_paginate .paginate_button.current:hover {
    background: #ffffff !important; border: 2px solid #064e3b !important;
    color: #064e3b !important; box-shadow: 0 0 0 3px rgba(6,78,59,0.1) !important;
}

div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled,
div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled:hover {
    color: #c8d8c8 !important; border-color: #edf5ed !important;
    background: #fafafa !important; cursor: default !important;
}

.dataTables_wrapper > div:first-child { padding: 14px 22px 10px; border-bottom: 1px solid #f0f5f0; }
.dataTables_wrapper > div:last-child  { padding: 14px 22px; border-top: 1px solid #f0f5f0; }

/* ── RESPONSIVE BREAKPOINTS ── */
@media (max-width: 768px) {
    .page-header h1 { font-size: 18px; }
    .container-fluid { padding-left: 12px; padding-right: 12px; }

    /* Sembunyikan tabel, tampilkan card */
    .desktop-table { display: none; }
    .mobile-card-list { display: block; padding: 12px; }

    .dataTables_wrapper > div:first-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        padding: 12px 14px 10px;
    }

    .dataTables_wrapper > div:last-child {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        padding: 10px 14px 14px;
    }
}

@media (max-width: 480px) {
    .page-header { gap: 10px; }
    .page-header-icon { width: 38px; height: 38px; font-size: 16px; }
    .page-header h1 { font-size: 16px; }
    .m-card-body { grid-template-columns: 1fr; }
}
</style>

<div class="container-fluid">

    <div class="page-header">
        <div class="page-header-icon"><i class="fas fa-users"></i></div>
        <div>
            <h1>Data Penghuni (RT)</h1>
            <p>Daftar lengkap data warga RT</p>
        </div>
    </div>

    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-icon green"><i class="fas fa-users"></i></div>
            <h6>Daftar Penghuni</h6>
        </div>

        {{-- ── DESKTOP TABLE ── --}}
        <div class="desktop-table" style="padding:0;">
            <div class="table-responsive-wrap">
                <table class="premium-table" id="tablePenghuni">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No KTP</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Blok</th>
                            <th>No Rumah</th>
                            <th>Status</th>
                            <th>Status Huni</th>
                            <th>Tgl Masuk</th>
                            <th>Tgl Keluar</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penghuni as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $p->nama }}</strong></td>
                            <td>{{ $p->no_ktp }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->rumah->blok ?? '-' }}</td>
                            <td>{{ $p->rumah->no_rumah ?? '-' }}</td>
                            <td>
                                @if($p->status_huni == 'Kontrak' && $p->tanggal_keluar && now()->gt(\Carbon\Carbon::parse($p->tanggal_keluar)))
                                    <span class="badge-pill-custom badge-red">
                                        <i class="fas fa-times-circle" style="font-size:10px"></i> Tidak Aktif
                                    </span>
                                @else
                                    <span class="badge-pill-custom badge-green">
                                        <i class="fas fa-check-circle" style="font-size:10px"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td><span class="badge-pill-custom badge-yellow">{{ $p->status_huni }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d-m-Y') }}</td>
                            <td>{{ $p->tanggal_keluar ?? '-' }}</td>
                            {{-- <td style="white-space:nowrap;">
                                <a href="{{ route('penghuni.edit', $p->id) }}" class="btn-action warn">
                                    <i class="fas fa-edit" style="font-size:11px"></i> Edit
                                </a>
                                <a href="{{ route('penghuni.delete', $p->id) }}" class="btn-action danger"
                                    onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="fas fa-trash" style="font-size:11px"></i> Hapus
                                </a>
                            </td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" style="text-align:center; padding:40px; color:#aaa;">
                                <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                Belum ada data penghuni
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── MOBILE CARD LIST ── --}}
        <div class="mobile-card-list">
            @forelse($penghuni as $p)
            <div class="m-card">
                <div class="m-card-top">
                    <span class="m-card-name">{{ $loop->iteration }}. {{ $p->nama }}</span>
                    @if($p->status_huni == 'Kontrak' && $p->tanggal_keluar && now()->gt(\Carbon\Carbon::parse($p->tanggal_keluar)))
                        <span class="badge-pill-custom badge-red" style="font-size:10.5px;">
                            <i class="fas fa-times-circle" style="font-size:9px"></i> Tidak Aktif
                        </span>
                    @else
                        <span class="badge-pill-custom badge-green" style="font-size:10.5px;">
                            <i class="fas fa-check-circle" style="font-size:9px"></i> Aktif
                        </span>
                    @endif
                </div>

                <div class="m-card-body">
                    <div class="m-card-row">
                        <span class="m-card-label">No KTP</span>
                        <span class="m-card-val">{{ $p->no_ktp }}</span>
                    </div>
                    <div class="m-card-row">
                        <span class="m-card-label">No HP</span>
                        <span class="m-card-val">{{ $p->telepon ?? '-' }}</span>
                    </div>
                    <div class="m-card-row">
                        <span class="m-card-label">Blok / No Rumah</span>
                        <span class="m-card-val">{{ $p->rumah->blok ?? '-' }} / {{ $p->rumah->no_rumah ?? '-' }}</span>
                    </div>
                    <div class="m-card-row">
                        <span class="m-card-label">Status Huni</span>
                        <span class="m-card-val">
                            <span class="badge-pill-custom badge-yellow" style="font-size:10.5px;">{{ $p->status_huni }}</span>
                        </span>
                    </div>
                    <div class="m-card-row">
                        <span class="m-card-label">Tgl Masuk</span>
                        <span class="m-card-val">{{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d-m-Y') }}</span>
                    </div>
                    <div class="m-card-row">
                        <span class="m-card-label">Tgl Keluar</span>
                        <span class="m-card-val">{{ $p->tanggal_keluar ?? '-' }}</span>
                    </div>
                    <div class="m-card-row" style="grid-column: span 2;">
                        <span class="m-card-label">Alamat</span>
                        <span class="m-card-val">{{ $p->alamat }}</span>
                    </div>
                </div>

                <div class="m-card-actions">
                    <a href="{{ route('penghuni.edit', $p->id) }}" class="btn-action warn" style="flex:1; justify-content:center;">
                        <i class="fas fa-edit" style="font-size:11px"></i> Edit
                    </a>
                    <a href="{{ route('penghuni.delete', $p->id) }}" class="btn-action danger" style="flex:1; justify-content:center;"
                        onclick="return confirm('Yakin hapus data ini?')">
                        <i class="fas fa-trash" style="font-size:11px"></i> Hapus
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:40px; color:#aaa;">
                <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                Belum ada data penghuni
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    if ($.fn.DataTable && window.innerWidth > 768) {
        $('#tablePenghuni').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: '<"d-flex justify-content-between align-items-center px-3 pt-3"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: { first: "«", last: "»", next: "›", previous: "‹" },
                emptyTable: "Belum ada data penghuni"
            }
        });
    }
});
</script>
@endsection

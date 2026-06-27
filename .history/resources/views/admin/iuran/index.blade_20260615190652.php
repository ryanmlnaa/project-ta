@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 28px;
    flex-wrap: wrap;
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
    flex-wrap: wrap;
    gap: 10px;
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
.premium-card-header h6 {
    font-size: 14px;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0;
}

/* ── TAMBAH BUTTON ── */
.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    color: white;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(6,78,59,0.3);
    transition: opacity 0.15s, transform 0.1s;
}
.btn-tambah:hover { opacity: 0.9; transform: translateY(-1px); color: white; text-decoration: none; }

/* ── TABLE WRAPPER (horizontal scroll on mobile) ── */
.table-responsive-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* ── TABLE ── */
.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
    min-width: 860px;
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
.premium-table tbody tr:hover td { background: #f8fdf8; }
.premium-table tbody tr:last-child td { border-bottom: none; }

/* ── MOBILE CARD VIEW ── */
.mobile-iuran-list { display: none; }
.iuran-card {
    border-bottom: 1px solid #f0f5f0;
    padding: 16px 18px;
}
.iuran-card:last-child { border-bottom: none; }
.iuran-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 10px;
    gap: 10px;
}
.iuran-card-name {
    font-size: 14px;
    font-weight: 700;
    color: #1a2e1a;
}
.iuran-card-meta {
    font-size: 12px;
    color: #8a9e8a;
    margin-top: 2px;
}
.iuran-card-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 16px;
    margin-bottom: 12px;
}
.iuran-card-field label {
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: #8a9e8a;
    display: block;
    margin-bottom: 2px;
}
.iuran-card-field span {
    font-size: 13px;
    color: #2a3a2a;
    font-weight: 500;
}
.iuran-card-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #f0f5f0;
}
.iuran-card-bukti {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

/* ── BADGES ── */
.badge-pill-custom {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.badge-green  { background: #d1fae5; color: #064e3b; }
.badge-red    { background: #fdf0f0; color: #c53030; }
.badge-yellow { background: #fdfbea; color: #7a6010; }
.badge-blue   { background: #eaf0fb; color: #1a4e8e; }

/* ── ACTION BUTTONS ── */
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
}
.btn-action:hover { opacity: 0.85; transform: translateY(-1px); text-decoration: none; }
.btn-action:active { transform: translateY(0); }
.btn-action.info    { background: #eaf0fb; color: #1a4e8e; }
.btn-action.warn    { background: #fdf8ea; color: #8a6000; }
.btn-action.danger  { background: #fdf0f0; color: #c53030; }
.btn-action.success { background: #d1fae5; color: #064e3b; }

/* ── BUKTI IMAGE ── */
.bukti-img {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    cursor: pointer;
    transition: transform 0.15s;
}
.bukti-img:hover { transform: scale(1.1); }

/* ── DATATABLES ── */
.dataTables_wrapper { padding: 0; }
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
    max-width: 160px;
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
    flex-wrap: wrap;
}
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
    border: 2px solid #1a6e3a !important;
    color: #1a6e3a !important;
    box-shadow: 0 0 0 3px rgba(26,110,58,0.12) !important;
}
div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled,
div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled:hover {
    color: #c8d8c8 !important;
    border-color: #edf5ed !important;
    background: #fafafa !important;
    cursor: default !important;
    box-shadow: none !important;
}

/* ── RESPONSIVE BREAKPOINTS ── */
@media (max-width: 768px) {
    .page-header h1 { font-size: 18px; }
    .page-header p  { font-size: 12px; }

    /* Hide desktop table, show mobile cards */
    .desktop-table-wrapper { display: none !important; }
    .mobile-iuran-list { display: block; }

    .premium-card-header { padding: 14px 16px; }

    /* DataTables controls stacked */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { width: 100%; }
    .dataTables_wrapper .dataTables_filter input { max-width: 100%; width: 100%; margin-left: 0; margin-top: 4px; }
    .dt-top-bar {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
        padding: 14px 16px !important;
    }
    .dt-bottom-bar {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
        padding: 14px 16px !important;
    }
}

@media (min-width: 769px) {
    .mobile-iuran-list { display: none !important; }
    .desktop-table-wrapper { display: block !important; }
}
</style>

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="page-header-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div>
            <h1>Kelola Data Iuran</h1>
            <p>Manajemen iuran dan pembayaran penghuni</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL IURAN --}}
    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-left">
                <div class="header-icon green"><i class="fas fa-list-alt"></i></div>
                <h6>Daftar Iuran</h6>
            </div>
            @if(auth()->user()->role == 'rt')
                {{-- Tombol Generate Massal --}}
                <button type="button" class="btn-tambah" style="background:linear-gradient(135deg,#1a4e8e,#2563eb);"
                    onclick="$('#modalGenerate').modal('show')">
                    <i class="fas fa-bolt" style="font-size:11px"></i> Generate Semua
                </button>
                <a href="{{ route('iuran.create') }}" class="btn-tambah">
                    <i class="fas fa-plus" style="font-size:11px"></i> Tambah Iuran
                </a>
            @endif
        </div>

        {{-- ══ DESKTOP TABLE ══ --}}
        <div class="desktop-table-wrapper" style="padding: 0;">
            <div class="table-responsive-wrapper">
                <table class="premium-table" id="dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Penghuni</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($iuran as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $i->penghuni->nama ?? '-' }}</strong></td>
                                <td>{{ $i->bulan }}</td>
                                <td>{{ $i->tahun }}</td>
                                <td><strong>Rp {{ number_format($i->jumlah, 0, ',', '.') }}</strong></td>
                                <td>{{ $i->jenis_iuran }}</td>
                                <td>{{ $i->keterangan ?? '-' }}</td>

                                <td>
                                    @if($i->status == 'lunas')
                                        <span class="badge-pill-custom badge-green"><i class="fas fa-check-circle" style="font-size:10px"></i> Lunas</span>
                                    @elseif($i->status == 'rt')
                                        <span class="badge-pill-custom badge-blue"><i class="fas fa-clock" style="font-size:10px"></i> Menunggu Admin</span>
                                    @elseif($i->bukti_pembayaran)
                                        <span class="badge-pill-custom badge-yellow"><i class="fas fa-hourglass-half" style="font-size:10px"></i> Menunggu RT</span>
                                    @else
                                        <span class="badge-pill-custom badge-red"><i class="fas fa-times-circle" style="font-size:10px"></i> Belum Bayar</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $i->tanggal_bayar
                                        ? \Carbon\Carbon::parse($i->tanggal_bayar)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if($i->bukti_pembayaran)
                                        <img src="{{ asset('bukti/' . $i->bukti_pembayaran) }}" class="bukti-img">
                                    @else
                                        <span style="color:#ccc; font-size:12px;">—</span>
                                    @endif
                                </td>

                                <td style="white-space:nowrap;">
                                    @if(auth()->user()->role == 'rt' && $i->status == 'belum' && $i->bukti_pembayaran)
                                        <form action="{{ route('iuran.approve.rt', $i->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn-action warn"><i class="fas fa-check" style="font-size:10px"></i>Approve</button>
                                        </form>
                                    @endif

                                    @if(auth()->user()->role == 'rt')
                                        <a href="{{ route('iuran.edit', $i->id) }}" class="btn-action warn">
                                            <i class="fas fa-edit" style="font-size:10px"></i> Edit
                                        </a>
                                        <form action="{{ route('iuran.destroy', $i->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action danger" onclick="return confirm('Yakin hapus iuran ini?')">
                                                <i class="fas fa-trash" style="font-size:10px"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align:center; padding: 32px; color: #aaa;">
                                    <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                                    Belum ada data iuran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ══ MOBILE CARD VIEW ══ --}}
        <div class="mobile-iuran-list">

            {{-- Mobile search bar --}}
            <div style="padding: 14px 16px; border-bottom: 1px solid #f0f5f0;">
                <input type="text" id="mobileSearch" placeholder="&#xf002; Cari nama penghuni..." oninput="filterMobileCards(this.value)"
                    style="width:100%; border-radius:9px; border:1.5px solid #e0ede0; padding:8px 12px; font-size:13px; font-family:inherit; outline:none;">
            </div>

            <div id="mobileCardContainer">
                @forelse($iuran as $i)
                    <div class="iuran-card" data-nama="{{ strtolower($i->penghuni->nama ?? '') }}">
                        <div class="iuran-card-header">
                            <div>
                                <div class="iuran-card-name">{{ $i->penghuni->nama ?? '-' }}</div>
                                <div class="iuran-card-meta">{{ $i->bulan }} {{ $i->tahun }} &middot; {{ $i->jenis_iuran }}</div>
                            </div>
                            <div>
                                @if($i->status == 'lunas')
                                    <span class="badge-pill-custom badge-green"><i class="fas fa-check-circle" style="font-size:10px"></i> Lunas</span>
                                @elseif($i->status == 'rt')
                                    <span class="badge-pill-custom badge-blue"><i class="fas fa-clock" style="font-size:10px"></i> Menunggu Admin</span>
                                @elseif($i->bukti_pembayaran)
                                    <span class="badge-pill-custom badge-yellow"><i class="fas fa-hourglass-half" style="font-size:10px"></i> Menunggu RT</span>
                                @else
                                    <span class="badge-pill-custom badge-red"><i class="fas fa-times-circle" style="font-size:10px"></i> Belum Bayar</span>
                                @endif
                            </div>
                        </div>

                        <div class="iuran-card-body">
                            <div class="iuran-card-field">
                                <label>Jumlah</label>
                                <span style="color:#064e3b; font-weight:700;">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</span>
                            </div>
                            <div class="iuran-card-field">
                                <label>Tanggal Bayar</label>
                                <span>{{ $i->tanggal_bayar ? \Carbon\Carbon::parse($i->tanggal_bayar)->translatedFormat('d M Y') : '-' }}</span>
                            </div>
                            <div class="iuran-card-field">
                                <label>Keterangan</label>
                                <span>{{ $i->keterangan ?? '-' }}</span>
                            </div>
                            @if($i->bukti_pembayaran)
                            <div class="iuran-card-field">
                                <label>Bukti</label>
                                <img src="{{ asset('bukti/' . $i->bukti_pembayaran) }}" class="bukti-img">
                            </div>
                            @endif
                        </div>

                        <div class="iuran-card-actions">
                            @if(auth()->user()->role == 'rt' && $i->status == 'belum' && $i->bukti_pembayaran)
                                <form action="{{ route('iuran.approve.rt', $i->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn-action warn"><i class="fas fa-check" style="font-size:10px"></i> Approve RT</button>
                                </form>
                            @endif

                            @if(auth()->user()->role == 'rt')
                                <a href="{{ route('iuran.edit', $i->id) }}" class="btn-action warn">
                                    <i class="fas fa-edit" style="font-size:10px"></i> Edit
                                </a>
                                <form action="{{ route('iuran.destroy', $i->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action danger" onclick="return confirm('Yakin hapus iuran ini?')">
                                        <i class="fas fa-trash" style="font-size:10px"></i> Hapus
                                    </button>
                                </form>
                            @endif

                            @if(!auth()->user() || (auth()->user()->role != 'rt' && auth()->user()->role != 'admin'))
                                <span style="font-size:12px; color:#ccc;">—</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding: 40px; color: #aaa;">
                        <i class="fas fa-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:0.4;"></i>
                        Belum ada data iuran
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

{{-- MODAL GENERATE MASSAL --}}
<div class="modal fade" id="modalGenerate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden;">
            <form action="{{ route('iuran.generate.massal') }}" method="POST">
                @csrf
                <div style="background:linear-gradient(135deg,#064e3b,#0d6e4f); padding:18px 24px; display:flex; align-items:center; gap:12px;">
                    <div style="width:34px;height:34px;background:rgba(255,255,255,.18);border-radius:9px;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h5 style="color:white;font-size:15px;font-weight:700;margin:0;">Generate Tagihan Massal</h5>
                </div>
                <div style="padding:22px 24px;">
                    <p style="font-size:13px;color:#5a6e5a;margin-bottom:16px;">
                        Otomatis buat tagihan untuk <strong>semua penghuni RT Anda</strong> sekaligus.
                    </p>
                    <div style="display:grid;gap:12px;">
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#8a9e8a;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Bulan</label>
                            <select name="bulan" class="form-control" required style="border-radius:9px;border:1.5px solid #e0ede0;font-size:13.5px;padding:9px 12px;">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                    <option value="{{ $bln }}">{{ $bln }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#8a9e8a;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Tahun</label>
                            <input type="number" name="tahun" value="{{ date('Y') }}" class="form-control" required style="border-radius:9px;border:1.5px solid #e0ede0;font-size:13.5px;padding:9px 12px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#8a9e8a;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Jenis Iuran</label>
                            <select name="jenis_iuran" class="form-control" required style="border-radius:9px;border:1.5px solid #e0ede0;font-size:13.5px;padding:9px 12px;">
                                <option value="Kebersihan">Kebersihan</option>
                                <option value="Keamanan">Keamanan</option>
                                <option value="Sosial">Sosial</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#8a9e8a;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" placeholder="Contoh: 50000" class="form-control" required style="border-radius:9px;border:1.5px solid #e0ede0;font-size:13.5px;padding:9px 12px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#8a9e8a;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Keterangan</label>
                            <input type="text" name="keterangan" placeholder="Keterangan tambahan" class="form-control" style="border-radius:9px;border:1.5px solid #e0ede0;font-size:13.5px;padding:9px 12px;">
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:18px;">
                        <button type="button" class="btn-action info" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-tambah" onclick="return confirm('Yakin generate tagihan untuk SEMUA penghuni RT?')">
                            <i class="fas fa-bolt" style="font-size:11px"></i> Generate Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    if ($.fn.DataTable) {
        $('#dataTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: '<"d-flex justify-content-between align-items-center px-3 pt-3 dt-top-bar"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3 dt-bottom-bar"ip>',
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
                emptyTable: "Belum ada data iuran"
            }
        });
    }
});

function filterMobileCards(query) {
    var cards = document.querySelectorAll('#mobileCardContainer .iuran-card');
    var q = query.toLowerCase();
    cards.forEach(function(card) {
        var nama = card.getAttribute('data-nama') || '';
        card.style.display = nama.includes(q) ? '' : 'none';
    });
}
</script>
@endpush

@extends('layouts.app')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* {
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

body {
    background: #e5e7eb !important;
    margin: 0;
    padding: 0 !important;
}

/* Override container Laravel agar tidak offset */
.container-fluid,
.container,
.content,
.main-content,
.page-content {
    padding: 0 !important;
    margin: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
}

/* ─── TOOLBAR (screen only) ─── */
.toolbar {
    background: #1f2937;
    padding: 0.85rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.toolbar-info {
    font-size: 0.82rem;
    color: #9ca3af;
    font-weight: 500;
}

.toolbar-info strong { color: #f9fafb; }

.btn-print {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 0.55rem 1.25rem;
    border-radius: 8px;
    border: 1px solid #4b5563;
    background: #374151;
    color: #f9fafb;
    font-size: 0.83rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-print:hover { background: #4b5563; }

/* ─── PAGE WRAPPER ─── */
.page-wrap {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2.5rem 1rem 3rem;
    width: 100%;
}

/* ─── A4 PAPER ─── */
.paper {
    background: #fff;
    width: 794px;
    max-width: 794px;
    min-height: 1123px;
    padding: 48px 56px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.15);
    margin: 0 auto;
    display: block;
}

/* ─── LETTERHEAD ─── */
.letterhead {
    text-align: center;
    border-bottom: 3px double #111;
    padding-bottom: 16px;
    margin-bottom: 20px;
}

.letterhead h1 {
    font-size: 1.15rem;
    font-weight: 800;
    color: #111;
    margin: 0 0 3px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.letterhead p {
    font-size: 0.8rem;
    color: #374151;
    margin: 0;
}

/* ─── META ─── */
.meta-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4px 2rem;
    margin-bottom: 20px;
    font-size: 0.82rem;
    color: #374151;
}

.meta-item { display: flex; gap: 6px; }
.meta-label { font-weight: 700; color: #111; min-width: 100px; }

/* ─── STATS ─── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    border: 1px solid #d1d5db;
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 24px;
}

.stat-cell {
    text-align: center;
    padding: 12px 8px;
    border-right: 1px solid #d1d5db;
}

.stat-cell:last-child { border-right: none; }

.stat-num {
    font-size: 1.3rem;
    font-weight: 800;
    color: #111;
    margin: 0 0 3px;
    line-height: 1;
}

.stat-lbl {
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin: 0;
}

/* ─── SECTION TITLE ─── */
.section-title {
    font-size: 0.78rem;
    font-weight: 800;
    color: #111;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.section-title::before {
    content: '';
    display: block;
    width: 3px;
    height: 14px;
    background: #111;
    border-radius: 2px;
    flex-shrink: 0;
}

/* ─── TABLE ─── */
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.83rem;
    margin-bottom: 32px;
}

.data-table thead tr { background: #111; }

.data-table thead th {
    padding: 9px 12px;
    color: #fff;
    font-weight: 700;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    text-align: left;
    border: none;
}

.data-table tbody tr { border-bottom: 1px solid #e5e7eb; }
.data-table tbody tr:last-child { border-bottom: 1px solid #d1d5db; }

.data-table tbody td {
    padding: 9px 12px;
    color: #1f2937;
    border: none;
    vertical-align: middle;
}

.data-table tbody tr:nth-child(even) td { background: #f9fafb; }

.col-no {
    width: 44px;
    text-align: center;
    color: #6b7280;
    font-weight: 600;
}

.status-pill {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    border: 1.5px solid #374151;
    color: #374151;
    background: transparent;
}

.empty-cell {
    text-align: center;
    padding: 2.5rem 1rem;
    color: #9ca3af;
    font-size: 0.85rem;
}

/* ─── SIGNATURE ─── */
.sign-area {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.sign-box { text-align: center; min-width: 210px; }
.sign-place { font-size: 0.82rem; color: #1f2937; margin: 0 0 2px; font-weight: 600; }
.sign-note  { font-size: 0.75rem; color: #6b7280; margin: 0 0 64px; }
.sign-line  {
    border-top: 1.5px solid #111;
    padding-top: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #111;
    margin: 0;
}

/* ─── FOOTER NOTE ─── */
.print-note {
    margin-top: 32px;
    border-top: 1px solid #e5e7eb;
    padding-top: 12px;
    font-size: 0.72rem;
    color: #9ca3af;
    text-align: center;
    line-height: 1.6;
}

/* ─── PRINT ─── */
@media print {
    body { background: #fff !important; margin: 0 !important; padding: 0 !important; }

    .toolbar { display: none !important; }

    nav, aside, header, .sidebar, .sidenav, .side-navbar,
    .navbar, .topbar, .top-bar, [class*="sidebar"],
    [class*="sidenav"], [class*="navbar"] {
        display: none !important;
    }

    body, main, .main, .main-content, .content,
    .content-wrapper, .page-wrapper, .wrapper,
    [class*="content"], [class*="wrapper"] {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        left: 0 !important;
        position: static !important;
    }

    .page-wrap {
        padding: 0 !important;
        background: #fff !important;
        display: block !important;
    }

    .paper {
        width: 100% !important;
        box-shadow: none !important;
        padding: 24px 40px !important;
        min-height: auto !important;
    }

    /* FORCE HITAM PUTIH */
    .data-table thead tr {
        background: #000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .data-table thead th {
        color: #fff !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .data-table tbody tr:nth-child(even) td {
        background: #f0f0f0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .status-pill {
        border-color: #000 !important;
        color: #000 !important;
    }

    .stat-num, .meta-label, .letterhead h1, .sign-line { color: #000 !important; }
    .stat-lbl, .letterhead p, .meta-item, .sign-note, .print-note { color: #555 !important; }
}
</style>

{{-- TOOLBAR --}}
<div class="toolbar">
    <span class="toolbar-info">
        <strong>Laporan Pengaduan</strong> &mdash; Perumahan Green View &mdash; Bulan {{ $bulan }}
    </span>
    <button onclick="window.print()" class="btn-print">
        <i class="fas fa-print"></i> Cetak
    </button>
</div>

<div class="page-wrap">
<div class="paper">

    {{-- LETTERHEAD --}}
    <div class="letterhead">
        <h1>Laporan Pengaduan</h1>
        <p>Perumahan Green View &bull; RT / Setempat</p>
    </div>

    {{-- META --}}
    <div class="meta-row">
        <div class="meta-item">
            <span class="meta-label">Periode</span>
            <span>: Bulan {{ $bulan }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Tanggal Cetak</span>
            <span>: {{ date('d F Y') }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Dicetak Oleh</span>
            <span>: Admin Perumahan</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Total Data</span>
            <span>: {{ $data->count() }} pengaduan</span>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-cell">
            <p class="stat-num">{{ $sukses }}</p>
            <p class="stat-lbl">Sukses</p>
        </div>
        <div class="stat-cell">
            <p class="stat-num">{{ $gagal }}</p>
            <p class="stat-lbl">Gagal</p>
        </div>
        <div class="stat-cell">
            <p class="stat-num">{{ $penghuni }}</p>
            <p class="stat-lbl">Penghuni</p>
        </div>
        <div class="stat-cell">
            <p class="stat-num">{{ $rumah }}</p>
            <p class="stat-lbl">Rumah</p>
        </div>
        <div class="stat-cell">
            <p class="stat-num" style="font-size:0.88rem;">Rp&nbsp;{{ number_format($iuran,0,',','.') }}</p>
            <p class="stat-lbl">Total Iuran</p>
        </div>
    </div>

    {{-- TABLE --}}
    <p class="section-title">Data Pengaduan</p>

    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Deskripsi Pengaduan</th>
                <th style="width:130px;">Status</th>
                <th style="width:110px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td class="col-no">{{ $loop->iteration }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>
                    @if($item->status == 'selesai')
                        <span class="status-pill">Selesai</span>
                    @elseif($item->status == 'diajukan')
                        <span class="status-pill">Diajukan</span>
                    @else
                        <span class="status-pill">Diproses</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="empty-cell">Tidak ada data pengaduan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- SIGNATURE --}}
    <div class="sign-area">
        <div class="sign-box">
            <p class="sign-place">Bondowoso, {{ date('d F Y') }}</p>
            <p class="sign-note">Admin Perumahan</p>
            <p class="sign-line">(_______________________)</p>
        </div>
    </div>

    {{-- PRINT NOTE --}}
    <div class="print-note">
        Dokumen ini digenerate secara otomatis oleh sistem Panel RT Perumahan Green View.<br>
        Sah tanpa tanda tangan basah apabila dicetak dari sistem resmi.
    </div>

</div>
</div>

<script>
window.addEventListener('beforeprint', function () {
    document.querySelectorAll('nav, aside, header, .sidebar, .sidenav, .side-navbar, .navbar, .topbar, .top-bar, .toolbar, [class*="sidebar"], [class*="sidenav"]').forEach(function(el) {
        el.dataset.ph = el.style.cssText || '';
        el.style.setProperty('display', 'none', 'important');
    });
    document.body.style.setProperty('padding', '0', 'important');
    document.body.style.setProperty('margin', '0', 'important');
});

window.addEventListener('afterprint', function () {
    document.querySelectorAll('[data-ph]').forEach(function(el) {
        el.style.cssText = el.dataset.ph;
        delete el.dataset.ph;
    });
    document.body.style.padding = '';
    document.body.style.margin = '';
});
</script>

@endsection

@extends('layouts.app')

@section('content')
<style>
    /* ── Palette ── */
    :root {
        --primary:      #16A34A;
        --primary-soft:#F0FDF4;
        --success:     #16A34A;
        --success-soft:#F0FDF4;
        --warning:     #D97706;
        --warning-soft:#FFFBEB;
        --danger:      #DC2626;
        --danger-soft: #FEF2F2;
        --muted:       #6B7280;
        --border:      #E5E7EB;
        --surface:     #F9FAFB;
        --card-bg:     #FFFFFF;
        --text-main:   #111827;
        --text-sub:    #6B7280;
    }

    /* ── Page wrapper ── */
    .rekap-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── Header ── */
    .rekap-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.5rem;
    }
    .rekap-header-left h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }
    .rekap-header-left .sub {
        font-size: .78rem;
        color: var(--text-sub);
        margin-top: .15rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem .9rem;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: var(--card-bg);
        color: var(--text-main);
        font-size: .82rem;
        font-weight: 500;
        text-decoration: none;
        transition: background .15s, border-color .15s;
        white-space: nowrap;
    }
    .btn-back:hover {
        background: var(--surface);
        border-color: #c0c0c0;
        color: var(--text-main);
    }

    /* ── Ditolak alert ── */
    .alert-ditolak {
        display: flex;
        gap: .75rem;
        align-items: flex-start;
        background: var(--danger-soft);
        border: 1px solid #FECACA;
        border-left: 4px solid var(--danger);
        border-radius: 10px;
        padding: .9rem 1rem;
        margin-bottom: 1.5rem;
        font-size: .875rem;
        color: #991B1B;
    }
    .alert-ditolak .icon { font-size: 1rem; margin-top: .05rem; flex-shrink: 0; }

    /* ── Summary card ── */
    .summary-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #fff;
    }
    .summary-card .label { font-size: .78rem; opacity: .85; margin-bottom: .2rem; }
    .summary-card .amount { font-size: 1.35rem; font-weight: 700; letter-spacing: -.3px; }
    .summary-card .count { font-size: .78rem; opacity: .8; }

    /* ── Desktop table ── */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .table-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: .875rem;
    }
    .table-card thead th {
        background: var(--surface);
        color: var(--text-sub);
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: .75rem 1rem;
        border-bottom: 1px solid var(--border);
    }
    .table-card tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .12s;
    }
    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: var(--surface); }
    .table-card tbody td {
        padding: .8rem 1rem;
        color: var(--text-main);
        vertical-align: middle;
    }
    .table-card tfoot td {
        padding: .8rem 1rem;
        background: var(--surface);
        font-weight: 700;
        color: var(--text-main);
        border-top: 2px solid var(--border);
        font-size: .9rem;
    }
    .nama-col { font-weight: 500; }
    .jumlah-col { font-variant-numeric: tabular-nums; font-weight: 600; color: var(--primary); }

    /* ── Mobile cards ── */
    .iuran-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: .85rem 1rem;
        margin-bottom: .75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .75rem;
        transition: box-shadow .15s;
    }
    .iuran-card:hover { box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    .iuran-card .left .nama { font-weight: 600; font-size: .9rem; color: var(--text-main); }
    .iuran-card .left .periode { font-size: .75rem; color: var(--text-sub); margin-top: .15rem; }
    .iuran-card .right { text-align: right; flex-shrink: 0; }
    .iuran-card .right .amount {
        font-weight: 700;
        font-size: .95rem;
        color: var(--primary);
        font-variant-numeric: tabular-nums;
    }
    .iuran-card .right .badge-wrap { margin-top: .3rem; }

    /* ── Badges ── */
    .badge-status {
        display: inline-block;
        padding: .2rem .55rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .badge-lunas    { background: var(--success-soft); color: var(--success); }
    .badge-belum    { background: var(--warning-soft); color: var(--warning); }
    .badge-default  { background: var(--surface);      color: var(--muted);   border: 1px solid var(--border); }

    /* ── Mobile total bar ── */
    .total-bar-mobile {
         background: var(--primary-soft);
    border: 1px solid #BBF7D0; 
        border-radius: 12px;
        padding: .85rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .total-bar-mobile .label { font-size: .8rem; font-weight: 600; color: var(--primary); }
    .total-bar-mobile .amount { font-size: 1rem; font-weight: 700; color: var(--primary); }

    /* ── Responsive breakpoint ── */
    .show-mobile  { display: none; }
    .show-desktop { display: block; }

    @media (max-width: 640px) {
        .show-mobile  { display: block; }
        .show-desktop { display: none; }
        .rekap-header h4 { font-size: 1rem; }
        .summary-card .amount { font-size: 1.15rem; }
    }
</style>

<div class="rekap-page">

    {{-- Header --}}
    <div class="rekap-header">
        <div class="rekap-header-left">
            <h4>Detail Rekap Iuran</h4>
            <div class="sub">Periode: {{ $rekap->periode }}</div>
        </div>
        <a href="{{ route('bendahara.rekap.index') }}" class="btn-back">
            ← Kembali
        </a>
    </div>

    {{-- Alert ditolak --}}
    @if($rekap->status === 'ditolak')
    <div class="alert-ditolak">
        <span class="icon">⚠️</span>
        <div>
            <strong>Rekap Ditolak RT</strong><br>
            {{ $rekap->catatan_rt }}
        </div>
    </div>
    @endif

    {{-- Summary card --}}
    <div class="summary-card">
        <div>
            <div class="label">Total Iuran Terkumpul</div>
            <div class="amount">Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</div>
        </div>
        <div style="text-align:right">
            <div class="count">{{ $rekap->iurans->count() }} penghuni</div>
            <div class="count">{{ $rekap->iurans->where('status','lunas')->count() }} lunas</div>
        </div>
    </div>

    {{-- ── DESKTOP TABLE ── --}}
    <div class="show-desktop">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Penghuni</th>
                        <th>Bulan / Tahun</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap->iurans as $i)
                    <tr>
                        <td class="nama-col">{{ $i->penghuni->nama ?? '-' }}</td>
                        <td style="color:var(--text-sub)">{{ $i->bulan }} {{ $i->tahun }}</td>
                        <td class="jumlah-col">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @php $s = strtolower($i->status); @endphp
                            <span class="badge-status {{ $s === 'lunas' ? 'badge-lunas' : ($s === 'belum' ? 'badge-belum' : 'badge-default') }}">
                                {{ ucfirst($i->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Total Keseluruhan</td>
                        <td class="jumlah-col">Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="show-mobile">
        @foreach($rekap->iurans as $i)
        @php $s = strtolower($i->status); @endphp
        <div class="iuran-card">
            <div class="left">
                <div class="nama">{{ $i->penghuni->nama ?? '-' }}</div>
                <div class="periode">{{ $i->bulan }} {{ $i->tahun }}</div>
            </div>
            <div class="right">
                <div class="amount">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</div>
                <div class="badge-wrap">
                    <span class="badge-status {{ $s === 'lunas' ? 'badge-lunas' : ($s === 'belum' ? 'badge-belum' : 'badge-default') }}">
                        {{ ucfirst($i->status) }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach

        <div class="total-bar-mobile">
            <span class="label">Total Keseluruhan</span>
            <span class="amount">Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</span>
        </div>
    </div>

</div>
@endsection

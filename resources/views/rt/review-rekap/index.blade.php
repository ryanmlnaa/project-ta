@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary:      #16A34A;
        --primary-dark: #15803D;
        --primary-soft: #F0FDF4;
        --border:       #E5E7EB;
        --surface:      #F9FAFB;
        --card-bg:      #FFFFFF;
        --text-main:    #111827;
        --text-sub:     #6B7280;
    }

    .review-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── Header ── */
    .review-header {
        margin-bottom: 1.5rem;
    }
    .review-header h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 .2rem;
    }
    .review-header .sub {
        font-size: .78rem;
        color: var(--text-sub);
    }

    /* ── Alert sukses ── */
    .alert-ok {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        background: var(--primary-soft);
        border: 1px solid #BBF7D0;
        border-left: 4px solid var(--primary);
        border-radius: 10px;
        padding: .8rem 1rem;
        margin-bottom: 1.25rem;
        font-size: .875rem;
        color: #166534;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-sub);
    }
    .empty-state .icon { font-size: 2.5rem; margin-bottom: .75rem; }
    .empty-state p { margin: 0; font-size: .9rem; }

    /* ── DESKTOP TABLE ── */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .table-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: .875rem;
    }
    .table-card thead th {
        background: var(--surface);
        color: var(--text-sub);
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: .75rem 1rem;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .table-card tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .12s;
    }
    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: var(--surface); }
    .table-card tbody td {
        padding: .85rem 1rem;
        color: var(--text-main);
        vertical-align: middle;
    }
    .periode-col { font-weight: 700; color: var(--text-main); }
    .jumlah-col {
        font-weight: 700;
        color: var(--primary);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .count-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .2rem .6rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 600;
        background: var(--primary-soft);
        color: var(--primary-dark);
        border: 1px solid #BBF7D0;
    }

    /* ── Tombol detail ── */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .4rem .85rem;
        border-radius: 8px;
        border: 1.5px solid #BBF7D0;
        background: var(--primary-soft);
        color: var(--primary-dark);
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .15s, border-color .15s;
    }
    .btn-detail:hover {
        background: #DCFCE7;
        border-color: var(--primary);
        color: var(--primary-dark);
    }

    /* ── MOBILE CARDS ── */
    .rekap-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: .75rem;
        transition: box-shadow .15s;
    }
    .rekap-card:hover { box-shadow: 0 2px 10px rgba(0,0,0,.06); }

    .rekap-card .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .5rem;
        margin-bottom: .6rem;
    }
    .rekap-card .card-periode {
        font-weight: 700;
        font-size: .95rem;
        color: var(--text-main);
    }
    .rekap-card .card-total {
        font-weight: 700;
        font-size: 1rem;
        color: var(--primary);
        white-space: nowrap;
    }
    .rekap-card .card-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
        font-size: .75rem;
        color: var(--text-sub);
        margin-bottom: .75rem;
    }
    .rekap-card .card-actions .btn-detail {
        width: 100%;
        justify-content: center;
    }

    /* ── Responsive ── */
    .show-mobile  { display: none; }
    .show-desktop { display: block; }

    @media (max-width: 640px) {
        .show-mobile  { display: block; }
        .show-desktop { display: none; }
        .review-header h4 { font-size: 1rem; }
    }
</style>

<div class="review-page">

    {{-- Header --}}
    <div class="review-header">
        <h4>Review Rekap dari Bendahara</h4>
        <div class="sub">Periksa rekap iuran sebelum disetujui</div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert-ok">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if($rekaps->isEmpty())
    <div class="table-card">
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>Tidak ada rekap yang menunggu review saat ini.</p>
        </div>
    </div>

    @else

    {{-- ── DESKTOP TABLE ── --}}
    <div class="show-desktop">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Bendahara</th>
                        <th>Jumlah Iuran</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekaps as $r)
                    <tr>
                        <td class="periode-col">{{ $r->periode }}</td>
                        <td style="color:var(--text-sub)">{{ $r->bendahara->name ?? '-' }}</td>
                        <td><span class="count-badge">{{ $r->iurans->count() }} iuran</span></td>
                        <td class="jumlah-col">Rp {{ number_format($r->iurans->sum('jumlah'), 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('rt.review-rekap.show', $r->id) }}" class="btn-detail">
                                → Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="show-mobile">
        @foreach($rekaps as $r)
        <div class="rekap-card">
            <div class="card-top">
                <div class="card-periode">{{ $r->periode }}</div>
                <div class="card-total">Rp {{ number_format($r->iurans->sum('jumlah'), 0, ',', '.') }}</div>
            </div>
            <div class="card-meta">
                <span class="count-badge">{{ $r->iurans->count() }} iuran</span>
                <span>· oleh {{ $r->bendahara->name ?? '-' }}</span>
            </div>
            <div class="card-actions">
                <a href="{{ route('rt.review-rekap.show', $r->id) }}" class="btn-detail">
                    → Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @endif

</div>
@endsection

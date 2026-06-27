@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary:      #16A34A;
        --primary-dark: #15803D;
        --primary-soft: #F0FDF4;
        --danger:       #DC2626;
        --danger-soft:  #FEF2F2;
        --border:       #E5E7EB;
        --surface:      #F9FAFB;
        --card-bg:      #FFFFFF;
        --text-main:    #111827;
        --text-sub:     #6B7280;
    }

    .detail-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── Header ── */
    .detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.5rem;
    }
    .detail-header h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 .2rem;
    }
    .detail-header .sub {
        font-size: .78rem;
        color: var(--text-sub);
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
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-back:hover { background: var(--surface); color: var(--text-main); }

    /* ── Summary card ── */
    .summary-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #fff;
    }
    .summary-card .label  { font-size: .78rem; opacity: .85; margin-bottom: .2rem; }
    .summary-card .amount { font-size: 1.35rem; font-weight: 700; letter-spacing: -.3px; }
    .summary-card .meta   { font-size: .78rem; opacity: .8; text-align: right; }

    /* ── DESKTOP TABLE ── */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
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
    .table-card tfoot td {
        padding: .8rem 1rem;
        background: var(--surface);
        font-weight: 700;
        color: var(--text-main);
        border-top: 2px solid var(--border);
    }
    .nama-col   { font-weight: 600; }
    .jumlah-col { font-weight: 700; color: var(--primary); font-variant-numeric: tabular-nums; white-space: nowrap; }
    .metode-badge {
        display: inline-block;
        padding: .2rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        background: var(--primary-soft);
        color: var(--primary-dark);
        border: 1px solid #BBF7D0;
    }

    /* ── MOBILE CARDS ── */
    .iuran-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: .9rem 1rem;
        margin-bottom: .75rem;
    }
    .iuran-card .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .5rem;
        margin-bottom: .45rem;
    }
    .iuran-card .card-nama    { font-weight: 700; font-size: .9rem; color: var(--text-main); }
    .iuran-card .card-periode { font-size: .75rem; color: var(--text-sub); margin-top: .1rem; }
    .iuran-card .card-amount  { font-weight: 700; font-size: .95rem; color: var(--primary); white-space: nowrap; }
    .iuran-card .card-meta    { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }

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
    .total-bar-mobile .label  { font-size: .8rem; font-weight: 600; color: var(--primary); }
    .total-bar-mobile .amount { font-size: 1rem; font-weight: 700; color: var(--primary); }

    /* ── Action buttons ── */
    .action-row {
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
    }
    .btn-setujui {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.25rem;
        border-radius: 9px;
        border: none;
        background: var(--primary);
        color: #fff;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-setujui:hover { background: var(--primary-dark); }
    .btn-tolak {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.25rem;
        border-radius: 9px;
        border: 1.5px solid #FECACA;
        background: var(--danger-soft);
        color: var(--danger);
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-tolak:hover { background: #FEE2E2; }

    @media (max-width: 640px) {
        .action-row { flex-direction: column; }
        .btn-setujui, .btn-tolak { justify-content: center; width: 100%; }
    }

    /* ── Modal ── */
    .modal-content {
        border-radius: 14px;
        border: none;
        overflow: hidden;
    }
    .modal-header {
        background: var(--danger-soft);
        border-bottom: 1px solid #FECACA;
        padding: 1rem 1.25rem;
    }
    .modal-header h5 {
        font-size: .95rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0;
    }
    .modal-body { padding: 1.25rem; }
    .modal-body .modal-info {
        font-size: .82rem;
        color: var(--text-sub);
        margin-bottom: .75rem;
    }
    .modal-body textarea {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: .65rem .85rem;
        font-size: .875rem;
        resize: vertical;
        min-height: 100px;
        outline: none;
        transition: border-color .15s;
        font-family: inherit;
        color: var(--text-main);
        box-sizing: border-box;
    }
    .modal-body textarea:focus { border-color: var(--danger); }
    .modal-footer {
        padding: .85rem 1.25rem;
        border-top: 1px solid var(--border);
        display: flex;
        gap: .5rem;
        justify-content: flex-end;
    }
    .btn-batal {
        padding: .45rem .9rem;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: var(--card-bg);
        color: var(--text-main);
        font-size: .82rem;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-batal:hover { background: var(--surface); }
    .btn-konfirm-tolak {
        padding: .45rem .9rem;
        border-radius: 8px;
        border: none;
        background: var(--danger);
        color: #fff;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-konfirm-tolak:hover { background: #B91C1C; }

    /* ── Responsive show/hide ── */
    .show-mobile  { display: none; }
    .show-desktop { display: block; }

    @media (max-width: 640px) {
        .show-mobile  { display: block; }
        .show-desktop { display: none; }
        .detail-header h4 { font-size: 1rem; }
        .summary-card .amount { font-size: 1.15rem; }
    }
</style>

<div class="detail-page">

    {{-- Header --}}
    <div class="detail-header">
        <div>
            <h4>Detail Rekap Iuran</h4>
            <div class="sub">Periode: {{ $rekap->periode }} · Diajukan oleh <strong>{{ $rekap->bendahara->name ?? '-' }}</strong></div>
        </div>
        <a href="{{ route('rt.review-rekap.index') }}" class="btn-back">← Kembali</a>
    </div>

    {{-- Summary card --}}
    <div class="summary-card">
        <div>
            <div class="label">Total Iuran</div>
            <div class="amount">Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</div>
        </div>
        <div class="meta">
            {{ $rekap->iurans->count() }} penghuni
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
                        <th>Metode Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap->iurans as $i)
                    <tr>
                        <td class="nama-col">{{ $i->penghuni->nama ?? '-' }}</td>
                        <td style="color:var(--text-sub)">{{ $i->bulan }} {{ $i->tahun }}</td>
                        <td class="jumlah-col">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if($i->metode)
                                <span class="metode-badge">{{ $i->metode }}</span>
                            @else
                                <span style="color:var(--text-sub)">—</span>
                            @endif
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
        <div class="iuran-card">
            <div class="card-top">
                <div>
                    <div class="card-nama">{{ $i->penghuni->nama ?? '-' }}</div>
                    <div class="card-periode">{{ $i->bulan }} {{ $i->tahun }}</div>
                </div>
                <div class="card-amount">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</div>
            </div>
            <div class="card-meta">
                @if($i->metode)
                    <span class="metode-badge">{{ $i->metode }}</span>
                @else
                    <span style="color:var(--text-sub);font-size:.75rem">Metode: —</span>
                @endif
            </div>
        </div>
        @endforeach

        <div class="total-bar-mobile">
            <span class="label">Total Keseluruhan</span>
            <span class="amount">Rp {{ number_format($rekap->iurans->sum('jumlah'), 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- ── Action buttons ── --}}
    <div class="action-row">
        <form action="{{ route('rt.review-rekap.setujui', $rekap->id) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="btn-setujui"
                onclick="return confirm('Setujui rekap ini?')">
                ✓ Setujui Rekap
            </button>
        </form>

        <button class="btn-tolak" data-bs-toggle="modal" data-bs-target="#tolakRekapModal">
            ✕ Tolak Rekap
        </button>
    </div>

</div>

{{-- ── Modal Tolak ── --}}
<div class="modal fade" id="tolakRekapModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('rt.review-rekap.tolak', $rekap->id) }}" method="POST">
                @csrf @method('PATCH')
                <div class="modal-header">
                    <h5>⚠️ Alasan Penolakan Rekap</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-info">
                        Rekap periode <strong style="color:var(--text-main)">{{ $rekap->periode }}</strong>
                        dari <strong style="color:var(--text-main)">{{ $rekap->bendahara->name ?? '-' }}</strong>
                    </p>
                    <textarea name="catatan_rt" required
                        placeholder="Tulis alasan penolakan..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-konfirm-tolak">Tolak Rekap</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary:      #16A34A;
        --primary-dark: #15803D;
        --primary-soft: #F0FDF4;
        --danger:       #DC2626;
        --danger-soft:  #FEF2F2;
        --success:      #16A34A;
        --success-soft: #F0FDF4;
        --warning:      #D97706;
        --warning-soft: #FFFBEB;
        --border:       #E5E7EB;
        --surface:      #F9FAFB;
        --card-bg:      #FFFFFF;
        --text-main:    #111827;
        --text-sub:     #6B7280;
    }

    .kas-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── Header ── */
    .kas-header {
        margin-bottom: 1.5rem;
    }
    .kas-header h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 .2rem;
    }
    .kas-header .sub {
        font-size: .78rem;
        color: var(--text-sub);
    }

    /* ── Summary cards ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
        margin-bottom: 1.75rem;
    }
    .summary-item {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }
    .summary-item .s-label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--text-sub);
    }
    .summary-item .s-amount {
        font-size: 1.2rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        letter-spacing: -.3px;
    }
    .summary-item .s-icon {
        font-size: 1.3rem;
        margin-bottom: .1rem;
    }
    .summary-item.masuk  { border-top: 3px solid var(--success); }
    .summary-item.keluar { border-top: 3px solid var(--danger);  }
    .summary-item.saldo  {
        border-top: 3px solid var(--primary);
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        color: #fff;
    }
    .summary-item.masuk  .s-amount { color: var(--success); }
    .summary-item.keluar .s-amount { color: var(--danger);  }
    .summary-item.saldo  .s-label,
    .summary-item.saldo  .s-amount { color: #fff; }

    @media (max-width: 640px) {
        .summary-grid { grid-template-columns: 1fr; }
        .summary-item { flex-direction: row; align-items: center; justify-content: space-between; }
        .summary-item .s-icon { display: none; }
    }

    /* ── Section title ── */
    .section-title {
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--text-sub);
        margin-bottom: .75rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

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
    .tanggal-col { font-size: .8rem; color: var(--text-sub); white-space: nowrap; }
    .jumlah-masuk  { font-weight: 700; color: var(--success); font-variant-numeric: tabular-nums; white-space: nowrap; }
    .jumlah-keluar { font-weight: 700; color: var(--danger);  font-variant-numeric: tabular-nums; white-space: nowrap; }
    .keterangan-col { color: var(--text-sub); font-size: .82rem; }

    /* ── Badges ── */
    .badge-masuk {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        padding: .22rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        background: var(--success-soft);
        color: var(--success);
        border: 1px solid #BBF7D0;
    }
    .badge-keluar {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        padding: .22rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        background: var(--danger-soft);
        color: var(--danger);
        border: 1px solid #FECACA;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-sub);
    }
    .empty-state .icon { font-size: 2.5rem; margin-bottom: .75rem; }
    .empty-state p { margin: 0; font-size: .9rem; }

    /* ── MOBILE CARDS ── */
    .kas-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: .9rem 1rem;
        margin-bottom: .75rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .75rem;
    }
    .kas-card .left .ket  { font-weight: 600; font-size: .88rem; color: var(--text-main); margin-bottom: .25rem; }
    .kas-card .left .tgl  { font-size: .72rem; color: var(--text-sub); }
    .kas-card .right      { text-align: right; flex-shrink: 0; }
    .kas-card .right .amt { font-weight: 700; font-size: .95rem; font-variant-numeric: tabular-nums; }
    .kas-card .right .amt.masuk  { color: var(--success); }
    .kas-card .right .amt.keluar { color: var(--danger);  }
    .kas-card .right .bdg { margin-top: .3rem; }

    /* ── Responsive show/hide ── */
    .show-mobile  { display: none; }
    .show-desktop { display: block; }

    @media (max-width: 640px) {
        .show-mobile  { display: block; }
        .show-desktop { display: none; }
        .kas-header h4 { font-size: 1rem; }
    }
</style>

<div class="kas-page">

    {{-- Header --}}
    <div class="kas-header">
        <h4>Kas Bendahara</h4>
        <div class="sub">Riwayat arus kas — hanya dapat dilihat</div>
    </div>

    {{-- Summary cards --}}
    <div class="summary-grid">
        <div class="summary-item masuk">
            <div class="s-icon">↑</div>
            <div>
                <div class="s-label">Total Masuk</div>
                <div class="s-amount">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="summary-item keluar">
            <div class="s-icon">↓</div>
            <div>
                <div class="s-label">Total Keluar</div>
                <div class="s-amount">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="summary-item saldo">
            <div class="s-icon">◈</div>
            <div>
                <div class="s-label">Saldo Saat Ini</div>
                <div class="s-amount">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="section-title">Riwayat Kas</div>

    @if($kas->isEmpty())
    <div class="table-card">
        <div class="empty-state">
            <div class="icon">📒</div>
            <p>Belum ada catatan kas.</p>
        </div>
    </div>

    @else

    {{-- ── DESKTOP TABLE ── --}}
    <div class="show-desktop">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kas as $k)
                    <tr>
                        <td class="tanggal-col">{{ $k->created_at->format('d M Y') }}<br><span style="font-size:.72rem">{{ $k->created_at->format('H:i') }}</span></td>
                        <td>
                            @if($k->jenis === 'masuk')
                                <span class="badge-masuk">↑ Masuk</span>
                            @else
                                <span class="badge-keluar">↓ Keluar</span>
                            @endif
                        </td>
                        <td class="{{ $k->jenis === 'masuk' ? 'jumlah-masuk' : 'jumlah-keluar' }}">
                            {{ $k->jenis === 'masuk' ? '+' : '-' }} Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="keterangan-col">{{ $k->keterangan ?: '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="show-mobile">
        @foreach($kas as $k)
        <div class="kas-card">
            <div class="left">
                <div class="ket">{{ $k->keterangan ?: '(Tidak ada keterangan)' }}</div>
                <div class="tgl">{{ $k->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div class="right">
                <div class="amt {{ $k->jenis === 'masuk' ? 'masuk' : 'keluar' }}">
                    {{ $k->jenis === 'masuk' ? '+' : '-' }} Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                </div>
                <div class="bdg">
                    @if($k->jenis === 'masuk')
                        <span class="badge-masuk">↑ Masuk</span>
                    @else
                        <span class="badge-keluar">↓ Keluar</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif

</div>
@endsection

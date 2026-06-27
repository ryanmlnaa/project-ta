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
        --border:       #E5E7EB;
        --surface:      #F9FAFB;
        --card-bg:      #FFFFFF;
        --text-main:    #111827;
        --text-sub:     #6B7280;
        --muted:        #9CA3AF;
    }

    .review-page {
        max-width: 960px;
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

    /* ── Alert success ── */
    .alert-ok {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        background: var(--success-soft);
        border: 1px solid #BBF7D0;
        border-left: 4px solid var(--success);
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
    .nama-col { font-weight: 600; }
    .jumlah-col {
        font-weight: 700;
        color: var(--primary);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .jenis-badge {
        display: inline-block;
        padding: .2rem .6rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        background: var(--primary-soft);
        color: var(--primary-dark);
        border: 1px solid #BBF7D0;
    }

    /* ── Action buttons ── */
    .btn-setujui {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .38rem .75rem;
        border-radius: 8px;
        border: none;
        background: var(--primary);
        color: #fff;
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
        white-space: nowrap;
    }
    .btn-setujui:hover { background: var(--primary-dark); }

    .btn-tolak {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .38rem .75rem;
        border-radius: 8px;
        border: 1.5px solid #FECACA;
        background: var(--danger-soft);
        color: var(--danger);
        font-size: .78rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        white-space: nowrap;
    }
    .btn-tolak:hover { background: #FEE2E2; border-color: #FCA5A5; }

    .action-group { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }

    /* ── MOBILE CARDS ── */
    .iuran-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: .75rem;
    }
    .iuran-card .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .5rem;
        margin-bottom: .65rem;
    }
    .iuran-card .card-nama { font-weight: 700; font-size: .95rem; color: var(--text-main); }
    .iuran-card .card-periode { font-size: .75rem; color: var(--text-sub); margin-top: .1rem; }
    .iuran-card .card-amount {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
    }
    .iuran-card .card-meta {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: .75rem;
        font-size: .75rem;
        color: var(--text-sub);
    }
    .iuran-card .card-actions {
        display: flex;
        gap: .5rem;
    }
    .iuran-card .card-actions .btn-setujui,
    .iuran-card .card-actions .btn-tolak {
        flex: 1;
        justify-content: center;
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
        <h4>Review Iuran dari Bendahara</h4>
        <div class="sub">Periksa dan setujui atau tolak iuran yang diajukan</div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert-ok">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if($iurans->isEmpty())
    {{-- Empty state --}}
    <div class="table-card">
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>Tidak ada iuran yang menunggu review saat ini.</p>
        </div>
    </div>

    @else

    {{-- ── DESKTOP TABLE ── --}}
    <div class="show-desktop">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Penghuni</th>
                        <th>Bulan / Tahun</th>
                        <th>Jumlah</th>
                        <th>Jenis</th>
                        <th>Diajukan oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($iurans as $i)
                    <tr>
                        <td class="nama-col">{{ $i->penghuni->nama ?? '-' }}</td>
                        <td style="color:var(--text-sub)">{{ $i->bulan }} {{ $i->tahun }}</td>
                        <td class="jumlah-col">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</td>
                        <td><span class="jenis-badge">{{ $i->jenis_iuran }}</span></td>
                        <td style="color:var(--text-sub)">{{ $i->bendahara->name ?? '-' }}</td>
                        <td>
                            <div class="action-group">
                                {{-- Setujui --}}
                                <form action="{{ route('rt.review-iuran.setujui', $i->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-setujui"
                                        onclick="return confirm('Setujui iuran ini?')">
                                        ✓ Setujui
                                    </button>
                                </form>
                                {{-- Tolak --}}
                                <button class="btn-tolak" data-bs-toggle="modal"
                                    data-bs-target="#tolakModal{{ $i->id }}">
                                    ✕ Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="show-mobile">
        @foreach($iurans as $i)
        <div class="iuran-card">
            <div class="card-top">
                <div>
                    <div class="card-nama">{{ $i->penghuni->nama ?? '-' }}</div>
                    <div class="card-periode">{{ $i->bulan }} {{ $i->tahun }}</div>
                </div>
                <div class="card-amount">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</div>
            </div>
            <div class="card-meta">
                <span class="jenis-badge">{{ $i->jenis_iuran }}</span>
                <span>· oleh {{ $i->bendahara->name ?? '-' }}</span>
            </div>
            <div class="card-actions">
                <form action="{{ route('rt.review-iuran.setujui', $i->id) }}" method="POST" style="flex:1;display:flex">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-setujui" style="flex:1"
                        onclick="return confirm('Setujui iuran ini?')">
                        ✓ Setujui
                    </button>
                </form>
                <button class="btn-tolak" style="flex:1" data-bs-toggle="modal"
                    data-bs-target="#tolakModal{{ $i->id }}">
                    ✕ Tolak
                </button>
            </div>
        </div>
        @endforeach
    </div>

    @endif

    {{-- ── MODALS (di luar loop display, tetap dirender) ── --}}
    @foreach($iurans as $i)
    <div class="modal fade" id="tolakModal{{ $i->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('rt.review-iuran.tolak', $i->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="modal-header">
                        <h5>⚠️ Alasan Penolakan</h5>
                    </div>
                    <div class="modal-body">
                        <p style="font-size:.82rem;color:var(--text-sub);margin:0 0 .75rem">
                            Iuran <strong style="color:var(--text-main)">{{ $i->penghuni->nama ?? '-' }}</strong>
                            — {{ $i->bulan }} {{ $i->tahun }}
                        </p>
                        <textarea name="catatan_rt" required
                            placeholder="Tulis alasan penolakan..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-konfirm-tolak">Tolak Iuran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection

@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary:      #16A34A;
        --primary-dark: #15803D;
        --primary-soft: #F0FDF4;
        --danger:       #DC2626;
        --danger-soft:  #FEF2F2;
        --warning:      #D97706;
        --warning-soft: #FFFBEB;
        --border:       #E5E7EB;
        --surface:      #F9FAFB;
        --card-bg:      #FFFFFF;
        --text-main:    #111827;
        --text-sub:     #6B7280;
        --muted:        #9CA3AF;
    }

    .kelola-page {
        max-width: 860px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── Header ── */
    .kelola-header {
        margin-bottom: 1.5rem;
    }
    .kelola-header h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 .2rem;
    }
    .kelola-header .sub {
        font-size: .78rem;
        color: var(--text-sub);
    }

    /* ── Alerts ── */
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
    .alert-err {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        background: var(--danger-soft);
        border: 1px solid #FECACA;
        border-left: 4px solid var(--danger);
        border-radius: 10px;
        padding: .8rem 1rem;
        margin-bottom: 1.25rem;
        font-size: .875rem;
        color: #991B1B;
    }

    /* ── Form card ── */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .form-card-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: .85rem 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .form-card-header .title {
        font-size: .875rem;
        font-weight: 700;
        color: var(--text-main);
    }
    .form-card-body { padding: 1.25rem; }

    .field-group { margin-bottom: 1rem; }
    .field-group label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: var(--text-sub);
        margin-bottom: .35rem;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .field-group input {
        width: 100%;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: .6rem .85rem;
        font-size: .875rem;
        color: var(--text-main);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        background: var(--card-bg);
        box-sizing: border-box;
        font-family: inherit;
    }
    .field-group input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(22,163,74,.1);
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 8px;
        padding: .75rem .9rem;
        font-size: .8rem;
        color: #1E40AF;
        margin-bottom: 1.1rem;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.2rem;
        border-radius: 9px;
        border: none;
        background: var(--primary);
        color: #fff;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-submit:hover { background: var(--primary-dark); }

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
    .nama-col     { font-weight: 600; }
    .username-col { font-family: monospace; font-size: .82rem; color: var(--text-sub); }
    .email-col    { font-size: .82rem; color: var(--text-sub); }

    /* ── Badges ── */
    .badge-aktif {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600;
        background: var(--primary-soft); color: var(--primary);
        border: 1px solid #BBF7D0;
    }
    .badge-nonaktif {
        display: inline-flex; align-items: center; gap: .25rem;
        padding: .22rem .65rem; border-radius: 999px;
        font-size: .7rem; font-weight: 600;
        background: var(--surface); color: var(--muted);
        border: 1px solid var(--border);
    }

    /* ── Nonaktifkan button ── */
    .btn-nonaktif {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .35rem .75rem;
        border-radius: 8px;
        border: 1.5px solid #FDE68A;
        background: var(--warning-soft);
        color: var(--warning);
        font-size: .76rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
        white-space: nowrap;
    }
    .btn-nonaktif:hover { background: #FEF3C7; }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: var(--text-sub);
    }
    .empty-state .icon { font-size: 2.2rem; margin-bottom: .6rem; }
    .empty-state p { margin: 0; font-size: .88rem; }

    /* ── MOBILE CARDS ── */
    .bendahara-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: .75rem;
    }
    .bendahara-card .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: .5rem;
        margin-bottom: .5rem;
    }
    .bendahara-card .card-nama  { font-weight: 700; font-size: .95rem; color: var(--text-main); }
    .bendahara-card .card-user  { font-size: .75rem; color: var(--text-sub); font-family: monospace; margin-top: .1rem; }
    .bendahara-card .card-email { font-size: .75rem; color: var(--text-sub); margin-bottom: .75rem; }
    .bendahara-card .card-foot  { display: flex; justify-content: space-between; align-items: center; gap: .5rem; flex-wrap: wrap; }

    /* ── Responsive ── */
    .show-mobile  { display: none; }
    .show-desktop { display: block; }

    @media (max-width: 640px) {
        .show-mobile  { display: block; }
        .show-desktop { display: none; }
        .kelola-header h4 { font-size: 1rem; }
        .form-card-body { padding: 1rem; }
    }
</style>

<div class="kelola-page">

    {{-- Header --}}
    <div class="kelola-header">
        <h4>Kelola Bendahara</h4>
        <div class="sub">Buat dan kelola akun bendahara RT</div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert-ok">✅ {{ session('success') }}</div>
    @endif

    @if($errors->has('bendahara'))
    <div class="alert-err">⚠️ {{ $errors->first('bendahara') }}</div>
    @endif

    {{-- ── Form tambah bendahara ── --}}
    @if(!$bendaharaAktif)
    <div class="form-card">
        <div class="form-card-header">
            <span>➕</span>
            <span class="title">Buat Akun Bendahara Baru</span>
        </div>
        <div class="form-card-body">
            <form action="{{ route('rt.bendahara.store') }}" method="POST">
                @csrf
                <div class="field-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso" value="{{ old('name') }}">
                </div>
                <div class="field-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="Contoh: bendahara_rt01" value="{{ old('username') }}">
                </div>
                <div class="field-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Contoh: bendahara@email.com" value="{{ old('email') }}">
                </div>
                <div class="info-box">
                    ℹ️ Password default: <strong style="margin-left:.3rem">12345678</strong>. Bendahara wajib menggantinya saat login pertama kali.
                </div>
                <button type="submit" class="btn-submit">✓ Buat Akun Bendahara</button>
            </form>
        </div>
    </div>
    @endif

    <div class="section-title">Riwayat Akun Bendahara</div>

    @php $empty = $bendaharas->isEmpty(); @endphp

    {{-- ── DESKTOP TABLE ── --}}
    <div class="show-desktop">
        <div class="table-card">
            @if($empty)
            <div class="empty-state">
                <div class="icon">👤</div>
                <p>Belum ada akun bendahara.</p>
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bendaharas as $b)
                    <tr>
                        <td class="nama-col">{{ $b->name }}</td>
                        <td class="username-col">{{ $b->username }}</td>
                        <td class="email-col">{{ $b->email }}</td>
                        <td>
                            @if($b->status_akun === 'aktif')
                                <span class="badge-aktif">● Aktif</span>
                            @else
                                <span class="badge-nonaktif">○ Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status_akun === 'aktif')
                            <form action="{{ route('rt.bendahara.nonaktifkan', $b->id) }}" method="POST"
                                  onsubmit="return confirm('Nonaktifkan bendahara ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-nonaktif">⊘ Nonaktifkan</button>
                            </form>
                            @else
                                <span style="color:var(--muted);font-size:.8rem">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    {{-- ── MOBILE CARDS ── --}}
    <div class="show-mobile">
        @if($empty)
        <div class="table-card">
            <div class="empty-state">
                <div class="icon">👤</div>
                <p>Belum ada akun bendahara.</p>
            </div>
        </div>
        @else
        @foreach($bendaharas as $b)
        <div class="bendahara-card">
            <div class="card-top">
                <div>
                    <div class="card-nama">{{ $b->name }}</div>
                    <div class="card-user">{{ $b->username }}</div>
                </div>
                @if($b->status_akun === 'aktif')
                    <span class="badge-aktif">● Aktif</span>
                @else
                    <span class="badge-nonaktif">○ Nonaktif</span>
                @endif
            </div>
            <div class="card-email">✉ {{ $b->email }}</div>
            <div class="card-foot">
                @if($b->status_akun === 'aktif')
                <form action="{{ route('rt.bendahara.nonaktifkan', $b->id) }}" method="POST"
                      onsubmit="return confirm('Nonaktifkan bendahara ini?')" style="flex:1">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-nonaktif" style="width:100%;justify-content:center">
                        ⊘ Nonaktifkan
                    </button>
                </form>
                @else
                    <span style="color:var(--muted);font-size:.8rem">Tidak ada aksi</span>
                @endif
            </div>
        </div>
        @endforeach
        @endif
    </div>

</div>
@endsection

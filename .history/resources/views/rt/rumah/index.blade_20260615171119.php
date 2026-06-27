@extends('layouts.app')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="dr-header">
    <div class="dr-header-left">
        <div class="dr-icon">
            <i class="fas fa-home"></i>
        </div>
        <div>
            <h2 class="dr-title">Data Rumah (RT)</h2>
            <p class="dr-sub">Kelola data rumah & status hunian</p>
        </div>
    </div>
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="dr-card">

    <div class="dr-card-header">
        <div class="dr-card-icon">
            <i class="fas fa-list"></i>
        </div>
        <span class="dr-card-title">Daftar Rumah</span>
    </div>

    <div class="dr-table-wrap">
        <table class="dr-table">
           <thead>
    <tr>
        <th>ID</th>
        <th>Cluster</th>
        <th>Blok</th>
        <th>No Rumah</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
    @forelse($rumah as $r)
        @php
            $clusterMap = [
                'A'=>'Cluster Gardenia','B'=>'Cluster Gardenia','C'=>'Cluster Gardenia',
                'D'=>'Cluster Gardenia','E'=>'Cluster Gardenia','F'=>'Cluster Gardenia','G'=>'Cluster Gardenia',
                'H'=>'Cluster Edelweis','I'=>'Cluster Edelweis',
                'J'=>'Blok J','K'=>'Blok K','L'=>'Blok L',
            ];
            $clusterR = $clusterMap[$r->blok] ?? '-';
        @endphp
        <tr>
            <td class="td-id">{{ $loop->iteration }}</td>
            <td><span class="badge-cluster">{{ $clusterR }}</span></td>
            <td><span class="badge-blok">{{ $r->blok }}</span></td>
            <td class="td-norumah">{{ $r->no_rumah }}</td>
            <td>
                @if($r->status == 'aktif' || $r->status == 'Terisi')
                    <span class="badge-terisi">
                        <i class="fas fa-check-circle"></i> {{ ucfirst($r->status) }}
                    </span>
                @else
                    <span class="badge-kosong">
                        <i class="fas fa-circle"></i> {{ ucfirst($r->status) }}
                    </span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="td-empty">
                <i class="fas fa-home"></i>
                <p>Tidak ada data rumah</p>
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>

<style>
/* ===== HEADER ===== */
.dr-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
}

.dr-header-left {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}

.dr-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    background: #064e3b;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.dr-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a2e22;
    margin: 0;
    line-height: 1.2;
}

.dr-sub {
    margin: 0.15rem 0 0;
    color: #888;
    font-size: 0.87rem;
}

/* ===== CARD ===== */
.dr-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8ede9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
}

.dr-card-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f0f4f1;
}

.dr-card-icon {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    background: #d1fae5;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #064e3b;
    font-size: 0.85rem;
}

.dr-card-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2c3e50;
}

/* ===== TABLE ===== */
.dr-table-wrap {
    overflow-x: auto;
}

.dr-table {
    width: 100%;
    border-collapse: collapse;
}

.dr-table thead tr {
    background: #f9fafb;
}

.dr-table thead th {
    padding: 0.75rem 1.5rem;
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #888;
    border-bottom: 1px solid #eff2f0;
    white-space: nowrap;
}

.dr-table tbody tr {
    border-bottom: 1px solid #f4f6f4;
    transition: background 0.15s ease;
}

.dr-table tbody tr:last-child { border-bottom: none; }
.dr-table tbody tr:hover { background: #f8fdf9; }

.dr-table tbody td {
    padding: 0.9rem 1.5rem;
    font-size: 0.9rem;
    color: #2c3e50;
    vertical-align: middle;
}

/* ===== CELL TYPES ===== */
.td-id {
    font-weight: 600;
    color: #aaa;
    font-size: 0.88rem;
}

.td-norumah {
    color: #444;
}

/* ===== BADGES ===== */
.badge-blok {
    display: inline-block;
    padding: 0.25rem 0.65rem;
    border-radius: 6px;
    background: #d1fae5;
    color: #064e3b;
    font-size: 0.82rem;
    font-weight: 700;
    border: 1px solid #d0e8d5;
}

.badge-terisi {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    background: #fff0f0;
    color: #c0392b;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid #f5c6c6;
}

.badge-terisi i { font-size: 0.7rem; }

.badge-kosong {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    background: #d1fae5;
    color: #064e3b;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid #c3e6cb;
}

.badge-kosong i { font-size: 0.7rem; }

/* ===== EMPTY ===== */
.td-empty {
    text-align: center;
    padding: 3.5rem 1rem !important;
    color: #aaa;
}

.td-empty i {
    font-size: 2rem;
    display: block;
    margin-bottom: 0.6rem;
}

.td-empty p {
    margin: 0;
    font-size: 0.9rem;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .dr-title { font-size: 1.25rem; }
    .dr-table tbody td,
    .dr-table thead th { padding: 0.75rem 1rem; }
}

.badge-cluster {
    display: inline-block;
    padding: 0.25rem 0.65rem;
    border-radius: 6px;
    background: #eaf0fb;
    color: #1a4e8e;
    font-size: 0.82rem;
    font-weight: 600;
    border: 1px solid #c5d5f0;
}
</style>

@endsection

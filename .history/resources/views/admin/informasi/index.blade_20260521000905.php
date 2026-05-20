@extends('layouts.app')

@section('content')

{{-- ============================================================
     FILE: resources/views/informasi/index.blade.php
============================================================ --}}

<style>
body { background: #f0f4f8 !important; }

.page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.page-icon {
    width: 46px;
    height: 46px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #ffffff;
    font-size: 18px;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}

.page-title {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 12.5px;
    color: #6b7280;
    margin: 2px 0 0;
}

.card {
    border: 1px solid #e5e7eb !important;
    border-radius: 14px !important;
    background: #ffffff;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04) !important;
    overflow: hidden;
    animation: fadeUp 0.35s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

.card-header {
    background: #ffffff !important;
    border-bottom: 1px solid #f3f4f6 !important;
    border-radius: 0 !important;
    padding: 13px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.card-header-left {
    display: flex;
    align-items: center;
    gap: 9px;
}

.card-header-icon {
    width: 28px;
    height: 28px;
    background: #d1fae5;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: #064e3b;
}

.card-header-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    margin: 0;
}

.table { margin-bottom: 0; }

.table thead th {
    background: #f9fafb !important;
    color: #6b7280 !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 1px solid #e5e7eb !important;
    border-top: none !important;
    padding: 10px 16px;
    white-space: nowrap;
}

.table tbody td {
    color: #111827;
    font-size: 13px;
    padding: 13px 16px;
    border-bottom: 1px solid #f3f4f6 !important;
    vertical-align: middle;
}

.table tbody tr:last-child td { border-bottom: none !important; }
.table tbody tr:hover td { background: #fafafa; }

.badge-kategori {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    white-space: nowrap;
}

.badge-kategori::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #2563eb;
    flex-shrink: 0;
}

.badge-penting {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    white-space: nowrap;
}

.badge-penting::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #dc2626;
    flex-shrink: 0;
}

.views-text {
    font-weight: 700;
    color: #064e3b;
}

.btn {
    border-radius: 8px !important;
    font-size: 12px;
    padding: 5px 12px;
    font-weight: 600;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    line-height: 1.4;
}

.btn-tambah {
    background: linear-gradient(135deg, #064e3b, #0d6e4f) !important;
    border: none !important;
    color: #ffffff !important;
    border-radius: 9px !important;
    padding: 7px 15px;
    font-size: 12.5px;
    font-weight: 700;
    box-shadow: 0 3px 10px rgba(6,78,59,0.3);
    white-space: nowrap;
}

.btn-tambah:hover {
    opacity: 0.9;
    color: #fff !important;
    transform: translateY(-1px);
}

.btn-edit {
    background: #fff7ed !important;
    border: 1px solid #fed7aa !important;
    color: #ea580c !important;
}

.btn-edit:hover { background: #ffedd5 !important; }

.btn-hapus {
    background: #fef2f2 !important;
    border: 1px solid #fecaca !important;
    color: #dc2626 !important;
}

.btn-hapus:hover { background: #fee2e2 !important; }

.empty-text {
    color: #9ca3af;
    font-style: italic;
    font-size: 13px;
    padding: 36px 0 !important;
}

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    /* Hide less critical columns on mobile */
    .col-hide-sm {
        display: none;
    }

    .table thead th,
    .table tbody td {
        padding: 10px 10px;
        font-size: 12px;
    }

    .btn {
        padding: 4px 8px;
        font-size: 11px;
    }

    .btn-tambah {
        padding: 6px 11px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .page-title { font-size: 17px; }

    /* On very small screens, stack action buttons vertically */
    .action-wrap {
        flex-direction: column;
        gap: 4px !important;
    }
}
</style>

<div class="container-fluid" style="padding: 20px 16px;">

    <div class="page-header">
        <div class="page-icon">
            <i class="fas fa-bullhorn"></i>
        </div>
        <div>
            <h1 class="page-title">Kelola Informasi</h1>
            <p class="page-subtitle">Manajemen informasi dan pengumuman warga</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; border-radius:10px; font-size:13px; padding:10px 16px; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="card-header-left">
                <div class="card-header-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <p class="card-header-title">Daftar Informasi</p>
            </div>
           z
                <i class="fas fa-plus" style="font-size:11px;"></i> Tambah Informasi
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Judul</th>
                        <th class="col-hide-sm">Kategori</th>
                        <th class="col-hide-sm">Penting</th>
                        <th class="col-hide-sm">Views</th>
                        <th class="col-hide-sm">Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informasi as $index => $i)
                    <tr>
                        <td style="color:#9ca3af; font-weight:600;">{{ $index + 1 }}</td>
                        <td style="font-weight:700;">{{ $i->judul }}</td>
                        <td class="col-hide-sm"><span class="badge-kategori">{{ $i->kategori }}</span></td>
                        <td class="col-hide-sm">
                            @if($i->is_penting)
                                <span class="badge-penting">Penting</span>
                            @else
                              y  <span style="color:#9ca3af;">—</span>
                            @endif
                        </td>
                        <td class="col-hide-sm"><span class="views-text">{{ $i->views }}</span></td>
                        <td class="col-hide-sm" style="color:#6b7280; white-space:nowrap; font-size:13px;">
                            {{ \Carbon\Carbon::parse($i->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td>
                            <div class="action-wrap" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                                <a href="{{ route('informasi.edit', $i->id) }}" class="btn btn-edit">
                                    <i class="fas fa-edit" style="font-size:11px;"></i> Edit
                                </a>
                                <form action="{{ route('informasi.destroy', $i->id) }}" method="POST" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-hapus" onclick="return confirm('Yakin hapus informasi ini?')">
                                        <i class="fas fa-trash" style="font-size:11px;"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center empty-text">
                            <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:6px; opacity:0.3;"></i>
                            Belum ada data informasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

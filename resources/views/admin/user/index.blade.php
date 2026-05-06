@extends('layouts.app')

@section('content')

{{-- ============================================================
     FILE: resources/views/admin/user/index.blade.php
============================================================ --}}

<style>
body { background: #f0f4f8 !important; }

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}

.page-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.page-icon {
    width: 46px;
    height: 46px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    color: #fff;
    box-shadow: 0 4px 14px rgba(6,78,59,0.3);
}

.page-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin: 2px 0 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.stat-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    animation: fadeUp 0.35s ease;
    transition: all 0.15s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.stat-value {
    font-size: 28px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 12.5px;
    color: #6b7280;
    font-weight: 500;
    margin: 0;
}

.stat-card:nth-child(1) .stat-value { color: #111827; }
.stat-card:nth-child(2) .stat-value { color: #6366f1; }
.stat-card:nth-child(3) .stat-value { color: #064e3b; }
.stat-card:nth-child(4) .stat-value { color: #f59e0b; }

.card {
    border: 1px solid #e5e7eb !important;
    border-radius: 16px !important;
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
    overflow: hidden;
    animation: fadeUp 0.35s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
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
    padding: 11px 18px;
    white-space: nowrap;
}

.table tbody td {
    color: #111827;
    font-size: 13.5px;
    padding: 15px 18px;
    border-bottom: 1px solid #f3f4f6 !important;
    vertical-align: middle;
}

.table tbody tr:last-child td { border-bottom: none !important; }
.table tbody tr:hover td { background: #fafafa; }

.nama-cell { font-weight: 700; color: #111827; }
.email-cell { color: #6b7280; font-size: 13px; }

.badge-role {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: lowercase;
}

.badge-admin { background: #eef2ff; color: #4f46e5; border: 1px solid #c7d2fe; }
.badge-user  { background: #f0fdf4; color: #064e3b; border: 1px solid #bbf7d0; }
.badge-rt    { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }

.btn {
    border-radius: 8px !important;
    font-size: 12px;
    padding: 5px 13px;
    font-weight: 600;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.btn-tambah {
    background: linear-gradient(135deg, #064e3b, #0d6e4f) !important;
    border: none !important;
    color: #ffffff !important;
    border-radius: 10px !important;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
    box-shadow: 0 3px 10px rgba(6,78,59,0.3);
}

.btn-tambah:hover { opacity: 0.9; color: #fff !important; transform: translateY(-1px); }

.btn-edit  { background: #fff7ed !important; border: 1px solid #fed7aa !important; color: #ea580c !important; }
.btn-edit:hover { background: #ffedd5 !important; }

.btn-hapus { background: #fef2f2 !important; border: 1px solid #fecaca !important; color: #dc2626 !important; }
.btn-hapus:hover { background: #fee2e2 !important; }

.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-top: 1px solid #f3f4f6;
}

.pagination-info { font-size: 12.5px; color: #6b7280; }

.pagination {
    display: flex;
    gap: 4px;
    margin: 0;
    list-style: none;
    padding: 0;
}

.pagination .page-item .page-link {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px !important;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    background: #ffffff;
    border: 1px solid #e5e7eb !important;
    text-decoration: none;
    transition: all 0.15s ease;
}

.pagination .page-item .page-link:hover { background: #f0fdf4; border-color: #064e3b !important; color: #064e3b; }
.pagination .page-item.active .page-link { background: #064e3b !important; border-color: #064e3b !important; color: #ffffff !important; }
.pagination .page-item.disabled .page-link { background: #f9fafb; color: #d1d5db; cursor: not-allowed; }

.alert-success-custom {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
    border-radius: 10px;
    font-size: 13px;
    padding: 10px 16px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>

<div class="container-fluid" style="padding: 28px 28px;">

    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div>
                <h1 class="page-title">Kelola Data User</h1>
                <p class="page-subtitle">Manajemen akun dan hak akses pengguna</p>
            </div>
        </div>
        <a href="{{ route('admin.user.create') }}" class="btn-tambah">
            <i class="fas fa-plus" style="font-size:11px;"></i> Tambah User RT
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <p class="stat-value">{{ $user->count() }}</p>
            <p class="stat-label">Total User</p>
        </div>
        <div class="stat-card">
            <p class="stat-value">{{ $user->where('role','admin')->count() }}</p>
            <p class="stat-label">Admin</p>
        </div>
        <div class="stat-card">
            <p class="stat-value">{{ $user->where('role','user')->count() }}</p>
            <p class="stat-label">User</p>
        </div>
        <div class="stat-card">
            <p class="stat-value">{{ $user->where('role','rt')->count() }}</p>
            <p class="stat-label">RT</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user as $index => $u)
                    <tr class="user-row">
                        <td style="color:#9ca3af; font-weight:600;">{{ $index + 1 }}</td>
                        <td class="nama-cell">{{ $u->name }}</td>
                        <td class="email-cell">{{ $u->email }}</td>
                        <td>
                            @if($u->role == 'admin')
                                <span class="badge-role badge-admin">admin</span>
                            @elseif($u->role == 'rt')
                                <span class="badge-role badge-rt">rt</span>
                            @else
                                <span class="badge-role badge-user">user</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.user.edit', $u->id) }}" class="btn btn-edit">
                                    <i class="fas fa-edit" style="font-size:11px;"></i> Edit
                                </a>
                                <form action="{{ route('admin.user.delete', $u->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-hapus" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash" style="font-size:11px;"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            <p class="pagination-info" id="paginationInfo"></p>
            <ul class="pagination" id="paginationControls"></ul>
        </div>
    </div>

</div>

<script>
const PER_PAGE = 10;
let currentPage = 1;
const rows = document.querySelectorAll('.user-row');
const totalRows = rows.length;
const totalPages = Math.ceil(totalRows / PER_PAGE);

function showPage(page) {
    currentPage = page;
    const start = (page - 1) * PER_PAGE;
    const end = start + PER_PAGE;
    rows.forEach((row, i) => { row.style.display = (i >= start && i < end) ? '' : 'none'; });
    const from = start + 1;
    const to = Math.min(end, totalRows);
    document.getElementById('paginationInfo').textContent = `Menampilkan ${from}–${to} dari ${totalRows} data`;
    renderPagination();
}

function renderPagination() {
    const ul = document.getElementById('paginationControls');
    ul.innerHTML = '';
    const prevLi = document.createElement('li');
    prevLi.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
    prevLi.innerHTML = `<a class="page-link" href="#">‹</a>`;
    prevLi.addEventListener('click', (e) => { e.preventDefault(); if (currentPage > 1) showPage(currentPage - 1); });
    ul.appendChild(prevLi);
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = 'page-item' + (i === currentPage ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', (e) => { e.preventDefault(); showPage(i); });
        ul.appendChild(li);
    }
    const nextLi = document.createElement('li');
    nextLi.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
    nextLi.innerHTML = `<a class="page-link" href="#">›</a>`;
    nextLi.addEventListener('click', (e) => { e.preventDefault(); if (currentPage < totalPages) showPage(currentPage + 1); });
    ul.appendChild(nextLi);
}

showPage(1);
</script>

@endsection

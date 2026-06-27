@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="spp-wrapper">

    <div class="spp-page-header">
        <div class="spp-header-bg"></div>
        <div class="spp-header-content">
            <div class="spp-header-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <h1 class="spp-title">Status Pengaduan Saya</h1>
                <p class="spp-subtitle">Pantau perkembangan laporan yang telah Anda kirimkan</p>
            </div>
            <div class="spp-header-stat ms-auto">
                <span class="spp-stat-number">{{ count($layanan) }}</span>
                <span class="spp-stat-label">Total Laporan</span>
            </div>
        </div>
    </div>

    <div class="spp-card">
        @if(count($layanan) === 0)
        <div class="spp-empty">
            <div class="spp-empty-icon"><i class="fas fa-inbox"></i></div>
            <p class="spp-empty-text">Belum ada pengaduan yang diajukan</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="spp-table">
                <thead>
                    <tr>
                        <th class="spp-th-no">No</th>
                        <th>Tanggal Pengaduan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($layanan as $item)
                    <tr class="spp-row">
                        <td><span class="spp-number">{{ $loop->iteration }}</span></td>
                        <td>
                            <div class="spp-date-wrap">
                                <span class="spp-date-icon"><i class="far fa-calendar-alt"></i></span>
                                <span class="spp-date-text">{{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->translatedFormat('d M Y') }}</span>
                                <span class="spp-time-text">{{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td><span style="font-size:13px;font-weight:600;">{{ ucfirst($item->kategori_masalah) }}</span></td>
                        <td>
                            @if($item->status == 'diajukan')
                                <span class="spp-badge spp-badge--blue"><span class="spp-badge-dot"></span> Diajukan</span>
                            @elseif($item->status == 'diproses')
                                <span class="spp-badge spp-badge--amber"><span class="spp-badge-dot spp-badge-dot--pulse"></span> Diproses</span>
                            @else
                                <span class="spp-badge spp-badge--green"><span class="spp-badge-dot"></span> Selesai</span>
                            @endif
                        </td>
                        <td>
                            <button class="spp-btn-detail" data-toggle="modal" data-target="#detail{{ $item->id }}">
                                <i class="fas fa-eye"></i> <span>Lihat Detail</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- MODALS --}}
@foreach($layanan as $item)
<div class="modal fade spp-modal-wrap" id="detail{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content spp-modal">

            <div class="spp-modal-header">
                <div class="spp-modal-header-left">
                    <div class="spp-modal-icon"><i class="fas fa-file-alt"></i></div>
                    <div>
                        <h5 class="spp-modal-title">Detail Pengaduan</h5>
                        <span class="spp-modal-date">{{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                </div>
                <button class="spp-modal-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>

            <div class="spp-modal-body">

                {{-- Status --}}
                <div class="spp-modal-section spp-modal-status-row">
                    <span class="spp-modal-label">Status Saat Ini</span>
                    @if($item->status == 'diajukan')
                        <span class="spp-badge spp-badge--blue"><span class="spp-badge-dot"></span> Diajukan</span>
                    @elseif($item->status == 'diproses')
                        <span class="spp-badge spp-badge--amber"><span class="spp-badge-dot spp-badge-dot--pulse"></span> Diproses RT</span>
                    @else
                        <span class="spp-badge spp-badge--green"><span class="spp-badge-dot"></span> Selesai</span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="spp-modal-section">
                    <span class="spp-modal-label"><i class="fas fa-align-left me-1"></i> Deskripsi Laporan</span>
                    <div class="spp-modal-box">{{ $item->deskripsi }}</div>
                </div>

                {{-- Foto pengaduan dari penghuni --}}
                @if($item->foto)
                <div class="spp-modal-section">
                    <span class="spp-modal-label"><i class="fas fa-image me-1"></i> Foto Laporan Anda</span>
                    <div class="spp-modal-img-wrap">
                        <img src="{{ asset('storage/'.$item->foto) }}" class="spp-modal-img" alt="Foto Pengaduan">
                    </div>
                </div>
                @endif

                {{-- Tanggapan RT --}}
                <div class="spp-modal-section">
                    <span class="spp-modal-label"><i class="fas fa-reply me-1"></i> Tanggapan RT</span>
                    <div class="spp-modal-box {{ !$item->tanggapan_admin ? 'spp-modal-box--empty' : '' }}">
                        @if($item->tanggapan_admin)
                            {{ $item->tanggapan_admin }}
                        @else
                            <span class="spp-empty-reply"><i class="far fa-clock me-1"></i> Menunggu tanggapan RT...</span>
                        @endif
                    </div>
                </div>

                {{-- Bukti Penyelesaian dari RT (hanya muncul jika status selesai) --}}
                @if($item->status == 'selesai')
                <div class="spp-modal-section" style="border:1.5px solid #a7f3d0;border-radius:12px;padding:14px;background:#f0fdf4;">
                    <span class="spp-modal-label" style="color:#064e3b;"><i class="fas fa-check-double me-1"></i> Bukti Penyelesaian dari RT</span>

                    @if($item->catatan_selesai ?? null)
                    <div class="spp-modal-box" style="margin-top:8px;border-color:#a7f3d0;background:#ecfdf5;">
                        <strong style="color:#064e3b;"><i class="fas fa-sticky-note me-1"></i> Keterangan RT:</strong><br>
                        {{ $item->catatan_selesai }}
                    </div>
                    @endif

                    @if($item->foto_bukti_rt ?? null)
                    <div class="spp-modal-img-wrap" style="margin-top:10px;">
                        <img src="{{ asset('storage/'.$item->foto_bukti_rt) }}" class="spp-modal-img" alt="Bukti Selesai RT">
                    </div>
                    <p style="font-size:11px;color:#059669;text-align:center;margin-top:6px;">
                        <i class="fas fa-camera"></i> Foto bukti dari RT
                    </p>
                    @endif

                    @if(!($item->catatan_selesai ?? null) && !($item->foto_bukti_rt ?? null))
                    <div class="spp-modal-box spp-modal-box--empty" style="margin-top:8px;">
                        <span class="spp-empty-reply">Pengaduan telah ditandai selesai oleh RT</span>
                    </div>
                    @endif
                </div>
                @endif

            </div>

            <div class="spp-modal-footer">
                <button class="spp-btn-close" data-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach

@endsection

<style>
*, *::before, *::after { box-sizing: border-box; }
:root {
    --emerald-50:#ecfdf5;--emerald-100:#d1fae5;--emerald-200:#a7f3d0;
    --emerald-400:#34d399;--emerald-500:#10b981;--emerald-600:#059669;
    --emerald-700:#047857;--emerald-800:#065f46;--emerald-900:#064e3b;
    --blue-50:#eff6ff;--blue-100:#dbeafe;--blue-500:#3b82f6;--blue-700:#1d4ed8;
    --amber-50:#fffbeb;--amber-100:#fef3c7;--amber-500:#f59e0b;--amber-700:#b45309;
    --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;
    --gray-400:#9ca3af;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;
    --gray-800:#1f2937;--gray-900:#111827;
}
body { background:#f0f4f8; font-family:'Plus Jakarta Sans',sans-serif; }

.spp-wrapper { max-width:960px; margin:0 auto; padding:28px 20px 60px; }

.spp-page-header { position:relative; background:linear-gradient(135deg,var(--emerald-900) 0%,var(--emerald-700) 55%,var(--emerald-500) 100%); border-radius:20px; margin-bottom:20px; overflow:hidden; padding:28px; }
.spp-header-bg { position:absolute; inset:0; background-image:radial-gradient(circle at 85% 20%,rgba(255,255,255,0.07) 0%,transparent 50%); pointer-events:none; }
.spp-header-content { position:relative; display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
.spp-header-icon { width:52px; height:52px; background:rgba(255,255,255,0.15); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; flex-shrink:0; border:1px solid rgba(255,255,255,0.2); }
.spp-title { font-size:20px; font-weight:800; color:#fff; margin:0 0 3px; }
.spp-subtitle { font-size:13px; color:rgba(255,255,255,0.7); margin:0; }
.spp-header-stat { text-align:right; flex-shrink:0; }
.spp-stat-number { display:block; font-size:32px; font-weight:800; color:#fff; line-height:1; }
.spp-stat-label { display:block; font-size:11px; color:rgba(255,255,255,0.65); font-weight:500; text-transform:uppercase; letter-spacing:0.8px; margin-top:4px; }

.spp-card { background:#fff; border-radius:18px; box-shadow:0 1px 3px rgba(0,0,0,0.04),0 8px 24px rgba(0,0,0,0.06); overflow:hidden; border:1px solid var(--gray-100); }
.spp-table { width:100%; border-collapse:collapse; }
.spp-table thead tr { background:var(--gray-50); border-bottom:1.5px solid var(--gray-100); }
.spp-table thead th { font-size:11.5px; font-weight:700; color:var(--emerald-800); text-transform:uppercase; letter-spacing:0.7px; padding:14px 20px; text-align:left; }
.spp-th-no { width:60px; text-align:center !important; }
.spp-row { border-bottom:1px solid var(--gray-100); transition:background 0.15s; }
.spp-row:last-child { border-bottom:none; }
.spp-row:hover { background:var(--emerald-50); }
.spp-table td { padding:16px 20px; vertical-align:middle; font-size:13.5px; color:var(--gray-700); }
.spp-number { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:var(--emerald-50); color:var(--emerald-800); border-radius:8px; font-weight:700; font-size:12.5px; border:1px solid var(--emerald-200); }
.spp-date-wrap { display:flex; align-items:center; gap:8px; }
.spp-date-icon { color:var(--gray-400); font-size:13px; }
.spp-date-text { font-weight:600; color:var(--gray-800); font-size:13.5px; }
.spp-time-text { font-size:12px; color:var(--gray-400); background:var(--gray-100); padding:2px 8px; border-radius:20px; font-weight:500; }

.spp-badge { display:inline-flex; align-items:center; gap:7px; padding:5px 12px 5px 10px; border-radius:20px; font-size:12px; font-weight:700; white-space:nowrap; }
.spp-badge-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.spp-badge--blue { background:var(--blue-50); color:var(--blue-700); border:1px solid var(--blue-100); }
.spp-badge--blue .spp-badge-dot { background:var(--blue-500); }
.spp-badge--amber { background:var(--amber-50); color:var(--amber-700); border:1px solid var(--amber-100); }
.spp-badge--amber .spp-badge-dot { background:var(--amber-500); }
.spp-badge--green { background:var(--emerald-50); color:var(--emerald-800); border:1px solid var(--emerald-100); }
.spp-badge--green .spp-badge-dot { background:var(--emerald-500); }
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.4;transform:scale(0.7);} }
.spp-badge-dot--pulse { animation:pulse-dot 1.4s ease-in-out infinite; }

.spp-btn-detail { display:inline-flex; align-items:center; gap:7px; padding:7px 16px; background:linear-gradient(135deg,var(--emerald-600),var(--emerald-500)); color:#fff; border:none; border-radius:10px; font-size:12.5px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; transition:all 0.2s; box-shadow:0 2px 8px rgba(5,150,105,0.25); }
.spp-btn-detail:hover { background:linear-gradient(135deg,var(--emerald-700),var(--emerald-600)); transform:translateY(-1px); color:#fff; }

.spp-empty { padding:60px 20px; text-align:center; }
.spp-empty-icon { font-size:42px; color:var(--gray-200); margin-bottom:14px; }
.spp-empty-text { font-size:14px; color:var(--gray-400); margin:0; font-weight:500; }

.spp-modal { border:none; border-radius:20px !important; overflow:hidden; box-shadow:0 25px 60px rgba(0,0,0,0.18); font-family:'Plus Jakarta Sans',sans-serif; }
.spp-modal-header { display:flex; align-items:center; justify-content:space-between; padding:20px 24px; background:linear-gradient(135deg,var(--emerald-900),var(--emerald-700)); border-bottom:none; }
.spp-modal-header-left { display:flex; align-items:center; gap:14px; }
.spp-modal-icon { width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; border:1px solid rgba(255,255,255,0.2); flex-shrink:0; }
.spp-modal-title { font-size:15px; font-weight:700; color:#fff; margin:0 0 2px; }
.spp-modal-date { font-size:11.5px; color:rgba(255,255,255,0.65); }
.spp-modal-close { background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2); color:#fff; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:background 0.2s; }
.spp-modal-close:hover { background:rgba(255,255,255,0.25); }
.spp-modal-body { padding:20px 24px; }
.spp-modal-section { margin-bottom:16px; }
.spp-modal-status-row { display:flex; align-items:center; justify-content:space-between; background:var(--gray-50); border-radius:10px; padding:12px 16px; border:1px solid var(--gray-100); }
.spp-modal-label { display:block; font-size:11px; font-weight:700; color:var(--gray-400); text-transform:uppercase; letter-spacing:0.7px; margin-bottom:7px; }
.spp-modal-status-row .spp-modal-label { margin-bottom:0; }
.spp-modal-box { background:var(--gray-50); border:1px solid var(--gray-100); border-radius:10px; padding:12px 14px; font-size:13.5px; color:var(--gray-700); line-height:1.6; min-height:48px; }
.spp-modal-box--empty { border-style:dashed; }
.spp-empty-reply { color:var(--gray-400); font-size:13px; font-style:italic; }
.spp-modal-img-wrap { border-radius:12px; overflow:hidden; border:1px solid var(--gray-200); text-align:center; background:var(--gray-50); }
.spp-modal-img { max-height:280px; width:100%; object-fit:contain; }
.spp-modal-footer { padding:14px 24px 20px; border-top:1px solid var(--gray-100); display:flex; justify-content:flex-end; }
.spp-btn-close { display:inline-flex; align-items:center; padding:9px 22px; background:var(--gray-100); color:var(--gray-600); border:none; border-radius:10px; font-size:13px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; transition:all 0.2s; }
.spp-btn-close:hover { background:var(--gray-200); color:var(--gray-800); }

@media (max-width:576px) {
    .spp-wrapper { padding:16px 12px 40px; }
    .spp-title { font-size:17px; }
    .spp-subtitle { display:none; }
    .spp-time-text { display:none; }
    .spp-btn-detail span { display:none; }
    .spp-btn-detail { padding:8px 11px; }
}
</style>

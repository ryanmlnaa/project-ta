@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; }

.page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
.page-header-icon { width: 46px; height: 46px; background: linear-gradient(135deg, #064e3b, #0d6e4f); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 14px rgba(6,78,59,0.3); }
.page-header h1 { font-size: 22px; font-weight: 800; color: #1a2e1a; margin: 0; line-height: 1.2; }
.page-header p { font-size: 13px; color: #8a9e8a; margin: 0; }

.alert-success-custom { background: #f0faf4; border: 1px solid #a8e6be; border-left: 4px solid #1a6e3a; border-radius: 12px; padding: 12px 16px; color: #1a4e2a; font-size: 13.5px; font-weight: 500; display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }

.premium-card { background: #ffffff; border-radius: 16px; border: 1px solid #e8f0e8; box-shadow: 0 2px 12px rgba(0,0,0,0.05); margin-bottom: 24px; overflow: hidden; }
.premium-card-header { padding: 16px 22px; background: #ffffff; border-bottom: 1px solid #f0f5f0; display: flex; align-items: center; justify-content: space-between; }
.premium-card-header .header-left { display: flex; align-items: center; gap: 10px; }
.header-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
.header-icon.green { background: #d1fae5; color: #064e3b; }
.premium-card-header h6 { font-size: 14px; font-weight: 700; color: #1a2e1a; margin: 0; }

.premium-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
.premium-table thead tr th { background: #f6fbf7; color: #3a5a3a; font-weight: 700; font-size: 11.5px; letter-spacing: 0.5px; text-transform: uppercase; padding: 11px 14px; border-bottom: 2px solid #e0ede0; white-space: nowrap; }
.premium-table tbody tr td { padding: 11px 14px; border-bottom: 1px solid #f2f7f2; color: #2a3a2a; vertical-align: middle; }
.premium-table tbody tr:hover td { background: #f8fdf8; }
.premium-table tbody tr:last-child td { border-bottom: none; }

.badge-pill-custom { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 99px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
.badge-green  { background: #d1fae5; color: #064e3b; }
.badge-red    { background: #fdf0f0; color: #c53030; }
.badge-yellow { background: #fdfbea; color: #7a6010; }
.badge-blue   { background: #eaf0fb; color: #1a4e8e; }
.badge-gray   { background: #f3f4f6; color: #4b5563; }
.badge-orange { background: #fff7ed; color: #c05621; }

.btn-action { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.15s, transform 0.1s; }
.btn-action:hover { opacity: 0.85; transform: translateY(-1px); text-decoration: none; }
.btn-action.info    { background: #eaf0fb; color: #1a4e8e; }
.btn-action.warn    { background: #fdf8ea; color: #8a6000; }
.btn-action.danger  { background: #fdf0f0; color: #c53030; }
.btn-action.success { background: #d1fae5; color: #064e3b; }
.btn-action.orange  { background: #fff7ed; color: #c05621; }

.form-inline-group { display: flex; flex-direction: column; gap: 6px; min-width: 200px; }
.form-inline-group textarea { border-radius: 9px !important; border: 1.5px solid #e0ede0 !important; font-size: 12px !important; padding: 7px 10px !important; resize: none; font-family: 'Plus Jakarta Sans', sans-serif; outline: none; transition: border-color 0.15s; }
.form-inline-group textarea:focus { border-color: #1a6e3a !important; box-shadow: 0 0 0 3px rgba(26,110,58,0.1); }
.form-inline-group input[type="file"] { font-size: 11px; border: 1.5px dashed #c0d8c0; border-radius: 8px; padding: 5px 8px; background: #f8fdf8; }

.bukti-img { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.12); cursor: pointer; transition: transform 0.15s; }
.bukti-img:hover { transform: scale(1.1); }

.desc-text { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }

.table-responsive-wrapper { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
@media (max-width: 768px) { .premium-table { min-width: 900px; } .page-header h1 { font-size: 18px; } }

/* Modal Bukti */
.modal-bukti .modal-content { border-radius: 16px; overflow: hidden; border: none; }
.modal-bukti .modal-header { background: linear-gradient(135deg,#064e3b,#0d9e6e); border: none; }
.modal-bukti .modal-title { color: #fff; font-weight: 700; font-size: 15px; }
.modal-bukti .close { color: #fff; opacity: 0.8; }
.modal-bukti img { width: 100%; border-radius: 10px; }
.catatan-box { background: #f8fdf8; border: 1px solid #c8e6c8; border-radius: 10px; padding: 12px 16px; font-size: 13px; color: #1a3e1a; line-height: 1.6; }
</style>

<div class="container-fluid">

    <div class="page-header">
        <div class="page-header-icon"><i class="fas fa-headset"></i></div>
        <div>
            <h1>Layanan Pengaduan</h1>
            <p>Manajemen pengaduan dan tanggapan penghuni</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-success-custom" style="border-left-color:#c53030;background:#fff5f5;color:#c53030;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="premium-card">
        <div class="premium-card-header">
            <div class="header-left">
                <div class="header-icon green"><i class="fas fa-clipboard-list"></i></div>
                <h6>Daftar Pengaduan</h6>
            </div>
        </div>

        <div class="premium-card-body" style="padding:0;">
        <div class="table-responsive-wrapper">
        <table class="premium-table" id="dataTable" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Foto Pengadu</th>
                    <th>Status</th>
                    <th>Tanggapan RT</th>
                    <th>Bukti Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td><strong>{{ $item->penghuni->nama ?? '-' }}</strong></td>

                    <td style="white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($item->tanggal_pengaduan)->translatedFormat('d M Y') }}
                    </td>

                    <td>
                        <span class="badge-pill-custom badge-blue">
                            <i class="fas fa-tag" style="font-size:9px"></i>
                            {{ ucfirst($item->kategori_masalah) }}
                        </span>
                    </td>

                    <td>
                        <span class="desc-text" title="{{ $item->deskripsi }}">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi, 45) }}
                        </span>
                    </td>

                    {{-- Foto dari penghuni --}}
                    <td>
                        @if($item->foto)
                            <img src="{{ asset('storage/'.$item->foto) }}" class="bukti-img"
                                 data-toggle="modal" data-target="#fotoModal{{ $item->id }}">
                        @else
                            <span style="color:#ccc;font-size:12px;">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($item->status == 'diajukan')
                            <span class="badge-pill-custom badge-yellow"><i class="fas fa-paper-plane" style="font-size:9px"></i> Diajukan</span>
                        @elseif($item->status == 'diproses')
                            <span class="badge-pill-custom badge-orange"><i class="fas fa-spinner" style="font-size:9px"></i> Diproses</span>
                        @elseif($item->status == 'selesai')
                            <span class="badge-pill-custom badge-green"><i class="fas fa-check-circle" style="font-size:9px"></i> Selesai</span>
                        @else
                            <span class="badge-pill-custom badge-gray">—</span>
                        @endif
                    </td>

                    {{-- Tanggapan RT --}}
                    <td style="max-width:160px;">
                        @if($item->tanggapan_admin)
                            <span class="desc-text" title="{{ $item->tanggapan_admin }}">
                                {{ \Illuminate\Support\Str::limit($item->tanggapan_admin, 40) }}
                            </span>
                        @else
                            <span style="color:#ccc;font-size:12px;font-style:italic;">Belum ada</span>
                        @endif
                    </td>

                    {{-- Bukti Selesai dari RT --}}
                    <td>
                        @if($item->foto_bukti_rt ?? null)
                            <img src="{{ asset('storage/'.$item->foto_bukti_rt) }}" class="bukti-img"
                                 data-toggle="modal" data-target="#buktirtModal{{ $item->id }}"
                                 title="Lihat bukti selesai">
                        @elseif($item->catatan_selesai ?? null)
                            <span style="color:#064e3b;font-size:11px;"><i class="fas fa-check"></i> Ada catatan</span>
                        @else
                            <span style="color:#ccc;font-size:12px;">—</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td style="white-space:nowrap;min-width:200px;">

                        {{-- RT: Tanggapi (status diajukan) --}}
                        @if(auth()->user()->role == 'rt' && $item->status == 'diajukan')
                            <button class="btn-action success" style="margin-bottom:4px;"
                                    data-toggle="modal" data-target="#tanggapiModal{{ $item->id }}">
                                <i class="fas fa-reply" style="font-size:10px"></i> Tanggapi
                            </button>
                        @endif

                        {{-- RT: Konfirmasi Selesai (status diproses) --}}
                        @if(auth()->user()->role == 'rt' && $item->status == 'diproses')
                            <button class="btn-action orange" style="margin-bottom:4px;"
                                    data-toggle="modal" data-target="#selesaiModal{{ $item->id }}">
                                <i class="fas fa-check-double" style="font-size:10px"></i> Konfirmasi Selesai
                            </button>
                        @endif

                        {{-- HAPUS --}}
                        {{-- <form action="{{ route('layanan.delete', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn-action danger" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash" style="font-size:10px"></i> Hapus
                            </button>
                        </form> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:32px;color:#aaa;">
                        <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px;opacity:0.4;"></i>
                        Belum ada data pengaduan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     MODALS
═══════════════════════════════════════════════ --}}
@foreach($layanan as $item)

{{-- Modal Foto Penghuni --}}
@if($item->foto)
<div class="modal fade modal-bukti" id="fotoModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-image me-2"></i> Foto Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto Pengaduan">
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Foto Bukti RT --}}
@if($item->foto_bukti_rt ?? null)
<div class="modal fade modal-bukti" id="buktirtModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-double me-2"></i> Bukti Penyelesaian RT</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/'.$item->foto_bukti_rt) }}" alt="Bukti RT" style="margin-bottom:12px;">
                @if($item->catatan_selesai ?? null)
                    <div class="catatan-box">
                        <strong><i class="fas fa-sticky-note me-1"></i> Catatan Selesai:</strong><br>
                        {{ $item->catatan_selesai }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Tanggapi RT --}}
@if(auth()->user()->role == 'rt' && $item->status == 'diajukan')
<div class="modal fade" id="tanggapiModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#064e3b,#0d9e6e);border:none;">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="fas fa-reply me-2"></i> Tanggapi Pengaduan</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:.8;"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <p style="font-size:13px;color:#555;margin-bottom:4px;">
                    <strong>Penghuni:</strong> {{ $item->penghuni->nama ?? '-' }}<br>
                    <strong>Kategori:</strong> {{ ucfirst($item->kategori_masalah) }}<br>
                    <strong>Deskripsi:</strong> {{ $item->deskripsi }}
                </p>
                <hr style="margin:12px 0;">
                <form action="{{ route('layanan.tanggapi.rt', $item->id) }}" method="POST">
                    @csrf
                    <div class="form-inline-group">
                        <label style="font-size:12px;font-weight:700;color:#1a3e1a;">Tanggapan RT:</label>
                        <textarea name="tanggapan_admin" rows="3"
                            placeholder="Tulis tanggapan untuk penghuni..." required></textarea>
                        <button type="submit" class="btn-action success" style="width:100%;justify-content:center;padding:9px;">
                            <i class="fas fa-paper-plane"></i> Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Modal Konfirmasi Selesai RT --}}
@if(auth()->user()->role == 'rt' && $item->status == 'diproses')
<div class="modal fade" id="selesaiModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#c05621,#dd6b20);border:none;">
                <h5 class="modal-title" style="color:#fff;font-weight:700;"><i class="fas fa-check-double me-2"></i> Konfirmasi Selesai</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:.8;"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding:20px 24px;">
                <p style="font-size:13px;color:#555;margin-bottom:4px;">
                    <strong>Penghuni:</strong> {{ $item->penghuni->nama ?? '-' }}<br>
                    <strong>Kategori:</strong> {{ ucfirst($item->kategori_masalah) }}
                </p>
                @if($item->tanggapan_admin)
                    <div class="catatan-box" style="margin:10px 0;">
                        <i class="fas fa-comment-alt me-1"></i> <strong>Tanggapan sebelumnya:</strong><br>
                        {{ $item->tanggapan_admin }}
                    </div>
                @endif
                <hr style="margin:12px 0;">
                <form action="{{ route('layanan.konfirmasi.selesai', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-inline-group">
                        <label style="font-size:12px;font-weight:700;color:#1a3e1a;">
                            Catatan Telah Selesai Diproses: <span style="color:red">*</span>
                        </label>
                        <textarea name="catatan_selesai" rows="3"
                            placeholder="Jelaskan apa yang telah dilakukan untuk menyelesaikan pengaduan ini..." required></textarea>

                        <label style="font-size:12px;font-weight:700;color:#1a3e1a;margin-top:6px;">
                            Upload Foto Bukti: <span style="color:#888;font-weight:400;">(opsional)</span>
                        </label>
                        <input type="file" name="foto_bukti_rt" accept="image/*">
                        <small style="color:#888;font-size:11px;">Format: JPG, JPEG, PNG. Maks: 3MB</small>

                        <button type="submit" class="btn-action orange" style="width:100%;justify-content:center;padding:9px;margin-top:4px;"
                            onclick="return confirm('Konfirmasi bahwa pengaduan ini telah selesai ditangani?')">
                            <i class="fas fa-check-double"></i> Konfirmasi Selesai & Kirim Notifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    if ($.fn.DataTable) {
        $('#dataTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            dom: '<"d-flex justify-content-between align-items-center px-3 pt-3"lf>t<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: { first:"«", last:"»", next:"›", previous:"‹" },
                emptyTable: "Belum ada data pengaduan"
            }
        });
    }
});
</script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">

        <h3 class="mb-4 fw-bold text-primary">Beranda Penghuni</h3>

        <div class="mt-5">

            <h4 class="mb-4">📢 Informasi & Pengumuman</h4>

            @php
                $slider = $informasi->where('is_penting', 1)->values();
            @endphp

            <div id="carouselExample" class="carousel slide carousel-fade mb-4" data-ride="carousel" data-interval="2000"
                data-pause="false">

                <div class="carousel-inner rounded shadow">

                    @foreach($slider as $key => $info)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                            <img src="{{ asset('informasi/' . $info->gambar) }}" class="d-block w-100"
                                style="height:350px; object-fit:cover;">

                            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                                <h4>{{ $info->judul }}</h4>
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            <div class="informasi-scroll d-flex">

                @foreach($informasi as $info)
                    <a href="{{ route('user.informasi.detail', $info->id) }}" class="informasi-item">

                        <div class="card shadow-sm h-100">

                            <img src="{{ asset('informasi/' . $info->gambar) }}" class="card-img-top"
                                style="height:150px; object-fit:cover;">

                            <div class="card-body">

                                @if($info->is_penting)
                                    <span class="badge bg-danger">🔥 Penting</span>
                                @endif

                                <h6 class="mt-2">{{ $info->judul }}</h6>

                                <small class="text-muted">
                                    📅 {{ $info->tanggal }} | 👁️ {{ $info->views }}x
                                </small>

                                <p class="mt-2">
                                    {{ Str::limit($info->isi, 60) }}
                                </p>

                            </div>

                        </div>

                    </a>
                @endforeach

            </div>

            @forelse($informasi as $info)

            @empty
                <div class="alert alert-warning text-center">
                    Belum ada informasi
                </div>
            @endforelse
        </div>

        {{-- 🔔 NOTIF --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        {{-- ========================= --}}
        {{-- DATA PENGHUNI --}}
        {{-- ========================= --}}

        {{-- 🔥 FORM INPUT PENGHUNI (JIKA BELUM ADA DATA) --}}
        @if(!isset($penghuni))

            <div class="card modern-card mb-3 border-danger">
                <div class="card-body">

                    <h5 class="fw-bold text-danger">⚠️ Lengkapi Data Penghuni</h5>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('user.simpan.penghuni') }}" method="POST">
                        @csrf

                        <div class="mb-2">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>No KTP</label>
                            <input type="text" name="no_ktp" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>No HP</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>

                        {{-- <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div> --}}

                        <div class="mb-2">
                            <label>Status Huni</label>
                            <select name="status_huni" id="statusHuni" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                        </div>

                        <div class="mb-2 d-none" id="tanggalKeluarField">
                            <label>Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" id="tanggalKeluarInput" class="form-control">
                        </div>

                        <button class="btn btn-primary w-100 mt-2">
                            💾 Simpan Data
                        </button>
                    </form>

                </div>
            </div>

        @endif
        {{-- @if(isset($penghuni))
        <div class="card modern-card mb-3">
            <div class="card-body">
                <h5 class="fw-bold">👤 Data Anda</h5>
                <p><b>Nama:</b> {{ $penghuni->nama }}</p>
                <p><b>Email:</b> {{ $penghuni->email }}</p>

                <p><b>Status Huni:</b>
                    <span
                        class="badge
                                                                                                                                                                                                                                                                                                                                                                {{ $penghuni->status_huni == 'Tetap' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $penghuni->status_huni }}
                    </span>
                </p>
            </div>
        </div>
        @endif --}}

        {{-- <h4 class="fw-bold">👤 Data Anda</h4> --}}
        {{-- ========================= --}}
        {{-- 🏠 RUMAH SAYA --}}
        {{-- ========================= --}}
        {{-- @if(isset($penghuni) && $penghuni->rumah)

        <div class="card modern-card mb-3">
            <div class="card-body">

                <h5 class="fw-bold">🏠 Rumah Saya</h5>

                <p>
                    <b>Blok:</b> {{ $penghuni->rumah->blok }} <br>
                    <b>No Rumah:</b> {{ $penghuni->rumah->no_rumah }}
                </p>

                <p>
                    <b>Status:</b>
                    <span
                        class="badge
                                                                                                                                                                                                                                                                                                                                                            {{ $penghuni->rumah->status == 'Terisi' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $penghuni->rumah->status }}
                    </span>
                </p>

            </div>
        </div>

        @endif --}}

        {{-- ========================= --}}
        {{-- DATA IURAN --}}
        {{-- ========================= --}}
        <h4 class="fw-bold">💰 Data Iuran Saya</h4>

        @forelse($iuran as $i)
            <div class="card modern-card mb-3">
                <div class="card-body">

                    <h5>Iuran {{ $i->bulan }} {{ $i->tahun }}</h5>

                    <p><b>Jumlah:</b> Rp {{ number_format($i->jumlah, 0, ',', '.') }}</p>

                    <p><b>Status:</b>
                        <span
                            class="badge
                                                                                                                                                                                                                                                                                                                                                                    {{ $i->status == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($i->status) }}
                        </span>
                    </p>

                    {{-- PROGRESS --}}
                    <div class="timeline">
                        <div class="timeline-step {{ $i->bukti_pembayaran ? 'active' : '' }}">📤</div>
                        <div class="timeline-step {{ $i->status == 'lunas' ? 'active' : '' }}">✔</div>
                        <div class="timeline-line"></div>
                    </div>

                </div>
            </div>

            {{-- 🔥 TOMBOL HAPUS DI SINI --}}
            <div class="mt-3">
                @if($i->status == 'lunas')
                    <form action="{{ route('user.iuran.delete', $i->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            🗑️ Hapus
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        ❌ Tidak bisa dihapus
                    </button>
                @endif
            </div>
        @empty
            <div class="alert alert-warning">Belum ada data iuran</div>
        @endforelse

        {{-- ========================= --}}
        {{-- STATUS PENGADUAN --}}
        {{-- ========================= --}}
        <h4 class="mt-4 fw-bold">📢 Status Pengaduan Saya</h4>

        {{-- @php
        $pengaduan = \App\Models\Layanan::where('penghuni_id', $penghuni->id ?? 0)->latest()->get();
        @endphp --}}

        @forelse($pengaduan as $p)
            <div class="card modern-card mb-3">
                <div class="card-body">

                    {{-- 🔥 TOMBOL HAPUS PENGADUAN --}}
                    @if($p->status == 'selesai')
                        <form action="{{ route('user.layanan.delete', $p->id) }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                🗑️ Hapus Pengaduan
                            </button>
                        </form>
                    @endif

                    <div class="d-flex justify-content-between">
                        <h5>#P-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</h5>

                        <span
                            class="badge
                                                                                                                                                                                                                                                                                                                                                                    {{ $p->status == 'selesai' ? 'bg-success' : ($p->status == 'diproses' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>

                    <p class="text-muted">
                        {{ \Illuminate\Support\Str::limit($p->deskripsi, 80) }}
                    </p>

                    {{-- TIMELINE --}}
                    <div class="timeline">
                        <div class="timeline-step active">📩</div>
                        <div class="timeline-step {{ $p->status != 'diajukan' ? 'active' : '' }}">⚙️</div>
                        <div class="timeline-step {{ $p->status == 'selesai' ? 'active' : '' }}">✅</div>
                        <div class="timeline-line"></div>
                    </div>

                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($p->tanggal_pengaduan)->translatedFormat('d M Y H:i') }}
                    </small>

                    @if($p->tanggapan_admin)
                        <div class="alert alert-success mt-2">
                            <b>Tanggapan:</b> {{ $p->tanggapan_admin }}
                        </div>
                    @endif

                </div>
            </div>
        @empty
            <div class="alert alert-info">Belum ada pengaduan</div>
        @endforelse

    </div>
@endsection

{{-- 🔥 STYLE + SCRIPT DIGABUNG --}}
@section('scripts')
    <style>
        /* 🔥 CARD MODERN */
        .modern-card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .modern-card:hover {
            transform: translateY(-3px);
        }

        /* 🔥 TIMELINE */
        .timeline {
            position: relative;
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .timeline-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: 0.3s;
        }

        .timeline-step.active {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            transform: scale(1.1);
        }

        .timeline-line {
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 5px;
            background: #e5e7eb;
            z-index: 1;
            border-radius: 10px;
        }

        /* ANIMASI */
        .modern-card {
            animation: fadeUp 0.4s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .informasi-card {
            border-radius: 15px;
            transition: 0.3s;
        }

        .informasi-card:hover {
            transform: translateY(-5px);
        }

        .posisi-badge {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .informasi-card {
            cursor: pointer;
        }

        .informasi-full {
            border-radius: 20px;
            transition: 0.3s;
        }

        .informasi-full:hover {
            transform: scale(1.01);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .informasi-full {
            border-radius: 20px;
            transition: 0.3s;
            cursor: pointer;
        }

        .informasi-full:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .informasi-full {
            cursor: pointer;
        }

        .informasi-scroll {
            overflow-x: auto;
            gap: 20px;
            padding-bottom: 10px;
        }

        .informasi-item {
            min-width: 300px;
            max-width: 300px;
            flex: 0 0 auto;
            text-decoration: none;
            color: black;
        }

        .informasi-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .informasi-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const statusHuni = document.getElementById('statusHuni');
            const tanggalKeluarField = document.getElementById('tanggalKeluarField');
            const tanggalKeluarInput = document.getElementById('tanggalKeluarInput');

            if (statusHuni) {
                statusHuni.addEventListener('change', function () {
                    if (this.value === 'Kontrak') {
                        tanggalKeluarField.classList.remove('d-none');
                        tanggalKeluarInput.required = true;
                    } else {
                        tanggalKeluarField.classList.add('d-none');
                        tanggalKeluarInput.required = false;
                        tanggalKeluarInput.value = '';
                    }
                });
            }

        });

        window.onload = function () {
            let popup = new bootstrap.Modal(document.getElementById('popupInfo'));
            popup.show();
        }

        $(document).ready(function () {
            $('#carouselExample').carousel({
                interval: 2000,
                pause: false,
                wrap: true
            });
        });

        const container = document.querySelector('.informasi-scroll');

        setInterval(() => {
            container.scrollBy({
                left: 320,
                behavior: 'smooth'
            });
        }, 3000);
    </script>
@endsection
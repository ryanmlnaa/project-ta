@extends('layouts.app')

@section('content')
    <div class="home-wrapper">

        {{-- ===== HERO ===== --}}
        <div class="hero-banner fade-in">
            <div class="hero-bg-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            <div class="hero-content">
                <div class="hero-icon-wrap">
                    <i class="fas fa-leaf"></i>
                </div>
                <div>
                    <h2 class="hero-title">Selamat Datang, {{ auth()->user()->name }} 👋</h2>
                    <p class="hero-sub">Kelola hunian Anda dengan mudah di Green View</p>
                </div>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="stat-val">{{ $rumahList->count() ?? 0 }}</span>
                    <span class="stat-lbl">Total Kavling</span>
                </div>
                <div class="hero-stat-div"></div>
                <div class="hero-stat">
                    <span class="stat-val">{{ $rumahList->where('status', 'Kosong')->count() ?? 0 }}</span>
                    <span class="stat-lbl">Tersedia</span>
                </div>
                <div class="hero-stat-div"></div>
                <div class="hero-stat">
                    <span class="stat-val">{{ $rumahList->where('status', 'Terisi')->count() ?? 0 }}</span>
                    <span class="stat-lbl">Terisi</span>
                </div>
            </div>
        </div>

        <div class="main-grid">

            {{-- ===== PROFILE CARD ===== --}}
            <div class="profile-col fade-in" style="animation-delay:0.15s">
                <div class="glass-card profile-card">
                    <div class="profile-cover"></div>
                    <div class="profile-body">
                        <div class="profile-avatar-wrap">
                            <img src="{{ auth()->user()->photo
        ? asset('profile/' . auth()->user()->photo)
        : 'https://i.pravatar.cc/120?img=3' }}" class="profile-avatar" alt="Avatar">
                            <div class="profile-status-dot"></div>
                        </div>
                        <h5 class="profile-name">{{ auth()->user()->name }}</h5>
                        <p class="profile-email">{{ auth()->user()->email }}</p>

                        <div class="profile-badge">
                            <i class="fas fa-circle-check"></i> User Aktif
                        </div>

                        <div class="profile-divider"></div>

                        <div class="user-status-row">
                            <p>Status Hunian</p>

                            @if($penghuni)

                                {{-- BARU --}}
                                @if($penghuni->status_huni == 'Tetap')
                                    <span style="background:green;color:white;padding:5px 10px;border-radius:10px;">
                                        Sudah Punya Rumah
                                    </span>
                                @elseif($penghuni->status_huni == 'Kontrak')
                                    <span style="background:orange;color:white;padding:5px 10px;border-radius:10px;">
                                        Kontrak
                                        @if($penghuni->tanggal_keluar)
                                            sampai {{ \Carbon\Carbon::parse($penghuni->tanggal_keluar)->format('d M Y') }}
                                        @endif
                                    </span>
                                @endif

                            @else

                                <span style="background:red;color:white;padding:5px 10px;border-radius:10px;">
                                    Belum Punya
                                </span>

                            @endif
                        </div>

                        <br>

                        {{-- BARU: hanya tampil jika statusnya Kontrak --}}
                        @if($penghuni && $penghuni->status_huni == 'Kontrak')
                                        <div class="profile-info-row">
                                            <div class="profile-info-label">Kontrak Sampai</div>
                                            <span class="pil pil-amber">
                                                {{ $penghuni->tanggal_keluar
                            ? \Carbon\Carbon::parse($penghuni->tanggal_keluar)->format('d M Y')
                            : '-' }}
                                            </span>
                                        </div>
                        @endif

                        <a href="{{ route('user.profil') }}" class="btn-profile-edit">
                            <i class="fas fa-pen"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== KONTEN UTAMA ===== --}}
            <div class="content-col">

                <div class="content-col">
                    {{-- ===================== --}}
                    {{-- FORM DATA PENGHUNI --}}
                    {{-- ===================== --}}
                    @if(!$penghuni)
                        <div class="glass-card fade-in" style="animation-delay:0.2s" id="formPenghuniCard">

                            <div class="section-header">
                                <div class="section-icon green">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h5 class="section-title">Form Data Penghuni</h5>
                                    <p class="section-sub">Lengkapi data sebelum memilih rumah</p>
                                </div>
                            </div>

                            {{-- ✅ Flash success message --}}
                            @if(session('success'))
                                <div class="alert-success-gv">
                                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('user.simpan.penghuni') }}" method="POST">
                                @csrf

                                <div class="form-grid">
                                    <input type="text" class="gv-input" name="nama" value="{{ auth()->user()->name }}" readonly>

                                    <input type="text" class="gv-input" name="no_ktp" placeholder="No KTP" required
                                        value="{{ old('no_ktp') }}">

                                    <input type="text" class="gv-input" name="telepon" placeholder="No HP" required
                                        value="{{ old('telepon') }}">

                                    <input type="text" class="gv-input" name="alamat" placeholder="Alamat" required
                                        value="{{ old('alamat') }}">

                                    <select class="gv-input" name="status_huni" id="status_huni" required
                                        onchange="toggleTanggal()">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Tetap" {{ old('status_huni') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="Kontrak" {{ old('status_huni') == 'Kontrak' ? 'selected' : '' }}>Kontrak
                                        </option>
                                    </select>

                                    <div id="tanggal_keluar_box" style="display:none;">
                                        <input type="date" class="gv-input" name="tanggal_keluar"
                                            value="{{ old('tanggal_keluar') }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn-simpan-gv">
                                    <i class="fas fa-save"></i> Simpan Data
                                </button>
                            </form>

                        </div>
                    @endif

                   @if($rumah)
                {{-- ===== RUMAH SAYA ===== --}}
                <div class="glass-card fade-in" style="animation-delay:0.25s">
                    <div class="section-header">
                        <div class="section-icon green">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Rumah Saya</h5>
                            <p class="section-sub">Detail hunian terdaftar Anda</p>
                        </div>
                    </div>

                    {{-- ✅ Definisikan clusterNama DI SINI, sebelum rumah-showcase --}}
                    @php
                    $clusterMap = [
                        'A'=>'Cluster Gardenia','B'=>'Cluster Gardenia','C'=>'Cluster Gardenia',
                        'D'=>'Cluster Gardenia','E'=>'Cluster Gardenia','F'=>'Cluster Gardenia','G'=>'Cluster Gardenia',
                        'H'=>'Cluster Edelweis','I'=>'Cluster Edelweis',
                        'J'=>'Blok J','K'=>'Blok K','L'=>'Blok L',
                    ];
                    $clusterNama = $clusterMap[$penghuni->rumah->blok ?? ''] ?? '-';
                    @endphp

                    <div class="rumah-showcase">
                        <div class="rumah-img-frame">
                            <img src="{{ asset('foto_rumah/' . $penghuni->rumah->foto) }}" class="rumah-photo" alt="Foto Rumah">
                            <div class="rumah-img-overlay">
                                {{-- ✅ Sekarang $clusterNama sudah tersedia --}}
                                <span class="rumah-blok-badge">{{ $clusterNama }} — Blok {{ $penghuni->rumah->blok }}</span>
                            </div>
                        </div>

                        <div class="rumah-details">
                            <div class="detail-item">
                                <div class="detail-icon"><i class="fas fa-map"></i></div>
                                <div>
                                    <div class="detail-lbl">Cluster</div>
                                    <div class="detail-val">{{ $clusterNama }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div>
                                    <div class="detail-lbl">Blok</div>
                                    <div class="detail-val">{{ $penghuni->rumah->blok }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon"><i class="fas fa-hashtag"></i></div>
                                <div>
                                    <div class="detail-lbl">No. Rumah</div>
                                    <div class="detail-val">{{ $penghuni->rumah->no_rumah }}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon"><i class="fas fa-tag"></i></div>
                                <div>
                                    <div class="detail-lbl">Status</div>
                                    <div class="detail-val">
                                        <span class="pil pil-green">{{ $penghuni->rumah->status }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-icon"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <div class="detail-lbl">RT</div>
                                    <div class="detail-val">{{ $rtUser->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                        {{-- ===== EMPTY STATE ===== --}}
                        <div class="glass-card fade-in" style="animation-delay:0.25s">
                            <div class="empty-hero">
                                <div class="empty-icon-wrap">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h5 class="empty-title">Belum Memiliki Rumah</h5>
                                <p class="empty-sub">Pilih kavling di bawah untuk memulai</p>
                            </div>
                        </div>

                        {{-- ===== KAVLING GRID ===== --}}
                        <div class="glass-card mt-kavling fade-in" style="animation-delay:0.35s">
                            <div class="section-header">
                                <div class="section-icon green">
                                    <i class="fas fa-map"></i>
                                </div>
                                <div>
                                    <h5 class="section-title">Pilih Kavling</h5>
                                    <p class="section-sub">Klik kavling <span class="legend-green">hijau</span> untuk memilih
                                    </p>
                                </div>
                                <div class="kavling-legend ms-auto">
                                    <span class="leg-item"><span class="leg-dot green"></span>Tersedia</span>
                                    <span class="leg-item"><span class="leg-dot gray"></span>Terisi</span>
                                </div>
                            </div>

                            <div class="kavling-grid">
                                @php
                                $clusterMap = [
                                    'A'=>'Gardenia','B'=>'Gardenia','C'=>'Gardenia',
                                    'D'=>'Gardenia','E'=>'Gardenia','F'=>'Gardenia','G'=>'Gardenia',
                                    'H'=>'Edelweis','I'=>'Edelweis',
                                    'J'=>'J','K'=>'K','L'=>'L',
                                ];
                                @endphp
                                @foreach($rumahList ?? [] as $index => $r)
                                    @php
                                        $clusterUser = isset($clusterMap[$r->blok]) ? $clusterMap[$r->blok] : $r->blok;
                                    @endphp
                                    <button type="button"
                                        class="kav-btn {{ $r->status == 'Kosong' ? 'kav-kosong' : 'kav-terisi' }} fade-in"
                                        style="animation-delay: {{ $index * 0.04 }}s"
                                        data-id="{{ $r->id }}"
                                        data-status="{{ $r->status }}"
                                        data-blok="{{ $r->blok }}"
                                        data-cluster="{{ $clusterUser }}"
                                        data-nomor="{{ $r->no_rumah }}"
                                        data-luas="{{ $r->luas_tanah }}"
                                        data-harga="{{ $r->harga }}"
                                        data-foto="{{ asset('foto_rumah/' . $r->foto) }}">
                                        <span class="kav-label">{{ $r->blok }}{{ $r->no_rumah }}</span>
                                        <span style="font-size:8px;opacity:.8;font-weight:500;">{{ $clusterUser }}</span>
                                        @if($r->status == 'Kosong')
                                            <span class="kav-dot"></span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ===== MODAL AMBIL KAVLING ===== --}}
        <div class="modal fade" id="modalAmbil" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-pro">

                    <div class="modal-pro-header">
                        <div class="modal-header-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h5 class="modal-pro-title">Konfirmasi Pilih Rumah</h5>
                            <p class="modal-pro-sub">Periksa detail sebelum mengajukan</p>
                        </div>
                        <button type="button" class="modal-close-btn" data-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-pro-body">
                        <div class="modal-rumah-img-wrap">
                            <img id="fotoRumah" src="" class="modal-rumah-img" alt="Foto Rumah">
                            <div class="modal-img-badge" id="blokBadge"></div>
                        </div>
                       <div class="modal-info-grid">
                            {{-- tambah ini --}}
                            <div class="modal-info-item">
                                <i class="fas fa-map"></i>
                                <div>
                                    <div class="minfo-lbl">Cluster</div>
                                    <div class="minfo-val" id="cluster">-</div>
                                </div>
                            </div>
                            <div class="modal-info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <div class="minfo-lbl">Blok</div>
                                    <div class="minfo-val" id="blok">-</div>
                                </div>
                            </div>
                            <div class="modal-info-item">
                                <i class="fas fa-hashtag"></i>
                                <div>
                                    <div class="minfo-lbl">No. Rumah</div>
                                    <div class="minfo-val" id="nomor">-</div>
                                </div>
                            </div>
                            <div class="modal-info-item">
                                <i class="fas fa-ruler-combined"></i>
                                <div>
                                    <div class="minfo-lbl">Luas Tanah</div>
                                    <div class="minfo-val"><span id="luas">-</span> m²</div>
                                </div>
                            </div>
                            <div class="modal-info-item">
                                <i class="fas fa-tag"></i>
                                <div>
                                    <div class="minfo-lbl">Harga</div>
                                    <div class="minfo-val minfo-price">Rp <span id="harga">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-pro-footer">
                        {{-- ✅ FORM ASLI TIDAK DIUBAH ROUTE-NYA --}}
                        <form id="formPilihRumah" action="" method="POST">
                            @csrf
                            <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn-modal-confirm">
                                <i class="fas fa-check-circle me-2"></i> Pilih Rumah Ini
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

@endsection

    @section('scripts')
        <script>
            // ── Kavling button click ──────────────────────────────────────
           document.querySelectorAll('.kav-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    // ripple tetap sama...
                    const ripple = document.createElement('span');
                    ripple.classList.add('kav-ripple');
                    const rect = this.getBoundingClientRect();
                    ripple.style.left = (e.clientX - rect.left) + 'px';
                    ripple.style.top  = (e.clientY - rect.top)  + 'px';
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);

                    if (this.dataset.status !== 'Kosong') {
                        showToast('Kavling ini sudah terisi!', 'warning');
                        return;
                    }

                    const rumahId = this.dataset.id;
                    document.getElementById('formPilihRumah').action = '/user/pilih-rumah/' + rumahId;

                    // tambah cluster
                    document.getElementById('cluster').innerText  = 'Cluster ' + this.dataset.cluster;
                    document.getElementById('blok').innerText     = this.dataset.blok;
                    document.getElementById('nomor').innerText    = this.dataset.nomor;
                    document.getElementById('luas').innerText     = this.dataset.luas;
                    document.getElementById('harga').innerText    = Number(this.dataset.harga).toLocaleString('id-ID');
                    document.getElementById('fotoRumah').src      = this.dataset.foto;
                    document.getElementById('blokBadge').innerText = 'Cluster ' + this.dataset.cluster + ' — Blok ' + this.dataset.blok;

                    $('#modalAmbil').modal('show');
                });
            });

            // ── Toggle tanggal keluar ─────────────────────────────────────
            function toggleTanggal() {
                const status = document.getElementById('status_huni').value;
                const box = document.getElementById('tanggal_keluar_box');
                if (box) {
                    box.style.display = (status === 'Kontrak') ? 'block' : 'none';
                }
            }

            // Jalankan saat halaman load (jaga-jaga ada old value)
            document.addEventListener('DOMContentLoaded', function () {
                toggleTanggal();

                // ✅ Auto-hide form jika ada session success (fallback kalau $penghuni belum reload)
                @if(session('success'))
                    showToast('{{ session('success') }}', 'success');
                @endif
            });

            // ── Toast ─────────────────────────────────────────────────────
            function showToast(message, type = 'success') {
                const icons = {
                    success: 'fa-check-circle',
                    warning: 'fa-exclamation-circle',
                    error: 'fa-times-circle'
                };
                const toast = document.createElement('div');
                toast.className = `gv-toast gv-toast-${type}`;
                toast.innerHTML = `<i class="fas ${icons[type]}"></i><span>${message}</span>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.classList.add('show'), 50);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 400);
                }, 3000);
            }
        </script>
    @endsection

    @push('styles')
        <style>
            /* =========================================== */
            /* 🌿 GREEN VIEW — HOME PAGE PREMIUM           */
            /* =========================================== */
            * {
                box-sizing: border-box;
            }

            .home-wrapper {
                padding: 28px 28px 80px;
                max-width: 1400px;
                margin: 0 auto;
                font-family: 'Nunito', sans-serif;
                overflow-x: hidden;
            }

            /* --- HERO --- */
            .hero-banner {
                position: relative;
                background: linear-gradient(135deg, #064e3b 0%, #065f46 30%, #059669 65%, #34d399 100%);
                border-radius: 22px;
                padding: 36px 40px;
                margin-bottom: 28px;
                overflow: hidden;
                box-shadow: 0 12px 40px rgba(5, 150, 105, 0.3), 0 2px 0 rgba(255, 255, 255, 0.1) inset;
            }

            .hero-bg-shapes {
                position: absolute;
                inset: 0;
                overflow: hidden;
                pointer-events: none;
            }

            .shape {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.06);
            }

            .shape-1 {
                width: 300px;
                height: 300px;
                top: -80px;
                right: -60px;
            }

            .shape-2 {
                width: 180px;
                height: 180px;
                bottom: -50px;
                right: 200px;
                background: rgba(255, 255, 255, 0.04);
            }

            .shape-3 {
                width: 120px;
                height: 120px;
                top: 10px;
                right: 350px;
                background: rgba(255, 255, 255, 0.05);
            }

            .hero-content {
                position: relative;
                display: flex;
                align-items: center;
                gap: 18px;
                margin-bottom: 28px;
            }

            .hero-icon-wrap {
                width: 56px;
                height: 56px;
                background: rgba(255, 255, 255, 0.18);
                border: 1.5px solid rgba(255, 255, 255, 0.3);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                color: #fff;
                flex-shrink: 0;
                backdrop-filter: blur(4px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .hero-title {
                font-size: 22px;
                font-weight: 800;
                color: #fff;
                margin: 0 0 4px;
                text-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
            }

            .hero-sub {
                font-size: 14px;
                color: rgba(255, 255, 255, 0.75);
                margin: 0;
            }

            /* ✅ PERBAIKAN: hero-stats agar tidak terpotong di mobile */
            .hero-stats {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(6px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 14px;
                padding: 14px 0;
                width: 100%;
            }

            .hero-stat {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 0 28px;
                flex: 1;
            }

            .stat-val {
                font-size: 28px;
                font-weight: 900;
                color: #fff;
                line-height: 1;
            }

            .stat-lbl {
                font-size: 11px;
                color: rgba(255, 255, 255, 0.7);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-top: 3px;
            }

            .hero-stat-div {
                width: 1px;
                height: 36px;
                background: rgba(255, 255, 255, 0.2);
                flex-shrink: 0;
            }

            /* --- LAYOUT --- */
            .main-grid {
                display: grid;
                grid-template-columns: 300px 1fr;
                gap: 22px;
                align-items: start;
            }

            @media (max-width: 1024px) {
                .main-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* ✅ PERBAIKAN: padding & kavling di mobile agar tidak terpotong */
            @media (max-width: 576px) {
                .home-wrapper {
                    padding: 16px 12px 80px;
                }

                .hero-banner {
                    padding: 24px 16px;
                }

                .hero-stat {
                    padding: 0 12px;
                }

                .stat-val {
                    font-size: 22px;
                }

                .stat-lbl {
                    font-size: 10px;
                }

                .kavling-grid {
                    grid-template-columns: repeat(4, 1fr) !important;
                    gap: 6px;
                }

                .kav-btn {
                    width: 100% !important;
                    min-width: 0 !important;
                    font-size: 10px;
                    padding: 10px 2px;
                    box-sizing: border-box;
                }

                .glass-card {
                    padding: 16px 12px;
                    overflow: hidden;
                }

                .kav-label {
                    font-size: 10px;
                    word-break: break-all;
                }
            }

            /* --- GLASS CARD --- */
            .glass-card {
                background: #fff;
                border-radius: 20px;
                border: 1px solid rgba(5, 150, 105, 0.08);
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
                overflow: hidden;
                transition: box-shadow 0.3s, transform 0.3s;
                padding: 24px;
            }

            .glass-card:hover {
                box-shadow: 0 12px 40px rgba(5, 150, 105, 0.12);
                transform: translateY(-3px);
            }

            .mt-kavling {
                margin-top: 22px;
            }

            /* --- PROFILE CARD --- */
            .profile-card {
                padding: 0;
            }

            .profile-cover {
                height: 80px;
                background: linear-gradient(135deg, #064e3b, #059669, #34d399);
            }

            .profile-body {
                padding: 0 24px 24px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-avatar-wrap {
                position: relative;
                margin-top: -40px;
                margin-bottom: 14px;
            }

            .profile-avatar {
                width: 78px;
                height: 78px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid #fff;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            }

            .profile-status-dot {
                position: absolute;
                bottom: 4px;
                right: 4px;
                width: 14px;
                height: 14px;
                background: #22c55e;
                border-radius: 50%;
                border: 2.5px solid #fff;
                box-shadow: 0 0 8px rgba(34, 197, 94, 0.5);
            }

            .profile-name {
                font-size: 17px;
                font-weight: 800;
                color: #111827;
                margin: 0 0 4px;
            }

            .profile-email {
                font-size: 12.5px;
                color: #6b7280;
                margin: 0 0 12px;
            }

            .profile-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                color: #065f46;
                font-size: 11.5px;
                font-weight: 700;
                padding: 5px 13px;
                border-radius: 50px;
                border: 1px solid rgba(5, 150, 105, 0.2);
                margin-bottom: 18px;
            }

            .profile-divider {
                width: 100%;
                height: 1px;
                background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
                margin: 4px 0 16px;
            }

            .profile-info-row {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }

            .profile-info-label {
                font-size: 12.5px;
                color: #6b7280;
                font-weight: 600;
            }

            /* Pills */
            .pil {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 11.5px;
                font-weight: 700;
                padding: 4px 11px;
                border-radius: 50px;
            }

            .pil-green {
                background: #dcfce7;
                color: #065f46;
                border: 1px solid #bbf7d0;
            }

            .pil-amber {
                background: #fef3c7;
                color: #92400e;
                border: 1px solid #fde68a;
            }

            .pil-blue {
                background: #dbeafe;
                color: #1e40af;
                border: 1px solid #bfdbfe;
            }

            .btn-profile-edit {
                margin-top: 16px;
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 9px 22px;
                border-radius: 12px;
                background: linear-gradient(135deg, #064e3b, #059669);
                color: #fff;
                font-size: 13px;
                font-weight: 700;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
                box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
            }

            .btn-profile-edit:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(5, 150, 105, 0.4);
                color: #fff;
            }

            /* --- SECTION HEADER --- */
            .section-header {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 22px;
            }

            .section-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                flex-shrink: 0;
            }

            .section-icon.green {
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                color: #065f46;
                box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
            }

            .section-title {
                font-size: 16px;
                font-weight: 800;
                color: #111827;
                margin: 0 0 2px;
            }

            .section-sub {
                font-size: 12.5px;
                color: #6b7280;
                margin: 0;
            }

            /* --- RUMAH SHOWCASE --- */
            .rumah-showcase {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                align-items: start;
            }

            @media (max-width: 768px) {
                .rumah-showcase {
                    grid-template-columns: 1fr;
                }
            }

            .rumah-img-frame {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                background: #f1f5f9;
                aspect-ratio: 4/3;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            }

            .rumah-photo {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform 0.4s ease;
            }

            .rumah-img-frame:hover .rumah-photo {
                transform: scale(1.04);
            }

            .rumah-img-overlay {
                position: absolute;
                bottom: 12px;
                left: 12px;
            }

            .rumah-blok-badge {
                background: rgba(6, 79, 62, 0.85);
                backdrop-filter: blur(6px);
                color: #fff;
                font-size: 12px;
                font-weight: 700;
                padding: 5px 12px;
                border-radius: 8px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .rumah-details {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .detail-item {
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 14px 16px;
                background: linear-gradient(135deg, #f8fafc, #f1f5f9);
                border-radius: 12px;
                border: 1px solid rgba(5, 150, 105, 0.07);
                transition: all 0.2s;
            }

            .detail-item:hover {
                background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                border-color: rgba(5, 150, 105, 0.15);
                transform: translateX(4px);
            }

            .detail-icon {
                width: 36px;
                height: 36px;
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                color: #059669;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                flex-shrink: 0;
            }

            .detail-lbl {
                font-size: 11px;
                color: #6b7280;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.4px;
            }

            .detail-val {
                font-size: 14px;
                font-weight: 700;
                color: #111827;
                margin-top: 2px;
            }

            /* --- EMPTY STATE --- */
            .empty-hero {
                text-align: center;
                padding: 20px 0 8px;
            }

            .empty-icon-wrap {
                width: 72px;
                height: 72px;
                background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                border-radius: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                color: #059669;
                margin: 0 auto 16px;
                box-shadow: 0 6px 20px rgba(5, 150, 105, 0.15);
                animation: floatIcon 3s ease-in-out infinite;
            }

            .empty-title {
                font-size: 17px;
                font-weight: 800;
                color: #374151;
                margin: 0 0 6px;
            }

            .empty-sub {
                font-size: 13.5px;
                color: #9ca3af;
                margin: 0;
            }

            @keyframes floatIcon {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-8px);
                }
            }

            /* --- KAVLING LEGEND --- */
            .kavling-legend {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 12px;
                color: #6b7280;
                font-weight: 600;
            }

            .leg-item {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .leg-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
            }

            .leg-dot.green {
                background: #22c55e;
                box-shadow: 0 0 6px rgba(34, 197, 94, 0.5);
            }

            .leg-dot.gray {
                background: #d1d5db;
            }

            .legend-green {
                color: #059669;
                font-weight: 700;
            }

            /* --- KAVLING GRID --- */
            .kavling-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(72px, 1fr));
                gap: 8px;
                box-sizing: border-box;
                width: 100%;
                overflow: hidden;
            }

            .kav-btn {
                position: relative;
                overflow: hidden;
                padding: 12px 6px;
                border-radius: 12px;
                border: none;
                font-size: 12px;
                font-weight: 700;
                font-family: 'Nunito', sans-serif;
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 4px;
            }

            .kav-kosong {
                background: linear-gradient(135deg, #22c55e, #16a34a);
                color: #fff;
                box-shadow: 0 3px 10px rgba(34, 197, 94, 0.3);
            }

            .kav-kosong:hover {
                transform: translateY(-3px) scale(1.06);
                box-shadow: 0 8px 20px rgba(34, 197, 94, 0.45);
            }

            .kav-terisi {
                background: #f1f5f9;
                color: #94a3b8;
                cursor: not-allowed;
                border: 1px solid #e2e8f0;
            }

            .kav-dot {
                width: 6px;
                height: 6px;
                background: rgba(255, 255, 255, 0.7);
                border-radius: 50%;
            }

            .kav-ripple {
                position: absolute;
                width: 120px;
                height: 120px;
                background: rgba(255, 255, 255, 0.35);
                border-radius: 50%;
                transform: translate(-50%, -50%) scale(0);
                animation: kavRipple 0.6s ease-out forwards;
                pointer-events: none;
            }

            @keyframes kavRipple {
                to {
                    transform: translate(-50%, -50%) scale(2.5);
                    opacity: 0;
                }
            }

            /* --- MODAL PRO --- */
            .modal-pro {
                border: none;
                border-radius: 22px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            }

            .modal-pro-header {
                background: linear-gradient(135deg, #064e3b, #059669);
                padding: 22px 24px;
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .modal-header-icon {
                width: 44px;
                height: 44px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #fff;
                flex-shrink: 0;
            }

            .modal-pro-title {
                font-size: 16px;
                font-weight: 800;
                color: #fff;
                margin: 0 0 2px;
            }

            .modal-pro-sub {
                font-size: 12px;
                color: rgba(255, 255, 255, 0.7);
                margin: 0;
            }

            .modal-close-btn {
                margin-left: auto;
                width: 32px;
                height: 32px;
                background: rgba(255, 255, 255, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 8px;
                color: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.2s;
                font-size: 14px;
                flex-shrink: 0;
            }

            .modal-close-btn:hover {
                background: rgba(255, 255, 255, 0.25);
                color: #fff;
            }

            .modal-pro-body {
                padding: 22px 24px;
                background: #fff;
            }

            .modal-rumah-img-wrap {
                position: relative;
                border-radius: 14px;
                overflow: hidden;
                margin-bottom: 18px;
                height: 180px;
                background: #f1f5f9;
            }

            .modal-rumah-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            .modal-img-badge {
                position: absolute;
                bottom: 10px;
                left: 10px;
                background: rgba(6, 79, 62, 0.85);
                backdrop-filter: blur(6px);
                color: #fff;
                font-size: 12px;
                font-weight: 700;
                padding: 5px 12px;
                border-radius: 8px;
            }

            .modal-info-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .modal-info-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 14px;
                background: #f8fafc;
                border-radius: 12px;
                border: 1px solid #f1f5f9;
            }

            .modal-info-item i {
                color: #059669;
                font-size: 16px;
                width: 20px;
                text-align: center;
                flex-shrink: 0;
            }

            .minfo-lbl {
                font-size: 11px;
                color: #6b7280;
                font-weight: 600;
                text-transform: uppercase;
            }

            .minfo-val {
                font-size: 14px;
                font-weight: 700;
                color: #111827;
                margin-top: 2px;
            }

            .minfo-price {
                color: #059669 !important;
            }

            .modal-pro-footer {
                padding: 16px 24px 22px;
                background: #fafafa;
                border-top: 1px solid #f1f5f9;
            }

            .modal-pro-footer form {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }

            .btn-modal-cancel {
                padding: 10px 20px;
                border-radius: 11px;
                background: #f1f5f9;
                border: 1px solid #e2e8f0;
                color: #6b7280;
                font-size: 13.5px;
                font-weight: 700;
                font-family: 'Nunito', sans-serif;
                cursor: pointer;
                transition: 0.2s;
            }

            .btn-modal-cancel:hover {
                background: #e2e8f0;
                color: #374151;
            }

            .btn-modal-confirm {
                padding: 10px 22px;
                border-radius: 11px;
                background: linear-gradient(135deg, #064e3b, #059669);
                color: #fff;
                font-size: 13.5px;
                font-weight: 700;
                font-family: 'Nunito', sans-serif;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
                display: inline-flex;
                align-items: center;
            }

            .btn-modal-confirm:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(5, 150, 105, 0.4);
            }

            /* --- TOAST --- */
            .gv-toast {
                position: fixed;
                top: 24px;
                right: 24px;
                background: #fff;
                border-radius: 14px;
                padding: 14px 18px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 13.5px;
                font-weight: 600;
                font-family: 'Nunito', sans-serif;
                color: #1f2937;
                box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
                border: 1px solid #f1f5f9;
                opacity: 0;
                transform: translateX(20px);
                transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
                z-index: 99999;
            }

            .gv-toast.show {
                opacity: 1;
                transform: translateX(0);
            }

            .gv-toast-success i {
                color: #22c55e;
                font-size: 18px;
            }

            .gv-toast-warning i {
                color: #f59e0b;
                font-size: 18px;
            }

            .gv-toast-error i {
                color: #ef4444;
                font-size: 18px;
            }

            /* --- FADE IN ANIMATION --- */
            .fade-in {
                opacity: 0;
                animation: fadeUp 0.55s ease forwards;
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

            .status-badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .status-badge.success {
                background: #d1fae5;
                color: #065f46;
            }

            .status-badge.warning {
                background: #fef3c7;
                color: #92400e;
            }

            .status-badge.danger {
                background: #fee2e2;
                color: #991b1b;
            }

            /* ── Form Penghuni ─────────────────────────── */
            .form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 12px;
                margin-bottom: 16px;
            }

            .gv-input {
                width: 100%;
                padding: 10px 14px;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                font-size: 13.5px;
                font-family: 'Nunito', sans-serif;
                color: #374151;
                background: #f8fafc;
                transition: border-color 0.2s, box-shadow 0.2s;
                outline: none;
            }

            .gv-input:focus {
                border-color: #059669;
                box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12);
                background: #fff;
            }

            .btn-simpan-gv {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 22px;
                background: linear-gradient(135deg, #064e3b, #059669);
                color: #fff;
                font-size: 13.5px;
                font-weight: 700;
                font-family: 'Nunito', sans-serif;
                border: none;
                border-radius: 11px;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
            }

            .btn-simpan-gv:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(5, 150, 105, 0.4);
            }

            .alert-success-gv {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 12px 16px;
                background: #d1fae5;
                border: 1px solid #6ee7b7;
                border-radius: 10px;
                color: #065f46;
                font-size: 13.5px;
                font-weight: 600;
                margin-bottom: 16px;
            }
        </style>
    @endpush

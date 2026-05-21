@extends('layouts.app')

    @section('content')

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <div class="gv-wrap">

         {{-- ✅ NOTIFIKASI SUCCESS --}}
        @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-left:4px solid #064e3b;
                    color:#065f46; border-radius:10px; padding:12px 16px; font-size:13px;
                    font-weight:600; display:flex; align-items:center; gap:8px; margin:16px 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        {{-- ⚠️ KONTRAK EXPIRED --}}
        @if($isExpired)
        <div class="gv-alert-banner">
            <div class="gv-alert-inner">
                <div class="gv-alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <strong>Kontrak Berakhir</strong>
                    <span>Silakan hubungi admin untuk perpanjangan kontrak Anda.</span>
                </div>
                <button class="gv-alert-close" onclick="this.closest('.gv-alert-banner').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        {{-- ===================== --}}
        {{-- HERO HEADER --}}
        {{-- ===================== --}}
        <header class="gv-hero">
            <div class="gv-hero-bg">
                <div class="gv-orb gv-orb-1"></div>
                <div class="gv-orb gv-orb-2"></div>
                <div class="gv-orb gv-orb-3"></div>
                <div class="gv-grid-lines"></div>
            </div>
            <div class="gv-hero-content">
                <div class="gv-hero-pill">
                    <span class="gv-dot-pulse"></span>
                    Sistem Manajemen Hunian
                </div>
               <h1 class="gv-hero-title">Selamat Datang<br><em>{{ auth()->user()->name }}</em></h1>
                <p class="gv-hero-sub">Kelola iuran, pengaduan, dan informasi hunian Anda dalam satu tempat</p>
                <div class="gv-hero-stats">
                    <div class="gv-stat-chip">
                        <i class="fas fa-home"></i>
                        <span>Green View</span>
                    </div>
                    <div class="gv-stat-chip">
                        <i class="fas fa-calendar-check"></i>
                        <span>{{ date('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </header>



        {{-- ===================== --}}
        {{-- INFORMASI & PENGUMUMAN --}}
        {{-- ===================== --}}
        <section class="gv-section">
            <div class="gv-section-label">
                <span class="gv-label-dot"></span>
                Informasi & Pengumuman
            </div>
            <div class="gv-section-title">
                <h2>Berita Terkini <em>Hunian</em></h2>
            </div>

            {{-- SLIDER --}}
            @php $slider = $informasi->where('is_penting', 1)->values(); @endphp
            @if($slider->count() > 0)
            <div class="gv-slider mb-5" id="gvCarousel">
                <div class="gv-slides">
                    @foreach($slider as $key => $info)
                    <div class="gv-slide {{ $key == 0 ? 'active' : '' }}" data-index="{{ $key }}">
                        <div class="gv-slide-img">
                            <img src="{{ asset('informasi/' . $info->gambar) }}" alt="{{ $info->judul }}">
                            <div class="gv-slide-shade"></div>
                        </div>
                        <div class="gv-slide-card">
                            <span class="gv-slide-tag">
                                <i class="fas fa-fire-alt"></i> Penting
                            </span>
                            <h3>{{ $info->judul }}</h3>
                            <p>{{ Str::limit($info->isi ?? 'Informasi terbaru untuk penghuni Green View.', 130) }}</p>
                            <a href="{{ route('user.informasi.detail', $info->id) }}" class="gv-btn-slide">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="gv-slide-nav">
                    <button class="gv-slide-prev" onclick="gvSlide(-1)"><i class="fas fa-chevron-left"></i></button>
                    <div class="gv-slide-dots">
                        @foreach($slider as $key => $info)
                        <button class="gv-dot {{ $key == 0 ? 'active' : '' }}" onclick="gvGoTo({{ $key }})"></button>
                        @endforeach
                    </div>
                    <button class="gv-slide-next" onclick="gvSlide(1)"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            @endif

            {{-- GRID INFORMASI --}}
            <div class="gv-info-grid">
                @foreach($informasi as $info)
                <a href="{{ route('user.informasi.detail', $info->id) }}" class="gv-info-card">
                    <div class="gv-info-thumb">
                        <img src="{{ asset('informasi/' . $info->gambar) }}" alt="{{ $info->judul }}">
                        @if($info->is_penting)
                        <span class="gv-info-badge">
                            <i class="fas fa-bolt"></i> Penting
                        </span>
                        @endif
                    </div>
                    <div class="gv-info-body">
                        <div class="gv-info-meta">
                            <span><i class="fas fa-calendar"></i> {{ $info->tanggal }}</span>
                            <span><i class="fas fa-eye"></i> {{ $info->views }}x</span>
                        </div>
                        <h4>{{ $info->judul }}</h4>
                        <p>{{ Str::limit($info->isi, 90) }}</p>
                        <div class="gv-info-cta">
                            Selengkapnya <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        {{-- ===================== --}}
        {{-- IURAN + PENGADUAN --}}
        {{-- ===================== --}}
        <div class="gv-dual-grid">

            {{-- IURAN --}}
            <section class="gv-section">
                <div class="gv-section-label">
                    <span class="gv-label-dot" style="background:#059669"></span>
                    Keuangan
                </div>
                <div class="gv-section-title">
                    <h2>Data Iuran <em>Saya</em></h2>
                </div>

                @forelse($iuran as $i)
                <div class="gv-iuran-card">
                    <div class="gv-iuran-top">
                        <div class="gv-iuran-period">
                            <div class="gv-period-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <span class="gv-period-label">Periode</span>
                                <strong>{{ $i->bulan }} {{ $i->tahun }}</strong>
                            </div>
                        </div>
                        <span class="gv-iuran-badge {{ $i->status == 'lunas' ? 'lunas' : 'pending' }}">
                            <i class="fas {{ $i->status == 'lunas' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                            {{ ucfirst($i->status) }}
                        </span>
                    </div>

                    <div class="gv-iuran-amount">
                        <span class="gv-amount-label">Jumlah Tagihan</span>
                        <div class="gv-amount-val">Rp {{ number_format($i->jumlah, 0, ',', '.') }}</div>
                    </div>

                    <div class="gv-progress-track">
                        <div class="gv-progress-info">
                            <span>Progress Pembayaran</span>
                            <span>{{ $i->status == 'lunas' ? '100%' : '0%' }}</span>
                        </div>
                        <div class="gv-progress-bar">
                            <div class="gv-progress-fill {{ $i->status == 'lunas' ? 'lunas' : 'pending' }}"
                                data-width="{{ $i->status == 'lunas' ? '100' : '0' }}" style="width:0%"></div>
                        </div>
                    </div>

                    @if($i->status == 'lunas')
                    <div class="gv-iuran-footer">
                        <form action="{{ route('user.iuran.delete', $i->id) }}" method="POST" class="delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="gv-btn-delete">
                                <i class="fas fa-trash-alt"></i> Hapus Data
                            </button>
                        </form>
                        <span class="gv-lunas-stamp">
                            <i class="fas fa-shield-check"></i> Lunas
                        </span>
                    </div>
                    @endif
                </div>
                @empty
                <div class="gv-empty">
                    <div class="gv-empty-icon" style="color:#059669">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h5>Belum Ada Data Iuran</h5>
                    <p>Data iuran akan muncul setelah ditambahkan oleh admin</p>
                </div>
                @endforelse
            </section>

            {{-- PENGADUAN --}}
            <section class="gv-section">
                <div class="gv-section-label">
                    <span class="gv-label-dot" style="background:#d97706"></span>
                    Layanan
                </div>
                <div class="gv-section-title">
                    <h2>Status <em>Pengaduan</em></h2>
                </div>

                @forelse($pengaduan as $p)
                <div class="gv-pengaduan-card">
                    <div class="gv-pengaduan-header">
                        <div class="gv-ticket-id">
                            <i class="fas fa-ticket-alt"></i>
                            #P-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}
                        </div>
                        <span class="gv-pengaduan-status
                            {{ $p->status == 'selesai' ? 'selesai' : ($p->status == 'diproses' ? 'diproses' : 'diajukan') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>

                    <p class="gv-pengaduan-desc">{{ Str::limit($p->deskripsi, 110) }}</p>

                    {{-- STEPPER --}}
                    <div class="gv-stepper">
                        <div class="gv-step-line">
                            <div class="gv-step-progress"
                                style="width: {{ $p->status == 'selesai' ? '100%' : ($p->status == 'diproses' ? '50%' : '0%') }}">
                            </div>
                        </div>

                        <div class="gv-step {{ in_array($p->status, ['diajukan','diproses','selesai']) ? 'done' : '' }}">
                            <div class="gv-step-circle">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span>Diajukan</span>
                        </div>
                        <div class="gv-step {{ in_array($p->status, ['diproses','selesai']) ? 'done' : '' }}">
                            <div class="gv-step-circle">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <span>Diproses</span>
                        </div>
                        <div class="gv-step {{ $p->status == 'selesai' ? 'done' : '' }}">
                            <div class="gv-step-circle">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>Selesai</span>
                        </div>
                    </div>

                    <div class="gv-pengaduan-footer">
                        <small class="gv-pengaduan-time">
                            <i class="fas fa-clock"></i>
                            {{ \Carbon\Carbon::parse($p->tanggal_pengaduan)->translatedFormat('d M Y H:i') }}
                        </small>
                        @if($p->status == 'selesai')
                        <form action="{{ route('user.layanan.delete', $p->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="gv-btn-delete-sm"
                                    onclick="return confirm('Hapus pengaduan ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="gv-empty">
                    <div class="gv-empty-icon" style="color:#d97706">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5>Belum Ada Pengaduan</h5>
                    <p>Pengaduan yang Anda kirim akan muncul di sini</p>
                </div>
                @endforelse
            </section>

        </div>{{-- end dual-grid --}}
    </div>{{-- end gv-wrap --}}



    <style>
    /* =============================================
       VARIABLES & RESET
    ============================================= */
.gv-container {
    padding: 0 5%;
}
    :root {
        --gv-bg:          #f5f4f0;
        --gv-surface:     #ffffff;
        --gv-surface-2:   #f9f8f5;
        --gv-surface-3:   #f0ede8;
        --gv-border:      rgba(0,0,0,0.08);
        --gv-border-hover:rgba(0,0,0,0.16);
        --gv-shadow:      0 2px 16px rgba(0,0,0,0.07);
        --gv-shadow-hover:0 12px 40px rgba(0,0,0,0.13);
        --gv-text:        #1a1a1a;
        --gv-text-muted:  #6b6b6b;
        --gv-text-faint:  #aaaaaa;
        --gv-green:       #059669;
        --gv-green-2:     #10b981;
        --gv-green-light: #d1fae5;
        --gv-green-glow:  rgba(5,150,105,0.15);
        --gv-amber:       #d97706;
        --gv-amber-light: #fef3c7;
        --gv-amber-glow:  rgba(217,119,6,0.15);
        --gv-blue:        #2563eb;
        --gv-blue-light:  #dbeafe;
        --gv-red:         #dc2626;
        --gv-red-light:   #fee2e2;
        --gv-radius:      18px;
        --gv-radius-sm:   10px;
        --gv-font:        'Nunito', sans-serif;
        --gv-font-display:'Nunito', sans-serif;
        --gv-transition:  0.3s cubic-bezier(0.4,0,0.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .gv-wrap {
        font-family: var(--gv-font);
        background: var(--gv-bg);
        min-height: 100vh;
        color: var(--gv-text);
        padding: 0 0 6rem;
    }

    /* =============================================
       ALERT BANNER
    ============================================= */
    .gv-alert-banner {
        background: var(--gv-red-light);
        border-bottom: 1px solid rgba(220,38,38,0.2);
        padding: 1rem 2rem;
    }
    .gv-alert-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .gv-alert-icon {
        width: 40px; height: 40px;
        background: #fecaca;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: var(--gv-red);
        flex-shrink: 0;
    }
    .gv-alert-inner strong { display: block; color: var(--gv-red); font-weight: 700; }
    .gv-alert-inner span   { color: #7f1d1d; font-size: 0.875rem; }
    .gv-alert-close {
        margin-left: auto;
        background: none; border: none;
        color: var(--gv-text-muted); cursor: pointer;
        font-size: 1rem; padding: 0.5rem;
        border-radius: 8px; transition: var(--gv-transition);
    }
    .gv-alert-close:hover { background: rgba(0,0,0,0.06); }

    /* =============================================
       HERO
    ============================================= */
    .gv-hero {
        position: relative;
        overflow: hidden;
        padding: 6rem 5% 5rem;
        text-align: center;
        background: #ffffff;
        border-bottom: 1px solid var(--gv-border);
    }
    .gv-hero-bg {
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 80% 60% at 50% -20%, rgba(5,150,105,0.08), transparent 70%),
                    radial-gradient(ellipse 50% 40% at 85% 90%, rgba(37,99,235,0.05), transparent 70%);
    }
    .gv-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.55;
        animation: gvFloat 12s ease-in-out infinite;
    }
    .gv-orb-1 { width: 420px; height: 420px; background: rgba(5,150,105,0.1); top: -160px; left: -100px; }
    .gv-orb-2 { width: 300px; height: 300px; background: rgba(37,99,235,0.07); bottom: -80px; right: -60px; animation-delay: -4s; }
    .gv-orb-3 { width: 220px; height: 220px; background: rgba(217,119,6,0.07); top: 40%; left: 65%; animation-delay: -8s; }
    .gv-grid-lines {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(0,0,0,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,0,0,0.025) 1px, transparent 1px);
        background-size: 56px 56px;
    }
    @keyframes gvFloat {
        0%,100% { transform: translate(0,0) scale(1); }
        33%      { transform: translate(28px,-18px) scale(1.04); }
        66%      { transform: translate(-18px,18px) scale(0.96); }
    }
    .gv-hero-content {
        position: relative; z-index: 2;
        max-width: 680px; margin: 0 auto;
    }
    .gv-hero-pill {
        display: inline-flex; align-items: center; gap: 0.6rem;
        background: var(--gv-green-light);
        border: 1px solid rgba(5,150,105,0.25);
        color: var(--gv-green);
        font-size: 0.75rem; font-weight: 600;
        letter-spacing: 0.07em; text-transform: uppercase;
        padding: 0.5rem 1.25rem; border-radius: 50px;
        margin-bottom: 2rem;
    }
    .gv-dot-pulse {
        width: 8px; height: 8px;
        background: var(--gv-green); border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(5,150,105,0.5); }
        50%      { box-shadow: 0 0 0 8px rgba(5,150,105,0); }
    }
    .gv-hero-title {
        font-family: var(--gv-font);
        font-size: clamp(2.6rem, 6vw, 4.2rem);
        font-weight: 800;
        line-height: 1.08;
        color: var(--gv-text);
        margin-bottom: 1.25rem;
        letter-spacing: -0.01em;
    }
    .gv-hero-title em {
        font-style: normal;
        color: var(--gv-green);
    }
    .gv-hero-sub {
        font-size: 1.05rem;
        color: var(--gv-text-muted);
        line-height: 1.75;
        margin-bottom: 2.5rem;
        font-weight: 400;
    }
    .gv-hero-stats {
        display: flex; justify-content: center;
        gap: 1rem; flex-wrap: wrap;
    }
    .gv-stat-chip {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: var(--gv-surface-2);
        border: 1px solid var(--gv-border);
        color: var(--gv-text-muted);
        padding: 0.6rem 1.25rem; border-radius: 50px;
        font-size: 0.875rem; font-weight: 500;
        box-shadow: var(--gv-shadow);
    }
    .gv-stat-chip i { color: var(--gv-green); }

    /* =============================================
       SECTION LAYOUT
    ============================================= */
   .gv-section {
    width: 100%;
    padding: 4rem 5%;
}
    .gv-dual-grid {
    width: 100%;
    padding: 4rem 5%;

        display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;
    }
    @media(max-width:900px) { .gv-dual-grid { grid-template-columns: 1fr; } }

    .gv-section-label {
        display: inline-flex; align-items: center; gap: 0.6rem;
        font-size: 0.73rem; font-weight: 700;
        letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--gv-text-faint); margin-bottom: 0.6rem;
        margin-top: 0.5rem;
    margin-bottom: 2.5rem;
    }
    .gv-label-dot {
        width: 7px; height: 7px;
        background: var(--gv-blue); border-radius: 50%;
    }
   .gv-section-title {
    margin-top: 1.5rem;      /* 🔥 jarak dari atas */
    margin-bottom: 3rem;     /* 🔥 lebih lega ke bawah */
}

.gv-section-title h2 {
    font-family: var(--gv-font);
    font-size: clamp(2rem, 3.5vw, 2.8rem); /* 🔥 sedikit lebih besar */
    font-weight: 800;
    color: var(--gv-text);
    line-height: 1.2;
    letter-spacing: -0.02em;

    margin: 0; /* biar bersih */
}
.gv-container {
    padding: 0 5%;
}

.gv-section-label {
    padding-left: 5%; /* 🔥 kasih jarak dari kiri */
}
.gv-section-title h2 em {
    font-style: normal;
    color: var(--gv-blue);

    position: relative;
}
.gv-section-title {
    padding-left: 5%;
}
/* 🔥 efek underline modern */
.gv-section-title h2 em::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 100%;
    height: 6px;
    background: rgba(37, 99, 235, 0.15);
    border-radius: 4px;
}
    .gv-wrap {
    width: 100%;
    overflow-x: hidden;
}

.gv-hero {
    width: 100%;
    padding-left: 5%;
    padding-right: 5%;
}

.gv-info-grid {
    padding: 0 5%;
}

.gv-section {
    width: 100%;
    padding: 4rem 0;
}
/* dual grid */
.gv-dual-grid {
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
     margin-top: 2rem;
    padding: 0 5%; /* 🔥 jarak kiri kanan */
}
    /* =============================================
       SLIDER
    ============================================= */
    .gv-slider {
        position: relative;
        border-radius: var(--gv-radius);
        overflow: hidden;
        border: 1px solid var(--gv-border);
        height: 440px;
        box-shadow: var(--gv-shadow-hover);
        margin: 0 20px; /* 🔥 ini yang bikin ada jarak */
    }
    .gv-slides { height: 100%; }
    .gv-slide {
        position: absolute; inset: 0;
        opacity: 0; pointer-events: none;
        transition: opacity 0.7s ease;
    }
    .gv-slide.active { opacity: 1; pointer-events: auto; }

    .gv-slide-img { position: absolute; inset: 0; }
    .gv-slide-img img { width: 100%; height: 100%; object-fit: cover; }
    .gv-slide-shade {
        position: absolute; inset: 0;
        background: linear-gradient(to right, rgba(255,255,255,0.97) 38%, rgba(255,255,255,0.2) 100%);
    }

    .gv-slide-card {
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: min(540px, 55%);
        display: flex; flex-direction: column; justify-content: center;
        padding: 3.5rem; z-index: 2;
    }
    .gv-slide-tag {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: var(--gv-red-light);
        border: 1px solid rgba(220,38,38,0.2);
        color: var(--gv-red);
        font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.08em; text-transform: uppercase;
        padding: 0.4rem 0.9rem; border-radius: 50px;
        margin-bottom: 1.25rem; width: fit-content;
    }
    .gv-slide-card h3 {
        font-family: var(--gv-font);
        font-size: 2rem; font-weight: 800;
        color: var(--gv-text);
        line-height: 1.2; margin-bottom: 1rem;
    }
    .gv-slide-card p {
        color: var(--gv-text-muted);
        font-size: 0.95rem; line-height: 1.75;
        margin-bottom: 2rem; font-weight: 400;
    }
    .gv-btn-slide {
        display: inline-flex; align-items: center; gap: 0.6rem;
        background: var(--gv-green);
        color: #fff; font-weight: 600; font-size: 0.875rem;
        padding: 0.85rem 1.75rem; border-radius: 50px;
        text-decoration: none; width: fit-content;
        transition: var(--gv-transition);
        box-shadow: 0 6px 24px var(--gv-green-glow);
    }
    .gv-btn-slide:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 10px 32px rgba(5,150,105,0.25);
        color: #fff; text-decoration: none;
    }

    .gv-slide-nav {
        position: absolute; bottom: 1.5rem; right: 1.5rem;
        display: flex; align-items: center; gap: 0.75rem; z-index: 5;
    }
    .gv-slide-prev, .gv-slide-next {
        width: 38px; height: 38px;
        background: var(--gv-surface);
        border: 1px solid var(--gv-border);
        border-radius: 50%; color: var(--gv-text);
        cursor: pointer; display: flex;
        align-items: center; justify-content: center;
        transition: var(--gv-transition); font-size: 0.8rem;
        box-shadow: var(--gv-shadow);
    }
    .gv-slide-prev:hover, .gv-slide-next:hover { background: var(--gv-surface-3); }
    .gv-slide-dots { display: flex; gap: 0.5rem; align-items: center; }
    .gv-dot {
        width: 8px; height: 8px;
        background: rgba(0,0,0,0.2);
        border: none; border-radius: 50%;
        cursor: pointer; transition: var(--gv-transition); padding: 0;
    }
    .gv-dot.active { background: var(--gv-green); width: 24px; border-radius: 4px; }

    /* =============================================
       INFO GRID
    ============================================= */
    .gv-info-grid {
        display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem;
    }
    @media(max-width:1000px) { .gv-info-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:900px) {
    .gv-dual-grid {
        grid-template-columns: 1fr;
    }
}

    .gv-info-card {
        background: var(--gv-surface);
        border: 1px solid var(--gv-border);
        border-radius: var(--gv-radius);
        overflow: hidden; text-decoration: none;
        display: flex; flex-direction: column;
        transition: var(--gv-transition);
        box-shadow: var(--gv-shadow);
    }
    .gv-info-card:hover {
        transform: translateY(-6px);
        border-color: var(--gv-border-hover);
        box-shadow: var(--gv-shadow-hover);
        text-decoration: none;
    }
    .gv-info-thumb {
        height: 180px; overflow: hidden;
        position: relative; background: var(--gv-surface-2);
    }
    .gv-info-thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s ease;
    }
    .gv-info-card:hover .gv-info-thumb img { transform: scale(1.06); }
    .gv-info-badge {
        position: absolute; top: 12px; left: 12px;
        background: var(--gv-red);
        color: #fff; font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.05em; padding: 0.3rem 0.75rem;
        border-radius: 50px;
        display: flex; align-items: center; gap: 0.3rem;
    }
    .gv-info-body {
        padding: 1.5rem; display: flex; flex-direction: column; flex: 1;
    }
    .gv-info-meta {
        display: flex; gap: 1rem;
        font-size: 0.74rem; color: var(--gv-text-faint);
        margin-bottom: 0.75rem;
    }
    .gv-info-meta i { color: var(--gv-text-faint); margin-right: 0.25rem; }
    .gv-info-body h4 {
        font-family: var(--gv-font);
        font-weight: 700; font-size: 1.05rem;
        color: var(--gv-text); line-height: 1.4; margin-bottom: 0.6rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .gv-info-body p {
        font-size: 0.875rem; color: var(--gv-text-muted);
        line-height: 1.7; flex: 1; font-weight: 400;
        display: -webkit-box; -webkit-line-clamp: 3;
        -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 1rem;
    }
    .gv-info-cta {
        display: flex; align-items: center; gap: 0.4rem;
        color: var(--gv-green); font-size: 0.85rem; font-weight: 600;
        margin-top: auto; transition: var(--gv-transition);
    }
    .gv-info-card:hover .gv-info-cta { gap: 0.7rem; }

    /* =============================================
       IURAN CARDS
    ============================================= */
    .gv-iuran-card {
        background: var(--gv-surface);
        border: 1px solid var(--gv-border);
        border-radius: var(--gv-radius);
        padding: 2.5rem; margin-bottom: 1.75rem;
        transition: var(--gv-transition);
        position: relative; overflow: hidden;
        box-shadow: var(--gv-shadow);
        width: 100%;
    }
    .gv-iuran-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--gv-green), var(--gv-green-2));
    }
    .gv-iuran-card:hover {
        transform: translateY(-4px);
        border-color: rgba(5,150,105,0.2);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1), 0 0 0 1px rgba(5,150,105,0.08);
    }

    .gv-iuran-top {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 1.75rem;
    }
    .gv-iuran-period { display: flex; align-items: center; gap: 1rem; }
    .gv-period-icon {
        width: 44px; height: 44px;
        background: var(--gv-green-light);
        border: 1px solid rgba(5,150,105,0.2);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: var(--gv-green); font-size: 1rem;
    }
    .gv-period-label {
        display: block; font-size: 0.7rem;
        color: var(--gv-text-faint);
        text-transform: uppercase; letter-spacing: 0.08em;
        font-weight: 600; margin-bottom: 0.15rem;
    }
    .gv-iuran-period strong { font-size: 1rem; font-weight: 700; color: var(--gv-text); }

    .gv-iuran-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.78rem; font-weight: 700;
        padding: 0.45rem 1rem; border-radius: 50px;
    }
    .gv-iuran-badge.lunas {
        background: var(--gv-green-light);
        border: 1px solid rgba(5,150,105,0.25);
        color: var(--gv-green);
    }
    .gv-iuran-badge.pending {
        background: var(--gv-amber-light);
        border: 1px solid rgba(217,119,6,0.25);
        color: var(--gv-amber);
    }

    .gv-iuran-amount { margin-bottom: 1.75rem; }
    .gv-amount-label {
        display: block; font-size: 0.7rem;
        color: var(--gv-text-faint); text-transform: uppercase;
        letter-spacing: 0.08em; font-weight: 600; margin-bottom: 0.4rem;
    }
    .gv-amount-val {
        font-family: var(--gv-font);
        font-size: 2.4rem; font-weight: 800;
        color: var(--gv-text);
    }

    .gv-progress-track { margin-bottom: 0; }
    .gv-progress-info {
        display: flex; justify-content: space-between;
        font-size: 0.78rem; color: var(--gv-text-faint); margin-bottom: 0.6rem;
    }
    .gv-progress-bar {
        height: 7px; background: var(--gv-surface-3);
        border-radius: 50px; overflow: hidden;
    }
    .gv-progress-fill {
        height: 100%; border-radius: 50px;
        transition: width 1.5s cubic-bezier(0.4,0,0.2,1);
        position: relative; overflow: hidden;
    }
    .gv-progress-fill::after {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: shimmer 2.5s infinite;
    }
    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(200%); } }
    .gv-progress-fill.lunas {
        background: linear-gradient(90deg, var(--gv-green), var(--gv-green-2));
        box-shadow: 0 0 10px var(--gv-green-glow);
    }
    .gv-progress-fill.pending {
        background: linear-gradient(90deg, var(--gv-amber), #fbbf24);
        box-shadow: 0 0 10px var(--gv-amber-glow);
    }

    .gv-iuran-footer {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 1.5rem; padding-top: 1.5rem;
        border-top: 1px solid var(--gv-border);
    }
    .gv-btn-delete {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: var(--gv-red-light);
        border: 1px solid rgba(220,38,38,0.2);
        color: var(--gv-red); font-size: 0.8rem; font-weight: 600;
        padding: 0.5rem 1rem; border-radius: 8px;
        cursor: pointer; transition: var(--gv-transition);
    }
    .gv-btn-delete:hover { background: #fecaca; border-color: rgba(220,38,38,0.35); }
    .gv-lunas-stamp {
        display: inline-flex; align-items: center; gap: 0.4rem;
        color: var(--gv-green); font-size: 0.8rem; font-weight: 700;
    }

    /* =============================================
       PENGADUAN CARDS
    ============================================= */
    .gv-pengaduan-card {
        background: var(--gv-surface);
        border: 1px solid var(--gv-border);
        border-radius: var(--gv-radius);
        padding: 2.5rem; margin-bottom: 1.75rem;
        transition: var(--gv-transition);
        position: relative; overflow: hidden;
        box-shadow: var(--gv-shadow);
        width: 100%;
    }
    .gv-pengaduan-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--gv-amber), #fbbf24);
    }
    .gv-pengaduan-card:hover {
        transform: translateY(-4px);
        border-color: rgba(217,119,6,0.2);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }

    .gv-pengaduan-header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 1rem;
    }
    .gv-ticket-id {
        display: flex; align-items: center; gap: 0.5rem;
        font-family: var(--gv-font);
        font-weight: 800; font-size: 1.15rem; color: var(--gv-text);
    }
    .gv-ticket-id i { color: var(--gv-amber); }

    .gv-pengaduan-status {
        font-size: 0.74rem; font-weight: 700;
        padding: 0.35rem 0.9rem; border-radius: 50px;
        letter-spacing: 0.04em;
    }
    .gv-pengaduan-status.diajukan {
        background: var(--gv-surface-3);
        border: 1px solid var(--gv-border);
        color: var(--gv-text-muted);
    }
    .gv-pengaduan-status.diproses {
        background: var(--gv-amber-light);
        border: 1px solid rgba(217,119,6,0.25);
        color: var(--gv-amber);
    }
    .gv-pengaduan-status.selesai {
        background: var(--gv-green-light);
        border: 1px solid rgba(5,150,105,0.25);
        color: var(--gv-green);
    }

    .gv-pengaduan-desc {
        color: var(--gv-text-muted); font-size: 0.9rem;
        line-height: 1.7; margin-bottom: 1.75rem; font-weight: 400;
    }

    /* STEPPER */
    .gv-stepper {
        position: relative; display: flex;
        justify-content: space-between;
        padding: 0 0.5rem; margin-bottom: 1.75rem;
    }
    .gv-step-line {
        position: absolute; top: 20px;
        left: 10%; right: 10%; height: 2px;
        background: var(--gv-surface-3); border-radius: 50px;
    }
    .gv-step-progress {
        height: 100%; border-radius: 50px;
        background: linear-gradient(90deg, var(--gv-green), var(--gv-green-2));
        transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
    }
    .gv-step {
        display: flex; flex-direction: column; align-items: center;
        gap: 0.6rem; flex: 1; position: relative; z-index: 2;
    }
    .gv-step-circle {
        width: 40px; height: 40px;
        background: var(--gv-surface-2);
        border: 2px solid var(--gv-border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; color: var(--gv-text-faint);
        transition: var(--gv-transition);
    }
    .gv-step.done .gv-step-circle {
        background: var(--gv-green-light);
        border-color: rgba(5,150,105,0.35);
        color: var(--gv-green);
        box-shadow: 0 0 16px var(--gv-green-glow);
    }
    .gv-step span { font-size: 0.7rem; font-weight: 600; color: var(--gv-text-faint); text-align: center; }
    .gv-step.done span { color: var(--gv-green); }

    .gv-pengaduan-footer {
        display: flex; justify-content: space-between; align-items: center;
        padding-top: 1.25rem; border-top: 1px solid var(--gv-border);
    }
    .gv-pengaduan-time {
        font-size: 0.8rem; color: var(--gv-text-faint);
        display: flex; align-items: center; gap: 0.4rem;
    }
    .gv-btn-delete-sm {
        display: inline-flex; align-items: center; gap: 0.35rem;
        background: var(--gv-red-light);
        border: 1px solid rgba(220,38,38,0.2);
        color: var(--gv-red); font-size: 0.75rem; font-weight: 600;
        padding: 0.4rem 0.85rem; border-radius: 8px;
        cursor: pointer; transition: var(--gv-transition);
    }
    .gv-btn-delete-sm:hover { background: #fecaca; }

    /* =============================================
       EMPTY STATE
    ============================================= */
    .gv-empty {
        background: var(--gv-surface);
        border: 2px dashed var(--gv-border);
        border-radius: var(--gv-radius);
        padding: 4rem 2rem; text-align: center;
    }

    .gv-slide {
    transition: opacity 0.8s ease-in-out;
}
    .gv-empty-icon { font-size: 2.75rem; margin-bottom: 1.25rem; opacity: 0.45; }
    .gv-empty h5 { font-weight: 700; color: var(--gv-text); margin-bottom: 0.5rem; }
    .gv-empty p { font-size: 0.875rem; color: var(--gv-text-muted); font-weight: 400; }

    /* =============================================
       RESPONSIVE
    ============================================= */
    @media(max-width:768px) {
        .gv-hero { padding: 4rem 1.5rem 3rem; }
        .gv-slider { height: 340px; }
        .gv-slide-card { width: 85%; padding: 2rem 1.5rem; }
        .gv-slide-card h3 { font-size: 1.5rem; }
        .gv-section, .gv-dual-grid { padding-left: 1rem; padding-right: 1rem; }
        .gv-amount-val { font-size: 1.65rem; }
        .gv-slide-shade {
            background: linear-gradient(to bottom, rgba(255,255,255,0.96) 55%, rgba(255,255,255,0.3) 100%);
        }
    }
    </style>

    @push('scripts')
   <script>
document.addEventListener('DOMContentLoaded', function () {

    let current = 0;
    const slides = document.querySelectorAll('.gv-slide');
    const dots = document.querySelectorAll('.gv-dot');

    if (slides.length === 0) return;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (dots[i]) dots[i].classList.remove('active');
        });

        current = (index + slides.length) % slides.length;

        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
    }

    function nextSlide() {
        showSlide(current + 1);
    }

    // 🔥 AUTO SLIDE (SETIAP 4 DETIK)
    setInterval(nextSlide, 4000);

});
</script>
    @endpush
    @endsection

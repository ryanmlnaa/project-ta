@extends('layouts.app')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <div class="dash-wrap">

        <!-- HERO HEADER -->
        <div class="dash-hero">
            <div class="hero-shapes">
                <div class="hs hs1"></div>
                <div class="hs hs2"></div>
                <div class="hs hs3"></div>
            </div>
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    Live Dashboard
                </div>
                <h1 class="hero-title">Dashboard RT</h1>
                <p class="hero-sub">Pantau aktivitas RT secara real-time</p>
            </div>

            {{-- CLOCK WIDGET --}}
            <div class="rt-clock">
                <div class="rt-clock-time" id="rt-clock-time">00:00:00</div>
                <div class="rt-clock-date" id="rt-clock-date">Memuat...</div>
            </div>

            <div class="hero-deco">
                <svg viewBox="0 0 140 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 70 Q45 15 80 55 Q105 78 130 35" stroke="rgba(255,255,255,0.25)" stroke-width="3"
                        fill="none" stroke-linecap="round" />
                    <circle cx="10" cy="70" r="5" fill="rgba(255,255,255,0.4)" />
                    <circle cx="80" cy="55" r="5" fill="rgba(255,255,255,0.4)" />
                    <circle cx="130" cy="35" r="5" fill="rgba(255,255,255,0.4)" />
                    <circle cx="10" cy="70" r="10" fill="rgba(255,255,255,0.08)" />
                    <circle cx="80" cy="55" r="10" fill="rgba(255,255,255,0.08)" />
                    <circle cx="130" cy="35" r="10" fill="rgba(255,255,255,0.08)" />
                </svg>
            </div>
        </div>
        <!-- STATS GRID ROW 1 -->
        <div class="stats-grid" style="grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:14px;">
            <div class="stat-card" style="--delay:0.05s;padding:16px 18px;">
                <div class="stat-icon-wrap c-green" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Penghuni RT</p>
                    <h2 class="stat-val vc-green" style="font-size:1.8rem;">{{ $totalPenghuni }}</h2>
                    <span class="stat-sub">Warga wilayah ini</span>
                </div>
                <div class="stat-glow g-green"></div>
            </div>
            <div class="stat-card" style="--delay:0.1s;padding:16px 18px;">
                <div class="stat-icon-wrap c-teal" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Rumah RT</p>
                    <h2 class="stat-val vc-teal" style="font-size:1.8rem;">{{ $totalRumah }}</h2>
                    <span class="stat-sub">Terisi: {{ $rumahTerisi }} · Kosong: {{ $rumahKosong }}</span>
                    <div class="prog-bar" style="margin-top:8px;">
                        <div class="prog-fill pf-teal" style="width:{{ $totalRumah > 0 ? ($rumahTerisi/$totalRumah*100) : 0 }}%"></div>
                    </div>
                </div>
                <div class="stat-glow g-teal"></div>
            </div>
            <div class="stat-card" style="--delay:0.15s;padding:16px 18px;">
                <div class="stat-icon-wrap c-amber" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Iuran</p>
                    <h2 class="stat-val vc-amber" style="font-size:1.8rem;">{{ $totalIuran }}</h2>
                    <span class="stat-sub">Total iuran bulanan</span>
                </div>
                <div class="stat-glow g-amber"></div>
            </div>
            <div class="stat-card" style="--delay:0.2s;padding:16px 18px;">
                <div class="stat-icon-wrap c-rose" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Pengaduan</p>
                    <h2 class="stat-val vc-rose" style="font-size:1.8rem;">{{ $totalPengaduan }}</h2>
                    <span class="stat-sub">Laporan masuk</span>
                </div>
                <div class="stat-glow g-rose"></div>
            </div>
        </div>

        <!-- STATS GRID ROW 2 -->
        <div class="stats-grid" style="grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:14px;">
            <div class="stat-card wide" style="--delay:0.25s;padding:16px 18px;">
                <div class="stat-icon-wrap c-orange large" style="width:46px;height:46px;font-size:1.1rem;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Menunggu RT</p>
                    <h2 class="stat-val vc-orange" style="font-size:1.8rem;">{{ $menungguRT }}</h2>
                    <span class="stat-sub">Perlu penanganan segera</span>
                    <div class="prog-bar">
                        <div class="prog-fill pf-orange" style="width:{{ min(($menungguRT/max($totalPengaduan,1))*100,100) }}%"></div>
                    </div>
                </div>
                <div class="stat-glow g-orange"></div>
            </div>
            <div class="stat-card wide" style="--delay:0.3s;padding:16px 18px;">
                <div class="stat-icon-wrap c-sky large" style="width:46px;height:46px;font-size:1.1rem;">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Ke Admin</p>
                    <h2 class="stat-val vc-sky" style="font-size:1.8rem;">{{ $menungguAdmin }}</h2>
                    <span class="stat-sub">Sedang diproses admin</span>
                    <div class="prog-bar">
                        <div class="prog-fill pf-sky" style="width:{{ min(($menungguAdmin/max($totalPengaduan,1))*100,100) }}%"></div>
                    </div>
                </div>
                <div class="stat-glow g-sky"></div>
            </div>
        </div>

        {{-- SECTION BENDAHARA --}}
        @if($bendaharaAktif)
        <div style="margin-bottom:10px;margin-top:4px;">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#94a3b8;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                <span style="width:20px;height:2px;background:#10b981;border-radius:2px;display:inline-block;"></span>
                Info Bendahara — {{ $bendaharaAktif->name }}
                <span style="width:20px;height:2px;background:#10b981;border-radius:2px;display:inline-block;"></span>
            </div>
        </div>
        <div class="stats-grid" style="grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:14px;">
            <div class="stat-card" style="--delay:0.35s;padding:16px 18px;">
                <div class="stat-icon-wrap c-amber" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Menunggu Konfirmasi</p>
                    <h2 class="stat-val vc-amber" style="font-size:1.8rem;">{{ $menungguKonfirmasi }}</h2>
                    <span class="stat-sub">Iuran sudah dibayar penghuni</span>
                </div>
                <div class="stat-glow g-amber"></div>
            </div>
            <div class="stat-card" style="--delay:0.4s;padding:16px 18px;">
                <div class="stat-icon-wrap c-green" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Lunas Bulan Ini</p>
                    <h2 class="stat-val vc-green" style="font-size:1.8rem;">{{ $lunasBuilanIni }}</h2>
                    <span class="stat-sub">Iuran terkonfirmasi</span>
                </div>
                <div class="stat-glow g-green"></div>
            </div>
            <div class="stat-card" style="--delay:0.45s;padding:16px 18px;">
                <div class="stat-icon-wrap c-teal" style="width:40px;height:40px;font-size:1rem;margin-bottom:10px;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Saldo Kas</p>
                    <h2 class="stat-val vc-teal" style="font-size:1.3rem;">Rp {{ number_format($saldoKas,0,',','.') }}</h2>
                    <span class="stat-sub">Total kas bendahara</span>
                </div>
                <div class="stat-glow g-teal"></div>
            </div>
        </div>
        <div class="stats-grid" style="grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:24px;">
            <div class="stat-card wide" style="--delay:0.5s;padding:16px 18px;">
                <div class="stat-icon-wrap c-rose large" style="width:46px;height:46px;font-size:1.1rem;">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Rekap Belum Dikirim</p>
                    <h2 class="stat-val vc-rose" style="font-size:1.8rem;">{{ $rekapBelumDikirim }}</h2>
                    <span class="stat-sub">Iuran lunas belum direkap ke RT</span>
                </div>
                <div class="stat-glow g-rose"></div>
            </div>
            <div class="stat-card wide" style="--delay:0.55s;padding:16px 18px;">
                <div class="stat-icon-wrap c-orange large" style="width:46px;height:46px;font-size:1.1rem;">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Tagihan Kas Belum Bayar</p>
                    <h2 class="stat-val vc-orange" style="font-size:1.8rem;">{{ $tagihanKasBelumBayar }}</h2>
                    <span class="stat-sub">Menunggu pembayaran penghuni</span>
                </div>
                <div class="stat-glow g-orange"></div>
            </div>
        </div>
        @else
        <div style="background:#fff;border-radius:18px;border:1px solid #e8ede9;padding:20px;margin-bottom:24px;text-align:center;color:#94a3b8;">
            <i class="fas fa-user-slash" style="font-size:22px;margin-bottom:8px;display:block;"></i>
            <p style="font-size:13px;font-weight:600;">Belum ada bendahara aktif untuk RT ini.</p>
        </div>
        @endif

        <!-- CHART -->
        <div class="chart-card">
            <div class="chart-head">
                <div>
                    <h5 class="chart-title"><i class="fas fa-chart-line"></i> Statistik Pengaduan</h5>
                    <p class="chart-sub">Tren 12 bulan terakhir</p>
                </div>
                <div class="chart-legend">
                    <span class="leg-item"><span class="leg-dot ld-blue"></span>Diajukan</span>
                    <span class="leg-item"><span class="leg-dot ld-pink"></span>Menunggu</span>
                    <span class="leg-item"><span class="leg-dot ld-green"></span>Selesai</span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="chartPengaduan"></canvas>
            </div>
        </div>

    </div>

    <style>
        .pf-teal {
            background: linear-gradient(90deg, #0d7377, #14a085);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .dash-wrap {
            padding: 24px 24px 48px;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }

        .dash-wrap .dash-hero {
            border-radius: 22px !important;
            -webkit-border-radius: 22px !important;
        }

        /* ── HERO ── */
        .dash-hero {
            position: relative;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 45%, #10b981 100%);
            border-radius: 22px !important;
            padding: 40px 44px;
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 16px 48px rgba(6, 78, 59, 0.35);
        }

        .hero-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .hs {
            position: absolute;
            border-radius: 50%;
            background: white;
            opacity: 0.07;
        }

        .hs1 {
            width: 280px;
            height: 280px;
            top: -80px;
            right: -50px;
        }

        .hs2 {
            width: 150px;
            height: 150px;
            bottom: -40px;
            right: 200px;
        }

        .hs3 {
            width: 90px;
            height: 90px;
            top: 20px;
            right: 300px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 5px 13px;
            border-radius: 100px;
            margin-bottom: 14px;
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #a7f3d0;
            animation: blink 1.8s ease infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.4); }
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 7px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        .hero-sub {
            color: rgba(255, 255, 255, 0.82);
            font-size: 1rem;
            font-weight: 500;
        }

        .hero-deco {
            position: absolute;
            right: 44px;
            bottom: 20px;
            width: 150px;
            opacity: 0.55;
            z-index: 1;
        }

        /* ── CLOCK RT ── */
        .rt-clock {
            position: absolute;
            top: 50%;
            right: 44px;
            transform: translateY(-50%);
            z-index: 2;
            text-align: center;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 18px;
            padding: 16px 26px;
            min-width: 160px;
        }
        .rt-clock-time {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.04em;
            line-height: 1;
            margin-bottom: 6px;
        }
        .rt-clock-colon {
            animation: rtBlink 1s step-end infinite;
            display: inline-block;
        }
        @keyframes rtBlink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        .rt-clock-date {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(255,255,255,0.75);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px 22px 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid #e8ede9;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.45s ease both;
            animation-delay: var(--delay, 0s);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            isolation: isolate;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }

        .stat-card.wide {
            grid-column: span 2;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .stat-card.wide .stat-body {
            flex: 1;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Icon */
        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
            margin-bottom: 16px;
        }

        .stat-icon-wrap.large {
            width: 60px;
            height: 60px;
            font-size: 1.45rem;
            margin-bottom: 0;
        }

        .c-green  { background: linear-gradient(135deg, #064e3b, #10b981); box-shadow: 0 6px 18px rgba(6,78,59,0.3); }
        .c-teal   { background: linear-gradient(135deg, #0d7377, #14a085); box-shadow: 0 6px 18px rgba(13,115,119,0.3); }
        .c-amber  { background: linear-gradient(135deg, #b45309, #d97706); box-shadow: 0 6px 18px rgba(217,119,6,0.3); }
        .c-rose   { background: linear-gradient(135deg, #be123c, #e11d48); box-shadow: 0 6px 18px rgba(225,29,72,0.3); }
        .c-orange { background: linear-gradient(135deg, #c2410c, #ea580c); box-shadow: 0 6px 18px rgba(234,88,12,0.3); }
        .c-sky    { background: linear-gradient(135deg, #0369a1, #0284c7); box-shadow: 0 6px 18px rgba(2,132,199,0.3); }

        .stat-icon-wrap, .stat-body { position: relative; z-index: 1; }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 3px;
        }

        .stat-val {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-sub { font-size: 0.78rem; color: #94a3b8; font-weight: 500; }

        .stat-val.vc-green  { color: #064e3b; }
        .stat-val.vc-teal   { color: #0d7377; }
        .stat-val.vc-amber  { color: #b45309; }
        .stat-val.vc-rose   { color: #be123c; }
        .stat-val.vc-orange { color: #c2410c; }
        .stat-val.vc-sky    { color: #0369a1; }

        .prog-bar {
            height: 4px;
            background: #f1f5f1;
            border-radius: 100px;
            margin-top: 10px;
            overflow: hidden;
        }

        .prog-fill {
            height: 100%;
            border-radius: 100px;
            transition: width 1s ease;
        }

        .pf-orange { background: linear-gradient(90deg, #c2410c, #ea580c); }
        .pf-sky    { background: linear-gradient(90deg, #0369a1, #38bdf8); }

        .stat-glow {
            position: absolute;
            width: 120px; height: 120px;
            border-radius: 50%;
            right: -30px; bottom: -40px;
            opacity: 0.06;
            pointer-events: none;
            z-index: 0;
        }

        .g-green  { background: #10b981; }
        .g-teal   { background: #14a085; }
        .g-amber  { background: #d97706; }
        .g-rose   { background: #e11d48; }
        .g-orange { background: #ea580c; }
        .g-sky    { background: #38bdf8; }

        /* ── CHART ── */
        .chart-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e8ede9;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: slideUp 0.45s 0.35s ease both;
        }

        .chart-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            border-bottom: 1px solid #f0f4f1;
            flex-wrap: wrap;
            gap: 10px;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #064e3b;
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 3px;
        }

        .chart-title i { color: #206d31; }
        .chart-sub { font-size: 0.78rem; color: #94a3b8; }

        .chart-legend { display: flex; gap: 16px; }

        .leg-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
        }

        .leg-dot { width: 9px; height: 9px; border-radius: 50%; }
        .ld-blue  { background: #3b82f6; }
        .ld-pink  { background: #ec4899; }
        .ld-green { background: #064e3b; }

        .chart-body {
            padding: 20px 24px 24px;
            height: 320px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-card.wide { grid-column: span 2; }
            .rt-clock {
                right: 24px;
                padding: 12px 18px;
                min-width: 130px;
            }
            .rt-clock-time { font-size: 1.6rem; }
        }

        @media (max-width: 640px) {
            .dash-wrap { padding: 14px 14px 40px; }

            .dash-hero {
                padding: 28px 22px 22px;
                display: flex;
                flex-direction: column;
            }

            .hero-title  { font-size: 1.75rem; }
            .hero-deco   { display: none; }

            /* Clock turun ke bawah konten hero, bentuk pill */
            .rt-clock {
                position: static;
                transform: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                margin-top: 18px;
                padding: 10px 16px;
                border-radius: 50px;
                min-width: 0;
                width: fit-content;
                align-self: flex-start;
            }
            .rt-clock-time {
                font-size: 1.15rem;
                margin-bottom: 0;
                line-height: 1;
            }
            .rt-clock-date {
                font-size: 0.62rem;
                text-align: left;
                line-height: 1.4;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .stat-card.wide { grid-column: span 2; }
            .stat-val { font-size: 1.9rem; }

            .chart-head {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 400px) {
            .rt-clock { padding: 8px 12px; }
            .rt-clock-time { font-size: 1rem; }
            .rt-clock-date { font-size: 0.58rem; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // ── CHART ──
            const ctx = document.getElementById('chartPengaduan');

            const labels = @json(array_map(fn($i) => now()->subMonths(11-$i)->format('M'), range(0,11)));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Diajukan',
                            data: {{ $chartDiajukan }},
                            borderColor: '#3b82f6',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(59,130,246,0.15)', 'rgba(59,130,246,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#3b82f6', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        },
                        {
                            label: 'Menunggu',
                            data: {{ $chartMenunggu }},
                            borderColor: '#ec4899',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(236,72,153,0.12)', 'rgba(236,72,153,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#ec4899', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        },
                        {
                            label: 'Selesai',
                            data: {{ $chartSelesai }},
                            borderColor: '#064e3b',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(6,78,59,0.15)', 'rgba(6,78,59,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#064e3b', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        }
                    ]
                },

            const mkGrad = (chartCtx, c1, c2) => {
                const g = chartCtx.createLinearGradient(0, 0, 0, 260);
                g.addColorStop(0, c1);
                g.addColorStop(1, c2);
                return g;
            };

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Diajukan',
                            data: base,
                            borderColor: '#3b82f6',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(59,130,246,0.15)', 'rgba(59,130,246,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#3b82f6', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        },
                        {
                            label: 'Menunggu',
                            data: base.map(d => d * 0.7),
                            borderColor: '#ec4899',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(236,72,153,0.12)', 'rgba(236,72,153,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#206d31', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        },
                        {
                            label: 'Selesai',
                            data: base.map(d => d * 1.2),
                            borderColor: '#064e3b',
                            backgroundColor: (c) => mkGrad(c.chart.ctx, 'rgba(6,78,59,0.15)', 'rgba(6,78,59,0)'),
                            borderWidth: 2.5, fill: true, tension: 0.45,
                            pointBackgroundColor: '#064e3b', pointBorderColor: '#fff',
                            pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a2e22',
                            titleColor: '#94a3b8',
                            bodyColor: '#f8fafc',
                            borderColor: 'rgba(255,255,255,0.08)',
                            borderWidth: 1,
                            padding: 11,
                            cornerRadius: 10,
                            boxPadding: 5
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: { font: { family: "'Plus Jakarta Sans'", size: 11, weight: '600' }, color: '#94a3b8' }
                        },
                        y: {
                            grid: { color: 'rgba(0,0,0,0.04)' },
                            ticks: { font: { family: "'Plus Jakarta Sans'", size: 11 }, color: '#94a3b8', stepSize: 1 },
                            beginAtZero: true
                        }
                    }
                }
            });

            // ── CLOCK RT ──
            function updateRtClock() {
                const now    = new Date();
                const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

                const hari  = days[now.getDay()];
                const tgl   = String(now.getDate()).padStart(2,'0');
                const bln   = months[now.getMonth()];
                const thn   = now.getFullYear();
                const jam   = String(now.getHours()).padStart(2,'0');
                const menit = String(now.getMinutes()).padStart(2,'0');
                const detik = String(now.getSeconds()).padStart(2,'0');

                const timeEl = document.getElementById('rt-clock-time');
                if (timeEl) {
                    timeEl.innerHTML =
                        `${jam}<span class="rt-clock-colon">:</span>${menit}<span class="rt-clock-colon">:</span>${detik}`;
                }
                const dateEl = document.getElementById('rt-clock-date');
                if (dateEl) {
                    dateEl.textContent = `${hari}, ${tgl} ${bln} ${thn}`;
                }
            }

            updateRtClock();
            setInterval(updateRtClock, 1000);
        });
    </script>

@endsection

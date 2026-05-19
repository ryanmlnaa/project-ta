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

        <!-- STATS GRID -->
        <div class="stats-grid">

            {{-- RT 1 --}}
            <div class="stat-card" style="--delay:0.05s">
                <div class="stat-icon-wrap c-green">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">RT 1 – Blok D</p>
                    <h2 class="stat-val vc-green">{{ $rt1_penghuni }} penghuni</h2>
                    <span class="stat-sub">Rumah terisi: {{ $rt1_rumah_terisi }} / {{ $rt1_rumah_total }}</span>
                    <div class="prog-bar" style="margin-top:10px">
                        <div class="prog-fill pf-green"
                            style="width: {{ $rt1_rumah_total > 0 ? ($rt1_rumah_terisi / $rt1_rumah_total * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                <div class="stat-glow g-green"></div>
            </div>

            {{-- RT 2 --}}
            <div class="stat-card" style="--delay:0.1s">
                <div class="stat-icon-wrap c-teal">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">RT 2 – Blok E</p>
                    <h2 class="stat-val vc-teal">{{ $rt2_penghuni }} penghuni</h2>
                    <span class="stat-sub">Rumah terisi: {{ $rt2_rumah_terisi }} / {{ $rt2_rumah_total }}</span>
                    <div class="prog-bar" style="margin-top:10px">
                        <div class="prog-fill pf-sky"
                            style="width: {{ $rt2_rumah_total > 0 ? ($rt2_rumah_terisi / $rt2_rumah_total * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                <div class="stat-glow g-teal"></div>
            </div>

            {{-- RT 3 --}}
            <div class="stat-card" style="--delay:0.15s">
                <div class="stat-icon-wrap c-rose">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">RT 3 – Blok C</p>
                    <h2 class="stat-val vc-rose">{{ $rt3_penghuni }} penghuni</h2>
                    <span class="stat-sub">Rumah terisi: {{ $rt3_rumah_terisi }} / {{ $rt3_rumah_total }}</span>
                    <div class="prog-bar" style="margin-top:10px">
                        <div class="prog-fill"
                            style="width: {{ $rt3_rumah_total > 0 ? ($rt3_rumah_terisi / $rt3_rumah_total * 100) : 0 }}%; background: linear-gradient(90deg,#be123c,#e11d48); height:100%; border-radius:100px;">
                        </div>
                    </div>
                </div>
                <div class="stat-glow g-rose"></div>
            </div>

            <div class="stat-card" style="--delay:0.15s">
                <div class="stat-icon-wrap c-amber">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Iuran</p>
                    <h2 class="stat-val vc-amber">{{ $totalIuran }}</h2>
                    <span class="stat-sub">Total iuran bulanan</span>
                </div>
                <div class="stat-glow g-amber"></div>
            </div>

            <div class="stat-card" style="--delay:0.2s">
                <div class="stat-icon-wrap c-rose">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Pengaduan</p>
                    <h2 class="stat-val vc-rose">{{ $totalPengaduan }}</h2>
                    <span class="stat-sub">Laporan masuk</span>
                </div>
                <div class="stat-glow g-rose"></div>
            </div>

            <div class="stat-card wide" style="--delay:0.25s">
                <div class="stat-icon-wrap c-orange large">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Menunggu RT</p>
                    <h2 class="stat-val vc-orange">{{ $menungguRT }}</h2>
                    <span class="stat-sub">Perlu penanganan segera</span>
                    <div class="prog-bar">
                        <div class="prog-fill pf-orange"
                            style="width: {{ min(($menungguRT / max($totalPengaduan, 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
                <div class="stat-glow g-orange"></div>
            </div>

            <div class="stat-card wide" style="--delay:0.3s">
                <div class="stat-icon-wrap c-sky large">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-body">
                    <p class="stat-label">Ke Admin</p>
                    <h2 class="stat-val vc-sky">{{ $menungguAdmin }}</h2>
                    <span class="stat-sub">Sedang diproses admin</span>
                    <div class="prog-bar">
                        <div class="prog-fill pf-sky"
                            style="width: {{ min(($menungguAdmin / max($totalPengaduan, 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
                <div class="stat-glow g-sky"></div>
            </div>

        </div>

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

        .pf-green { background: linear-gradient(90deg, #064e3b, #10b981); }
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

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.4);
            }
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
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .c-green {
            background: linear-gradient(135deg, #064e3b, #10b981);
            box-shadow: 0 6px 18px rgba(6, 78, 59, 0.3);
        }

        .c-teal {
            background: linear-gradient(135deg, #0d7377, #14a085);
            box-shadow: 0 6px 18px rgba(13, 115, 119, 0.3);
        }

        .c-amber {
            background: linear-gradient(135deg, #b45309, #d97706);
            box-shadow: 0 6px 18px rgba(217, 119, 6, 0.3);
        }

        .c-rose {
            background: linear-gradient(135deg, #be123c, #e11d48);
            box-shadow: 0 6px 18px rgba(225, 29, 72, 0.3);
        }

        .c-orange {
            background: linear-gradient(135deg, #c2410c, #ea580c);
            box-shadow: 0 6px 18px rgba(234, 88, 12, 0.3);
        }

        .c-sky {
            background: linear-gradient(135deg, #0369a1, #0284c7);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.3);
        }

        /* Ensure content sits above glow */
        .stat-icon-wrap,
        .stat-body {
            position: relative;
            z-index: 1;
        }

        /* Text */
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

        .stat-sub {
            font-size: 0.78rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .stat-val.vc-green {
            color: #064e3b;
        }

        .stat-val.vc-teal {
            color: #0d7377;
        }

        .stat-val.vc-amber {
            color: #b45309;
        }

        .stat-val.vc-rose {
            color: #be123c;
        }

        .stat-val.vc-orange {
            color: #c2410c;
        }

        .stat-val.vc-sky {
            color: #0369a1;
        }

        /* Progress bar */
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

        .pf-orange {
            background: linear-gradient(90deg, #c2410c, #ea580c);
        }

        .pf-sky {
            background: linear-gradient(90deg, #0369a1, #38bdf8);
        }

        /* Glow blobs */
        .stat-glow {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            right: -30px;
            bottom: -40px;
            opacity: 0.06;
            pointer-events: none;
            z-index: 0;
        }

        .g-green {
            background: #10b981;
        }

        .g-teal {
            background: #14a085;
        }

        .g-amber {
            background: #d97706;
        }

        .g-rose {
            background: #e11d48;
        }

        .g-orange {
            background: #ea580c;
        }

        .g-sky {
            background: #38bdf8;
        }

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

        .chart-title i {
            color: #206d31;
        }

        .chart-sub {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
        }

        .leg-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
        }

        .leg-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
        }

        .ld-blue {
            background: #3b82f6;
        }

        .ld-pink {
            background: #ec4899;
        }

        .ld-green {
            background: #064e3b;
        }

        .chart-body {
            padding: 20px 24px 24px;
            height: 320px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card.wide {
                grid-column: span 2;
            }
        }

        @media (max-width: 640px) {
            .dash-wrap {
                padding: 14px 14px 40px;
            }

            .dash-hero {
                padding: 28px 22px;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .hero-deco {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .stat-card.wide {
                grid-column: span 2;
            }

            .stat-val {
                font-size: 1.9rem;
            }

            .chart-head {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('chartPengaduan');

            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const base = [
            {{ $diajukan }}, {{ $menunggu }}, {{ $selesai }},
            {{ $diajukan * 0.8 }}, {{ $menunggu * 1.2 }}, {{ $selesai * 0.9 }},
            {{ $diajukan * 1.1 }}, {{ $menunggu * 0.7 }}, {{ $selesai * 1.3 }},
            {{ $diajukan * 0.95 }}, {{ $menunggu * 1.1 }}, {{ $selesai * 1.0 }}
            ];

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
        });
    </script>

@endsection

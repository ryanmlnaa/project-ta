@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="dash-wrap">

    {{-- HERO --}}
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
        <div class="rt-clock">
            <div class="rt-clock-time" id="rt-clock-time">00:00:00</div>
            <div class="rt-clock-date" id="rt-clock-date">Memuat...</div>
        </div>
        <div class="hero-deco">
            <svg viewBox="0 0 140 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 70 Q45 15 80 55 Q105 78 130 35" stroke="rgba(255,255,255,0.25)" stroke-width="3" fill="none" stroke-linecap="round"/>
                <circle cx="10"  cy="70" r="5"  fill="rgba(255,255,255,0.4)"/>
                <circle cx="80"  cy="55" r="5"  fill="rgba(255,255,255,0.4)"/>
                <circle cx="130" cy="35" r="5"  fill="rgba(255,255,255,0.4)"/>
                <circle cx="10"  cy="70" r="10" fill="rgba(255,255,255,0.08)"/>
                <circle cx="80"  cy="55" r="10" fill="rgba(255,255,255,0.08)"/>
                <circle cx="130" cy="35" r="10" fill="rgba(255,255,255,0.08)"/>
            </svg>
        </div>
    </div>

    {{-- ROW 1: 4 stat --}}
    <div class="stats-grid sg-4">
        <div class="stat-card" style="--delay:.05s">
            <div class="stat-icon-wrap c-green"><i class="fas fa-users"></i></div>
            <div class="stat-body">
                <p class="stat-label">Penghuni RT</p>
                <h2 class="stat-val vc-green">{{ $totalPenghuni }}</h2>
                <span class="stat-sub">Warga wilayah ini</span>
            </div>
            <div class="stat-glow g-green"></div>
        </div>
        <div class="stat-card" style="--delay:.10s">
            <div class="stat-icon-wrap c-teal"><i class="fas fa-home"></i></div>
            <div class="stat-body">
                <p class="stat-label">Rumah RT</p>
                <h2 class="stat-val vc-teal">{{ $totalRumah }}</h2>
                <span class="stat-sub">Terisi: {{ $rumahTerisi }} · Kosong: {{ $rumahKosong }}</span>
                <div class="prog-bar">
                    <div class="prog-fill pf-teal" style="width:{{ $totalRumah > 0 ? ($rumahTerisi/$totalRumah*100) : 0 }}%"></div>
                </div>
            </div>
            <div class="stat-glow g-teal"></div>
        </div>
        <div class="stat-card" style="--delay:.15s">
            <div class="stat-icon-wrap c-amber"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-body">
                <p class="stat-label">Iuran</p>
                <h2 class="stat-val vc-amber">{{ $totalIuran }}</h2>
                <span class="stat-sub">Total iuran bulanan</span>
            </div>
            <div class="stat-glow g-amber"></div>
        </div>
        <div class="stat-card" style="--delay:.20s">
            <div class="stat-icon-wrap c-rose"><i class="fas fa-bullhorn"></i></div>
            <div class="stat-body">
                <p class="stat-label">Pengaduan</p>
                <h2 class="stat-val vc-rose">{{ $totalPengaduan }}</h2>
                <span class="stat-sub">Laporan masuk</span>
            </div>
            <div class="stat-glow g-rose"></div>
        </div>
    </div>

    {{-- ROW 2: 2 wide --}}
    <div class="stats-grid sg-2">
        <div class="stat-card wide" style="--delay:.25s">
            <div class="stat-icon-wrap c-orange large"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-body">
                <p class="stat-label">Menunggu RT</p>
                <h2 class="stat-val vc-orange">{{ $menungguRT }}</h2>
                <span class="stat-sub">Perlu penanganan segera</span>
                <div class="prog-bar">
                    <div class="prog-fill pf-orange" style="width:{{ min(($menungguRT/max($totalPengaduan,1))*100,100) }}%"></div>
                </div>
            </div>
            <div class="stat-glow g-orange"></div>
        </div>
        <div class="stat-card wide" style="--delay:.30s">
            <div class="stat-icon-wrap c-sky large"><i class="fas fa-paper-plane"></i></div>
            <div class="stat-body">
                <p class="stat-label">Ke Admin</p>
                <h2 class="stat-val vc-sky">{{ $menungguAdmin }}</h2>
                <span class="stat-sub">Sedang diproses admin</span>
                <div class="prog-bar">
                    <div class="prog-fill pf-sky" style="width:{{ min(($menungguAdmin/max($totalPengaduan,1))*100,100) }}%"></div>
                </div>
            </div>
            <div class="stat-glow g-sky"></div>
        </div>
    </div>

    {{-- BENDAHARA SECTION --}}
    @if($bendaharaAktif)
    <div class="section-divider">
        <span class="sd-line"></span>
        <span class="sd-label">Info Bendahara — {{ $bendaharaAktif->name }}</span>
        <span class="sd-line"></span>
    </div>

    <div class="stats-grid sg-3">
        <div class="stat-card" style="--delay:.35s">
            <div class="stat-icon-wrap c-amber"><i class="fas fa-clock"></i></div>
            <div class="stat-body">
                <p class="stat-label">Menunggu Konfirmasi</p>
                <h2 class="stat-val vc-amber">{{ $menungguKonfirmasi }}</h2>
                <span class="stat-sub">Iuran sudah dibayar penghuni</span>
            </div>
            <div class="stat-glow g-amber"></div>
        </div>
        <div class="stat-card" style="--delay:.40s">
            <div class="stat-icon-wrap c-green"><i class="fas fa-check-double"></i></div>
            <div class="stat-body">
                <p class="stat-label">Lunas Bulan Ini</p>
                <h2 class="stat-val vc-green">{{ $lunasBuilanIni }}</h2>
                <span class="stat-sub">Iuran terkonfirmasi</span>
            </div>
            <div class="stat-glow g-green"></div>
        </div>
        <div class="stat-card" style="--delay:.45s">
            <div class="stat-icon-wrap c-teal"><i class="fas fa-wallet"></i></div>
            <div class="stat-body">
                <p class="stat-label">Saldo Kas</p>
                <h2 class="stat-val vc-teal" style="font-size:1.35rem">Rp {{ number_format($saldoKas,0,',','.') }}</h2>
                <span class="stat-sub">Total kas bendahara</span>
            </div>
            <div class="stat-glow g-teal"></div>
        </div>
    </div>

    <div class="stats-grid sg-2" style="margin-bottom:28px">
        <div class="stat-card wide" style="--delay:.50s">
            <div class="stat-icon-wrap c-rose large"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-body">
                <p class="stat-label">Rekap Belum Dikirim</p>
                <h2 class="stat-val vc-rose">{{ $rekapBelumDikirim }}</h2>
                <span class="stat-sub">Iuran lunas belum direkap ke RT</span>
            </div>
            <div class="stat-glow g-rose"></div>
        </div>
        <div class="stat-card wide" style="--delay:.55s">
            <div class="stat-icon-wrap c-orange large"><i class="fas fa-coins"></i></div>
            <div class="stat-body">
                <p class="stat-label">Tagihan Kas Belum Bayar</p>
                <h2 class="stat-val vc-orange">{{ $tagihanKasBelumBayar }}</h2>
                <span class="stat-sub">Menunggu pembayaran penghuni</span>
            </div>
            <div class="stat-glow g-orange"></div>
        </div>
    </div>

    @else
    <div class="empty-bendahara">
        <i class="fas fa-user-slash"></i>
        <p>Belum ada bendahara aktif untuk RT ini.</p>
    </div>
    @endif

    {{-- CHART --}}
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
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }

.dash-wrap {
    padding: 24px 24px 48px;
    font-family: 'Plus Jakarta Sans','Segoe UI',sans-serif;
}

/* ── HERO ── */
.dash-hero {
    position: relative;
    background: linear-gradient(135deg,#064e3b 0%,#065f46 45%,#10b981 100%);
    border-radius: 22px;
    padding: 40px 44px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 16px 48px rgba(6,78,59,0.35);
}
.hero-shapes { position: absolute; inset: 0; pointer-events: none; }
.hs { position: absolute; border-radius: 50%; background: white; opacity: .07; }
.hs1 { width:280px; height:280px; top:-80px;  right:-50px; }
.hs2 { width:150px; height:150px; bottom:-40px; right:200px; }
.hs3 { width:90px;  height:90px;  top:20px;  right:300px; }
.hero-content { position: relative; z-index: 1; }
.hero-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3);
    color: white; font-size: .75rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em;
    padding: 5px 13px; border-radius: 100px; margin-bottom: 14px;
}
.badge-dot { width:7px; height:7px; border-radius:50%; background:#a7f3d0; animation: blink 1.8s ease infinite; }
@keyframes blink { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:.5;transform:scale(1.4);} }
.hero-title { font-size:2.2rem; font-weight:800; color:white; letter-spacing:-.03em; line-height:1.1; margin-bottom:7px; text-shadow:0 2px 8px rgba(0,0,0,.12); }
.hero-sub   { color:rgba(255,255,255,0.82); font-size:1rem; font-weight:500; }
.hero-deco  { position:absolute; right:44px; bottom:20px; width:150px; opacity:.55; z-index:1; }

/* ── CLOCK ── */
.rt-clock {
    position: absolute; top: 50%; right: 44px; transform: translateY(-50%);
    z-index: 2; text-align: center;
    background: rgba(255,255,255,0.12); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.25); border-radius: 18px;
    padding: 16px 26px; min-width: 160px;
}
.rt-clock-time { font-size:2rem; font-weight:800; color:#fff; letter-spacing:.04em; line-height:1; margin-bottom:6px; }
.rt-clock-colon { animation: rtBlink 1s step-end infinite; display:inline-block; }
@keyframes rtBlink { 0%,100%{opacity:1;} 50%{opacity:0;} }
.rt-clock-date { font-size:.68rem; font-weight:700; color:rgba(255,255,255,0.75); letter-spacing:.06em; text-transform:uppercase; }

/* ── STATS GRID ── */
.stats-grid { display:grid; gap:14px; margin-bottom:14px; }
.sg-4 { grid-template-columns: repeat(4,1fr); }
.sg-3 { grid-template-columns: repeat(3,1fr); }
.sg-2 { grid-template-columns: repeat(2,1fr); }

.stat-card {
    background: #fff; border-radius: 18px; padding: 20px 18px;
    position: relative; overflow: hidden;
    border: 1px solid #e8ede9;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    animation: slideUp .45s ease both;
    animation-delay: var(--delay,0s);
    transition: transform .25s ease, box-shadow .25s ease;
    isolation: isolate;
}
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,.10); }
.stat-card.wide { display:flex; align-items:center; gap:18px; }
.stat-card.wide .stat-body { flex:1; }
@keyframes slideUp { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }

.stat-icon-wrap {
    width:48px; height:48px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.15rem; color:white; flex-shrink:0; margin-bottom:14px;
}
.stat-icon-wrap.large { width:56px; height:56px; font-size:1.35rem; margin-bottom:0; }
.stat-icon-wrap,.stat-body { position:relative; z-index:1; }

.c-green  { background:linear-gradient(135deg,#064e3b,#10b981); box-shadow:0 6px 18px rgba(6,78,59,.3); }
.c-teal   { background:linear-gradient(135deg,#0d7377,#14a085); box-shadow:0 6px 18px rgba(13,115,119,.3); }
.c-amber  { background:linear-gradient(135deg,#b45309,#d97706); box-shadow:0 6px 18px rgba(217,119,6,.3); }
.c-rose   { background:linear-gradient(135deg,#be123c,#e11d48); box-shadow:0 6px 18px rgba(225,29,72,.3); }
.c-orange { background:linear-gradient(135deg,#c2410c,#ea580c); box-shadow:0 6px 18px rgba(234,88,12,.3); }
.c-sky    { background:linear-gradient(135deg,#0369a1,#0284c7); box-shadow:0 6px 18px rgba(2,132,199,.3); }

.stat-label { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; margin-bottom:3px; }
.stat-val   { font-size:2.2rem; font-weight:800; letter-spacing:-.04em; line-height:1; margin-bottom:5px; }
.stat-sub   { font-size:.76rem; color:#94a3b8; font-weight:500; }

.vc-green  { color:#064e3b; }
.vc-teal   { color:#0d7377; }
.vc-amber  { color:#b45309; }
.vc-rose   { color:#be123c; }
.vc-orange { color:#c2410c; }
.vc-sky    { color:#0369a1; }

.prog-bar  { height:4px; background:#f1f5f1; border-radius:100px; margin-top:10px; overflow:hidden; }
.prog-fill { height:100%; border-radius:100px; transition:width 1s ease; }
.pf-teal   { background:linear-gradient(90deg,#0d7377,#14a085); }
.pf-orange { background:linear-gradient(90deg,#c2410c,#ea580c); }
.pf-sky    { background:linear-gradient(90deg,#0369a1,#38bdf8); }

.stat-glow { position:absolute; width:120px; height:120px; border-radius:50%; right:-30px; bottom:-40px; opacity:.06; pointer-events:none; z-index:0; }
.g-green  { background:#10b981; }
.g-teal   { background:#14a085; }
.g-amber  { background:#d97706; }
.g-rose   { background:#e11d48; }
.g-orange { background:#ea580c; }
.g-sky    { background:#38bdf8; }

/* ── Section divider ── */
.section-divider {
    display:flex; align-items:center; gap:10px;
    margin: 6px 0 14px;
}
.sd-line  { flex:1; height:1px; background:#e5e7eb; }
.sd-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; white-space:nowrap; }

/* ── Empty bendahara ── */
.empty-bendahara {
    background:#fff; border-radius:18px; border:1px solid #e8ede9;
    padding:28px; margin-bottom:24px;
    text-align:center; color:#94a3b8;
}
.empty-bendahara i  { font-size:24px; margin-bottom:10px; display:block; }
.empty-bendahara p  { font-size:13px; font-weight:600; margin:0; }

/* ── CHART ── */
.chart-card {
    background:#fff; border-radius:18px;
    border:1px solid #e8ede9;
    box-shadow:0 2px 12px rgba(0,0,0,.05);
    overflow:hidden;
    animation:slideUp .45s .35s ease both;
}
.chart-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:20px 24px 16px; border-bottom:1px solid #f0f4f1;
    flex-wrap:wrap; gap:10px;
}
.chart-title { font-size:1rem; font-weight:700; color:#064e3b; display:flex; align-items:center; gap:7px; margin-bottom:3px; }
.chart-title i { color:#206d31; }
.chart-sub    { font-size:.78rem; color:#94a3b8; }
.chart-legend { display:flex; gap:16px; }
.leg-item { display:flex; align-items:center; gap:6px; font-size:.8rem; font-weight:600; color:#64748b; }
.leg-dot  { width:9px; height:9px; border-radius:50%; }
.ld-blue  { background:#3b82f6; }
.ld-pink  { background:#ec4899; }
.ld-green { background:#064e3b; }
.chart-body { padding:20px 24px 24px; height:320px; }

/* ── RESPONSIVE ── */
@media (max-width:1024px) {
    .sg-4 { grid-template-columns:repeat(2,1fr); }
    .sg-3 { grid-template-columns:repeat(2,1fr); }
    .rt-clock { right:24px; padding:12px 18px; min-width:130px; }
    .rt-clock-time { font-size:1.6rem; }
}

@media (max-width:640px) {
    .dash-wrap  { padding:14px 14px 40px; }
    .dash-hero  { padding:28px 22px 22px; display:flex; flex-direction:column; }
    .hero-title { font-size:1.75rem; }
    .hero-deco  { display:none; }
    .rt-clock {
        position:static; transform:none;
        display:inline-flex; align-items:center; gap:10px;
        margin-top:18px; padding:10px 16px; border-radius:50px;
        min-width:0; width:fit-content; align-self:flex-start;
    }
    .rt-clock-time { font-size:1.15rem; margin-bottom:0; line-height:1; }
    .rt-clock-date { font-size:.62rem; text-align:left; line-height:1.4; }
    .sg-4,.sg-3 { grid-template-columns:1fr 1fr; }
    .sg-2       { grid-template-columns:1fr; }
    .stat-card.wide { flex-direction:column; align-items:flex-start; gap:12px; }
    .stat-card.wide .stat-icon-wrap.large { margin-bottom:0; }
    .stat-val   { font-size:1.9rem; }
    .chart-head { flex-direction:column; align-items:flex-start; }
    .chart-legend { flex-wrap:wrap; gap:10px; }
}

@media (max-width:400px) {
    .sg-4,.sg-3 { grid-template-columns:1fr; }
    .rt-clock   { padding:8px 12px; }
    .rt-clock-time { font-size:1rem; }
    .rt-clock-date { font-size:.58rem; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // ── CHART ──
    const ctx = document.getElementById('chartPengaduan');
    const mkGrad = (c, c1, c2) => {
        const g = c.createLinearGradient(0,0,0,260);
        g.addColorStop(0,c1); g.addColorStop(1,c2); return g;
    };
    const namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    const now = new Date();
    const labels = [];
    for (let i=11;i>=0;i--) {
        const d = new Date(now.getFullYear(), now.getMonth()-i, 1);
        labels.push(namaBulan[d.getMonth()]);
    }
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label:'Diajukan', data:{{ $chartDiajukan }},
                    borderColor:'#3b82f6',
                    backgroundColor:(c)=>mkGrad(c.chart.ctx,'rgba(59,130,246,0.15)','rgba(59,130,246,0)'),
                    borderWidth:2.5, fill:true, tension:.45,
                    pointBackgroundColor:'#3b82f6', pointBorderColor:'#fff',
                    pointBorderWidth:2, pointRadius:4, pointHoverRadius:6
                },
                {
                    label:'Menunggu', data:{{ $chartMenunggu }},
                    borderColor:'#ec4899',
                    backgroundColor:(c)=>mkGrad(c.chart.ctx,'rgba(236,72,153,0.12)','rgba(236,72,153,0)'),
                    borderWidth:2.5, fill:true, tension:.45,
                    pointBackgroundColor:'#ec4899', pointBorderColor:'#fff',
                    pointBorderWidth:2, pointRadius:4, pointHoverRadius:6
                },
                {
                    label:'Selesai', data:{{ $chartSelesai }},
                    borderColor:'#064e3b',
                    backgroundColor:(c)=>mkGrad(c.chart.ctx,'rgba(6,78,59,0.15)','rgba(6,78,59,0)'),
                    borderWidth:2.5, fill:true, tension:.45,
                    pointBackgroundColor:'#064e3b', pointBorderColor:'#fff',
                    pointBorderWidth:2, pointRadius:4, pointHoverRadius:6
                }
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            interaction:{ intersect:false, mode:'index' },
            plugins:{
                legend:{ display:false },
                tooltip:{
                    backgroundColor:'#1a2e22', titleColor:'#94a3b8',
                    bodyColor:'#f8fafc', borderColor:'rgba(255,255,255,0.08)',
                    borderWidth:1, padding:11, cornerRadius:10, boxPadding:5
                }
            },
            scales:{
                x:{ grid:{color:'rgba(0,0,0,0.04)'}, ticks:{font:{family:"'Plus Jakarta Sans'",size:11,weight:'600'},color:'#94a3b8'} },
                y:{ grid:{color:'rgba(0,0,0,0.04)'}, ticks:{font:{family:"'Plus Jakarta Sans'",size:11},color:'#94a3b8',stepSize:1}, beginAtZero:true }
            }
        }
    });

    // ── CLOCK ──
    function updateRtClock() {
        const n = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const pad = v => String(v).padStart(2,'0');
        const t = document.getElementById('rt-clock-time');
        const d = document.getElementById('rt-clock-date');
        if (t) t.innerHTML = `${pad(n.getHours())}<span class="rt-clock-colon">:</span>${pad(n.getMinutes())}<span class="rt-clock-colon">:</span>${pad(n.getSeconds())}`;
        if (d) d.textContent = `${days[n.getDay()]}, ${pad(n.getDate())} ${months[n.getMonth()]} ${n.getFullYear()}`;
    }
    updateRtClock();
    setInterval(updateRtClock, 1000);
});
</script>

@endsection

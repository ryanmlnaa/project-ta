@extends('layouts.app')

@section('content')

{{-- ============================================================
     FILE: resources/views/admin/dashboard.blade.php
============================================================ --}}

<style>
body { background: #f0f4f8 !important; }

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 24px;
    flex-wrap: wrap;
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

/* ── CLOCK WIDGET ── */
.admin-clock {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border-radius: 14px;
    padding: 12px 20px;
    box-shadow: 0 4px 16px rgba(6,78,59,0.25);
    flex-shrink: 0;
}

.admin-clock-icon {
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.15);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 15px;
    flex-shrink: 0;
}

.admin-clock-info {
    text-align: left;
}

.admin-clock-time {
    font-size: 1.3rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.04em;
    line-height: 1;
    margin-bottom: 3px;
}

.admin-clock-colon {
    animation: adminBlink 1s step-end infinite;
    display: inline-block;
}

@keyframes adminBlink {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0; }
}

.admin-clock-date {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* ── STATS ── */
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
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    animation: fadeUp 0.35s ease;
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.stat-card-left .stat-label {
    font-size: 12.5px;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 4px;
}

.stat-card-left .stat-value {
    font-size: 26px;
    font-weight: 800;
    color: #111827;
    margin: 0;
    line-height: 1.1;
}

.stat-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    color: #fff;
}

.icon-blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.icon-green  { background: linear-gradient(135deg, #064e3b, #0d6e4f); }
.icon-yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
.icon-red    { background: linear-gradient(135deg, #ef4444, #dc2626); }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── BOTTOM GRID ── */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 16px;
}

.card-box {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 22px 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    animation: fadeUp 0.4s ease;
}

.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.chart-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.chart-filter {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12.5px;
    font-weight: 600;
    color: #374151;
    background: #f9fafb;
    outline: none;
    cursor: pointer;
    transition: all 0.15s;
}

.chart-filter:focus {
    border-color: #064e3b;
    box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
}

.info-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.info-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.info-desc {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 20px;
}

.info-divider {
    border: none;
    border-top: 1px solid #f3f4f6;
    margin: 16px 0;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0 0 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.info-list li {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #374151;
    font-weight: 500;
}

.info-check {
    width: 20px;
    height: 20px;
    background: #d1fae5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #064e3b;
    font-size: 10px;
    flex-shrink: 0;
}

.btn-laporan {
    background: linear-gradient(135deg, #064e3b, #0d6e4f);
    border: none;
    color: #ffffff;
    width: 100%;
    padding: 11px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: all 0.15s ease;
    box-shadow: 0 3px 10px rgba(6,78,59,0.3);
}

.btn-laporan:hover {
    opacity: 0.9;
    color: #fff;
    transform: translateY(-1px);
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .stats-grid    { grid-template-columns: repeat(2, 1fr); }
    .bottom-grid   { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .admin-clock {
        width: 100%;
        justify-content: flex-start;
        border-radius: 12px;
        padding: 10px 16px;
    }
    .admin-clock-time { font-size: 1.15rem; }
    .admin-clock-date { font-size: 0.62rem; }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
    .stat-card  { padding: 14px 16px; }
    .stat-card-left .stat-value { font-size: 20px; }
    .page-title { font-size: 18px; }
    .chart-header { flex-wrap: wrap; gap: 10px; }
}

@media (max-width: 400px) {
    .stats-grid { grid-template-columns: 1fr; }
    .admin-clock-time { font-size: 1rem; }
}
</style>

<div class="container-fluid" style="padding: 20px 16px;">

    {{-- PAGE HEADER + CLOCK --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <div>
                <h1 class="page-title">Dashboard Admin</h1>
                <p class="page-subtitle">Ringkasan data dan statistik sistem</p>
            </div>
        </div>

        {{-- CLOCK WIDGET --}}
        <div class="admin-clock">
            <div class="admin-clock-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="admin-clock-info">
                <div class="admin-clock-time" id="admin-clock-time">00:00:00</div>
                <div class="admin-clock-date" id="admin-clock-date">Memuat...</div>
            </div>
        </div>
    </div>

    {{-- STATS GRID --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-card-left">
                <p class="stat-label">Penghuni</p>
                <p class="stat-value">{{ $totalPenghuni }}</p>
            </div>
            <div class="stat-icon-wrap icon-blue">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <p class="stat-label">Rumah</p>
                <p class="stat-value">{{ $totalRumah }}</p>
            </div>
            <div class="stat-icon-wrap icon-green">
                <i class="fas fa-home"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <p class="stat-label">Pengaduan</p>
                <p class="stat-value">{{ $totalPengaduan }}</p>
            </div>
            <div class="stat-icon-wrap icon-yellow">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-left">
                <p class="stat-label">Administrasi Iuran</p>
                <p class="stat-value" style="font-size:18px;">Rp {{ number_format($totalIuran, 0, ',', '.') }}</p>
            </div>
            <div class="stat-icon-wrap icon-red">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>

    </div>

    {{-- BOTTOM GRID --}}
    <div class="bottom-grid">

        <div class="card-box">
            <div class="chart-header">
                <p class="chart-title">
                    <i class="fas fa-chart-line" style="color:#064e3b;"></i>
                    Statistik Pengaduan
                </p>
                <select id="filterChart" class="chart-filter">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan" selected>Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                </select>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="chartAdmin"></canvas>
            </div>
        </div>

        <div class="card-box">
            <div class="info-card">
                <div>
                    <p class="info-title">
                        <i class="fas fa-info-circle" style="color:#064e3b;"></i>
                        Informasi
                    </p>
                    <p class="info-desc">
                        Sistem membantu pengelolaan penghuni, rumah, dan pengaduan secara efisien.
                    </p>

                    <hr class="info-divider">

                    <ul class="info-list">
                        <li><span class="info-check"><i class="fas fa-check"></i></span> Data Penghuni</li>
                        <li><span class="info-check"><i class="fas fa-check"></i></span> Data Rumah</li>
                        <li><span class="info-check"><i class="fas fa-check"></i></span> Pengaduan Warga</li>
                        <li><span class="info-check"><i class="fas fa-check"></i></span> Administrasi Iuran</li>
                        <li><span class="info-check"><i class="fas fa-check"></i></span> Laporan Bulanan</li>
                    </ul>
                </div>

                <a href="{{ route('laporan.index') }}" class="btn-laporan">
                    <i class="fas fa-file-alt" style="margin-right:6px;"></i> Lihat Laporan
                </a>
            </div>
        </div>

    </div>

</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ── CHART ──
    const canvas = document.getElementById('chartAdmin');
    const filter = document.getElementById('filterChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    let dataSets = {
        harian:   @json($chartHarian),
        mingguan: @json($chartMingguan),
        bulanan:  @json($chartBulanan),
        tahunan:  @json($chartTahunan)
    };

    if (!dataSets.harian.length)   dataSets.harian   = [1,2,3,2,4,3,5];
    if (!dataSets.mingguan.length) dataSets.mingguan = [5,10,7,12];
    if (!dataSets.bulanan.length)  dataSets.bulanan  = [0,0,0,7,0,0,0,0,0,0,0,0];
    if (!dataSets.tahunan.length)  dataSets.tahunan  = [50,70,40,90];

    const labelsSets = {
        harian: [...Array(7).keys()].map(i => {
            let d = new Date();
            d.setDate(d.getDate() - (6 - i));
            return d.toLocaleDateString('id-ID', { weekday: 'short' });
        }),
        mingguan: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4'],
        bulanan:  ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        tahunan:  [
            new Date().getFullYear() - 3,
            new Date().getFullYear() - 2,
            new Date().getFullYear() - 1,
            new Date().getFullYear()
        ]
    };

    let chart;

    function renderChart(type) {
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsSets[type],
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: dataSets[type],
                    borderColor: '#064e3b',
                    backgroundColor: 'rgba(6,78,59,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#064e3b',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#f9fafb',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: { grid: { color: '#f3f4f6' }, ticks: { color: '#6b7280', font: { size: 12 } } },
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { color: '#6b7280', font: { size: 12 }, stepSize: 1 } }
                }
            }
        });
    }

    renderChart('bulanan');
    if (filter) filter.addEventListener('change', function () { renderChart(this.value); });

    // ── CLOCK ADMIN ──
    function updateAdminClock() {
        const now    = new Date();
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        const hari  = days[now.getDay()];
        const tgl   = String(now.getDate()).padStart(2, '0');
        const bln   = months[now.getMonth()];
        const thn   = now.getFullYear();
        const jam   = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');

        const timeEl = document.getElementById('admin-clock-time');
        if (timeEl) {
            timeEl.innerHTML =
                `${jam}<span class="admin-clock-colon">:</span>${menit}<span class="admin-clock-colon">:</span>${detik}`;
        }

        const dateEl = document.getElementById('admin-clock-date');
        if (dateEl) {
            dateEl.textContent = `${hari}, ${tgl} ${bln} ${thn}`;
        }
    }

    updateAdminClock();
    setInterval(updateAdminClock, 1000);
});
</script>

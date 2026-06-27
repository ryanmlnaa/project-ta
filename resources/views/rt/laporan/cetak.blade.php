<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan RT - {{ now()->format('M Y') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #1a1a1a; padding: 20px; }

        .header { text-align: center; border-bottom: 3px solid #064e3b; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: 800; color: #064e3b; }
        .header p  { font-size: 12px; color: #64748b; margin-top: 4px; }

        .info-box { display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap; }
        .info-item { flex: 1; min-width: 100px; background: #f0fdf4; border: 1px solid #a7f3d0; border-radius: 8px; padding: 10px 12px; }
        .info-item label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 700; display: block; }
        .info-item p { font-size: 15px; font-weight: 800; color: #064e3b; margin-top: 2px; }

        .section-title { font-size: 13px; font-weight: 800; color: #064e3b; border-left: 4px solid #059669; padding-left: 10px; margin: 20px 0 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #064e3b; color: #fff; padding: 8px 10px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #e2e8e2; font-size: 11px; }
        tr:nth-child(even) td { background: #f8fdf8; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .badge-selesai  { background: #dcfce7; color: #15803d; }
        .badge-diproses { background: #fef3c7; color: #a16207; }
        .badge-diajukan { background: #dbeafe; color: #1d4ed8; }
        .badge-lunas    { background: #dcfce7; color: #15803d; }
        .badge-menunggu { background: #fef3c7; color: #a16207; }
        .badge-masuk    { background: #dcfce7; color: #15803d; }
        .badge-keluar   { background: #fee2e2; color: #b91c1c; }

        .total-row td { font-weight: 800; background: #f0fdf4 !important; color: #064e3b; border-top: 2px solid #a7f3d0; }

        .footer { border-top: 1px solid #e2e8e2; margin-top: 30px; padding-top: 12px; display: flex; justify-content: space-between; font-size: 10px; color: #94a3b8; }

        .ttd-box { display: flex; justify-content: flex-end; margin-top: 30px; }
        .ttd-item { text-align: center; min-width: 180px; }
        .ttd-item .ttd-line { margin-top: 60px; border-top: 1px solid #333; padding-top: 4px; font-size: 11px; font-weight: 700; }
        .ttd-item .ttd-label { font-size: 10px; color: #64748b; }

        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>🏡 GREEN VIEW RESIDENCE — Laporan RT</h1>
        <p>
            Periode:
            {{ ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$bulan] }}
            {{ $tahun }}
        </p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }} &nbsp;·&nbsp; RT: {{ $user->name }}</p>
    </div>

    {{-- RINGKASAN --}}
    <div class="info-box">
        <div class="info-item">
            <label>Total Rumah</label>
            <p>{{ $totalRumah ?? 0 }}</p>
        </div>
        <div class="info-item">
            <label>Total Penghuni</label>
            <p>{{ $totalPenghuni ?? 0 }}</p>
        </div>
        <div class="info-item">
            <label>Total Iuran</label>
            <p>Rp {{ number_format($totalIuran ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="info-item">
            <label>Saldo Kas</label>
            <p>Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="info-item">
            <label>Pengaduan Selesai</label>
            <p>{{ $sukses ?? 0 }}</p>
        </div>
        <div class="info-item">
            <label>Pengaduan Masuk</label>
            <p>{{ isset($dataPengaduan) ? $dataPengaduan->count() : 0 }}</p>
        </div>
    </div>

    {{-- DATA IURAN --}}
    <div class="section-title">💰 Data Iuran</div>
    @if(isset($dataIuran) && $dataIuran->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Penghuni</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataIuran as $i => $iuran)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $iuran->penghuni->nama ?? '-' }}</td>
                <td>{{ ucfirst($iuran->jenis ?? '-') }}</td>
                <td>Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}</td>
                <td><span class="badge badge-{{ $iuran->status }}">{{ ucfirst($iuran->status) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($iuran->created_at)->format('d M Y') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>Rp {{ number_format($dataIuran->sum('jumlah'), 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
    @else
    <p style="color:#94a3b8;font-size:12px;margin-bottom:16px;">Tidak ada data iuran periode ini.</p>
    @endif

    {{-- DATA KAS BENDAHARA --}}
    <div class="section-title">🏦 Riwayat Kas Bendahara</div>
    @if(isset($dataKas) && $dataKas->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataKas as $i => $kas)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($kas->created_at)->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $kas->jenis }}">{{ ucfirst($kas->jenis) }}</span></td>
                <td>{{ $kas->keterangan ?? '-' }}</td>
                <td>Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4">Saldo Akhir</td>
                <td>Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @else
    <p style="color:#94a3b8;font-size:12px;margin-bottom:16px;">Tidak ada data kas periode ini.</p>
    @endif

    {{-- DATA PENGADUAN --}}
    <div class="section-title">📢 Data Pengaduan</div>
    @if(isset($dataPengaduan) && $dataPengaduan->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Penghuni</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPengaduan as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->penghuni->nama ?? '-' }}</td>
                <td>{{ ucfirst($p->kategori_masalah ?? '-') }}</td>
                <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="color:#94a3b8;font-size:12px;margin-bottom:16px;">Tidak ada pengaduan periode ini.</p>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="ttd-box">
        <div class="ttd-item">
            <div class="ttd-label">Mengetahui,</div>
            <div class="ttd-line">{{ $user->name }}</div>
            <div class="ttd-label">Ketua RT</div>
        </div>
    </div>

    <div class="footer">
        <span>Green View RT Management System</span>
        <span>Dicetak {{ now()->format('d M Y H:i') }}</span>
    </div>

    <script>window.onload = function(){ window.print(); }</script>

</body>
</html>

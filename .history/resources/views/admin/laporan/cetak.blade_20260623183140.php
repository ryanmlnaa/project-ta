<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Admin - {{ now()->format('M Y') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #1a1a1a; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #1e3a5f; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: 800; color: #1e3a5f; }
        .header p { font-size: 12px; color: #64748b; margin-top: 4px; }
        .info-box { display: flex; gap: 20px; margin-bottom: 20px; }
        .info-item { flex: 1; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px; }
        .info-item label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 700; }
        .info-item p { font-size: 15px; font-weight: 800; color: #1e3a5f; margin-top: 2px; }
        .section-title { font-size: 13px; font-weight: 800; color: #1e3a5f; border-left: 4px solid #2563eb; padding-left: 10px; margin: 20px 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1e3a5f; color: #fff; padding: 8px 10px; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #e8ede9; font-size: 11px; }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .badge-selesai  { background: #dcfce7; color: #15803d; }
        .badge-diajukan { background: #fef3c7; color: #a16207; }
        .badge-menunggu { background: #dbeafe; color: #1d4ed8; }
        .footer { border-top: 1px solid #e8ede9; margin-top: 30px; padding-top: 12px; display: flex; justify-content: space-between; font-size: 10px; color: #94a3b8; }
        @media print { body { padding: 10px; } }
    </style>
</head>
<body>

    <div class="header">
        <h1>🏛️ GREEN VIEW — Laporan Admin</h1>
        <p>Periode: {{ ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$bulan] }} {{ $tahun }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }} &nbsp;·&nbsp; Admin: {{ $user->name }}</p>
    </div>

    <div class="info-box">
        <div class="info-item">
            <label>Total Pengaduan</label>
            <p>{{ $dataPengaduan->count() }}</p>
        </div>
        <div class="info-item">
            <label>Selesai</label>
            <p>{{ $sukses }}</p>
        </div>
        <div class="info-item">
            <label>Menunggu</label>
            <p>{{ $dataPengaduan->where('status','menunggu')->count() }}</p>
        </div>
        <div class="info-item">
            <label>Diajukan</label>
            <p>{{ $gagal }}</p>
        </div>
    </div>

    <div class="section-title">📢 Data Pengaduan</div>
    @if($dataPengaduan->count() > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Penghuni</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataPengaduan as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->penghuni->nama ?? '-' }}</td>
                <td>{{ $p->judul ?? $p->pesan ?? '-' }}</td>
                <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                <td>{{ $p->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="color:#94a3b8;font-size:12px;">Tidak ada pengaduan periode ini.</p>
    @endif

    <div class="footer">
        <span>Green View RT Management System</span>
        <span>Dicetak {{ now()->format('d M Y H:i') }}</span>
    </div>

    <script>window.onload = function(){ window.print(); }</script>
</body>
</html>

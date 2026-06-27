<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengaduan Selesai</title>
</head>
<body style="font-family:Arial,sans-serif;background-color:#f4f6f9;padding:20px;margin:0;">
<div style="max-width:600px;margin:auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.1);">

    <!-- HEADER -->
    <div style="background:linear-gradient(135deg,#064e3b,#059669);color:white;padding:24px;text-align:center;">
        <h2 style="margin:0;font-size:20px;">🏡 GREEN VIEW RESIDENCE</h2>
        <small style="opacity:0.85;">Sistem Informasi Perumahan</small>
    </div>

    <!-- CONTENT -->
    <div style="padding:28px 24px;">

        <div style="text-align:center;margin-bottom:20px;">
            <div style="width:64px;height:64px;background:#d1fae5;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:28px;margin-bottom:10px;">✅</div>
            <h3 style="margin:0;color:#064e3b;font-size:18px;">Pengaduan Telah Selesai Ditangani</h3>
        </div>

        <p style="color:#555;font-size:14px;">
            Halo, <b>{{ $layanan->penghuni->nama ?? 'Penghuni' }}</b> 👋
        </p>

        <p style="color:#555;font-size:14px;">
            Kami dengan senang hati memberitahukan bahwa pengaduan Anda telah <b>selesai ditangani</b> oleh RT.
        </p>

        <!-- STATUS BOX -->
        <div style="margin:16px 0;padding:14px 16px;border-radius:10px;background:#d1fae5;color:#064e3b;border-left:4px solid #059669;">
            <b>✅ Status: SELESAI</b>
        </div>

        <!-- KETERANGAN SELESAI -->
        @if($layanan->catatan_selesai ?? null)
        <div style="margin:16px 0;">
            <b style="color:#333;font-size:14px;">📋 Keterangan Penyelesaian dari RT:</b>
            <div style="margin-top:8px;padding:14px;background:#f8f9fa;border-left:4px solid #059669;border-radius:6px;font-size:13.5px;color:#333;line-height:1.6;">
                {{ $layanan->catatan_selesai }}
            </div>
        </div>
        @endif

        <!-- FOTO BUKTI -->
        @if($layanan->foto_bukti_rt ?? null)
        <div style="margin:16px 0;">
            <b style="color:#333;font-size:14px;">📸 Foto Bukti Penyelesaian:</b>
            <div style="margin-top:10px;text-align:center;">
                <img src="{{ asset('storage/'.$layanan->foto_bukti_rt) }}"
                     alt="Bukti Selesai"
                     style="max-width:100%;border-radius:10px;border:1px solid #e0e0e0;">
            </div>
        </div>
        @endif

        <p style="color:#555;font-size:13.5px;margin-top:20px;">
            Silakan buka aplikasi untuk melihat detail lengkap beserta bukti penyelesaian.
        </p>

        <!-- BUTTON -->
        <div style="text-align:center;margin:20px 0;">
            <a href="{{ url('/') }}"
               style="background:linear-gradient(135deg,#064e3b,#059669);color:white;padding:12px 28px;text-decoration:none;border-radius:10px;font-weight:700;font-size:14px;">
                🔍 Buka Aplikasi
            </a>
        </div>

    </div>

    <!-- FOOTER -->
    <div style="background:#f1f1f1;padding:14px;text-align:center;font-size:12px;color:#777;">
        © {{ date('Y') }} Green View Residence — Sistem Manajemen Perumahan
    </div>

</div>
</body>
</html>

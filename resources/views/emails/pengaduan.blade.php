<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Pengaduan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;">

<div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

    <!-- HEADER -->
    <div style="background: #28a745; color: white; padding: 15px; text-align: center;">
        <h2 style="margin: 0;">🏡 GREEN VIEW</h2>
        <small>Sistem Informasi Perumahan</small>
    </div>

    <!-- CONTENT -->
    <div style="padding: 20px;">

        <h3 style="margin-top: 0; color: #333;">
            📢 Pengaduan Anda Telah Ditanggapi
        </h3>

        <p style="color: #555;">
            Halo, <b>{{ $layanan->penghuni->nama ?? 'Penghuni' }}</b> 👋
        </p>

        <p style="color: #555;">
            Pengaduan yang Anda kirim telah mendapatkan tanggapan dari admin.
        </p>

        <!-- STATUS BOX -->
        <div style="margin: 15px 0; padding: 10px; border-radius: 6px;
            background:
            @if($layanan->status == 'selesai') #d4edda
            @else #fff3cd @endif;
            color:
            @if($layanan->status == 'selesai') #155724
            @else #856404 @endif;">

            <b>Status:</b>
            {{ ucfirst($layanan->status) }}
        </div>

        <!-- TANGGAPAN -->
        <div style="margin: 15px 0;">
            <b style="color:#333;">💬 Tanggapan Admin:</b>
            <div style="margin-top: 8px; padding: 12px; background:#f8f9fa; border-left: 4px solid #28a745; border-radius:5px;">
                {{ $layanan->tanggapan_admin }}
            </div>
        </div>

        <!-- INFO -->
        <p style="color:#555;">
            Silakan cek aplikasi untuk informasi lebih lanjut.
        </p>

        <!-- BUTTON -->
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/') }}"
               style="background:#28a745; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">
                🔍 Buka Aplikasi
            </a>
        </div>

    </div>

    <!-- FOOTER -->
    <div style="background:#f1f1f1; padding:10px; text-align:center; font-size:12px; color:#777;">
        © {{ date('Y') }} Green View - Sistem Manajemen Perumahan
    </div>

</div>

</body>
</html>

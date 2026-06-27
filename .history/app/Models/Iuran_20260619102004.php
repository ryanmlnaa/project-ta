<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    protected $table = 'iuran';

    protected $fillable = [
        'penghuni_id',
        'rt_id',
        'bulan',
        'tahun',
        'jumlah',
        'jenis_iuran',
        'keterangan',
        'status',
        'tanggal_bayar',
        'bukti_pembayaran',
        'dibuat_oleh',  // tambah
        'catatan_rt',   // tambah
        'rekap_id',     // tambah
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    // Relasi lama (tetap)
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }

    // Relasi baru
    public function bendahara()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function rekap()
    {
        return $this->belongsTo(RekapIuran::class, 'rekap_id');
    }
}jj

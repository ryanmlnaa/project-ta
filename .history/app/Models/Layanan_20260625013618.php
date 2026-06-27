<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'penghuni_id',
        'tanggal_pengaduan',
        'kategori_masalah',
        'deskripsi',
        'foto',
        'foto_bukti_rt',
        'catatan_selesai',
        'status',
        'tanggapan_admin',
    ];

    public function penghuni()
    {
        return $this->belongsTo(\App\Models\Penghuni::class);
    }
}

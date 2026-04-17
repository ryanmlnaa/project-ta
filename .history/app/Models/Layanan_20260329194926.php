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
        'status',
        'tanggapan_admin',
        'tanggal_tanggapan'
    ];

    // =========================
    // RELASI KE PENGHUNI
    // =========================
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}

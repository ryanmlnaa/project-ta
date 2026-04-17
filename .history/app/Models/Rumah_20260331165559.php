<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penghuni;

class Rumah extends Model
{
    use HasFactory;

    protected $table = 'rumah';

    protected $fillable = [
        'blok',
        'no_rumah',
        'status',
        'luas_tanah',
        'harga',
        'gambar',
        'keterangan',
        'foto'
        // 'denah', // 🔥 TAMBAHAN UNTUK DENAH
    ];

    // =========================
    // RELASI KE PENGHUNI (UPDATED)
    // =========================
    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'rumah_id', 'id');
    }
}

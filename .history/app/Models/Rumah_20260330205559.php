<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    // =========================
    // RELASI KE PENGHUNI
    // =========================
    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'no_rumah', 'no_rumah');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';

    protected $fillable = [
        'nama',
        'no_ktp',
        'email',
        'telepon',
        'alamat',
        'rumah_id',
        'blok_rumah',
        'no_rumah',
        'status',
        'status_huni',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    // 🔥 RELASI KE RUMAH
    public function rumah()
    {
        return $this->belongsTo(\App\Models\Rumah::class, 'rumah_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'email', 'email');
    }

    public function layanan()
    {
        return $this->hasMany(\App\Models\Layanan::class);
    }
}


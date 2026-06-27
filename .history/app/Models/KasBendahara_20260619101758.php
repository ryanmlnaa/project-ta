<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasBendahara extends Model
{
    protected $table = 'kas_bendahara';

    protected $fillable = [
        'bendahara_id',
        'rt_id',
        'jenis',
        'jumlah',
        'keterangan',
        'iuran_id',
    ];

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'bendahara_id');
    }

    public function iuran()
    {
        return $this->belongsTo(Iuran::class, 'iuran_id');
    }
}

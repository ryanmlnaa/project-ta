<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapIuran extends Model
{
    protected $table = 'rekap_iuran';

    protected $fillable = [
        'bendahara_id',
        'rt_id',
        'periode',
        'status',
        'catatan_rt',
    ];

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'bendahara_id');
    }

    public function rt()
    {
        return $this->belongsTo(User::class, 'rt_id');
    }

    public function iurans()
    {
        return $this->hasMany(Iuran::class, 'rekap_id');
    }
}

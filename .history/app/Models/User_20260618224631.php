<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'rt_id',
        'status_akun',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Bendahara milik RT mana
    public function rt()
    {
        return $this->belongsTo(User::class, 'rt_id');
    }

    // RT punya banyak bendahara
    public function bendaharas()
    {
        return $this->hasMany(User::class, 'rt_id')->where('role', 'bendahara');
    }

    // Bendahara aktif milik RT ini
    public function bendaharaAktif()
    {
        return $this->hasOne(User::class, 'rt_id')
                    ->where('role', 'bendahara')
                    ->where('status_akun', 'aktif');
    }
}

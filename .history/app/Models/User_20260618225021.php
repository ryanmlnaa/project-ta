<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'photo',
        'rt_id',        // tambah
        'status_akun',  // tambah
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi lama (tetap)
    public function penghuni()
    {
        return $this->hasOne(\App\Models\Penghuni::class, 'email', 'email');
    }

    public function rumahs()
    {
        return $this->hasMany(\App\Models\Rumah::class, 'rt_id');
    }

    // Relasi baru
    public function rt()
    {
        return $this->belongsTo(User::class, 'rt_id');
    }

    public function bendaharas()
    {
        return $this->hasMany(User::class, 'rt_id')->where('role', 'bendahara');
    }

    public function bendaharaAktif()
    {
        return $this->hasOne(User::class, 'rt_id')
                    ->where('role', 'bendahara')
                    ->where('status_akun', 'aktif');
    }
}

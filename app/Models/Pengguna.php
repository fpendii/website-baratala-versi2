<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function laporanJobdesks()
    {
        return $this->hasMany(LaporanJobdesk::class, 'id_pengguna');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_pengguna');
    }

    public function laporanKeuangans()
    {
        return $this->hasMany(LaporanKeuangan::class, 'id_pengguna');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_pengguna');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'id_pengguna',
        'judul_rencana',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'jenis',
        'prioritas',
        'lampiran',
        'catatan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}

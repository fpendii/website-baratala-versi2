<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuangan';

    protected $fillable = [
        'id_keuangan',
        'id_pengguna',
        'tanggal',
        'tipe',
        'nominal',
        'deskripsi',
        'bukti_transaksi',
        'metode_pembayaran',
    ];

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'id_keuangan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_laporan_keuangan');
    }
}

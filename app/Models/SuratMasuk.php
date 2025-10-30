<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'id_pengguna',
        'judul',
        'pengirim',
        'nomor_surat',
        'tanggal_terima',
        'lampiran',
        'prioritas',
        'keterangan',
    ];
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanKeuangan;
use App\Models\Pengguna;
use App\Models\Keuangan;

class LaporanKeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengguna = Pengguna::where('email', 'admin@example.com')->first();
        $keuangan = Keuangan::first();
        if ($pengguna && $keuangan) {
            LaporanKeuangan::create([
                'id_keuangan' => $keuangan->id,
                'id_pengguna' => $pengguna->id,
                'tanggal' => '2025-09-17',
                'tipe' => 'pengeluaran',
                'nominal' => 500000.00,
                'deskripsi' => 'Pembelian suku cadang mesin.',
                'bukti_transaksi' => 'bukti_transaksi_01.jpg',
                'metode_pembayaran' => 'transfer bank',
            ]);
        }
    }
}

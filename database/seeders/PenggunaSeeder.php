<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengguna::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'alamat' => 'Jalan Kenangan No. 1, Jakarta',
            'role' => 'admin',
        ]);

        Pengguna::create([
            'nama' => 'Karyawan Biasa',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'alamat' => 'Jalan Suka-suka No. 2, Bandung',
            'role' => 'karyawan',
        ]);

        Pengguna::create([
            'nama' => 'Kepala Teknik',
            'email' => 'kepalatenik@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'alamat' => 'Jalan Lurus No. 3, Surabaya',
            'role' => 'kepala teknik',
        ]);

        Pengguna::create([
            'nama' => 'Direktur',
            'email' => 'direktur@example.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567893',
            'alamat' => 'Jalan Rame No. 4, Jakarta',
            'role' => 'direktur',
        ]);
    }
}

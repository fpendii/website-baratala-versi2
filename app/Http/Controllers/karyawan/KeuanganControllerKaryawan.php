<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use App\Models\Pengguna;
use App\Models\User;

class KeuanganControllerKaryawan extends Controller
{
    public function index(){
        $laporanKeuangan = LaporanKeuangan::with('pengguna')->latest()->get();

        // Hitung ringkasan sederhana
        $totalPendapatan = $laporanKeuangan->where('tipe', 'pendapatan')->sum('nominal');
        $totalPengeluaran = $laporanKeuangan->where('tipe', 'pengeluaran')->sum('nominal');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        return view('karyawan.keuangan.index', compact(
            'laporanKeuangan',
            'totalPendapatan',
            'totalPengeluaran',
            'labaBersih'
        ));
    }

    public function createPengeluaran(){

        $daftarKaryawan = Pengguna::get();

        return view('karyawan.keuangan.create-pengeluaran', compact('daftarKaryawan'));
    }

    public function createKasbon(){

         $daftarKaryawan = Pengguna::get();

        return view('karyawan.keuangan.create-kasbon', compact('daftarKaryawan'));
    }
}

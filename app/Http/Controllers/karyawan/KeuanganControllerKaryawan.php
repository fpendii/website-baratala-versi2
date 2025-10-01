<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;

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
}

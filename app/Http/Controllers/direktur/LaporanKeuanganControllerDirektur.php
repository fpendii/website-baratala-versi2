<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuangan;

class LaporanKeuanganControllerDirektur extends Controller
{
    public function index()
    {
        // Ambil semua laporan keuangan (bisa ditambah pagination kalau banyak)
        $laporanKeuangan = LaporanKeuangan::with('pengguna')->latest()->get();

        // Hitung ringkasan sederhana
        $totalPendapatan = $laporanKeuangan->where('tipe', 'pendapatan')->sum('nominal');
        $totalPengeluaran = $laporanKeuangan->where('tipe', 'pengeluaran')->sum('nominal');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        return view('direktur.laporan_keuangan.index', compact(
            'laporanKeuangan',
            'totalPendapatan',
            'totalPengeluaran',
            'labaBersih'
        ));
    }
}

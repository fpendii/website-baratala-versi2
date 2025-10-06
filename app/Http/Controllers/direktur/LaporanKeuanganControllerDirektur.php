<?php

namespace App\Http\Controllers\Direktur;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LaporanKeuanganControllerDirektur extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanKeuangan::with('pengguna');

        // Filter bulan/tanggal
        if ($request->filled('filter_tanggal')) {
            $query->whereYear('tanggal', substr($request->filter_tanggal, 0, 4))
                ->whereMonth('tanggal', substr($request->filter_tanggal, 5, 2));
        }

        // Filter jenis
        if ($request->filled('filter_jenis')) {
            $query->where('jenis', $request->filter_jenis);
        }

        // Filter pengguna
        if ($request->filled('filter_pengguna')) {
            $query->where('id_pengguna', $request->filter_pengguna);
        }

        $laporanKeuangan = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();


        $uangKas = Keuangan::first();
        $uangKeluar = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $uangMasuk = LaporanKeuangan::where('jenis', 'uang_masuk')->sum('nominal');
        $daftarKaryawan = Pengguna::all();

        return view('direktur.laporan_keuangan.index', compact('laporanKeuangan', 'uangKeluar', 'uangKas', 'daftarKaryawan', 'uangMasuk'));
    }

    public function persetujuan($id)
    {
        $laporan = LaporanKeuangan::with('pengguna')->findOrFail($id);
        return view('direktur.laporan_keuangan.persetujuan', compact('laporan'));
    }
}

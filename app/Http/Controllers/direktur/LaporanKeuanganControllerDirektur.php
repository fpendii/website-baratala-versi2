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

    public function persetujuan(Request $request, $id)
    {
        $laporan = LaporanKeuangan::with('pengguna', 'penerimaRelasi')->findOrFail($id);
        // Ubah status persetujuan_direktur menjadi true
        return view('direktur.laporan_keuangan.persetujuan', compact('laporan'));
    }

    public function updatePersetujuan(Request $request, $id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);


        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Update status persetujuan_direktur
            if ($request->persetujuan === 'disetujui') {
                $laporan->status_persetujuan = 'disetujui';

                // Jika disetujui, update uang kas
                $keuangan = Keuangan::first();
                if ($keuangan->nominal < $laporan->nominal) {
                    return back()->with('error', 'Saldo kas tidak mencukupi untuk pengeluaran ini.');
                }
                $keuangan->nominal -= $laporan->nominal;
                $keuangan->save();
            } else {
                $laporan->status_persetujuan = 'ditolak';
            }
            $laporan->catatan = $request->catatan;
            $laporan->save();

            // Commit transaksi
            DB::commit();

            return redirect()->route('direktur.keuangan-laporan.index')->with('success', 'Persetujuan laporan keuangan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            Log::error('Error updating laporan keuangan approval: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui persetujuan laporan keuangan.');
        }
    }
}

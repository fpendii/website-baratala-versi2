<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KeuanganControllerKaryawan extends Controller
{
    public function index()
    {
        $uangKas = Keuangan::first();
        $uangKeluar = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $laporanKeuangan = LaporanKeuangan::get();
        return view('karyawan.keuangan.index', compact(
            'laporanKeuangan',
            'uangKeluar',
            'uangKas'
        ));
    }

    public function createPengeluaran()
    {

        $daftarKaryawan = Pengguna::get();

        return view('karyawan.keuangan.create-pengeluaran', compact('daftarKaryawan'));
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
            'lampiran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status_persetujuan' => 'required',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);

        DB::beginTransaction();
        try {
            $pengeluaran = new LaporanKeuangan();
            $pengeluaran->id_keuangan = Keuangan::first()->id;
            $pengeluaran->id_pengguna = 1; // nanti bisa diganti auth()->id()
            $pengeluaran->tanggal = $request->tanggal;
            $pengeluaran->keperluan = $request->keperluan;
            $pengeluaran->nominal = $nominal;
            $pengeluaran->penerima = $request->penerima;
            $pengeluaran->jenis = 'pengeluaran';
            $pengeluaran->jenis_uang = $request->jenis_uang;
            $pengeluaran->persetujuan_direktur = $request->status_persetujuan;

            // Upload lampiran
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/lampiran'), $filename);
                $pengeluaran->lampiran = $filename;
            }

            // Kurangi sisa uang kas
            $uangKas = Keuangan::first();
            if ($uangKas->nominal < $nominal) {
                throw new \Exception('Saldo kas tidak mencukupi!');
            }
            $uangKas->nominal -= $nominal;
            $uangKas->save();

            $pengeluaran->save();

            DB::commit();

            return redirect()->to('/karyawan/keuangan')->with('success', 'Pengeluaran kas berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pengeluaran: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }



    public function createKasbon()
    {

        $daftarKaryawan = Pengguna::get();

        return view('karyawan.keuangan.create-kasbon', compact('daftarKaryawan'));
    }
}

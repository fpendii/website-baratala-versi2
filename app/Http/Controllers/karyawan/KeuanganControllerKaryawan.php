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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeuanganControllerKaryawan extends Controller
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

        return view('karyawan.keuangan.index', compact('laporanKeuangan', 'uangKeluar', 'uangKas', 'daftarKaryawan', 'uangMasuk'));
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
            'persetujuan_direktur' => 'required',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);

        DB::beginTransaction();
        try {
            $pengeluaran = new LaporanKeuangan();
            $pengeluaran->id_keuangan = Keuangan::first()->id;
            $pengeluaran->id_pengguna = Auth::id(); // nanti bisa diganti auth()->id()
            $pengeluaran->tanggal = $request->tanggal;
            $pengeluaran->keperluan = $request->keperluan;
            $pengeluaran->nominal = $nominal;
            $pengeluaran->penerima = $request->penerima;
            $pengeluaran->jenis = 'pengeluaran';
            $pengeluaran->jenis_uang = $request->jenis_uang;
            $pengeluaran->persetujuan_direktur = $request->persetujuan_direktur;


            // jika memerplukan persetujuan direktur
            if($request->persetujuan_direktur == 1){
                // Jika perlu persetujuan direktur, set status menunggu

                $pengeluaran->status_persetujuan = 'menunggu';
            } else {
                // Jika tidak perlu persetujuan, langsung set disetujui
                $pengeluaran->status_persetujuan = 'tanpa persetujuan';

                // Kurangi sisa uang kas
                $uangKas = Keuangan::first();
                if ($uangKas->nominal < $nominal) {
                    return redirect()->to('/karyawan/keuangan/pengeluaran/create')->with('error', 'Saldo kas tidak mencukupi!')->withInput();
                }
                $uangKas->nominal -= $nominal;
                $uangKas->save();
            }


            // Upload lampiran
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/lampiran'), $filename);
                $pengeluaran->lampiran = $filename;
            }


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

    public function storeKasbon(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
            'status_persetujuan' => 'required',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);

        DB::beginTransaction();
        try {
            $kasbon = new LaporanKeuangan();
            $kasbon->id_keuangan = Keuangan::first()->id;
            $kasbon->id_pengguna = Auth::id(); // nanti bisa diganti auth()->id()
            $kasbon->tanggal = $request->tanggal;
            $kasbon->keperluan = $request->keperluan;
            $kasbon->nominal = $nominal;
            $kasbon->penerima = $request->penerima;
            $kasbon->jenis = 'kasbon';
            $kasbon->jenis_uang = $request->jenis_uang;
            $kasbon->persetujuan_direktur = $request->status_persetujuan;

            // // Upload lampiran
            // if ($request->hasFile('lampiran')) {
            //     $file = $request->file('lampiran');
            //     $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads/lampiran'), $filename);
            //     $kasbon->lampiran = $filename;
            // }

            // Kurangi sisa uang kas
            $uangKas = Keuangan::first();
            if ($uangKas->nominal < $nominal) {
                return redirect()->to('/karyawan/keuangan/kasbon/create')->with('error', 'Saldo kas tidak mencukupi!')->withInput();
            }

            $kasbon->save();

            DB::commit();

            return redirect()->to('/karyawan/keuangan')->with('success', 'Kasbon berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan kasbon: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createUangMasuk(){
        $daftarKaryawan = Pengguna::get();

        return view('karyawan.keuangan.create-uang-masuk', compact('daftarKaryawan'));
    }

    public function storeUangMasuk(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);

        DB::beginTransaction();
        try {
            $uangMasuk = new LaporanKeuangan();
            $uangMasuk->id_keuangan = Keuangan::first()->id;
            $uangMasuk->id_pengguna = Auth::id(); // nanti bisa diganti auth()->id()
            $uangMasuk->tanggal = $request->tanggal;
            $uangMasuk->keperluan = $request->keperluan;
            $uangMasuk->nominal = $nominal;
            $uangMasuk->penerima = $request->penerima;
            $uangMasuk->jenis = 'uang_masuk';
            $uangMasuk->jenis_uang = $request->jenis_uang;
            $uangMasuk->persetujuan_direktur = 0; // uang masuk tidak perlu persetujuan direktur

            // // Upload lampiran
            // if ($request->hasFile('lampiran')) {
            //     $file = $request->file('lampiran');
            //     $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            //     $file->move(public_path('uploads/lampiran'), $filename);
            //     $uangMasuk->lampiran = $filename;
            // }

            // Tambah sisa uang kas
            $uangKas = Keuangan::first();
            $uangKas->nominal += $nominal;
            $uangKas->save();

            $uangMasuk->save();

            DB::commit();

            return redirect()->to('/karyawan/keuangan')->with('success', 'Pemasukan kas berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pemasukan kas: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function generatePDF($id)
    {
        // Pastikan laporan sudah disetujui sebelum mencoba membuat PDF
        $laporan = LaporanKeuangan::with('pengguna', 'penerimaRelasi')->findOrFail($id);

        if ($laporan->status_persetujuan !== 'disetujui') {
            return redirect()->route('karyawan.keuangan.index')->with('error', 'Dokumen PDF hanya dapat dibuat untuk laporan yang disetujui.');
        }

        // Tambahkan package PDF di sini jika belum di-import di atas
        $pdf = app('dompdf.wrapper');

        // Load view blade untuk PDF
        $pdf->loadView('pdf.bukti_persetujuan_pdf', compact('laporan'));

        // Nama file PDF
        $fileName = 'Bukti_Pengeluaran_' . $laporan->id . '_' . Carbon::now()->format('Ymd') . '.pdf';

        // Unduh PDF
        return $pdf->download($fileName);
    }
}

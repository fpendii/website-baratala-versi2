<?php

namespace App\Http\Controllers;

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
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel; // Pastikan ini di-import
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganController extends Controller
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

        $laporanKeuangan = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();


        $uangKas = Keuangan::first();
        $uangKeluar = LaporanKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $uangMasuk = LaporanKeuangan::where('jenis', 'uang_masuk')->sum('nominal');
        $daftarKaryawan = Pengguna::all();

        return view('keuangan.index', compact('laporanKeuangan', 'uangKeluar', 'uangKas', 'daftarKaryawan', 'uangMasuk'));
    }

    public function previewPdfView($id)
    {
        // 1. Ambil data laporan
        $laporan = LaporanKeuangan::findOrFail($id);

        // nama direktur
        $direktur = Pengguna::where('role', 'direktur')->first()->nama ?? 'Direktur';

        // 2. Siapkan variabel yang dibutuhkan view (sesuai template)
        $data = [
            'laporan' => $laporan,
            // $direktur adalah variabel yang mungkin digunakan di view
            'direktur' => $direktur,
            // $tanggal_persetujuan juga variabel yang dibutuhkan view
            'tanggal_persetujuan' => now()->format('Y-m-d H:i:s'),

        ];

        // 3. Tampilkan view-nya secara langsung
        return view('pdf.bukti_persetujuan_pdf', $data);
    }


    public function createPengeluaran()
    {

        $daftarKaryawan = Pengguna::get();

        return view('keuangan.create-pengeluaran', compact('daftarKaryawan'));
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
            'lampiran' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'persetujuan_direktur' => 'required',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        // Menggunakan (int) atau (float) untuk memastikan konversi ke tipe numerik jika diperlukan,
        // tetapi karena database menggunakan DECIMAL(15,2), kita biarkan sebagai string angka bersih,
        // namun untuk perbandingan dan pengurangan kita perlu konversi.
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);
        $nominalNumeric = (float)$nominal; // Konversi ke float untuk operasi matematika

        DB::beginTransaction();
        try {
            $pengeluaran = new LaporanKeuangan();
            // Menggunakan Keuangan::first() untuk mendapatkan baris data keuangan utama
            $keuangan = Keuangan::first();

            // Cek apakah data Keuangan tersedia
            if (!$keuangan) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data Keuangan utama tidak ditemukan.')->withInput();
            }

            $pengeluaran->id_keuangan = $keuangan->id;
            $pengeluaran->id_pengguna = Auth::id(); // nanti bisa diganti auth()->id()
            $pengeluaran->tanggal = $request->tanggal;
            $pengeluaran->keperluan = $request->keperluan;
            $pengeluaran->nominal = $nominalNumeric; // Simpan sebagai angka
            $pengeluaran->penerima = $request->penerima;
            $pengeluaran->jenis = 'pengeluaran';
            $pengeluaran->jenis_uang = $request->jenis_uang;
            $pengeluaran->persetujuan_direktur = $request->persetujuan_direktur;


            // jika memerlukan persetujuan direktur
            if ($request->persetujuan_direktur == 1) {
                // Jika perlu persetujuan direktur, set status menunggu


                $pengeluaran->status_persetujuan = 'menunggu';

                // Kirim WA notif ke direktur
                $this->sendWhatsAppToDirektur($pengeluaran);
            } else {
                // Jika tidak perlu persetujuan, langsung set disetujui
                $pengeluaran->status_persetujuan = 'tanpa persetujuan';

                // --- Logika Pengurangan Saldo berdasarkan jenis_uang ---
                $jenisUang = $request->jenis_uang;

                if ($jenisUang == 'kas') {
                    // Kurangi sisa uang kas
                    if ($keuangan->uang_kas < $nominalNumeric) {
                        DB::rollBack();
                        return redirect()->to('keuangan/pengeluaran/create')->with('error', 'Saldo **Kas** tidak mencukupi!')->withInput();
                    }
                    $keuangan->uang_kas -= $nominalNumeric;
                } elseif ($jenisUang == 'bank') {
                    // Kurangi sisa uang rekening
                    if ($keuangan->uang_rekening < $nominalNumeric) {
                        DB::rollBack();
                        return redirect()->to('keuangan/pengeluaran/create')->with('error', 'Saldo **Bank** tidak mencukupi!')->withInput();
                    }
                    $keuangan->uang_rekening -= $nominalNumeric;
                }

                // Juga kurangi kolom 'nominal' yang merupakan total (kas + rekening)
                $keuangan->nominal -= $nominalNumeric;

                // Simpan perubahan pada tabel Keuangan
                $keuangan->save();
                // --------------------------------------------------------
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

            return redirect()->to('keuangan')->with('success', 'Pengeluaran kas berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pengeluaran: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    private function sendWhatsAppToDirektur($pengeluaran)
    {
        // Tentukan salam otomatis berdasarkan waktu
        $hour = now()->format('H');
        if ($hour >= 5 && $hour < 12) {
            $salam = 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 17) {
            $salam = 'Selamat Siang';
        } elseif ($hour >= 17 && $hour < 20) {
            $salam = 'Selamat Sore';
        } else {
            $salam = 'Selamat Malam';
        }

        // Ambil direktur
        $direktur = \App\Models\Pengguna::where('role', 'direktur')->first();

        if (!$direktur || !$direktur->no_hp) {
            Log::error("Tidak ada nomor WA direktur terdaftar!");
            return;
        }

        $message = "👋 *{$salam}, {$direktur->nama}!* \n\n"
            . "Terdapat pengajuan *pengeluaran* yang memerlukan persetujuan.\n\n"
            . "📝 *Keperluan:* {$pengeluaran->keperluan}\n"
            . "💰 *Nominal:* Rp " . number_format($pengeluaran->nominal, 0, ',', '.') . "\n"
            . "📅 *Tanggal:* {$pengeluaran->tanggal}\n"
            . "👤 *Diajukan oleh:* " . Auth::user()->nama . "\n\n"
            . "Silakan buka aplikasi untuk melakukan *persetujuan*.\n\n"
            . "_Notifikasi otomatis dari Sistem Baratala_";

        \App\Helpers\WhatsAppHelper::send($direktur->no_hp, $message);
    }


    public function createKasbon()
    {
        $daftarKaryawan = Pengguna::get();

        return view('keuangan.create-kasbon', compact('daftarKaryawan'));
    }

    public function storeKasbon(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
            // Tambahkan persetujuan_direktur seperti di storePengeluaran
            'status_persetujuan' => 'required',
            // 'status_persetujuan' dihilangkan karena akan ditentukan oleh logika di bawah
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);
        $nominalNumeric = (float)$nominal; // Konversi ke float untuk operasi matematika

        DB::beginTransaction();
        try {
            $kasbon = new LaporanKeuangan();
            $keuangan = Keuangan::first();

            // Cek apakah data Keuangan tersedia
            if (!$keuangan) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data Keuangan utama tidak ditemukan.')->withInput();
            }

            $kasbon->id_keuangan = $keuangan->id;
            $kasbon->id_pengguna = Auth::id();
            $kasbon->tanggal = $request->tanggal;
            $kasbon->keperluan = $request->keperluan;
            $kasbon->nominal = $nominalNumeric;
            $kasbon->penerima = $request->penerima;
            $kasbon->jenis = 'kasbon'; // Jenis tetap 'kasbon'
            $kasbon->jenis_uang = $request->jenis_uang;
            $kasbon->persetujuan_direktur = $request->status_persetujuan; // Ambil dari request

            // LOGIKA PERSYARATAN PERSETUJUAN (SAMA DENGAN storePengeluaran)
            if ($request->status_persetujuan == 1) {
                // Jika perlu persetujuan direktur, set status menunggu
                $kasbon->status_persetujuan = 'menunggu';

                // Kirim WA notif ke direktur (gunakan fungsi yang sudah ada)
                $this->sendWhatsAppToDirektur($kasbon);
            } else {
                // Jika tidak perlu persetujuan, langsung set disetujui (tanpa persetujuan)
                $kasbon->status_persetujuan = 'tanpa persetujuan';

                // --- Logika Pengurangan Saldo berdasarkan jenis_uang ---
                $jenisUang = $request->jenis_uang;

                if ($jenisUang == 'kas') {
                    // Kurangi sisa uang kas
                    if ($keuangan->uang_kas < $nominalNumeric) {
                        DB::rollBack();
                        return redirect()->to('keuangan/kasbon/create')->with('error', 'Saldo **Kas** tidak mencukupi!')->withInput();
                    }
                    $keuangan->uang_kas -= $nominalNumeric;
                } elseif ($jenisUang == 'bank') {
                    // Kurangi sisa uang rekening
                    if ($keuangan->uang_rekening < $nominalNumeric) {
                        DB::rollBack();
                        return redirect()->to('keuangan/kasbon/create')->with('error', 'Saldo **Bank** tidak mencukupi!')->withInput();
                    }
                    $keuangan->uang_rekening -= $nominalNumeric;
                }

                // Kurangi juga kolom 'nominal' yang merupakan total (kas + rekening)
                $keuangan->nominal -= $nominalNumeric;

                // Simpan perubahan pada tabel Keuangan
                $keuangan->save();
            }
            // END LOGIKA PERSYARATAN PERSETUJUAN

            // Catatan: Tidak ada upload 'lampiran' di validasi/storeKasbon. Jika harusnya ada, tambahkan.
            // Asumsi kasbon tidak memerlukan lampiran saat pengajuan.

            // Simpan data kasbon (laporan keuangan)
            $kasbon->save();

            DB::commit();

            return redirect()->to('keuangan')->with('success', 'Kasbon berhasil disimpan dengan status ' . $kasbon->status_persetujuan . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan kasbon: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createUangMasuk()
    {
        $daftarKaryawan = Pengguna::get();

        return view('keuangan.create-uang-masuk', compact('daftarKaryawan'));
    }

    public function storeUangMasuk(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'nominal' => 'required|string',
            'jenis_uang' => 'required|in:kas,bank',
        ]);

        // Bersihkan nominal -> hapus titik/koma pemisah ribuan
        $nominal = preg_replace('/[^0-9]/', '', $request->nominal);
        $nominalNumeric = (float)$nominal; // Konversi ke float untuk operasi matematika

        DB::beginTransaction();
        try {
            $uangMasuk = new LaporanKeuangan();
            $keuangan = Keuangan::first();

            // Cek apakah data Keuangan tersedia
            if (!$keuangan) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Data Keuangan utama tidak ditemukan.')->withInput();
            }

            $uangMasuk->id_keuangan = $keuangan->id;
            $uangMasuk->id_pengguna = Auth::id();
            $uangMasuk->tanggal = $request->tanggal;
            $uangMasuk->keperluan = $request->keperluan;
            $uangMasuk->nominal = $nominalNumeric;
            $uangMasuk->penerima = $request->penerima;
            $uangMasuk->jenis = 'uang_masuk';
            $uangMasuk->jenis_uang = $request->jenis_uang;
            $uangMasuk->status_persetujuan = 'tanpa persetujuan';
            $uangMasuk->persetujuan_direktur = 0; // uang masuk tidak perlu persetujuan direktur

            // --- Logika Penambahan Saldo berdasarkan jenis_uang ---
            $jenisUang = $request->jenis_uang;

            if ($jenisUang == 'kas') {
                // Tambah sisa uang kas
                $keuangan->uang_kas += $nominalNumeric;
            } elseif ($jenisUang == 'bank') {
                // Tambah sisa uang rekening
                $keuangan->uang_rekening += $nominalNumeric;
            }

            // Tambah juga kolom 'nominal' yang merupakan total (kas + rekening)
            $keuangan->nominal += $nominalNumeric;

            // Simpan perubahan pada tabel Keuangan
            $keuangan->save();
            // --------------------------------------------------------

            $uangMasuk->save();

            DB::commit();

            return redirect()->to('keuangan')->with('success', 'Pemasukan kas berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pemasukan kas: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // public function generatePDF($id)
    // {
    //     // Pastikan laporan sudah disetujui sebelum mencoba membuat PDF
    //     $laporan = LaporanKeuangan::with('pengguna', 'penerimaRelasi')->findOrFail($id);

    //     if ($laporan->status_persetujuan !== 'disetujui') {
    //         return redirect()->route('keuangan.index')->with('error', 'Dokumen PDF hanya dapat dibuat untuk laporan yang disetujui.');
    //     }

    //     // Tambahkan package PDF di sini jika belum di-import di atas
    //     $pdf = app('dompdf.wrapper');

    //     // Load view blade untuk PDF
    //     $pdf->loadView('pdf.bukti_persetujuan_pdf', compact('laporan'));

    //     // Nama file PDF
    //     $fileName = 'Bukti_Pengeluaran_' . $laporan->id . '_' . Carbon::now()->format('Ymd') . '.pdf';

    //     // Unduh PDF
    //     return $pdf->download($fileName);
    // }

    public function exportExcel(Request $request)
    {
        // Ambil semua parameter filter dari request (sama seperti di index/show data)
        $filters = $request->only(['filter_tanggal', 'filter_jenis', 'filter_pengguna']);

        // Tentukan nama file
        $namaFile = 'Laporan_Keuangan_' . now()->format('Ymd_His') . '.xlsx';

        // Lakukan export menggunakan kelas yang sudah dibuat
        return Excel::download(new LaporanKeuanganExport($filters), $namaFile);
    }

    /**
     * Hapus (Destroy) Laporan Keuangan.
     * Tidak mengizinkan penghapusan untuk status 'disetujui' dan 'ditolak'.
     * Logika pengembalian saldo diterapkan untuk status 'tanpa persetujuan'.
     */
    public function destroy($id)
    {
        // 1. Cari Laporan Keuangan
        $laporan = LaporanKeuangan::find($id);

        if (!$laporan) {
            return redirect()->to('keuangan')->with('error', 'Data laporan tidak ditemukan.');
        }

        // 2. CEK STATUS KEAMANAN
        // Blokir penghapusan untuk status yang tidak boleh dihapus: 'disetujui' dan 'ditolak'.
        if ($laporan->status_persetujuan === 'disetujui' || $laporan->status_persetujuan === 'ditolak') {
            return redirect()->to('keuangan')->with('error', 'Transaksi dengan status **' . ucfirst($laporan->status_persetujuan) . '** tidak dapat dihapus.');
        }

        // Cek Batas Waktu 24 Jam untuk status yang tersisa ('menunggu' dan 'tanpa persetujuan')
        $tanggalDibuat = Carbon::parse($laporan->created_at);
        $batasWaktuTerlampaui = $tanggalDibuat->lte(Carbon::now()->subDay());

        if ($batasWaktuTerlampaui) {
            // Blokir semua penghapusan jika sudah lewat 24 jam, kecuali ada kebijakan khusus.
            // Kita pertahankan batas 24 jam untuk 'menunggu' dan 'tanpa persetujuan' demi keamanan.
            return redirect()->to('keuangan')->with('error', 'Transaksi hanya dapat dihapus dalam waktu 1x24 jam sejak dibuat.');
        }


        DB::beginTransaction();
        try {
            $keuangan = Keuangan::first();

            if (!$keuangan) {
                DB::rollBack();
                return redirect()->to('keuangan')->with('error', 'Data Keuangan utama (Kas/Bank) tidak ditemukan.');
            }

            // 3. LOGIKA PENGEMBALIAN SALDO
            // Saldo HANYA perlu disesuaikan jika transaksi sebelumnya SUDAH mengurangi/menambah saldo.
            // Dalam Controller Anda: hanya status 'tanpa persetujuan' dan 'disetujui' (melalui direktur) yang memengaruhi saldo.
            // Karena 'disetujui' diblokir, kita fokus pada 'tanpa persetujuan'.

            if ($laporan->status_persetujuan === 'tanpa persetujuan') {
                $nominal = $laporan->nominal;
                $jenis_uang = $laporan->jenis_uang;
                $jenis_transaksi = $laporan->jenis; // uang_masuk, pengeluaran, kasbon

                if ($jenis_transaksi == 'pengeluaran' || $jenis_transaksi == 'kasbon') {
                    // Pengeluaran/Kasbon (keluar) perlu DITAMBAHKAN kembali
                    if ($jenis_uang == 'kas') {
                        $keuangan->uang_kas += $nominal;
                    } elseif ($jenis_uang == 'bank') {
                        $keuangan->uang_rekening += $nominal;
                    }
                    $keuangan->nominal += $nominal;
                } elseif ($jenis_transaksi == 'uang_masuk') {
                    // Uang Masuk (masuk) perlu DIKURANGI kembali
                    if ($jenis_uang == 'kas') {
                        $keuangan->uang_kas -= $nominal;
                    } elseif ($jenis_uang == 'bank') {
                        $keuangan->uang_rekening -= $nominal;
                    }
                    $keuangan->nominal -= $nominal;
                }

                // Simpan perubahan pada tabel Keuangan
                $keuangan->save();
            }
            // Catatan: Untuk status 'menunggu', saldo tidak berubah, jadi tidak ada yang perlu dikembalikan.


            // 4. Hapus Lampiran (jika ada)
            if ($laporan->lampiran) {
                // Pastikan Anda menggunakan Storage::delete() jika file di-upload via Storage facade,
                // atau unlink() jika via public_path/move(). Saya asumsikan unlink sesuai storePengeluaran.
                $path = public_path('uploads/lampiran/' . $laporan->lampiran);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            // 5. Hapus Laporan Keuangan dari database
            $laporan->delete();

            DB::commit();

            return redirect()->to('keuangan')->with('success', 'Transaksi keuangan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus transaksi. Terjadi kesalahan sistem.');
        }
    }

    public function persetujuan(Request $request, $id)
    {
        $laporan = LaporanKeuangan::with('pengguna', 'penerimaRelasi')->findOrFail($id);
        // Ubah status persetujuan_direktur menjadi true
        return view('keuangan.persetujuan', compact('laporan'));
    }

    public function updatePersetujuan(Request $request, $id)
    {
        $laporan = LaporanKeuangan::findOrFail($id);

        // Hanya proses jika persetujuan dikirim (untuk keamanan)
        if (!in_array($request->persetujuan, ['disetujui', 'ditolak'])) {
            return back()->with('error', 'Pilihan persetujuan tidak valid.');
        }

        $isApproved = ($request->persetujuan === 'disetujui');
        $pdfPath = null; // Inisialisasi variabel untuk path PDF

        DB::beginTransaction();

        try {
            if ($isApproved) {
                $laporan->status_persetujuan = 'disetujui';

                // Ambil data keuangan utama
                $keuangan = Keuangan::first();
                if (!$keuangan) {
                    DB::rollBack();
                    return back()->with('error', 'Data Keuangan utama tidak ditemukan.');
                }

                $nominal = (float) $laporan->nominal;
                $jenisUang = $laporan->jenis_uang;
                $jenisTransaksi = $laporan->jenis;

                // Logika Pembaruan Saldo (Kode Anda yang sudah benar)
                if (in_array($jenisTransaksi, ['pengeluaran', 'kasbon'])) {
                    if ($jenisUang === 'kas') {
                        if ($keuangan->uang_kas < $nominal) {
                            DB::rollBack();
                            return back()->with('error', 'Saldo Kas tidak mencukupi untuk pengeluaran ini.');
                        }
                        $keuangan->uang_kas -= $nominal;
                    } elseif ($jenisUang === 'bank') {
                        if ($keuangan->uang_rekening < $nominal) {
                            DB::rollBack();
                            return back()->with('error', 'Saldo Bank tidak mencukupi untuk pengeluaran ini.');
                        }
                        $keuangan->uang_rekening -= $nominal;
                    }
                    $keuangan->nominal -= $nominal;
                } elseif ($jenisTransaksi === 'uang_masuk') {
                    if ($jenisUang === 'kas') {
                        $keuangan->uang_kas += $nominal;
                    } elseif ($jenisUang === 'bank') {
                        $keuangan->uang_rekening += $nominal;
                    }
                    $keuangan->nominal += $nominal;
                }

                // Simpan perubahan keuangan
                $keuangan->save();

                // PANGGIL FUNGSI GENERATE PDF DAN SIMPAN PATH
                // Pastikan ini dipanggil SETELAH $laporan->status_persetujuan diatur
                $pdfPath = $this->generatePDF($laporan->id);

            } else {
                $laporan->status_persetujuan = 'ditolak';
                // Jika ditolak, pastikan path PDF dihapus/null
                $laporan->bukti_persetujuan_pdf = null;
            }


            $laporan->catatan = $request->catatan;
            // Simpan path PDF yang dikembalikan (jika ada)
            if ($pdfPath) {
                $laporan->bukti_persetujuan_pdf = $pdfPath;
            }

            $laporan->save(); // Simpan status persetujuan, catatan, dan path PDF

            DB::commit();

            $message = $isApproved ? 'Laporan berhasil disetujui dan bukti PDF telah disimpan.' : 'Persetujuan laporan keuangan berhasil diperbarui (Ditolak).';

            // Hanya redirect ke index, tidak perlu ke route generate-pdf lagi
            return redirect()->route('keuangan.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating laporan keuangan approval: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui persetujuan laporan keuangan.');
        }
    }

    // protected function generateAndStorePdf(LaporanKeuangan $laporan)
    // {
    //     if ($laporan->persetujuan_direktur != 1) {
    //         return null;
    //     }

    //     $data = [
    //         'laporan' => $laporan,
    //         'direktur' => Auth::user()->nama,
    //         'tanggal_persetujuan' => now()->format('d M Y H:i:s'),
    //     ];

    //     $pdf = Pdf::loadView('pdf.bukti_persetujuan_pdf', $data);

    //     $fileName = 'persetujuan_' . $laporan->id . '_' . time() . '.pdf';
    //     $filePath = 'bukti_persetujuan/' . $fileName;

    //     // Simpan file PDF ke storage/app/public/bukti_persetujuan/
    //     Storage::disk('public')->put($filePath, $pdf->output());

    //     return $filePath; // simpan path ini ke database
    // }



    public function generatePDF($id)
    {
        $laporan = LaporanKeuangan::with('pengguna', 'penerimaRelasi')->findOrFail($id);

        if ($laporan->status_persetujuan !== 'disetujui') {
            return redirect()->route('keuangan.index')
                ->with('error', 'Dokumen PDF hanya dapat dibuat untuk laporan yang disetujui.');
        }

        // --- DEFENISI BASE64 ---
        $logoBase64 = $this->getBase64Image(public_path('image/logo.png'));
        $ttdDirBase64 = $this->getBase64Image(public_path('image/ttd.png'));

        // --- DATA UNTUK VIEW ---
        $data = [
            'laporan' => $laporan,
            'direktur' => Auth::user()->nama,
            'tanggal_persetujuan' => Carbon::now()->format('Y-m-d H:i:s'),
            'logoBase64' => $logoBase64,
            'ttdDirBase64' => $ttdDirBase64,
        ];

        // --- LOAD VIEW PDF (nama view harus sama dengan file Blade) ---
        // $pdf = Pdf::loadView('pdf.bukti_persetujuan_pdf', $data);

        // $fileName = 'Bukti_Pengeluaran_' . $laporan->id . '_' . Carbon::now()->format('Ymd') . '.pdf';

        // return $pdf->download($fileName);

        $pdf = Pdf::loadView('pdf.bukti_persetujuan_pdf', $data);

        $fileName = 'persetujuan_' . $laporan->id . '_' . time() . '.pdf';
        $filePath = 'bukti_persetujuan/' . $fileName;

        // Simpan file PDF ke storage/app/public/bukti_persetujuan/
        Storage::disk('public')->put($filePath, $pdf->output());

        return $filePath; // simpan path ini ke database
    }

    /**
     * Fungsi helper untuk konversi gambar ke Base64
     */
    private function getBase64Image($path)
    {
        if (!file_exists($path)) {
            return ''; // Optional: bisa kasih placeholder
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

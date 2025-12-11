<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Helpers\WhatsAppHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeluarController extends Controller
{
    /**
     * Tampilkan daftar semua Surat Keluar.
     */
    public function index(Request $request)
    {
        // 1. Mulai query builder
        $query = SuratKeluar::with('pengguna')->orderBy('tgl_surat', 'desc');

        // --- Logika Filter ---

        // NEW: Filter Nomor Surat
        if ($request->filled('nomor')) {
            $query->where('nomor_surat', 'like', '%' . $request->nomor . '%');
        }

        // 2. Filter Perihal / Tujuan (Cari)
        if ($request->filled('cari')) {
            $cari = $request->cari;
            // Gunakan where untuk mencari di kolom perihal ATAU tujuan
            $query->where(function ($q) use ($cari) {
                $q->where('perihal', 'like', '%' . $cari . '%')
                    ->orWhere('tujuan', 'like', '%' . $cari . '%');
            });
        }

        // 3. Filter berdasarkan Jenis Surat
        if ($request->filled('jenis')) {
            $query->where('jenis_surat', strtolower($request->jenis));
        }

        // 4. Filter berdasarkan Rentang Tanggal Surat (Tanggal Mulai)
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_surat', '>=', $request->tanggal_mulai);
        }

        // 5. Filter berdasarkan Rentang Tanggal Surat (Tanggal Selesai)
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tgl_surat', '<=', $request->tanggal_selesai);
        }

        // 6. Ambil data dengan paginasi
        $surat_keluar = $query->paginate(10);

        return view('surat_keluar.index', compact('surat_keluar'));
    }

    public function create(Request $request)
    {
        $jenis_surat_options = ['umum', 'keuangan', 'operasional'];
        $jenis = $request->jenis ?? 'umum';

        // ===============================
        // GENERATE NOMOR SURAT PER JENIS
        // FORMAT: BTTP-1.058/Ops/XII/2025
        // ===============================

        // Ambil surat terakhir BERDASARKAN JENIS
        $lastSurat = SuratKeluar::where('jenis_surat', $jenis)
            ->orderBy('nomor_surat', 'desc')
            ->first();

        $lastNumber = 0;

        if ($lastSurat && preg_match('/BTTP-([\d\.]+)\//', $lastSurat->nomor_surat, $matches)) {
            // Contoh: 1.058 → 1058
            $lastNumber = (int) str_replace('.', '', $matches[1]);
        }

        // Tambah 1
        $newNumber = $lastNumber + 1;

        // Format ribuan: 1059 → 1.059
        $formattedNumber = number_format($newNumber, 0, '', '.');

        // Kode jenis surat
        $jenisKode = [
            'umum'        => 'Um',
            'operasional' => 'Ops',
            'keuangan'    => 'Keu',
        ];

        // Bulan Romawi
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $bulan = $bulanRomawi[Carbon::now()->month];
        $tahun = Carbon::now()->year;

        // ✅ NOMOR FINAL SESUAI JENIS MASING-MASING
        $nomor_surat = "BTTP-{$formattedNumber}/{$jenisKode[$jenis]}/{$bulan}/{$tahun}";

        return view('surat_keluar.create', compact(
            'jenis_surat_options',
            'jenis',
            'nomor_surat'
        ));
    }



    /**
     * Simpan Surat Keluar baru.
     */
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:100|unique:surat_keluar,nomor_surat',
            'tujuan' => 'required|string|max:255',
            'konten_surat' => 'nullable|string',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $lampiran = null;
            $dok_surat = null;
            $kontenSurat = $request->konten_surat;

            // =====================================================
            // 📌 CEK JIKA PENGGUNA MENGUPLOAD FILE → TIDAK PERLU PDF
            // =====================================================
            if ($request->hasFile('file_surat')) {

                // SIMPAN FILE LAMPIRAN
                $lampiran = $request->file('file_surat')->store('surat_keluar_pdf', 'public');

                // KOSONGKAN konten surat & PDF (dok_surat)
                $kontenSurat = "";
                $dok_surat = null;
            } else {
                // =====================================================
                // 📌 JIKA TIDAK UPLOAD → GENERATE PDF DARI KONTEN
                // =====================================================

                // LOGO BASE64
                $logoPath = public_path('image/logo.png');

                if (file_exists($logoPath)) {
                    $logoData = base64_encode(file_get_contents($logoPath));
                    $base64Image = 'data:image/png;base64,' . $logoData;
                    $assetUrlToFind = '../image/logo.png';

                    if (strpos($kontenSurat, $assetUrlToFind) !== false) {
                        $kontenSurat = str_replace($assetUrlToFind, $base64Image, $kontenSurat);
                    }
                }

                // GENERATE PDF
                $pdf = PDF::loadHtml($kontenSurat)->setPaper('A4', 'portrait');

                $safeNomorSurat = str_replace(['/', '\\', ' '], '-', $request->nomor_surat);
                $tanggal = date('Ymd');
                $fileName = "SK-{$tanggal}-{$safeNomorSurat}.pdf";

                $dok_surat = 'surat_keluar_pdf/' . $fileName;
                Storage::disk('public')->put($dok_surat, $pdf->output());
            }

            // =====================================================
            // 🗂 SIMPAN KE DATABASE
            // =====================================================

            $surat = SuratKeluar::create([
                'id_pengguna'   => Auth::id(),
                'nomor_surat'   => $request->nomor_surat,
                'konten_surat'  => $kontenSurat,
                'tgl_surat'     => $request->tgl_surat,
                'tujuan'        => $request->tujuan,
                'perihal'       => $request->perihal,
                'lampiran'      => $lampiran,
                'jenis_surat'   => $request->jenis_surat,
                'dok_surat'     => $dok_surat
            ]);

            // =====================================================
            // 🔔 NOTIFIKASI WA KEPADA ATASAN (FONNTE)
            // =====================================================
            try {
                $token = env('FONNTE_API_KEY');
                $target = env('WA_ATASAN');

                $pembuat = Auth::user()->nama ?? 'Pengguna';
                $tanggalSurat = date('d-m-Y', strtotime($request->tgl_surat));

                $message = "
📄 *Notifikasi Surat Keluar Baru*

Ada surat keluar baru yang dibuat:

📝 *Nomor Surat:* {$request->nomor_surat}
🎯 *Tujuan:* {$request->tujuan}
📅 *Tanggal:* {$tanggalSurat}
👤 *Dibuat oleh:* {$pembuat}

Silakan cek sistem untuk detailnya.
";

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.fonnte.com/send",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => [
                        "target" => $target,
                        "message" => $message,
                    ],
                    CURLOPT_HTTPHEADER => [
                        "Authorization: $token"
                    ],
                ]);

                $response = curl_exec($curl);
                curl_close($curl);

                Log::info('Fonnte Notification Sent', ['response' => $response]);
            } catch (\Exception $e) {
                Log::error('Fonnte Notification Error: ' . $e->getMessage());
            }

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat berhasil ditambahkan & notifikasi WA terkirim.');
        } catch (\Exception $e) {

            Log::error('Store Surat Error: ' . $e->getMessage());
            return back()->withInput()->withErrors([
                'error' => 'Gagal menyimpan surat. Silakan cek log.'
            ]);
        }
    }



    /**
     * Detail surat keluar.
     */
    public function show(SuratKeluar $surat_keluar)
    {
        return view('surat_keluar.show', compact('surat_keluar'));
    }

    /**
     * Form edit Surat Keluar.
     */
    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return view('surat_keluar.edit', [
            'surat' => $surat,
            'nomor_surat' => $surat->nomor_surat,
            'jenis' => $surat->jenis_surat,
        ]);
    }


    /**
     * Update Surat Keluar.
     */
    public function update(Request $request, $id)
    {
        // Ambil data surat lama
        $surat = SuratKeluar::findOrFail($id);

        // VALIDASI
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => [
                'required',
                'string',
                'max:100',
                Rule::unique('surat_keluar', 'nomor_surat')->ignore($id)
            ],
            'tujuan' => 'required|string|max:255',
            'konten_surat' => 'required|string',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $lampiran = $surat->lampiran; // default: pakai lampiran lama
            $dok_surat = $surat->dok_surat; // default: pakai PDF lama
            $htmlContent = $request->konten_surat;

            /* ================================
         * 1. Upload Lampiran (Jika Ada)
         * ================================ */
            if ($request->hasFile('lampiran')) {

                // Hapus lampiran lama jika ada
                if ($lampiran && Storage::disk('public')->exists($lampiran)) {
                    Storage::disk('public')->delete($lampiran);
                }

                $lampiran = $request->file('lampiran')->store('surat_keluar_lampiran', 'public');
            }

            /* ================================
         * 2. Replace Logo Menjadi Base64
         * ================================ */
            $logoPath = public_path('image/logo.png');
            Log::info('PDF Update: Checking logo path', [
                'path' => $logoPath,
                'exists' => file_exists($logoPath)
            ]);

            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
                $base64Image = "data:image/png;base64,$logoData";

                $assetUrlToFind = '../image/logo.png';

                if (strpos($htmlContent, $assetUrlToFind) !== false) {
                    $htmlContent = str_replace($assetUrlToFind, $base64Image, $htmlContent);
                    Log::info('PDF Update: Logo replaced successfully');
                } else {
                    Log::warning('PDF Update: Logo URL NOT FOUND in HTML content');
                }
            } else {
                Log::error('PDF Update: Logo NOT FOUND on server');
            }

            /* ================================
         * 3. Generate PDF Baru
         * ================================ */

            // Hapus PDF lama jika ada
            if ($dok_surat && Storage::disk('public')->exists($dok_surat)) {
                Storage::disk('public')->delete($dok_surat);
            }

            $pdf = PDF::loadHtml($htmlContent)->setPaper('A4', 'portrait');

            $safeNomorSurat = str_replace(['/', '\\', ' '], '-', $request->nomor_surat);
            $tanggal = date('Ymd');
            $fileName = "SK-{$tanggal}-{$safeNomorSurat}.pdf";

            // Simpan PDF baru
            $dok_surat = 'surat_keluar_pdf/' . $fileName;
            Storage::disk('public')->put($dok_surat, $pdf->output());

            /* ================================
         * 4. Update Database
         * ================================ */

            $surat->update([
                'id_pengguna' => Auth::id(),
                'nomor_surat' => $request->nomor_surat,
                'konten_surat' => $htmlContent,
                'tgl_surat' => $request->tgl_surat,
                'tujuan' => $request->tujuan,
                'perihal' => $request->perihal,
                'lampiran' => $lampiran,
                'jenis_surat' => $request->jenis_surat,
                'dok_surat' => $dok_surat,
            ]);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat Keluar berhasil diperbarui dan PDF baru berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('PDF Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->withErrors([
                'error' => 'Gagal memperbarui data atau membuat PDF baru. Silakan cek log.'
            ]);
        }
    }


    /**
     * Hapus Surat Keluar.
     */
    public function destroy($id_surat)
    {
        $surat_keluar = SuratKeluar::findOrFail($id_surat);
        try {

            // Hapus lampiran dari storage jika ada
            if ($surat_keluar->lampiran && Storage::disk('public')->exists($surat_keluar->lampiran)) {
                Storage::disk('public')->delete($surat_keluar->lampiran);
            }

            $surat_keluar->delete();

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat Keluar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data. ' . $e->getMessage()]);
        }
    }

    public function updateDokumen(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'surat_id' => 'required|exists:surat_keluar,id',
            // Menggunakan nama input file 'dok_surat'
            'dok_surat' => 'required|file|mimes:pdf|max:5120', // Maks 5MB
        ]);

        // 2. Cari Surat
        $surat = SuratKeluar::findOrFail($request->surat_id);

        // 3. Proses File Upload
        if ($request->hasFile('dok_surat')) {
            $file = $request->file('dok_surat');

            // Tentukan folder penyimpanan. Sesuaikan nama folder jika Anda menggunakan nama yang berbeda!
            $storageDisk = 'public';
            $pathFolder = 'surat_keluar_pdf';

            // 4. Hapus file lama (JIKA ADA) dari storage
            if ($surat->dok_surat && Storage::disk($storageDisk)->exists($surat->dok_surat)) {
                Storage::disk($storageDisk)->delete($surat->dok_surat);
            }

            // Buat nama file baru (menggantikan dokumen lama)
            $namaFile = time() . '_' . $surat->id . '_final.' . $file->getClientOriginalExtension();

            // 5. Simpan file baru
            $path = $file->storeAs($pathFolder, $namaFile, $storageDisk);

            // 6. Update kolom di database (menggunakan kolom dok_surat yang sudah ada)
            $surat->dok_surat = $path;
            $surat->save();

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Dokumen Surat Keluar berhasil diperbarui dengan versi TTD.');
        }

        return redirect()->back()->with('error', 'Gagal memproses dokumen.');
    }
}

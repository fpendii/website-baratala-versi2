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
    public function index()
    {
        $surat_keluar = SuratKeluar::with('pengguna')
            ->orderBy('id', 'desc')
            ->get();

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
            ->orderBy('id', 'desc')
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
        // 1. VALIDASI DATA
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:100|unique:surat_keluar,nomor_surat',
            'tujuan' => 'required|string|max:255',
            'konten_surat' => 'required|string',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $lampiran = null;
            $dok_surat = null;
            $htmlContent = $request->konten_surat;

            // 2. Upload lampiran jika ada
            if ($request->hasFile('lampiran')) {
                $lampiran = $request->file('lampiran')->store('surat_keluar_lampiran', 'public');
            }

            // --- START: BASE64 ENCODING & LOGGING ---

            $logoPath = public_path('image/logo.png');

            // LOG POINT 1: Cek Path Logo
            Log::info('PDF Generation: Logo Path checked.', ['path' => $logoPath, 'exists' => file_exists($logoPath)]);

            if (file_exists($logoPath)) {
                // 3. ENCODE LOGO KE BASE64
                $logoData = base64_encode(file_get_contents($logoPath));
                $base64Image = 'data:image/png;base64,' . $logoData;

                // BARIS BARU (Mencari URL Relatif yang diubah TinyMCE)
                $assetUrlToFind = '../image/logo.png';

                // LOG POINT 2: Cek URL Asset yang Dicari
                Log::info('PDF Generation: Asset URL to be replaced.', ['asset_url' => $assetUrlToFind]);

                // Cek apakah URL Asset ditemukan dalam konten
                if (strpos($htmlContent, $assetUrlToFind) !== false) {
                    // Ganti URL asset() dengan string Base64
                    $htmlContent = str_replace($assetUrlToFind, $base64Image, $htmlContent);

                    // LOG POINT 3: Konfirmasi Penggantian
                    Log::info('PDF Generation: Replacement SUCCESSFUL. Logo URL found and replaced.');
                } else {
                    // LOG POINT 3b: Penggantian Gagal (URL Asset tidak ditemukan)
                    Log::warning('PDF Generation: Replacement FAILED. Asset URL not found in HTML content.');
                    // Tambahkan log untuk melihat awal konten yang di-submit
                    Log::debug('Start of Content Submitted:', ['content_start' => substr($htmlContent, 0, 500)]);
                }
            } else {
                // LOG POINT 4: File Logo Tidak Ditemukan
                Log::error('PDF Generation: Logo file NOT found at the specified path!');
            }

            // --- END: BASE64 ENCODING & LOGGING ---

            // 4. GENERATE DAN SIMPAN PDF DARI KONTEN HTML
            $pdf = PDF::loadHtml($htmlContent)->setPaper('A4', 'portrait');

            // Tentukan nama file PDF
            $safeNomorSurat = str_replace(['/', '\\', ' '], '-', $request->nomor_surat);
            $tanggal = date('Ymd');
            $fileName = "SK-{$tanggal}-{$safeNomorSurat}.pdf";

            // Simpan file PDF ke storage
            $dok_surat = 'surat_keluar_pdf/' . $fileName;
            Storage::disk('public')->put($dok_surat, $pdf->output());


            // 5. Simpan data Surat Keluar ke Database
            $surat = SuratKeluar::create([
                'id_pengguna' => Auth::id(),
                'nomor_surat' => $request->nomor_surat,
                'konten_surat' => $htmlContent,
                'tgl_surat' => $request->tgl_surat,
                'tujuan' => $request->tujuan,
                'perihal' => $request->perihal,
                'lampiran' => $lampiran,
                'jenis_surat' => $request->jenis_surat,
                'dok_surat' => $dok_surat

            ]);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat Keluar berhasil ditambahkan, konten surat dan dokumen PDF telah tersimpan.');
        } catch (\Exception $e) {
            // ... penanganan error lainnya
            Log::error('PDF Generation Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data atau membuat PDF. Silakan cek log untuk detail.']);
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
    public function edit($id_surat)
    {
        $surat_keluar = SuratKeluar::findOrFail($id_surat);
        $jenis_surat_options = ['umum', 'keuangan', 'operasional'];

        return view('surat_keluar.edit', compact('surat_keluar', 'jenis_surat_options'));
    }

    /**
     * Update Surat Keluar.
     */
    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => [
                'required',
                'string',
                'max:100',

            ],
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {

            $data = $request->except('lampiran');

            // Jika user upload lampiran baru
            if ($request->hasFile('lampiran')) {

                // Hapus lampiran lama jika ada
                if ($surat_keluar->lampiran && Storage::disk('public')->exists($surat_keluar->lampiran)) {
                    Storage::disk('public')->delete($surat_keluar->lampiran);
                }

                // Upload yang baru
                $data['lampiran'] = $request->file('lampiran')->store('lampiran_surat', 'public');
            }

            $surat_keluar->update($data);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat Keluar berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data. ' . $e->getMessage()]);
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
}

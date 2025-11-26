<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    /**
     * Tampilkan daftar semua Surat Keluar.
     */
    public function index()
    {
        // Ambil semua surat keluar, urutkan berdasarkan tanggal terbaru
        $surat_keluar = SuratKeluar::with('pengguna')
                                   ->orderBy('tgl_surat', 'desc')
                                   ->get();

        return view('surat_keluar.index', compact('surat_keluar'));
    }

    /**
     * Tampilkan form untuk membuat Surat Keluar baru.
     */
    public function create()
    {
        $jenis_surat_options = ['umum', 'keuangan', 'operasional'];
        return view('surat_keluar.create', compact('jenis_surat_options'));
    }

    /**
     * Simpan Surat Keluar yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:100|unique:surat_keluar,nomor_surat',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
        ]);

        try {
            SuratKeluar::create([
                // Asumsi: Ambil ID pengguna yang sedang login
                'id_pengguna' => Auth::id(),
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'tujuan' => $request->tujuan,
                'perihal' => $request->perihal,
                'jenis_surat' => $request->jenis_surat,
            ]);

            return redirect()->route('surat-keluar.index')
                             ->with('success', 'Surat Keluar berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan detail Surat Keluar.
     */
    public function show(SuratKeluar $surat_keluar)
    {
        return view('surat_keluar.show', compact('surat_keluar'));
    }

    /**
     * Tampilkan form untuk mengedit Surat Keluar.
     */
    public function edit($id_surat)
    {
        $surat_keluar = SuratKeluar::findOrFail($id_surat);
        $jenis_surat_options = ['umum', 'keuangan', 'operasional'];
        return view('surat_keluar.edit', compact('surat_keluar', 'jenis_surat_options'));
    }

    /**
     * Perbarui Surat Keluar di database.
     */
    public function update(Request $request, SuratKeluar $surat_keluar)
    {
        // Validasi data input. Pastikan nomor_surat unik, kecuali untuk surat yang sedang diedit.
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => [
                'required',
                'string',
                'max:100',
                Rule::unique('surat_keluar', 'nomor_surat')->ignore($surat_keluar->id),
            ],
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
        ]);

        try {
            $surat_keluar->update([
                // id_pengguna tidak diubah di sini
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'tujuan' => $request->tujuan,
                'perihal' => $request->perihal,
                'jenis_surat' => $request->jenis_surat,
            ]);

            return redirect()->route('surat-keluar.index')
                             ->with('success', 'Surat Keluar berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data. ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus Surat Keluar dari database.
     */
    public function destroy(SuratKeluar $surat_keluar)
    {
        try {
            $surat_keluar->delete();
            return redirect()->route('surat-keluar.index')
                             ->with('success', 'Surat Keluar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus data. ' . $e->getMessage()]);
        }
    }
}

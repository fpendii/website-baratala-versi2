<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Tampilkan daftar semua Surat Keluar.
     */
    public function index()
    {
        $surat_keluar = SuratKeluar::with('pengguna')
            ->orderBy('tgl_surat', 'desc')
            ->get();

        return view('surat_keluar.index', compact('surat_keluar'));
    }

    /**
     * Tampilkan form membuat Surat Keluar baru.
     */
    public function create()
    {
        $jenis_surat_options = ['umum', 'keuangan', 'operasional'];
        return view('surat_keluar.create', compact('jenis_surat_options'));
    }

    /**
     * Simpan Surat Keluar baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:100|unique:surat_keluar,nomor_surat',
            'tujuan' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'jenis_surat' => ['required', Rule::in(['umum', 'keuangan', 'operasional'])],
            'lampiran' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {

            $lampiran = null;

            // Upload lampiran jika ada
            if ($request->hasFile('lampiran')) {
                $lampiran = $request->file('lampiran')->store('surat_keluar_lampiran', 'public');
            }

            SuratKeluar::create([
                'id_pengguna' => Auth::id(),
                'tgl_surat' => $request->tgl_surat,
                'nomor_surat' => $request->nomor_surat,
                'tujuan' => $request->tujuan,
                'perihal' => $request->perihal,
                'jenis_surat' => $request->jenis_surat,
                'lampiran' => $lampiran,
            ]);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat Keluar berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. ' . $e->getMessage()]);
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

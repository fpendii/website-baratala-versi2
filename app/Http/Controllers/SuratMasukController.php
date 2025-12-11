<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\WhatsAppHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai query builder
        $query = SuratMasuk::orderBy('created_at', 'desc');

        // --- Logika Filter ---

        // 1. Filter berdasarkan Pengirim
        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'like', '%' . $request->pengirim . '%');
        }

        // 2. Filter berdasarkan Prioritas
        if ($request->filled('prioritas')) {
            // Prioritas disimpan dalam huruf kecil
            $prioritas = strtolower($request->prioritas);
            $query->where('prioritas', $prioritas);
        }

        // 3. Filter berdasarkan Rentang Tanggal Terima (Tanggal Mulai)
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_terima', '>=', $request->tanggal_mulai);
        }

        // 4. Filter berdasarkan Rentang Tanggal Terima (Tanggal Selesai)
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_terima', '<=', $request->tanggal_selesai);
        }

        // Ambil data yang sudah difilter dan tambahkan paginasi (disarankan)
        // Jika Anda ingin tetap menggunakan get() tanpa paginasi, ubah .paginate(10) menjadi .get()
        $suratMasuk = $query->paginate(10);
        // ATAU: $suratMasuk = $query->get();

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surat-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'nullable|string|max:100|unique:surat_masuk,nomor_surat',
            'tanggal_terima' => 'required|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('lampiran')) {
            $filePath = $request->file('lampiran')->store('surat_masuk_lampiran', 'public');
            $validatedData['lampiran'] = $filePath;
        }

        $id_pengguna = Auth::id();
        $validatedData['id_pengguna'] = $id_pengguna;

        $suratMasuk = SuratMasuk::create($validatedData);

        // === 🔔 Kirim Notifikasi WhatsApp ke semua user ===
        $this->sendWhatsAppNotification($suratMasuk);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat Masuk berhasil ditambahkan dan notifikasi dikirim.');
    }

    /**
     * Kirim notifikasi WA ke semua pengguna.
     */
    private function sendWhatsAppNotification($suratMasuk)
    {
        // Tentukan waktu salam otomatis
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

        // Format pesan WhatsApp
        $message = "👋 *Halo, {$salam} Karyawan PD Baratala!*\n\n"
            . "──────────────────────────────\n"
            . "📬 *SURAT MASUK BARU TELAH DITERIMA*\n"
            . "──────────────────────────────\n\n"
            . "📌 *Judul:* _{$suratMasuk->judul}_\n"
            . "✉️ *Pengirim:* _{$suratMasuk->pengirim}_\n"
            . "⚡ *Prioritas:* _" . ucfirst($suratMasuk->prioritas) . "_\n"
            . "📅 *Tanggal Terima:* _{$suratMasuk->tanggal_terima}_\n\n"
            . "🗂️ Silakan cek detailnya di sistem untuk tindak lanjut lebih lanjut.\n\n"
            . "──────────────────────────────\n"
            . "📎 _Notifikasi otomatis dari Sistem Baratala_";

        // Kirim ke grup WhatsApp kantor
        \App\Helpers\WhatsAppHelper::sendToGroup($message);
    }




    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        // 1. Validasi data
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'nomor_surat' => 'nullable|string|max:100|unique:surat_masuk,nomor_surat,' . $suratMasuk->id,
            'tanggal_terima' => 'required|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // File opsional
            'keterangan' => 'nullable|string',
        ]);

        // 2. Proses update lampiran
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($suratMasuk->lampiran) {
                Storage::disk('public')->delete($suratMasuk->lampiran);
            }

            // Simpan file baru
            $filePath = $request->file('lampiran')->store('surat_masuk_lampiran', 'public');
            $validatedData['lampiran'] = $filePath;
        }
        // Jika tidak ada file baru dan Anda ingin memberikan opsi hapus file lama,
        // Anda mungkin perlu menambahkan checkbox di form edit (diasumsikan tidak ada)

        // 3. Update database
        $suratMasuk->update($validatedData);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        // Hapus lampiran fisik (jika ada) sebelum menghapus record database
        if ($suratMasuk->lampiran) {
            Storage::disk('public')->delete($suratMasuk->lampiran);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat Masuk berhasil dihapus.');
    }
}

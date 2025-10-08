<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Pengguna;
use App\Models\Komentar; // Ditambahkan: Model Komentar diperlukan untuk fitur komentar
use Illuminate\Support\Facades\Auth;

class RencanaControllerKaryawan extends Controller
{
    /**
     * Menampilkan daftar tugas (rencana) yang ditugaskan kepada pengguna yang sedang login.
     * Tugas yang dibuat sendiri juga otomatis masuk karena creator dimasukkan ke pivot di store().
     */
    public function index()
    {
        // Ambil semua tugas, urutkan terbaru dulu
        $tugas = Tugas::orderBy('created_at', 'desc')->where('id_pengguna', Auth::id())
            ->orWhereHas('pengguna', function ($query) {
                $query->where('pengguna.id', Auth::id());
            })->get();
        // dd($tugas);
        return view('karyawan.rencana.index', compact('tugas'));
    }

    /**
     * Menampilkan formulir untuk membuat tugas baru.
     */
    public function create()
    {
        // Ambil semua pengguna kecuali dirinya sendiri untuk penugasan
        $users = Pengguna::where('id', '!=', auth()->id())->get();
        return view('karyawan.rencana.create', compact('users'));
    }

    /**
     * Menyimpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_rencana'    => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|string',
            'jenis'            => 'required|string',
            'prioritas'        => 'nullable|string',
            'lampiran'         => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'catatan'          => 'nullable|string',
            'pengguna'         => 'nullable|string', // Hidden input, koma dipisahkan
        ]);

        // Simpan user yang membuat tugas (sebagai pembuat)
        $validated['id_pengguna'] = Auth::id();

        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('public/uploads');
            $validated['lampiran'] = str_replace('public/', '', $lampiranPath);
        }

        // Simpan tugas
        $tugas = Tugas::create($validated);

        // Ambil id pengguna dari input (pecah string jadi array)
        $penggunaIds = [];
        if (!empty($request->pengguna)) {
            $penggunaIds = array_filter(explode(',', $request->pengguna));
        }

        // Tambahkan user yang sedang login (pembuat) ke daftar pengguna yang ditugaskan
        $penggunaIds[] = Auth::id();

        // Hilangkan duplikasi & validasi hanya id yang valid di tabel pengguna
        $penggunaIds = Pengguna::whereIn('id', array_unique($penggunaIds))->pluck('id')->toArray();

        // Simpan ke pivot
        $tugas->pengguna()->sync($penggunaIds);

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail tugas, termasuk daftar pengguna dan komentar.
     */
    public function show($id)
    {
        // Eager load pengguna yang ditugaskan dan komentar beserta penggunanya
        $tugas = Tugas::with(['pengguna', 'komentar.pengguna'])->findOrFail($id);

        // Ambil semua pengguna untuk opsi penugasan (jika diperlukan di view detail)
        $allUsers = Pengguna::all();

        return view('karyawan.rencana.detail', compact('tugas', 'allUsers'));
    }

    /**
     * Menampilkan formulir untuk mengedit tugas.
     */
    public function edit($id)
    {
        $rencana = Tugas::with(['pengguna', 'komentar.pengguna'])->findOrFail($id);
        // Ambil semua pengguna kecuali dirinya sendiri untuk penugasan
        $users = Pengguna::where('id', '!=', auth()->id())->get();
        return view('karyawan.rencana.edit', compact('rencana', 'users'));
    }

    /**
     * Memperbarui tugas di database.
     */
    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $validated = $request->validate([
            'judul_rencana'    => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|string',
            'jenis'            => 'required|string',
            'prioritas'        => 'nullable|string',
            'lampiran'         => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'catatan'          => 'nullable|string',
            'pengguna'         => 'nullable|string', // Hidden input, koma dipisahkan - DITAMBAHKAN
        ]);

        // Kalau ada lampiran baru, simpan
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('public/uploads');
            $validated['lampiran'] = str_replace('public/', '', $lampiranPath);
        }

        // Update tugas
        $tugas->update($validated);

        // Update pivot pengguna (logika sama seperti store)
        $penggunaIds = [];
        if (!empty($request->pengguna)) {
            $penggunaIds = array_filter(explode(',', $request->pengguna));
        }

        // Tambahkan user yang sedang login (pembuat/editor) ke daftar pengguna yang ditugaskan
        $penggunaIds[] = Auth::id();

        // Hilangkan duplikasi & validasi hanya id yang valid
        $penggunaIds = Pengguna::whereIn('id', array_unique($penggunaIds))->pluck('id')->toArray();

        // Sync pivot → otomatis tambah kalau ada id baru, hapus kalau tidak ada lagi
        $tugas->pengguna()->sync($penggunaIds);

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil diperbarui.');
    }

    /**
     * Menyimpan komentar/progres dari karyawan pada tugas tertentu.
     */
    public function komentar(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'isi_komentar' => 'required|string|max:1000', // Mengubah nama field agar lebih generik
        ]);

        // Pastikan tugas ada
        $tugas = Tugas::findOrFail($id);

        // Simpan komentar dengan status 'menunggu' untuk diverifikasi Direktur
        Komentar::create([
            'tugas_id'    => $tugas->id,
            'pengguna_id' => Auth::id(),  // Ambil user yang login (karyawan)
            'isi'         => $request->isi_komentar,
            'status'      => 'menunggu', // Status default dari karyawan: menunggu persetujuan/verifikasi direktur
        ]);

        return redirect()->back()->with('success', 'Progres/Komentar berhasil ditambahkan dan menunggu persetujuan.');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil dihapus.');
    }
}

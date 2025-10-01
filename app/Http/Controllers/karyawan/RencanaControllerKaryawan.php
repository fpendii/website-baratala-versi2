<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;

class RencanaControllerKaryawan extends Controller
{
    public function index()
    {
        $tugas = Tugas::where('id_pengguna', Auth::id())->get();
        return view('karyawan.rencana.index', compact('tugas'));
    }

    public function create()
    {
        $users = Pengguna::where('id', '!=', auth()->id())->get();
        return view('karyawan.rencana.create', compact('users'));
    }


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
            'pengguna'         => 'nullable|string', // masih string di sini
        ]);

        // simpan user yang membuat tugas
        $validated['id_pengguna'] = Auth::id();

        // simpan file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('public/uploads');
            $validated['lampiran'] = str_replace('public/', '', $lampiranPath);
        }

        // simpan tugas
        $tugas = Tugas::create($validated);

        // ambil id pengguna dari input (pecah string jadi array)
        $penggunaIds = [];
        if (!empty($request->pengguna)) {
            $penggunaIds = array_filter(explode(',', $request->pengguna));
        }

        // tambahkan user login
        $penggunaIds[] = Auth::id();

        // hilangkan duplikasi & cek hanya id yang valid
        $penggunaIds = Pengguna::whereIn('id', $penggunaIds)->pluck('id')->toArray();

        // simpan ke pivot
        $tugas->pengguna()->sync($penggunaIds);

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil ditambahkan.');
    }



    public function show($id)
    {
        $tugas = Tugas::with('pengguna')->findOrFail($id);
        // dd($tugas);
        return view('karyawan.rencana.detail', compact('tugas'));
    }

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('karyawan.rencana.edit', compact('tugas'));
    }

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
        ]);

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('public/uploads');
            $validated['lampiran'] = str_replace('public/', '', $lampiranPath);
        }

        $tugas->update($validated);

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class RencanaControllerKaryawan extends Controller
{
    public function index()
    {
        $id_pengguna = 1;
        // $id_pengguna = Auth::id();
        $tugas = Tugas::where('id_pengguna', $id_pengguna)->get();
        return view('karyawan.rencana.index', compact('tugas'));
    }

    public function create()
    {
        return view('karyawan.rencana.create');
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
        ]);

        // $validated['id_pengguna'] = Auth::id();
        $validated['id_pengguna'] = 1;

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('public/uploads');
            $validated['lampiran'] = str_replace('public/', '', $lampiranPath);
        }

        Tugas::create($validated);

        return redirect()->route('karyawan.rencana.index')->with('success', 'Rencana berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tugas = Tugas::findOrFail($id);
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

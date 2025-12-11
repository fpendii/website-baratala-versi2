<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query(); // Mulai query

        // 1. Terapkan Filter Role
        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        // 2. Terapkan Pencarian (Nama atau Email)
        if ($request->filled('cari')) {
            $search = $request->cari;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Ambil daftar unik role yang tersedia untuk dropdown filter (opsional)
        $availableRoles = Pengguna::select('role')->distinct()->pluck('role');

        // Eksekusi query dengan pagination
        $pengguna = $query->paginate(10)->appends($request->query());

        // Kirim $availableRoles ke view
        return view('pengguna.index', compact('pengguna', 'availableRoles'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update($request->all());
        return redirect()->route('pengguna.index');
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);

        // Soft delete (tidak menghapus data dari DB)
        $pengguna->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}

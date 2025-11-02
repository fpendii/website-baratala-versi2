<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Session::get('pengguna'); // ambil data dari session
        $role = Session::get('role');     // role juga udah diset pas login

        return view('profil.index', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $user = \App\Models\Pengguna::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        // update field lain sesuai kebutuhan

        $user->save();

        // Update session data
        Session::put('pengguna', $user->toArray());
        Session::put('nama', $user->nama);
        Session::put('email', $user->email);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}

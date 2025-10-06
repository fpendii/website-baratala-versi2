<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class KaryawanControllerAdministrasi extends Controller
{
    public function index()
    {
        $karyawan = Pengguna::where('role', '!=', 'direktur')->paginate(10);

        return view('administrasi.karyawan.index', compact('karyawan'));
    }
}

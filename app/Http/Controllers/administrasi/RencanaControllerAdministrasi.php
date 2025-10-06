<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;

class RencanaControllerAdministrasi extends Controller
{
    public function index()
    {
         // Ambil semua tugas, urutkan terbaru dulu
        $tugas = Tugas::orderBy('created_at', 'desc')->get();
        return view('administrasi.rencana-kerja.index', compact('tugas'));
    }

    public function create()
    {
        return view('administrasi.rencana-kerja.create');
    }
}

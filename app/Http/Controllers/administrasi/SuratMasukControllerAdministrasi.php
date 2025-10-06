<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;

class SuratMasukControllerAdministrasi extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::orderBy('tanggal_terima', 'desc')->get();
        return view('administrasi.surat-masuk.index', compact('suratMasuk'));
    }
}

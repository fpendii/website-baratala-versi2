<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RencanaControllerKaryawan extends Controller
{
    public function index()
    {
        return view('karyawan.rencana.index');
    }

    public function create()
    {
        return view('karyawan.rencana.create');
    }
}

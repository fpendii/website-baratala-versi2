<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanControllerDirektur extends Controller
{
    public function index(){
        return view('direktur.laporan.index');
    }
}

<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanJobdeskControllerDirektur extends Controller
{
    public function index(){
        return view('direktur.laporan_jobdesk.index');
    }
}

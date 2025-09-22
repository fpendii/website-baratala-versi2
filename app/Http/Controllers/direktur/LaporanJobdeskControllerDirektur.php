<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanJobdeskControllerDirektur extends Controller
{
    public function index(){
        return view('direktur.laporan_jobdesk.index');
    }

    public function detail(){
        return view('direktur.laporan_jobdesk.detail');
    }

    public function JobdeskKaryawan(){
        return view('direktur.laporan_jobdesk.jobdesk_karyawan');
    }

    public function detailJobdeskKaryawan(){
        $halamnJobdeskKaryawan = true;
        return view('direktur.laporan_jobdesk.detail_jobdesk_karyawan');
    }
}

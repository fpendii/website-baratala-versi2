<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Contracts\Queue\Job;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuratMasukBulanIni = SuratMasuk::whereMonth('created_at', date('m'))->count();
        $totalPengguna = Pengguna::count();
        $totalSuratKeluarBulanIni = SuratKeluar::whereMonth('created_at', date('m'))->count();
        return view('dashboard.index', compact('totalSuratMasukBulanIni', 'totalPengguna', 'totalSuratKeluarBulanIni'));
    }
}

<?php

namespace App\Http\Controllers\KepalaTeknik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardControllerKepalaTeknik extends Controller
{
    public function index()
    {
        return view('karyawan.dashboard.index');
    }
}

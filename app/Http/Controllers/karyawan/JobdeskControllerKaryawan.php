<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobdeskControllerKaryawan extends Controller
{
    public function index()
    {
        return view('karyawan.jobdesk.index');
    }

    public function create()
    {
        return view('karyawan.jobdesk.create');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\SuratMasuk;
use Illuminate\Contracts\Queue\Job;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard.index');
    }
}

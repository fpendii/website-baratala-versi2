<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobdesk;

class JobdeskControllerAdministrasi extends Controller
{
    public function index()
    {
        $jobdesks = Jobdesk::all();
        return view('administrasi.jobdesk.index', compact('jobdesks'));
    }
}

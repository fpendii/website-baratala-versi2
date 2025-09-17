<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobdDeskControllerDirektur extends Controller
{
    public function index(){
        return view('jobdesk.index');
    }
}

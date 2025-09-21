<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobdDeskControllerDirektur extends Controller
{
    public function index(){
        return view('direktur.jobdesk.index');
    }

    public function create(){
        return view('direktur.jobdesk.create');
    }

    public function edit($id){
        return view('direktur.jobdesk.edit');
    }
}

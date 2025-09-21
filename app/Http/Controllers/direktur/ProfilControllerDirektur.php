<?php

namespace App\Http\Controllers\direktur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilControllerDirektur extends Controller
{
    public function index(){
        return view('direktur.profil.index');
    }
}

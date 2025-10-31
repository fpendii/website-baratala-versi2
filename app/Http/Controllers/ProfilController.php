<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Session::get('pengguna'); // ambil data dari session
        $role = Session::get('role');     // role juga udah diset pas login

        return view('profil.index', compact('user'));
    }
}

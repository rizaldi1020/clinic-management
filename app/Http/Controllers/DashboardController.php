<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }

    public function dokter()
    {
        return view('dashboard.dokter');
    }

    public function resepsionis()
    {
        return view('dashboard.resepsionis');
    }

    public function apoteker()
    {
        return view('dashboard.apoteker');
    }

    public function kasir()
    {
        return view('dashboard.kasir');
    }

    public function pasien()
    {
        return view('dashboard.pasien');
    }
}

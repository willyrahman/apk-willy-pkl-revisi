<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IbuHamil;
use App\Models\Odgj;
use App\Models\Hipertensi;
use App\Models\Lansia;
use App\Models\Balita; // Pastikan Model Balita di-import

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalibuhamil'   => IbuHamil::count(),
            'totalodgj'       => Odgj::count(),
            'totalhipertensi' => Hipertensi::count(),
            'totallansia'     => Lansia::count(),
            'totalbalita'     => Balita::count(), // <--- KIRIM DATA BALITA KE VIEW
        ]);
    }
}

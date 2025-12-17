<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// Import Model-Model Baru
use App\Models\Odgj;
use App\Models\IbuHamil;
use App\Models\Hipertensi;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Total ODGJ
        // Pastikan Anda sudah membuat Model Odgj (php artisan make:model Odgj)
        $totalodgj = Odgj::count();

        // 2. Menghitung Total Ibu Hamil
        // Pastikan Anda sudah membuat Model IbuHamil
        $totalibuhamil = IbuHamil::count();

        // 3. Menghitung Total Hipertensi
        // Pastikan Anda sudah membuat Model Hipertensi
        $totalhipertensi = Hipertensi::count();

        // 4. Menghitung Total Petugas (User)
        $totalPetugas = User::where('role', 'operator')->orWhere('role', 'admin')->count();

        // Kirim variabel-variabel ini ke View
        return view('dashboard', compact('totalodgj', 'totalibuhamil', 'totalhipertensi', 'totalPetugas'));
    }
}

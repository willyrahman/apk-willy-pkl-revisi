<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;

// Import Controller Utama
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\OdgjController;
use App\Http\Controllers\HipertensiController;
use App\Http\Controllers\BalitaController; // <--- PENTING: Tambahkan Import Ini
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rute Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pengalihan Berdasarkan Role
Route::get('/home', function () {
    if (Auth::user()->role == 'admin') {
        return redirect('/dashboard');
    } elseif (Auth::user()->role == 'operator') {
        return redirect('/scan');
    }
    return redirect('/');
})->middleware('auth');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

// Grup Middleware Auth
Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', DashboardController::class);

    // --- MODIFIKASI MENU UTAMA ---

    // 1. Menu Ibu Hamil
    Route::resource('ibuHamil', IbuHamilController::class);

    // 2. Menu ODGJ
    Route::resource('odgj', OdgjController::class);

    // 3. Menu Hipertensi
    Route::resource('hipertensi', HipertensiController::class);

    // 4. Menu Balita (PERBAIKAN: DITAMBAHKAN DI SINI)
    // Ini akan membuat route: balita.index, balita.store, balita.update, balita.destroy
    Route::resource('balita', BalitaController::class);
    // 5. Menu Lansia
    Route::resource('lansia', LansiaController::class);

    Route::middleware(['is_admin'])->group(function () {
        Route::resource('petugas', PetugasController::class);
    });

    // 6. Menu Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/ibu-hamil', [LaporanController::class, 'ibuHamil'])->name('ibuHamil');
        Route::get('/odgj', [LaporanController::class, 'odgj'])->name('odgj');
        Route::get('/hipertensi', [LaporanController::class, 'hipertensi'])->name('hipertensi');
        Route::get('/balita', [LaporanController::class, 'balita'])->name('balita');
        Route::get('/lansia', [LaporanController::class, 'lansia'])->name('lansia');

        Route::get('/export/pdf/{jenis}', [LaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel/{jenis}', [LaporanController::class, 'exportExcel'])->name('export.excel');
    });

    // -------------------------------

    // Route operasional scan (tetap dipertahankan jika masih dipakai)
    Route::get('/scan', [BorrowController::class, 'showBorrowForm'])->name('scan');
    Route::post('/scan-barcode', [BorrowController::class, 'scanBarcode'])->name('scanBarcode');
    Route::post('/borrow/add-to-cart', [BorrowController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/borrow/process', [BorrowController::class, 'processBorrow'])->name('process.borrow');
    Route::get('/borrow', [BorrowController::class, 'showBorrowForm'])->name('show.borrow.form');
});

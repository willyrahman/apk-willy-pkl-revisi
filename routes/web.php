<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RecapController;

// Import Controller Utama
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\OdgjController;
use App\Http\Controllers\HipertensiController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ====================================================
// 1. RUTE AUTH (Login & Logout)
// ====================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================================================
// 2. RUTE PENGALIHAN (Redirect setelah Login)
// ====================================================
Route::get('/home', function () {
    $role = Auth::user()->role;

    // Jika Operator (Scan), arahkan ke halaman scan
    if ($role == 'operator') {
        return redirect()->route('scan');
    }

    // Admin, Petugas, Kepala semuanya masuk ke Dashboard
    return redirect()->route('dashboard.index');
})->middleware('auth');

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

// ====================================================
// 3. GRUP UTAMA (Bisa diakses SEMUA User Login)
// ====================================================
Route::middleware(['auth'])->group(function () {

    // --- MENU UMUM (Dashboard & Data Pasien) ---
    // Admin, Petugas, Kepala BISA akses ini
    Route::resource('dashboard', DashboardController::class);
    Route::resource('ibuHamil', IbuHamilController::class);
    Route::resource('odgj', OdgjController::class);
    Route::resource('hipertensi', HipertensiController::class);
    Route::resource('balita', BalitaController::class);
    Route::resource('lansia', LansiaController::class);

    // --- MENU LAPORAN ---
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/ibu-hamil', [LaporanController::class, 'ibuHamil'])->name('ibuHamil');
        Route::get('/odgj', [LaporanController::class, 'odgj'])->name('odgj');
        Route::get('/hipertensi', [LaporanController::class, 'hipertensi'])->name('hipertensi');
        Route::get('/balita', [LaporanController::class, 'balita'])->name('balita');
        Route::get('/lansia', [LaporanController::class, 'lansia'])->name('lansia');

        Route::get('/export/pdf/{jenis}', [LaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel/{jenis}', [LaporanController::class, 'exportExcel'])->name('export.excel');
    });

    // ====================================================
    // 4. RUTE KHUSUS ADMIN (Hanya Admin)
    // ====================================================
    // Petugas & Kepala AKAN DITOLAK jika mencoba akses ini
    Route::middleware(['is_admin'])->group(function () {
        Route::resource('petugas', PetugasController::class);
    });

    // ====================================================
    // 5. RUTE KHUSUS KEPALA (Hanya Kepala)
    // ====================================================
    Route::middleware(['is_kepala'])->group(function () {
        Route::get('/laporan/persetujuan', [LaporanController::class, 'persetujuan'])->name('laporan.persetujuan');
    });

    // ====================================================
    // 6. RUTE LAINNYA (Opsional/Legacy)
    // ====================================================
    Route::get('/scan', [BorrowController::class, 'showBorrowForm'])->name('scan');
    Route::post('/scan-barcode', [BorrowController::class, 'scanBarcode'])->name('scanBarcode');
    Route::post('/borrow/add-to-cart', [BorrowController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/borrow/process', [BorrowController::class, 'processBorrow'])->name('process.borrow');
    Route::get('/borrow', [BorrowController::class, 'showBorrowForm'])->name('show.borrow.form');
});

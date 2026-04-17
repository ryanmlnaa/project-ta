<?php

use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return redirect()->route('dashboard.index');
});

Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard.index');

    // ===============================
    // Routes untuk Penghuni
    // ===============================
    Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni.index');
    Route::get('/penghuni/create', [PenghuniController::class, 'create'])->name('penghuni.create');
    Route::post('/penghuni/store', [PenghuniController::class, 'store'])->name('penghuni.store');
    Route::get('/penghuni/edit/{id}', [PenghuniController::class, 'edit'])->name('penghuni.edit');
    Route::put('/penghuni/update/{id}', [PenghuniController::class, 'update'])->name('penghuni.update');
    Route::get('/penghuni/delete/{id}', [PenghuniController::class, 'destroy'])->name('penghuni.delete');

    // ===============================
    // Routes untuk Iuran
    // ===============================
    Route::get('/iuran', [IuranController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/create', [IuranController::class, 'create'])->name('iuran.create');
    Route::post('/iuran/store', [IuranController::class, 'store'])->name('iuran.store');
    Route::get('/iuran/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
    Route::put('/iuran/update/{id}', [IuranController::class, 'update'])->name('iuran.update');
    Route::delete('/iuran/delete/{id}', [IuranController::class, 'destroy'])->name('iuran.destroy');

        // ==============================
    // Routes untuk Layanan
    // ==============================

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');

    // simpan pengaduan (dari form/modal)
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');

    // tanggapi pengaduan (modal tanggapan admin)
    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])->name('layanan.tanggapi');

    // hapus data
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');
});

Route::prefix('admin')->group(function () {
    Route::resource('iuran', IuranController::class);
});


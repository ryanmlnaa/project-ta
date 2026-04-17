<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

// LOGIN
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');

// REGISTER
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // =========================
    // PENGHUNI
    // =========================
    Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni.index');
    Route::get('/penghuni/create', [PenghuniController::class, 'create'])->name('penghuni.create');
    Route::post('/penghuni/store', [PenghuniController::class, 'store'])->name('penghuni.store');
    Route::get('/penghuni/edit/{id}', [PenghuniController::class, 'edit'])->name('penghuni.edit');
    Route::put('/penghuni/update/{id}', [PenghuniController::class, 'update'])->name('penghuni.update');
    Route::get('/penghuni/delete/{id}', [PenghuniController::class, 'destroy'])->name('penghuni.delete');

    // =========================
    // RUMAH (FIX TOTAL)
    // =========================
    Route::post('/rumah/store', [PenghuniController::class, 'storeRumah'])->name('rumah.store');

    Route::get('/rumah/{id}/edit', [PenghuniController::class, 'editRumah'])
        ->name('rumah.edit');

    // 🔥 INI YANG DIPAKAI UNTUK UPDATE (SUDAH FIX)
    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah'])
        ->name('admin.rumah.update');

    Route::delete('/rumah/{id}', [PenghuniController::class, 'destroyRumah'])
        ->name('rumah.destroy');


    // =========================
    // IURAN
    // =========================
    Route::get('/iuran', [IuranController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/create', [IuranController::class, 'create'])->name('iuran.create');
    Route::post('/iuran/store', [IuranController::class, 'store'])->name('iuran.store');
    Route::get('/iuran/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
    Route::put('/iuran/update/{id}', [IuranController::class, 'update'])->name('iuran.update');
    Route::delete('/iuran/delete/{id}', [IuranController::class, 'destroy'])->name('iuran.delete');

    // =========================
    // LAYANAN
    // =========================
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])->name('layanan.tanggapi');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');

    // INFORMASI
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
    Route::post('/informasi/store', [InformasiController::class, 'store'])->name('informasi.store');

    Route::get('/test-view', function () {
    return view('admin.informasi.index');
});

    // LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    //user
    Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.delete');

});


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('user.home');

    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('user.profil.update');

    Route::get('/rumah', [UserController::class, 'rumah'])->name('user.rumah');

    Route::get('/user/pilih-rumah/{id}', [UserController::class, 'pilihRumah'])
        ->name('user.pilih.rumah');

    Route::post('/user/simpan-rumah', [UserController::class, 'simpanRumah'])
        ->name('user.simpan.rumah');

    Route::post('/user/simpan-penghuni', [UserController::class, 'simpanPenghuni'])
        ->name('user.simpan.penghuni');

    Route::post('/user/ambil-rumah', [UserController::class, 'ambilRumah'])
        ->name('user.ambil.rumah');

    // 🔥 USER UPDATE RUMAH (OPSIONAL)
    Route::put('/user/rumah/update/{id}', [PenghuniController::class, 'updateRumah']);

    Route::get('/iuran', [UserController::class, 'iuran'])->name('user.iuran');

    Route::get('/pengaduan', [UserController::class, 'pengaduan'])->name('user.pengaduan');
    Route::post('/pengaduan/store', [UserController::class, 'storePengaduan'])
        ->name('user.pengaduan.store');

    Route::get('/pengumuman', [UserController::class, 'pengumuman'])->name('user.pengumuman');

    // Upload pembayaran
    Route::get('/upload-pembayaran', [UserController::class, 'uploadPembayaran'])
        ->name('user.upload.pembayaran');

    // Status pembayaran
    Route::get('/status-pembayaran', [UserController::class, 'statusPembayaran'])
        ->name('user.status.pembayaran');

    // Status pengaduan
    Route::get('/status-pengaduan', [UserController::class, 'statusPengaduan'])
        ->name('user.status.pengaduan');

    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])
    ->name('user.upload.photo');
});

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
use App\Http\Controllers\UserIuranController;
use App\Http\Controllers\UserLayananController;
use App\Http\Controllers\DashboardController;

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

Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.forgot');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.sendOtp');

Route::get('/verify-otp', [AuthController::class, 'otpForm'])->name('password.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verifyOtp');

Route::get('/reset-password', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

// ✅ SESUDAH: tambah ->name('admin.')
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // ✅ FIX: Pakai DashboardController, bukan closure
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

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
    // RUMAH
    // =========================
    Route::post('/rumah/store', [PenghuniController::class, 'storeRumah'])->name('rumah.store');
    Route::get('/rumah/{id}/edit', [PenghuniController::class, 'editRumah'])->name('rumah.edit');
    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah'])->name('admin.rumah.update');
    Route::delete('/rumah/{id}', [PenghuniController::class, 'destroyRumah'])->name('rumah.destroy');
    Route::get('/bagi-rt', [PenghuniController::class, 'bagiRT'])->name('bagi.rt');

    // =========================
    // IURAN
    // =========================
    Route::prefix('iuran')->group(function () {
        Route::get('/', [IuranController::class, 'index'])->name('iuran.index');
        Route::get('/create', [IuranController::class, 'create'])->name('iuran.create');
        Route::post('/store', [IuranController::class, 'store'])->name('iuran.store');
        Route::get('/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
        Route::put('/update/{id}', [IuranController::class, 'update'])->name('iuran.update');
        Route::delete('/{id}', [IuranController::class, 'destroy'])->name('iuran.destroy');
        Route::post('/approve/{id}', [IuranController::class, 'approve'])->name('iuran.approve');
        Route::get('/user', [UserIuranController::class, 'index'])->name('user.iuran');
    });

    Route::post('/iuran/{id}/approve-admin', [IuranController::class, 'approveAdmin'])->name('iuran.approve.admin');

    // =========================
    // LAYANAN
    // =========================
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])->name('layanan.tanggapi');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');
    Route::post('/layanan/{id}/approve-admin', [LayananController::class, 'approveAdmin'])->name('layanan.approve.admin');

    // =========================
    // INFORMASI
    // =========================
    Route::resource('informasi', InformasiController::class);

    // =========================
    // LAPORAN
    // =========================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // =========================
    // USER MANAGEMENT
    // =========================
    Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/create', [AdminUserController::class, 'create'])->name('admin.user.create');
    Route::post('/user/store', [AdminUserController::class, 'store'])->name('admin.user.store');
    Route::get('/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/user/update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
    Route::delete('/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.delete');

});

/*
|--------------------------------------------------------------------------
| RT
|--------------------------------------------------------------------------
*/

// ✅ FIX: Dashboard RT dengan DashboardController
Route::middleware(['auth', 'role:rt'])->group(function () {

    Route::get('/rt/dashboard', [DashboardController::class, 'index'])->name('rt.dashboard');

    Route::get('/rt/penghuni', [PenghuniController::class, 'indexRT'])->name('rt.penghuni');
    Route::get('/rt/rumah', [PenghuniController::class, 'rumahRT'])->name('rt.rumah');
    Route::get('/rt/iuran', [IuranController::class, 'index'])->name('rt.iuran');

    Route::post('/iuran/{id}/approve-rt', [IuranController::class, 'approveRT'])->name('iuran.approve.rt');
    Route::post('/layanan/{id}/tanggapi-rt', [LayananController::class, 'tanggapiRT'])->name('layanan.tanggapi.rt');

});

// Profil RT
Route::middleware(['auth'])->group(function () {
    Route::get('/rt/profile', [ProfileController::class, 'editProfile'])->name('rt.profile');
    Route::post('/rt/profile/update', [ProfileController::class, 'updateprofile'])->name('rt.updateprofile');
    Route::post('/rt/profile/upload-photo', [ProfileController::class, 'uploadPhotoRT'])->name('rt.upload.photo');
});

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('user.home');
    Route::get('/home', [UserController::class, 'index']);

    // PROFIL
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('user.profil.update');

    // PENGHUNI
    Route::post('/simpan-penghuni', [UserController::class, 'simpanPenghuni'])->name('user.simpan.penghuni');

    // RUMAH
    Route::get('/rumah', [UserController::class, 'rumah'])->name('user.rumah');
    Route::post('/pilih-rumah/{id}', [UserController::class, 'pilihRumah'])->name('user.pilih.rumah');
    Route::post('/simpan-rumah', [UserController::class, 'simpanRumah'])->name('user.simpan.rumah');
    Route::post('/ambil-rumah', [UserController::class, 'ambilRumah'])->name('user.ambil.rumah');
    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah']);

    // IURAN
    Route::get('/iuran', [UserIuranController::class, 'index'])->name('user.iuran.index');
    Route::get('/iuran/upload/{id}', [UserIuranController::class, 'upload'])->name('user.iuran.upload');
    Route::post('/iuran/upload/{id}', [UserIuranController::class, 'storeUpload'])->name('user.iuran.storeUpload');
    Route::post('/iuran/qris/{id}', [UserIuranController::class, 'bayarQris'])->name('user.iuran.qris');
    Route::delete('/iuran/delete/{id}', [UserIuranController::class, 'delete'])->name('user.iuran.delete');

    // LAYANAN
    Route::prefix('layanan')->group(function () {
        Route::get('/', [UserLayananController::class, 'create'])->name('user.layanan.create');
        Route::post('/store', [UserLayananController::class, 'store'])->name('user.layanan.store');
        Route::get('/status', [UserLayananController::class, 'status'])->name('user.layanan.status');
    });
    Route::delete('/layanan/delete/{id}', [UserLayananController::class, 'delete'])->name('user.layanan.delete');

    // INFORMASI
    Route::get('/informasi/{id}', [UserController::class, 'detailInformasi'])->name('user.informasi.detail');

    // LAINNYA
    Route::get('/pengumuman', [UserController::class, 'pengumuman'])->name('user.pengumuman');
    Route::get('/upload-pembayaran', [UserController::class, 'uploadPembayaran'])->name('user.upload.pembayaran');
    Route::get('/status-pembayaran', [UserController::class, 'statusPembayaran'])->name('user.status.pembayaran');
    Route::get('/status-pengaduan', [UserController::class, 'statusPengaduan'])->name('user.status.pengaduan');

    // PROFILE
Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('user.upload.photo');

Route::get('/profile', [ProfileController::class, 'profil'])->name('user.profile');

Route::put('/profile/update', [ProfileController::class, 'updateProfil'])->name('user.profile.update');

});

/*
|--------------------------------------------------------------------------
| GLOBAL
|--------------------------------------------------------------------------
*/

Route::get('/admin/iuran/realtime', [IuranController::class, 'realtime'])->name('iuran.realtime');
Route::resource('iuran', IuranController::class);

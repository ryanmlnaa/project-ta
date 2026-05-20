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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // PENGHUNI
    Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni.index');
    Route::get('/penghuni/create', [PenghuniController::class, 'create'])->name('penghuni.create');
    Route::post('/penghuni/store', [PenghuniController::class, 'store'])->name('penghuni.store');
    Route::get('/penghuni/edit/{id}', [PenghuniController::class, 'edit'])->name('penghuni.edit');
    Route::put('/penghuni/update/{id}', [PenghuniController::class, 'update'])->name('penghuni.update');
    Route::get('/penghuni/delete/{id}', [PenghuniController::class, 'destroy'])->name('penghuni.delete');

    // RUMAH
    Route::post('/rumah/store', [PenghuniController::class, 'storeRumah'])->name('rumah.store');
    Route::get('/rumah/{id}/edit', [PenghuniController::class, 'editRumah'])->name('rumah.edit');
    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah'])->name('rumah.update');
    Route::delete('/rumah/{id}', [PenghuniController::class, 'destroyRumah'])->name('rumah.destroy');
    Route::get('/bagi-rt', [PenghuniController::class, 'bagiRT'])->name('bagi.rt');

    // IURAN
    Route::prefix('iuran')->name('iuran.')->group(function () {
        Route::get('/', [IuranController::class, 'index'])->name('index');
        Route::get('/create', [IuranController::class, 'create'])->name('create');
        Route::post('/store', [IuranController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [IuranController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [IuranController::class, 'update'])->name('update');
        Route::delete('/{id}', [IuranController::class, 'destroy'])->name('destroy');
        Route::post('/approve/{id}', [IuranController::class, 'approve'])->name('approve');
        Route::get('/user', [UserIuranController::class, 'index'])->name('user');
    });

    Route::post('/iuran/{id}/approve-admin', [IuranController::class, 'approveAdmin'])->name('iuran.approve.admin');

    // LAYANAN
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])->name('layanan.tanggapi');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');
    Route::post('/layanan/{id}/approve-admin', [LayananController::class, 'approveAdmin'])->name('layanan.approve.admin');

    // ✅ FIX UTAMA: Tambah ->names([...]) agar nama route pakai prefix admin.
    Route::resource('informasi', InformasiController::class)->names([
        'index'   => 'admin.informasi.index',
        'create'  => 'admin.informasi.create',
        'store'   => 'admin.informasi.store',
        'show'    => 'admin.informasi.show',
        'edit'    => 'admin.informasi.edit',
        'update'  => 'admin.informasi.update',
        'destroy' => 'admin.informasi.destroy',
    ]);

    // LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // USER MANAGEMENT
    Route::get('/user', [AdminUserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [AdminUserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [AdminUserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [AdminUserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('user.delete');

});

/*
|--------------------------------------------------------------------------
| RT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:rt'])->group(function () {

    Route::get('/rt/dashboard', [DashboardController::class, 'index'])->name('rt.dashboard');
    Route::get('/rt/penghuni', [PenghuniController::class, 'indexRT'])->name('rt.penghuni');
    Route::get('/rt/rumah', [PenghuniController::class, 'rumahRT'])->name('rt.rumah');
    Route::get('/rt/iuran', [IuranController::class, 'index'])->name('rt.iuran');

    Route::post('/iuran/{id}/approve-rt', [IuranController::class, 'approveRT'])->name('iuran.approve.rt');
    Route::post('/layanan/{id}/tanggapi-rt', [LayananController::class, 'tanggapiRT'])->name('layanan.tanggapi.rt');

});

// Profil RT & Admin (tidak perlu role spesifik, cukup auth)
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

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/home', [UserController::class, 'index']);

    // PROFIL
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('profil.update');

    // PENGHUNI
    Route::post('/simpan-penghuni', [UserController::class, 'simpanPenghuni'])->name('simpan.penghuni');

    // RUMAH
    Route::get('/rumah', [UserController::class, 'rumah'])->name('rumah');
    Route::post('/pilih-rumah/{id}', [UserController::class, 'pilihRumah'])->name('pilih.rumah');
    Route::post('/simpan-rumah', [UserController::class, 'simpanRumah'])->name('simpan.rumah');
    Route::post('/ambil-rumah', [UserController::class, 'ambilRumah'])->name('ambil.rumah');
    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah']);

    // IURAN
    Route::get('/iuran', [UserIuranController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/upload/{id}', [UserIuranController::class, 'upload'])->name('iuran.upload');
    Route::post('/iuran/upload/{id}', [UserIuranController::class, 'storeUpload'])->name('iuran.storeUpload');
    Route::post('/iuran/qris/{id}', [UserIuranController::class, 'bayarQris'])->name('iuran.qris');
    Route::delete('/iuran/delete/{id}', [UserIuranController::class, 'delete'])->name('iuran.delete');

    // LAYANAN
    Route::prefix('layanan')->name('layanan.')->group(function () {
        Route::get('/', [UserLayananController::class, 'create'])->name('create');
        Route::post('/store', [UserLayananController::class, 'store'])->name('store');
        Route::get('/status', [UserLayananController::class, 'status'])->name('status');
    });
    Route::delete('/layanan/delete/{id}', [UserLayananController::class, 'delete'])->name('layanan.delete');

    // INFORMASI
    Route::get('/informasi/{id}', [UserController::class, 'detailInformasi'])->name('informasi.detail');

    // LAINNYA
    Route::get('/pengumuman', [UserController::class, 'pengumuman'])->name('pengumuman');
    Route::get('/upload-pembayaran', [UserController::class, 'uploadPembayaran'])->name('upload.pembayaran');
    Route::get('/status-pembayaran', [UserController::class, 'statusPembayaran'])->name('status.pembayaran');
    Route::get('/status-pengaduan', [UserController::class, 'statusPengaduan'])->name('status.pengaduan');

    // PROFILE
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('upload.photo');
    Route::get('/profile', [ProfileController::class, 'profil'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfil'])->name('profile.update');

});

/*
|--------------------------------------------------------------------------
| GLOBAL
|--------------------------------------------------------------------------
*/

Route::get('/admin/iuran/realtime', [IuranController::class, 'realtime'])->name('iuran.realtime');
Route::resource('iuran', IuranController::class);

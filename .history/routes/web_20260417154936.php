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

Route::get('/test-email', function () {
    return view('emails.otp', ['otp' => 123456]);
});


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
    Route::prefix('iuran')->group(function () {
        Route::get('/', [IuranController::class, 'index'])->name('iuran.index');
        Route::get('/create', [IuranController::class, 'create'])->name('iuran.create');
        Route::post('/store', [IuranController::class, 'store'])->name('iuran.store');
        Route::get('/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
        Route::put('/iuran/update/{id}', [IuranController::class, 'update'])->name('iuran.update');
        Route::delete('/iuran/{id}', [IuranController::class, 'destroy'])->name('iuran.destroy');
        Route::post('/iuran/approve/{id}', [IuranController::class, 'approve'])->name('iuran.approve');
    });

    // =========================
    // LAYANAN
    // =========================
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])->name('layanan.tanggapi');
    Route::delete('/layanan/delete/{id}', [LayananController::class, 'destroy'])->name('layanan.delete');
    Route::prefix('admin')->group(function () {

    Route::put('/layanan/tanggapi/{id}', [LayananController::class, 'tanggapi'])
    ->name('layanan.tanggapi');

    });

    // INFORMASI
   // =======================
    // 🔥 ADMIN INFORMASI
    // =======================
    Route::middleware(['auth'])->prefix('admin')->group(function () {

        // 🔥 INFORMASI (FIX FINAL)
        Route::resource('informasi', InformasiController::class);

    });

    // LAPORAN
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

        //user
        Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('/admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/admin/user/update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.user.delete');

          Route::post('/iuran/{id}/approve-admin', [IuranController::class, 'approveAdmin'])
        ->name('iuran.approve.admin');

        Route::post('/layanan/{id}/approve-admin', [LayananController::class, 'approveAdmin'])
            ->name('layanan.approve.admin');


    });

    Route::middleware(['auth', 'cek.status'])->group(function () {

        Route::get('/layanan/create', [UserLayananController::class, 'create'])->name('user.layanan.create');

        Route::get('/layanan/status', [UserLayananController::class, 'status'])->name('user.layanan.status');

        Route::get('/iuran', [UserController::class, 'iuran'])->name('user.iuran');

    });

    // ================= RT =================
    Route::middleware(['auth', 'role:rt'])->group(function () {

        Route::get('/rt/iuran', [IuranController::class, 'index'])->name('rt.iuran');

        Route::post('/iuran/{id}/approve-rt', [IuranController::class, 'approveRT'])->name('iuran.approve.rt');

        Route::post('/layanan/{id}/tanggapi-rt', [LayananController::class, 'tanggapiRT'])->name('layanan.tanggapi.rt');

         Route::get('/rt/dashboard', [IuranController::class, 'dashboardRT'])
        ->name('rt.dashboard');

        Route::get('/rt/penghuni', [PenghuniController::class, 'indexRT'])
        ->name('rt.penghuni');

    });


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {

    // =========================
    // DASHBOARD
    // =========================
    Route::get('/', [UserController::class, 'index'])->name('user.home');

    // =========================
    // PROFIL
    // =========================
    Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
    Route::post('/profil/update', [UserController::class, 'updateProfil'])->name('user.profil.update');

    // =========================
    // 🔥 PENGHUNI (INI YANG KAMU BUTUH)
    // =========================
   Route::post('/simpan-penghuni', [UserController::class, 'simpanPenghuni'])
    ->name('user.simpan.penghuni');

    // =========================
    // RUMAH
    // =========================
    Route::get('/rumah', [UserController::class, 'rumah'])->name('user.rumah');

    Route::get('/pilih-rumah/{id}', [UserController::class, 'pilihRumah'])
        ->name('user.pilih.rumah');

    Route::post('/simpan-rumah', [UserController::class, 'simpanRumah'])
        ->name('user.simpan.rumah');

    Route::post('/ambil-rumah', [UserController::class, 'ambilRumah'])
        ->name('user.ambil.rumah');

    Route::put('/rumah/update/{id}', [PenghuniController::class, 'updateRumah']);

    // =========================
    // IURAN
    // =========================
    Route::get('/iuran', [UserIuranController::class, 'index'])->name('user.iuran.index');

    Route::get('/iuran/upload/{id}', [UserIuranController::class, 'upload'])
        ->name('user.iuran.upload');

    Route::post('/iuran/upload/{id}', [UserIuranController::class, 'storeUpload'])
        ->name('user.iuran.storeUpload');

    Route::post('/iuran/qris/{id}', [UserIuranController::class, 'bayarQris'])
        ->name('user.iuran.qris');

    Route::delete('/iuran/delete/{id}', [UserIuranController::class, 'delete'])
        ->name('user.iuran.delete');

    // =========================
    // LAYANAN
    // =========================
    Route::prefix('layanan')->group(function () {

        Route::get('/', [UserLayananController::class, 'create'])
            ->name('user.layanan.create');

        Route::post('/layanan/store', [UserLayananController::class, 'store'])
    ->name('user.layanan.store');

        Route::get('/status', [UserLayananController::class, 'status'])
            ->name('user.layanan.status');
    });

    Route::delete('/user/layanan/delete/{id}', [UserLayananController::class, 'delete'])
        ->name('user.layanan.delete');

        // =======================
    // 🔥 USER INFORMASI
    // =======================
    Route::get('/home', [UserController::class, 'index'])->name('user.home');

    Route::get('/informasi/{id}', [UserController::class, 'detailInformasi'])
        ->name('user.informasi.detail');

    // =========================
    // LAINNYA
    // =========================
    Route::get('/pengumuman', [UserController::class, 'pengumuman'])->name('user.pengumuman');

    Route::get('/upload-pembayaran', [UserController::class, 'uploadPembayaran'])
        ->name('user.upload.pembayaran');

    Route::get('/status-pembayaran', [UserController::class, 'statusPembayaran'])
        ->name('user.status.pembayaran');

    Route::get('/status-pengaduan', [UserController::class, 'statusPengaduan'])
        ->name('user.status.pengaduan');

    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])
        ->name('user.upload.photo');
});


/*
|--------------------------------------------------------------------------
| ADMIN / GLOBAL
|--------------------------------------------------------------------------
*/

Route::get('/admin/iuran/realtime', [IuranController::class, 'realtime'])
    ->name('iuran.realtime');

Route::resource('iuran', IuranController::class);

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
us
use Illuminate\Support\Facades\Mail;

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

    //     Route::get('/test-mail', function () {
    //     Mail::to('mlnryan05@gmail.com')->send(new \App\Mail\OtpMail(123456));
    //     return 'OK';
    // });

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

    Route::get('/bagi-rt', [PenghuniController::class, 'bagiRT'])->name('bagi.rt');

    Route::get('/rt/penghuni', [PenghuniController::class, 'indexRT'])->name('rt.penghuni');

//    Route::get('/rt/dashboard', [PenghuniController::class, 'dashboardRT'])
//     ->name('rt.dashboard');
    Route::get('/rt/rumah', [PenghuniController::class, 'rumahRT'])->name('rt.rumah');
    Route::get('/rt/iuran', [PenghuniController::class, 'iuranRT'])->name('rt.iuran');


    // =========================
    // IURAN
    // =========================
   Route::prefix('iuran')->group(function () {

    // ADMIN / MASTER IURAN
    Route::get('/', [IuranController::class, 'index'])->name('iuran.index');
    Route::get('/create', [IuranController::class, 'create'])->name('iuran.create');
    Route::post('/store', [IuranController::class, 'store'])->name('iuran.store');
    Route::get('/edit/{id}', [IuranController::class, 'edit'])->name('iuran.edit');
    Route::put('/update/{id}', [IuranController::class, 'update'])->name('iuran.update');
    Route::delete('/{id}', [IuranController::class, 'destroy'])->name('iuran.destroy');
    Route::post('/approve/{id}', [IuranController::class, 'approve'])->name('iuran.approve');

    // 🔥 USER IURAN (BEDAKAN URL BIAR TIDAK TABRAKAN)
    Route::get('/user', [UserIuranController::class, 'index'])->name('user.iuran');

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

    Route::get('/admin/layanan', [LayananController::class, 'indexAdmin'])
    ->name('admin.layanan');

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
        Route::get('/user/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('/user/store', [AdminUserController::class, 'store'])->name('admin.user.store');
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

     Route::get('/rt/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:rt'])
    ->name('rt.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth','role:admin'])
    ->name('admin.dashboard');

    // ================= RT =================
    Route::middleware(['auth', 'role:rt'])->group(function () {

        Route::get('/rt/iuran', [IuranController::class, 'index'])->name('rt.iuran');

        Route::post('/iuran/{id}/approve-rt', [IuranController::class, 'approveRT'])->name('iuran.approve.rt');

        Route::post('/layanan/{id}/tanggapi-rt', [LayananController::class, 'tanggapiRT'])->name('layanan.tanggapi.rt');

        //  Route::get('/rt/dashboard', [IuranController::class, 'dashboardRT'])
        // ->name('rt.dashboard');

        Route::get('/rt/penghuni', [PenghuniController::class, 'indexRT'])
        ->name('rt.penghuni');
    });

       Route::middleware(['auth'])->group(function () {
            Route::get('/rt/profile',                [ProfileController::class, 'editProfile'])->name('rt.profile');
            Route::post('/rt/profile/update',        [ProfileController::class, 'updateprofile'])->name('rt.updateprofile');
            Route::post('/rt/profile/upload-photo',  [ProfileController::class, 'uploadPhotoRT'])->name('rt.upload.photo');
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

    Route::post('/pilih-rumah/{id}', [UserController::class, 'pilihRumah'])
    ->name('user.pilih.rumah');

    Route::post('/simpan-rumah', [UserController::class, 'simpanRumah'])
        ->name('user.simpan.rumah');

    Route::post('/user/ambil-rumah', [UserController::class, 'ambilRumah'])
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

    Route::post('/kas/qris/{id}', [UserKasController::class, 'bayarQris'])->name('user.kas.qris');
    Route::get('/kas/upload/{id}', [UserKasController::class, 'upload'])->name('user.kas.upload');
    Route::post('/kas/upload/{id}', [UserKasController::class, 'storeUpload'])->name('user.kas.storeUpload');

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

    Route::get('/user/profil',          [ProfileController::class, 'profil'])->name('profile.edit');
    Route::put('/user/profil/update',   [ProfileController::class, 'updateProfil'])->name('user.profil.update');

    Route::post('/otp-resend', [AuthController::class, 'resendOtp'])->name('password.resendOtp');

    // HAPUS setelah testing!
Route::get('/test-wa', function () {
    $sent = \App\Services\WhatsappService::send('08xxxxxxxxxx', 'Test OTP dari Green View');
    return $sent ? 'BERHASIL ✅' : 'GAGAL ❌ — cek storage/logs/laravel.log';
});

        // Profil RT
    // Route::get('/rt/profil',          [ProfileController::class, 'rtProfil'])->name('rt.profil');
    // Route::post('/rt/profil/update',  [ProfileController::class, 'rtUpdateProfile'])->name('rt.updateprofile');

});

Route::post('/iuran/generate-massal', [IuranController::class, 'generateMassal'])->name('iuran.generate.massal');
// Bendahara - CRUD Iuran
Route::middleware(['auth', 'status.akun', 'role:bendahara', 'force.password'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/iuran', [App\Http\Controllers\Bendahara\IuranController::class, 'index'])->name('iuran.index');
    Route::get('/iuran/create', [App\Http\Controllers\Bendahara\IuranController::class, 'create'])->name('iuran.create');
    Route::post('/iuran', [App\Http\Controllers\Bendahara\IuranController::class, 'store'])->name('iuran.store');
    Route::get('/iuran/{id}/edit', [App\Http\Controllers\Bendahara\IuranController::class, 'edit'])->name('iuran.edit');
    Route::put('/iuran/{id}', [App\Http\Controllers\Bendahara\IuranController::class, 'update'])->name('iuran.update');
    Route::get('/rekap', [App\Http\Controllers\Bendahara\RekapController::class, 'index'])->name('rekap.index');
    Route::post('/rekap', [App\Http\Controllers\Bendahara\RekapController::class, 'store'])->name('rekap.store');
    Route::get('/rekap/{id}', [App\Http\Controllers\Bendahara\RekapController::class, 'show'])->name('rekap.show');
    Route::get('/kas', [App\Http\Controllers\Bendahara\KasController::class, 'index'])->name('kas.index');
    Route::post('/kas', [App\Http\Controllers\Bendahara\KasController::class, 'store'])->name('kas.store');
});

// RT - Review Iuran dari Bendahara
Route::middleware(['auth', 'status.akun', 'role:rt'])->prefix('rt')->name('rt.')->group(function () {
    Route::get('/review-iuran', [App\Http\Controllers\RT\ReviewIuranController::class, 'index'])->name('review-iuran.index');
    Route::patch('/review-iuran/{id}/setujui', [App\Http\Controllers\RT\ReviewIuranController::class, 'setujui'])->name('review-iuran.setujui');
    Route::patch('/review-iuran/{id}/tolak', [App\Http\Controllers\RT\ReviewIuranController::class, 'tolak'])->name('review-iuran.tolak');
    Route::get('/review-rekap', [App\Http\Controllers\RT\ReviewRekapController::class, 'index'])->name('review-rekap.index');
    Route::get('/review-rekap/{id}', [App\Http\Controllers\RT\ReviewRekapController::class, 'show'])->name('review-rekap.show');
    Route::patch('/review-rekap/{id}/setujui', [App\Http\Controllers\RT\ReviewRekapController::class, 'setujui'])->name('review-rekap.setujui');
    Route::patch('/review-rekap/{id}/tolak', [App\Http\Controllers\RT\ReviewRekapController::class, 'tolak'])->name('review-rekap.tolak');

    Route::get('/kas', [App\Http\Controllers\RT\KasRTController::class, 'index'])->name('kas.index');

    Route::get('/bendahara', [App\Http\Controllers\RT\BendaharaController::class, 'index'])->name('bendahara.index');
    Route::post('/bendahara', [App\Http\Controllers\RT\BendaharaController::class, 'store'])->name('bendahara.store');
    Route::patch('/bendahara/{id}/nonaktifkan', [App\Http\Controllers\RT\BendaharaController::class, 'nonaktifkan'])->name('bendahara.nonaktifkan');
});

// Bendahara - Ganti Password Wajib (login pertama)
Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/ganti-password', [App\Http\Controllers\Bendahara\GantiPasswordController::class, 'form'])->name('ganti-password.form');
    Route::post('/ganti-password', [App\Http\Controllers\Bendahara\GantiPasswordController::class, 'update'])->name('ganti-password.update');
});



/*
|--------------------------------------------------------------------------
| ADMIN / GLOBAL
|--------------------------------------------------------------------------
*/

Route::get('/admin/iuran/realtime', [IuranController::class, 'realtime'])
    ->name('iuran.realtime');

Route::resource('iuran', IuranController::class);

<?php

use App\Http\Controllers\administrasi\DashboardControllerAdministrasi;
use App\Http\Controllers\administrasi\JobdeskControllerAdministrasi;
use App\Http\Controllers\administrasi\ProfilControllerAdministrasi;
use App\Http\Controllers\administrasi\RencanaControllerAdministrasi;
use App\Http\Controllers\direktur\DashboardControllerDirektur;
use App\Http\Controllers\direktur\JobdeskControllerDirektur;
use App\Http\Controllers\direktur\KaryawanControllerDirektur;
use App\Http\Controllers\direktur\LaporanControllerDirektur;
use App\Http\Controllers\direktur\LaporanJobdeskControllerDirektur;
use App\Http\Controllers\direktur\LaporanKeuanganControllerDirektur;
use App\Http\Controllers\direktur\ProfilControllerDirektur;
use App\Http\Controllers\enginer\DashboardControllerEnginer;
use App\Http\Controllers\enginer\JobdeskControllerEnginer;
use App\Http\Controllers\enginer\ProfilControllerEnginer;
use App\Http\Controllers\enginer\RencanaControllerEnginer;
use App\Http\Controllers\karyawan\DashboardControllerKaryawan;
use App\Http\Controllers\karyawan\JobdeskControllerKaryawan;
use App\Http\Controllers\karyawan\ProfilControllerKaryawan;
use App\Http\Controllers\karyawan\RencanaControllerKaryawan;
use App\Http\Controllers\KepalaTeknik\DashboardControllerKepalaTeknik;
use App\Http\Controllers\KepalaTeknik\JobdeskControllerKepalaTeknik;
use App\Http\Controllers\KepalaTeknik\ProfilControllerKepalaTeknik;
use App\Http\Controllers\KepalaTeknik\RencanaControllerKepalaTeknik;
use App\Http\Controllers\produksi\DashboardControllerProduksi;
use App\Http\Controllers\produksi\JobdeskControllerProduksi;
use App\Http\Controllers\produksi\ProfilControllerProduksi;
use App\Http\Controllers\produksi\RencanaControllerProduksi;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\direktur\RencanaControllerDirektur;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// // Route Auth
// Route::get('/',[AuthController::class, 'login']);
// Route::get('/login',[AuthController::class, 'login'])->name('login');
// Route::post('/login',[AuthController::class, 'submitLogin'])->name('login.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'attempt'])->name('login.attempt');
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route Direktur
Route::prefix('direktur')->name('direktur.')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardControllerDirektur::class, 'index'])->name('dashboard');

    // Rencana kerja
    Route::resource('rencana', RencanaControllerDirektur::class);

    // Karyawan
    Route::resource('karyawan', KaryawanControllerDirektur::class);

    // Jobdesk (CRUD)
    Route::resource('jobdesk', JobdeskControllerDirektur::class);

    // Laporan (pakai resource biar rapih, tapi bisa disesuaikan kalau memang tidak semua method)
    Route::resource('laporan', LaporanControllerDirektur::class)->only(['index', 'show', 'update']);
    Route::get('laporan/tabel', [LaporanControllerDirektur::class, 'TampilanTabel'])->name('laporan.tabel');
    Route::get('laporan/grafik', [LaporanControllerDirektur::class, 'TampilanGrafik'])->name('laporan.grafik');
    Route::post('laporan/keputusan/{id}', [LaporanControllerDirektur::class, 'updateKeputusan'])->name('laporan.keputusan');

    // Laporan Keuangan
    Route::resource('laporan-keuangan', LaporanKeuanganControllerDirektur::class)->only(['index', 'show']);

    // Laporan Jobdesk
    Route::get('jobdesk-laporan', [LaporanJobdeskControllerDirektur::class, 'index'])->name('laporan-jobdesk.index');
    Route::get('jobdesk-laporan/detail/{id}', [LaporanJobdeskControllerDirektur::class, 'detail'])->name('laporan-jobdesk.detail');
    Route::get('jobdesk-laporan/jobdesk-karyawan', [LaporanJobdeskControllerDirektur::class, 'JobdeskKaryawan'])->name('laporan-jobdesk.karyawan');
    Route::get('jobdesk-laporan/jobdesk-karyawan/detail/{id}', [LaporanJobdeskControllerDirektur::class, 'detailJobdeskKaryawan'])->name('laporan-jobdesk.karyawan.detail');

    // Profil
    Route::resource('profil', ProfilControllerDirektur::class)->only(['index', 'edit', 'update']);
});

// Route Kepala Teknik
// Route::prefix('karyawan')->group(function () {

//     Route::get('dashboard', [DashboardControllerKepalaTeknik::class, 'index']);

//     Route::get('rencana', [RencanaControllerKepalaTeknik::class, 'index']);

//     Route::get('jobdesk', [JobdeskControllerKepalaTeknik::class, 'index']);

//     Route::get('profil', [ProfilControllerKepalaTeknik::class, 'index']);
// });

// Route Enginer
Route::prefix('enginer')->group(function () {

    Route::get('dashboard', [DashboardControllerEnginer::class, 'index']);

    Route::get('rencana', [RencanaControllerEnginer::class, 'index']);

    Route::get('jobdesk', [JobdeskControllerEnginer::class, 'index']);

    Route::get('profil', [ProfilControllerEnginer::class, 'index']);
});

// Route Produksi
Route::prefix('produksi')->group(function () {

    Route::get('dashboard', [DashboardControllerProduksi::class, 'index']);

    Route::get('rencana', [RencanaControllerProduksi::class, 'index']);

    Route::get('jobdesk', [JobdeskControllerProduksi::class, 'index']);

    Route::get('profil', [ProfilControllerProduksi::class, 'index']);
});

// Route Administrasi
Route::prefix('administrasi')->group(function () {

    Route::get('dashboard', [DashboardControllerAdministrasi::class, 'index']);

    Route::get('rencana', [RencanaControllerAdministrasi::class, 'index']);

    Route::get('jobdesk', [JobdeskControllerAdministrasi::class, 'index']);

    Route::get('profil', [ProfilControllerAdministrasi::class, 'index']);
});

// Route karyawan
Route::prefix('karyawan')->name('karyawan.')->group(function () {

    Route::get('dashboard', [DashboardControllerKaryawan::class, 'index']);

    // Route::get('rencana', [RencanaControllerKaryawan::class, 'index']);
    // Route::get('rencana/create', [RencanaControllerKaryawan::class, 'create']);

    Route::get('rencana', [RencanaControllerKaryawan::class, 'index'])->name('rencana.index');
    Route::get('rencana/create', [RencanaControllerKaryawan::class, 'create'])->name('rencana.create');
    Route::post('rencana/store', [RencanaControllerKaryawan::class, 'store'])->name('rencana.store');
    Route::get('rencana/{id}', [RencanaControllerKaryawan::class, 'show'])->name('rencana.show');
    Route::get('rencana/{id}/edit', [RencanaControllerKaryawan::class, 'edit'])->name('rencana.edit');
    Route::put('rencana/{id}', [RencanaControllerKaryawan::class, 'update'])->name('rencana.update');
    Route::get('rencana', [RencanaControllerKaryawan::class, 'index'])->name('rencana.index');
    Route::delete('rencana/delete/{id}', [RencanaControllerKaryawan::class, 'destroy'])->name('rencana.destroy');

    Route::get('jobdesk', [JobdeskControllerKaryawan::class, 'index'])->name('jobdesk.index');
    Route::get('jobdesk/create', [JobdeskControllerKaryawan::class, 'create'])->name('jobdesk.create');
    Route::post('jobdesk/store', [JobdeskControllerKaryawan::class, 'store'])->name('jobdesk.store');
    Route::get('jobdesk/{id}', [JobdeskControllerKaryawan::class, 'show'])->name('jobdesk.show');
    Route::get('jobdesk/{id}/edit', [JobdeskControllerKaryawan::class, 'edit'])->name('jobdesk.edit');
    Route::put('jobdesk/{id}', [JobdeskControllerKaryawan::class, 'update'])->name('jobdesk.update');


    Route::get('profil', [ProfilControllerKaryawan::class, 'index']);
});

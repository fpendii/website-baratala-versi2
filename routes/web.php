<?php

use App\Http\Controllers\administrasi\DashboardControllerAdministrasi;
use App\Http\Controllers\administrasi\JobdeskControllerAdministrasi;
use App\Http\Controllers\administrasi\ProfilControllerAdministrasi;
use App\Http\Controllers\administrasi\RencanaControllerAdministrasi;
use App\Http\Controllers\direktur\DashboardControllerDirektur;
use App\Http\Controllers\direktur\JobdDeskControllerDirektur;
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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Direktur

Route::prefix('direktur')->group(function () {

    Route::get('dashboard', [DashboardControllerDirektur::class, 'index']);

    Route::get('jobdesk', [JobdDeskControllerDirektur::class, 'index']);
    Route::get('jobdesk/create', [JobdDeskControllerDirektur::class, 'create']);
    Route::get('jobdesk/edit/{id}', [JobdDeskControllerDirektur::class, 'edit']);
    Route::get('jobdesk/delete/{id}', [JobdDeskControllerDirektur::class, 'delete']);

    Route::get('laporan', [LaporanControllerDirektur::class, 'index']);
    Route::get('laporan/tabel', [LaporanControllerDirektur::class, 'TampilanTabel']);

    Route::get('keuangan-laporan', [LaporanKeuanganControllerDirektur::class, 'index']);

    Route::get('jobdesk-laporan', [LaporanJobdeskControllerDirektur::class, 'index']);
    Route::get('jobdesk-laporan/jobdesk-karyawan', [LaporanJobdeskControllerDirektur::class, 'JobdeskKaryawan']);

    Route::get('karyawan', [KaryawanControllerDirektur::class, 'index']);

    Route::get('profil', [ProfilControllerDirektur::class, 'index']);
});

// Route Kepala Teknik
Route::prefix('kepala-teknik')->group(function () {

    Route::get('dashboard', [DashboardControllerKepalaTeknik::class, 'index']);

    Route::get('rencana', [RencanaControllerKepalaTeknik::class, 'index']);

    Route::get('jobdesk', [JobdeskControllerKepalaTeknik::class, 'index']);

    Route::get('profil', [ProfilControllerKepalaTeknik::class, 'index']);

});

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
Route::prefix('karyawan')->group(function () {

    Route::get('dashboard', [DashboardControllerKaryawan::class, 'index']);

    Route::get('rencana', [RencanaControllerKaryawan::class, 'index']);

    Route::get('jobdesk', [JobdeskControllerKaryawan::class, 'index']);

    Route::get('profil', [ProfilControllerKaryawan::class, 'index']);

});









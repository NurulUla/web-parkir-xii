<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/

// Halaman login
Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // CRUD User
    Route::get('/users', [DashboardController::class, 'crudUser'])
        ->name('admin.user');

    Route::post('/users', [DashboardController::class, 'simpanUser'])
        ->name('admin.user.simpan');

    Route::delete('/users/hapus/{id}', [DashboardController::class, 'hapusUser'])
        ->name('admin.user.hapus');


    // CRUD Tarif Parkir
    Route::get('/tarif', [DashboardController::class, 'crudTarif'])
        ->name('admin.tarif');


    // CRUD Area Parkir
    Route::get('/area', [DashboardController::class, 'crudArea'])
        ->name('admin.area');


    // CRUD Kendaraan
    Route::get('/kendaraan', [DashboardController::class, 'crudKendaraan'])
        ->name('admin.kendaraan');

    Route::delete('/kendaraan/hapus/{id}', [DashboardController::class, 'hapusKendaraan'])
        ->name('admin.kendaraan.hapus');


    // Log Aktivitas
    Route::get('/log', [DashboardController::class, 'aksesLog'])
        ->name('admin.log');

    Route::delete('/log/hapus/{id}', [DashboardController::class, 'hapusLog'])
        ->name('admin.log.hapus');
});


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::prefix('petugas')->group(function () {

    // Transaksi Parkir
    Route::get('/transaksi', [DashboardController::class, 'transaksi'])
        ->name('petugas.transaksi');

    Route::post('/transaksi', [DashboardController::class, 'simpanTransaksiMasuk'])
        ->name('petugas.transaksi.simpan');

    Route::delete('/transaksi/hapus/{id}', [DashboardController::class, 'hapusTransaksi'])
        ->name('petugas.transaksi.hapus');


    // Cetak Struk
    Route::get('/cetak/{id}', [DashboardController::class, 'cetakStruk'])
        ->name('petugas.cetak');
});


/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/

Route::prefix('owner')->group(function () {

    // Rekap transaksi
    Route::get('/rekap', [DashboardController::class, 'rekapLaporan'])
        ->name('owner.rekap');
});
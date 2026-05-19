<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ManajemenKandangController;

// ===== AUTH =====
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


// ===== PROTECTED AREA =====
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PRODUKSI
    |--------------------------------------------------------------------------
    */
    Route::get('/produksi', [ProduksiController::class, 'index'])
        ->name('produksi');

    Route::get('/produksi/export', [ProduksiController::class, 'exportPdf'])
        ->name('produksi.export');


    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN KANDANG
    |--------------------------------------------------------------------------
    */

    // lihat semua batch
    Route::get('/manajemen-kandang',
        [ManajemenKandangController::class, 'index'])
        ->name('manajemen.kandang');

    // form tambah
    Route::get('/manajemen-kandang/create',
        [ManajemenKandangController::class, 'create'])
        ->name('manajemen.kandang.create');

    // simpan batch baru
    Route::post('/manajemen-kandang/store',
        [ManajemenKandangController::class, 'store'])
        ->name('manajemen.kandang.store');

    // detail batch
    Route::get('/manajemen-kandang/{id}',
        [ManajemenKandangController::class, 'show'])
        ->name('manajemen.kandang.show');

    // form edit
    Route::get('/manajemen-kandang/{id}/edit',
        [ManajemenKandangController::class, 'edit'])
        ->name('manajemen.kandang.edit');

    // update batch
    Route::put('/manajemen-kandang/{id}',
        [ManajemenKandangController::class, 'update'])
        ->name('manajemen.kandang.update');

    // hapus batch
    Route::delete('/manajemen-kandang/{id}',
        [ManajemenKandangController::class, 'destroy'])
        ->name('manajemen.kandang.destroy');
});


// ===== API untuk ESP32 & Polling =====
Route::post('/api/sensor',
    [App\Http\Controllers\Api\SensorController::class, 'store']);

Route::get('/api/latest',
    [App\Http\Controllers\Api\SensorController::class, 'latest']);
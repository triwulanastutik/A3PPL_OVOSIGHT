<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduksiController;

// ===== AUTH =====
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ===== PROTECTED AREA =====
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/produksi', [ProduksiController::class, 'index'])
        ->name('produksi');

    Route::get('/produksi/export', [ProduksiController::class, 'exportPdf'])
        ->name('produksi.export');
});
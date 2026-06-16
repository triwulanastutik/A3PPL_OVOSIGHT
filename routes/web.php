<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\DataAyamController;
use App\Http\Controllers\JadwalVaksinasiController;

Route::get('/', function () {
    return redirect('/login');
});




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
    |  DATA AYAM
    |--------------------------------------------------------------------------
    */

    // lihat semua batch
    Route::get('/data-ayam',
        [DataAyamController::class, 'index'])
        ->name('data.ayam');

    // form tambah
    Route::get('/data-ayam/create',
        [DataAyamController::class, 'create'])
        ->name('data.ayam.create');

    // simpan batch baru
    Route::post('/data-ayam/store',
        [DataAyamController::class, 'store'])
        ->name('data.ayam.store');

    // detail batch
    Route::get('/data-ayam/{id}',
        [DataAyamController::class, 'show'])
        ->name('data.ayam.show');

    // form edit
    Route::get('/data-ayam/{id}/edit',
        [DataAyamController::class, 'edit'])
        ->name('data.ayam.edit');

    // update batch
    Route::put('/data-ayam/{id}',
        [DataAyamController::class, 'update'])
        ->name('data.ayam.update');

    // hapus batch
    Route::delete('/data-ayam/{id}',
        [DataAyamController::class, 'destroy'])
        ->name('data.ayam.destroy');
});


// ===== API untuk ESP32 & Polling =====
Route::post('/api/sensor',
    [App\Http\Controllers\Api\SensorController::class, 'store']);

Route::get('/api/latest',
    [App\Http\Controllers\Api\SensorController::class, 'latest']);


// ===== Jadwal Vaksinasi =====
Route::get('/jadwal-vaksinasi', [JadwalVaksinasiController::class, 'index'])
    ->name('jadwal.vaksinasi');

Route::get('/jadwal-vaksinasi/create', [JadwalVaksinasiController::class, 'create'])
    ->name('jadwal.vaksinasi.create');

Route::post('/jadwal-vaksinasi', [JadwalVaksinasiController::class, 'store'])
    ->name('jadwal.vaksinasi.store');

Route::get('/jadwal-vaksinasi/{id}/edit', [JadwalVaksinasiController::class, 'edit'])
    ->name('jadwal.vaksinasi.edit');

Route::put('/jadwal-vaksinasi/{id}', [JadwalVaksinasiController::class, 'update'])
    ->name('jadwal.vaksinasi.update');

Route::put('/jadwal-vaksinasi/{id}/selesai', [JadwalVaksinasiController::class, 'selesai'])
    ->name('jadwal.vaksinasi.selesai');

Route::delete('/jadwal-vaksinasi/{id}', [JadwalVaksinasiController::class, 'destroy'])
    ->name('jadwal.vaksinasi.destroy');

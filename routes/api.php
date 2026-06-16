<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorController;

Route::post('/sensor', [SensorController::class, 'store']);

// REALTIME endpoint (untuk dashboard)
Route::get('/sensor/latest', [SensorController::class, 'latest']);

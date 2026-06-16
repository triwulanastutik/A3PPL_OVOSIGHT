<?php

use Illuminate\Support\Facades\Route;

Route::post('/sensor', [App\Http\Controllers\Api\SensorController::class, 'store']);
Route::get('/latest', [App\Http\Controllers\Api\SensorController::class, 'latest']);

<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\SosController;
use Illuminate\Support\Facades\Route;

Route::post('/update-log', [SensorController::class, 'updateHikerLog']);
Route::post('/sos-trigger', [SosController::class, 'trigger']);

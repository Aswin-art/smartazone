<?php

use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;

Route::post('/update-log', [SensorController::class, 'updateHikerLog']);
Route::post('/sos-trigger', [SensorController::class, 'trigger']);

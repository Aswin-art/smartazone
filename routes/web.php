<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HikersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('hikers', [HikersController::class, 'index'])->name('hikers.index');
Route::get('/hikers/data', [HikersController::class, 'getData'])->name('hikers.getData');

Route::get('/hikers/{id}', [HikersController::class, 'show'])->name('hikers.show');
Route::get('/hikers/{id}/edit', [HikersController::class, 'edit'])->name('hikers.edit');
Route::put('/hikers/{id}', [HikersController::class, 'update'])->name('hikers.update');
Route::delete('/hikers/{id}', [HikersController::class, 'destroy'])->name('hikers.destroy');

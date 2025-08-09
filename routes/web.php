<?php

use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\EquipmentRentalsController;
use App\Http\Controllers\HikerHistoryController;
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

Route::prefix('hiker-history')->name('hiker-history.')->group(function () {
    Route::get('/', [HikerHistoryController::class, 'index'])->name('index');
    Route::get('/data', [HikerHistoryController::class, 'getData'])->name('data');
    Route::get('/{bookingId}/detail', [HikerHistoryController::class, 'show'])->name('detail');
    Route::get('/{bookingId}/tracking-route', [HikerHistoryController::class, 'getTrackingRoute'])->name('tracking-route');
});

Route::prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/', [ComplaintsController::class, 'index'])->name('index');
    Route::get('/data', [ComplaintsController::class, 'getData'])->name('data');
    Route::get('/statistics', [ComplaintsController::class, 'getStatistics'])->name('statistics');
    Route::get('/export', [ComplaintsController::class, 'exportComplaints'])->name('export');
    Route::get('/{complaintId}/detail', [ComplaintsController::class, 'show'])->name('detail');
    Route::post('/{complaintId}/mark-read', [ComplaintsController::class, 'markAsRead'])->name('mark-read');
});

 Route::prefix('equipment-rentals')->name('equipment-rentals.')->group(function () {
        Route::get('/', [EquipmentRentalsController::class, 'index'])->name('index');
        Route::get('/data', [EquipmentRentalsController::class, 'getData'])->name('data');
        Route::get('/statistics', [EquipmentRentalsController::class, 'getStatistics'])->name('statistics');
        Route::get('/equipment-availability', [EquipmentRentalsController::class, 'getEquipmentAvailability'])->name('equipment-availability');
        Route::get('/export', [EquipmentRentalsController::class, 'exportRentals'])->name('export');
        Route::get('/{rentalId}/detail', [EquipmentRentalsController::class, 'show'])->name('detail');
        Route::post('/{rentalId}/update-status', [EquipmentRentalsController::class, 'updateStatus'])->name('update-status');
    });

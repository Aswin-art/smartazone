<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\EquipmentRentalsController;
use App\Http\Controllers\HikerHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HealthMonitoringController;
use App\Http\Controllers\HikersController;
use App\Http\Controllers\LocationTrackingController;
use App\Http\Controllers\SOSMonitoringController;
use App\Http\Controllers\Superadmin\MountainController;
use Illuminate\Support\Facades\Route;

// $mainDomain = config('app.domain');
// Route::domain('{tenant}.' . $mainDomain)->group(function () {
//     Route::get('/', function () {
//         return view('landing-page');
//     });
// });

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // SUPERADMIN 
    Route::prefix('superadmin')->middleware('role:superadmin')->name('superadmin.')->group(function () {
        Route::get('/mountains', [MountainController::class, 'index'])->name('mountains.index');
        Route::get('/mountains/get-data', [MountainController::class, 'getData'])->name('mountains.getData');
        Route::get('/mountains/{id}', [MountainController::class, 'show'])->name('mountains.show');
        Route::get('/mountains/{id}/edit', [MountainController::class, 'edit'])->name('mountains.edit');
        Route::put('/mountains/{id}', [MountainController::class, 'update'])->name('mountains.update');
        Route::post('/mountains/{id}/deactivate', [MountainController::class, 'deactivate'])->name('mountains.deactivate');
        Route::delete('/mountains/{id}', [MountainController::class, 'destroy'])->name('mountains.destroy');
    });

    // ADMIN GUNUNG
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.superadmin.index');
        })->name('admin.dashboard');
    });

    // PENDAKI 
    Route::prefix('pendaki')->middleware('role:pendaki')->group(function () {
        Route::get('/dashboard', function () {
            return view('pendaki.dashboard');
        })->name('pendaki.dashboard');
    });
});


Route::get('/', function () {
    return view('landing-page');
});

Route::get('/auth', function () {
    return view('auth');
});

Route::get('/booking', function () {
    return view('booking');
});

Route::get('/profile', function () {
    return view('profile');
});


Route::prefix('dashboard')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('hikers')->group(function () {
        Route::get('/', [HikersController::class, 'index'])->name('hikers.index');
        Route::get('/data', [HikersController::class, 'getData'])->name('hikers.getData');
        Route::get('/{id}', [HikersController::class, 'show'])->name('hikers.show');
        Route::get('/{id}/edit', [HikersController::class, 'edit'])->name('hikers.edit');
        Route::put('/{id}', [HikersController::class, 'update'])->name('hikers.update');
        Route::delete('/{id}', [HikersController::class, 'destroy'])->name('hikers.destroy');
    });

    Route::prefix('hiker-history')->group(function () {
        Route::get('/', [HikerHistoryController::class, 'index'])->name('hiker-history.index');
        Route::get('/data', [HikerHistoryController::class, 'getData'])->name('hiker-history.data');
        Route::get('/{bookingId}/detail', [HikerHistoryController::class, 'show'])->name('hiker-history.detail');
        Route::get('/{bookingId}/tracking-route', [HikerHistoryController::class, 'getTrackingRoute'])->name('hiker-history.tracking-route');
    });

    Route::prefix('complaints')->group(function () {
        Route::get('/', [ComplaintsController::class, 'index'])->name('complaints.index');
        Route::get('/data', [ComplaintsController::class, 'getData'])->name('complaints.data');
        Route::get('/statistics', [ComplaintsController::class, 'getStatistics'])->name('complaints.statistics');
        Route::get('/export', [ComplaintsController::class, 'exportComplaints'])->name('complaints.export');
        Route::get('/{complaintId}/detail', [ComplaintsController::class, 'show'])->name('complaints.detail');
        Route::post('/{complaintId}/mark-read', [ComplaintsController::class, 'markAsRead'])->name('complaints.mark-read');
    });

    Route::prefix('equipment-rentals')->group(function () {
        Route::get('/', [EquipmentRentalsController::class, 'index'])->name('equipment-rentals.index');
        Route::get('/data', [EquipmentRentalsController::class, 'getData'])->name('equipment-rentals.data');
        Route::get('/statistics', [EquipmentRentalsController::class, 'getStatistics'])->name('equipment-rentals.statistics');
        Route::get('/equipment-availability', [EquipmentRentalsController::class, 'getEquipmentAvailability'])->name('equipment-rentals.equipment-availability');
        Route::get('/export', [EquipmentRentalsController::class, 'exportRentals'])->name('equipment-rentals.export');
        Route::get('/{rentalId}/detail', [EquipmentRentalsController::class, 'show'])->name('equipment-rentals.detail');
        Route::post('/{rentalId}/update-status', [EquipmentRentalsController::class, 'updateStatus'])->name('equipment-rentals.update-status');
    });

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/data', [FeedbackController::class, 'getData'])->name('feedback.getData');
    Route::get('/feedback/stats', [FeedbackController::class, 'getStats'])->name('feedback.stats');
    Route::get('/feedback/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Health Monitoring
    Route::get('/health-monitoring', [HealthMonitoringController::class, 'index'])->name('health.index');
    Route::get('/health-monitoring/data', [HealthMonitoringController::class, 'getData'])->name('health.getData');
    Route::get('/health-monitoring/stats', [HealthMonitoringController::class, 'getHealthStats'])->name('health.stats');
    Route::get('/health/{bookingId}', [HealthMonitoringController::class, 'getHikerHealth'])->name('health.show');
    Route::get('/health/{bookingId}/chart', [HealthMonitoringController::class, 'getChartData'])->name('health.chart');
    Route::post('/health/alert', [HealthMonitoringController::class, 'sendHealthAlert'])->name('health.sendAlert');

    // Location Tracking
    Route::get('/location-tracking', [LocationTrackingController::class, 'index'])->name('location.index');
    Route::get('/location-tracking/active-hikers', [LocationTrackingController::class, 'getActiveHikers'])->name('location.activeHikers');
    Route::get('/location-tracking/stats', [LocationTrackingController::class, 'getLocationStats'])->name('location.stats');
    Route::get('/location/{bookingId}/history', [LocationTrackingController::class, 'getHikerLocationHistory'])->name('location.history');
    Route::get('/location/{bookingId}/export', [LocationTrackingController::class, 'exportLocationData'])->name('location.export');
    Route::post('/location/update', [LocationTrackingController::class, 'updateLocation'])->name('location.update');
    Route::get('/location/geofence-alerts', [LocationTrackingController::class, 'getGeofenceAlerts'])->name('location.geofence');

    // SOS Monitoring
    Route::get('/sos-monitoring', [SOSMonitoringController::class, 'index'])->name('sos.index');
    Route::get('/sos-monitoring/data', [SOSMonitoringController::class, 'getData'])->name('sos.getData');
    Route::get('/sos-monitoring/stats', [SOSMonitoringController::class, 'getSOSStats'])->name('sos.stats');
    Route::get('/sos/{id}', [SOSMonitoringController::class, 'show'])->name('sos.show');
    Route::post('/sos/{id}/respond', [SOSMonitoringController::class, 'respondToSOS'])->name('sos.respond');
    Route::get('/sos/emergency-contacts/{bookingId}', [SOSMonitoringController::class, 'getEmergencyContacts'])->name('sos.contacts');
    Route::post('/sos/create', [SOSMonitoringController::class, 'createSOSSignal'])->name('sos.create');
});

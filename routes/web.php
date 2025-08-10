<?php

use Illuminate\Support\Facades\Route;

// $mainDomain = config('app.domain');
// Route::domain('{tenant}.' . $mainDomain)->group(function () {
//     Route::get('/', function () {
//         return view('landing-page');
//     });
// });

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

Route::get('/dashboard', function () {
    // dd("Welcome to the Dashboard");
    return view('Dashboard.pages.index');
});
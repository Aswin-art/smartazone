<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // dd("Welcome to the Dashboard");
    return view('Dashboard.pages.index');
});
<?php

use App\Http\Controllers\Backend\DashboardController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/radiostations/stations/profile', [StationsController::class, 'profile'])->name('stations.profile');
Route::resource('/radiostations/stations', 'RadioStation\StationsController');
Route::resource('/radiostations/stations/{station}/contests', 'RadioStation\StationContestsController');
Route::resource('/radiostations/stations/{station}/contest/{contest}/entrants', 'RadioStation\StationEntrantsController');
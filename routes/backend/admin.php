<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Radiostation\StationsController;


// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::group(['namespace' => 'Radiostation'], function () {
	Route::get('/radiostations/stations/profile', [StationsController::class, 'profile'])->name('stations.profile');
	Route::post('upload', 'StationContestsController@upload')->name('contests.upload');
	Route::resource('/radiostations/stations', 'StationsController');
	Route::resource('/radiostations/stations/{station}/contests', 'StationContestsController');
	Route::resource('/radiostations/stations/{station}/contest/{contest}/entrants', 'StationEntrantsController');
});
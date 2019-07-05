<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Radiostation\StationsController;
use App\Http\Controllers\Backend\Radiostation\StationEntrantsController;
use App\Http\Controllers\Backend\Radiostation\NotificationsController;


// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::group(['namespace' => 'Radiostation'], function () {
	Route::get('/radiostations/stations/profile', [StationsController::class, 'profile'])->name('stations.profile');
	Route::post('upload_mp3', 'StationContestsController@upload')->name('contests.upload.mp3');
	Route::post('upload_image', 'StationContestsController@uploadImage')->name('contests.upload.image');
	Route::get('entrant/mp3/{uuid}', [StationEntrantsController::class, 'download'])->name('entrants.download');
	Route::resource('/radiostations/stations', 'StationsController');
	Route::resource('/radiostations/stations/{station}/contests', 'StationContestsController');
	Route::resource('/radiostations/stations/{station}/contest/{contest}/notifications', 'NotificationsController');
	Route::resource('/radiostations/stations/{station}/contest/{contest}/entrants', 'StationEntrantsController');

	Route::post('/ajax/mailblast/{contest}', [NotificationsController::class, 'index'])->name('entrants.mailblast');
});
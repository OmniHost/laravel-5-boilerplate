<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Api\radiostation_contestsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
//Route::resource('radiostation_contests', 'Api\\radiostation_contestsController');

Route::post('radiostation_contests/{id}', [radiostation_contestsController::class, 'incommingCall'])->where('id', '[0-9]+');
Route::post('radiostation_contests/callstatus', [radiostation_contestsController::class, 'statusCall']);
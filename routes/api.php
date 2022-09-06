<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OkrController;
use App\Http\Controllers\Api\QuarterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/okr/mine/get', [OkrController::class, 'getMine'])->name('okr.mine.get');
    Route::post('/okr/ours/get', [OkrController::class, 'getOurs'])->name('okr.ours.get');
    Route::post('/quarter/get', [QuarterController::class, 'get'])->name('quarter.get');
});

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeyResultController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resources([
        'dashboard' => DashboardController::class,
        'key_result' => KeyResultController::class,
        'objective' => ObjectiveController::class,
    ]);

    Route::prefix('objective')->group(function () {
        // OKR 検索
        Route::post('search', [ObjectiveController::class, 'search'])->name('objective.search');
    });

    Route::prefix('dashboard')->group(function () {
        // ユーザー検索
        Route::post('search', [DashboardController::class, 'search'])->name('dashboard.search');
    });
});

// 会社ユーザ以上
Route::middleware('auth', 'can:manager-higher')->group(function () {
    Route::resources([
        'user' => UserController::class,
    ]);
});

// // 全ユーザ
// Route::group(['middleware' => ['auth', 'can:member-higher']], function () {
//     // ユーザ一覧
//     Route::get('/account', [AccountController::class, 'index'])->name('account.index');
// });

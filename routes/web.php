<?php

use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\OkrController;
use App\Http\Controllers\DashboardController;
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
        'objective' => ObjectiveController::class,
        'okr' => OkrController::class,
    ]);

    Route::prefix('okr')->group(function () {
        // OKR 検索
        Route::post('search', [OkrController::class, 'search'])->name('okr.search');
    });

    Route::prefix('dashboard')->group(function () {
        // ユーザー検索
        Route::post('search', [DashboardController::class, 'search'])->name('dashboard.search');
    });
});

// // 全ユーザ
// Route::group(['middleware' => ['auth', 'can:member-higher']], function () {
//     // ユーザ一覧
//     Route::get('/account', [AccountController::class, 'index'])->name('account.index');
// });

// // 管理者以上
// Route::group(['middleware' => ['auth', 'can:manager-higher']], function () {
//     // ユーザ登録
//     Route::get('/account/regist', [AccountController::class, 'regist'])->name('account.regist');
//     Route::post('/account/regist', [AccountController::class, 'createData'])->name('account.regist');

//     // ユーザ編集
//     Route::get('/account/edit/{user_id}', [AccountController::class, 'edit'])->name('account.edit');
//     Route::post('/account/edit/{user_id}', [AccountController::class, 'updateData'])->name('account.edit');

//     // ユーザ削除
//     Route::post('/account/delete/{user_id}', [AccountController::class, 'deleteData']);
// });

<?php

use App\Http\Controllers\OkrController;
use App\Http\Controllers\AccountController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Auth::routes();
// Route::get(['/home', HomeController::class, 'index'])->name('home');

// OKR 一覧
Route::resource('/okr', OkrController::class);

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:member-higher']], function () {
    // ユーザ一覧
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:manager-higher']], function () {
    // ユーザ登録
    Route::get('/account/regist', [AccountController::class, 'regist'])->name('account.regist');
    Route::post('/account/regist', [AccountController::class, 'createData'])->name('account.regist');

    // ユーザ編集
    Route::get('/account/edit/{user_id}', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/edit/{user_id}', [AccountController::class, 'updateData'])->name('account.edit');

    // ユーザ削除
    Route::post('/account/delete/{user_id}', [AccountController::class, 'deleteData']);
});

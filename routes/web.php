<?php

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:member-higher']], function () {
    // ユーザ一覧
    Route::get('/account', 'AccountController@index')->name('account.index');
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:manager-higher']], function () {
    // ユーザ登録
    Route::get('/account/regist', 'AccountController@regist')->name('account.regist');
    Route::post('/account/regist', 'AccountController@createData')->name('account.regist');

    // ユーザ編集
    Route::get('/account/edit/{user_id}', 'AccountController@edit')->name('account.edit');
    Route::post('/account/edit/{user_id}', 'AccountController@updateData')->name('account.edit');

    // ユーザ削除
    Route::post('/account/delete/{user_id}', 'AccountController@deleteData');
});

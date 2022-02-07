<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KeyResultController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\QuarterController;
use App\Http\Controllers\SlackController;
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

Route::middleware('auth')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resources([
        'dashboard' => DashboardController::class,
        'key_result' => KeyResultController::class,
        'objective' => ObjectiveController::class,
        'quarter' => QuarterController::class,
    ]);
    Route::resource('slack', SlackController::class, ['except' => ['show', 'destroy']]);

    Route::prefix('objective')->group(function (): void {
        Route::post('search', [ObjectiveController::class, 'search'])->name('objective.search');
    });

    Route::prefix('dashboard')->group(function (): void {
        Route::post('search', [DashboardController::class, 'search'])->name('dashboard.search');
    });

    Route::prefix('slack')->group(function (): void {
        Route::get('stop', [SlackController::class, 'stop'])->name('slack.stop');
        Route::get('restart', [SlackController::class, 'restart'])->name('slack.restart');
    });
});

// MANAGER ユーザ以上
Route::middleware('auth', 'can:manager-higher')->group(function (): void {
    Route::resources([
        'user' => UserController::class,
    ]);
    Route::prefix('company')->group(function (): void {
        Route::post('store', [CompanyController::class, 'store'])->name('company.store');
    });
    Route::prefix('department')->group(function (): void {
        Route::post('store', [DepartmentController::class, 'store'])->name('department.store');
    });
    Route::prefix('manager')->group(function (): void {
        Route::post('store', [ManagerController::class, 'store'])->name('manager.store');
    });
    Route::prefix('member')->group(function (): void {
        Route::post('store', [MemberController::class, 'store'])->name('member.store');
    });
});

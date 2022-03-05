<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyGroupController;
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
        'company_group' => CompanyGroupController::class,
        'key_result' => KeyResultController::class,
        'quarter' => QuarterController::class,
    ]);

    Route::resource('objective', ObjectiveController::class, ['except' => ['show']]);
    Route::resource('slack', SlackController::class, ['except' => ['show', 'destroy']]);

    Route::prefix('admin')->group(function (): void {
        Route::get('proxy_login/{user_id}', [AdminController::class, 'proxyLogin'])->name('admin.proxy_login');
        Route::get('edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('update', [AdminController::class, 'update'])->name('admin.update');
    });

    Route::prefix('objective')->group(function (): void {
        Route::post('search', [ObjectiveController::class, 'search'])->name('objective.search');
        Route::put('archive/{objective_id}', [ObjectiveController::class, 'archive'])->name('objective.archive');
        Route::get('archive/list', [ObjectiveController::class, 'archivedList'])->name('objective.archived_list');
        Route::post('archive/search', [ObjectiveController::class, 'archiveSearch'])->name('objective.archive_search');
        Route::put('unarchive/{objective_id}', [ObjectiveController::class, 'unarchive'])->name('objective.unarchive');
    });

    Route::prefix('dashboard')->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::post('search', [DashboardController::class, 'search'])->name('dashboard.search');
        Route::get('search', [DashboardController::class, 'index'])->name('dashboard.links');
    });

    Route::prefix('slack')->group(function (): void {
        Route::get('stop', [SlackController::class, 'stop'])->name('slack.stop');
        Route::get('restart', [SlackController::class, 'restart'])->name('slack.restart');
    });

    Route::prefix('fetch')->group(function (): void {
        Route::post('departments/{company_id}', [DepartmentController::class, 'fetch'])->name('fetch.departments');
    });

    // 編集は可能
    Route::prefix('user')->group(function (): void {
        Route::get('edit/{user_id}', [UserController::class, 'edit'])->name('user.edit');
    });

    Route::prefix('company')->group(function (): void {
        Route::put('update', [CompanyController::class, 'update'])->name('company.update');
    });
    Route::prefix('department')->group(function (): void {
        Route::put('update', [DepartmentController::class, 'update'])->name('department.update');
    });
    Route::prefix('manager')->group(function (): void {
        Route::put('update', [ManagerController::class, 'update'])->name('manager.update');
    });
    Route::prefix('member')->group(function (): void {
        Route::put('update', [MemberController::class, 'update'])->name('member.update');
    });

    Route::middleware('can:manager-higher')->group(function (): void {
        Route::resource('user', UserController::class, ['except' => ['edit', 'update']]);
        Route::prefix('user')->group(function (): void {
            Route::post('search', [UserController::class, 'search'])->name('user.search');
            Route::get('search', [UserController::class, 'index'])->name('user.links');
        });

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
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Middleware untuk user yang belum login
Route::group(['middleware' => 'not.authenticated'], function() {
    Route::get('/', function () { return view('auth.login'); });
    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Middleware untuk user yang sudah login
Route::group(['middleware' => 'authenticated'], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        
        Route::get('/masterMenus', [AdminController::class, 'indexMasterMenus'])->name('master-menus.index');
        Route::get('/masterAuthGroups', [AdminController::class, 'indexMasterAuthGroups'])->name('master-auth-groups.index');
        Route::get('/masterReports', [AdminController::class, 'indexMasterReports'])->name('master-reports.index');
        
        // Master Auth Groups
        Route::prefix('master-auth-groups')->name('master-auth-groups.')->group(function() {
            Route::post('/create', [AdminController::class, 'createMasterAuthGroups'])->name('create');
            Route::post('/update-users', [AdminController::class, 'updateUsersMasterAuthGroups'])->name('update-users');
            Route::post('/update-auth-group', [AdminController::class, 'updateAuthGroupMasterAuthGroups'])->name('update-auth-group');
            Route::get('/delete', [AdminController::class, 'deleteMasterAuthGroups'])->name('delete');
        });

        // Master Menus
        Route::prefix('master-menus')->name('master-menus.')->group(function() {
            Route::post('/create', [AdminController::class, 'createMasterMenus'])->name('create');
            Route::post('/update', [AdminController::class, 'updateMasterMenus'])->name('update');
            Route::get('/delete', [AdminController::class, 'deleteMasterMenus'])->name('delete');
        });

        // Master Reports
        Route::prefix('master-reports')->name('master-reports.')->group(function() {
            Route::post('/create', [AdminController::class, 'createMasterReports'])->name('create');
            Route::post('/update', [AdminController::class, 'updateMasterReports'])->name('update');
            Route::get('/delete', [AdminController::class, 'deleteMasterReports'])->name('delete');
        });
        
    });

    



});
<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobRoleController;
use App\Http\Controllers\ShiftController;
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

Route::get('/', function () {
    return redirect()->route('login');
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('job-roles', JobRoleController::class);
        Route::resource('companies', CompanyController::class);
    });

    Route::middleware('company_admin')->group(function () {
        Route::resource('company-users', CompanyUserController::class);
        Route::resource('shifts', ShiftController::class);
        Route::post('shifts-list', [ShiftController::class, 'list'])->name('shifts.list');
    });
});

require __DIR__ . '/auth.php';

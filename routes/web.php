<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationProcessController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDocumentController;
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

    Route::resource('applications', ApplicationController::class);
    Route::post('/application/{application}/approve', [ApplicationProcessController::class, 'approve'])->name('applications.approve');
    Route::post('/application/{application}/reject', [ApplicationProcessController::class, 'reject'])->name('applications.reject');
    Route::get('/application/{application}/show', [ApplicationProcessController::class, 'show'])->name('application.show');

    Route::resource('user-documents', UserDocumentController::class);
});

require __DIR__ . '/auth.php';

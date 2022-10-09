<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationProcessController;
use App\Http\Controllers\AvailableShiftController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyCompanyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftRequestController;
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
        Route::resource('applications', ApplicationController::class);
    });

    /** Resource API requires session */
    Route::post('/application/{application}/approve', [ApplicationProcessController::class, 'approve'])->name('applications.approve');
    Route::post('/application/{application}/reject', [ApplicationProcessController::class, 'reject'])->name('applications.reject');
    Route::get('/application/{application}/show', [ApplicationProcessController::class, 'show'])->name('application.show');

    Route::middleware('company_admin')->group(function () {
        Route::resource('company-users', CompanyUserController::class);
        Route::resource('shifts', ShiftController::class);

        /** Resource API requires session */
        Route::get('/company-users/{company}', [CompanyUserController::class, 'show'])->name('company-users.show');
        Route::get('/shift-applications', [ShiftRequestController::class, 'index'])->name('shift-requests.index');
        Route::get('/shift-applications/{company}', [ShiftRequestController::class, 'show'])->name('shift-requests.show');
        Route::get('/shift-applications/{shiftRequest}/details', [ShiftRequestController::class, 'details'])->name('shift-requests.details');
        Route::post('/shift-applications/process', [ShiftRequestController::class, 'process'])->name('shift-requests.process');
    });

    Route::resource('user-documents', UserDocumentController::class);

    /** Resource API requires session */
    Route::get('/my-companies', [MyCompanyController::class, 'index'])->name('my-companies.index');
    Route::get('/my-schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/my-schedules/{company}', [ScheduleController::class, 'show'])->name('my-schedules.show');
    Route::get('/available-shifts', [AvailableShiftController::class, 'index'])->name('available-shifts.index');
    Route::get('/available-shifts/{company}', [AvailableShiftController::class, 'show'])->name('available-shifts.show');
    Route::post('/available-shifts/{shift}/apply', [AvailableShiftController::class, 'apply'])->name('available-shifts.show');
});

require __DIR__ . '/auth.php';

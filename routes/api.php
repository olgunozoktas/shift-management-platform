<?php

use App\Http\Controllers\API\v1\CompanyController;
use App\Http\Controllers\API\v1\JobRoleController;
use App\Http\Controllers\API\v1\ShiftController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('api.companies.index');
    Route::get('/job-roles', [JobRoleController::class, 'index'])->name('api.job-roles.index');
    Route::post('/shifts/calendar', [ShiftController::class, 'calendar'])->name('shifts.calendar');
    Route::get('/shifts/{company}/list', [ShiftController::class, 'list'])->name('shifts.list');
});

<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::post('login', [AuthController::class, 'login']);
Route::get('token', [AuthController::class, 'getToken'])->middleware('auth:sanctum');
Route::post('refresh-token', [AuthController::class, 'refreshToken']);

Route::prefix('departments')->name('departments.')->group(function() {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
    Route::post('/create', [DepartmentController::class, 'create'])->name('create');
    // Route::put('/{department}', [DepartmentController::class, 'update'])->name('update-put');
    Route::patch('/{department}', [DepartmentController::class, 'update'])->name('update-patch');
    Route::delete('/{department}', [DepartmentController::class, 'delete'])->name('delete');
});

Route::prefix('positions')->name('positions.')->group(function() {
    Route::get('/', [PositionController::class, 'index'])->name('index');
    Route::get('/{position}', [PositionController::class, 'detail'])->name('detail');
    Route::post('/create', [PositionController::class, 'create'])->name('create');
    Route::put('/{position}', [PositionController::class, 'update'])->name('update-put');
    Route::patch('/{position}', [PositionController::class, 'update'])->name('update-patch');
    Route::delete('/{position}', [PositionController::class, 'delete'])->name('delete');
});

Route::apiResource('users', UserController::class);
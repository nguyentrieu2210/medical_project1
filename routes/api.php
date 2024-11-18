<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\MedicationCatalogueController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoomCatalogueController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ServiceCatalogueController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ServiceController;

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
    Route::get('/{position}', [PositionController::class, 'show'])->name('show');
    Route::post('/create', [PositionController::class, 'create'])->name('create');
    // Route::put('/{position}', [PositionController::class, 'update'])->name('update-put');
    Route::patch('/{position}', [PositionController::class, 'update'])->name('update-patch');
    Route::delete('/{position}', [PositionController::class, 'delete'])->name('delete');
});

Route::prefix('users')->name('users.')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::post('/create', [UserController::class, 'create'])->name('create');
    // Route::put('/{user}', [UserController::class, 'update'])->name('update-put');
    Route::patch('/{user}', [UserController::class, 'update'])->name('update-patch');
    Route::delete('/{user}', [UserController::class, 'delete'])->name('delete');
});

Route::prefix('roomCatalogues')->name('roomCatalogues.')->group(function() {
    Route::get('/', [RoomCatalogueController::class, 'index'])->name('index');
    Route::get('/{roomCatalogue}', [RoomCatalogueController::class, 'show'])->name('show');
    Route::post('/create', [RoomCatalogueController::class, 'create'])->name('create');
    // Route::put('/{roomCatalogue}', [RoomCatalogueController::class, 'update'])->name('update-put');
    Route::patch('/{roomCatalogue}', [RoomCatalogueController::class, 'update'])->name('update-patch');
    Route::delete('/{roomCatalogue}', [RoomCatalogueController::class, 'delete'])->name('delete');
});

Route::prefix('rooms')->name('rooms.')->group(function() {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/{room}', [RoomController::class, 'show'])->name('show');
    Route::post('/create', [RoomController::class, 'create'])->name('create');
    // Route::put('/{room}', [RoomController::class, 'update'])->name('update-put');
    Route::patch('/{room}', [RoomController::class, 'update'])->name('update-patch');
    Route::delete('/{room}', [RoomController::class, 'delete'])->name('delete');
});

Route::prefix('patients')->name('patients.')->group(function() {
    Route::get('/', [PatientController::class, 'index'])->name('index');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
    Route::post('/create', [PatientController::class, 'create'])->name('create');
    // Route::put('/{patient}', [PatientController::class, 'update'])->name('update-put');
    Route::patch('/{patient}', [PatientController::class, 'update'])->name('update-patch');
    Route::delete('/{patient}', [PatientController::class, 'delete'])->name('delete');
});

Route::prefix('medicalRecords')->name('medicalRecords.')->group(function() {
    Route::get('/', [MedicalRecordController::class, 'index'])->name('index');
    Route::post('/create', [MedicalRecordController::class, 'create'])->name('create');
    Route::post('/createPivot', [MedicalRecordController::class, 'createPivot'])->name('createPivot');
});

Route::prefix('beds')->name('beds.')->group(function() {
    Route::get('/', [BedController::class, 'index'])->name('index');
    Route::get('/{bed}', [BedController::class, 'show'])->name('show');
    Route::post('/create', [BedController::class, 'create'])->name('create');
    // Route::put('/{bed}', [BedController::class, 'update'])->name('update-put');
    Route::patch('/{bed}', [BedController::class, 'update'])->name('update-patch');
    Route::delete('/{bed}', [BedController::class, 'delete'])->name('delete');
});

Route::prefix('serviceCatalogues')->name('serviceCatalogues.')->group(function() {
    Route::get('/', [ServiceCatalogueController::class, 'index'])->name('index');
    Route::get('/{serviceCatalogue}', [ServiceCatalogueController::class, 'show'])->name('show');
    Route::post('/create', [ServiceCatalogueController::class, 'create'])->name('create');
    // Route::put('/{serviceCatalogue}', [ServiceCatalogueController::class, 'update'])->name('update-put');
    Route::patch('/{serviceCatalogue}', [ServiceCatalogueController::class, 'update'])->name('update-patch');
    Route::delete('/{serviceCatalogue}', [ServiceCatalogueController::class, 'delete'])->name('delete');
});

Route::prefix('services')->name('services.')->group(function() {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/{service}', [ServiceController::class, 'show'])->name('show');
    Route::post('/create', [ServiceController::class, 'create'])->name('create');
    // Route::put('/{service}', [ServiceController::class, 'update'])->name('update-put');
    Route::patch('/{service}', [ServiceController::class, 'update'])->name('update-patch');
    Route::delete('/{service}', [ServiceController::class, 'delete'])->name('delete');
});

Route::prefix('permissions')->name('permissions.')->group(function() {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
    Route::post('/create', [PermissionController::class, 'create'])->name('create');
    // Route::put('/{permission}', [PermissionController::class, 'update'])->name('update-put');
    Route::patch('/{permission}', [PermissionController::class, 'update'])->name('update-patch');
    Route::delete('/{permission}', [PermissionController::class, 'delete'])->name('delete');
});

Route::prefix('medicationCatalogues')->name('medicationCatalogues.')->group(function() {
    Route::get('/', [MedicationCatalogueController::class, 'index'])->name('index');
    Route::get('/{medicationCatalogue}', [MedicationCatalogueController::class, 'show'])->name('show');
    Route::post('/create', [MedicationCatalogueController::class, 'create'])->name('create');
    // Route::put('/{medicationCatalogue}', [MedicationCatalogueController::class, 'update'])->name('update-put');
    Route::patch('/{medicationCatalogue}', [MedicationCatalogueController::class, 'update'])->name('update-patch');
    Route::delete('/{medicationCatalogue}', [MedicationCatalogueController::class, 'delete'])->name('delete');
});

Route::prefix('medications')->name('medications.')->group(function() {
    Route::get('/', [MedicationController::class, 'index'])->name('index');
    Route::get('/{medication}', [MedicationController::class, 'show'])->name('show');
    Route::post('/create', [MedicationController::class, 'create'])->name('create');
    // Route::put('/{medication}', [MedicationController::class, 'update'])->name('update-put');
    Route::patch('/{medication}', [MedicationController::class, 'update'])->name('update-patch');
    Route::delete('/{medication}', [MedicationController::class, 'delete'])->name('delete');
});

Route::patch('/update/status', [Controller::class, 'updateStatus']);
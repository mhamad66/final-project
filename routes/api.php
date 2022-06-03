<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SampleController;

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

//public Route
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);
Route::get('/logout', [AuthController::class, 'Logout'])->middleware('auth:sanctum');



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/showrooms/index', [ShowroomController::class, 'index']);

});

Route::get('/showrooms/view/{id}', [ShowroomController::class, 'show']);
Route::get('/showrooms/delete/{id}', [ShowroomController::class, 'destroy']);
Route::post('/showrooms', [ShowroomController::class, 'store']);
Route::post('/showrooms/{id}', [ShowroomController::class, 'update']);


Route::get('/warehouses/index', [WarehouseController::class, 'index']);
Route::get('/warehouses/view/{id}', [WarehouseController::class, 'show']);
Route::get('/warehouses/delete/{id}', [WarehouseController::class, 'destroy']);
Route::post('/warehouses', [WarehouseController::class, 'store']);
Route::post('/warehouses/{id}', [WarehouseController::class, 'update']);

Route::get('/samples/index', [SampleController::class, 'index']);
Route::get('/samples/view/{id}', [SampleController::class, 'show']);
Route::get('/samples/delete/{id}', [SampleController::class, 'destroy']);
Route::post('/samples', [SampleController::class, 'store']);
Route::post('/samples/{id}', [SampleController::class, 'update']);



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Auth\AuthController;
use App\Http\Controllers\api\User\UserInformationController;
use App\Http\Controllers\CarController;

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

// private routes
Route::middleware('auth:sanctum')->group(function(){
    Route::get('user', [UserInformationController::class, 'index']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('tokens/create', [AuthController::class, 'createNewToken']);

    Route::apiResource('car', CarController::class);
});

// public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
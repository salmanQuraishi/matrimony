<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/update-basic', [AuthController::class, 'updateBasic']);
    Route::post('/update-religion', [AuthController::class, 'updateReligion']);
    Route::post('/update-personal', [AuthController::class, 'updatePersonal']);
    Route::post('/update-professional', [AuthController::class, 'updateProfessional']);
    Route::post('/update-about', [AuthController::class, 'updateAbout']);

    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('/user-profile', function (Request $request) {
        return $request->user();
    });

});
<?php

use App\Http\Controllers\Api\Restraunt\AuthController as RestrauntAuthController;
use App\Http\Controllers\Api\Restraunt\DriverController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\RestrauntController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'user'], function () {
    Route::post('register', [AuthController::class, 'createUser']);
    Route::post('login', [AuthController::class, 'loginUser']);

    Route::group(['middleware' =>  ['auth:sanctum', 'user']], function () {
        Route::get('restaurants', [RestrauntController::class, 'index']);
    });
});

Route::group(['prefix' => 'restraunt'], function () {
    Route::post('register', [RestrauntAuthController::class, 'createRestraunt']);
    Route::post('login', [RestrauntAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', 'restraunt']], function () {
        Route::post('driver/store', [DriverController::class, 'storeDriver']);
        Route::get('drivers', [DriverController::class, 'index']);
    });
});



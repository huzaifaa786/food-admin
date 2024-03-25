<?php

use App\Http\Controllers\Api\Restraunt\AuthController as RestrauntAuthController;
use App\Http\Controllers\Api\Restraunt\CategoryController;
use App\Http\Controllers\Api\Restraunt\DriverController;
use App\Http\Controllers\Api\Restraunt\MenuCategoryController;
use App\Http\Controllers\Api\Restraunt\MenuItemController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\RestrauntController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'user'], function () {
    Route::post('register', [AuthController::class, 'createUser']);
    Route::post('login', [AuthController::class, 'loginUser']);

    Route::group(['middleware' =>  ['auth:sanctum', 'user']], function () {
        Route::get('restaurants', [RestrauntController::class, 'index']);
        Route::get('home', [HomeController::class, 'index']);
    });
});

Route::group(['prefix' => 'restraunt'], function () {
    Route::post('register', [RestrauntAuthController::class, 'createRestraunt']);
    Route::post('login', [RestrauntAuthController::class, 'login']);
    Route::get('categories', [CategoryController::class, 'index']);

    Route::group(['middleware' => ['auth:sanctum', 'restraunt']], function () {
        Route::get('profile', [RestrauntAuthController::class, 'profile']);
        Route::post('updatePassword', [RestrauntAuthController::class, 'updatePassword']);
        Route::post('profile/update', [RestrauntAuthController::class, 'profileUpdate']);
        Route::post('driver/store', [DriverController::class, 'storeDriver']);
        Route::get('drivers', [DriverController::class, 'index']);
        Route::post('driver/update/{id}', [DriverController::class, 'udpateDriver']);
        Route::get('driver/delete/{id}', [DriverController::class, 'deleteDriver']);
        Route::post('menuCategory/create', [MenuCategoryController::class, 'create']);
        Route::get('menucategories', [MenuCategoryController::class, 'index']);
        Route::get('menuItems', [MenuItemController::class, 'index']);
        Route::post('menuItem/create', [MenuItemController::class, 'create']);
        Route::post('menuItem/udpate/{id}', [MenuItemController::class, 'update']);
    });
});

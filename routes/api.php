<?php

use App\Http\Controllers\Api\Restraunt\AuthController as RestrauntAuthController;
use App\Http\Controllers\Api\Restraunt\CategoryController;
use App\Http\Controllers\Api\Restraunt\DriverController;
use App\Http\Controllers\Api\Restraunt\MenuCategoryController;
use App\Http\Controllers\Api\Restraunt\MenuItemController;
use App\Http\Controllers\Api\Restraunt\OrderController as RestrauntOrderController;
use App\Http\Controllers\Api\Restraunt\PosterController;
use App\Http\Controllers\Api\Rider\AuthController as RiderAuthController;
use App\Http\Controllers\Api\Rider\OrderController as RiderOrderController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\RestrauntController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'user'], function () {
    Route::post('register', [AuthController::class, 'createUser']);
    Route::post('login', [AuthController::class, 'loginUser']);
    Route::any('forgetpassword', [AuthController::class, 'forgetPassword']);
    Route::any('verifyemail', [AuthController::class, 'verifyEmail']);
    Route::any('verifyOtp', [AuthController::class, 'verifyOtp']);
    Route::any('forgetUpdatePassword', [AuthController::class, 'forgetupdatePassword']);

    Route::group(['middleware' =>  ['auth:sanctum', 'user']], function () {
        Route::get('restaurants', [RestrauntController::class, 'index']);
        Route::get('category/restaurants/{id}', [RestrauntController::class, 'restaurantByCategory']);
        Route::get('restaurant-detail/{id}', [RestrauntController::class, 'restaurantDetail']);
        Route::post('updatePassword', [AuthController::class, 'updatePassword']);
        Route::get('home', [HomeController::class, 'index']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('add/cart', [CartController::class, 'add']);
        Route::post('update/cart', [CartController::class, 'update']);
        Route::post('remove/cart', [CartController::class, 'remove']);
        Route::get('get/cart', [CartController::class, 'get']);
        Route::post('place/order', [OrderController::class, 'placeOrder']);
        Route::post('add/address', [AddressController::class, 'create']);
        Route::get('addressess', [AddressController::class, 'get']);
        Route::post('address/main', [AddressController::class, 'setMain']);
        Route::post('address/remove', [AddressController::class, 'delete']);
        Route::post('address/update/{id}', [AddressController::class, 'update']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('profile/update', [AuthController::class, 'profileUpdate']);
        Route::get('notifications', [NotificationController::class, 'index']);
    });
});

Route::group(['prefix' => 'restraunt'], function () {
    Route::post('register', [RestrauntAuthController::class, 'createRestraunt']);
    Route::post('login', [RestrauntAuthController::class, 'login']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::any('forgetpassword', [AuthController::class, 'forgetPassword']);
    Route::any('verifyemail', [AuthController::class, 'verifyEmail']);
    Route::any('verifyOtp', [AuthController::class, 'verifyOtp']);
    Route::any('forgetUpdatePassword', [AuthController::class, 'forgetupdatePassword']);

    Route::group(['middleware' => ['auth:sanctum', 'restraunt']], function () {
        Route::get('profile', [RestrauntAuthController::class, 'profile']);
        Route::post('updatePassword', [RestrauntAuthController::class, 'updatePassword']);
        Route::post('profile/update', [RestrauntAuthController::class, 'profileUpdate']);
        Route::post('driver/store', [DriverController::class, 'storeDriver']);
        Route::get('drivers', [DriverController::class, 'index']);
        Route::get('driver/{id}', [DriverController::class, 'show']);
        Route::post('driver/update/{id}', [DriverController::class, 'udpateDriver']);
        Route::get('driver/delete/{id}', [DriverController::class, 'deleteDriver']);
        Route::post('menuCategory/create', [MenuCategoryController::class, 'create']);
        Route::get('menucategories', [MenuCategoryController::class, 'index']);
        Route::get('menuItems', [MenuItemController::class, 'index']);
        Route::post('menuItem/updateAvailability/{id}', [MenuItemController::class, 'updateAvailability']);
        Route::post('menuItem/create', [MenuItemController::class, 'create']);
        Route::post('menuItem/udpate/{id}', [MenuItemController::class, 'update']);
        Route::post('add/poster', [PosterController::class, 'addPoster']);
        Route::get('orders', [RestrauntOrderController::class, 'index']);
        Route::get('order/accept/{id}', [RestrauntOrderController::class, 'acceptOrder']);
        Route::get('order/reject/{id}', [RestrauntOrderController::class, 'rejectOrder']);
        Route::post('assign/order', [RestrauntOrderController::class, 'assignDriver']);

    });
});


Route::group(['prefix' => 'rider'], function () {
    Route::post('login', [RiderAuthController::class, 'login']);

    Route::group(['middleware' =>  ['auth:sanctum', 'rider']], function () {
        Route::get('profile', [RiderAuthController::class, 'profile']);
        Route::get('change/status', [RiderAuthController::class, 'toggleActive']);
        Route::get('orders', [RiderOrderController::class, 'index']);
        Route::get('order/deliver/{id}', [RiderOrderController::class, 'deliverOrder']);
        Route::post('order/updateLocation', [RiderOrderController::class, 'changeOrderLocation']);
    });
});

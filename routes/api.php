<?php

use App\Http\Controllers\Api\Restraunt\AuthController as RestrauntAuthController;
use App\Http\Controllers\Api\Restraunt\CategoryController;
use App\Http\Controllers\Api\Restraunt\DriverController;
use App\Http\Controllers\Api\Restraunt\MenuCategoryController;
use App\Http\Controllers\Api\Restraunt\MenuItemController;
use App\Http\Controllers\Api\Restraunt\NotificationController as RestrauntNotificationController;
use App\Http\Controllers\Api\Restraunt\OrderController as RestrauntOrderController;
use App\Http\Controllers\Api\Restraunt\PosterController;
use App\Http\Controllers\Api\Restraunt\RestaurantFeeController;
use App\Http\Controllers\Api\Restraunt\SaleController;
use App\Http\Controllers\Api\Rider\AuthController as RiderAuthController;
use App\Http\Controllers\Api\Rider\NotificationController as RiderNotificationController;
use App\Http\Controllers\Api\Rider\OrderController as RiderOrderController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\RatingController;
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

    Route::group(['middleware' => ['auth:sanctum', 'user']], function () {
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
        Route::post('check/range', [OrderController::class, 'checkRange']);
        Route::post('add/address', [AddressController::class, 'create']);
        Route::get('addressess', [AddressController::class, 'get']);
        Route::post('address/main', [AddressController::class, 'setMain']);
        Route::post('address/remove', [AddressController::class, 'delete']);
        Route::post('address/update/{id}', [AddressController::class, 'update']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('order/{id}', [OrderController::class, 'getOrder']);
        Route::post('profile/update', [AuthController::class, 'profileUpdate']);
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('notification/count', [NotificationController::class, 'unreadCount']);
        Route::post('rating/store', [RatingController::class, 'store']);
        Route::get('rating/check', [RatingController::class, 'checkRating']);
        Route::get('ratings/{id}', [RatingController::class, 'getRatings']);
        Route::get('notification/seen/{id}', [NotificationController::class, 'seenNotification']);
    });
});

Route::group(['prefix' => 'restraunt'], function () {
    Route::post('register', [RestrauntAuthController::class, 'createRestraunt']);
    Route::post('login', [RestrauntAuthController::class, 'login']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::any('forgetpassword', [RestrauntAuthController::class, 'forgetPassword']);
    Route::any('verifyemail', [RestrauntAuthController::class, 'verifyEmail']);
    Route::any('verifyOtp', [RestrauntAuthController::class, 'verifyOtp']);
    Route::any('forgetUpdatePassword', [RestrauntAuthController::class, 'forgetupdatePassword']);
    Route::get('fee', [RestaurantFeeController::class, 'fee']);
    Route::post('payment/update', [RestaurantFeeController::class, 'updatePaymentStatus']);

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
        Route::get('order/{id}', [RestrauntOrderController::class, 'getOrder']);
        Route::get('order/accept/{id}', [RestrauntOrderController::class, 'acceptOrder']);
        Route::get('order/reject/{id}', [RestrauntOrderController::class, 'rejectOrder']);
        Route::post('assign/order', [RestrauntOrderController::class, 'assignDriver']);
        Route::get('notifications', [RestrauntNotificationController::class, 'index']);
        Route::get('notification/count', [RestrauntNotificationController::class, 'unreadCount']);
        Route::get('notification/seen/{id}', [RestrauntNotificationController::class, 'seenNotification']);
        Route::get('sales', [SaleController::class, 'index']);
    });
});


Route::group(['prefix' => 'rider'], function () {
    Route::post('login', [RiderAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', 'rider']], function () {
        Route::get('profile', [RiderAuthController::class, 'profile']);
        Route::get('change/status', [RiderAuthController::class, 'toggleActive']);
        Route::get('orders', [RiderOrderController::class, 'index']);
        Route::get('order/{id}', [RiderOrderController::class, 'getOrder']);
        Route::get('order/deliver/{id}', [RiderOrderController::class, 'deliverOrder']);
        Route::get('order/onway/{id}', [RiderOrderController::class, 'onWayOrder']);
        Route::post('order/updateLocation', [RiderOrderController::class, 'changeOrderLocation']);
        Route::get('notifications', [RiderNotificationController::class, 'index']);
        Route::get('notification/count', [RiderNotificationController::class, 'unreadCount']);
        Route::get('notification/seen/{id}', [RiderNotificationController::class, 'seenNotification']);
        Route::post('updatePassword', [RiderAuthController::class, 'updatePassword']);
    });
});

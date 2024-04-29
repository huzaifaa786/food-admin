<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Livewire\PusherTest;
use Illuminate\Support\Facades\Route;

Route::get('/test', PusherTest::class);

Route::view('/', 'admin.login')->name('adminlogin');
Route::post('admin.login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/layouts', function () {
        return view('admin.layouts.app');
    });
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout/page');

    Route::get('user/index',[AdminUserController::class,'index'])->name('user.index');

    //Resturant Routes
    Route::get('resturant/index',[RestaurantController::class,'index'])->name('resturant.index');
    Route::get('resturant/order/{id}',[RestaurantController::class,'resturantorder'])->name('resturant.order');

    Route::post('order/items',[RestaurantController::class,'orderitems'])->name('order.item');

    //sales
    Route::get('table',[SalesController::class,'saletable'])->name('saletable');
    Route::post('sale/table',[SalesController::class,'salestable'])->name('sales.table');
});

require __DIR__ . '/auth.php';

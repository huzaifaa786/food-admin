<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\RestaurantFeeController;
use App\Http\Controllers\Admin\RiderController;
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

    Route::get('user/index', [AdminUserController::class, 'index'])->name('user.index');

    //Resturant Routes
    Route::get('resturant/index', [RestaurantController::class, 'index'])->name('resturant.index');
    Route::get('resturant/order/{id}', [RestaurantController::class, 'resturantorder'])->name('resturant.order');
    Route::get('resturant/status/{id}', [RestaurantController::class, 'resturantStatus'])->name('resturant.status');
    Route::get('menu/index', [RestaurantController::class, 'showMenu'])->name('menu.index');
    Route::get('/menu/{restaurant_id}',[RestaurantController::class,'showMenuItems'])->name('menu.items');
    Route::post('order/items', [RestaurantController::class, 'orderitems'])->name('order.item');

    //sales
    Route::get('table', [SalesController::class, 'saletable'])->name('saletable');
    Route::post('sale/table', [SalesController::class, 'salestable'])->name('sales.table');
    Route::view('/sale-graph', 'admin.Sales.graph')->name('sale/graph');
    Route::post('/sale/graph', [SalesController::class, 'graph'])->name('sale-graph');

    Route::post('order/items', [RestaurantController::class, 'orderitems'])->name('order.item');

    // routes for dashboard
    Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'showTotalRestraunts'])->name('dashboard');

    // Rider routes
    Route::get('rider', [RiderController::class, 'index'])->name('rider');
    Route::get('/rider/detail/{id}',[RiderController::class,'ridersinfo'])->name('riders.detail');
    Route::post('/rider/order/detail',[RiderController::class,'riderorder'])->name('rider.order.detail');

    //category
    Route::view('/category','admin.category.create')->name('category');
    Route::post('/create/category',[AdminCategoryController::class,'store'])->name('category.store');
    Route::get('index',[AdminCategoryController::class,'index'])->name('category.index');
    Route::get('/category/delete/{id}',[AdminCategoryController::class,'delete'])->name('category.delete');
    Route::get('/category/edit/{id}',[AdminCategoryController::class,'edit'])->name('category.edit');
    Route::post('/category/update',[AdminCategoryController::class,'update'])->name('category.update');
    Route::post('/fee/store',[RestaurantFeeController::class,'store'])->name('fee.store');
    Route::get('/fee/create',[RestaurantFeeController::class,'create'])->name('fee.create');

});

require __DIR__ . '/auth.php';

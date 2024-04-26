<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Livewire\PusherTest;
use Illuminate\Support\Facades\Route;

Route::get('/test', PusherTest::class);

Route::view('/', 'admin.login')->name('adminlogin');
Route::post('admin.login',[AdminController::class,'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/layouts', function () {
        return view('admin.layouts.app');
    });
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout/page');
Route::view('/restraunts', 'admin.restraunts.index')->name('restraunts');

});

require __DIR__.'/auth.php';

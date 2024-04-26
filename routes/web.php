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
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::view('about', 'about')->name('about');

//     Route::get('users', [UserController::class, 'index'])->name('users.index');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

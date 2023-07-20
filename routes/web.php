<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ProductPurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
    Route::get('dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('profile', function () {return view('profile');})->name('profile');
    Route::get('user-management', function () {return view('laravel-examples/user-management');})->name('user-management');
    Route::get('tables', function () {return view('tables');})->name('tables');

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index')->name('product.index');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/store', 'store')->name('product.store');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::post('/update/{id}', 'update')->name('product.update');
        Route::get('/delete/{id}', 'destroy')->name('product.destroy');
    });

    Route::controller(ProductPurchaseController::class)->prefix('product-pruchased')->group(function () {
        Route::get('/', 'index')->name('product-pruchased.index');
        Route::get('/create', 'create')->name('product-pruchased.create');
    });


    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {return view('dashboard');})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    // Route::get('/register', [RegisterController::class, 'create']);
    // Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    // Route::get('/login/forgot-password', [ResetController::class, 'create']);
    // Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    // Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    // Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {return view('session/login-session');})->name('login');

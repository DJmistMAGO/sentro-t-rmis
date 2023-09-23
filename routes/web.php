<?php

use App\Http\Controllers\DamagedProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchasedProductController;
use App\Http\Controllers\ReturnProductController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StockProductController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');

    Route::controller(UserManagementController::class)->prefix('user-management')->group(function () {
        Route::get('/', 'index')->name('user-management.index');
        Route::get('/create', 'create')->name('user-management.create');

    });

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index')->name('product.index');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/store', 'store')->name('product.store');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::get('/view/{id}', 'show')->name('product.show');
        Route::post('/update/{id}', 'update')->name('product.update');
        Route::get('/delete/{id}', 'destroy')->name('product.destroy');
        Route::get('/sample', 'sample')->name('product.sample');
    });

    Route::controller(PurchasedProductController::class)->prefix('purchased-product')->group(function () {
        Route::get('/', 'index')->name('purchased-product.index');
        Route::get('/create', 'create')->name('purchased-product.create');
        Route::post('/store', 'store')->name('purchased-product.store');
        // Route::get('/edit/{purchased}', 'edit')->name('purchased-product.edit');
        // Route::post('/update/{purchased}', 'update')->name('purchased-product.update');

    });

    Route::controller(ReturnProductController::class)->prefix('returned-product')->group(function () {
        Route::get('/', 'index')->name('returned-product.index');
        Route::get('/create', 'create')->name('returned-product.create');
        Route::post('/store', 'store')->name('returned-product.store');

    });

    Route::controller(DamagedProductController::class)->prefix('damaged-product')->group(function () {
        Route::get('/', 'index')->name('damaged-product.index');
        Route::get('/create', 'create')->name('damaged-product.create');
        Route::post('/store', 'store')->name('damaged-product.store');
    });

    Route::controller(StockProductController::class)->prefix('stock-product')->group(function () {
        Route::get('/', 'index')->name('stock-product.index');
    });

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {return view('dashboard');})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
});

Route::get('/login', function () {return view('session/login-session');})->name('login');

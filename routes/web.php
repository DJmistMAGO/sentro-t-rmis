<?php

use App\Http\Controllers\DamagedProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchasedProductController;
use App\Http\Controllers\ReturnProductController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StockProductController;
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
    // Route::get('dashboard', function () {return view('dashboard');})->name('dashboard');
    // <!-- Route::get('profile', function () {return view('profile');})->name('profile'); -->
    Route::get('user-management', function () {return view('users/user-management');})->name('user-management');
    // Route::get('tables', function () {return view('tables');})->name('tables');

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index')->name('product.index');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/store', 'store')->name('product.store');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::get('/view/{id}', 'show')->name('product.show');
        Route::post('/update/{id}', 'update')->name('product.update');
        Route::get('/delete/{id}', 'destroy')->name('product.destroy');
    });

    Route::controller(PurchasedProductController::class)->prefix('purchased-product')->group(function () {
        Route::get('/', 'index')->name('purchased-product.index');
        Route::get('/create', 'create')->name('purchased-product.create');
        Route::post('/store', 'store')->name('purchased-product.store');
    });

    Route::controller(ReturnProductController::class)->prefix('returned-product')->group(function () {
        Route::get('/', 'index')->name('returned-product.index');
        Route::get('/create', 'create')->name('returned-product.create');
    });

    Route::controller(DamagedProductController::class)->prefix('damaged-product')->group(function () {
        Route::get('/', 'index')->name('damaged-product.index');
        Route::get('/create', 'create')->name('damaged-product.create');
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

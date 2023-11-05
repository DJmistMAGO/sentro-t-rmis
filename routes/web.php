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
use App\Http\Controllers\LogController;

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
    Route::get('/chart-data', [HomeController::class, 'getChartData']);

    Route::controller(UserManagementController::class)->prefix('user-management')->group(function () {
        Route::get('/', 'index')->name('user-management.index');
        Route::get('/create', 'create')->name('user-management.create');
        Route::post('/store', 'store')->name('user-management.store');
        Route::put('/update/{user}', 'updateStaff')->name('user-management.update');
        Route::get('/view-profile/{user}', 'viewProfile')->name('user-info.view-profile');
        Route::post('/profile', 'profileStore')->name('user-management.profile-update');
        Route::post('/password', 'passwordUpdate')->name('user-management.password-update');
        Route::get('/view-staff/{user}', 'viewStaff')->name('user-management.view-staff');
        Route::delete('/delete/{user}', 'destroy')->name('user-management.delete');
        Route::post('/pass-reset/{user}', 'resetPass')->name('user-management.reset-pass');
    });

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index')->name('product.index');
        Route::get('/create', 'create')->name('product.create');
        Route::post('/store', 'store')->name('product.store');
        Route::get('/edit/{id}', 'edit')->name('product.edit');
        Route::get('/view/{id}', 'show')->name('product.show');
        Route::post('/update/{id}', 'update')->name('product.update');
        Route::put('/restock/{product}', 'restock')->name('product.restock');
        Route::get('/delete/{id}', 'destroy')->name('product.destroy');
        Route::get('/sample', 'sample')->name('product.sample');
    });

    Route::controller(PurchasedProductController::class)->prefix('purchased-product')->group(function () {
        Route::get('/', 'index')->name('purchased-product.index');
        Route::get('/create', 'create')->name('purchased-product.create');
        Route::post('/store', 'store')->name('purchased-product.store');
        Route::get('/view/{purchased}', 'view')->name('purchased-product.view');
        Route::get('/edit/{prodPurInfo}', 'edit')->name('purchased-product.edit');
        Route::put('/edit/{prodPurInfo}', 'update')->name('purchased-product.update');


        // Route::post('/update/{purchased}', 'update')->name('purchased-product.update');

    });

    Route::controller(ReturnProductController::class)->prefix('returned-product')->group(function () {
        Route::get('/', 'index')->name('returned-product.index');
        Route::get('/create', 'create')->name('returned-product.create');
        Route::post('/store', 'store')->name('returned-product.store');
        Route::get('/view/{purchased}', 'view')->name('returned-product.view');
        Route::get('/edit/{prodPurInfo}', 'edit')->name('returned-product.edit');
        Route::put('/update/{prodPurInfo}', 'update')->name('returned-product.update');
    });

    Route::controller(DamagedProductController::class)->prefix('damaged-product')->group(function () {
        Route::get('/', 'index')->name('damaged-product.index');
        Route::get('/create', 'create')->name('damaged-product.create');
        Route::post('/store', 'store')->name('damaged-product.store');
        Route::get('/view/{purchased}', 'view')->name('damaged-product.view');
        Route::get('/edit/{prodPurInfo}', 'edit')->name('damaged-product.edit');
        Route::put('/update/{prodPurInfo}', 'update')->name('damaged-product.update');
    });

    Route::controller(StockProductController::class)->prefix('stock-product')->group(function () {
        Route::get('/', 'index')->name('stock-product.index');
    });

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
        return view('dashboard');
    })->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
});

Route::controller(LogController::class)->prefix('logs')->group(function () {
    Route::get('/', 'index')->name('logs.index');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

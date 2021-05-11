<?php

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


Route::group(['prefix' => 'admin'],function(){
    Route::get('/login',[\App\Http\Controllers\Backend\HomeController::class,'login'])->name('auth.login');
    Route::post('/login',[\App\Http\Controllers\Backend\HomeController::class,'signIn'])->name('auth.signIn');
    Route::get('/logout',[\App\Http\Controllers\Backend\HomeController::class,'logout'])->name('auth.logout');

    Route::group(['middleware' => 'checkAuth'],function(){
        Route::get('/',[\App\Http\Controllers\Backend\HomeController::class,'index'])->name('index');
        Route::get('/statistic',[\App\Http\Controllers\Backend\HomeController::class,'statistic'])->name('statistic');
        Route::resource('readers',\App\Http\Controllers\Backend\ReaderController::class);
        Route::resource('books',\App\Http\Controllers\Backend\BookController::class);
        Route::get('/orders/search',[\App\Http\Controllers\Backend\OrderController::class,'search'])->name('orders.search');
        Route::resource('orders',\App\Http\Controllers\Backend\OrderController::class);
        Route::resource('users',\App\Http\Controllers\Backend\UserController::class);

    });
});

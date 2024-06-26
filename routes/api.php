<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function () {
    // Auth
    Route::prefix('/user')->controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    // user
    Route::prefix('user')->middleware(['auth:sanctum', 'type.user'])->group(function () {
    });


    // product
    Route::prefix('product')->controller(ProductController::class)->group(function(){
       Route::get('/', 'index');
       Route::get('/{id}','show');
    });


    Route::prefix('rating')->controller(RatingController::class)->group(function () {
        Route::get('/','index');
        Route::post('/','store')->middleware(['auth:sanctum','type.user']);
    });

    // seller
    Route::prefix('seller')->controller(ProductController::class)->group(function(){
        // Route::get('/product','index');
        Route::post('/product','store');
    } );
});

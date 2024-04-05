<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Product\ProductController;
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


    Route::get('/product', [ProductController::class,'index']);

    // seller
    // Route::prefix('seller')->controller(ProductController::class)->group(function(){
    //     // Route::get('/product','index');
    //     Route::post('/product','store');
    // } );
});

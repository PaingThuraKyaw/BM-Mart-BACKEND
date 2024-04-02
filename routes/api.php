<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/seller/')->controller(ProductController::class)->group(function(){
    Route::get('/product','index');
    Route::post('/product','store');
} );

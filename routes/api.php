<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;

Route::get('/user', function (Request $request) {
    
});

Route::middleware('auth:sanctum')->group( function () {


Route::get('/products', [ProductController::class, 'index']);

});

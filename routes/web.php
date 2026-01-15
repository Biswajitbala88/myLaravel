<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePaymentController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/user', [UserController::class, 'index']);
Route::get('/env-check', function () {
    return App::environment();
});

Route::get('/get-pdf', [UserController::class, 'getPdf']);


Route::get('/file-upload', [UserController::class, 'fileUploadForm']);
Route::post('/upload', [UserController::class, 'fileUpload']);

// send mail
Route::get('/send-demo-mail', [UserController::class, 'sendDemoMail']);

// generate QR code
Route::get('/generate-qr-code', [UserController::class, 'generateQrCode']);

Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
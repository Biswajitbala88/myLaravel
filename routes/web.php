<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('callback-url', [GoogleController::class, 'handleGoogleCallback']);

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

Route::get('/rule-form', [UserController::class, 'ruleForm']);
Route::post('/rule-form-post', [UserController::class, 'ruleFormPost'])->name('custom.validation.post');

Route::get('/chatgpt', [ChatGPTController::class, 'index'])->name('chatgpt.index');
Route::post('/chatgptPost', [ChatGPTController::class, 'getResponse'])->name('chatgpt.getResponse');

Route::resource('users', UserController::class)->middleware('auth');

require __DIR__.'/auth.php';



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', [UserController::class, 'index']);
Route::get('/env-check', function () {
    return App::environment();
});

Route::get('/get-pdf', [UserController::class, 'getPdf']);


Route::get('/file-upload', [UserController::class, 'fileUploadForm']);
Route::post('/upload', [UserController::class, 'fileUpload']);

// send mail
Route::get('/send-demo-mail', [UserController::class, 'sendDemoMail']);
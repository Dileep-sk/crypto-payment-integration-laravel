<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [PaymentController::class, 'index']);
Route::post('/pay', [PaymentController::class, 'create']);
Route::post('/webhook', [PaymentController::class, 'webhook']);
Route::get('/status', [PaymentController::class, 'status']);

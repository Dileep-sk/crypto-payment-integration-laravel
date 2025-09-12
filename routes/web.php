<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('products');
})->name('products');

Route::get('/checkout', [BookingController::class, 'showBookingForm'])->name('show.payment.form');

Route::post('/checkout', [BookingController::class, 'createCharge'])->name('checkout.process');

Route::get('/payment-success', function () {
    return view('payment-success');
})->name('payment.success');

Route::post('/webhook/coinbase', [BookingController::class, 'handleWebhook'])->name('webhook.coinbase');

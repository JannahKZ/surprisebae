<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\DecoServiceController;
use App\Http\Controllers\User\DeliveryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\ChatController;


/*
Route::apiResource('products', ProductController::class);
Route::apiResource('deco-services', DecoServiceController::class);
Route::apiResource('deliveries', DeliveryController::class);
*/

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('deco-services')->group(function () {
    Route::get('/', [DecoServiceController::class, 'index']);
    Route::get('/{id}', [DecoServiceController::class, 'show']);
    Route::post('/', [DecoServiceController::class, 'store']);
    Route::put('/{id}', [DecoServiceController::class, 'update']);
    Route::delete('/{id}', [DecoServiceController::class, 'destroy']);
});

Route::prefix('deliveries')->group(function () {
    Route::get('/', [DeliveryController::class, 'index']);
    Route::get('/{id}', [DeliveryController::class, 'show']);
    Route::post('/', [DeliveryController::class, 'store']);
    Route::put('/{id}', [DeliveryController::class, 'update']);
    Route::delete('/{id}', [DeliveryController::class, 'destroy']);
});

Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/delivery/email/{email}', [OrderController::class, 'getDeliveryOrdersByEmail']);

Route::post('/messages', [ChatController::class, 'sendMessage']);
Route::get('/messages/{userId}/{adminId}', [ChatController::class, 'getMessages']);
Route::post('/messages', [ChatController::class, 'apiPostMessage']);

Route::get('deco-services/{id}/unavailable-dates', [App\Http\Controllers\User\DecoServiceController::class, 'getUnavailableDates']);

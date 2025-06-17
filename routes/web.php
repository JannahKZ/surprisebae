<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DecoServiceController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

// Products
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'productByCategory'])->name('categories');
    Route::get('/category/{category}', [ProductController::class, 'index'])->name('index');
    Route::get('/category/{category}/create', [ProductController::class, 'create'])->name('create');
    Route::post('/category/{category}', [ProductController::class, 'store'])->name('store');
    Route::get('{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('{id}', [ProductController::class, 'destroy'])->name('delete');
});

// Occasions
Route::prefix('decoServices')->name('decoServices.')->group(function () {
    Route::get('/categories', [DecoServiceController::class, 'serviceByCategory'])->name('categories');
    Route::get('/category/{category}', [DecoServiceController::class, 'index'])->name('index');
    Route::get('/category/{category}/create', [DecoServiceController::class, 'create'])->name('create');
    Route::post('/category/{category?}', [DecoServiceController::class, 'store'])->name('store');
    Route::get('{id}/edit', [DecoServiceController::class, 'edit'])->name('edit');
    Route::put('{id}', [DecoServiceController::class, 'update'])->name('update');
    Route::delete('{id}', [DecoServiceController::class, 'destroy'])->name('delete');
});

// Deliveries
Route::prefix('deliveries')->name('deliveries.')->group(function () {
    Route::get('/', [DeliveryController::class, 'index'])->name('index');
    Route::get('create', [DeliveryController::class, 'create'])->name('create');
    Route::post('/', [DeliveryController::class, 'store'])->name('store');
    Route::get('{id}/edit', [DeliveryController::class, 'edit'])->name('edit');
    Route::put('{id}', [DeliveryController::class, 'update'])->name('update');
    Route::delete('{id}', [DeliveryController::class, 'destroy'])->name('delete');
});

// Reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/salesSummary', [ReportController::class, 'salesSummary'])->name('salesSummary');
    Route::get('/inventory', [ReportController::class, 'inventory'])->name('inventory');
    Route::get('/salesHighlight', [ReportController::class, 'salesHighlight'])->name('salesHighlight');
});

// Categories
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/products/categories', [CategoryController::class, 'productbyCategory'])->name('products.categories');
    Route::get('/services/categories', [CategoryController::class, 'servicebyCategory'])->name('decoServices.categories');
    Route::get('create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('{id}', [CategoryController::class, 'destroy'])->name('destroy');
});


Route::prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::post('/update', [AccountController::class, 'update'])->name('update');
});


Route::prefix('chat')->name('chat.')->group(function() {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
    Route::post('/{conversation}/message', [ChatController::class, 'sendMessage'])->name('message.send');
});

Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// Auth
Auth::routes();
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

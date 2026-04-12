<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UseController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);

route::prefix('category')->group(function () {
    route::get('/food', [ProductController::class, 'food']);
    route::get('/beauty', [ProductController::class, 'beauty']);
    route::get('/home', [ProductController::class, 'home']);
    route::get('/baby', [ProductController::class, 'baby']);
});

route::get('/user/{id}/name/{name}', [UseController::class, 'profile']);
route::get('/sales', [SalesController::class, 'index']);
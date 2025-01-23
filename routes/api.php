<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']); // Default product listing
Route::get('/products/search', [ProductController::class, 'search']); // Product search
Route::delete('/products/{id}', [ProductController::class, 'destroy']); // Product delete

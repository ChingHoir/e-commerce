<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

// Public authentication routes
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:api');
    Route::get('/me', 'me')->middleware('auth:api');
    Route::get('/tokens', 'tokens')->middleware('auth:api');
    Route::delete('/tokens/{tokenId}', 'revokeToken')->middleware('auth:api');
});

// Legacy user endpoint (deprecated, use /auth/me instead)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Category routes
Route::controller(CategoryController::class)->prefix('categories')->group(function () {
    Route::get('/', 'getCategories');
    Route::post('/', 'createCategory')->middleware('auth:api');
    Route::get('/{categoryId}', 'getCategory');
    Route::patch('/{categoryId}', 'updateCategory')->middleware('auth:api');
    Route::delete('/{categoryId}', 'deleteCategory')->middleware('auth:api');
});

// Product routes with policy authorization
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'getProducts');
    Route::post('/', 'createProduct')->middleware('auth:api'); // Manager/Admin only
    Route::get('/{productId}', 'getProduct');
    Route::patch('/{productId}', 'updateProduct')->middleware('auth:api');
    Route::delete('/{productId}', 'deleteProduct')->middleware('auth:api');
});

// Task routes with policy authorization
Route::middleware('auth:api')->controller(TaskController::class)->prefix('tasks')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{task}', 'show');
    Route::patch('/{task}', 'update');
    Route::patch('/{task}/status', 'updateStatus');
    Route::delete('/{task}', 'destroy');
});

// Project routes with policy authorization
Route::middleware('auth:api')->controller(ProjectController::class)->prefix('projects')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{project}', 'show');
    Route::patch('/{project}', 'update');
    Route::delete('/{project}', 'destroy');
});

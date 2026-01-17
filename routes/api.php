<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\CommentController;

Route::post('/authors', [AuthorController::class, 'store']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::post('/audiences', [AudienceController::class, 'store']);
Route::post('/subscribe', [AudienceController::class, 'subscribe']);
Route::post('/comments', [CommentController::class, 'store']);
Route::get('/authors/{id}/articles', [AuthorController::class, 'articles']);
Route::get('/articles/{id}/audiences', [ArticleController::class, 'audiences']);
Route::get('/authors/{id}/audiences', [AuthorController::class, 'audiences']);
Route::get('/audiences/{id}/comments', [AudienceController::class, 'comments']);
Route::get('/comments', [CommentController::class, 'index']);

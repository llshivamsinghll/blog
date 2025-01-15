<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/articles', [ArticleController::class, 'getAllArticles']);
Route::get('/articles/category/{category}', [ArticleController::class, 'getAllArticles']);

// Protected routes (authentication middleware is applied)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/articles', [ArticleController::class, 'createArticle']);
    Route::get('/articles/{id}', [ArticleController::class, 'getArticle']);
    Route::patch('/articles/{id}', [ArticleController::class, 'updateArticle']);
    Route::delete('/articles/{id}', [ArticleController::class, 'deleteArticle']);
});

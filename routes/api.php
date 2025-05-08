<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SavedArticleController;

Route::middleware('auth')->group(function () {
    Route::resource('saved-articles', SavedArticleController::class)->except(['update', 'edit', 'create']);
});

Route::apiResource('users', UserController::class); // gunakan dengan hati-hati untuk data sensitif!

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('user', [AuthController::class, 'me']);

Route::middleware('auth:api')->group(function () {
    // Endpoint untuk melihat artikel yang disimpan
    Route::get('saved-articles', [SavedArticleController::class, 'index']);

    // Endpoint untuk menyimpan artikel
    Route::post('saved-articles', [SavedArticleController::class, 'store']);

    // Endpoint untuk menghapus artikel yang disimpan
    Route::delete('saved-articles/{id}', [SavedArticleController::class, 'destroy']);
});
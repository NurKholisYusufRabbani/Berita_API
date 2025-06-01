<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

// ✅ Public Endpoints
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

// ✅ Protected Routes (JWT Required)
Route::middleware('auth:api')->group(function () {

    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ Saved Articles
    Route::get('saved-articles', [SavedArticleController::class, 'index']);     // List saved articles
    Route::post('saved-articles', [SavedArticleController::class, 'store']);    // Save new article
    Route::get('saved-articles/token/{token}', [SavedArticleController::class, 'findByToken']);
    Route::delete('saved-articles/{id}', [SavedArticleController::class, 'destroy']); // Delete saved article
    
    // ✅ DISCUSSIONS
    Route::get('discussions/{token}', [DiscussionController::class, 'index']);
    Route::post('discussions/{token}', [DiscussionController::class, 'store']);

    // ✅ COMMENTS (on a discussion of a given article_token)
    Route::get('articles/{token}/comments', [CommentController::class, 'index']);
    Route::post('articles/{token}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    // ✅ REPLIES (on a comment)
    Route::get('comments/{comment}/replies', [ReplyController::class, 'index']);
    Route::post('comments/{comment}/replies', [ReplyController::class, 'store']);
    Route::delete('replies/{id}', [ReplyController::class, 'destroy']);

    Route::get('auth/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// ✅ Admin-only route (hanya bisa diakses oleh role:admin)
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::get('/admin/users/{user}', [UserController::class, 'show']);
    Route::put('/admin/users/{user}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [ProfileController::class, 'me']);
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto']);
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/me', [SettingsController::class, 'me']);
    Route::put('/settings', [SettingsController::class, 'update']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

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

    // ✅ User Profile
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::delete('/user/profile', [UserController::class, 'destroyProfile']);

    // ✅ Saved Articles
    Route::get('saved-articles', [SavedArticleController::class, 'index']);     // List saved articles
    Route::post('saved-articles', [SavedArticleController::class, 'store']);    // Save new article
    Route::delete('saved-articles/{id}', [SavedArticleController::class, 'destroy']); // Delete saved article

    // ✅ Comments (on Saved Articles)
    Route::get('saved-articles/{article}/comments', [CommentController::class, 'index']);   // View comments on an article
    Route::post('saved-articles/{article}/comments', [CommentController::class, 'store']);  // Post a comment
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);                 // Delete a comment

    // ✅ Replies (on Comments)
    Route::get('comments/{comment}/replies', [ReplyController::class, 'index']);   // View replies to a comment
    Route::post('comments/{comment}/replies', [ReplyController::class, 'store']);  // Reply to a comment
    Route::delete('replies/{id}', [ReplyController::class, 'destroy']);           // Delete a reply
});

// ✅ Admin-only route (hanya bisa diakses oleh role:admin)
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::get('/admin/users/{user}', [UserController::class, 'show']);
    Route::put('/admin/users/{user}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
});

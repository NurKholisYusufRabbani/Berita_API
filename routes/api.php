<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;

// ✅ Public Endpoints
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ✅ Protected Routes (JWT Required)
Route::middleware('auth:api')->group(function () {

    // ✅ User Profile
    Route::get('user', [AuthController::class, 'me']);           // View profile
    Route::put('user', [AuthController::class, 'update']);       // Update profile
    Route::delete('user', [AuthController::class, 'destroy']);   // Delete account

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

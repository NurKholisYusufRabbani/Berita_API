<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    Route::resource('saved-articles', SavedArticleController::class)->except(['update', 'edit', 'create']);
});

Route::apiResource('users', UserController::class); // gunakan dengan hati-hati untuk data sensitif!

Route::middleware('auth')->group(function () {
    Route::resource('discussions', DiscussionController::class)->except(['edit', 'update', 'create']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SavedArticleController;

// Auth Form Routes (halaman tampilan)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']); // Proses submit form login
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']); // Jika ingin pakai form register di web
Route::middleware('auth')->get('/home', function () {
    return view('home');
});

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

// Page Routes
Route::get('/', function () {
    return redirect()->route('home.index');
});

// Route /home tanpa middleware
Route::get('/home', [PageController::class, 'index'])->name('home.index');
Route::get('/home/{category}', [PageController::class, 'category'])->name('home.category');

Route::get('/saved-articles', function () {
    return view('saved-articles.index');
});

Route::get('/saved-articles/view', function () {
    return view('saved-articles.view');
});

Route::get('/discussions/{token}', function ($token) {
    return view('discussions.show', ['token' => $token]);
});

// Route lainnya dibungkus middleware
//Route::middleware(['auth'])->group(function () {
    //Route::get('/user/{username}', [PageController::class, 'userProfile'])->name('user.profile');
    //Route::get('/discussion', [PageController::class, 'discussion'])->name('discussion');

    // ✅ Saved Articles
    //Route::get('/saved-articles', [SavedArticleController::class, 'index']);     // List saved articles
    //Route::post('saved-articles', [SavedArticleController::class, 'store']);    // Save new article
    //Route::delete('saved-articles/{id}', [SavedArticleController::class, 'destroy']); // Delete saved article
//});

Route::middleware('auth:api')->get('/me', function (Request $request) {
    return response()->json($request->user());
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;

// Auth Form Routes (halaman tampilan)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

// Page Routes
Route::get('/', function () {
    return redirect()->route('home.index');
});

// Route /home tanpa middleware
Route::get('/home', [PageController::class, 'index'])->name('home.index');
Route::get('/home/{category}', [PageController::class, 'category'])->name('home.category');

// Route lainnya dibungkus middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/user/{username}', [PageController::class, 'userProfile'])->name('user.profile');
    Route::get('/discussion', [PageController::class, 'discussion'])->name('discussion');
});

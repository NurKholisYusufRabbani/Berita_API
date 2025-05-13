<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Auth Form Routes (halaman tampilan)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

// Page Routes
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/home/{category}', [HomeController::class, 'category'])->name('home.category');
Route::get('/user/{username}', [HomeController::class, 'userProfile'])->name('user.profile');
Route::get('/discussion', [HomeController::class, 'discussion'])->name('discussion');

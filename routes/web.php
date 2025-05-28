<?php

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AdminDiscussionController;
use App\Http\Controllers\AdminSavedArticleController;

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

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

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

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('saved-articles/user/{id}', [AdminSavedArticleController::class, 'userArticles'])->name('admin.saved_articles.user');
    Route::get('saved-articles', [AdminSavedArticleController::class, 'index'])->name('admin.saved_articles.index');
    Route::get('saved-articles/{id}', [AdminSavedArticleController::class, 'show'])->name('admin.saved_articles.show');
    Route::delete('saved-articles/{id}', [AdminSavedArticleController::class, 'destroy'])->name('admin.saved_articles.destroy');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/discussions', [AdminDiscussionController::class, 'index'])->name('admin.discussions.index');
    Route::get('/discussions/{id}', [AdminDiscussionController::class, 'show'])->name('admin.discussions.show');

    Route::delete('/comments/{id}', [AdminDiscussionController::class, 'deleteComment'])->name('admin.comments.delete');
    Route::delete('/replies/{id}', [AdminDiscussionController::class, 'deleteReply'])->name('admin.replies.delete');
});

Route::get('/settings', function () {
    return view('settings.index');
});

Route::get('/profile', function () {
    return view('auth.profile');
});

// Rute untuk menampilkan form permintaan reset password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest') // Hanya bisa diakses oleh tamu (belum login)
    ->name('password.request');

// Rute untuk mengirim link reset password
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Rute untuk menampilkan form permintaan reset password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');

// Rute untuk mengirim link reset password
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');

// Rute untuk menampilkan form reset password (setelah user klik link di email)
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset'); // Nama route ini akan digunakan di link dalam email

// Rute untuk memproses reset password
Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

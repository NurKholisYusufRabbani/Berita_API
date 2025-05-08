<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', [App\Http\Controllers\NewsController::class, 'index']);

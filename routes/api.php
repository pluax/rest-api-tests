<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


Route::apiResource('posts', PostController::class);
Route::post('{post}/review', [PostController::class, 'review'])
    ->name('posts.review');

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login')->name('login');
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::apiResource('posts', PostController::class);
Route::post('{post}/review', [PostController::class, 'review'])
    ->name('posts.review');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

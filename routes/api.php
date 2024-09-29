<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::controller(PostController::class)
    ->prefix('posts')
    ->group(function () {
        Route::get('', 'list')->name('posts.list');
        Route::get('{post}', 'show')->name('posts.show');

    });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

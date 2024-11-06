<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('posts',PostController::class);

Route::controller(AuthController::class)->group(function () {
    Route::name("auth.")->group(function () {
        Route::post('/register','register')->name('register');
        Route::post('/login','login')->name('login');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout','logout')->name('logout');
            Route::post('/refresh_token','refreshToken')->name('refresh');
        });
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(CommentController::class)->group(function () {
        Route::name('comment.')->group(function () {
            Route::post('/comment/{post}','store')->name("addComment");
            Route::get('/comment/{post}','index')->name('comments');
            Route::post('/comment/{comment}/reply','addReply')->name('addReply');
        });
    });
});

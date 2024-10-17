<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);

Route::view('/posts','welcome')->name("view.posts");
Route::middleware('auth:sanctum')->get('/my-posts', function ()  {
    return view('welcome');
})->name("view.posts");

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\AuthController;

Route::get('/', function () {
    return redirect()->route("dashboard");
});

Route::get('/posts', [PostController::class, 'index'])->name("dashboard");
Route::get('/my-posts', [PostController::class, 'myPosts'])->name("my-posts");

Route::get('/login', [AuthController::class, 'getLogin'])->name("login");
Route::post('/login', [AuthController::class, 'submitLogin'])->name("loginSubmit");
Route::get('/signUp', [AuthController::class, 'getSignUp'])->name("signup");
Route::post('/signUp', [AuthController::class, 'submitSignUp'])->name("loginSubmit");


// Route::view('/posts','welcome')->name("view.posts");
// Route::middleware('auth:sanctum')->get('/my-posts', function ()  {
//     return view('welcome');
// })->name("view.posts");

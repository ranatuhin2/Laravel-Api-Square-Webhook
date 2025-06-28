<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.lists');
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.list');
        Route::post('/create', [PostController::class, 'create'])->name('posts.create');
        Route::put('/update/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/delete/{post}', [PostController::class, 'delete'])->name('posts.delete');
    });

});

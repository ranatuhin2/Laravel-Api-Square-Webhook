<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);


Route::middleware('auth:api')->prefix('users')->group(function () {

    Route::get('/',[UserController::class, 'index'])->name('users.lists');

});
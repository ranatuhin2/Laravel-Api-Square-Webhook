<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('ngrok-test', function () {
    echo 'Ngrok is Working Properly!';
});

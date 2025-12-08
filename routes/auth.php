<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'login');
    Route::get('/forgot', 'forgot')->name('forgot');
    Route::post('/forgot', 'postForgot');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'postLogin');
    Route::get('/register', 'register');
    Route::post('/register', 'postRegister');
    Route::get('/reset-password', 'resetPassword');
    Route::post('/reset-password', 'postResetPassword');
});
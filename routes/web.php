<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');
Route::get('/setting', function () {
    return view('setting');
});
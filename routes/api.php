<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 認証系エンドポイントは web ミドルウェアを付与して
| セッション・CSRF 検証を有効化する
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
});

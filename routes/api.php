<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoliloquyController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| セッション認証 + CSRF を使うため、いずれのルートにも web ミドルウェアを付与する。
|--------------------------------------------------------------------------
*/

// 認証不要（ログイン・新規登録）
Route::middleware('web')->group(function () {
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
});

// 認証必須（ログインユーザー自身のタスクのみ操作可能）
Route::middleware(['web', 'auth'])->group(function () {
    Route::apiResource('tasks', TaskController::class);

    // ひとりごと（つぶやき）投稿
    Route::post('soliloquies', [SoliloquyController::class, 'store']);
});

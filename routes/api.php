<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SoliloquyController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 認証不要（ログイン・新規登録）
Route::middleware('web')->group(function () {
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
});

// 認証必須
Route::middleware(['web', 'auth'])->group(function () {
    Route::apiResource('tasks', TaskController::class);

    // ひとりごと（つぶやき）投稿
    Route::post('soliloquies', [SoliloquyController::class, 'store']);

    // ショップ：アイテム一覧 / 購入
    Route::get('items',              [ItemController::class, 'index']);
    Route::post('items/{item}/buy',  [ItemController::class, 'buy']);

    // 着せ替え：所持アイテム一覧 / 装備切替
    Route::get('user/items',                       [UserItemController::class, 'index']);
    Route::put('user/items/{ownedItem}/equip',     [UserItemController::class, 'equip']);

    // ユーザー情報取得
    Route::get('user', [UserController::class, 'show']);

    // ユーザー設定：モード更新
    Route::put('user/mode', [AuthController::class, 'updateMode']);
});
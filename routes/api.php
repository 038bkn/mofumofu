<?php
namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SoliloquyController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    // ★★★【追加・修正】ここを既存の認証必須グループの中に引っ越しました ★★★
    Route::get('/user', [UserController::class, 'show']);
});


// ============================================================
// UserController クラス（api.phpの中に一時的に同居させる場合）
// ============================================================

// ※ Route::middleware('auth:sanctum') の記述はエラーを招くため削除しました。

class UserController extends Controller
{
    /**
     * ログイン中ユーザーの情報（ポイント含む）を返す
     * GET /api/user
     */
    public function show(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ログインしていない場合の安全策
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'name'   => $user->name,
            'points' => $user->points,
        ]);
    }
}
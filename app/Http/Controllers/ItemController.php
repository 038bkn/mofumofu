<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * ショップの全アイテム一覧
     * GET /api/items
     */
    public function index(): JsonResponse
    {
        $items = Item::orderBy('category')->orderBy('id')->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'アイテム一覧を取得しました。',
            'data'    => $items,
        ]);
    }

    /**
     * アイテム購入
     * POST /api/items/{item}/buy
     */
    public function buy(Item $item): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 重複購入チェック
        if ($user->ownedItems()->where('item_id', $item->id)->exists()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'このアイテムはすでに所持しています。',
            ], 422);
        }

        // ポイント不足チェック
        if ($user->points < $item->price) {
            return response()->json([
                'status'  => 'error',
                'message' => 'ポイントが足りません。',
            ], 422);
        }

        $ownedItem = DB::transaction(function () use ($user, $item) {
            $user->decrement('points', $item->price);

            return $user->ownedItems()->create([
                'item_id'     => $item->id,
                'is_equipped' => false,
            ]);
        });

        // 紐づくアイテム情報を付与してから返却
        $ownedItem->load('item');
        $user->refresh();

        return response()->json([
            'status'  => 'success',
            'message' => 'アイテムを購入しました。',
            'data'    => [
                'owned_item'   => $ownedItem,
                'total_points' => $user->points,
            ],
        ], 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\OwnedItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserItemController extends Controller
{
    /**
     * ログインユーザーの所持アイテム一覧（アイテム情報付き）
     * GET /api/user/items
     */
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ownedItems = $user->ownedItems()
            ->with('item')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => '所持アイテム一覧を取得しました。',
            'data'    => $ownedItems,
        ]);
    }

    /**
     * 着脱処理（同カテゴリ内排他制御つき）
     * PUT /api/user/items/{ownedItem}/equip
     *
     * リクエスト Body: { "is_equipped": true | false }
     */
    public function equip(Request $request, OwnedItem $ownedItem): JsonResponse
    {
        // 所有権チェック（他人のレコードへの操作禁止）
        if ($ownedItem->user_id !== Auth::id()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'この所持アイテムを操作する権限がありません。',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'is_equipped' => ['required', 'boolean'],
        ], [
            'is_equipped.required' => '装備状態（is_equipped）を指定してください。',
            'is_equipped.boolean'  => '装備状態は true / false で指定してください。',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $isEquipped = $request->boolean('is_equipped');

        DB::transaction(function () use ($ownedItem, $isEquipped) {
            if ($isEquipped) {
                // 同じカテゴリで装備中の他アイテムを外す（排他制御）
                $category = $ownedItem->item->category;

                OwnedItem::where('user_id', $ownedItem->user_id)
                    ->where('id', '!=', $ownedItem->id)
                    ->where('is_equipped', true)
                    ->whereHas('item', fn ($q) => $q->where('category', $category))
                    ->update(['is_equipped' => false]);
            }

            $ownedItem->update(['is_equipped' => $isEquipped]);
        });

        $ownedItem->refresh()->load('item');

        return response()->json([
            'status'  => 'success',
            'message' => $isEquipped ? '装備しました。' : '装備を外しました。',
            'data'    => $ownedItem,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Soliloquy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SoliloquyController extends Controller
{
    /** ボーナス付与の間隔（n件ごと） */
    private const BONUS_INTERVAL = 10;

    /** ボーナスポイント量 */
    private const BONUS_POINTS = 50;

    /**
     * ひとりごと投稿
     * POST /api/soliloquies
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:1000'],
            'type'    => ['required', 'integer', 'in:0,1,2'],
        ], [
            'content.required' => 'つぶやき内容を入力してください。',
            'content.string'   => 'つぶやき内容は文字列で入力してください。',
            'content.max'      => 'つぶやきは1000文字以内で入力してください。',
            'type.required'    => '種別を指定してください。',
            'type.integer'     => '種別は数値で指定してください。',
            'type.in'          => '種別は 0（通常）/ 1（ほめて）/ 2（なぐさめて）のいずれかを指定してください。',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $soliloquy    = null;
        $earnedPoints = 0;

        DB::transaction(function () use ($user, $request, &$soliloquy, &$earnedPoints) {
            // 1) つぶやきを保存
            $soliloquy = $user->soliloquies()->create([
                'content' => $request->input('content'),
                'type'    => (int) $request->input('type'),
            ]);

            // 2) 保存後の総件数で 10 の倍数チェック → ボーナス付与
            $count = $user->soliloquies()->count();
            if ($count > 0 && $count % self::BONUS_INTERVAL === 0) {
                $earnedPoints = self::BONUS_POINTS;
                $user->increment('points', $earnedPoints);
            }
        });

        return response()->json([
            'status'        => 'success',
            'soliloquy'     => $soliloquy,
            'reply_message' => $this->replyMessageFor((int) $request->input('type')),
            'earned_points' => $earnedPoints,
            'total_points'  => $user->points,
        ], 201);
    }

    /**
     * type に応じた返信メッセージを生成
     *  - 0: 通常 → null
     *  - 1: ほめて → ランダムなほめ言葉
     *  - 2: なぐさめて → ランダムななぐさめ言葉
     */
    private function replyMessageFor(int $type): ?string
    {
        $candidates = match ($type) {
            1 => [
                'よく頑張ったね！',
                'あなたは本当にすごいよ！',
                '今日も一日お疲れさま、よくやったね。',
                'えらい！その調子！',
                'いつも頑張ってて偉いね。',
            ],
            2 => [
                '無理しないでね。',
                '今日はゆっくり休もう？',
                'つらかったね、よく耐えたよ。',
                '頑張りすぎなくていいんだよ。',
                'そばにいるよ、大丈夫。',
            ],
            default => null,
        };

        if (! $candidates) {
            return null;
        }

        return $candidates[array_rand($candidates)];
    }
}

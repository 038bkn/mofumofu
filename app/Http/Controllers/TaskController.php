<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * 一覧取得
     * GET /api/tasks
     * クエリ: ?date=YYYY-MM-DD / ?month=YYYY-MM
     */
    public function index(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user  = Auth::user();
        $query = $user->tasks();

        if ($request->filled('date')) {
            $query->whereDate('due_date', $request->query('date'));
        } elseif ($request->filled('month')) {
            // YYYY-MM の月で絞り込み
            $query->where('due_date', 'like', $request->query('month') . '%');
        }

        $tasks = $query->orderBy('due_date')->orderBy('id')->get();

        return $this->success($tasks);
    }

    /**
     * 1件取得
     * GET /api/tasks/{task}
     */
    public function show(Task $task): JsonResponse
    {
        if ($denied = $this->denyIfNotOwner($task)) {
            return $denied;
        }

        return $this->success($task);
    }

    /**
     * 新規作成
     * POST /api/tasks
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'      => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'integer', 'between:1,5'],
            'due_date'   => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time'   => ['nullable', 'date_format:H:i', 'after:start_time'],
            'note'       => ['nullable', 'string'],
            'location'   => ['nullable', 'string', 'max:255'],
        ], $this->validationMessages());

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $task = $user->tasks()->create($validator->validated());

        return $this->success($task, 201);
    }

    /**
     * 更新（完了処理込み）
     * PUT/PATCH /api/tasks/{task}
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        if ($denied = $this->denyIfNotOwner($task)) {
            return $denied;
        }

        $validator = Validator::make($request->all(), [
            'title'      => ['sometimes', 'required', 'string', 'max:255'],
            'difficulty' => ['sometimes', 'required', 'integer', 'between:1,5'],
            'due_date'   => ['sometimes', 'nullable', 'date'],
            'start_time' => ['sometimes', 'nullable', 'date_format:H:i'],
            'end_time'   => ['sometimes', 'nullable', 'date_format:H:i', 'after:start_time'],
            'location'   => ['sometimes', 'nullable', 'string', 'max:255'],
            'note'       => ['sometimes', 'nullable', 'string'],
            'status'     => ['sometimes', 'required', 'integer', 'in:0,1'],
        ], $this->validationMessages());

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $validated = $validator->validated();

        // この更新で「未完了 → 完了」に遷移するかを判定（既に完了済みなら二重付与しない）
        $isCompleting = isset($validated['status'])
            && (int) $validated['status'] === 1
            && (int) $task->status === 0;

        $earnedPoints = 0;
        $totalPoints  = null;

        DB::transaction(function () use ($task, &$validated, $isCompleting, &$earnedPoints, &$totalPoints) {
            if ($isCompleting) {
                $validated['completed_at'] = now();
            }

            $task->update($validated);

            if ($isCompleting) {
               
                $earnedPoints = $task->difficulty * 5;

                $user = $task->user;
                $user->increment('points', $earnedPoints);
                $totalPoints = $user->points;
            }
        });

        $task->refresh();

        if ($isCompleting) {
            return response()->json([
                'status'        => 'success',
                'data'          => $task,
                'earned_points' => $earnedPoints,
                'total_points'  => $totalPoints,
            ]);
        }

        return $this->success($task);
    }

    /**
     * 削除
     * DELETE /api/tasks/{task}
     */
    public function destroy(Task $task): JsonResponse
    {
        if ($denied = $this->denyIfNotOwner($task)) {
            return $denied;
        }

        $task->delete();

        return $this->success(null);
    }

    /* =====================================================
     |  helpers
     |===================================================== */

    /**
     * ログインユーザー以外のタスクなら 403 を返す
     */
    private function denyIfNotOwner(Task $task): ?JsonResponse
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'このタスクを操作する権限がありません。',
            ], 403);
        }

        return null;
    }

    /**
     * 成功レスポンスの共通フォーマット
     */
    private function success(mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ], $statusCode);
    }

    /**
     * バリデーションエラーを統一フォーマットで返す
     */
    private function validationError(ValidatorContract $validator): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $validator->errors()->first(),
        ], 422);
    }

    /**
     * バリデーション用の日本語メッセージ
     */
    private function validationMessages(): array
    {
        return [
            'title.required'      => 'タイトルを入力してください。',
            'title.string'        => 'タイトルは文字列で入力してください。',
            'title.max'           => 'タイトルは255文字以内で入力してください。',
            'difficulty.required' => '難易度を選択してください。',
            'difficulty.integer'  => '難易度は数値で指定してください。',
            'difficulty.between'  => '難易度は1〜5の範囲で指定してください。',
            'due_date.date'       => '期限日は正しい日付形式で入力してください。',
            'status.integer'      => 'ステータスは数値で指定してください。',
            'status.in'           => 'ステータスは 0（未完了）または 1（完了）を指定してください。',
        ];
    }
}

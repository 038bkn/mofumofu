<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Session;

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/calendar', function () {
    return view('calendar_screen');
});

Route::get('/day-schedule', function (Request $request) {
    $date = $request->query('date', date('Y-m-d'));
    return view('day_schedule', compact('date'));
});

Route::get('/task/create', function (Request $request) {
    $date = $request->query('date', date('Y-m-d'));
    return view('task_create', compact('date'));
})->name('task.create');

Route::get('/task/detail', function (Request $request) {
    $date = $request->query('date', date('Y-m-d'));
    return view('task_detail', compact('date'));
});

// --- API Routes ---

// 1. タスクを保存する
Route::post('/api/tasks', function (Request $request) {
    $tasks = Session::get('tasks', []);

    $newTask = [
        'id'         => time() . rand(100, 999), // よりユニークなID
        'title'      => $request->input('title'),
        'difficulty' => $request->input('difficulty'),
        'due_date'   => $request->input('due_date'),
        'start_time' => $request->input('start_time'),
        'end_time'   => $request->input('end_time'),
        'note'       => $request->input('note'),
        'completed'  => false, // 完了フラグ（初期値はfalse）
    ];

    $tasks[] = $newTask;
    Session::put('tasks', $tasks);

    return response()->json([
        'status'  => 'success',
        'message' => '保存しました',
        'task'    => $newTask
    ]);
});

// 2. タスクを取得する（日付指定 or 年月指定）
Route::get('/api/tasks', function (Request $request) {
    $date  = $request->query('date');   // 例: 2026-04-15
    $month = $request->query('month');  // 例: 2026-04（月別取得用）

    $allTasks = Session::get('tasks', []);

    if ($date) {
        // 日付が指定された場合：その日のタスクを返す
        $filtered = array_filter($allTasks, fn($task) =>
            isset($task['due_date']) && $task['due_date'] === $date
        );
    } elseif ($month) {
        // 年月が指定された場合：その月のタスクを全て返す（例: "2026-04"）
        $filtered = array_filter($allTasks, fn($task) =>
            isset($task['due_date']) && str_starts_with($task['due_date'], $month)
        );
    } else {
        $filtered = $allTasks;
    }

    return response()->json([
        'status' => 'success',
        'tasks'  => array_values($filtered)
    ]);
});

// 3. タスクを削除する
Route::delete('/api/tasks/{id}', function ($id) {
    $allTasks = Session::get('tasks', []);

    $filtered = array_filter($allTasks, fn($task) =>
        (string)$task['id'] !== (string)$id
    );

    Session::put('tasks', array_values($filtered));

    return response()->json(['status' => 'success']);
});

// 4. タスクの完了状態を更新する（PATCH /api/tasks/{id}/complete）
Route::patch('/api/tasks/{id}/complete', function (Request $request, $id) {
    $allTasks = Session::get('tasks', []);

    $updated = array_map(function ($task) use ($id, $request) {
        if ((string)$task['id'] === (string)$id) {
            $task['completed'] = $request->input('completed', true);
        }
        return $task;
    }, $allTasks);

    Session::put('tasks', $updated);

    return response()->json(['status' => 'success']);
});
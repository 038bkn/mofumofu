<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
// Sessionを使うために追加
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

// --- APIルートの修正 ---

// 1. 予定を保存する（Sessionに格納する）
Route::post('/api/tasks', function (Request $request) {
    $tasks = Session::get('tasks', []);
    
    // 送られてきたデータを整理
    $newTask = [
        'id'         => time(), // IDの代わり
        'title'      => $request->input('title'),
        'difficulty' => $request->input('difficulty'),
        'due_date'   => $request->input('due_date'),
        'start_time' => $request->input('start_time'),
        'end_time'   => $request->input('end_time'),
        'note'       => $request->input('note'),
    ];

    $tasks[] = $newTask;
    Session::put('tasks', $tasks);

    return response()->json([
        'status'  => 'success',
        'message' => '保存しました',
        'task'    => $newTask
    ]);
});

// 2. 予定を取得する（Sessionから該当する日付のものを出す）
Route::get('/api/tasks', function (Request $request) {
    $date = $request->query('date');
    $allTasks = Session::get('tasks', []);

    // その日の日付に一致する予定だけを抽出
    $filteredTasks = array_filter($allTasks, function($task) use ($date) {
        return isset($task['due_date']) && $task['due_date'] === $date;
    });

    return response()->json([
        'status' => 'success',
        'tasks'  => array_values($filteredTasks)
    ]);
});

// 3. 予定を削除する（Sessionから取り除く）
Route::delete('/api/tasks/{id}', function ($id) {
    $allTasks = Session::get('tasks', []);
    
    $filteredTasks = array_filter($allTasks, function($task) use ($id) {
        return (string)$task['id'] !== (string)$id;
    });
    
    Session::put('tasks', array_values($filteredTasks));

    return response()->json([
        'status' => 'success'
    ]);
});
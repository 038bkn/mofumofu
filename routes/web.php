<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ==========================================
// ログイン・認証系画面
// ==========================================
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.Register'); 
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


Route::get('/home', function () {
    return view('home');
})->name('home');

// ==========================================
// メイン機能画面
// ==========================================
Route::get('/calendar', function () {
    return view('Calendar_screen');
});

// ※ダミーデータとして日付（date）を受け取る処理
// 画面の動作確認用
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

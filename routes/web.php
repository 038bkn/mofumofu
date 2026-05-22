<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Middleware\NoCache;

// ==========================================
// ログイン・認証系画面（キャッシュを許可する）
// ==========================================
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('password.request');


// ==========================================
// 認証が必須のルート（キャッシュを「絶対に」禁止する）
// ==========================================
// middleware('auth')に加えて、戻るボタン対策のヘッダーを強制付与します
Route::middleware(['auth', NoCache::class])->group(function () {

    Route::get('/home', function () {
        $points = auth()->user()?->points ?? 0;
        return view('home', compact('points'));
    })->name('home');
    
    Route::get('/home', function () {
        $points = auth()->user()?->points ?? 0;
        return view('home', compact('points'));
    })->name('home');

    Route::get('/setting', function () {
        return view('setting');
    })->name('setting');

    Route::get('/user', function () {
        return view('user');
    })->name('user');

    Route::get('/pass', function () {
        return view('pass');
    });

    Route::post('/pass/update', function () {
        return redirect('/user');
    });

    // ==========================================
    // メイン機能画面
    // ==========================================
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

    Route::get('/chat', function () {
        return view('chatscreen');
    })->name('chat');

    Route::get('/homete', function () {
        return view('homete_screen');
    });

    Route::get('/nagusame', function () {
        return view('nagusame_screen');
    });

    Route::get('/hitorigoto', function () {
        return view('homete_screen');
    });

    Route::get('/todo', function () {
        return view('home');
    });

    // ==========================================
    // コレクション・ショップ系画面
    // ==========================================
    Route::get('/collection', function () {
        return view('collection');
    });

    Route::get('/shop', function () {
        $ownedItemIds = Auth::user()->ownedItems()->pluck('item_id')->toArray();
        return view('shop', ['ownedItemIds' => $ownedItemIds]);
    });

    // ログアウト処理
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

});
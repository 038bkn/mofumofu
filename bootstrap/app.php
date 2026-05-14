<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 未ログインで保護ルートにアクセスした場合
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'ログインが必要です。',
                ], 401);
            }
            return redirect('/login');
        });

        // 存在しないモデルに対する操作（route model binding の 404）
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->expectsJson()) {
                $labels = [
                    'Task'      => 'タスク',
                    'Item'      => 'アイテム',
                    'OwnedItem' => '所持アイテム',
                    'Soliloquy' => 'つぶやき',
                ];
                $label = $labels[class_basename($e->getModel())] ?? 'データ';

                return response()->json([
                    'status'  => 'error',
                    'message' => $label . 'が見つかりません。',
                ], 404);
            }
        });
    })->create();

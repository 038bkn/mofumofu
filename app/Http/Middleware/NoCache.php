<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCache
{
    /**
     * ハンドルメソッド
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ブラウザに対して、この画面のあらゆるキャッシュ（bfcache含む）を完全に禁止する命令
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Wed, 11 Jan 1984 05:00:00 GMT'); // 過去の絶対的な日時

        return $response;
    }
}
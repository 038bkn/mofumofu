<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログイン処理
     * POST /api/login
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['status' => 'success']);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'メールアドレスまたはパスワードが正しくありません。',
        ], 401);
    }

    /**
     * ログアウト処理
     * POST /api/logout
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['status' => 'success']);
    }

    /**
     * 新規登録処理
     * POST /api/register
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password, // User モデル側で hashed キャストされる
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['status' => 'success']);
    }

    /**
     * ユーザー情報取得
     * GET /api/user
     */
    public function show(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'points' => $user->points,
        ]);
    }

    /**
     * モード更新処理
     * PUT /api/user/mode
     */
    public function updateMode(Request $request): JsonResponse
    {
        $request->validate([
            'mode' => ['required', 'in:sweet,spicy'],
        ]);

        $modeValue = $request->mode === 'sweet' ? 0 : 1;

        auth()->user()->update([
            'mode' => $modeValue,
        ]);

        return response()->json(['status' => 'success']);
    }
}

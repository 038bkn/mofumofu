<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * ログイン処理
     * POST /api/login
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginValue = $request->input('email');
        $field      = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (Auth::attempt([$field => $loginValue, 'password' => $request->password])) {
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
     * メールアドレス・パスワード更新処理
     * PUT /api/user/credentials
     */
    public function updateCredentials(Request $request): JsonResponse
    {
        $user = Auth::user();

        $request->validate([
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique'    => 'このメールアドレスはすでに登録されています。',
            'email.required'  => 'メールアドレスを入力してください。',
            'email.email'     => '有効なメールアドレスを入力してください。',
            'password.min'    => 'パスワードは6文字以上で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
        ]);

        $data = ['email' => $request->email];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return response()->json(['status' => 'success']);
    }

    /**
     * ユーザー名更新処理
     * PUT /api/user/name
     */
    public function updateName(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20'],
        ], [
            'name.required' => 'ユーザー名を入力してください。',
            'name.max'      => 'ユーザー名は20文字以内で入力してください。',
        ]);

        auth()->user()->update(['name' => $request->name]);

        return response()->json(['status' => 'success', 'name' => $request->name]);
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

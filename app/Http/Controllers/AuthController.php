<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 
class AuthController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function showLogin()
    {
        // すでにログイン済みならホームへ
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }
 
    /**
     * ログイン処理 POST /api/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
 
        $credentials = $request->only('email', 'password');
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            $user = Auth::user();
 
            return response()->json([
                'status' => 'success',
                'user'   => [
                    'id'        => $user->id,
                    'name'      => $user->name,
                    'points'    => $user->points,
                    'mode'      => $user->mode,
                    'icon_path' => $user->icon_path,
                ],
            ], 200);
        }
 
        return response()->json([
            'status'  => 'error',
            'message' => 'メールアドレスまたはパスワードが正しくありません。',
        ], 401);
    }
 
    /**
     * 新規登録画面表示
     */
    public function showRegister()
    {
        return view('auth.register');
    }
 
    /**
     * 新規登録処理 POST /api/register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'name.required'     => '名前とメールアドレスは必須です。',
            'email.required'    => '名前とメールアドレスは必須です。',
            'email.unique'      => 'このメールアドレスはすでに登録されています。',
            'password.min'      => 'パスワードは8文字以上で入力してください。',
        ]);
 
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
 
        // 登録後に自動ログイン
        Auth::login($user);
        $request->session()->regenerate();
 
        return response()->json([
            'status'  => 'success',
            'message' => '登録が完了しました',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }
 
    /**
     * ログアウト処理 POST /api/logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return response()->json([
            'status'  => 'success',
            'message' => 'ログアウトしました',
        ], 200);
    }
}
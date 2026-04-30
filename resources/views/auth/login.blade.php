<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - ログイン</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
 
        body {
            font-family: 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Noto Sans JP', sans-serif;
            background-color: #fde8e8;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
 
        .phone-wrapper {
            width: 100%;
            max-width: 390px;
            min-height: 100vh;
            background-color: #fde8e8;
            display: flex;
            flex-direction: column;
            padding: 0 32px;
        }
 
        /* ヘッダーラベル */
        .screen-label {
            font-size: 11px;
            color: #aaa;
            padding: 12px 0 0;
        }
 
        /* タイトル */
        .title-area {
            margin-top: 72px;
            margin-bottom: 52px;
            text-align: center;
        }
 
        .app-title {
            font-size: 42px;
            font-weight: 400;
            color: #3a3a3a;
            letter-spacing: 0.05em;
        }
 
        /* フォームエリア */
        .form-area {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
 
        .field-label {
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
            margin-top: 20px;
        }
 
        .field-label:first-child {
            margin-top: 0;
        }
 
        .input-field {
            width: 100%;
            height: 44px;
            background: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 14px;
            font-size: 15px;
            color: #333;
            outline: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            transition: box-shadow 0.2s;
        }
 
        .input-field:focus {
            box-shadow: 0 0 0 2px #f4a0a0;
        }
 
        /* パスワード忘れリンク */
        .forgot-link {
            text-align: right;
            margin-top: 10px;
        }
 
        .forgot-link a {
            font-size: 12px;
            color: #6a9fd8;
            text-decoration: none;
        }
 
        /* エラーメッセージ */
        .error-message {
            background: #fff0f0;
            border: 1px solid #f4a0a0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #c0392b;
            margin-top: 16px;
            display: none;
        }
 
        .error-message.show {
            display: block;
        }
 
        /* ログインボタン */
        .btn-login {
            margin-top: 36px;
            width: 100%;
            height: 48px;
            background: #fff;
            border: none;
            border-radius: 24px;
            font-size: 16px;
            color: #3a3a3a;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.15s, box-shadow 0.15s;
            position: relative;
        }
 
        .btn-login:active {
            transform: scale(0.97);
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
 
        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
 
        /* ローディングスピナー */
        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid #ddd;
            border-top-color: #f4a0a0;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
        }
 
        .btn-login.loading .spinner {
            display: block;
        }
 
        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }
 
        /* 新規登録リンク */
        .register-link {
            text-align: center;
            margin-top: 32px;
        }
 
        .register-link a {
            font-size: 13px;
            color: #6a9fd8;
            text-decoration: none;
        }
 
        /* フェードインアニメーション */
        .fade-in {
            opacity: 0;
            transform: translateY(12px);
            animation: fadeIn 0.5s ease forwards;
        }
 
        .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.3s; }
 
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="phone-wrapper">
        <div class="screen-label">ログイン画面</div>
 
        <div class="title-area fade-in">
            <h1 class="app-title">もふすけ</h1>
        </div>
 
        <div class="form-area fade-in">
            <div class="field-label">メールアドレス・ユーザー名</div>
            <input
                type="email"
                id="email"
                class="input-field"
                placeholder=""
                autocomplete="email"
                inputmode="email"
            >
 
            <div class="field-label">パスワード</div>
            <input
                type="password"
                id="password"
                class="input-field"
                placeholder=""
                autocomplete="current-password"
            >
 
            <div class="forgot-link">
                <a href="{{ route('password.request') }}">パスワード忘れたはこちらから</a>
            </div>
 
            <div class="error-message" id="errorMsg"></div>
 
            <button class="btn-login" id="loginBtn" onclick="handleLogin()">
                ログイン
                <div class="spinner"></div>
            </button>
        </div>
 
        <div class="register-link fade-in">
            <a href="{{ route('register') }}">新規登録はこちらから</a>
        </div>
    </div>
 
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
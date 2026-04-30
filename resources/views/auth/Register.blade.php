<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - 新規登録</title>
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

        .screen-label {
            font-size: 11px;
            color: #aaa;
            padding: 12px 0 0;
        }

        /* タイトルボタン風 */
        .title-area {
            margin-top: 52px;
            margin-bottom: 40px;
            text-align: center;
        }

        .title-badge {
            display: inline-block;
            background: #fff;
            border-radius: 24px;
            padding: 10px 40px;
            font-size: 18px;
            color: #3a3a3a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* フォームエリア */
        .form-area {
            display: flex;
            flex-direction: column;
        }

        .field-label {
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
            margin-top: 20px;
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
            line-height: 1.6;
        }

        .error-message.show {
            display: block;
        }

        /* 登録ボタン */
        .btn-register {
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

        .btn-register:active {
            transform: scale(0.97);
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .btn-register:disabled {
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

        .btn-register.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        /* ログインリンク */
        .login-link {
            text-align: center;
            margin-top: 24px;
            margin-bottom: 32px;
        }

        .login-link a {
            font-size: 13px;
            color: #6a9fd8;
            text-decoration: none;
        }

        /* フェードイン */
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
        <div class="screen-label">新規登録画面</div>

        <div class="title-area fade-in">
            <span class="title-badge">新規登録</span>
        </div>

        <div class="form-area fade-in">
            <div class="field-label">ユーザ名</div>
            <input
                type="text"
                id="name"
                class="input-field"
                autocomplete="username"
            >

            <div class="field-label">メールアドレス</div>
            <input
                type="email"
                id="email"
                class="input-field"
                autocomplete="email"
                inputmode="email"
            >

            <div class="field-label">パスワード</div>
            <input
                type="password"
                id="password"
                class="input-field"
                autocomplete="new-password"
            >

            <div class="error-message" id="errorMsg"></div>

            <button class="btn-register" id="registerBtn">
                登録
                <div class="spinner"></div>
            </button>
        </div>

        <div class="login-link fade-in">
            <a href="{{ route('login') }}">ログインはこちらから</a>
        </div>
    </div>

    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
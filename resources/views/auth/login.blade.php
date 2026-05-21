<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - ログイン</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        mofupink: '#fde8e8',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-1 { animation: fadeIn 0.5s ease 0.1s forwards; opacity: 0; }
        .fade-in-2 { animation: fadeIn 0.5s ease 0.2s forwards; opacity: 0; }
        .fade-in-3 { animation: fadeIn 0.5s ease 0.3s forwards; opacity: 0; }
        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid #ddd;
            border-top-color: #f4a0a0;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            position: absolute; right: 16px; top: 50%;
            transform: translateY(-50%);
        }
        .loading .spinner { display: block; }
    </style>
</head>
<body class="bg-[#fde8e8] min-h-screen flex justify-center items-start">
    <div class="w-full max-w-[390px] min-h-screen bg-[#fde8e8] flex flex-col px-8">

        <!-- タイトル -->
        <div class="mt-[72px] mb-[52px] text-center fade-in-1">
            <h1 class="text-[42px] font-normal text-[#3a3a3a] tracking-wide">もふすけ</h1>
        </div>

        <!-- フォーム -->
        <div class="flex flex-col fade-in-2">
            <label class="text-[13px] text-[#555]">メールアドレス・ユーザー名</label>
            <input
                type="text"
                id="email"
                autocomplete="username"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            <label class="text-[13px] text-[#555] mt-5">パスワード</label>
            <input
                type="password"
                id="password"
                autocomplete="current-password"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            {{-- <div class="text-right mt-2.5">
                <a href="/forgot-password" class="text-[12px] text-[#6a9fd8] no-underline">パスワードを忘れた方はこちらから</a>
            </div> --}}

            <!-- エラーメッセージ -->
            <div id="errorMsg" class="hidden mt-4 bg-[#fff0f0] border border-[#f4a0a0] rounded-lg px-3.5 py-2.5 text-[13px] text-[#c0392b] leading-relaxed"></div>

            <!-- ログインボタン -->
            <button
                id="loginBtn"
                onClick="handleLogin()"
                class="relative mt-9 w-full h-12 bg-white border-none rounded-full text-[16px] text-[#3a3a3a] cursor-pointer shadow-md active:scale-95 transition-transform disabled:opacity-60"
            >
                ログイン
                <div class="spinner"></div>
            </button>
        </div>

        <!-- 新規登録リンク -->
        <div class="text-center mt-8 fade-in-3">
            <a href="/register" class="text-[13px] text-[#6a9fd8] no-underline">新規登録はこちらから</a>
        </div>

    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
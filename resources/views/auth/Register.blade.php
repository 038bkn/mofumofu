<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - 新規登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        <div class="mt-[52px] mb-10 text-center fade-in-1">
            <span class="inline-block bg-white rounded-full px-10 py-2.5 text-[18px] text-[#3a3a3a] shadow-md">
                新規登録
            </span>
        </div>

        <!-- フォーム -->
        <div class="flex flex-col fade-in-2">
            <label class="text-[13px] text-[#555]">ユーザ名</label>
            <input
                type="text"
                id="name"
                autocomplete="username"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            <label class="text-[13px] text-[#555] mt-5">メールアドレス</label>
            <input
                type="email"
                id="email"
                autocomplete="email"
                inputmode="email"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            <label class="text-[13px] text-[#555] mt-5">パスワード</label>
            <input
                type="password"
                id="password"
                autocomplete="new-password"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            <!-- エラーメッセージ -->
            <div id="errorMsg" class="hidden mt-4 bg-[#fff0f0] border border-[#f4a0a0] rounded-lg px-3.5 py-2.5 text-[13px] text-[#c0392b] leading-relaxed"></div>

            <!-- 登録ボタン -->
            <button
                id="registerBtn"
                class="relative mt-9 w-full h-12 bg-white border-none rounded-full text-[16px] text-[#3a3a3a] cursor-pointer shadow-md active:scale-95 transition-transform disabled:opacity-60"
            >
                登録
                <div class="spinner"></div>
            </button>
        </div>

        <!-- ログインリンク -->
        <div class="text-center mt-6 mb-8 fade-in-3">
            <a href="/login" class="text-[13px] text-[#6a9fd8] no-underline">ログインはこちらから</a>
        </div>

    </div>

    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
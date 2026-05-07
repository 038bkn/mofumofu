<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>もふすけ - パスワード再設定</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-1 { animation: fadeIn 0.5s ease 0.1s forwards; opacity: 0; }
        .fade-in-2 { animation: fadeIn 0.5s ease 0.2s forwards; opacity: 0; }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        .pop-in { animation: popIn 0.2s ease forwards; }

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

        <!-- タイトルバッジ -->
        <div class="mt-[52px] mb-10 text-center fade-in-1">
            <span class="inline-block bg-white rounded-full px-10 py-2.5 text-[18px] text-[#3a3a3a] shadow-md">
                再設定
            </span>
        </div>

        <!-- フォーム -->
        <div class="flex flex-col fade-in-2">
            <label class="text-[13px] text-[#555]">メールアドレス</label>
            <input
                type="email"
                id="email"
                autocomplete="email"
                inputmode="email"
                class="mt-1.5 w-full h-11 bg-white border-none rounded-lg px-3.5 text-[15px] text-[#333] outline-none shadow-sm focus:ring-2 focus:ring-[#f4a0a0]"
            >

            <!-- エラーメッセージ -->
            <div id="errorMsg" class="hidden mt-4 bg-[#fff0f0] border border-[#f4a0a0] rounded-lg px-3.5 py-2.5 text-[13px] text-[#c0392b] leading-relaxed"></div>

            <!-- 送信ボタン -->
            <button
                id="submitBtn"
                class="relative mt-9 w-full h-12 bg-white border-none rounded-full text-[16px] text-[#3a3a3a] cursor-pointer shadow-md active:scale-95 transition-transform disabled:opacity-60"
            >
                送信
                <div class="spinner"></div>
            </button>
        </div>

    </div>

    <!-- ポップアップ -->
    <div id="popup" class="hidden fixed inset-0 flex items-center justify-center px-8 z-50">
        <!-- 背景オーバーレイ -->
        <div class="absolute inset-0 bg-black/20" id="popupOverlay"></div>

        <!-- ポップアップ本体 -->
        <div class="relative bg-white rounded-2xl shadow-lg p-6 w-full max-w-[320px] pop-in">
            <!-- バツ印（右上） -->
            <button
                id="popupClose"
                class="absolute top-3 right-3 w-6 h-6 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
            </button>

            <!-- メッセージ -->
            <p class="text-[14px] text-[#3a3a3a] leading-relaxed mt-2">
                メールボックスに送信しました<br>確認お願いします
            </p>
        </div>
    </div>

    <script src="{{ asset('js/forgot_password.js') }}"></script>
</body>
</html>
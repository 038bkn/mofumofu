<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mofumofu Project</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --font-size-base: 16px; }
        body { font-size: var(--font-size-base); }
    </style>
</head>
<body class="bg-rose-50 text-slate-900 font-sans">

    <div class="min-h-screen flex flex-col items-center p-4">

        <div class="w-full max-w-sm">

            <!-- 戻る -->
            <div class="mt-5">
                <button
                    type="button"
                    onclick="history.back()"
                    class="w-11 h-11 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center text-lg shadow-sm">
                    ←
                </button>
            </div>

            <!-- タイトル -->
            <h1 class="text-center text-xl font-semibold text-slate-800 mt-8 mb-10">
                設定変更
            </h1>

            <!-- フォーム -->
            <div class="flex flex-col gap-6">

                <!-- メールアドレス -->
                <div>
                    <label for="emailInput" class="text-sm text-slate-500 mb-2 block">
                        メールアドレス
                    </label>
                    <input
                        type="email"
                        id="emailInput"
                        placeholder="example@email.com"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm outline-none focus:border-rose-300 transition">
                </div>

                <!-- 新しいパスワード -->
                <div>
                    <label for="newPassword" class="text-sm text-slate-500 mb-2 block">
                        パスワード
                    </label>
                    <input
                        type="password"
                        id="newPassword"
                        placeholder="••••••"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm outline-none focus:border-rose-300 transition">
                </div>

                <!-- 新しいパスワード（確認） -->
                <div>
                    <label for="confirmPassword" class="text-sm text-slate-500 mb-2 block">
                        パスワード（確認）
                    </label>
                    <input
                        type="password"
                        id="confirmPassword"
                        placeholder="••••••"
                        class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-white text-sm outline-none focus:border-rose-300 transition">
                </div>

                <!-- エラーメッセージ -->
                <p
                    id="errorMsg"
                    style="display:none;"
                    class="text-sm text-rose-500 text-center -mt-2">
                </p>

                <!-- 保存ボタン -->
                <div class="flex justify-center mt-4">
                    <button
                        type="button"
                        onclick="saveChanges()"
                        class="w-40 py-4 rounded-full bg-rose-300 text-white text-lg font-medium hover:bg-rose-400 transition tracking-wide">
                        保存
                    </button>
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/pass.js') }}"></script>
</body>
</html>

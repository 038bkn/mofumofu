<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>もふすけ - ユーザー画面</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- ブラウザバック対策：キャッシュを無効化 --}}
   <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --font-size-base: 16px; }
        body { font-size: var(--font-size-base); }

        .screen-label {
            font-size: 11px;
            color: #fde8e8;
            padding: 12px 0 0;
        }
    </style>
</head>
<body style="background:#FDE8E8;"
      class="text-slate-900 font-sans">
    <div class="screen-label">設定</div>
    <div class="min-h-screen flex flex-col items-center p-4">
        <div class="w-full max-w-sm">
            <!-- 戻る -->
            <div class="mt-5">
                <button
                    type="button"
                    onclick="location.href='/setting'"
                    class="w-11 h-11 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center text-lg shadow-sm">
                    ←
                </button>
            </div>

            <!-- タイトル -->
            <h1 class="text-center text-xl font-semibold text-slate-800 mt-8 mb-8">
                メインプロフィール
            </h1>

            <!-- アイコン
            <div class="flex justify-center mb-8">
                <div class="relative w-24 h-24">
                    <div class="w-24 h-24 rounded-full bg-slate-200 border-2 border-slate-300 overflow-hidden flex items-center justify-center" id="userIconWrapper">
                        <span class="text-xs text-slate-400 text-center leading-snug" id="iconPlaceholder">ユーザー<br>アイコン</span>
                        <img id="iconImage" src="" alt="ユーザーアイコン" class="w-full h-full object-cover rounded-full hidden">
                    </div>
                    <button
                        type="button"
                        onclick="document.getElementById('fileInput').click()"
                        aria-label="アイコン画像を変更"
                        class="absolute bottom-0 right-0 w-7 h-7 bg-slate-600 rounded-full flex items-center justify-center text-sm border-2 border-white">
                        📷
                    </button>
                </div>
                <input type="file" id="fileInput" accept="image/*" class="hidden" onchange="handleIconUpload(event)">
            </div> -->

            <!-- ユーザー名 -->
            <div class="mb-8">
                <p class="text-sm text-slate-500 mb-2">ユーザー名</p>
                <div class="flex justify-between items-center">
                    <span class="text-base font-medium text-slate-800" id="usernameDisplay">読み込み中…</span>
                    <button
                        type="button"
                        onclick="toggleNameEdit()"
                        class="px-5 py-1.5 rounded-full bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition">
                        変更
                    </button>
                </div>
                {{-- ②styleで制御することでTailwindのhidden問題を回避 --}}
                <div style="display:none;" class="mt-3 flex gap-2" id="nameEditArea">
                    <input
                        type="text"
                        id="nameInput"
                        placeholder="新しいユーザー名"
                        maxlength="20"
                        class="flex-1 px-4 py-2 rounded-full border border-slate-300 text-sm outline-none focus:border-rose-300 bg-white">
                    <button
                        type="button"
                        onclick="saveName()"
                        class="px-5 py-2 rounded-full bg-rose-300 text-white text-sm hover:bg-rose-400 transition">
                        保存
                    </button>
                </div>
            </div>

            <!-- メールアドレス・パスワード -->
            <div class="mb-12">
                <p class="text-sm text-slate-500 mb-2">メールアドレス・パスワード</p>
                <div class="flex justify-between items-center">
                    <span class="text-base font-medium text-slate-800 underline" id="emailDisplay">読み込み中…</span>
                </div>
                <div class="flex justify-end mt-3">
                    <button
                        type="button"
                        onclick="location.href='/pass'"
                        class="px-5 py-1.5 rounded-full bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition">
                        変更
                    </button>
                </div>
            </div>

            <!-- ログアウト -->
            <div class="flex justify-center">
                <button
                    type="button"
                    onclick="showLogoutModal()"
                    class="w-52 py-4 rounded-full bg-rose-400 text-white text-lg font-medium hover:bg-rose-500 transition tracking-wide">
                    ログアウト
                </button>
            </div>

        </div>

    </div>

    <div
        style="display:none;"
        class="fixed inset-0 bg-black bg-opacity-40 z-50 flex justify-center items-center"
        id="logoutModal"
        role="dialog"
        aria-modal="true"
        aria-label="ログアウト確認">
        <div class="bg-white rounded-2xl p-7 w-72 text-center shadow-xl">
            <p class="text-base text-slate-700 mb-6 leading-relaxed">本当にログアウトしますか？</p>
            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="executeLogout()"
                    class="flex-1 py-2.5 rounded-full bg-rose-400 text-white text-sm hover:bg-rose-500 transition">
                    はい
                </button>
                <button
                    type="button"
                    onclick="hideLogoutModal()"
                    class="flex-1 py-2.5 rounded-full bg-slate-200 text-slate-700 text-sm hover:bg-slate-300 transition">
                    いいえ
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="{{ asset('js/user.js') }}"></script>
</body>
</html>
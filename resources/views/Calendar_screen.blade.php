<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900 font-sans">
    <div class="min-h-screen flex flex-col items-center p-4 gap-4">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-rose-100 px-6 py-5">
                <h1 class="text-center text-2xl font-semibold text-slate-800">カレンダー</h1>
            </div>
            <div class="p-5">
                <div class="rounded-3xl border border-slate-200 overflow-hidden">
                    <div class="bg-slate-100 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500" id="monthDisplay">4月</p>
                            <p class="text-xl font-semibold text-slate-900" id="yearDisplay">2026</p>
                        </div>
                        <div class="flex gap-2">
                            <button id="prevBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">‹</button>
                            <button id="nextBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">›</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 gap-2 p-4 text-center" id="calendarGrid">
                        <span class="text-xs font-semibold uppercase text-slate-400">日</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">月</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">火</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">水</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">木</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">金</span>
                        <span class="text-xs font-semibold uppercase text-slate-400">土</span>
                    </div>
                </div>

                <div class="mt-6 grid gap-4">
                    {{-- ToDo欄 --}}
                    <div class="rounded-3xl border border-slate-200 p-4">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">ToDo</h2>
                        <div class="space-y-2 text-sm text-slate-700" id="todoList">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3 text-slate-400">
                                読み込み中…
                            </div>
                        </div>
                    </div>

                    {{-- 完了欄 --}}
                    <div class="rounded-3xl border border-slate-200 p-4 bg-slate-50">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">完了</h2>
                        <div class="space-y-2 text-sm" id="completedList">
                            <p class="text-sm text-slate-400">読み込み中…</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="w-full max-w-xl bg-white rounded-3xl shadow-inner border border-slate-200 px-5 py-4">
            <div class="flex justify-between items-center text-slate-600">
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">💬</span>
                    <span class="text-xs">ひとりごと</span>
                </button>
                <button class="flex flex-col items-center gap-1">
                    <span class="text-2xl">🏠</span>
                    <span class="text-xs">ホーム</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">📅</span>
                    <span class="text-xs">ToDo</span>
                </button>
                <button class="flex flex-col items-center gap-1">
                    <span class="text-2xl">⚙️</span>
                    <span class="text-xs">設定</span>
                </button>
            </div>
        </nav>
    </div>

    <script src="{{ asset('js/Calendar.js') }}"></script>
</body>
</html>
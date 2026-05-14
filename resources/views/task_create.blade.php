<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* 背景色を #fffacc に設定 */
        .custom-bg { background-color: #fffacc; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 flex justify-center items-center min-h-screen p-2 sm:p-4">
    @php
        use Carbon\Carbon;
        $targetDate = isset($date) ? Carbon::parse($date) : Carbon::now();
    @endphp

    <div class="w-full max-w-[450px] h-[92vh] max-h-[900px] flex flex-col gap-3 pb-[72px]">
        
        <div class="flex-1 custom-bg rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">
            {{-- ヘッダー --}}
            <div class="bg-rose-100 px-6 py-5 flex-shrink-0">
                <h1 class="text-center text-2xl font-semibold text-slate-800">カレンダー</h1>
            </div>

            {{-- コンテンツエリア --}}
            <div class="p-5 flex-1 overflow-y-auto hide-scrollbar">
                {{-- 月表示・ナビ --}}
                <div class="rounded-3xl border border-slate-200 overflow-hidden mb-6 bg-white">
                    <div class="bg-slate-100 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500" id="monthDisplay">{{ $targetDate->format('n') }}月</p>
                            <p class="text-xl font-semibold text-slate-900" id="yearDisplay">{{ $targetDate->format('Y') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button id="prevBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">‹</button>
                            <button id="nextBtn" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50">›</button>
                        </div>
                    </div>
                    {{-- カレンダー本体 --}}
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

                {{-- ToDoセクション --}}
                <div class="grid gap-4">
                    <div class="rounded-3xl border border-slate-200 p-4 bg-white">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">ToDo</h2>
                        <div class="space-y-2 text-sm text-slate-700" id="todoList">
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-3 text-slate-400">読み込み中…</div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-slate-200 p-4 bg-white/80">
                        <h2 class="text-lg font-semibold text-slate-900 mb-3">完了</h2>
                        <div class="space-y-2 text-sm" id="completedList">
                            <p class="text-sm text-slate-400">読み込み中…</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/calendar.js') }}"></script>

    {{-- ボトムナビ（フル幅・画面固定） --}}
    <nav class="fixed bottom-0 left-0 w-full z-50 border-t border-[#9ecfde]" style="background-color: #b5d9e4;">
        <div class="w-full max-w-[450px] mx-auto px-6 py-3 flex justify-between items-center text-slate-600">
            <a href="/chat" class="flex flex-col items-center gap-1 {{ request()->is('chat*') ? 'text-slate-900' : '' }}">
                <span class="text-xl">💬</span>
                <span class="text-[9px] font-bold {{ request()->is('chat*') ? 'underline decoration-2 underline-offset-4' : '' }}">ひとりごと</span>
            </a>
            <a href="/home" class="flex flex-col items-center gap-1 {{ request()->is('home*') ? 'text-slate-900' : '' }}">
                <span class="text-xl">🏠</span>
                <span class="text-[9px] font-bold {{ request()->is('home*') ? 'underline decoration-2 underline-offset-4' : '' }}">ホーム</span>
            </a>
            <a href="/calendar" class="flex flex-col items-center gap-1 {{ request()->is('calendar*') ? 'text-slate-900' : '' }}">
                <span class="text-xl">📅</span>
                <span class="text-[9px] font-bold {{ request()->is('calendar*') ? 'underline decoration-2 underline-offset-4' : '' }}">ToDo</span>
            </a>
            <a href="/setting" class="flex flex-col items-center gap-1 {{ request()->is('setting*') ? 'text-slate-900' : '' }}">
                <span class="text-xl">⚙️</span>
                <span class="text-[9px] font-bold {{ request()->is('setting*') ? 'underline decoration-2 underline-offset-4' : '' }}">設定</span>
            </a>
        </div>
    </nav>
</body>
</html>
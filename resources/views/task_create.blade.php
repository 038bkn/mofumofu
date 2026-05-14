<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
        input[type="date"], input[type="time"] { -webkit-appearance: none; appearance: none; }
        input:focus, textarea:focus { outline: none; }
        /* スクロールバー非表示 */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 flex justify-center items-center min-h-screen p-2 sm:p-4">
    @php
        use Carbon\Carbon;
        $dateObject = Carbon::parse($date);
    @endphp

    <div class="w-full max-w-[450px] h-[92vh] max-h-[900px] flex flex-col gap-3">
        
        <div class="flex-1 bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">

            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 flex-shrink-0">
                <a href="/day-schedule?date={{ $dateObject->format('Y-m-d') }}"
                   class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition text-slate-600 text-xl">←</a>
                <span class="text-lg font-bold text-slate-800">新規タスク</span>
                <button type="submit" form="taskForm" id="saveBtn" aria-label="保存"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-900 text-white shadow-sm hover:bg-slate-700 transition text-lg">✓</button>
            </div>

            <div class="flex-1 overflow-y-auto p-5 hide-scrollbar">
                <form id="taskForm" class="space-y-6 pb-4">
                    <input type="hidden" id="taskDate" value="{{ $dateObject->format('Y-m-d') }}">

                    <div class="space-y-2 border-b border-slate-100 pb-4">
                        <input type="text" id="taskTitle" placeholder="タイトル"
                               class="w-full text-lg font-semibold text-slate-800 placeholder-slate-300 bg-transparent border-none focus:ring-0 py-1">
                        <div class="flex items-center gap-2 text-slate-500">
                           
                            <input type="text" id="taskLocation" placeholder="場所またはビデオ通話"
                                   class="w-full text-sm placeholder-slate-300 bg-transparent border-none focus:ring-0 py-1">
                        </div>
                    </div>

                    <div class="space-y-4 border-b border-slate-100 pb-5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500">開始</span>
                            <div class="flex items-center gap-1.5">
                                <input type="date" id="startDate" value="{{ $dateObject->format('Y-m-d') }}"
                                       class="text-[12px] text-slate-700 bg-slate-100 rounded-lg px-2 py-1.5 border-none font-medium">
                                <input type="time" id="taskStart" value="10:00"
                                       class="text-[12px] font-bold text-rose-600 bg-rose-50 rounded-lg px-2 py-1.5 border-none">
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-500">終了</span>
                            <div class="flex items-center gap-1.5">
                                <input type="date" id="endDate" value="{{ $dateObject->format('Y-m-d') }}"
                                       class="text-[12px] text-slate-700 bg-slate-100 rounded-lg px-2 py-1.5 border-none font-medium">
                                <input type="time" id="taskEnd" value="11:00"
                                       class="text-[12px] font-bold text-rose-600 bg-rose-50 rounded-lg px-2 py-1.5 border-none">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                        <span class="text-sm font-medium text-slate-500">難易度</span>
                        <div class="flex gap-1" id="difficultyStars">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-star="{{ $i }}"
                                        class="star-btn text-2xl text-slate-200 hover:text-amber-400 transition">★</button>
                            @endfor
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-500 ml-1">メモ</label>
                        <textarea id="taskNote" placeholder="詳細を入力..." rows="5"
                                  class="w-full text-sm text-slate-700 placeholder-slate-300 bg-slate-50 rounded-2xl px-4 py-3 border border-slate-100 resize-none focus:ring-0"></textarea>
                    </div>
                </form>
            </div>
        </div>

        {{-- ボトムナビゲーション --}}
       {{-- ボトムナビゲーション --}}
       <nav class="w-full rounded-[2rem] shadow-lg border border-slate-200 px-6 py-3 flex-shrink-0" style="background-color: #b5d9e4;">
        <div class="flex justify-between items-center text-slate-600">
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
    </div>

    <script src="{{ asset('js/task_create.js') }}"></script>
</body>
</html>
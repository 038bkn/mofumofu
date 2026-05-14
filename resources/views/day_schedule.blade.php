<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
        /* スクロールバーのカスタマイズ（細く清潔感のあるデザイン） */
        #scheduleContainer::-webkit-scrollbar { width: 4px; }
        #scheduleContainer::-webkit-scrollbar-track { background: transparent; }
        #scheduleContainer::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 flex justify-center items-center min-h-screen p-2 sm:p-4">
    @php
        use Carbon\Carbon;
        $dateObject = Carbon::parse($date);
        $weekDays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekStart = $dateObject->copy()->startOfWeek();
        $weekDates = collect(range(0, 6))->map(fn($offset) => $weekStart->copy()->addDays($offset));
    @endphp

    <div class="w-full max-w-[450px] h-[92vh] max-h-[900px] flex flex-col gap-3">
        
        <div class="flex-1 bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col">

            {{-- ヘッダー：月選択と週カレンダー（ピンクから #fffacc に変更） --}}
            <div class="px-5 pt-5 pb-3 flex-shrink-0 border-b" style="background-color: #fffacc; border-color: #f5f0bb;">
                <div class="flex items-center justify-between mb-4">
                    <a href="/calendar" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white border border-slate-200 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <span class="text-xs">←</span>
                        <span>{{ $dateObject->format('n') }}月</span>
                    </a>
                    <a href="/task/create?date={{ $dateObject->format('Y-m-d') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-900 text-white text-xl shadow-md hover:bg-slate-700 transition">＋</a>
                </div>

                {{-- 週カレンダー（横スクロール対応） --}}
                <div class="bg-white rounded-2xl p-1.5 border border-slate-100 shadow-sm">
                    <div class="flex justify-between gap-1">
                        @foreach ($weekDates as $weekDate)
                            <a href="/day-schedule?date={{ $weekDate->format('Y-m-d') }}"
                               class="flex-1 text-center rounded-xl py-2 transition {{ $weekDate->isSameDay($dateObject) ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:bg-slate-50' }}">
                                <div class="text-[10px] mb-0.5 leading-none">{{ $weekDays[$weekDate->dayOfWeek] }}</div>
                                <div class="text-sm font-bold">{{ $weekDate->day }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <p class="text-[11px] text-slate-400 tracking-wide font-medium">{{ $dateObject->format('Y年n月j日') }}・{{ $weekDays[$dateObject->dayOfWeek] }}曜日</p>
                </div>
            </div>

            {{-- 24時間タイムラインエリア --}}
            <div id="scheduleContainer" class="flex-1 overflow-y-auto">
                <div class="px-4 py-2" id="timelineWrapper">
                    @foreach (range(0, 23) as $hour)
                        <div class="timeline-row flex gap-4 items-stretch border-b border-slate-100" data-hour="{{ $hour }}">
                            <div class="w-10 text-right text-[10px] text-slate-300 pt-3 flex-shrink-0 font-mono">
                                {{ sprintf('%02d:00', $hour) }}
                            </div>
                            <div class="flex-1 py-2 min-h-[64px] task-slot relative">
                                {{-- タスクはJSで動的に追加 --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

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

    <script>
        window.scheduleDate = "{{ $dateObject->format('Y-m-d') }}";
    </script>
    <script src="{{ asset('js/day_schedule.js') }}"></script>
</body>
</html>
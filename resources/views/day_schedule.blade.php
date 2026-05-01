<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif; }
        #scheduleContainer::-webkit-scrollbar { width: 4px; }
        #scheduleContainer::-webkit-scrollbar-track { background: transparent; }
        #scheduleContainer::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900">
    @php
        use Carbon\Carbon;
        $dateObject = Carbon::parse($date);
        $weekDays = ['日', '月', '火', '水', '木', '金', '土'];
        $weekStart = $dateObject->copy()->startOfWeek();
        $weekDates = collect(range(0, 6))->map(fn($offset) => $weekStart->copy()->addDays($offset));
    @endphp

    <div class="min-h-screen flex flex-col items-center p-4 gap-4">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- ヘッダー --}}
            <div class="bg-rose-50 px-5 py-4">
                <div class="flex items-center justify-between mb-3">
                    <a href="/calendar" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                        <span class="text-xs">←</span>
                        <span>{{ $dateObject->format('n') }}月</span>
                    </a>
                    <a href="/task/create?date={{ $dateObject->format('Y-m-d') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-900 text-white text-xl shadow-md hover:bg-slate-700 transition">＋</a>
                </div>

                {{-- 週カレンダー --}}
                <div class="overflow-x-auto">
                    <div class="inline-flex gap-1 bg-white rounded-2xl p-1.5 border border-slate-100 shadow-sm w-full justify-between">
                        @foreach ($weekDates as $weekDate)
                            <a href="/day-schedule?date={{ $weekDate->format('Y-m-d') }}"
                               class="flex-1 text-center rounded-xl px-1 py-2 transition {{ $weekDate->isSameDay($dateObject) ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:bg-slate-50' }}">
                                <div class="text-xs mb-0.5">{{ $weekDays[$weekDate->dayOfWeek] }}</div>
                                <div class="text-sm font-bold">{{ $weekDate->day }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <p class="text-xs text-slate-400 tracking-wide">{{ $dateObject->format('Y年n月j日') }}・{{ $weekDays[$dateObject->dayOfWeek] }}曜日</p>
                </div>
            </div>

            {{-- 24時間タイムライン --}}
            <div id="scheduleContainer" class="overflow-y-auto" style="height: 520px;">
                <div class="px-4 py-2" id="timelineWrapper">
                    @foreach (range(0, 23) as $hour)
                        <div class="timeline-row flex gap-3 items-start border-b border-slate-100" data-hour="{{ $hour }}">
                            <div class="w-12 text-right text-xs text-slate-300 pt-3 flex-shrink-0 select-none">
                                {{ sprintf('%02d:00', $hour) }}
                            </div>
                            <div class="flex-1 py-2 min-h-[52px] task-slot">
                                {{-- タスクはJSで動的に追加 --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ボトムナビ --}}
        <nav class="w-full max-w-xl bg-white rounded-3xl shadow border border-slate-200 px-6 py-3">
            <div class="flex justify-between items-center">
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">💬</span>
                    <span class="text-xs">ひとりごと</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">🏠</span>
                    <span class="text-xs">ホーム</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-900">
                    <span class="text-2xl">📅</span>
                    <span class="text-xs font-semibold">ToDo</span>
                </button>
                <button class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600 transition">
                    <span class="text-2xl">⚙️</span>
                    <span class="text-xs">設定</span>
                </button>
            </div>
        </nav>
    </div>

    <script>
        window.scheduleDate = "{{ $dateObject->format('Y-m-d') }}";
    </script>
    <script src="{{ asset('js/day_schedule.js') }}"></script>
</body>
</html>
{{-- day_schedule.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>スケジュール</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif;
            /* ブラウザのツールバーによるガタつきを防止 */
            height: 100vh;
            height: -webkit-fill-available;
        }
        html {
            height: -webkit-fill-available;
        }
        #scheduleContainer::-webkit-scrollbar { width: 4px; }
        #scheduleContainer::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-white text-slate-900 overflow-hidden m-0 p-0">

@php
    use Carbon\Carbon;
    $dateObject = isset($date) ? Carbon::parse($date) : Carbon::now();
    $weekDays = ['日', '月', '火', '水', '木', '金', '土'];
    $weekStart = $dateObject->copy()->startOfWeek();
    $weekDates = collect(range(0, 6))->map(fn($offset) => $weekStart->copy()->addDays($offset));
@endphp

{{-- 画面全体を100%使うコンテナ --}}
<div class="flex flex-col h-screen w-full overflow-hidden">

    {{-- メインエリア：max-wを外してw-fullにし、パディングを完全に除去 --}}
    <div class="flex-1 flex flex-col min-h-0 w-full bg-white">
        
        {{-- ヘッダー：背景色を左右端まで満たす。roundedを削除。 --}}
        <div class="px-4 pt-4 pb-3 flex-shrink-0 border-b" style="background-color: #fffacc; border-color: #f5f0bb;">
            <div class="flex items-center justify-between mb-4">
                <a href="/calendar" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    <span>← {{ $dateObject->format('n') }}月</span>
                </a>
                <a href="/task/create?date={{ $dateObject->format('Y-m-d') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-900 text-white text-xl shadow-md hover:bg-slate-700 transition">＋</a>
            </div>

            {{-- 週間カレンダー --}}
            <div class="bg-white rounded-2xl p-1.5 border border-slate-100 shadow-sm">
                <div class="grid grid-cols-7 gap-1">
                    @foreach ($weekDates as $weekDate)
                        <a href="/day-schedule?date={{ $weekDate->format('Y-m-d') }}"
                            class="text-center rounded-xl py-2 transition {{ $weekDate->isSameDay($dateObject) ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:bg-slate-50' }}">
                            <div class="text-[10px] mb-0.5">{{ $weekDays[$weekDate->dayOfWeek] }}</div>
                            <div class="text-sm font-bold">{{ $weekDate->day }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- タイムライン：左右に少し余白（px-4）を持たせつつ背景は白 --}}
        <div id="scheduleContainer" class="flex-1 overflow-y-auto bg-white px-4">
            {{-- day_schedule.js で中身（timeline-row）が生成されます --}}
        </div>
    </div>

    {{-- ナビゲーション：画面最下部に隙間なく固定 --}}
    <nav class="fixed bottom-0 left-0 w-full h-[68px] bg-[#cdeef9] border-t border-[#b5d9e4] z-20">
        <div class="w-full max-w-[390px] mx-auto h-full flex justify-around items-center">
            <a href="/chat" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/chat.png') }}" class="w-16 h-16 object-contain">
            </a>
            <a href="/home" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/home.png') }}" class="w-16 h-16 object-contain">
            </a>
            <a href="/calendar" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/todo.png') }}" class="w-16 h-16 object-contain">
            </a>
            <a href="/setting" class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/icon/setting.png') }}" class="w-16 h-16 object-contain">
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
<!DOCTYPE html>
<html lang="ja">
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <title>カレンダー</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-bg {
            background-color: #fffacc;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-900 overflow-hidden m-0 p-0">

@php
    use Carbon\Carbon;

    $targetDate = isset($date)
        ? Carbon::parse($date)
        : Carbon::now();
@endphp

<div class="w-screen h-screen flex flex-col overflow-hidden">

    {{-- メイン --}}
    <div class="flex-1 custom-bg overflow-hidden flex flex-col min-h-0 rounded-none">

        {{-- ヘッダー --}}
        <div class="bg-rose-100 px-6 sm:px-8 py-6 flex-shrink-0 flex items-center justify-between">

            <h1 class="text-3xl sm:text-4xl font-bold text-slate-800">
                カレンダー
            </h1>

            <a
                href="/task/create?date={{ $targetDate->format('Y-m-d') }} "
                class="w-14 h-14 sm:w-16 sm:h-16 bg-slate-800 text-white rounded-full flex items-center justify-center text-3xl shadow-lg hover:bg-slate-700 transition-colors"
            >
                ＋
            </a>

        </div>

        {{-- コンテンツ --}}
        <div class="px-2 sm:px-4 py-4 pb-[120px] flex-1 overflow-y-auto hide-scrollbar min-h-0">

            {{-- 月表示 --}}
            <div class="rounded-[2.5rem] border border-slate-200 overflow-hidden mb-10 bg-white shadow-sm">

                <div class="bg-slate-100 px-6 sm:px-8 py-6 border-b border-slate-200 flex items-center justify-between">

                    <div>

                        <p class="text-lg sm:text-xl text-slate-500" id="monthDisplay">
                            {{ $targetDate->format('n') }}月
                        </p>

                        <p class="text-3xl sm:text-5xl font-bold text-slate-900 leading-none mt-1" id="yearDisplay">
                            {{ $targetDate->format('Y') }}
                        </p>

                    </div>

                    <div class="flex gap-4">

                        <button
                            id="prevBtn"
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-3xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-3xl shadow-sm"
                        >
                            ‹
                        </button>

                        <button
                            id="nextBtn"
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-3xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-3xl shadow-sm"
                        >
                            ›
                        </button>

                    </div>

                </div>

                {{-- カレンダー --}}
                <div
                    class="grid grid-cols-7 gap-3 sm:gap-4 p-5 sm:p-8 text-center"
                    id="calendarGrid"
                >

                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">日</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">月</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">火</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">水</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">木</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">金</span>
                    <span class="text-sm sm:text-base font-bold uppercase text-slate-400">土</span>

                </div>

            </div>

            {{-- ToDo & 完了 --}}
            <div class="flex flex-col gap-10">

                {{-- ToDo --}}
                <div class="rounded-[2rem] border border-slate-200 p-6 sm:p-8 bg-white">

                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-5">
                        ToDo
                    </h2>

                    <div
                        class="space-y-4 text-base sm:text-lg text-slate-700"
                        id="todoList"
                    >

                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5 text-slate-400">

                            読み込み中…

                        </div>

                    </div>

                </div>

                {{-- 完了 --}}
                <div class="rounded-[2rem] border border-slate-200 p-6 sm:p-8 bg-white">

                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-5">
                        完了
                    </h2>

                    <div
                        class="space-y-4 text-base sm:text-lg"
                        id="completedList"
                    >

                        <p class="text-base text-slate-400">
                            読み込み中…
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ボトムナビ --}}
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

<script src="{{ asset('js/calendar.js') }}"></script>

</body>
</html>
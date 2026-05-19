{{-- task_detail.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>タスク詳細</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Hiragino Sans', 'Hiragino Kino Gothic ProN', 'Noto Sans JP', sans-serif;
            height: 100vh;
            height: -webkit-fill-available;
        }
        html { height: -webkit-fill-available; }
    </style>
</head>
<body class="bg-white text-slate-900 m-0 p-0 overflow-hidden">
    @php
        $taskId = request('id');
        $taskDate = request('date', date('Y-m-d'));
    @endphp

    <div class="w-full h-screen flex flex-col bg-slate-50 overflow-hidden">
        {{-- ヘッダー --}}
        <div class="flex items-center justify-between px-5 py-4 bg-white border-b border-slate-100 flex-shrink-0">
        <a href="#" class="text-xl p-2 -ml-2 text-slate-400" onclick="history.back(); return false;">←</a>
            <span class="font-bold text-lg text-slate-700">タスク詳細</span>
            <div class="w-8"></div>
        </div>

        {{-- メインコンテンツ --}}
        <div class="flex-1 overflow-y-auto px-6 py-8">
            {{-- IDを detail.js と一致させています --}}
            <div id="taskContent" class="space-y-6">
                <p class="text-center text-slate-400">読み込み中...</p>
            </div>

            <div class="flex flex-col gap-3 justify-center mt-10 mb-6">
                <button id="editBtn"
                    class="bg-[#b8e0e9] text-slate-700 font-bold px-12 py-3 rounded-full shadow-sm hover:opacity-90 transition">
                    編集する
                </button>

                <button id="deleteBtn"
                    class="bg-white text-rose-500 font-bold px-12 py-3 rounded-full shadow-sm border border-rose-100 hover:bg-rose-50 transition">
                    予定を削除する
                </button>
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

    {{-- JSに必要な値を渡す --}}
    <script>
        window.taskId = "{{ $taskId }}";
        window.scheduleDate = "{{ $taskDate }}";
    </script>
    <script src="{{ asset('js/detail.js') }}"></script>
</body>
</html>
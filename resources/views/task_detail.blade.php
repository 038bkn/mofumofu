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
            <a href="/day-schedule?date={{ $taskDate }}" class="text-xl p-2 -ml-2 text-slate-400">←</a>
            <span class="font-bold text-lg text-slate-700">タスク詳細</span>
            <div class="w-8"></div>
        </div>

        {{-- メインコンテンツ --}}
        <div class="flex-1 overflow-y-auto px-6 py-8">
            {{-- IDを detail.js と一致させています --}}
            <div id="taskContent" class="space-y-6">
                <p class="text-center text-slate-400">読み込み中...</p>
            </div>

            <div class="flex justify-center mt-10 mb-6">
                <button id="deleteBtn" class="bg-white text-rose-500 font-bold px-12 py-3 rounded-full shadow-sm border border-rose-100 hover:bg-rose-50 transition">
                    予定を削除する
                </button>
            </div>
        </div>

        {{-- ボトムナビ --}}
        <nav class="w-full flex justify-center items-center text-slate-600 flex-shrink-0 border-t border-[#9ecfde]" style="background-color: #b8e0e9; height: 80px;">
            <div class="w-full max-w-2xl px-6 flex justify-between items-center">
                <a href="/chat" class="flex flex-col items-center gap-1"><span>💬</span><span class="text-[10px] font-bold">ひとりごと</span></a>
                <a href="/home" class="flex flex-col items-center gap-1"><span>🏠</span><span class="text-[10px] font-bold">ホーム</span></a>
                <a href="/calendar" class="flex flex-col items-center gap-1 text-slate-900"><span>🗓️</span><span class="text-[10px] font-bold border-b-2 border-slate-900">ToDo</span></a>
                <a href="/setting" class="flex flex-col items-center gap-1"><span>⚙️</span><span class="text-[10px] font-bold">設定</span></a>
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